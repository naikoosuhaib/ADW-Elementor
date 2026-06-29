<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Carousel_Card extends \Elementor\Widget_Base {

    public function get_name() { return 'cmp_carousel_card'; }
    public function get_title() { return __( 'ADW — Carousel + Card', 'arenex-digital-widgets' ); }
    public function get_icon() { return 'eicon-slider-push'; }
    public function get_categories() { return [ 'arenex-digital' ]; }
    public function get_keywords() { return [ 'carousel', 'card', 'slider', 'fleet', 'gallery' ]; }
    public function get_style_depends() { return [ 'adw-styles' ]; }
    public function get_script_depends() { return [ 'adw-front' ]; }

    protected function register_controls() {

        // ── Carousel Slides ──
        $this->start_controls_section( 'sec_carousel', [
            'label' => 'Carousel Images',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control( 'slides', [
            'label'  => 'Slides',
            'type'   => \Elementor\Controls_Manager::REPEATER,
            'fields' => [
                [
                    'name'    => 'image',
                    'label'   => 'Image',
                    'type'    => \Elementor\Controls_Manager::MEDIA,
                    'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
                ],
                [
                    'name'    => 'caption1',
                    'label'   => 'Caption Left',
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => 'Featured',
                ],
                [
                    'name'    => 'caption1_icon',
                    'label'   => 'Caption Left Icon',
                    'type'    => \Elementor\Controls_Manager::ICONS,
                    'default' => [ 'value' => 'fas fa-anchor', 'library' => 'fa-solid' ],
                ],
                [
                    'name'    => 'caption2',
                    'label'   => 'Caption Right',
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => 'Web Design',
                ],
                [
                    'name'    => 'caption2_icon',
                    'label'   => 'Caption Right Icon',
                    'type'    => \Elementor\Controls_Manager::ICONS,
                    'default' => [ 'value' => 'fas fa-users', 'library' => 'fa-solid' ],
                ],
            ],
            'default' => [
                [ 'caption1' => 'Project One', 'caption2' => 'Web Design', 'caption1_icon' => [ 'value' => 'fas fa-anchor', 'library' => 'fa-solid' ], 'caption2_icon' => [ 'value' => 'fas fa-users', 'library' => 'fa-solid' ] ],
                [ 'caption1' => 'Project Two', 'caption2' => 'Brand Strategy', 'caption1_icon' => [ 'value' => 'fas fa-anchor', 'library' => 'fa-solid' ], 'caption2_icon' => [ 'value' => 'fas fa-users', 'library' => 'fa-solid' ] ],
                [ 'caption1' => 'Design • Build • Launch', 'caption2' => 'Web · Brand · Marketing', 'caption1_icon' => [ 'value' => 'fas fa-anchor', 'library' => 'fa-solid' ], 'caption2_icon' => [ 'value' => 'fas fa-users', 'library' => 'fa-solid' ] ],
            ],
            'title_field' => '{{{ caption1 }}}',
        ]);
        $this->add_responsive_control( 'carousel_height', [
            'label'      => __( 'Carousel Height', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'vh' ],
            'range'      => [ 'px' => [ 'min' => 200, 'max' => 800 ], 'vh' => [ 'min' => 20, 'max' => 100 ] ],
            'default'    => [ 'size' => 500, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-fleet-carousel' => 'height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cmp-fleet-slide' => 'height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cmp-fleet-slide img' => 'height: 100%; object-fit: cover;',
            ],
        ]);
        $this->add_control( 'image_fit', [
            'label'   => __( 'Image Fit', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'cover',
            'options' => [
                'cover'   => __( 'Cover', 'arenex-digital-widgets' ),
                'contain' => __( 'Contain', 'arenex-digital-widgets' ),
                'fill'    => __( 'Fill', 'arenex-digital-widgets' ),
            ],
            'selectors' => [ '{{WRAPPER}} .cmp-fleet-slide img' => 'object-fit: {{VALUE}};' ],
        ]);
        $this->add_control( 'autoplay', [
            'label'   => 'Autoplay',
            'type'    => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);
        $this->add_control( 'autoplay_speed', [
            'label'     => 'Autoplay Speed (ms)',
            'type'      => \Elementor\Controls_Manager::NUMBER,
            'default'   => 5000,
            'condition' => [ 'autoplay' => 'yes' ],
        ]);
        $this->end_controls_section();

        // ── Boat Cards ──
        $this->start_controls_section( 'sec_boats', [
            'label' => 'Boat Cards',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control( 'boat_layout', [
            'label'   => __( 'Boat Card Layout', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'grid',
            'options' => [
                'grid'     => __( 'Simple Grid', 'arenex-digital-widgets' ),
                'detailed' => __( 'Detailed (Alternating)', 'arenex-digital-widgets' ),
            ],
        ] );

        $this->add_control( 'boats', [
            'label'  => 'Boats',
            'type'   => \Elementor\Controls_Manager::REPEATER,
            'fields' => [
                [
                    'name'    => 'name',
                    'label'   => 'Boat Name',
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => 'Project One',
                ],
                [
                    'name'    => 'specs',
                    'label'   => 'Specs Line',
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => 'Web Design · Brand · Development',
                ],
                [
                    'name'    => 'trips',
                    'label'   => 'Trip Types',
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => 'Discovery · Strategy · Launch',
                ],
                [
                    'name'    => 'capacity',
                    'label'   => 'Capacity',
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => 'Trusted by growing brands',
                ],
                [
                    'name'    => 'btn_text',
                    'label'   => 'Button Text',
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => 'Book Now',
                ],
                [
                    'name'    => 'btn_url',
                    'label'   => 'Button URL',
                    'type'    => \Elementor\Controls_Manager::URL,
                    'default' => [ 'url' => '#' ],
                ],
                [
                    'name'    => 'image',
                    'label'   => __( 'Boat Image', 'arenex-digital-widgets' ),
                    'type'    => \Elementor\Controls_Manager::MEDIA,
                    'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
                ],
                [
                    'name'    => 'subtitle',
                    'label'   => __( 'Subtitle', 'arenex-digital-widgets' ),
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => '',
                    'label_block' => true,
                ],
                [
                    'name'    => 'description',
                    'label'   => __( 'Description', 'arenex-digital-widgets' ),
                    'type'    => \Elementor\Controls_Manager::TEXTAREA,
                    'default' => '',
                    'rows'    => 4,
                ],
                [
                    'name' => 'spec_heading',
                    'label' => __( 'Specifications', 'arenex-digital-widgets' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ],
                [
                    'name'        => 'spec_items',
                    'label'       => __( 'Spec Items (Label | Value per line)', 'arenex-digital-widgets' ),
                    'type'        => \Elementor\Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'rows'        => 5,
                    'placeholder' => "Service | Web Design\nTimeline | 4 Weeks\nDeliverable | Live Site",
                ],
                [
                    'name' => 'trip_heading',
                    'label' => __( 'Trip Types', 'arenex-digital-widgets' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ],
                [
                    'name'        => 'trip_list',
                    'label'       => __( 'Trip List (one per line)', 'arenex-digital-widgets' ),
                    'type'        => \Elementor\Controls_Manager::TEXTAREA,
                    'default'     => '',
                    'rows'        => 4,
                    'placeholder' => "Service One\nService Two\nService Three",
                ],
            ],
            'default' => [
                [ 'name' => 'Project One', 'specs' => 'Web Design · Brand Strategy · Development', 'trips' => 'Discovery · Strategy · Launch', 'capacity' => 'Trusted by growing brands', 'btn_text' => 'View Project' ],
                [ 'name' => 'Project Two', 'specs' => 'Brand Identity · Marketing · Consulting', 'trips' => 'Discovery · Design · Delivery', 'capacity' => 'Built for results', 'btn_text' => 'View Project' ],
            ],
            'title_field' => '{{{ name }}}',
        ]);
        $this->end_controls_section();

        // ── Layout ──
        $this->start_controls_section( 'sec_layout', [
            'label' => 'Layout',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_responsive_control( 'boat_columns', [
            'label'   => 'Boat Card Columns',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '2',
            'options' => [ '1' => '1', '2' => '2', '3' => '3' ],
            'selectors' => [ '{{WRAPPER}} .cmp-fleet-boats' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ],
        ]);
        $this->add_responsive_control( 'boat_gap', [
            'label'      => 'Boat Card Gap',
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'default'    => [ 'size' => 24, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-fleet-boats' => 'gap: {{SIZE}}{{UNIT}};' ],
        ]);
        $this->end_controls_section();

        /* ═══ STYLE TAB ═══ */

        // ── Section Style ──
        $this->start_controls_section( 'style_section', [
            'label' => 'Section',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control( 'section_bg', [
            'label'     => __( 'Background Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-fleet-wrap' => 'background: {{VALUE}};' ],
        ]);
        $this->add_control( 'accent_color', [
            'label'   => 'Accent Color',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'global'  => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'default' => '#cc1010',
        ]);
        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .cmp-fleet-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);
        $this->end_controls_section();

        // ── Boat Cards Style ──
        $this->start_controls_section( 'style_cards', [
            'label' => 'Boat Cards',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control( 'card_bg', [
            'label'     => 'Card Background',
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'default'   => '#112236',
            'selectors' => [ '{{WRAPPER}} .cmp-fleet-boat' => 'background: {{VALUE}};' ],
        ]);
        $this->add_control( 'card_hover_bg', [
            'label'     => 'Card Hover Background',
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'default'   => 'rgba(255,255,255,0.06)',
            'selectors' => [ '{{WRAPPER}} .cmp-fleet-boat:hover' => 'background: {{VALUE}};' ],
        ]);
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
            'name'     => 'card_border',
            'selector' => '{{WRAPPER}} .cmp-fleet-boat',
        ]);
        $this->add_control( 'card_border_radius', [
            'label'      => 'Border Radius',
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 20 ] ],
            'default'    => [ 'size' => 6 ],
            'selectors'  => [ '{{WRAPPER}} .cmp-fleet-boat' => 'border-radius: {{SIZE}}px;' ],
        ]);
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_box_shadow',
            'selector' => '{{WRAPPER}} .cmp-fleet-boat',
        ]);
        $this->add_responsive_control( 'card_padding', [
            'label'      => 'Card Padding',
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'default'    => [ 'top' => '28', 'right' => '32', 'bottom' => '28', 'left' => '32', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .cmp-fleet-boat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);
        $this->end_controls_section();

        // ── Boat Name Style ──
        $this->start_controls_section( 'style_boat_name', [
            'label' => 'Boat Name',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'boat_name_typo',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ],
            'selector' => '{{WRAPPER}} .cmp-fleet-boat__name',
        ]);
        $this->add_control( 'boat_name_color', [
            'label'     => 'Color',
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .cmp-fleet-boat__name' => 'color: {{VALUE}};' ],
        ]);
        $this->add_responsive_control( 'boat_name_spacing', [
            'label'      => 'Bottom Spacing',
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
            'default'    => [ 'size' => 6, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-fleet-boat__name' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
        ]);
        $this->end_controls_section();

        // ── Specs Style ──
        $this->start_controls_section( 'style_specs', [
            'label' => 'Boat Specs',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'specs_typo',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-fleet-boat__specs',
        ]);
        $this->add_control( 'specs_color', [
            'label'     => 'Color',
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'default'   => 'rgba(255,255,255,0.45)',
            'selectors' => [ '{{WRAPPER}} .cmp-fleet-boat__specs' => 'color: {{VALUE}};' ],
        ]);
        $this->add_responsive_control( 'specs_spacing', [
            'label'      => 'Bottom Spacing',
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
            'default'    => [ 'size' => 10, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-fleet-boat__specs' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
        ]);
        $this->end_controls_section();

        // ── Capacity Style ──
        $this->start_controls_section( 'style_capacity', [
            'label' => 'Capacity & Trips',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'capacity_typo',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-fleet-boat__trips',
        ]);
        $this->add_control( 'trips_color', [
            'label'     => 'Trips Text Color',
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'default'   => 'rgba(255,255,255,0.65)',
            'selectors' => [ '{{WRAPPER}} .cmp-fleet-boat__trips' => 'color: {{VALUE}};' ],
        ]);
        $this->add_control( 'capacity_color', [
            'label'     => 'Capacity Highlight Color',
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'default'   => '#cc1010',
            'selectors' => [ '{{WRAPPER}} .cmp-fleet-boat__capacity' => 'color: {{VALUE}};' ],
        ]);
        $this->end_controls_section();

        // ── Button Style ──
        $this->start_controls_section( 'style_btn', [
            'label' => 'Button',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control( 'btn_bg', [
            'label'     => 'Button Background',
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'default'   => '#cc1010',
            'selectors' => [ '{{WRAPPER}} .cmp-fleet-btn' => 'background: {{VALUE}};' ],
        ]);
        $this->add_control( 'btn_hover_bg', [
            'label'     => 'Button Hover',
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'default'   => '#a80d0d',
            'selectors' => [ '{{WRAPPER}} .cmp-fleet-btn:hover' => 'background: {{VALUE}};' ],
        ]);
        $this->add_control( 'btn_text_color', [
            'label'     => 'Button Text Color',
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .cmp-fleet-btn' => 'color: {{VALUE}};' ],
        ]);
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'btn_typo',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ],
            'selector' => '{{WRAPPER}} .cmp-fleet-btn',
        ]);
        $this->add_responsive_control( 'btn_padding', [
            'label'      => 'Button Padding',
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'default'    => [ 'top' => '11', 'right' => '24', 'bottom' => '11', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .cmp-fleet-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);
        $this->add_control( 'btn_radius', [
            'label'      => 'Button Border Radius',
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 20 ] ],
            'default'    => [ 'size' => 3 ],
            'selectors'  => [ '{{WRAPPER}} .cmp-fleet-btn' => 'border-radius: {{SIZE}}px;' ],
        ]);
        $this->end_controls_section();

        // ── Caption Style ──
        $this->start_controls_section( 'style_captions', [
            'label' => 'Carousel Captions',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ]);
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'caption_typo',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ],
            'selector' => '{{WRAPPER}} .cmp-fleet-caption',
        ]);
        $this->add_control( 'caption_color', [
            'label'     => 'Caption Color',
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'default'   => 'rgba(255,255,255,0.75)',
            'selectors' => [ '{{WRAPPER}} .cmp-fleet-caption' => 'color: {{VALUE}};' ],
        ]);
        $this->add_control( 'caption_icon_color', [
            'label'     => 'Caption Icon Color',
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'default'   => 'rgba(255,255,255,0.5)',
            'selectors' => [ '{{WRAPPER}} .cmp-fleet-caption__icon' => 'color: {{VALUE}};' ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section(
            'detail_image_section',
            [
                'label' => __( 'Detail Image', 'arenex-digital-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'detail_image_height',
            [
                'label'      => __( 'Image Height', 'arenex-digital-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range'      => [
                    'px' => [ 'min' => 100, 'max' => 800 ],
                    'vh' => [ 'min' => 10, 'max' => 100 ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .cmp-fleet-detail__image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'detail_image_fit',
            [
                'label'   => __( 'Object Fit', 'arenex-digital-widgets' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover'   => __( 'Cover', 'arenex-digital-widgets' ),
                    'contain' => __( 'Contain', 'arenex-digital-widgets' ),
                    'fill'    => __( 'Fill', 'arenex-digital-widgets' ),
                    'none'    => __( 'None', 'arenex-digital-widgets' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .cmp-fleet-detail__image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'detail_title_section',
            [
                'label' => __( 'Detail Title', 'arenex-digital-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'detail_title_typo',
                'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ],
                'selector' => '{{WRAPPER}} .cmp-fleet-detail__name',
            ]
        );

        $this->add_control(
            'detail_title_color',
            [
                'label'     => __( 'Color', 'arenex-digital-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
                'selectors' => [
                    '{{WRAPPER}} .cmp-fleet-detail__name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'detail_title_spacing',
            [
                'label'      => __( 'Bottom Spacing', 'arenex-digital-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
                'selectors'  => [
                    '{{WRAPPER}} .cmp-fleet-detail__name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'detail_subtitle_section',
            [
                'label' => __( 'Detail Subtitle', 'arenex-digital-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'detail_subtitle_typo',
                'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ],
                'selector' => '{{WRAPPER}} .cmp-fleet-detail__subtitle',
            ]
        );

        $this->add_control(
            'detail_subtitle_color',
            [
                'label'     => __( 'Color', 'arenex-digital-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
                'selectors' => [
                    '{{WRAPPER}} .cmp-fleet-detail__subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'detail_subtitle_spacing',
            [
                'label'      => __( 'Bottom Spacing', 'arenex-digital-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
                'selectors'  => [
                    '{{WRAPPER}} .cmp-fleet-detail__subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'detail_desc_section',
            [
                'label' => __( 'Detail Description', 'arenex-digital-widgets' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'detail_desc_typo',
                'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
                'selector' => '{{WRAPPER}} .cmp-fleet-detail__desc',
            ]
        );

        $this->add_control(
            'detail_desc_color',
            [
                'label'     => __( 'Color', 'arenex-digital-widgets' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
                'selectors' => [
                    '{{WRAPPER}} .cmp-fleet-detail__desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'detail_desc_spacing',
            [
                'label'      => __( 'Bottom Spacing', 'arenex-digital-widgets' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
                'selectors'  => [
                    '{{WRAPPER}} .cmp-fleet-detail__desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $s      = $this->get_settings_for_display();
        $accent = esc_attr( $s['accent_color'] ?? '#cc1010' );
        $uid    = 'fleet-' . $this->get_id();
        $total  = count( $s['slides'] ?? [] );
        $speed  = intval( $s['autoplay_speed'] ?? 5000 );
        $auto   = ( $s['autoplay'] ?? '' ) === 'yes';

        ?>
        <div class="cmp-fleet-wrap"
             data-uid="<?php echo esc_attr( $uid ); ?>"
             data-total="<?php echo $total; ?>"
             data-auto="<?php echo $auto ? '1' : '0'; ?>"
             data-speed="<?php echo $speed; ?>"
             data-accent="<?php echo $accent; ?>">
            <div class="cmp-fleet-inner">

                <!-- Carousel -->
                <?php if ( $total > 0 ) : ?>
                <div class="cmp-fleet-carousel" id="<?php echo esc_attr( $uid ); ?>">
                    <div class="cmp-fleet-track" data-uid="<?php echo esc_attr( $uid ); ?>">
                        <?php foreach ( $s['slides'] as $slide ) : ?>
                        <div class="cmp-fleet-slide">
                            <?php if ( ! empty( $slide['image']['url'] ) ) : ?>
                            <img src="<?php echo esc_url( $slide['image']['url'] ); ?>" alt="" class="cmp-fleet-slide__img">
                            <?php endif; ?>
                            <?php if ( ! empty( $slide['caption1'] ) || ! empty( $slide['caption2'] ) ) : ?>
                            <div class="cmp-fleet-captions">
                                <?php if ( ! empty( $slide['caption1'] ) ) : ?>
                                <div class="cmp-fleet-caption">
                                    <?php if ( ! empty( $slide['caption1_icon']['value'] ) ) : ?>
                                    <span class="cmp-fleet-caption__icon"><?php \Elementor\Icons_Manager::render_icon( $slide['caption1_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                                    <?php endif; ?>
                                    <?php echo esc_html( $slide['caption1'] ); ?>
                                </div>
                                <?php endif; ?>
                                <?php if ( ! empty( $slide['caption2'] ) ) : ?>
                                <div class="cmp-fleet-caption">
                                    <?php if ( ! empty( $slide['caption2_icon']['value'] ) ) : ?>
                                    <span class="cmp-fleet-caption__icon"><?php \Elementor\Icons_Manager::render_icon( $slide['caption2_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                                    <?php endif; ?>
                                    <?php echo esc_html( $slide['caption2'] ); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if ( $total > 1 ) : ?>
                    <div class="cmp-fleet-nav">
                        <button class="cmp-fleet-arrow" data-dir="prev" data-uid="<?php echo esc_attr( $uid ); ?>">&larr;</button>
                        <?php for ( $i = 0; $i < $total; $i++ ) : ?>
                        <button class="cmp-fleet-dot<?php echo $i === 0 ? ' active' : ''; ?>" data-idx="<?php echo $i; ?>" data-uid="<?php echo esc_attr( $uid ); ?>"></button>
                        <?php endfor; ?>
                        <button class="cmp-fleet-arrow" data-dir="next" data-uid="<?php echo esc_attr( $uid ); ?>">&rarr;</button>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Boat Cards -->
                <?php if ( ! empty( $s['boats'] ) ) : ?>
                    <?php if ( ( $s['boat_layout'] ?? 'grid' ) === 'detailed' ) : ?>
                    <!-- DETAILED ALTERNATING LAYOUT -->
                    <div class="cmp-fleet-details">
                        <?php foreach ( $s['boats'] as $index => $boat ) :
                            $btn_url    = $boat['btn_url']['url'] ?? '#';
                            $btn_target = ! empty( $boat['btn_url']['is_external'] ) ? ' target="_blank"' : '';
                            $reverse    = $index % 2 === 1 ? ' cmp-fleet-detail--reverse' : '';
                        ?>
                        <div class="cmp-fleet-detail<?php echo $reverse; ?>">
                            <div class="cmp-fleet-detail__image">
                                <?php if ( ! empty( $boat['image']['url'] ) ) : ?>
                                <img src="<?php echo esc_url( $boat['image']['url'] ); ?>" alt="<?php echo esc_attr( $boat['name'] ?? '' ); ?>">
                                <?php endif; ?>
                            </div>
                            <div class="cmp-fleet-detail__info">
                                <h3 class="cmp-fleet-detail__name">
                                    <?php echo esc_html( $boat['name'] ); ?>
                                </h3>
                                <?php if ( ! empty( $boat['subtitle'] ) ) : ?>
                                <div class="cmp-fleet-detail__subtitle"><?php echo esc_html( $boat['subtitle'] ); ?></div>
                                <?php endif; ?>

                                <?php
                                // Parse specs from "Label | Value" textarea
                                $specs_raw = $boat['spec_items'] ?? '';
                                $spec_lines = array_filter( array_map( 'trim', explode( "\n", $specs_raw ) ) );
                                if ( ! empty( $spec_lines ) ) : ?>
                                <div class="cmp-fleet-detail__specs">
                                    <?php foreach ( $spec_lines as $spec_line ) :
                                        $parts = explode( '|', $spec_line, 2 );
                                        $spec_label = trim( $parts[0] ?? '' );
                                        $spec_value = trim( $parts[1] ?? '' );
                                        if ( empty( $spec_label ) ) continue;
                                    ?>
                                    <div class="cmp-fleet-spec">
                                        <div class="cmp-fleet-spec__label"><?php echo esc_html( $spec_label ); ?></div>
                                        <div class="cmp-fleet-spec__value"><?php echo esc_html( $spec_value ); ?></div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>

                                <?php if ( ! empty( $boat['description'] ) ) : ?>
                                <p class="cmp-fleet-detail__desc"><?php echo wp_kses_post( $boat['description'] ); ?></p>
                                <?php endif; ?>

                                <?php
                                // Parse trip list
                                $trips_raw = $boat['trip_list'] ?? '';
                                $trip_lines = array_filter( array_map( 'trim', explode( "\n", $trips_raw ) ) );
                                if ( ! empty( $trip_lines ) ) : ?>
                                <div class="cmp-fleet-detail__trips">
                                    <?php foreach ( $trip_lines as $trip ) : ?>
                                    <div class="cmp-fleet-trip">
                                        <span class="cmp-fleet-trip__dot" style="background:<?php echo $accent; ?>"></span>
                                        <?php echo esc_html( $trip ); ?>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>

                                <?php if ( ! empty( $boat['btn_text'] ) ) : ?>
                                <a href="<?php echo esc_url( $btn_url ); ?>"<?php echo $btn_target; ?> class="cmp-fleet-btn">
                                    <?php echo esc_html( $boat['btn_text'] ); ?> &rarr;
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else : ?>
                    <!-- EXISTING GRID LAYOUT -->
                    <div class="cmp-fleet-boats">
                        <?php foreach ( $s['boats'] as $boat ) :
                            $btn_url    = $boat['btn_url']['url'] ?? '#';
                            $btn_target = ! empty( $boat['btn_url']['is_external'] ) ? ' target="_blank"' : '';
                        ?>
                        <div class="cmp-fleet-boat">
                            <div class="cmp-fleet-boat__name">
                                <?php echo esc_html( $boat['name'] ); ?>
                            </div>
                            <div class="cmp-fleet-boat__specs">
                                <?php echo esc_html( $boat['specs'] ); ?>
                            </div>
                            <div class="cmp-fleet-boat__trips">
                                <span class="cmp-fleet-boat__capacity"><?php echo esc_html( $boat['capacity'] ); ?></span>
                                &nbsp;&middot;&nbsp; <?php echo esc_html( $boat['trips'] ); ?>
                            </div>
                            <?php if ( ! empty( $boat['btn_text'] ) ) : ?>
                            <div class="cmp-fleet-boat__btn-wrap">
                                <a href="<?php echo esc_url( $btn_url ); ?>"<?php echo $btn_target; ?> class="cmp-fleet-btn">
                                    <?php echo esc_html( $boat['btn_text'] ); ?> &rarr;
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>

            </div>
        </div>
        <?php
    }

    protected function content_template() {}
}
