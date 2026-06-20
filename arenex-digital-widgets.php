<?php
/**
 * Plugin Name:       Arenex Digital Widgets
 * Plugin URI:
 * GitHub Plugin URI: naikoosuhaib/ADW-Elementor
 * Primary Branch:    main
 * Description:       Lean agency-grade Elementor widgets by Arenex Digital — Hero, Services, Process, Timeline, Marquee, Reviews Carousel, Portfolio Carousel, Carousel-Card, Split-Scroll, Section-Pattern, Vertical Image Gallery, Process Showcase, Header, Footer. Ships with Master Kits + global Header/Footer + dark-mode color tokens. Works on Elementor Free and Pro.
 * Version:           5.1.0
 * Author:            Arenex Digital
 * Author URI:
 * Text Domain:       arenex-digital-widgets
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Elementor tested up to: 3.25
 *
 * Changelog 5.0.6
 *
 *   TIMELINE (alternating)
 *   - Numbers now center vertically on each card (left-side cards were dropping
 *     to a second grid row, mis-aligning them). Markers + cards pinned to the
 *     same row; connecting line bridges the inter-item gap to stay continuous.
 *
 *   SPLIT SCROLL
 *   - NEW controls: Image Height, Image Fit (object-fit), Image Position,
 *     Sticky Top Offset.
 *   - FIX: image now fills the chosen height (an Elementor/theme `img{height:auto}`
 *     rule was capping it at the image's natural height).
 *
 *   CLEANUP
 *   - Removed the Bento Grid widget (no longer used). Its CSS is left in place
 *     (interleaved with other widgets' rules) but unused/harmless.
 *
 * Changelog 5.0.5
 *
 *   REGRESSION FIXES (widget code dropped in the v5.0.0 merge from v4.4.9)
 *   - Process Showcase: restored its CSS and JS (it had rendered unstyled with
 *     no auto-advancing progress). Recovered from v4.2.9.
 *   - Vertical Image Gallery: restored its CSS and JS — the autoplay loop now
 *     runs again (is-autoplay was never applied).
 *   - Process Steps (accordion): restored its click handler (cards now expand).
 *   - All restored JS is self-contained and guarded against double-init.
 *
 *   TIMELINE
 *   - Alternating layout: markers now top-aligned via marker-size so the
 *     connecting line locks onto every dot regardless of Item Gap padding
 *     (first/last dots no longer float off the line).
 *
 * Changelog 5.0.4
 *
 *   DISTRIBUTION
 *   - NEW: Built-in GitHub self-updater (includes/class-adw-github-updater.php).
 *          When ADW_GH_REPO is set to "owner/repo", every site shows ADW updates
 *          in Dashboard → Updates and can one-click update from GitHub Releases —
 *          no more manually re-uploading the ZIP on each client site. Supports
 *          private repos via a read-only ADW_GH_TOKEN. OFF by default (inert
 *          until ADW_GH_REPO is configured). Test on a local/staging site first.
 *
 * Changelog 5.0.3
 *
 *   TIMELINE
 *   - NEW: "Vertical Layout" control — Standard (single side) or Alternating
 *          (zig-zag). Alternating places each card on alternating sides of a
 *          centered line; the line auto-trims to start at the first dot and end
 *          at the last. Ideal for "Next Steps" / process sections.
 *   - NEW: Optional per-item Button (Button Text + Button Link) on each timeline
 *          item, rendered inside the content. Works in any layout. New Style →
 *          Button section (text/bg colors + hover, typography, padding, radius).
 *   - The Line controls (Color / Thickness / Style) now also drive the
 *          alternating layout's connecting line.
 *   - Item content is now wrapped in .cmp-timeline__content (transparent in the
 *          standard layout — no visual change there).
 *
 *   FOOTER
 *   - FIX: Bottom-bar "Copyright" and "Bottom Right" fields now allow links/HTML
 *          (wp_kses_post instead of esc_html), so an <a> tag renders clickable
 *          instead of showing as raw text. Both are now textareas with a hint.
 *
 * Changelog 5.0.2
 *
 *   TIMELINE
 *   - NEW: "Line Style" control — Solid / Dashed / Dotted / None.
 *   - FIX: Line vertical position now tracks the marker_size control via a
 *          --cmp-marker-size CSS variable. Bigger markers no longer leave the
 *          line floating above their centerline.
 *   - REFACTOR: Line implementation switched from background-color to
 *          border (background → border-color, height/width → border-width).
 *          Backward-compatible — Line Color and Line Thickness controls still
 *          work, they just drive border properties now.
 *   - FIX: Mobile/tablet icon margin reset is now !important so per-instance
 *          values saved via Item Icon → "Gap Above" don't leak onto phone
 *          (was causing a 15-18px gap above the icon on mobile).
 *
 * Changelog 5.0.1
 *
 *   HEADER
 *   - FIX: Logo no longer collapses to width:0. The `logo_width_override`
 *          control used to default to size:0, which Elementor saved as inline
 *          `width: 0px` on every widget instance. It's now gated behind a
 *          switcher (`use_logo_width_override`), off by default — width
 *          auto-calculates from Logo Height + natural aspect.
 *   - FIX: CSS safety net — `.cmp-sh-logo img` now has `min-width: 1rem
 *          !important;` so existing widgets with legacy width:0 saved data
 *          still render correctly.
 *
 *   TIMELINE
 *   - FIX: Tablet layout (≤1024px) now uses the clean vertical stack instead
 *          of the broken 3+2 row wrap (row-2 markers used to float without a
 *          connecting line).
 *   - FIX: On vertical mode the item icon now aligns flush-left under the
 *          marker (was offset 18px right + 18px down from centered margins).
 *
 * Changelog 5.0.0  (merged release — supersedes 4.4.9 and 4.5.0)
 *
 *   TIMELINE
 *   - NEW: "Show Item Icon (below marker)" switcher — render the per-item icon
 *          as a separate element between marker and title (number + icon + text layout).
 *   - NEW: "Show Year / Marker Text" switcher — hide year/marker text cleanly.
 *   - NEW: "Item Alignment" CHOOSE control (Left / Center / Right) — horizontal mode.
 *   - NEW: Style → Item Icon panel (color, size, gap above/below).
 *   - FIX: Horizontal marker now centers in its grid cell (was pinned left:0).
 *   - FIX: Connecting line now spans first marker to last (10% / 10% inset).
 *
 *   HEADER
 *   - NEW: Phone slot now accepts any URL via "Link" field (tel: / mailto: /
 *          https://login.… / anything). Old "phone_number" digits-only field
 *          retained as backward-compat fallback.
 *   - NEW: "Show Icon" switcher on the phone button — hide when repurposing
 *          for login / custom CTA.
 *
 *   FOOTER
 *   - FIX: Removed `border-top: none !important;` on .cmp-sf-bottom so the
 *          Divider Color control actually shows a line.
 *   - FIX: Default copyright / contact / "Built by" values are now neutral
 *          placeholders ("Your Company" / blank) instead of "Arenex Digital".
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'ADW_VERSION',    '5.1.0.' . date( 'YmdHi' ) );
define( 'ADW_FILE',       __FILE__ );
define( 'ADW_PATH',       plugin_dir_path( __FILE__ ) );
define( 'ADW_URL',        plugin_dir_url( __FILE__ ) );
define( 'ADW_ASSETS_URL', ADW_URL . 'assets/' );

/**
 * ── SELF-UPDATER (GitHub Releases) ──
 * Set ADW_GH_REPO to "owner/repo" to turn on update notifications on every site
 * (shown in Dashboard → Updates, one-click update). For a PRIVATE repo, also set
 * ADW_GH_TOKEN to a fine-grained, READ-ONLY token (Contents: Read).
 * Leave ADW_GH_REPO empty to keep the updater OFF (default). You can also define
 * these in wp-config.php so the token stays out of the plugin files.
 */
