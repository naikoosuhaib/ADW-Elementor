<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Services_Grid extends \Elementor\Widget_Base {

    public function get_name()       { return 'cmp_services_grid'; }
    public function get_title()      { return __( 'ADW — Services Grid', 'arenex-digital-widgets' ); }
    public function get_icon()       { return 'eicon-gallery-grid'; }
    public function get_categories() { return [ 'arenex-digital' ]; }
    public function get_style_depends()  { return [ 'adw-styles' ]; }
    public function get_script_depends() { return [ 'adw-front' ]; }

    protected function register_controls() {

        /* ══════════════════════════════════════════
           CONTENT TAB — Layout
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'section_layout', [
            'label' => __( 'Layout', 'arenex-digital-widgets' ),
        ] );

        $this->add_responsive_control( 'columns', [
            'label'          => __( 'Columns', 'arenex-digital-widgets' ),
            'type'           => \Elementor\Controls_Manager::NUMBER,
            'min'            => 1,
            'max'            => 4,
            'default'        => 2,
            'tablet_default' => 2,
            'mobile_default' => 1,
            'selectors'      => [
                '{{WRAPPER}} .cmp-services-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ] );

        $this->add_control( 'image_position', [
            'label'   => __( 'Image Position', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'top',
            'options' => [
                'top'    => __( 'Top', 'arenex-digital-widgets' ),
                'left'   => __( 'Left', 'arenex-digital-widgets' ),
                'right'  => __( 'Right', 'arenex-digital-widgets' ),
                'bottom' => __( 'Bottom', 'arenex-digital-widgets' ),
                'none'   => __( 'None', 'arenex-digital-widgets' ),
            ],
        ] );

        $this->add_control( 'hover_style', [
            'label'       => __( 'Hover Effect', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => 'top-line',
            'options'     => [
                'top-line'     => __( 'Top Accent Line', 'arenex-digital-widgets' ),
                'lift'         => __( 'Lift (translate up)', 'arenex-digital-widgets' ),
                'overlay-fill' => __( 'Overlay Fill (color invert)', 'arenex-digital-widgets' ),
                'border-glow'  => __( 'Border Glow', 'arenex-digital-widgets' ),
                'none'         => __( 'None', 'arenex-digital-widgets' ),
            ],
            'description' => __( '"Overlay Fill" inverts the card colors on hover (e.g. white/dark → yellow/black).', 'arenex-digital-widgets' ),
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           CONTENT TAB — Cards
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'section_cards', [
            'label' => __( 'Cards', 'arenex-digital-widgets' ),
        ] );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control( 'image', [
            'label' => __( 'Image', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::MEDIA,
        ] );

        $repeater->add_control( 'icon', [
            'label'   => __( 'Icon', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::ICONS,
            'default' => [ 'value' => 'fas fa-network-wired', 'library' => 'fa-solid' ],
        ] );

        $repeater->add_control( 'title', [
            'label'   => __( 'Title', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Service Title', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'description', [
            'label'   => __( 'Description', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __( 'Service description.', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'features', [
            'label'       => __( 'Features (one per line)', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => "Feature 1\nFeature 2\nFeature 3",
            'description' => __( 'Enter one feature per line.', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'link_text', [
            'label'   => __( 'Link Text', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Learn More', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'link_url', [
            'label'       => __( 'Link URL', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::URL,
            'placeholder' => 'https://example.com',
            'default'     => [ 'url' => '' ],
        ] );

        $this->add_control( 'cards', [
            'label'   => __( 'Service Cards', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [
                    'icon'        => [ 'value' => 'fas fa-network-wired', 'library' => 'fa-solid' ],
                    'title'       => __( 'Network & Cabling', 'arenex-digital-widgets' ),
                    'description' => __( 'Enterprise-grade structured cabling and network infrastructure for businesses of all sizes.', 'arenex-digital-widgets' ),
                    'features'    => "Cat6/Cat6a Cabling\nServer Room Setup\nNetwork Design",
                    'link_text'   => __( 'Learn More', 'arenex-digital-widgets' ),
                    'link_url'    => [ 'url' => '' ],
                ],
                [
                    'icon'        => [ 'value' => 'fas fa-shield-alt', 'library' => 'fa-solid' ],
                    'title'       => __( 'Security Systems', 'arenex-digital-widgets' ),
                    'description' => __( 'Commercial and residential security camera installation with remote monitoring.', 'arenex-digital-widgets' ),
                    'features'    => "IP Camera Systems\nAccess Control\n24/7 Monitoring",
                    'link_text'   => __( 'Learn More', 'arenex-digital-widgets' ),
                    'link_url'    => [ 'url' => '' ],
                ],
                [
                    'icon'        => [ 'value' => 'fas fa-tv', 'library' => 'fa-solid' ],
                    'title'       => __( 'AV Installation', 'arenex-digital-widgets' ),
                    'description' => __( 'Professional audio visual solutions for conference rooms, churches, and commercial spaces.', 'arenex-digital-widgets' ),
                    'features'    => "Conference Rooms\nDigital Signage\nSound Systems",
                    'link_text'   => __( 'Learn More', 'arenex-digital-widgets' ),
                    'link_url'    => [ 'url' => '' ],
                ],
                [
                    'icon'        => [ 'value' => 'fas fa-tools', 'library' => 'fa-solid' ],
                    'title'       => __( 'Maintenance & Support', 'arenex-digital-widgets' ),
                    'description' => __( 'Ongoing maintenance and support to keep your systems running smoothly.', 'arenex-digital-widgets' ),
                    'features'    => "Preventive Maintenance\nTroubleshooting\nSystem Upgrades",
                    'link_text'   => __( 'Learn More', 'arenex-digital-widgets' ),
                    'link_url'    => [ 'url' => '' ],
                ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           CONTENT TAB — Element Visibility
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'section_visibility', [
            'label' => __( 'Element Visibility', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'show_image', [
            'label'        => __( 'Show Image', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'show_icon', [
            'label'        => __( 'Show Icon', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'show_description', [
            'label'        => __( 'Show Description', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'show_features', [
            'label'        => __( 'Show Features', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'show_link', [
            'label'        => __( 'Show Link', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           STYLE TAB — Section Header
           ══════════════════════════════════════════ */
        /* ══════════════════════════════════════════
           STYLE TAB — Card Style
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'style_card', [
            'label' => __( 'Card Style', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'card_bg', [
            'label'     => __( 'Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .cmp-service-card' => 'background: {{VALUE}};' ],
        ] );

        $this->add_control( 'card_border_color', [
            'label'     => __( 'Border Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#E5E7EB',
            'selectors' => [ '{{WRAPPER}} .cmp-service-card' => 'border-color: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'card_border_width', [
            'label'      => __( 'Border Width', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 8 ] ],
            'default'    => [ 'size' => 1, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-service-card' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;' ],
        ] );

        $this->add_control( 'hover_card_border_color', [
            'label'     => __( 'Hover Border Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'default'   => '#FFEB00',
            'selectors' => [ '{{WRAPPER}} .cmp-service-card:hover' => 'border-color: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'card_border_radius', [
            'label'      => __( 'Border Radius', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
            'default'    => [ 'size' => 16, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-service-card' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'card_padding', [
            'label'      => __( 'Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'default'    => [
                'top'      => '36',
                'right'    => '36',
                'bottom'   => '36',
                'left'     => '36',
                'unit'     => 'px',
                'isLinked' => true,
            ],
            'selectors' => [ '{{WRAPPER}} .cmp-service-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_shadow',
            'selector' => '{{WRAPPER}} .cmp-service-card:hover',
        ] );

        /* ── Hover-specific controls (conditional on hover_style) ── */
        $this->add_control( 'hover_bg_color', [
            'label'     => __( 'Hover Background Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#FFEB00',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-service-hover-overlay-fill .cmp-service-card:hover' => 'background-color: {{VALUE}} !important;' ],
            'condition' => [ 'hover_style' => 'overlay-fill' ],
        ] );

        $this->add_control( 'hover_text_color', [
            'label'     => __( 'Hover Text Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#0D0D0D',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [
                '{{WRAPPER}} .cmp-service-hover-overlay-fill .cmp-service-card:hover .cmp-service-card-title,
                 {{WRAPPER}} .cmp-service-hover-overlay-fill .cmp-service-card:hover .cmp-service-card-desc,
                 {{WRAPPER}} .cmp-service-hover-overlay-fill .cmp-service-card:hover .cmp-service-link,
                 {{WRAPPER}} .cmp-service-hover-overlay-fill .cmp-service-card:hover .cmp-service-features li,
                 {{WRAPPER}} .cmp-service-hover-overlay-fill .cmp-service-card:hover .cmp-service-icon' => 'color: {{VALUE}} !important;',
            ],
            'condition' => [ 'hover_style' => 'overlay-fill' ],
        ] );

        $this->add_control( 'hover_glow_color', [
            'label'     => __( 'Hover Glow / Border Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#FFEB00',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-service-hover-border-glow .cmp-service-card:hover' => 'border-color: {{VALUE}}; box-shadow: 0 0 0 2px {{VALUE}};' ],
            'condition' => [ 'hover_style' => 'border-glow' ],
        ] );

        $this->add_control( 'hover_lift_amount', [
            'label'     => __( 'Lift Amount (px)', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
            'default'   => [ 'size' => 6, 'unit' => 'px' ],
            'selectors' => [ '{{WRAPPER}} .cmp-service-hover-lift .cmp-service-card:hover' => 'transform: translateY(-{{SIZE}}{{UNIT}});' ],
            'condition' => [ 'hover_style' => 'lift' ],
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           STYLE TAB — Image Style
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'style_image', [
            'label'     => __( 'Image Style', 'arenex-digital-widgets' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_image' => 'yes' ],
        ] );

        $this->add_responsive_control( 'image_height', [
            'label'      => __( 'Image Height', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 50, 'max' => 600 ] ],
            'default'    => [ 'size' => 200, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-service-card-img, {{WRAPPER}} .cmp-service-card-img img' => 'height: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'image_radius', [
            'label'      => __( 'Image Border Radius', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'description' => __( 'Per-corner control. Top-right + top-left for image-top layouts; bottom-right + bottom-left for image-bottom; etc.', 'arenex-digital-widgets' ),
            'selectors'  => [
                '{{WRAPPER}} .cmp-service-card-img,
                 {{WRAPPER}} .cmp-service-card-img img' =>
                    'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'image_zoom_on_hover', [
            'label'        => __( 'Zoom Image on Card Hover', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
            'description'  => __( 'Subtle 5% scale on the card image when hovering. Adds movement to the cards.', 'arenex-digital-widgets' ),
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           STYLE TAB — Icon Style
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'style_icon', [
            'label'     => __( 'Icon Style', 'arenex-digital-widgets' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_icon' => 'yes' ],
        ] );

        $this->add_control( 'icon_bg', [
            'label'     => __( 'Icon Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'default'   => 'rgba(0, 180, 216, 0.15)',
            'selectors' => [ '{{WRAPPER}} .cmp-service-icon' => 'background: {{VALUE}};' ],
        ] );

        $this->add_control( 'icon_color', [
            'label'     => __( 'Icon Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'default'   => '#00B4D8',
            'selectors' => [
                '{{WRAPPER}} .cmp-service-icon i'   => 'color: {{VALUE}};',
                '{{WRAPPER}} .cmp-service-icon svg' => 'fill: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'icon_size', [
            'label'      => __( 'Icon Box Size', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 20, 'max' => 150 ] ],
            'default'    => [ 'size' => 56, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-service-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           STYLE TAB — Title Style
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'style_card_title', [
            'label' => __( 'Title Style', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'card_title_color', [
            'label'     => __( 'Title Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'default'   => '#111827',
            'selectors' => [ '{{WRAPPER}} .cmp-service-card-title' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'card_title_typo',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ],
            'selector' => '{{WRAPPER}} .cmp-service-card-title',
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           STYLE TAB — Description Style
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'style_card_desc', [
            'label' => __( 'Description Style', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'card_desc_color', [
            'label'     => __( 'Description Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'default'   => '#6B7280',
            'selectors' => [ '{{WRAPPER}} .cmp-service-card-desc' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'card_desc_typo',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-service-card-desc',
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           STYLE TAB — Features Style
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'style_features', [
            'label'     => __( 'Features Style', 'arenex-digital-widgets' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_features' => 'yes' ],
        ] );

        $this->add_control( 'feature_color', [
            'label'     => __( 'Feature Text Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'default'   => '#374151',
            'selectors' => [ '{{WRAPPER}} .cmp-service-features li' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'feature_bullet_color', [
            'label'     => __( 'Bullet Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'default'   => '#00B4D8',
            'selectors' => [ '{{WRAPPER}} .cmp-service-features li::before' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'feature_bullet_hover_color', [
            'label'     => __( 'Bullet Hover Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-service-card:hover .cmp-service-features li::before' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'feature_typo',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-service-features li',
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           STYLE TAB — Link Style
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'style_link', [
            'label'     => __( 'Link Style', 'arenex-digital-widgets' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_link' => 'yes' ],
        ] );

        $this->add_control( 'link_color', [
            'label'     => __( 'Link Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'default'   => '#00B4D8',
            'selectors' => [ '{{WRAPPER}} .cmp-service-link' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'link_hover_color', [
            'label'     => __( 'Link Hover Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-service-link:hover' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'link_typo',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ],
            'selector' => '{{WRAPPER}} .cmp-service-link',
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           STYLE TAB — Grid Style
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'style_grid', [
            'label' => __( 'Grid Style', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Grid Gap', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
            'default'    => [ 'size' => 24, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-services-grid' => 'gap: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           STYLE TAB — Spacing
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'style_spacing', [
            'label' => __( 'Spacing', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'body_padding', [
            'label'      => __( 'Content Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-service-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ],
        ] );

        $this->add_responsive_control( 'image_spacing', [
            'label'     => __( 'Image Bottom Spacing', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
            'default'   => [ 'size' => 20, 'unit' => 'px' ],
            'selectors' => [ '{{WRAPPER}} .cmp-service-card-img' => 'margin-bottom: {{SIZE}}px;' ],
        ] );

        $this->add_responsive_control( 'icon_spacing', [
            'label'     => __( 'Icon Bottom Spacing', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors' => [ '{{WRAPPER}} .cmp-service-icon' => 'margin-bottom: {{SIZE}}px;' ],
        ] );

        $this->add_responsive_control( 'title_spacing', [
            'label'     => __( 'Title Bottom Spacing', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors' => [ '{{WRAPPER}} .cmp-service-card-title' => 'margin-bottom: {{SIZE}}px;' ],
        ] );

        $this->add_responsive_control( 'desc_spacing', [
            'label'     => __( 'Description Bottom Spacing', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors' => [ '{{WRAPPER}} .cmp-service-card-desc' => 'margin-bottom: {{SIZE}}px;' ],
        ] );

        $this->add_responsive_control( 'features_spacing', [
            'label'     => __( 'Features Bottom Spacing', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors' => [ '{{WRAPPER}} .cmp-service-features' => 'margin-bottom: {{SIZE}}px;' ],
        ] );

        $this->add_responsive_control( 'features_item_spacing', [
            'label'     => __( 'Features Item Gap', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
            'selectors' => [ '{{WRAPPER}} .cmp-service-features li' => 'padding-top: {{SIZE}}px; padding-bottom: {{SIZE}}px;' ],
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'          => __( 'Section Padding', 'arenex-digital-widgets' ),
            'type'           => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units'     => [ 'px', 'em', '%' ],
            'default'        => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'tablet_default' => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'mobile_default' => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'selectors'      => [ '{{WRAPPER}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'content_max_width', [
            'label'      => __( 'Content Max Width', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range'      => [ 'px' => [ 'min' => 600, 'max' => 1800 ] ],
            'default'    => [ 'size' => 1200, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-services-grid' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $show_image       = ( ! empty( $s['show_image'] ) && $s['show_image'] === 'yes' );
        $show_icon        = ( ! empty( $s['show_icon'] ) && $s['show_icon'] === 'yes' );
        $show_description = ( ! empty( $s['show_description'] ) && $s['show_description'] === 'yes' );
        $show_features    = ( ! empty( $s['show_features'] ) && $s['show_features'] === 'yes' );
        $show_link        = ( ! empty( $s['show_link'] ) && $s['show_link'] === 'yes' );
        $image_position   = ! empty( $s['image_position'] ) ? $s['image_position'] : 'top';
        $hover_style      = ! empty( $s['hover_style'] ) ? $s['hover_style'] : 'top-line';
        $image_zoom       = ( ! empty( $s['image_zoom_on_hover'] ) && $s['image_zoom_on_hover'] === 'yes' );
        $grid_classes     = 'cmp-services-grid cmp-service-hover-' . esc_attr( $hover_style );
        if ( $image_zoom ) $grid_classes .= ' cmp-service-img-zoom';

        ?>
        <div class="<?php echo esc_attr( $grid_classes ); ?>">
            <?php foreach ( $s['cards'] as $i => $card ) :
                $delay    = ( $i % 4 ) + 1;
                $has_image = $show_image && ! empty( $card['image']['url'] );
            ?>
            <div class="cmp-service-card cmp-service-card--<?php echo esc_attr( $image_position ); ?> cmp-reveal cmp-reveal-delay-<?php echo esc_attr( $delay ); ?>">
                <div class="cmp-service-card-accent"></div>

                <?php if ( $has_image && in_array( $image_position, [ 'top', 'left' ], true ) ) : ?>
                <div class="cmp-service-card-img">
                    <img src="<?php echo esc_url( $card['image']['url'] ); ?>" alt="<?php echo esc_attr( ! empty( $card['image']['alt'] ) ? $card['image']['alt'] : $card['title'] ); ?>" loading="lazy">
                </div>
                <?php endif; ?>

                <div class="cmp-service-card-body">
                    <?php if ( $show_icon && ! empty( $card['icon']['value'] ) ) : ?>
                    <div class="cmp-service-icon">
                        <?php \Elementor\Icons_Manager::render_icon( $card['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </div>
                    <?php endif; ?>

                    <h3 class="cmp-service-card-title"><?php echo esc_html( $card['title'] ); ?></h3>

                    <?php if ( $show_description && ! empty( $card['description'] ) ) : ?>
                    <p class="cmp-service-card-desc"><?php echo esc_html( $card['description'] ); ?></p>
                    <?php endif; ?>

                    <?php if ( $show_features && ! empty( $card['features'] ) ) :
                        $features = array_filter( array_map( 'trim', explode( "\n", $card['features'] ) ) );
                        if ( ! empty( $features ) ) : ?>
                    <ul class="cmp-service-features">
                        <?php foreach ( $features as $feature ) : ?>
                        <li><?php echo esc_html( $feature ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; endif; ?>

                    <?php if ( $show_link && ! empty( $card['link_url']['url'] ) ) :
                        $target   = ! empty( $card['link_url']['is_external'] ) ? ' target="_blank"' : '';
                        $nofollow = ! empty( $card['link_url']['nofollow'] ) ? ' rel="nofollow"' : '';
                    ?>
                    <a href="<?php echo esc_url( $card['link_url']['url'] ); ?>"<?php echo $target . $nofollow; ?> class="cmp-service-link">
                        <?php echo esc_html( $card['link_text'] ); ?>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <?php endif; ?>
                </div>

                <?php if ( $has_image && in_array( $image_position, [ 'bottom', 'right' ], true ) ) : ?>
                <div class="cmp-service-card-img">
                    <img src="<?php echo esc_url( $card['image']['url'] ); ?>" alt="<?php echo esc_attr( ! empty( $card['image']['alt'] ) ? $card['image']['alt'] : $card['title'] ); ?>" loading="lazy">
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php
    }

    protected function content_template() {}
}
