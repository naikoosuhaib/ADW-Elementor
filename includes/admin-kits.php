<?php
/**
 * Arenex Master Kits — Admin page
 *
 * Adds top-level "Arenex Digital" menu in WP admin with a "Master Kits" page
 * that lists 4 importable Elementor kit presets.
 *
 * Each kit covers:
 *   - 11 color roles (Primary, Secondary, Accent, Heading, Text, Muted,
 *     Eyebrow, BG, BG Dim, BG Dark, Border)
 *   - 21 typography tokens (4 system + 17 custom incl. H1-H10, Eyebrow,
 *     Accent, Text XS-XL, Button), all rem-based, all responsive.
 *
 * Backward-compat: this is purely additive. No existing widgets or settings
 * are touched. Sites that don't import a kit see no behavior change.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ──────────────────────────────────────────────────────────────
 * Register top-level menu + Master Kits submenu
 * ────────────────────────────────────────────────────────────── */
add_action( 'admin_menu', function () {
	// Top-level Arenex Digital menu (icon: dashicons-art)
	add_menu_page(
		__( 'Arenex Digital', 'arenex-digital-widgets' ),
		__( 'Arenex Digital', 'arenex-digital-widgets' ),
		'manage_options',
		'arenex-digital',
		'adw_master_kits_page',
		'dashicons-art',
		58 // position: between Comments and Appearance
	);

	// Submenu: rename the auto-added first item to "Master Kits"
	add_submenu_page(
		'arenex-digital',
		__( 'Master Kits', 'arenex-digital-widgets' ),
		__( 'Master Kits', 'arenex-digital-widgets' ),
		'manage_options',
		'arenex-digital',
		'adw_master_kits_page'
	);
} );

/* ──────────────────────────────────────────────────────────────
 * Admin assets (only on our page)
 * ────────────────────────────────────────────────────────────── */
add_action( 'admin_enqueue_scripts', function ( $hook ) {
	if ( strpos( $hook, 'arenex-digital' ) === false ) {
		return;
	}
	wp_enqueue_style( 'adw-admin-kits', false );
	wp_add_inline_style( 'adw-admin-kits', adw_master_kits_css() );
} );

/* ──────────────────────────────────────────────────────────────
 * The 4 preset definitions — single source of truth for the UI
 * Filenames must match what build-arenex-kits.py generates in
 * assets/kits/.
 * ────────────────────────────────────────────────────────────── */
function adw_master_kits_definitions() {
	return [
		[
			'slug'        => 'arenex-default',
			'title'       => 'Arenex Default',
			'tagline'     => 'Inter + DM Sans',
			'description' => 'Clean, modern SaaS / professional services. Recommended starting point for most agency builds.',
			'use_cases'   => [ 'SaaS', 'B2B services', 'Professional services', 'Tech startups' ],
			'fonts'       => [ 'Heading: Inter', 'Body: DM Sans', 'Mono: JetBrains Mono' ],
			'accent'      => '#FFEB00',
			'primary'     => '#0D0D0D',
		],
		[
			'slug'        => 'poppins-friendly',
			'title'       => 'Poppins Friendly',
			'tagline'     => 'Poppins + Inter',
			'description' => 'Friendly, approachable, slightly playful. Pairs well with bright accent colors.',
			'use_cases'   => [ 'Startups', 'Lifestyle brands', 'Consumer products', 'Healthcare' ],
			'fonts'       => [ 'Heading: Poppins', 'Body: Inter', 'Mono: JetBrains Mono' ],
			'accent'      => '#FFEB00',
			'primary'     => '#0D0D0D',
		],
		[
			'slug'        => 'archivo-bold',
			'title'       => 'Archivo Black Bold',
			'tagline'     => 'Archivo Black + Inter',
			'description' => 'Heavy display headlines. Ideal for trades, sport, and bold marketing voices.',
			'use_cases'   => [ 'Construction', 'Contractors', 'Sport & fitness', 'Automotive' ],
			'fonts'       => [ 'Heading: Archivo Black', 'Body: Inter', 'Mono: JetBrains Mono' ],
			'accent'      => '#FFEB00',
			'primary'     => '#0D0D0D',
		],
		[
			'slug'        => 'playfair-editorial',
			'title'       => 'Playfair Editorial',
			'tagline'     => 'Playfair Display + Inter',
			'description' => 'Serif-led editorial style. Elegant and premium for hospitality and luxury brands.',
			'use_cases'   => [ 'Luxury brands', 'Hospitality', 'Editorial', 'Weddings & events' ],
			'fonts'       => [ 'Heading: Playfair Display', 'Body: Inter', 'Mono: JetBrains Mono' ],
			'accent'      => '#FFEB00',
			'primary'     => '#0D0D0D',
		],
	];
}