if ( ! defined( 'ADW_GH_REPO' ) )  define( 'ADW_GH_REPO',  '' ); // e.g. 'arenexdigital/arenex-digital-widgets'
if ( ! defined( 'ADW_GH_TOKEN' ) ) define( 'ADW_GH_TOKEN', '' ); // only for private repos

if ( ADW_GH_REPO && is_admin() ) {
    require_once ADW_PATH . 'includes/class-adw-github-updater.php';
    new ADW_GitHub_Updater( ADW_FILE, ADW_GH_REPO, ADW_GH_TOKEN );
}

/* ── Elementor check ── */
function adw_check_elementor() {
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', function () {
            echo '<div class="notice notice-warning"><p>';
            echo '<strong>Arenex Digital Widgets</strong> requires <strong>Elementor</strong> to be installed and active.';
            echo '</p></div>';
        } );
        return false;
    }
    return true;
}

/* ── Fonts & Assets ── */
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'adw-fonts',
        'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@300;400;500;600;700&family=Barlow+Condensed:wght@400;600;700&family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap',
        [], null
    );
    $css_ver = filemtime( ADW_PATH . 'assets/css/arenex-digital-sections.css' ) ?: ADW_VERSION;
    $js_ver  = filemtime( ADW_PATH . 'assets/js/arenex-digital-front.js' ) ?: ADW_VERSION;
    wp_enqueue_style( 'adw-styles', ADW_ASSETS_URL . 'css/arenex-digital-sections.css', [ 'adw-fonts', 'elementor-frontend' ], $css_ver );
    wp_enqueue_script( 'adw-front', ADW_ASSETS_URL . 'js/arenex-digital-front.js', [ 'jquery' ], $js_ver, true );
}, 999 );

add_action( 'elementor/frontend/after_register_styles', function () {
    wp_register_style( 'adw-fonts',
        'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@300;400;500;600;700&family=Barlow+Condensed:wght@400;600;700&family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap',
        [], null
    );
    wp_register_style( 'adw-styles', ADW_ASSETS_URL . 'css/arenex-digital-sections.css', [ 'adw-fonts' ], ADW_VERSION );
} );

