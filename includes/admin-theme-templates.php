<?php
/**
 * Arenex Theme Templates — Admin page + global header/footer renderer
 *
 * Lets users assign saved Elementor templates as the global Site Header
 * and Site Footer without needing Elementor Pro Theme Builder or any
 * third-party header/footer plugin (which usually bring extra widgets
 * with them, bloating the panel).
 *
 * What it adds to the panel:
 *   - 1 admin page under "Arenex Digital → Theme Templates"
 *   - 0 new Elementor widgets
 *
 * Front-end mechanism:
 *   - wp_body_open hook → render assigned header template
 *   - wp_footer hook    → render assigned footer template
 *   - Auto-defers if Elementor Pro Theme Builder is rendering the same role
 *
 * Options used:
 *   - adw_header_template_id  (int)  template post ID for global header
 *   - adw_footer_template_id  (int)  template post ID for global footer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ──────────────────────────────────────────────────────────────
 * Constants
 * ────────────────────────────────────────────────────────────── */
const ADW_TT_OPT_HEADER = 'adw_header_template_id';
const ADW_TT_OPT_FOOTER = 'adw_footer_template_id';
const ADW_TT_PARENT     = 'arenex-digital';
const ADW_TT_SLUG       = 'arenex-theme-templates';

/* ──────────────────────────────────────────────────────────────
 * Submenu registration (lives next to Master Kits)
 * ────────────────────────────────────────────────────────────── */
add_action( 'admin_menu', function () {
	add_submenu_page(
		ADW_TT_PARENT,
		__( 'Theme Templates', 'arenex-digital-widgets' ),
		__( 'Theme Templates', 'arenex-digital-widgets' ),
		'manage_options',
		ADW_TT_SLUG,
		'adw_tt_render_page'
	);
}, 11 );

/* ──────────────────────────────────────────────────────────────
 * Admin assets (only on this page)
 * ────────────────────────────────────────────────────────────── */
add_action( 'admin_enqueue_scripts', function ( $hook ) {
	if ( strpos( $hook, ADW_TT_SLUG ) === false ) {
		return;
	}
	wp_enqueue_style( 'adw-tt-admin', false );
	wp_add_inline_style( 'adw-tt-admin', adw_tt_admin_css() );
} );

/* ──────────────────────────────────────────────────────────────
 * Form actions: create / replace / clear template assignment
 * Single dispatcher for admin-post.php
 * ────────────────────────────────────────────────────────────── */
add_action( 'admin_post_adw_tt_action', 'adw_tt_handle_action' );

function adw_tt_handle_action() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'Insufficient permissions.', 'arenex-digital-widgets' ) );
	}
	check_admin_referer( 'adw_tt_action' );

	$role   = isset( $_POST['role'] ) ? sanitize_key( $_POST['role'] ) : '';
	$action = isset( $_POST['adw_tt_op'] ) ? sanitize_key( $_POST['adw_tt_op'] ) : '';

	if ( ! in_array( $role, [ 'header', 'footer' ], true ) ) {
		wp_safe_redirect( adw_tt_admin_url() );
		exit;
	}
	$option_key = $role === 'header' ? ADW_TT_OPT_HEADER : ADW_TT_OPT_FOOTER;

	switch ( $action ) {

		case 'create':
			$tpl_id = adw_tt_create_blank_template( $role );
			if ( $tpl_id ) {
				update_option( $option_key, (int) $tpl_id );
				$editor_url = add_query_arg(
					[ 'post' => $tpl_id, 'action' => 'elementor' ],
					admin_url( 'post.php' )
				);
				wp_safe_redirect( $editor_url );
				exit;
			}
			wp_safe_redirect( add_query_arg( 'adw_tt_msg', 'create_failed', adw_tt_admin_url() ) );
			exit;

		case 'replace':
			$new_id = isset( $_POST['template_id'] ) ? (int) $_POST['template_id'] : 0;
			if ( $new_id > 0 && get_post( $new_id ) ) {
				update_option( $option_key, $new_id );
			} elseif ( $new_id === 0 ) {
				delete_option( $option_key );
			}
			wp_safe_redirect( add_query_arg( 'adw_tt_msg', 'saved', adw_tt_admin_url() ) );
			exit;

		case 'clear':
			delete_option( $option_key );
			wp_safe_redirect( add_query_arg( 'adw_tt_msg', 'cleared', adw_tt_admin_url() ) );
			exit;
	}

	wp_safe_redirect( adw_tt_admin_url() );
	exit;
}