/* ──────────────────────────────────────────────────────────────
 * Helper: kit zip URL (or false if missing on disk)
 * ────────────────────────────────────────────────────────────── */
function adw_master_kit_zip_url( $slug ) {
	$file = ADW_PATH . 'assets/kits/' . $slug . '.zip';
	if ( ! file_exists( $file ) ) {
		return false;
	}
	return ADW_ASSETS_URL . 'kits/' . $slug . '.zip';
}

/* ──────────────────────────────────────────────────────────────
 * Page renderer
 * ────────────────────────────────────────────────────────────── */
function adw_master_kits_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$kits             = adw_master_kits_definitions();
	$elementor_active = did_action( 'elementor/loaded' );
	?>
	<div class="wrap adw-kits-wrap">
		<div class="adw-kits-header">
			<h1><?php esc_html_e( 'Arenex Master Kits', 'arenex-digital-widgets' ); ?></h1>
			<p class="adw-kits-lede">
				<?php
				esc_html_e(
					'Pick one of four design-token presets. Each kit installs 11 colors and 21 typography styles into Elementor — all rem-based, fully responsive (desktop / tablet / mobile). Every Arenex widget references these tokens, so swapping a kit re-paints your entire site.',
					'arenex-digital-widgets'
				);
				?>
			</p>
		</div>

		<?php if ( ! $elementor_active ) : ?>
			<div class="notice notice-warning">
				<p>
					<strong><?php esc_html_e( 'Elementor not detected.', 'arenex-digital-widgets' ); ?></strong>
					<?php esc_html_e( 'Install and activate Elementor before importing a kit.', 'arenex-digital-widgets' ); ?>
				</p>
			</div>
		<?php endif; ?>

		<div class="adw-kits-grid">
			<?php foreach ( $kits as $kit ) :
				$zip_url = adw_master_kit_zip_url( $kit['slug'] );
			?>
				<div class="adw-kit-card" style="--kit-accent: <?php echo esc_attr( $kit['accent'] ); ?>; --kit-primary: <?php echo esc_attr( $kit['primary'] ); ?>;">
					<div class="adw-kit-swatches">
						<span class="adw-kit-swatch" style="background: <?php echo esc_attr( $kit['primary'] ); ?>;"></span>
						<span class="adw-kit-swatch" style="background: <?php echo esc_attr( $kit['accent'] ); ?>;"></span>
						<span class="adw-kit-swatch" style="background: #FFFFFF; border: 1px solid #E0E0E0;"></span>
						<span class="adw-kit-swatch" style="background: #F5F5F5;"></span>
					</div>
					<h2 class="adw-kit-title"><?php echo esc_html( $kit['title'] ); ?></h2>
					<div class="adw-kit-tagline"><?php echo esc_html( $kit['tagline'] ); ?></div>
					<p class="adw-kit-desc"><?php echo esc_html( $kit['description'] ); ?></p>

					<div class="adw-kit-meta">
						<div class="adw-kit-meta-row">
							<strong><?php esc_html_e( 'Fonts', 'arenex-digital-widgets' ); ?></strong>
							<ul>
							<?php foreach ( $kit['fonts'] as $f ) : ?>
								<li><?php echo esc_html( $f ); ?></li>
							<?php endforeach; ?>
							</ul>
						</div>
						<div class="adw-kit-meta-row">
							<strong><?php esc_html_e( 'Best for', 'arenex-digital-widgets' ); ?></strong>
							<ul>
							<?php foreach ( $kit['use_cases'] as $u ) : ?>
								<li><?php echo esc_html( $u ); ?></li>
							<?php endforeach; ?>
							</ul>
						</div>
					</div>

					<?php if ( $zip_url ) : ?>
						<a href="<?php echo esc_url( $zip_url ); ?>" download class="button button-primary adw-kit-btn">
							<?php esc_html_e( 'Download Kit', 'arenex-digital-widgets' ); ?>
						</a>
					<?php else : ?>
						<button class="button" disabled><?php esc_html_e( 'Kit file missing', 'arenex-digital-widgets' ); ?></button>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="adw-kits-howto">
			<h2><?php esc_html_e( 'How to import', 'arenex-digital-widgets' ); ?></h2>
			<ol>
				<li><?php esc_html_e( 'Download a kit above. You\'ll get a .zip file.', 'arenex-digital-widgets' ); ?></li>
				<li><?php
					printf(
						/* translators: %s: link to Elementor → Tools → Import/Export */
						wp_kses(
							__( 'Go to <strong>%s</strong> in WP Admin.', 'arenex-digital-widgets' ),
							[ 'strong' => [] ]
						),
						esc_html__( 'Elementor → Tools → Import / Export Kit → Import Kit', 'arenex-digital-widgets' )
					);
				?></li>
				<li><?php esc_html_e( 'Upload the kit .zip and click Import.', 'arenex-digital-widgets' ); ?></li>
				<li><?php
					echo wp_kses(
						__( 'Done. Open <strong>Elementor → Site Settings → Global Colors / Global Fonts</strong> to see the imported tokens.', 'arenex-digital-widgets' ),
						[ 'strong' => [] ]
					);
				?></li>
			</ol>
			<p class="adw-howto-note">
				<?php esc_html_e( 'You can edit any color or typography token after import — kits are starting points, not lock-ins.', 'arenex-digital-widgets' ); ?>
			</p>
		</div>

		<div class="adw-kits-footer">
			<small>
				<?php
				/* translators: %s: plugin version */
				printf(
					esc_html__( 'Arenex Digital Widgets %s — Master Kits', 'arenex-digital-widgets' ),
					esc_html( defined( 'ADW_VERSION' ) ? ADW_VERSION : '' )
				);
				?>
			</small>
		</div>
	</div>
	<?php
}