add_action( 'elementor/frontend/after_register_scripts', function () {
    wp_register_script( 'adw-front', ADW_ASSETS_URL . 'js/arenex-digital-front.js', [ 'jquery' ], ADW_VERSION, true );
} );

add_action( 'elementor/preview/enqueue_styles', function () {
    wp_enqueue_style( 'adw-fonts' );
    wp_enqueue_style( 'adw-styles' );
} );

add_action( 'elementor/preview/enqueue_scripts', function () {
    wp_enqueue_script( 'adw-front' );
} );

/* ── Widget category ── */
add_action( 'elementor/elements/categories_registered', function ( $elements_manager ) {
    $elements_manager->add_category( 'arenex-digital', [
        'title' => __( 'Arenex Digital', 'arenex-digital-widgets' ),
        'icon'  => 'eicon-play',
    ] );
} );

/* ── Register all 41 widgets ── */
add_action( 'elementor/widgets/register', function ( $widgets_manager ) {

    if ( ! adw_check_elementor() ) return;

    $widgets = [
        /* ──────────────── v3.9 — 12 widgets (lean agency core) ──────────────── */

        /* Site chrome */
        'class-site-header.php'             => 'CMP_Site_Header',
        'class-site-footer.php'             => 'CMP_Site_Footer',

        /* Hero & marketing core */
        'class-hero.php'                    => 'CMP_Hero',
        'class-services-grid.php'           => 'CMP_Services_Grid',
        'class-services-bg-style.php'       => 'CMP_Services_BG_Style',
        'class-testimonials.php'            => 'CMP_Testimonials',
        'class-process-steps.php'           => 'CMP_Process_Steps',
        'class-timeline.php'                => 'CMP_Timeline',
        'class-marquee.php'                 => 'CMP_Marquee',
        'class-section-pattern.php'         => 'CMP_Section_Pattern',

        /* Social proof + content */
        'class-reviews-carousel.php'        => 'CMP_Reviews_Carousel',       // infinite-scroll review marquee
        'class-portfolio-carousel.php'      => 'CMP_Portfolio_Carousel',

        /* Premium scroll/carousel */
        'class-carousel-card.php'           => 'CMP_Carousel_Card',
        'class-split-scroll.php'            => 'CMP_Split_Scroll',
        'class-vertical-image-gallery.php'  => 'CMP_Vertical_Image_Gallery',
        'class-process-showcase.php'        => 'CMP_Process_Showcase',
        'class-before-after.php'            => 'CMP_Before_After',          // drag-to-reveal comparison slider

        /* Blog System */
        // 'class-single-post.php'             => 'CMP_Single_Post',  // moved to Elementor Pro Theme Builder
        // 'class-blog-archive.php'            => 'CMP_Blog_Archive',  // moved to Elementor Pro Theme Builder

        // 'class-bento-grid.php'              => 'CMP_Bento_Grid',   // removed — widget no longer needed
    ];

    foreach ( $widgets as $file => $class ) {
        $path = ADW_PATH . 'widgets/' . $file;
        if ( file_exists( $path ) ) {
            require_once $path;
            if ( class_exists( $class ) ) {
                $widgets_manager->register( new $class() );
            }
        }
    }
} );

/* ── Red Shield Page Creator (admin tool) ── */
require_once ADW_PATH . 'includes/page-creator.php';

/* ── Master Kits admin page (v3.8.3+) ── */
require_once ADW_PATH . 'includes/admin-kits.php';

/* ── Theme Templates admin page + global header/footer renderer (v3.8.4+) ── */
require_once ADW_PATH . 'includes/admin-theme-templates.php';

/* ═════════════════════════════════════════════════════════════════════
 * ADW SITE SETTINGS — Site-wide Button Hover Effect (v3.9+)
 * One dropdown that applies a unified hover animation to EVERY button on
 * the site: plugin .cmp-btn family, Elementor's native .elementor-button,
 * site header CTAs. Sets a body class which the CSS reads.
 * ═════════════════════════════════════════════════════════════════════ */
add_action( 'admin_menu', function () {
    add_submenu_page(
        'arenex-digital',
        __( 'Site Settings', 'arenex-digital-widgets' ),
        __( 'Site Settings', 'arenex-digital-widgets' ),
        'manage_options',
        'arenex-digital-settings',
        'adw_render_site_settings_page'
    );
}, 20 );

