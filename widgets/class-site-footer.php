<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Site_Footer extends \Elementor\Widget_Base {

    public function get_name()       { return 'cmp_site_footer'; }
    public function get_title()      { return __( 'ADW — Site Footer', 'arenex-digital-widgets' ); }
    public function get_icon()       { return 'eicon-footer'; }
    public function get_categories() { return [ 'arenex-digital' ]; }
    public function get_keywords()   { return [ 'footer', 'bottom', 'site', 'links', 'copyright' ]; }

    protected function register_controls() {

        /* ── Visibility Toggles ── */
        $this->start_controls_section( 'sec_visibility', [
            'label' => __( 'Visibility Toggles', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'show_tagline', [
            'label'        => __( 'Show Tagline', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'show_social', [
            'label'        => __( 'Show Social Icons', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'show_links', [
            'label'        => __( 'Show Link Columns', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'show_contact', [
            'label'        => __( 'Show Contact Column', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'show_copyright', [
            'label'        => __( 'Show Bottom Bar', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->end_controls_section();

        /* ── Brand Column ── */
        $this->start_controls_section( 'sec_brand', [
            'label' => __( 'Brand Column', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'brand_part1', [
            'label'   => __( 'Brand Part 1', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Brand',
        ] );

        $this->add_control( 'brand_part2', [
            'label'   => __( 'Brand Part 2 (Accent)', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Digital',
        ] );

        $this->add_control( 'logo_image', [
            'label' => __( 'Logo Image (optional)', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::MEDIA,
        ] );

        $this->add_responsive_control( 'logo_size', [
            'label'      => __( 'Logo Size', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 20, 'max' => 120 ] ],
            'default'    => [ 'size' => 40, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-sf-logo img' => 'width: {{SIZE}}{{UNIT}}; height: auto; max-height: none;',
            ],
        ] );

        $this->add_control( 'brand_tagline', [
            'label'     => __( 'Tagline', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXTAREA,
            'default'   => 'Premium WordPress + Elementor websites for ambitious brands. Built clean, fast, and conversion-ready.',
            'condition' => [ 'show_tagline' => 'yes' ],
        ] );

        $social_rep = new \Elementor\Repeater();
        $social_rep->add_control( 'icon', [
            'label'   => __( 'Icon', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value'   => 'fab fa-facebook-f',
                'library' => 'fa-brands',
            ],
        ] );
        $social_rep->add_control( 'url', [
            'label'   => __( 'URL', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '#' ],
        ] );

        $this->add_control( 'social_links', [
            'label'     => __( 'Social Links', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::REPEATER,
            'fields'    => $social_rep->get_controls(),
            'default'   => [
                [ 'icon' => [ 'value' => 'fab fa-facebook-f', 'library' => 'fa-brands' ], 'url' => [ 'url' => '#' ] ],
                [ 'icon' => [ 'value' => 'fab fa-instagram',  'library' => 'fa-brands' ], 'url' => [ 'url' => '#' ] ],
                [ 'icon' => [ 'value' => 'fab fa-youtube',    'library' => 'fa-brands' ], 'url' => [ 'url' => '#' ] ],
            ],
            'title_field' => '{{{ elementor.helpers.renderIcon( this, icon, {}, "i", "panel" ) || \'<i class="\' + icon.value + \'"></i>\' }}}',
            'condition'   => [ 'show_social' => 'yes' ],
        ] );

        $this->end_controls_section();

        /* ── Link Columns ── */
        $this->start_controls_section( 'sec_links', [
            'label'     => __( 'Link Columns', 'arenex-digital-widgets' ),
            'condition' => [ 'show_links' => 'yes' ],
        ] );

        $link_col_rep = new \Elementor\Repeater();
        $link_col_rep->add_control( 'col_title', [
            'label'   => __( 'Column Title', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Quick Links',
            'label_block' => true,
        ] );
        $link_col_rep->add_control( 'col_links', [
            'label'       => __( 'Links (Label | URL per line)', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => "Home | /\nServices | /services\nAbout | /about\nContact | /contact",
            'description' => __( 'One link per line: Label | URL', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'link_columns', [
            'label'   => __( 'Columns', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $link_col_rep->get_controls(),
            'default' => [
                [ 'col_title' => 'Services', 'col_links' => "Web Design | /services/web-design\nElementor Builds | /services/elementor\nSEO &amp; Performance | /services/seo\nMaintenance | /services/care" ],
                [ 'col_title' => 'Company', 'col_links' => "About | /about\nWork | /work\nProcess | /process\nContact | /contact" ],
            ],
            'title_field' => '{{{ col_title }}}',
        ] );

        $this->end_controls_section();

        /* ── Contact Column ── */
        $this->start_controls_section( 'sec_contact', [
            'label'     => __( 'Contact Column', 'arenex-digital-widgets' ),
            'condition' => [ 'show_contact' => 'yes' ],
        ] );

        $this->add_control( 'contact_title', [
            'label'   => __( 'Title', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Contact',
        ] );

        $this->add_control( 'contact_html', [
            'label'   => __( 'Contact Info (HTML)', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "Your Company\nhello@example.com\n+1 (000) 000-0000",
        ] );

        $this->add_control( 'hours_text', [
            'label'   => __( 'Hours (optional)', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "Mon–Fri: 9:00 AM – 6:00 PM\nWeekends: By appointment",
        ] );

        $this->end_controls_section();

        /* ── Bottom Bar ── */
        $this->start_controls_section( 'sec_bottom', [
            'label'     => __( 'Bottom Bar', 'arenex-digital-widgets' ),
            'condition' => [ 'show_copyright' => 'yes' ],
        ] );

        $this->add_control( 'copyright', [
            'label'       => __( 'Copyright Text', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'rows'        => 2,
            'default'     => '© 2026 Your Company. All rights reserved.',
            'label_block' => true,
            'description' => __( 'Plain text or HTML. Links are allowed, e.g. &lt;a href="https://example.com"&gt;Privacy&lt;/a&gt;.', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'bottom_right', [
            'label'       => __( 'Bottom Right Text', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'rows'        => 2,
            'default'     => '',
            'label_block' => true,
            'description' => __( 'Plain text or HTML. Make it clickable with a link, e.g. &lt;a href="https://arenexdigital.com/" target="_blank" rel="noopener"&gt;Built by Arenex Digital&lt;/a&gt;.', 'arenex-digital-widgets' ),
        ] );

        $this->end_controls_section();

        /* ── Style ── */
        $this->start_controls_section( 'style_footer', [
            'label' => __( 'Footer Style', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'footer_bg', [
            'label'     => __( 'Background Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#0d1b2a',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-sf' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), [
            'name'     => 'footer_bg_image',
            'label'    => __( 'Background Image / Gradient', 'arenex-digital-widgets' ),
            'types'    => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cmp-sf',
            'fields_options' => [
                'background' => [ 'default' => '' ],
            ],
        ] );

        $this->add_control( 'footer_bg_overlay', [
            'label'     => __( 'Background Overlay', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(0,0,0,0)',
            'description' => __( 'Optional dark overlay on top of background image.', 'arenex-digital-widgets' ),
            'selectors' => [ '{{WRAPPER}} .cmp-sf' => 'box-shadow: inset 0 0 0 9999px {{VALUE}};' ],
        ] );

        $this->add_control( 'footer_pattern', [
            'label'   => __( 'Pattern Overlay', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'none',
            'options' => [
                'none'     => __( 'None', 'arenex-digital-widgets' ),
                'dots'     => __( 'Dots', 'arenex-digital-widgets' ),
                'grid'     => __( 'Grid', 'arenex-digital-widgets' ),
                'diagonal' => __( 'Diagonal Lines', 'arenex-digital-widgets' ),
            ],
            'separator' => 'before',
        ] );

        $this->add_control( 'footer_pattern_opacity', [
            'label'      => __( 'Pattern Opacity (%)', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ '%' ],
            'range'      => [ '%' => [ 'min' => 1, 'max' => 100 ] ],
            'default'    => [ 'size' => 15, 'unit' => '%' ],
            'condition'  => [ 'footer_pattern!' => 'none' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-sf-pattern' => 'opacity: calc({{SIZE}} / 100);',
            ],
        ] );

        $this->add_control( '_div_brand', [ 'type' => \Elementor\Controls_Manager::DIVIDER ] );
        $this->add_control( '_h_brand', [
            'label' => __( 'Brand', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $this->add_control( 'brand_text_color', [
            'label'     => __( 'Brand Text Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-sf-brand' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'footer_accent', [
            'label'     => __( 'Brand Accent Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#C9A26B',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-sf-brand-accent' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'brand_typography',
            'label'    => __( 'Brand Typography', 'arenex-digital-widgets' ),
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ],
            'selector' => '{{WRAPPER}} .cmp-sf-brand',
        ] );

        $this->add_control( 'tagline_color', [
            'label'     => __( 'Tagline Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.65)',
            'selectors' => [ '{{WRAPPER}} .cmp-sf-tagline' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'tagline_typography',
            'label'    => __( 'Tagline Typography', 'arenex-digital-widgets' ),
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-sf-tagline',
        ] );

        $this->add_control( '_div_cols', [ 'type' => \Elementor\Controls_Manager::DIVIDER ] );
        $this->add_control( '_h_cols', [
            'label' => __( 'Column Headings', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $this->add_control( 'footer_heading_color', [
            'label'     => __( 'Column Heading Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-sf-col-title' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'col_title_typography',
            'label'    => __( 'Column Heading Typography', 'arenex-digital-widgets' ),
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ],
            'selector' => '{{WRAPPER}} .cmp-sf-col-title',
        ] );

        $this->add_control( '_div_links', [ 'type' => \Elementor\Controls_Manager::DIVIDER ] );
        $this->add_control( '_h_links', [
            'label' => __( 'Links', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $this->add_control( 'link_color', [
            'label'     => __( 'Link Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.65)',
            'selectors' => [ '{{WRAPPER}} .cmp-sf-links a' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'link_hover_color', [
            'label'     => __( 'Link Hover Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#C9A26B',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-sf-links a:hover' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'link_typography',
            'label'    => __( 'Link Typography', 'arenex-digital-widgets' ),
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-sf-links a',
        ] );

        $this->add_control( '_div_contact', [ 'type' => \Elementor\Controls_Manager::DIVIDER ] );
        $this->add_control( '_h_contact', [
            'label' => __( 'Contact / Hours', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $this->add_control( 'contact_color', [
            'label'     => __( 'Contact Text Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.65)',
            'selectors' => [
                '{{WRAPPER}} .cmp-sf-contact' => 'color: {{VALUE}};',
                '{{WRAPPER}} .cmp-sf-contact a' => 'color: {{VALUE}};',
                '{{WRAPPER}} .cmp-sf-hours' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'contact_hover_color', [
            'label'     => __( 'Contact Link Hover', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#C9A26B',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-sf-contact a:hover' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'contact_typography',
            'label'    => __( 'Contact Typography', 'arenex-digital-widgets' ),
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-sf-contact, {{WRAPPER}} .cmp-sf-hours',
        ] );

        $this->add_control( '_div_social', [ 'type' => \Elementor\Controls_Manager::DIVIDER ] );
        $this->add_control( '_h_social', [
            'label' => __( 'Social Icons', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $this->add_control( 'social_icon_color', [
            'label'     => __( 'Social Icon Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.6)',
            'selectors' => [
                '{{WRAPPER}} .cmp-sf-social a'     => 'color: {{VALUE}};',
                '{{WRAPPER}} .cmp-sf-social a svg' => 'fill: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'social_icon_hover', [
            'label'     => __( 'Social Icon Hover', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#C9A26B',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [
                '{{WRAPPER}} .cmp-sf-social a:hover'     => 'color: {{VALUE}};',
                '{{WRAPPER}} .cmp-sf-social a:hover svg' => 'fill: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'social_icon_size', [
            'label'      => __( 'Icon Size', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 10, 'max' => 48 ] ],
            'default'    => [ 'size' => 16, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-sf-social a'           => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cmp-sf-social a svg'       => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cmp-sf-social a i'         => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_control( '_div_bottom', [ 'type' => \Elementor\Controls_Manager::DIVIDER ] );
        $this->add_control( '_h_bottom', [
            'label' => __( 'Bottom Bar', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $this->add_control( 'bottom_color', [
            'label'     => __( 'Bottom Text Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.5)',
            'selectors' => [
                '{{WRAPPER}} .cmp-sf-bottom' => 'color: {{VALUE}};',
                '{{WRAPPER}} .cmp-sf-bottom a' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'bottom_typography',
            'label'    => __( 'Bottom Typography', 'arenex-digital-widgets' ),
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-sf-bottom',
        ] );

        $this->add_control( 'divider_color', [
            'label'     => __( 'Divider Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.1)',
            'selectors' => [ '{{WRAPPER}} .cmp-sf-bottom, {{WRAPPER}} .cmp-sf-divider' => 'border-top-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'footer_text_color', [
            'label'     => __( 'Default Text Color (Fallback)', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.6)',
            'separator' => 'before',
            'selectors' => [ '{{WRAPPER}} .cmp-sf' => 'color: {{VALUE}};' ],
        ] );

        $this->end_controls_section();

        /* ── STYLE: Spacing ── */
        $this->start_controls_section( 'style_spacing', [
            'label' => __( 'Spacing', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_responsive_control( 'footer_padding', [
            'label' => __( 'Footer Padding', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'selectors' => [ '{{WRAPPER}} .cmp-sf' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'grid_gap', [
            'label' => __( 'Column Gap', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [ 'px' => [ 'min' => 0, 'max' => 100 ] ], 'default' => [ 'size' => 48 ],
            'selectors' => [ '{{WRAPPER}} .cmp-sf-grid' => 'gap: {{SIZE}}px;' ],
        ] );
        $this->add_responsive_control( 'col_title_spacing', [
            'label' => __( 'Column Title Spacing', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors' => [ '{{WRAPPER}} .cmp-sf-col-title' => 'margin-bottom: {{SIZE}}px;' ],
        ] );
        $this->add_responsive_control( 'links_gap', [
            'label' => __( 'Links Gap', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
            'selectors' => [ '{{WRAPPER}} .cmp-sf-links' => 'gap: {{SIZE}}px;' ],
        ] );
        $this->add_responsive_control( 'social_gap', [
            'label' => __( 'Social Icons Gap', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
            'selectors' => [ '{{WRAPPER}} .cmp-sf-social' => 'gap: {{SIZE}}px;' ],
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $wid = $this->get_id();

        $show_tagline   = 'yes' === $s['show_tagline'];
        $show_social    = 'yes' === $s['show_social'];
        $show_links     = 'yes' === $s['show_links'];
        $show_contact   = 'yes' === $s['show_contact'];
        $show_copyright = 'yes' === $s['show_copyright'];

        // Calculate grid columns based on visible sections.
        $link_col_count = $show_links ? count( $s['link_columns'] ?? [] ) : 0;
        $grid_cols      = [];
        $grid_cols[]    = '1.5fr'; // Brand column is always visible.
        for ( $i = 0; $i < $link_col_count; $i++ ) {
            $grid_cols[] = '1fr';
        }
        if ( $show_contact ) {
            $grid_cols[] = '1.2fr';
        }
        $grid_template = implode( ' ', $grid_cols );
        $footer_pattern = $s['footer_pattern'] ?? 'none';
        ?>
        <footer class="cmp-sf" style="--cmp-sf-cols:<?php echo esc_attr( $grid_template ); ?>">
            <?php if ( 'none' !== $footer_pattern ) : ?>
            <div class="cmp-sf-pattern cmp-sf-pattern--<?php echo esc_attr( $footer_pattern ); ?>"></div>
            <?php endif; ?>
            <div class="cmp-sf-inner">
                <div class="cmp-sf-grid">

                    <!-- Brand Column -->
                    <div class="cmp-sf-brand-col">
                        <div class="cmp-sf-brand">
                            <?php if ( ! empty( $s['logo_image']['url'] ) ) : ?>
                                <span class="cmp-sf-logo"><img src="<?php echo esc_url( $s['logo_image']['url'] ); ?>" alt=""></span>
                            <?php endif; ?>
                            <span><?php echo esc_html( $s['brand_part1'] ); ?><span class="cmp-sf-brand-accent"><?php echo esc_html( $s['brand_part2'] ); ?></span></span>
                        </div>
                        <?php if ( $show_tagline && ! empty( $s['brand_tagline'] ) ) : ?>
                            <p class="cmp-sf-tagline"><?php echo wp_kses( $s['brand_tagline'], [ 'br' => [], 'strong' => [], 'em' => [], 'a' => [ 'href' => [], 'target' => [], 'rel' => [] ] ] ); ?></p>
                        <?php endif; ?>
                        <?php if ( $show_social && ! empty( $s['social_links'] ) ) : ?>
                            <div class="cmp-sf-social">
                                <?php foreach ( $s['social_links'] as $soc ) :
                                    $soc_url = $soc['url']['url'] ?? '#';
                                    $target  = ! empty( $soc['url']['is_external'] ) ? ' target="_blank"' : '';
                                    $nofollow = ! empty( $soc['url']['nofollow'] ) ? ' rel="nofollow"' : '';
                                ?>
                                    <a href="<?php echo esc_url( $soc_url ); ?>"<?php echo $target . $nofollow; ?>><?php \Elementor\Icons_Manager::render_icon( $soc['icon'], [ 'aria-hidden' => 'true' ] ); ?></a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ( $show_links && ! empty( $s['link_columns'] ) ) :
                        foreach ( $s['link_columns'] as $col ) : ?>
                        <!-- Link Column -->
                        <div>
                            <div class="cmp-sf-col-title"><?php echo esc_html( $col['col_title'] ); ?></div>
                            <ul class="cmp-sf-links">
                                <?php
                                $lines = explode( "\n", $col['col_links'] );
                                foreach ( $lines as $line ) :
                                    $line = trim( $line );
                                    if ( empty( $line ) ) continue;
                                    $parts = array_map( 'trim', explode( '|', $line, 2 ) );
                                    $label = $parts[0];
                                    $url   = $parts[1] ?? '#';
                                ?>
                                    <li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; endif; ?>

                    <?php if ( $show_contact ) : ?>
                    <!-- Contact Column -->
                    <div>
                        <?php if ( ! empty( $s['contact_title'] ) ) : ?>
                            <div class="cmp-sf-col-title"><?php echo esc_html( $s['contact_title'] ); ?></div>
                        <?php endif; ?>
                        <?php if ( ! empty( $s['contact_html'] ) ) : ?>
                            <div class="cmp-sf-contact"><?php
                                $contact_out = nl2br( esc_html( $s['contact_html'] ) );
                                // auto-link email addresses
                                $contact_out = preg_replace_callback(
                                    '/[\w.\-+]+@[\w\-]+\.[\w\-.]+/',
                                    function ( $m ) { return '<a href="mailto:' . esc_attr( $m[0] ) . '">' . $m[0] . '</a>'; },
                                    $contact_out
                                );
                                // auto-link phone / fax numbers (10-digit US formats)
                                $contact_out = preg_replace_callback(
                                    '/\(?\d{3}\)?[\s.\-]?\d{3}[\s.\-]?\d{4}/',
                                    function ( $m ) {
                                        $digits = preg_replace( '/\D/', '', $m[0] );
                                        return '<a href="tel:' . $digits . '">' . $m[0] . '</a>';
                                    },
                                    $contact_out
                                );
                                echo $contact_out;
                            ?></div>
                        <?php endif; ?>
                        <?php if ( ! empty( $s['hours_text'] ) ) : ?>
                            <div class="cmp-sf-hours"><?php echo esc_html( $s['hours_text'] ); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                </div>

                <?php if ( $show_copyright ) : ?>
                <!-- Bottom bar -->
                <div class="cmp-sf-bottom">
                    <span>&copy; <?php echo wp_kses_post( $s['copyright'] ); ?></span>
                    <?php if ( ! empty( $s['bottom_right'] ) ) : ?>
                        <span><?php echo wp_kses_post( $s['bottom_right'] ); ?></span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </footer>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        var showTagline   = 'yes' === settings.show_tagline,
            showSocial    = 'yes' === settings.show_social,
            showLinks     = 'yes' === settings.show_links,
            showContact   = 'yes' === settings.show_contact,
            showCopyright = 'yes' === settings.show_copyright;

        var gridCols = ['1.5fr'];
        if ( showLinks && settings.link_columns ) {
            _.each( settings.link_columns, function() { gridCols.push('1fr'); });
        }
        if ( showContact ) {
            gridCols.push('1.2fr');
        }
        var gridTemplate = gridCols.join(' ');
        #>
        <footer class="cmp-sf">
            <div class="cmp-sf-inner" style="max-width:1200px;margin:0 auto;">
                <div class="cmp-sf-grid" style="display:grid;grid-template-columns:{{{ gridTemplate }}};gap:3rem;padding-bottom:3rem;border-bottom:1px solid rgba(255,255,255,0.1);">

                    <div class="cmp-sf-brand-col">
                        <div class="cmp-sf-brand" style="font-family:'Barlow Condensed',sans-serif;font-size:1.5rem;font-weight:700;color:#fff;margin-bottom:.75rem;display:flex;align-items:center;gap:.5rem;">
                            <# if ( settings.logo_image && settings.logo_image.url ) { #>
                                <span class="cmp-sf-logo"><img src="{{{ settings.logo_image.url }}}" alt="" style="width:40px;height:40px;object-fit:contain;"></span>
                            <# } #>
                            <span>{{{ settings.brand_part1 }}}<span class="cmp-sf-brand-accent">{{{ settings.brand_part2 }}}</span></span>
                        </div>
                        <# if ( showTagline && settings.brand_tagline ) { #>
                            <p class="cmp-sf-tagline" style="font-size:.85rem;line-height:1.7;margin-bottom:1.25rem;">{{{ settings.brand_tagline }}}</p>
                        <# } #>
                        <# if ( showSocial && settings.social_links && settings.social_links.length ) { #>
                            <div class="cmp-sf-social" style="display:flex;gap:.75rem;">
                                <# _.each( settings.social_links, function( soc ) {
                                    var iconHtml = elementor.helpers.renderIcon( view, soc.icon, { 'aria-hidden': 'true' }, 'i', 'object' );
                                    var url = ( soc.url && soc.url.url ) ? soc.url.url : '#';
                                #>
                                    <a href="{{{ url }}}" style="text-decoration:none;font-size:1.1rem;">{{{ iconHtml ? iconHtml.value : '' }}}</a>
                                <# }); #>
                            </div>
                        <# } #>
                    </div>

                    <# if ( showLinks && settings.link_columns && settings.link_columns.length ) {
                        _.each( settings.link_columns, function( col ) { #>
                        <div>
                            <div class="cmp-sf-col-title" style="font-family:'Barlow Condensed',sans-serif;font-size:1rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;margin-bottom:1rem;">{{{ col.col_title }}}</div>
                            <ul class="cmp-sf-links" style="list-style:none;padding:0;margin:0;">
                                <# var lines = col.col_links.split("\n");
                                _.each( lines, function( line ) {
                                    line = line.trim();
                                    if ( ! line ) return;
                                    var parts = line.split('|');
                                    var label = parts[0] ? parts[0].trim() : '';
                                    var url   = parts[1] ? parts[1].trim() : '#';
                                #>
                                    <li style="margin-bottom:.6rem;"><a href="{{{ url }}}" style="text-decoration:none;font-size:.85rem;">{{{ label }}}</a></li>
                                <# }); #>
                            </ul>
                        </div>
                    <# }); } #>

                    <# if ( showContact ) { #>
                    <div>
                        <# if ( settings.contact_title ) { #>
                            <div class="cmp-sf-col-title" style="font-family:'Barlow Condensed',sans-serif;font-size:1rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;margin-bottom:1rem;">{{{ settings.contact_title }}}</div>
                        <# } #>
                        <# if ( settings.contact_html ) { #>
                            <div class="cmp-sf-contact" style="font-size:.85rem;line-height:1.7;white-space:pre-line;margin-bottom:1rem;">{{{ settings.contact_html }}}</div>
                        <# } #>
                        <# if ( settings.hours_text ) { #>
                            <div class="cmp-sf-hours" style="font-size:.8rem;line-height:1.7;white-space:pre-line;opacity:.7;">{{{ settings.hours_text }}}</div>
                        <# } #>
                    </div>
                    <# } #>

                </div>

                <# if ( showCopyright ) { #>
                <div class="cmp-sf-bottom" style="display:flex;justify-content:space-between;align-items:center;padding:1.5rem 0;font-size:.75rem;opacity:.5;">
                    <span>&copy; {{{ settings.copyright }}}</span>
                    <# if ( settings.bottom_right ) { #>
                        <span>{{{ settings.bottom_right }}}</span>
                    <# } #>
                </div>
                <# } #>
            </div>
        </footer>
        <?php
    }
}