/* ──────────────────────────────────────────────────────────────
 * Inline admin CSS
 * ────────────────────────────────────────────────────────────── */
function adw_master_kits_css() {
	return <<<CSS
	.adw-kits-wrap { max-width: 1280px; }
	.adw-kits-header h1 { font-size: 28px; margin: 16px 0 8px; }
	.adw-kits-lede { font-size: 14px; color: #50575e; max-width: 720px; line-height: 1.6; margin: 0 0 24px; }
	.adw-kits-grid {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
		gap: 20px;
		margin-bottom: 40px;
	}
	.adw-kit-card {
		background: #fff;
		border: 1px solid #dcdcde;
		border-radius: 6px;
		padding: 24px;
		display: flex;
		flex-direction: column;
		transition: box-shadow .15s ease, transform .15s ease;
	}
	.adw-kit-card:hover {
		box-shadow: 0 8px 24px rgba(0,0,0,.08);
		transform: translateY(-2px);
	}
	.adw-kit-swatches { display: flex; gap: 6px; margin-bottom: 16px; }
	.adw-kit-swatch { width: 24px; height: 24px; border-radius: 4px; box-shadow: inset 0 0 0 1px rgba(0,0,0,.06); }
	.adw-kit-title { font-size: 18px; margin: 0 0 4px; font-weight: 600; line-height: 1.2; }
	.adw-kit-tagline { font-size: 12px; letter-spacing: .04em; color: var(--kit-accent, #50575e); text-transform: uppercase; font-weight: 600; margin-bottom: 12px; }
	.adw-kit-desc { font-size: 13px; line-height: 1.5; color: #50575e; margin: 0 0 16px; flex-grow: 1; }
	.adw-kit-meta { font-size: 12px; color: #50575e; margin-bottom: 16px; padding: 12px 0; border-top: 1px solid #f0f0f1; border-bottom: 1px solid #f0f0f1; }
	.adw-kit-meta-row { display: flex; gap: 8px; align-items: flex-start; padding: 4px 0; }
	.adw-kit-meta-row strong { flex: 0 0 60px; font-weight: 600; color: #1d2327; }
	.adw-kit-meta-row ul { margin: 0; padding: 0; list-style: none; }
	.adw-kit-meta-row li { display: inline; }
	.adw-kit-meta-row li:not(:last-child)::after { content: " · "; color: #c3c4c7; }
	.adw-kit-btn { width: 100%; text-align: center; }
	.adw-kits-howto { background: #fff; border: 1px solid #dcdcde; border-radius: 6px; padding: 20px 24px; margin-bottom: 16px; }
	.adw-kits-howto h2 { font-size: 16px; margin: 0 0 12px; }
	.adw-kits-howto ol { padding-left: 20px; margin: 0; }
	.adw-kits-howto li { font-size: 13px; line-height: 1.7; color: #1d2327; }
	.adw-howto-note { font-size: 12px; color: #50575e; margin: 12px 0 0; font-style: italic; }
	.adw-kits-footer { color: #8c8f94; font-size: 11px; padding: 8px 0; }
CSS;
}