function adw_get_button_effects() {
    return [
        'lift-glow'    => __( 'Lift + Glow (default — subtle)', 'arenex-digital-widgets' ),
        'glow-ring'    => __( 'Glow Ring (animated outline)', 'arenex-digital-widgets' ),
        'color-invert' => __( 'Color Invert (bg / text swap)', 'arenex-digital-widgets' ),
        'arrow-slide'  => __( 'Arrow Slide (icon nudges right)', 'arenex-digital-widgets' ),
        'shine-sweep'  => __( 'Shine Sweep (light reflection)', 'arenex-digital-widgets' ),
        'pulse'        => __( 'Pulse (continuous slow pulse)', 'arenex-digital-widgets' ),
        'none'         => __( 'None (disable all hover effects)', 'arenex-digital-widgets' ),
    ];
}

function adw_get_button_icons() {
    return [
        'none'           => __( 'None — let me set icons per button', 'arenex-digital-widgets' ),
        'arrow-right'    => __( '→  Arrow Right', 'arenex-digital-widgets' ),
        'arrow-up-right' => __( '↗  Arrow Up-Right (external link feel)', 'arenex-digital-widgets' ),
        'long-arrow'     => __( '⟶  Long Arrow', 'arenex-digital-widgets' ),
        'chevron-right'  => __( '›  Chevron Right', 'arenex-digital-widgets' ),
        'plus'           => __( '+  Plus', 'arenex-digital-widgets' ),
    ];
}

function adw_get_scroll_animations() {
    return [
        'fade-up'  => __( 'Fade Up (default — gentle rise + fade)', 'arenex-digital-widgets' ),
        'fade-in'  => __( 'Fade In (pure opacity)', 'arenex-digital-widgets' ),
        'slide-up' => __( 'Slide Up (more aggressive lift)', 'arenex-digital-widgets' ),
        'zoom-in'  => __( 'Zoom In (subtle scale + fade)', 'arenex-digital-widgets' ),
        'none'     => __( 'None — use Elementor\'s built-in animations as-is', 'arenex-digital-widgets' ),
    ];
}

