<?php
/**
 * ADW — GitHub Self-Updater (dependency-free)
 *
 * Makes every site receive ADW updates straight from a GitHub repo's Releases,
 * shown in the normal WP Dashboard → Updates screen (and one-click "Update").
 *
 * INERT until configured: it does NOTHING unless ADW_GH_REPO is defined and
 * non-empty (set in the main plugin file / wp-config). For a PRIVATE repo,
 * also define ADW_GH_TOKEN with a fine-grained, read-only token.
 *
 * Release flow (per update you ship):
 *   1. Bump the "Version:" header in arenex-digital-widgets.php.
 *   2. git commit + push.
 *   3. Create a GitHub Release whose TAG is the version (e.g. 5.0.4 or v5.0.4).
 *      Attach the built plugin ZIP as a release asset (recommended — gives the
 *      cleanest folder name on install). Public repos can also just use the
 *      auto "Source code (zip)"; this class renames the folder correctly.
 *
 * Test on LocalWP first before enabling on client sites.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class ADW_GitHub_Updater {

	private $file;            // plugin main file (ADW_FILE)
	private $slug;            // plugin folder name, e.g. arenex-digital-widgets
	private $basename;        // arenex-digital-widgets/arenex-digital-widgets.php
	private $owner_repo;      // "owner/repo"
	private $token;           // optional GitHub token (private repos)
	private $cache_key;
	private $current_version;

	public function __construct( $file, $owner_repo, $token = '' ) {
		$this->file       = $file;
		$this->owner_repo = trim( (string) $owner_repo, '/' );
		$this->token      = (string) $token;
		$this->basename   = plugin_basename( $file );
		$this->slug       = dirname( $this->basename );
		$this->cache_key  = 'adw_gh_update_' . md5( $this->owner_repo );

		add_filter( 'pre_set_site_transient_update_plugins', [ $this, 'check_update' ] );
		add_filter( 'plugins_api', [ $this, 'plugin_info' ], 20, 3 );
		add_filter( 'upgrader_source_selection', [ $this, 'fix_source_dir' ], 10, 4 );
		add_filter( 'http_request_args', [ $this, 'maybe_auth_download' ], 10, 2 );
		// Let admins force a re-check from Plugins screen without waiting for cache.
		add_action( 'upgrader_process_complete', [ $this, 'flush_cache' ], 10, 0 );
	}

	/** Fetch the latest GitHub release (cached to respect API rate limits). */
	private function get_remote() {
		$cached = get_transient( $this->cache_key );
		if ( false !== $cached ) {
			return $cached ?: null;
		}
		$url  = "https://api.github.com/repos/{$this->owner_repo}/releases/latest";
		$args = [
			'timeout' => 15,
			'headers' => [
				'Accept'     => 'application/vnd.github+json',
				'User-Agent' => 'ADW-Updater',
			],
		];
		if ( $this->token ) {
			$args['headers']['Authorization'] = 'Bearer ' . $this->token;
		}
		$res = wp_remote_get( $url, $args );
		if ( is_wp_error( $res ) || 200 !== (int) wp_remote_retrieve_response_code( $res ) ) {
			set_transient( $this->cache_key, '', 30 * MINUTE_IN_SECONDS ); // brief negative cache
			return null;
		}
		$data = json_decode( wp_remote_retrieve_body( $res ) );
		if ( empty( $data ) || empty( $data->tag_name ) ) {
			set_transient( $this->cache_key, '', 30 * MINUTE_IN_SECONDS );
			return null;
		}
		set_transient( $this->cache_key, $data, 6 * HOUR_IN_SECONDS );
		return $data;
	}

	public function flush_cache() {
		delete_transient( $this->cache_key );
	}

	private function remote_version( $data ) {
		return ltrim( (string) $data->tag_name, 'vV' );
	}

	/** Choose the best package URL. */
	private function package_url( $data ) {
		// Private repo (token set): the zipball works with Bearer auth via codeload.
		if ( $this->token && ! empty( $data->zipball_url ) ) {
			return $data->zipball_url;
		}
		// Public repo: prefer an attached .zip asset (correct folder name), else zipball.
		if ( ! empty( $data->assets ) && is_array( $data->assets ) ) {
			foreach ( $data->assets as $asset ) {
				if ( ! empty( $asset->browser_download_url ) && '.zip' === substr( $asset->name, -4 ) ) {
					return $asset->browser_download_url;
				}
			}
		}
		return ! empty( $data->zipball_url ) ? $data->zipball_url : '';
	}

	private function installed_version() {
		if ( $this->current_version ) {
			return $this->current_version;
		}
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$d = get_plugin_data( $this->file, false, false );
		$this->current_version = $d['Version'] ?? '0';
		return $this->current_version;
	}

	/** Inject an available update into the plugins transient. */
	public function check_update( $transient ) {
		if ( empty( $transient->checked ) ) {
			return $transient;
		}
		$data = $this->get_remote();
		if ( ! $data ) {
			return $transient;
		}
		$remote  = $this->remote_version( $data );
		$package = $this->package_url( $data );
		if ( $package && version_compare( $remote, $this->installed_version(), '>' ) ) {
			$transient->response[ $this->basename ] = (object) [
				'slug'        => $this->slug,
				'plugin'      => $this->basename,
				'new_version' => $remote,
				'url'         => "https://github.com/{$this->owner_repo}",
				'package'     => $package,
				'tested'      => get_bloginfo( 'version' ),
			];
		} else {
			// Make sure WP shows "up to date" rather than a stale entry.
			unset( $transient->response[ $this->basename ] );
		}
		return $transient;
	}

	/** Populate the "View details" modal. */
	public function plugin_info( $result, $action, $args ) {
		if ( 'plugin_information' !== $action ) {
			return $result;
		}
		if ( empty( $args->slug ) || $args->slug !== $this->slug ) {
			return $result;
		}
		$data = $this->get_remote();
		if ( ! $data ) {
			return $result;
		}
		return (object) [
			'name'          => 'Arenex Digital Widgets',
			'slug'          => $this->slug,
			'version'       => $this->remote_version( $data ),
			'author'        => 'Arenex Digital',
			'homepage'      => "https://github.com/{$this->owner_repo}",
			'download_link' => $this->package_url( $data ),
			'sections'      => [
				'changelog' => ! empty( $data->body ) ? wpautop( esc_html( $data->body ) ) : 'See the GitHub releases page.',
			],
		];
	}

	/**
	 * GitHub zipballs extract to "owner-repo-<hash>/"; WordPress would install
	 * that as a brand-new plugin folder. Rename it to the real plugin slug so
	 * the update replaces the existing plugin in place.
	 */
	public function fix_source_dir( $source, $remote_source, $upgrader, $hook_extra = [] ) {
		if ( empty( $hook_extra['plugin'] ) || $hook_extra['plugin'] !== $this->basename ) {
			return $source;
		}
		global $wp_filesystem;
		$desired = trailingslashit( $remote_source ) . $this->slug;
		if ( trailingslashit( $source ) === trailingslashit( $desired ) ) {
			return $source; // already correct (release asset zip)
		}
		if ( $wp_filesystem && $wp_filesystem->move( $source, $desired, true ) ) {
			return trailingslashit( $desired );
		}
		return $source;
	}

	/** Attach the token when WP downloads the package from GitHub (private repos). */
	public function maybe_auth_download( $args, $url ) {
		if ( ! $this->token ) {
			return $args;
		}
		$is_github = ( false !== strpos( $url, 'codeload.github.com' ) )
			|| ( false !== strpos( $url, 'api.github.com/repos/' . $this->owner_repo ) )
			|| ( false !== strpos( $url, 'github.com/' . $this->owner_repo ) );
		if ( $is_github ) {
			$args['headers'] = isset( $args['headers'] ) && is_array( $args['headers'] ) ? $args['headers'] : [];
			$args['headers']['Authorization'] = 'Bearer ' . $this->token;
		}
		return $args;
	}
}