/* ──────────────────────────────────────────────────────────────
 * Helpers
 * ────────────────────────────────────────────────────────────── */
function adw_tt_admin_url() {
	return admin_url( 'admin.php?page=' . ADW_TT_SLUG );
}

/**
 * Create a blank Elementor template (CPT: elementor_library) seeded
 * with the matching Arenex widget so the user gets a one-click start.
 *
 * Template "type" stays as 'page' (the safest, most universally
 * supported value across Elementor versions).
 */
function adw_tt_create_blank_template( $role ) {
	$post_id = wp_insert_post( [
		'post_title'  => $role === 'header'
			? __( 'Site Header', 'arenex-digital-widgets' )
			: __( 'Site Footer', 'arenex-digital-widgets' ),
		'post_type'   => 'elementor_library',
		'post_status' => 'publish',
		'meta_input'  => [
			'_elementor_edit_mode'    => 'builder',
			'_elementor_template_type' => 'page',
			'_elementor_data'          => wp_slash( wp_json_encode( adw_tt_seed_data( $role ) ) ),
			'_elementor_version'       => defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '3.0.0',
		],
	], true );
	return is_wp_error( $post_id ) ? 0 : $post_id;
}

/**
 * Default Elementor data structure for a freshly-created template.
 * Pre-populates a single section containing the cmp_site_header
 * (or cmp_site_footer) widget so the user only has to edit, not assemble.
 */
function adw_tt_seed_data( $role ) {
	$widget_type = $role === 'header' ? 'cmp_site_header' : 'cmp_site_footer';
	$rand_id     = function () { return substr( md5( uniqid( '', true ) ), 0, 7 ); };

	return [
		[
			'id'       => $rand_id(),
			'elType'   => 'section',
			'settings' => [
				'layout'        => 'full_width',
				'content_width' => [ 'unit' => '%', 'size' => 100 ],
				'gap'           => 'no',
			],
			'elements' => [
				[
					'id'       => $rand_id(),
					'elType'   => 'column',
					'settings' => [ '_column_size' => 100 ],
					'elements' => [
						[
							'id'         => $rand_id(),
							'elType'     => 'widget',
							'widgetType' => $widget_type,
							'settings'   => [],
						],
					],
				],
			],
		],
	];
}

/**
 * Detect whether Elementor Pro Theme Builder has a header/footer
 * conditioned for the current request. If yes, our hooks defer.
 *
 * Uses Pro's location manager when available; falls back to a
 * conservative "if Pro is active, assume Pro handles it" so we don't
 * double-render. Users can override via the admin page if they want
 * us to render anyway alongside Pro (advanced use case).
 */
function adw_tt_pro_handles( $location ) {
	if ( ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
		return false;
	}
	// Try the precise Pro API first.
	if ( class_exists( '\ElementorPro\Modules\ThemeBuilder\Module' ) ) {
		try {
			$module       = \ElementorPro\Modules\ThemeBuilder\Module::instance();
			$location_mgr = $module->get_locations_manager();
			if ( $location_mgr && method_exists( $location_mgr, 'get_documents_for_location' ) ) {
				$docs = $location_mgr->get_documents_for_location( $location );
				if ( ! empty( $docs ) ) {
					return true;
				}
			}
		} catch ( \Throwable $e ) {
			// Fall through to conservative default.
		}
	}
	// Conservative default: Pro is active → trust Pro. User can opt our
	// hook back in via filter `adw_tt_force_render_when_pro_active`.
	return ! apply_filters( 'adw_tt_force_render_when_pro_active', false, $location );
}

/* ──────────────────────────────────────────────────────────────
 * Front-end render hooks
 * ────────────────────────────────────────────────────────────── */
add_action( 'wp_body_open', function () {
	$tpl_id = (int) get_option( ADW_TT_OPT_HEADER );
	if ( ! $tpl_id || ! get_post( $tpl_id ) ) {
		return;
	}
	if ( adw_tt_pro_handles( 'header' ) ) {
		return;
	}
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}
	echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $tpl_id, false );
}, 5 );