function adw_render_site_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    if ( isset( $_POST['adw_settings_submit'] ) && check_admin_referer( 'adw_settings_save' ) ) {
        // ── BUTTONS group ──
        // Hover effect
        $effect_value   = sanitize_key( $_POST['adw_button_hover_effect'] ?? '' );
        $allowed_fx     = array_keys( adw_get_button_effects() );
        if ( in_array( $effect_value, $allowed_fx, true ) ) {
            update_option( 'adw_button_hover_effect', $effect_value );
        }
        // Default button icon
        $icon_value     = sanitize_key( $_POST['adw_button_icon'] ?? '' );
        $allowed_icons  = array_keys( adw_get_button_icons() );
        if ( in_array( $icon_value, $allowed_icons, true ) ) {
            update_option( 'adw_button_icon', $icon_value );
        }
        // Button radius
        if ( isset( $_POST['adw_btn_radius'] ) ) {
            update_option( 'adw_btn_radius', absint( $_POST['adw_btn_radius'] ) );
        }
        // Button padding Desktop (T R B L) — always saved
        $pt = absint( $_POST['adw_btn_pad_top']    ?? 14 );
        $pr = absint( $_POST['adw_btn_pad_right']  ?? 28 );
        $pb = absint( $_POST['adw_btn_pad_bottom'] ?? 14 );
        $pl = absint( $_POST['adw_btn_pad_left']   ?? 28 );
        update_option( 'adw_btn_padding', "{$pt} {$pr} {$pb} {$pl}" );

        // Button padding Tablet — empty value = inherit desktop
        $tp = adw_norm_pad_input( $_POST, 'adw_btn_pad_tablet' );
        update_option( 'adw_btn_padding_tablet', $tp );

        // Button padding Mobile — empty value = inherit tablet/desktop
        $mp = adw_norm_pad_input( $_POST, 'adw_btn_pad_mobile' );
        update_option( 'adw_btn_padding_mobile', $mp );

        // ── ANIMATIONS group ──
        $anim_value     = sanitize_key( $_POST['adw_scroll_animation'] ?? '' );
        $allowed_anims  = array_keys( adw_get_scroll_animations() );
        if ( in_array( $anim_value, $allowed_anims, true ) ) {
            update_option( 'adw_scroll_animation', $anim_value );
        }

        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Settings saved.', 'arenex-digital-widgets' ) . '</p></div>';
    }

    $current_fx     = get_option( 'adw_button_hover_effect', 'lift-glow' );
    $current_icon   = get_option( 'adw_button_icon', 'none' );
    $current_anim   = get_option( 'adw_scroll_animation', 'fade-up' );
    $current_radius = absint( get_option( 'adw_btn_radius', 8 ) );
    $pad_parts      = array_pad( array_map( 'absint', explode( ' ', get_option( 'adw_btn_padding', '14 28 14 28' ) ) ), 4, 0 );
    $pad_tablet     = adw_split_pad_or_blank( get_option( 'adw_btn_padding_tablet', '' ) );
    $pad_mobile     = adw_split_pad_or_blank( get_option( 'adw_btn_padding_mobile', '' ) );
    $effects = adw_get_button_effects();
    $icons   = adw_get_button_icons();
    $anims   = adw_get_scroll_animations();
    ?>
    <div class="wrap adw-site-settings">
        <h1><?php esc_html_e( 'Arenex Digital — Site Settings', 'arenex-digital-widgets' ); ?></h1>
        <p><?php esc_html_e( 'Site-wide configuration. These options affect every page that uses this plugin.', 'arenex-digital-widgets' ); ?></p>

        <style>
            .adw-site-settings .adw-group{background:#fff;border:1px solid #dcdcde;border-left:4px solid #2271b1;border-radius:4px;margin:18px 0;padding:6px 22px 14px}
            .adw-site-settings .adw-group > h2{margin:14px 0 4px;font-size:16px;display:flex;align-items:center;gap:8px}
            .adw-site-settings .adw-group > h2 .dashicons{color:#2271b1;font-size:22px;width:22px;height:22px}
            .adw-site-settings .adw-group > .adw-group-desc{margin:0 0 6px;color:#646970;font-size:13px}
            .adw-site-settings .adw-pad-row label{display:inline-flex;align-items:center;gap:4px;margin-right:8px}
            .adw-site-settings .adw-pad-row input[type=number]{width:60px}
            .adw-site-settings .adw-pad-hint{color:#646970;font-style:italic;font-size:12px;margin-left:4px}
        </style>

        <form method="post">
            <?php wp_nonce_field( 'adw_settings_save' ); ?>
            <input type="hidden" name="adw_settings_submit" value="1">

            <!-- ════════ BUTTONS GROUP ════════ -->
            <div class="adw-group">
                <h2><span class="dashicons dashicons-button"></span><?php esc_html_e( 'Buttons', 'arenex-digital-widgets' ); ?></h2>
                <p class="adw-group-desc"><?php esc_html_e( 'Everything that controls site-wide button look & feel. Add future button settings here.', 'arenex-digital-widgets' ); ?></p>
                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label for="adw_button_hover_effect"><?php esc_html_e( 'Hover Effect', 'arenex-digital-widgets' ); ?></label></th>
                        <td>
                            <select name="adw_button_hover_effect" id="adw_button_hover_effect" style="min-width:340px">
                                <?php foreach ( $effects as $val => $label ) : ?>
                                    <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_fx, $val ); ?>><?php echo esc_html( $label ); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="description"><?php esc_html_e( 'Applies to ALL buttons site-wide — plugin widgets (.cmp-btn), Elementor\'s native Button widget, site-header CTAs.', 'arenex-digital-widgets' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="adw_button_icon"><?php esc_html_e( 'Default Icon', 'arenex-digital-widgets' ); ?></label></th>
                        <td>
                            <select name="adw_button_icon" id="adw_button_icon" style="min-width:340px">
                                <?php foreach ( $icons as $val => $label ) : ?>
                                    <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_icon, $val ); ?>><?php echo esc_html( $label ); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="description"><?php esc_html_e( 'Auto-appends this icon to every button. Inherits button text color. Add class "no-icon" to opt-out.', 'arenex-digital-widgets' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="adw_btn_radius"><?php esc_html_e( 'Border Radius (px)', 'arenex-digital-widgets' ); ?></label></th>
                        <td>
                            <input type="number" name="adw_btn_radius" id="adw_btn_radius" value="<?php echo esc_attr( $current_radius ); ?>" min="0" max="50" style="width:80px">
                            <p class="description"><?php esc_html_e( 'Sets --adw-btn-radius CSS var used by all .cmp-btn buttons.', 'arenex-digital-widgets' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e( 'Padding — Desktop (px)', 'arenex-digital-widgets' ); ?></th>
                        <td class="adw-pad-row">
                            <label><?php esc_html_e( 'T', 'arenex-digital-widgets' ); ?> <input type="number" name="adw_btn_pad_top"    value="<?php echo esc_attr( $pad_parts[0] ); ?>" min="0" max="100"></label>
                            <label><?php esc_html_e( 'R', 'arenex-digital-widgets' ); ?> <input type="number" name="adw_btn_pad_right"  value="<?php echo esc_attr( $pad_parts[1] ); ?>" min="0" max="100"></label>
                            <label><?php esc_html_e( 'B', 'arenex-digital-widgets' ); ?> <input type="number" name="adw_btn_pad_bottom" value="<?php echo esc_attr( $pad_parts[2] ); ?>" min="0" max="100"></label>
                            <label><?php esc_html_e( 'L', 'arenex-digital-widgets' ); ?> <input type="number" name="adw_btn_pad_left"   value="<?php echo esc_attr( $pad_parts[3] ); ?>" min="0" max="100"></label>
                            <p class="description"><?php esc_html_e( 'Base padding for all .cmp-btn buttons (≥ 1025px).', 'arenex-digital-widgets' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e( 'Padding — Tablet (px)', 'arenex-digital-widgets' ); ?></th>
                        <td class="adw-pad-row">
                            <label><?php esc_html_e( 'T', 'arenex-digital-widgets' ); ?> <input type="number" name="adw_btn_pad_tablet[top]"    value="<?php echo esc_attr( $pad_tablet[0] ); ?>" min="0" max="100"></label>
                            <label><?php esc_html_e( 'R', 'arenex-digital-widgets' ); ?> <input type="number" name="adw_btn_pad_tablet[right]"  value="<?php echo esc_attr( $pad_tablet[1] ); ?>" min="0" max="100"></label>
                            <label><?php esc_html_e( 'B', 'arenex-digital-widgets' ); ?> <input type="number" name="adw_btn_pad_tablet[bottom]" value="<?php echo esc_attr( $pad_tablet[2] ); ?>" min="0" max="100"></label>
                            <label><?php esc_html_e( 'L', 'arenex-digital-widgets' ); ?> <input type="number" name="adw_btn_pad_tablet[left]"   value="<?php echo esc_attr( $pad_tablet[3] ); ?>" min="0" max="100"></label>
                            <span class="adw-pad-hint"><?php esc_html_e( 'Leave blank to inherit Desktop. Active ≤ 1024px.', 'arenex-digital-widgets' ); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e( 'Padding — Mobile (px)', 'arenex-digital-widgets' ); ?></th>
                        <td class="adw-pad-row">
                            <label><?php esc_html_e( 'T', 'arenex-digital-widgets' ); ?> <input type="number" name="adw_btn_pad_mobile[top]"    value="<?php echo esc_attr( $pad_mobile[0] ); ?>" min="0" max="100"></label>
                            <label><?php esc_html_e( 'R', 'arenex-digital-widgets' ); ?> <input type="number" name="adw_btn_pad_mobile[right]"  value="<?php echo esc_attr( $pad_mobile[1] ); ?>" min="0" max="100"></label>
                            <label><?php esc_html_e( 'B', 'arenex-digital-widgets' ); ?> <input type="number" name="adw_btn_pad_mobile[bottom]" value="<?php echo esc_attr( $pad_mobile[2] ); ?>" min="0" max="100"></label>
                            <label><?php esc_html_e( 'L', 'arenex-digital-widgets' ); ?> <input type="number" name="adw_btn_pad_mobile[left]"   value="<?php echo esc_attr( $pad_mobile[3] ); ?>" min="0" max="100"></label>
                            <span class="adw-pad-hint"><?php esc_html_e( 'Leave blank to inherit Tablet/Desktop. Active ≤ 640px.', 'arenex-digital-widgets' ); ?></span>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- ════════ ANIMATIONS GROUP ════════ -->
            <div class="adw-group" style="border-left-color:#7e57c2">
                <h2><span class="dashicons dashicons-image-rotate"></span><?php esc_html_e( 'Animations', 'arenex-digital-widgets' ); ?></h2>
                <p class="adw-group-desc"><?php esc_html_e( 'Site-wide scroll & motion behavior. Affects every page.', 'arenex-digital-widgets' ); ?></p>
                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label for="adw_scroll_animation"><?php esc_html_e( 'Scroll Animation', 'arenex-digital-widgets' ); ?></label></th>
                        <td>
                            <select name="adw_scroll_animation" id="adw_scroll_animation" style="min-width:340px">
                                <?php foreach ( $anims as $val => $label ) : ?>
                                    <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_anim, $val ); ?>><?php echo esc_html( $label ); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="description"><?php esc_html_e( 'Unifies scroll-in animations across plugin widgets AND Elementor\'s native sections. Whatever animation Elementor users pick will be normalized to this style + timing for a consistent feel.', 'arenex-digital-widgets' ); ?></p>
                        </td>
                    </tr>
                </table>
            </div>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

/* Helpers for responsive padding — empty inputs stored as blank so we can inherit. */
function adw_norm_pad_input( $post, $key ) {
    if ( ! isset( $post[ $key ] ) || ! is_array( $post[ $key ] ) ) return '';
    $t = $post[ $key ]['top']    ?? '';
    $r = $post[ $key ]['right']  ?? '';
    $b = $post[ $key ]['bottom'] ?? '';
    $l = $post[ $key ]['left']   ?? '';
    // If ALL four are blank, store empty string (= inherit upstream device)
    if ( $t === '' && $r === '' && $b === '' && $l === '' ) return '';
    // Otherwise treat blanks as 0 for that side
    return absint( $t ) . ' ' . absint( $r ) . ' ' . absint( $b ) . ' ' . absint( $l );
}
function adw_split_pad_or_blank( $stored ) {
    if ( $stored === '' || $stored === null ) return [ '', '', '', '' ];
    $p = array_pad( explode( ' ', $stored ), 4, '0' );
    return [ $p[0], $p[1], $p[2], $p[3] ];
}

/* Add the chosen effect + icon as body classes so CSS can target them */
add_filter( 'body_class', function ( $classes ) {
    $effect = get_option( 'adw_button_hover_effect', 'lift-glow' );
    $allowed_fx = array_keys( adw_get_button_effects() );
    if ( ! in_array( $effect, $allowed_fx, true ) ) $effect = 'lift-glow';
    $classes[] = 'adw-btn-fx-' . sanitize_html_class( $effect );

    $icon = get_option( 'adw_button_icon', 'none' );
    $allowed_icons = array_keys( adw_get_button_icons() );
    if ( ! in_array( $icon, $allowed_icons, true ) ) $icon = 'none';
    $classes[] = 'adw-btn-icon-' . sanitize_html_class( $icon );

    $anim = get_option( 'adw_scroll_animation', 'fade-up' );
    $allowed_anims = array_keys( adw_get_scroll_animations() );
    if ( ! in_array( $anim, $allowed_anims, true ) ) $anim = 'fade-up';
    $classes[] = 'adw-anim-' . sanitize_html_class( $anim );

    return $classes;
} );

/* ═════════════════════════════════════════════════════════════════════
 * ADW BUTTON SYNC
 * Reads Elementor Theme Style → Buttons and applies the same sizing/
 * colors/typography to every ADW button class site-wide.
 * Per-widget Style tab overrides still win (no !important used).
 * ═════════════════════════════════════════════════════════════════════ */
if ( ! class_exists( 'ADW_Button_Sync' ) ) :
class ADW_Button_Sync {
    private static $settings = null;
    private static function button_selectors() {
        return [ '.cmp-btn', '.cmp-btn-primary', '.cmp-btn-secondary', '.cmp-btn-outline-light', '.cmp-btn-submit', '.cmp-hero-btn-primary', '.cmp-hero-btn-secondary', '.cmp-cta-banner-btn', '.cmp-split-scroll__btn', '.cmp-split-hero__btn', '.cmp-owner__btn', '.cmp-footer-cta__btn' ];
    }
    private static function primary_selectors() {
        return [ '.cmp-btn-primary', '.cmp-hero-btn-primary', '.cmp-cta-banner-btn', '.cmp-btn-submit', '.cmp-owner__btn', '.cmp-footer-cta__btn', '.cmp-split-scroll__btn--primary', '.cmp-split-hero__btn--primary' ];
    }
    public static function init() {
        add_action( 'wp_head', [ __CLASS__, 'print_css' ], 100 );
        add_action( 'elementor/preview/enqueue_styles', [ __CLASS__, 'print_css' ], 100 );
    }
    private static function get_kit_settings() {
        if ( self::$settings !== null ) return self::$settings;
        self::$settings = [];
        $kit_id = get_option( 'elementor_active_kit' );
        if ( ! $kit_id ) return self::$settings;
        $meta = get_post_meta( $kit_id, '_elementor_page_settings', true );
        if ( is_array( $meta ) ) self::$settings = $meta;
        return self::$settings;
    }
    private static function dim( $v ) {
        if ( ! is_array( $v ) ) return '';
        $unit = ! empty( $v['unit'] ) ? $v['unit'] : 'px';
        $top  = isset( $v['top'] )    && $v['top']    !== '' ? $v['top']    : null;
        $rig  = isset( $v['right'] )  && $v['right']  !== '' ? $v['right']  : null;
        $bot  = isset( $v['bottom'] ) && $v['bottom'] !== '' ? $v['bottom'] : null;
        $lef  = isset( $v['left'] )   && $v['left']   !== '' ? $v['left']   : null;
        if ( $top === null && $rig === null && $bot === null && $lef === null ) return '';
        return sprintf( '%s%s %s%s %s%s %s%s', $top ?? '0', $unit, $rig ?? '0', $unit, $bot ?? '0', $unit, $lef ?? '0', $unit );
    }
    private static function slider( $v, $default_unit = 'px' ) {
        if ( ! is_array( $v ) ) return '';
        if ( ! isset( $v['size'] ) || $v['size'] === '' ) return '';
        $unit = ! empty( $v['unit'] ) ? $v['unit'] : $default_unit;
        return $v['size'] . $unit;
    }
    public static function print_css() {
        static $printed = false;
        if ( $printed ) return;
        $printed = true;
        $s = self::get_kit_settings();
        if ( empty( $s ) ) return;

        $font_size      = self::slider( $s['button_typography_font_size']      ?? null );
        $font_weight    = $s['button_typography_font_weight']                  ?? '';
        $text_transform = $s['button_typography_text_transform']               ?? '';
        $letter_spacing = self::slider( $s['button_typography_letter_spacing'] ?? null, 'em' );
        $line_height    = self::slider( $s['button_typography_line_height']    ?? null, 'em' );
        $font_family    = $s['button_typography_font_family']                  ?? '';
        $padding        = self::dim(    $s['button_padding']       ?? null );
        $border_radius  = self::dim(    $s['button_border_radius'] ?? null );
        $border_width   = self::dim(    $s['button_border_width']  ?? null );
        $border_type    = $s['button_border_border']                ?? '';
        $border_color   = $s['button_border_color']                 ?? '';
        $text_color     = $s['button_text_color']       ?? '';
        $bg_color       = $s['button_background_color'] ?? '';
        $hover_text     = $s['button_hover_text_color']        ?? '';
        $hover_bg       = $s['button_hover_background_color']  ?? '';
        $hover_border   = $s['button_hover_border_color']      ?? '';

        if ( ! $font_size && ! $padding && ! $bg_color && ! $text_color ) return;

        $all       = implode( ',', self::button_selectors() );
        $primary   = implode( ',', self::primary_selectors() );
        $primary_h = implode( ':hover,', self::primary_selectors() ) . ':hover';

        $rules = [];
        if ( $padding )        $rules[] = 'padding:' . $padding;
        if ( $font_size )      $rules[] = 'font-size:' . $font_size;
        if ( $font_weight )    $rules[] = 'font-weight:' . $font_weight;
        if ( $text_transform ) $rules[] = 'text-transform:' . $text_transform;
        if ( $letter_spacing ) $rules[] = 'letter-spacing:' . $letter_spacing;
        if ( $line_height )    $rules[] = 'line-height:' . $line_height;
        if ( $font_family )    $rules[] = 'font-family:"' . esc_attr( $font_family ) . '",sans-serif';
        if ( $border_radius )  $rules[] = 'border-radius:' . $border_radius;
        if ( $border_width && $border_type && $border_type !== 'none' ) {
            $rules[] = 'border-width:' . $border_width;
            $rules[] = 'border-style:' . $border_type;
        }
        if ( $border_color )   $rules[] = 'border-color:' . $border_color;

        $out = '';
        if ( ! empty( $rules ) ) $out .= $all . '{' . implode( ';', $rules ) . ';}';

        $prim = [];
        if ( $bg_color )   $prim[] = 'background-color:' . $bg_color;
        if ( $text_color ) $prim[] = 'color:' . $text_color;
        if ( ! empty( $prim ) ) $out .= $primary . '{' . implode( ';', $prim ) . ';}';

        $hp = [];
        if ( $hover_bg )     $hp[] = 'background-color:' . $hover_bg;
        if ( $hover_text )   $hp[] = 'color:' . $hover_text;
        if ( $hover_border ) $hp[] = 'border-color:' . $hover_border;
        if ( ! empty( $hp ) ) $out .= $primary_h . '{' . implode( ';', $hp ) . ';}';

        if ( $out === '' ) return;
        echo "\n<style id=\"adw-button-sync\">\n" . $out . "\n</style>\n";
    }
}
ADW_Button_Sync::init();
endif;

/* ── Global Button Radius & Padding CSS vars (Desktop / Tablet / Mobile) ── */
function adw_emit_btn_vars_css() {
    $r   = absint( get_option( 'adw_btn_radius', 8 ) );
    $pad = array_pad( array_map( 'absint', explode( ' ', get_option( 'adw_btn_padding', '14 28 14 28' ) ) ), 4, 0 );
    $desktop_css = $pad[0] . 'px ' . $pad[1] . 'px ' . $pad[2] . 'px ' . $pad[3] . 'px';

    $out  = ":root{--adw-btn-radius:{$r}px;--adw-btn-padding:{$desktop_css}}";

    $tablet_raw = get_option( 'adw_btn_padding_tablet', '' );
    if ( $tablet_raw !== '' ) {
        $tp = array_pad( array_map( 'absint', explode( ' ', $tablet_raw ) ), 4, 0 );
        $tp_css = $tp[0] . 'px ' . $tp[1] . 'px ' . $tp[2] . 'px ' . $tp[3] . 'px';
        $out .= "@media(max-width:1024px){:root{--adw-btn-padding:{$tp_css}}}";
    }
    $mobile_raw = get_option( 'adw_btn_padding_mobile', '' );
    if ( $mobile_raw !== '' ) {
        $mp = array_pad( array_map( 'absint', explode( ' ', $mobile_raw ) ), 4, 0 );
        $mp_css = $mp[0] . 'px ' . $mp[1] . 'px ' . $mp[2] . 'px ' . $mp[3] . 'px';
        $out .= "@media(max-width:640px){:root{--adw-btn-padding:{$mp_css}}}";
    }
    echo "<style id=\"adw-btn-vars\">{$out}</style>\n";
}
add_action( 'wp_head', 'adw_emit_btn_vars_css', 5 );
add_action( 'elementor/preview/enqueue_styles', 'adw_emit_btn_vars_css', 5 );

/* ── CSS Variables bridging Elementor Global Colors ── */
add_action( 'elementor/frontend/after_enqueue_styles', function () {
    ?>
    <style id="adw-global-vars">
        :root {
            --adw-primary:   var(--e-global-color-primary,   #cc1010);
            --adw-secondary: var(--e-global-color-secondary, #0d1b2a);
            --adw-text:      var(--e-global-color-text,      #111820);
            --adw-accent:    var(--e-global-color-accent,    #cc1010);
        }
    </style>
    <?php
} );
