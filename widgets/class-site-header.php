<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Site_Header extends \Elementor\Widget_Base {

    public function get_name()       { return 'cmp_site_header'; }
    public function get_title()      { return __( 'ADW — Site Header', 'arenex-digital-widgets' ); }
    public function get_icon()       { return 'eicon-header'; }
    public function get_categories() { return [ 'arenex-digital' ]; }
    public function get_keywords()   { return [ 'header', 'nav', 'navigation', 'menu', 'site' ]; }
    public function get_style_depends()  { return [ 'adw-styles' ]; }

    private function get_available_menus() {
        $menus   = wp_get_nav_menus();
        $options = [ '' => __( '— Select Menu —', 'arenex-digital-widgets' ) ];
        foreach ( $menus as $menu ) {
            $options[ $menu->slug ] = $menu->name;
        }
        return $options;
    }

    protected function register_controls() {

        /* ── Brand ── */
        $this->start_controls_section( 'sec_brand', [
            'label' => __( 'Brand', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'brand_part1', [
            'label'   => __( 'Brand Name Part 1', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Brand',
        ] );

        $this->add_control( 'brand_part2', [
            'label'   => __( 'Brand Name Part 2 (Accent)', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Name',
        ] );

        $this->add_control( 'logo_image', [
            'label' => __( 'Logo Image (optional)', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::MEDIA,
        ] );

        $this->add_responsive_control( 'logo_size', [
            'label'       => __( 'Logo Height', 'arenex-digital-widgets' ),
            'description' => __( 'Sets logo height. Width auto-scales to keep aspect ratio. This lets border-radius round the actual visible logo edges, not empty padding.', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::SLIDER,
            'size_units'  => [ 'px' ],
            'range'       => [ 'px' => [ 'min' => 20, 'max' => 300 ] ],
            'default'     => [ 'size' => 36, 'unit' => 'px' ],
            'selectors'   => [ '{{WRAPPER}} .cmp-sh-logo img' => 'height: {{SIZE}}{{UNIT}}; width: auto; max-width: 100%;' ],
        ] );

        $this->add_control( 'use_logo_width_override', [
            'label'        => __( 'Override Logo Width?', 'arenex-digital-widgets' ),
            'description'  => __( 'Off (default) = natural aspect ratio, width auto-calculates from Logo Height. On = force a specific width (use for square / circular logos with Cover fit).', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Force', 'arenex-digital-widgets' ),
            'label_off'    => __( 'Auto', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => '',
        ] );
        $this->add_responsive_control( 'logo_width_override', [
            'label'       => __( 'Logo Width Override', 'arenex-digital-widgets' ),
            'description' => __( 'Only applied when "Override Logo Width" is On above.', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::SLIDER,
            'size_units'  => [ 'px' ],
            'range'       => [ 'px' => [ 'min' => 20, 'max' => 600 ] ],
            'default'     => [ 'size' => 100, 'unit' => 'px' ],
            'selectors'   => [ '{{WRAPPER}} .cmp-sh-logo img' => 'width: {{SIZE}}{{UNIT}};' ],
            'condition'   => [ 'use_logo_width_override' => 'yes' ],
        ] );

        $this->add_control( 'logo_object_fit', [
            'label'       => __( 'Logo Image Fit', 'arenex-digital-widgets' ),
            'description' => __( 'How the image fits within the logo box. Use COVER for rectangular logos in a square box (will crop to fill). Use CONTAIN to fit inside without cropping.', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => 'contain',
            'options'     => [
                'contain'    => __( 'Contain — fit inside, no crop', 'arenex-digital-widgets' ),
                'cover'      => __( 'Cover — fill box, may crop', 'arenex-digital-widgets' ),
                'fill'       => __( 'Fill — stretch to fit', 'arenex-digital-widgets' ),
                'scale-down' => __( 'Scale Down', 'arenex-digital-widgets' ),
                'none'       => __( 'None — original size', 'arenex-digital-widgets' ),
            ],
            'selectors'   => [ '{{WRAPPER}} .cmp-sh-logo img' => 'object-fit: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'logo_border_radius', [
            'label'      => __( 'Logo Border Radius', 'arenex-digital-widgets' ),
            'description' => __( 'Round logo corners. Pair with Width Override (same as height) + Cover fit for a circular logo (use 50% radius).', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ], '%' => [ 'min' => 0, 'max' => 50 ] ],
            'default'    => [ 'size' => 0, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-sh-logo img' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_control( 'show_brand_text', [
            'label'        => __( 'Show Brand Text', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->end_controls_section();

        /* ── Navigation ── */
        $this->start_controls_section( 'sec_nav', [
            'label' => __( 'Navigation', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'menu_source', [
            'label'   => __( 'Menu Source', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'wp_menu' => __( 'WordPress Menu', 'arenex-digital-widgets' ),
                'custom'  => __( 'Custom Links', 'arenex-digital-widgets' ),
            ],
            'default' => 'wp_menu',
        ] );

        $this->add_control( 'wp_menu', [
            'label'       => __( 'Select Menu', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'options'     => $this->get_available_menus(),
            'default'     => '',
            'condition'   => [ 'menu_source' => 'wp_menu' ],
            'description' => __( 'Go to Appearance > Menus to manage menus.', 'arenex-digital-widgets' ),
        ] );

        $nav_rep = new \Elementor\Repeater();
        $nav_rep->add_control( 'label', [
            'label'       => __( 'Label', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => 'Link',
            'label_block' => true,
        ] );
        $nav_rep->add_control( 'url', [
            'label'   => __( 'URL', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '#' ],
        ] );

        $this->add_control( 'nav_links', [
            'label'     => __( 'Nav Links', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::REPEATER,
            'fields'    => $nav_rep->get_controls(),
            'default'   => [
                [ 'label' => 'Home',     'url' => [ 'url' => '/' ] ],
                [ 'label' => 'Services', 'url' => [ 'url' => '/services' ] ],
                [ 'label' => 'About',    'url' => [ 'url' => '/about' ] ],
                [ 'label' => 'Contact',  'url' => [ 'url' => '/contact' ] ],
            ],
            'title_field' => '{{{ label }}}',
            'condition'   => [ 'menu_source' => 'custom' ],
        ] );

        $this->add_control( 'mobile_submenu_behavior', [
            'label'       => __( 'Mobile Submenu Behavior', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => 'accordion',
            'options'     => [
                'accordion' => __( 'Accordion — collapsed by default, tap parent to open', 'arenex-digital-widgets' ),
                'expanded'  => __( 'Always expanded — show all submenus open', 'arenex-digital-widgets' ),
            ],
            'description' => __( 'How the mobile drawer handles menu items with children. Accordion is recommended when you have 5+ menu items.', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'desktop_show_arrow', [
            'label'        => __( 'Show Arrow on Desktop Parent Menu Items', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'description'  => __( 'Adds a small ▾ chevron next to menu items that have a submenu, so users know they can hover for more.', 'arenex-digital-widgets' ),
        ] );

        $this->end_controls_section();

        /* ── CTA Button ── */
        $this->start_controls_section( 'sec_cta', [
            'label' => __( 'CTA Button', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'show_cta', [
            'label'        => __( 'Show CTA Button', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_responsive_control( 'menu_alignment', [
            'label'        => __( 'Menu Alignment (when CTA hidden)', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::CHOOSE,
            'options'      => [
                'left'   => [ 'title' => __( 'Left',   'arenex-digital-widgets' ), 'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'arenex-digital-widgets' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right',  'arenex-digital-widgets' ), 'icon' => 'eicon-text-align-right' ],
            ],
            'default'      => 'right',
            'description'  => __( 'How to position the nav menu when the CTA button is hidden. Has no effect when CTA is visible.', 'arenex-digital-widgets' ),
            'condition'    => [ 'show_cta!' => 'yes' ],
        ] );

        $this->add_control( 'cta_text', [
            'label'     => __( 'Button Text', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => 'Get Started',
            'condition' => [ 'show_cta' => 'yes' ],
        ] );

        $this->add_control( 'cta_link', [
            'label'     => __( 'Button Link', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::URL,
            'default'   => [ 'url' => '/contact' ],
            'condition' => [ 'show_cta' => 'yes' ],
        ] );

        $this->add_control( 'cta_size', [
            'label'     => __( 'Button Size', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'default',
            'options'   => [
                'default' => __( 'Default — matches site buttons', 'arenex-digital-widgets' ),
                'small'   => __( 'Small — compact for header', 'arenex-digital-widgets' ),
            ],
            'condition' => [ 'show_cta' => 'yes' ],
        ] );

        /* Phone number (optional, beside CTA) */
        $this->add_control( 'show_phone', [
            'label'        => __( 'Show Phone Number', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'no',
        ] );
        $this->add_control( 'phone_text', [
            'label'     => __( 'Phone Display Text', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => '+1 123 456 7890',
            'condition' => [ 'show_phone' => 'yes' ],
        ] );
        $this->add_control( 'phone_link', [
            'label'       => __( 'Link', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::URL,
            'default'     => [ 'url' => '', 'is_external' => false, 'nofollow' => false ],
            'placeholder' => __( 'tel:1234567890 · mailto:hi@example.com · https://login.example.com', 'arenex-digital-widgets' ),
            'description' => __( 'Where the link goes. Use tel:1234567890 for phone, mailto:address for email, or any URL for login / external. Replaces the old "Phone Number" field — old saved values still work as fallback.', 'arenex-digital-widgets' ),
            'condition'   => [ 'show_phone' => 'yes' ],
        ] );
        $this->add_control( 'show_phone_icon', [
            'label'        => __( 'Show Icon', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Show', 'arenex-digital-widgets' ),
            'label_off'    => __( 'Hide', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'description'  => __( 'Toggle the default phone icon next to the text. Turn off when using this button for non-phone purposes (login, custom CTA).', 'arenex-digital-widgets' ),
            'condition'    => [ 'show_phone' => 'yes' ],
        ] );
        $this->add_control( 'phone_color', [
            'label'     => __( 'Phone Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'default'   => '#FFEB00',
            'selectors' => [ '{{WRAPPER}} .cmp-sh-phone' => 'color: {{VALUE}};' ],
            'condition' => [ 'show_phone' => 'yes' ],
        ] );

        $this->add_control( 'cta_icon', [
            'label'     => __( 'Button Icon', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::ICONS,
            'condition' => [ 'show_cta' => 'yes' ],
        ] );

        $this->add_control( 'cta_show_arrow', [
            'label'        => __( 'Show Arrow', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'description'  => __( 'Disable if you set a custom icon above, to avoid two icons showing at once.', 'arenex-digital-widgets' ),
            'condition'    => [ 'show_cta' => 'yes' ],
        ] );

        $this->end_controls_section();

        /* ═══════════════════════════════════
         *  CONTENT — Sticky / Scroll behavior
         * ═══════════════════════════════════ */
        $this->start_controls_section( 'sec_sticky', [
            'label' => __( 'Sticky Header', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'sticky_enable', [
            'label'        => __( 'Sticky Header', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'On', 'arenex-digital-widgets' ),
            'label_off'    => __( 'Off', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => '',
        ] );

        $this->add_control( 'sticky_mode', [
            'label'       => __( 'Sticky Behavior', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => 'smart',
            'options'     => [
                'always' => __( 'Always visible while scrolling', 'arenex-digital-widgets' ),
                'smart'  => __( 'Hide on scroll down, show on scroll up', 'arenex-digital-widgets' ),
            ],
            'description' => __( 'Smart mode slides the header up out of the way as you scroll down, then drops it back in the moment you scroll up.', 'arenex-digital-widgets' ),
            'condition'   => [ 'sticky_enable' => 'yes' ],
        ] );

        $this->add_control( 'sticky_offset', [
            'label'       => __( 'Activate After Scrolling (px)', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'min'         => 0,
            'max'         => 600,
            'step'        => 10,
            'default'     => 80,
            'description' => __( 'How far down the page before the sticky behavior kicks in.', 'arenex-digital-widgets' ),
            'condition'   => [ 'sticky_enable' => 'yes' ],
        ] );

        $this->add_control( 'sticky_bg', [
            'label'       => __( 'Background When Stuck', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::COLOR,
            'default'     => '',
            'description' => __( 'Optional — a solid/darker background once the header is stuck (great when the header starts transparent over a hero). Leave empty to keep the normal background.', 'arenex-digital-widgets' ),
            'selectors'   => [ '{{WRAPPER}} .cmp-sh.is-stuck' => 'background-color: {{VALUE}};' ],
            'condition'   => [ 'sticky_enable' => 'yes' ],
        ] );

        $this->add_control( 'sticky_shadow', [
            'label'        => __( 'Shadow When Stuck', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'On', 'arenex-digital-widgets' ),
            'label_off'    => __( 'Off', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => [ 'sticky_enable' => 'yes' ],
        ] );

        $this->end_controls_section();

        /* ═══════════════════════════════════
         *  STYLE — Header
         * ═══════════════════════════════════ */
        $this->start_controls_section( 'style_header', [
            'label' => __( 'Header Style', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'header_bg', [
            'label'     => __( 'Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(13,27,42,0.95)',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'header_glass', [
            'label'        => __( 'Glass / Blur Effect', 'arenex-digital-widgets' ),
            'description'  => __( 'Adds a frosted-glass blur behind the header. Pair with a translucent background color.', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'On', 'arenex-digital-widgets' ),
            'label_off'    => __( 'Off', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => '',
        ] );

        $this->add_control( 'header_glass_blur', [
            'label'      => __( 'Blur Amount', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
            'default'    => [ 'size' => 12, 'unit' => 'px' ],
            'condition'  => [ 'header_glass' => 'yes' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-sh.cmp-sh--glass' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
            ],
        ] );

        $this->add_responsive_control( 'header_border_radius', [
            'label'      => __( 'Header Border Radius', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'default'    => [ 'size' => 0, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-sh' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_control( 'nav_color', [
            'label'     => __( 'Nav Link Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'selectors' => [
                '{{WRAPPER}}'                   => '--cmp-nav-link-color: {{VALUE}};',
                '{{WRAPPER}} .cmp-sh-nav a'     => 'color: {{VALUE}};',
                '{{WRAPPER}} .cmp-sh-wp-menu a' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'nav_hover_color', [
            'label'     => __( 'Nav Hover Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#00B4D8',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [
                '{{WRAPPER}} .cmp-sh-nav a:hover'      => 'color: {{VALUE}};',
                '{{WRAPPER}} .cmp-sh-wp-menu a:hover'  => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'nav_active_color', [
            'label'       => __( 'Nav Active Color', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::COLOR,
            'default'     => '#00B4D8',
            'global'      => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'description' => __( 'Colour for the current page link. Hash/anchor scroll links are unaffected.', 'arenex-digital-widgets' ),
            'selectors'   => [
                '{{WRAPPER}} .cmp-sh-nav .current-menu-item > a:not([href*="#"])'      => 'color: {{VALUE}} !important;',
                '{{WRAPPER}} .cmp-sh-nav .current_page_item > a:not([href*="#"])'      => 'color: {{VALUE}} !important;',
                '{{WRAPPER}} .cmp-sh-wp-menu .current-menu-item > a:not([href*="#"])' => 'color: {{VALUE}} !important;',
                '{{WRAPPER}} .cmp-sh-wp-menu .current_page_item > a:not([href*="#"])' => 'color: {{VALUE}} !important;',
                '{{WRAPPER}} .cmp-sh-wp-menu .current-menu-ancestor > a:not([href*="#"])' => 'color: {{VALUE}} !important;',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'nav_typography',
            'label'    => __( 'Nav Typography', 'arenex-digital-widgets' ),
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-sh-nav a, {{WRAPPER}} .cmp-sh-wp-menu a',
        ] );

        $this->add_control( 'accent_color', [
            'label'     => __( 'Accent Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#00B4D8',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-brand-accent' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'brand_color', [
            'label'     => __( 'Brand Text Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-brand' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'brand_typography',
            'label'    => __( 'Brand Typography', 'arenex-digital-widgets' ),
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ],
            'selector' => '{{WRAPPER}} .cmp-sh-brand',
        ] );

        $this->add_control( 'dropdown_bg', [
            'label'     => __( 'Dropdown Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#0D1B2A',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-wp-menu .sub-menu' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'dropdown_border_color', [
            'label'     => __( 'Dropdown Border', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#1A3358',
            'selectors' => [ '{{WRAPPER}} .cmp-sh-wp-menu .sub-menu' => 'border-color: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'header_height', [
            'label'      => __( 'Header Height', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 48, 'max' => 120 ] ],
            'default'    => [ 'size' => 64, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-sh-inner' => 'height: {{SIZE}}{{UNIT}};',

            ],
        ] );

        $this->add_responsive_control( 'nav_gap', [
            'label'   => __( 'Nav Link Gap', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SLIDER,
            'range'   => [ 'px' => [ 'min' => 8, 'max' => 60 ] ],
            'default' => [ 'size' => 32 ],
            'selectors' => [
                '{{WRAPPER}} .cmp-sh-nav'       => 'gap: {{SIZE}}px;',
                '{{WRAPPER}} .cmp-sh-wp-menu > ul' => 'gap: {{SIZE}}px;',
            ],
        ] );

        $this->add_control( 'header_border_color', [
            'label'     => __( 'Bottom Border Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .cmp-sh' => 'border-bottom: 1px solid {{VALUE}};' ],
        ] );

        $this->end_controls_section();

        /* ═══════════════════════════════════
         *  STYLE — CTA Button
         * ═══════════════════════════════════ */
        $this->start_controls_section( 'style_cta', [
            'label'     => __( 'CTA Button', 'arenex-digital-widgets' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_cta' => 'yes' ],
        ] );

        $this->add_control( 'cta_bg_color', [
            'label'     => __( 'Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#00B4D8',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-cta' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'cta_text_color', [
            'label'     => __( 'Text Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-cta' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'cta_hover_bg', [
            'label'     => __( 'Hover Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-cta:hover' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'cta_hover_text', [
            'label'     => __( 'Hover Text Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-cta:hover' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'cta_icon_color', [
            'label'     => __( 'Icon Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cmp-sh-cta i'   => 'color: {{VALUE}};',
                '{{WRAPPER}} .cmp-sh-cta svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'cta_padding', [
            'label'      => __( 'Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-sh-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'cta_typo',
            'label'    => __( 'Typography', 'arenex-digital-widgets' ),
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ],
            'selector' => '{{WRAPPER}} .cmp-sh-cta',
        ] );
        $this->add_responsive_control( 'cta_min_width', [
            'label'   => __( 'Min Width', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SLIDER,
            'range'   => [ 'px' => [ 'min' => 0, 'max' => 300 ] ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-cta' => 'min-width: {{SIZE}}px; justify-content: center;' ],
        ] );

        $this->add_responsive_control( 'cta_radius', [
            'label'     => __( 'Border Radius', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
            'default'   => [ 'size' => 8 ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-cta' => 'border-radius: {{SIZE}}px;' ],
        ] );

        $this->end_controls_section();

        /* ═══════════════════════════════════
         *  STYLE — Mobile Menu
         * ═══════════════════════════════════ */
        $this->start_controls_section( 'style_mobile', [
            'label' => __( 'Mobile Menu', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'mobile_bg', [
            'label'     => __( 'Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(13,27,42,0.98)',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-overlay' => 'background: {{VALUE}};' ],
        ] );

        $this->add_control( 'mobile_text_color', [
            'label'     => __( 'Link Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-overlay a' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'mob_link_typography',
            'label'    => __( 'Link Typography', 'arenex-digital-widgets' ),
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-sh-overlay a:not(.cmp-sh-cta)',
        ] );

        $this->add_responsive_control( 'mobile_link_spacing', [
            'label'   => __( 'Link Spacing', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SLIDER,
            'range'   => [ 'px' => [ 'min' => 4, 'max' => 40 ] ],
            'default' => [ 'size' => 12 ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-overlay' => 'gap: {{SIZE}}px;' ],
        ] );

        $this->add_control( 'mobile_cta_fullwidth', [
            'label'        => __( 'Full-Width CTA', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'selectors'    => [ '{{WRAPPER}} .cmp-sh-overlay .cmp-sh-cta' => 'width: 100%; max-width: 300px; justify-content: center;' ],
        ] );

        $this->add_control( 'mob_cta_heading', [
            'label'     => __( 'Mobile CTA Button', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $this->add_control( 'mob_cta_color', [
            'label'     => __( 'Text Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-overlay .cmp-sh-cta' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'mob_cta_bg', [
            'label'     => __( 'Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-overlay .cmp-sh-cta' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'mob_cta_border_radius', [
            'label'      => __( 'Border Radius', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
            'selectors'  => [ '{{WRAPPER}} .cmp-sh-overlay .cmp-sh-cta' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_control( 'hamburger_color', [
            'label'     => __( 'Hamburger Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-hamburger' => 'color: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'hamburger_size', [
            'label'     => __( 'Hamburger Size', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 16, 'max' => 64 ] ],
            'default'   => [ 'size' => 28, 'unit' => 'px' ],
            'selectors' => [
                '{{WRAPPER}} .cmp-sh-hamburger svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
            ],
        ] );

        $this->add_responsive_control( 'close_size', [
            'label'     => __( 'Close Button (X) Size', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 16, 'max' => 64 ] ],
            'default'   => [ 'size' => 28, 'unit' => 'px' ],
            'selectors' => [
                '{{WRAPPER}} .cmp-sh-close svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
            ],
        ] );

        $this->add_responsive_control( 'close_padding', [
            'label'      => __( 'Close Button Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 32 ] ],
            'default'    => [ 'size' => 8, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-sh-close' => 'padding: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_control( 'close_bg', [
            'label'     => __( 'Close Button Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .cmp-sh-close' => 'background-color: {{VALUE}};' ],
        ] );
        $this->add_control( 'hamburger_bg', [
            'label'     => __( 'Hamburger Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-hamburger' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'hamburger_padding', [
            'label'      => __( 'Hamburger Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
            'selectors'  => [ '{{WRAPPER}} .cmp-sh-hamburger' => 'padding: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_control( 'hamburger_radius', [
            'label'      => __( 'Hamburger Border Radius', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
            'selectors'  => [ '{{WRAPPER}} .cmp-sh-hamburger' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_control( 'hamburger_hover_bg', [
            'label'     => __( 'Hamburger Hover Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-hamburger:hover' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'close_btn_color', [
            'label'     => __( 'Close Button Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-sh-close' => 'color: {{VALUE}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $wid = $this->get_id();
        $menu_id = 'cmp-sh-menu-' . $wid;
        $use_wp_menu = 'wp_menu' === $s['menu_source'] && ! empty( $s['wp_menu'] );
        ?>

        <?php
        $menu_align_cls = '';
        if ( 'yes' !== ( $s['show_cta'] ?? '' ) ) {
            $align = $s['menu_alignment'] ?? 'right';
            if ( in_array( $align, [ 'left', 'center', 'right' ], true ) ) {
                $menu_align_cls = ' cmp-sh--menu-' . $align;
            }
        }
        ?>
        <?php
        $sticky_on   = 'yes' === ( $s['sticky_enable'] ?? '' );
        $sticky_mode = in_array( ( $s['sticky_mode'] ?? 'smart' ), [ 'always', 'smart' ], true ) ? $s['sticky_mode'] : 'smart';
        $sticky_off  = isset( $s['sticky_offset'] ) && '' !== $s['sticky_offset'] ? absint( $s['sticky_offset'] ) : 80;
        $sticky_cls  = '';
        $sticky_attr = '';
        if ( $sticky_on ) {
            $sticky_cls  = ' cmp-sh--sticky cmp-sh--sticky-' . $sticky_mode;
            if ( 'yes' === ( $s['sticky_shadow'] ?? 'yes' ) ) {
                $sticky_cls .= ' cmp-sh--sticky-shadow';
            }
            $sticky_attr = ' data-cmp-sticky="' . esc_attr( $sticky_mode ) . '" data-sticky-offset="' . esc_attr( $sticky_off ) . '"';
        }
        ?>
        <nav class="cmp-sh cmp-sh-<?php echo esc_attr( $wid ); ?><?php echo ( 'yes' === ( $s['header_glass'] ?? '' ) ) ? ' cmp-sh--glass' : ''; ?><?php echo esc_attr( $menu_align_cls ); ?><?php echo esc_attr( $sticky_cls ); ?>"<?php echo $sticky_attr; ?>>
            <div class="cmp-sh-inner">
                <a href="/" class="cmp-sh-brand">
                    <?php if ( ! empty( $s['logo_image']['url'] ) ) : ?>
                        <span class="cmp-sh-logo"><img src="<?php echo esc_url( $s['logo_image']['url'] ); ?>" alt="<?php echo esc_attr( $s['brand_part1'] . ' ' . $s['brand_part2'] ); ?>"></span>
                    <?php endif; ?>
                    <?php if ( 'yes' === $s['show_brand_text'] ) : ?>
                        <span><?php echo esc_html( $s['brand_part1'] ); ?><span class="cmp-sh-brand-accent"><?php echo esc_html( $s['brand_part2'] ); ?></span></span>
                    <?php endif; ?>
                </a>

                <?php
                $show_arrow_class = ( ( $s['desktop_show_arrow'] ?? '' ) === 'yes' ) ? ' has-arrow' : '';
                ?>
                <?php if ( $use_wp_menu ) : ?>
                    <div class="cmp-sh-wp-menu<?php echo esc_attr( $show_arrow_class ); ?>">
                        <?php wp_nav_menu( [ 'menu' => $s['wp_menu'], 'container' => false, 'depth' => 3, 'fallback_cb' => false ] ); ?>
                    </div>
                <?php else : ?>
                    <div class="cmp-sh-nav<?php echo esc_attr( $show_arrow_class ); ?>">
                        <?php if ( ! empty( $s['nav_links'] ) ) :
                            foreach ( $s['nav_links'] as $link ) :
                                $url = $link['url']['url'] ?? '#';
                                $ext = ! empty( $link['url']['is_external'] ) ? ' target="_blank"' : '';
                        ?>
                            <a href="<?php echo esc_url( $url ); ?>"<?php echo $ext; ?>><?php echo esc_html( $link['label'] ); ?></a>
                        <?php endforeach; endif; ?>
                    </div>
                <?php endif; ?>

                <div class="cmp-sh-actions">
                    <?php if ( 'yes' === ( $s['show_phone'] ?? '' ) && ! empty( $s['phone_text'] ) ) :
                        // Build href: prefer phone_link URL, fall back to legacy tel: build.
                        $phone_href  = '';
                        $phone_extra = '';
                        if ( ! empty( $s['phone_link']['url'] ) ) {
                            $phone_href = $s['phone_link']['url'];
                            if ( ! empty( $s['phone_link']['is_external'] ) ) $phone_extra .= ' target="_blank"';
                            if ( ! empty( $s['phone_link']['nofollow'] ) )    $phone_extra .= ' rel="nofollow"';
                        } else {
                            $phone_digits = preg_replace( '/\D/', '', $s['phone_number'] ?? $s['phone_text'] );
                            $phone_href   = 'tel:' . $phone_digits;
                        }
                        $show_phone_icon = ( $s['show_phone_icon'] ?? 'yes' ) === 'yes';
                        $phone_icon_cls  = $show_phone_icon ? '' : ' no-icon';
                    ?>
                        <a href="<?php echo esc_url( $phone_href ); ?>"<?php echo $phone_extra; ?> class="cmp-sh-phone cmp-sh-phone-desktop<?php echo esc_attr( $phone_icon_cls ); ?>">
                            <?php if ( $show_phone_icon ) : ?>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 2.08 4.18 2 2 0 0 1 4.08 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            <?php endif; ?>
                            <?php echo esc_html( $s['phone_text'] ); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ( 'yes' === $s['show_cta'] && ! empty( $s['cta_text'] ) ) :
                        $cta_url       = $s['cta_link']['url'] ?? '#';
                        $cta_ext       = ! empty( $s['cta_link']['is_external'] ) ? ' target="_blank"' : '';
                        $cta_size      = $s['cta_size'] ?? 'default';
                        $cta_has_icon  = ! empty( $s['cta_icon']['value'] );
                        $cta_show_arr  = ( $s['cta_show_arrow'] ?? 'yes' ) === 'yes';
                        $cta_no_arrow  = ( ! $cta_show_arr ) ? ' cmp-sh-cta--no-arrow' : '';
                    ?>
                        <a href="<?php echo esc_url( $cta_url ); ?>"<?php echo $cta_ext; ?> class="cmp-sh-cta cmp-sh-cta--<?php echo esc_attr( $cta_size ); ?> cmp-sh-cta-desktop<?php echo esc_attr( $cta_no_arrow ); ?>">
                            <?php
                            if ( $cta_has_icon ) {
                                \Elementor\Icons_Manager::render_icon( $s['cta_icon'], [ 'aria-hidden' => 'true' ] );
                            }
                            echo esc_html( $s['cta_text'] );
                            ?>
                        </a>
                    <?php endif; ?>
                    <button class="cmp-sh-hamburger" aria-label="Open menu">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <line x1="3" y1="12" x2="21" y2="12"/>
                            <line x1="3" y1="18" x2="21" y2="18"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile overlay (drawer-style, matches prototype) -->
            <div id="<?php echo esc_attr( $menu_id ); ?>" class="cmp-sh-overlay">
                <div class="cmp-sh-overlay-head">
                    <?php if ( ! empty( $s['logo']['url'] ) ) : ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="cmp-sh-overlay-logo">
                            <img src="<?php echo esc_url( $s['logo']['url'] ); ?>" alt="" />
                        </a>
                    <?php endif; ?>
                    <button class="cmp-sh-close" aria-label="Close menu">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                            <line x1="6" y1="6" x2="18" y2="18"/>
                            <line x1="18" y1="6" x2="6" y2="18"/>
                        </svg>
                    </button>
                </div>
                <?php
                $sub_behav = $s['mobile_submenu_behavior'] ?? 'accordion';
                $overlay_links_class = 'cmp-sh-overlay-links';
                if ( $sub_behav === 'accordion' ) $overlay_links_class .= ' is-accordion';
                ?>
                <div class="<?php echo esc_attr( $overlay_links_class ); ?>">
                    <?php if ( $use_wp_menu ) :
                        wp_nav_menu( [ 'menu' => $s['wp_menu'], 'container' => false, 'depth' => 2, 'fallback_cb' => false ] );
                    else :
                        if ( ! empty( $s['nav_links'] ) ) :
                            foreach ( $s['nav_links'] as $link ) :
                                $url = $link['url']['url'] ?? '#';
                    ?>
                        <a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $link['label'] ); ?></a>
                    <?php endforeach; endif;
                    endif; ?>
                </div>
                <div class="cmp-sh-overlay-foot">
                    <?php if ( 'yes' === ( $s['show_phone'] ?? '' ) && ! empty( $s['phone_text'] ) ) :
                        // Same logic as desktop — prefer phone_link, fall back to legacy tel: build.
                        $phone_href  = '';
                        $phone_extra = '';
                        if ( ! empty( $s['phone_link']['url'] ) ) {
                            $phone_href = $s['phone_link']['url'];
                            if ( ! empty( $s['phone_link']['is_external'] ) ) $phone_extra .= ' target="_blank"';
                            if ( ! empty( $s['phone_link']['nofollow'] ) )    $phone_extra .= ' rel="nofollow"';
                        } else {
                            $phone_digits = preg_replace( '/\D/', '', $s['phone_number'] ?? $s['phone_text'] );
                            $phone_href   = 'tel:' . $phone_digits;
                        }
                    ?>
                        <a href="<?php echo esc_url( $phone_href ); ?>"<?php echo $phone_extra; ?> class="cmp-sh-phone no-icon">
                            <?php echo esc_html( $s['phone_text'] ); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ( 'yes' === $s['show_cta'] && ! empty( $s['cta_text'] ) ) :
                        $cta_url      = $s['cta_link']['url'] ?? '#';
                        $cta_has_icon = ! empty( $s['cta_icon']['value'] );
                        $cta_show_arr = ( $s['cta_show_arrow'] ?? 'yes' ) === 'yes';
                        $cta_no_arrow = ( ! $cta_show_arr ) ? ' cmp-sh-cta--no-arrow' : '';
                    ?>
                        <a href="<?php echo esc_url( $cta_url ); ?>" class="cmp-sh-cta cmp-sh-cta--default cmp-sh-cta--block<?php echo esc_attr( $cta_no_arrow ); ?>">
                            <?php
                            if ( $cta_has_icon ) {
                                \Elementor\Icons_Manager::render_icon( $s['cta_icon'], [ 'aria-hidden' => 'true' ] );
                            }
                            echo esc_html( $s['cta_text'] );
                            // Arrow is supplied by the global .cmp-sh-cta::after icon system (respects
                            // .cmp-sh-cta--no-arrow). Do NOT also echo a literal &rarr; here or the
                            // drawer CTA renders two arrows. (Desktop render correctly omits it.)
                            ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <?php
    }

    protected function content_template() {}
}