add_action( 'wp_footer', function () {
	$tpl_id = (int) get_option( ADW_TT_OPT_FOOTER );
	if ( ! $tpl_id || ! get_post( $tpl_id ) ) {
		return;
	}
	if ( adw_tt_pro_handles( 'footer' ) ) {
		return;
	}
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}
	echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $tpl_id, false );
}, 5 );

/* ──────────────────────────────────────────────────────────────
 * Admin page renderer
 * ────────────────────────────────────────────────────────────── */
function adw_tt_render_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$msg = isset( $_GET['adw_tt_msg'] ) ? sanitize_key( $_GET['adw_tt_msg'] ) : '';
	$header_id = (int) get_option( ADW_TT_OPT_HEADER );
	$footer_id = (int) get_option( ADW_TT_OPT_FOOTER );
	$header    = $header_id ? get_post( $header_id ) : null;
	$footer    = $footer_id ? get_post( $footer_id ) : null;

	$pro_active   = defined( 'ELEMENTOR_PRO_VERSION' );
	$pro_header   = $pro_active && adw_tt_pro_handles( 'header' );
	$pro_footer   = $pro_active && adw_tt_pro_handles( 'footer' );
	?>
	<div class="wrap adw-tt-wrap">
		<div class="adw-tt-header">
			<h1><?php esc_html_e( 'Theme Templates', 'arenex-digital-widgets' ); ?></h1>
			<p class="adw-tt-lede">
				<?php esc_html_e( 'Assign saved Elementor templates as your site\'s global header and footer. No third-party plugin required, no extra widgets added to the panel.', 'arenex-digital-widgets' ); ?>
			</p>
		</div>

		<?php if ( $msg ) : ?>
			<div class="notice notice-<?php echo $msg === 'create_failed' ? 'error' : 'success'; ?> is-dismissible">
				<p>
					<?php
					switch ( $msg ) {
						case 'saved':         esc_html_e( 'Template assignment saved.', 'arenex-digital-widgets' ); break;
						case 'cleared':       esc_html_e( 'Template assignment cleared.', 'arenex-digital-widgets' ); break;
						case 'create_failed': esc_html_e( 'Failed to create template. Check your user permissions.', 'arenex-digital-widgets' ); break;
					}
					?>
				</p>
			</div>
		<?php endif; ?>

		<?php if ( $pro_active ) : ?>
			<div class="notice notice-info">
				<p>
					<strong><?php esc_html_e( 'Elementor Pro detected.', 'arenex-digital-widgets' ); ?></strong>
					<?php esc_html_e( 'When Pro Theme Builder has a header or footer location active, this plugin defers to Pro automatically. You can still assign a fallback below.', 'arenex-digital-widgets' ); ?>
				</p>
			</div>
		<?php endif; ?>

		<div class="adw-tt-grid">
			<?php
			adw_tt_render_card( 'header', $header, $pro_header );
			adw_tt_render_card( 'footer', $footer, $pro_footer );
			?>
		</div>

		<div class="adw-tt-howto">
			<h2><?php esc_html_e( 'How it works', 'arenex-digital-widgets' ); ?></h2>
			<ol>
				<li><?php esc_html_e( 'Click "Create Header" / "Create Footer" — we make a blank Elementor template seeded with the right Arenex widget.', 'arenex-digital-widgets' ); ?></li>
				<li><?php esc_html_e( 'Edit it in the Elementor editor like any normal template.', 'arenex-digital-widgets' ); ?></li>
				<li><?php esc_html_e( 'Save. The template is rendered on every page automatically.', 'arenex-digital-widgets' ); ?></li>
				<li><?php esc_html_e( 'Use "Replace" to switch to a different saved template, or "Clear" to remove the assignment.', 'arenex-digital-widgets' ); ?></li>
			</ol>
		</div>
	</div>
	<?php
}

/**
 * Render one role card (Header or Footer).
 */
function adw_tt_render_card( $role, $post, $pro_overriding ) {
	$is_header   = $role === 'header';
	$label       = $is_header ? __( 'Site Header', 'arenex-digital-widgets' ) : __( 'Site Footer', 'arenex-digital-widgets' );
	$has_tpl     = (bool) $post;
	$edit_url    = $has_tpl
		? add_query_arg( [ 'post' => $post->ID, 'action' => 'elementor' ], admin_url( 'post.php' ) )
		: '';
	$action_url  = admin_url( 'admin-post.php' );
	$status_text = $pro_overriding
		? __( '⚠ Pro Theme Builder is rendering — this fallback is inactive.', 'arenex-digital-widgets' )
		: ( $has_tpl
			? __( '🟢 Live on every page', 'arenex-digital-widgets' )
			: __( '— Not assigned', 'arenex-digital-widgets' )
		);

	// All saved Elementor templates for the Replace dropdown.
	$all_templates = get_posts( [
		'post_type'   => 'elementor_library',
		'numberposts' => -1,
		'post_status' => 'publish',
		'orderby'     => 'title',
		'order'       => 'ASC',
	] );
	?>
	<div class="adw-tt-card<?php echo $pro_overriding ? ' is-overridden' : ''; ?>">
		<div class="adw-tt-card-head">
			<div class="adw-tt-card-icon"><?php echo $is_header ? '📐' : '📄'; ?></div>
			<h2 class="adw-tt-card-title"><?php echo esc_html( $label ); ?></h2>
		</div>

		<?php if ( $has_tpl ) : ?>
			<div class="adw-tt-card-body">
				<div class="adw-tt-template-name">
					<strong><?php echo esc_html( get_the_title( $post ) ); ?></strong>
					<small>#<?php echo (int) $post->ID; ?></small>
				</div>
				<div class="adw-tt-status"><?php echo esc_html( $status_text ); ?></div>
			</div>

			<div class="adw-tt-card-actions">
				<a href="<?php echo esc_url( $edit_url ); ?>" class="button button-primary">
					<?php
					/* translators: %s: 'Header' or 'Footer' */
					printf( esc_html__( 'Edit %s', 'arenex-digital-widgets' ), esc_html( $label ) );
					?>
				</a>

				<form method="post" action="<?php echo esc_url( $action_url ); ?>" class="adw-tt-replace-form">
					<?php wp_nonce_field( 'adw_tt_action' ); ?>
					<input type="hidden" name="action" value="adw_tt_action">
					<input type="hidden" name="role" value="<?php echo esc_attr( $role ); ?>">
					<input type="hidden" name="adw_tt_op" value="replace">
					<select name="template_id">
						<option value="<?php echo (int) $post->ID; ?>"><?php esc_html_e( '— Replace with —', 'arenex-digital-widgets' ); ?></option>
						<?php foreach ( $all_templates as $t ) :
							if ( (int) $t->ID === (int) $post->ID ) continue;
							?>
							<option value="<?php echo (int) $t->ID; ?>">
								<?php echo esc_html( get_the_title( $t ) ); ?> (#<?php echo (int) $t->ID; ?>)
							</option>
						<?php endforeach; ?>
					</select>
					<button type="submit" class="button"><?php esc_html_e( 'Save', 'arenex-digital-widgets' ); ?></button>
				</form>

				<form method="post" action="<?php echo esc_url( $action_url ); ?>" class="adw-tt-clear-form">
					<?php wp_nonce_field( 'adw_tt_action' ); ?>
					<input type="hidden" name="action" value="adw_tt_action">
					<input type="hidden" name="role" value="<?php echo esc_attr( $role ); ?>">
					<input type="hidden" name="adw_tt_op" value="clear">
					<button type="submit" class="button-link adw-tt-clear-btn"
						onclick="return confirm('<?php echo esc_js( __( 'Clear this assignment? The template will no longer render globally.', 'arenex-digital-widgets' ) ); ?>');">
						<?php esc_html_e( 'Clear assignment', 'arenex-digital-widgets' ); ?>
					</button>
				</form>
			</div>

		<?php else : ?>
			<div class="adw-tt-card-body adw-tt-card-body--empty">
				<p class="adw-tt-empty-text">
					<?php
					echo $is_header
						? esc_html__( 'No header template assigned yet. Create one to render globally on every page.', 'arenex-digital-widgets' )
						: esc_html__( 'No footer template assigned yet. Create one to render globally on every page.', 'arenex-digital-widgets' );
					?>
				</p>
				<div class="adw-tt-status"><?php echo esc_html( $status_text ); ?></div>
			</div>

			<div class="adw-tt-card-actions">
				<form method="post" action="<?php echo esc_url( $action_url ); ?>">
					<?php wp_nonce_field( 'adw_tt_action' ); ?>
					<input type="hidden" name="action" value="adw_tt_action">
					<input type="hidden" name="role" value="<?php echo esc_attr( $role ); ?>">
					<input type="hidden" name="adw_tt_op" value="create">
					<button type="submit" class="button button-primary">
						<?php
						/* translators: %s: 'Header' or 'Footer' */
						printf( esc_html__( 'Create %s', 'arenex-digital-widgets' ), esc_html( $label ) );
						?>
					</button>
				</form>

				<?php if ( ! empty( $all_templates ) ) : ?>
				<form method="post" action="<?php echo esc_url( $action_url ); ?>" class="adw-tt-replace-form">
					<?php wp_nonce_field( 'adw_tt_action' ); ?>
					<input type="hidden" name="action" value="adw_tt_action">
					<input type="hidden" name="role" value="<?php echo esc_attr( $role ); ?>">
					<input type="hidden" name="adw_tt_op" value="replace">
					<select name="template_id">
						<option value=""><?php esc_html_e( '— Or pick existing —', 'arenex-digital-widgets' ); ?></option>
						<?php foreach ( $all_templates as $t ) : ?>
							<option value="<?php echo (int) $t->ID; ?>">
								<?php echo esc_html( get_the_title( $t ) ); ?> (#<?php echo (int) $t->ID; ?>)
							</option>
						<?php endforeach; ?>
					</select>
					<button type="submit" class="button"><?php esc_html_e( 'Use', 'arenex-digital-widgets' ); ?></button>
				</form>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

/* ──────────────────────────────────────────────────────────────
 * Inline admin CSS
 * ────────────────────────────────────────────────────────────── */
function adw_tt_admin_css() {
	return <<<CSS
	.adw-tt-wrap { max-width: 1280px; }
	.adw-tt-header h1 { font-size: 28px; margin: 16px 0 8px; }
	.adw-tt-lede { font-size: 14px; color: #50575e; max-width: 720px; line-height: 1.6; margin: 0 0 24px; }
	.adw-tt-grid {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 20px;
		margin-bottom: 32px;
	}
	@media (max-width: 800px) { .adw-tt-grid { grid-template-columns: 1fr; } }
	.adw-tt-card {
		background: #fff;
		border: 1px solid #dcdcde;
		border-radius: 6px;
		padding: 24px;
		display: flex;
		flex-direction: column;
		gap: 16px;
	}
	.adw-tt-card.is-overridden { opacity: 0.7; }
	.adw-tt-card-head { display: flex; align-items: center; gap: 12px; }
	.adw-tt-card-icon { font-size: 24px; }
	.adw-tt-card-title { font-size: 18px; font-weight: 600; margin: 0; line-height: 1.2; }
	.adw-tt-card-body { flex: 1 1 auto; }
	.adw-tt-card-body--empty .adw-tt-empty-text { color: #50575e; font-size: 13px; line-height: 1.5; margin: 0 0 12px; }
	.adw-tt-template-name { display: flex; align-items: baseline; gap: 8px; margin-bottom: 8px; font-size: 16px; }
	.adw-tt-template-name small { color: #8c8f94; font-family: Menlo, Monaco, monospace; font-size: 12px; }
	.adw-tt-status { font-size: 12px; color: #50575e; padding: 6px 0; }
	.adw-tt-card.is-overridden .adw-tt-status { color: #d94f00; }
	.adw-tt-card-actions {
		display: flex;
		flex-wrap: wrap;
		gap: 8px;
		align-items: center;
		padding-top: 12px;
		border-top: 1px solid #f0f0f1;
	}
	.adw-tt-replace-form { display: flex; gap: 6px; align-items: center; }
	.adw-tt-replace-form select { max-width: 220px; font-size: 12px; }
	.adw-tt-clear-form { margin-left: auto; }
	.adw-tt-clear-btn { color: #b32d2e; font-size: 12px; }
	.adw-tt-clear-btn:hover { color: #8a1f1f; }
	.adw-tt-howto { background: #fff; border: 1px solid #dcdcde; border-radius: 6px; padding: 20px 24px; }
	.adw-tt-howto h2 { font-size: 16px; margin: 0 0 12px; }
	.adw-tt-howto ol { padding-left: 20px; margin: 0; }
	.adw-tt-howto li { font-size: 13px; line-height: 1.7; color: #1d2327; }
CSS;
}
