<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Process_Showcase extends \Elementor\Widget_Base {

    public function get_name()       { return 'cmp_process_showcase'; }
    public function get_title()      { return __( 'ADW — Process Showcase', 'arenex-digital-widgets' ); }
    public function get_icon()       { return 'eicon-flow'; }
    public function get_categories() { return [ 'arenex-digital' ]; }
    public function get_keywords()   { return [ 'process', 'steps', 'showcase', 'features', 'timeline' ]; }
    public function get_style_depends()  { return [ 'adw-styles' ]; }
    public function get_script_depends() { return [ 'adw-front' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_steps', [
            'label' => __( 'Steps', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'step_label', [
            'label'   => __( 'Step Label', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Step 1', 'arenex-digital-widgets' ),
        ] );
        $repeater->add_control( 'title', [
            'label'       => __( 'Title', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __( 'Consultation', 'arenex-digital-widgets' ),
            'label_block' => true,
        ] );
        $repeater->add_control( 'title_tag', [
            'label'   => __( 'Title HTML Tag', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'h3',
            'options' => [
                'h1'   => 'H1',
                'h2'   => 'H2',
                'h3'   => 'H3',
                'h4'   => 'H4',
                'h5'   => 'H5',
                'h6'   => 'H6',
                'div'  => 'div',
                'span' => 'span',
                'p'    => 'p',
            ],
        ] );
        $repeater->add_control( 'description', [
            'label'   => __( 'Description', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __( 'We discuss your property, project goals, timeline, and excavation needs.', 'arenex-digital-widgets' ),
            'rows'    => 4,
        ] );
        $repeater->add_control( 'icon', [
            'label'   => __( 'Icon', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::ICONS,
            'default' => [ 'value' => 'far fa-clipboard', 'library' => 'fa-regular' ],
        ] );
        $repeater->add_control( 'image', [
            'label'   => __( 'Image', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );
        $repeater->add_control( 'image_alt', [
            'label'       => __( 'Image Alt Text', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __( 'Process step image', 'arenex-digital-widgets' ),
            'label_block' => true,
        ] );
        $repeater->add_control( 'image_label', [
            'label'   => __( 'Image Corner Label', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Ready Site', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'steps', [
            'label'       => __( 'Steps', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [
                    'step_label'  => 'Step 1',
                    'title'       => 'Consultation',
                    'description' => 'We discuss your property, project goals, timeline, and excavation needs.',
                    'icon'        => [ 'value' => 'far fa-clipboard', 'library' => 'fa-regular' ],
                    'image_label' => 'Project Plan',
                ],
                [
                    'step_label'  => 'Step 2',
                    'title'       => 'Site Preparation',
                    'description' => 'We assess the land, plan the work, and prepare the area for safe, efficient excavation.',
                    'icon'        => [ 'value' => 'fas fa-drafting-compass', 'library' => 'fa-solid' ],
                    'image_label' => 'Prepared Site',
                ],
                [
                    'step_label'  => 'Step 3',
                    'title'       => 'Excavation & Installation',
                    'description' => 'Our team completes the excavation, grading, septic, drainage, or site work with professional care.',
                    'icon'        => [ 'value' => 'fas fa-truck-loading', 'library' => 'fa-solid' ],
                    'image_label' => 'In Progress',
                ],
                [
                    'step_label'  => 'Step 4',
                    'title'       => 'Final Results',
                    'description' => 'We finish with clean, dependable results ready for the next stage of your project.',
                    'icon'        => [ 'value' => 'far fa-check-square', 'library' => 'fa-regular' ],
                    'image_label' => 'Ready Site',
                ],
            ],
            'title_field' => '{{{ step_label }}} — {{{ title }}}',
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_behavior', [
            'label' => __( 'Behavior', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'autoplay', [
            'label'        => __( 'Auto Rotate', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );
        $this->add_control( 'autoplay_speed', [
            'label'     => __( 'Auto Rotate Speed (ms)', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::NUMBER,
            'min'       => 2500,
            'max'       => 20000,
            'step'      => 100,
            'default'   => 6200,
            'condition' => [ 'autoplay' => 'yes' ],
        ] );
        $this->add_control( 'pause_on_hover', [
            'label'        => __( 'Pause on Hover', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => [ 'autoplay' => 'yes' ],
        ] );
        $this->add_control( 'initial_active', [
            'label'   => __( 'Initial Active Step', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 20,
            'step'    => 1,
            'default' => 1,
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'style_layout', [
            'label' => __( 'Layout', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .cmp-pshow-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'max_width', [
            'label'      => __( 'Max Width', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range'      => [ 'px' => [ 'min' => 320, 'max' => 1700 ], '%' => [ 'min' => 20, 'max' => 100 ] ],
            'default'    => [ 'size' => 1180, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-pshow-inner' => 'max-width: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'panel_gap', [
            'label'      => __( 'Column Gap', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
            'default'    => [ 'size' => 56, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-pshow-grid' => 'gap: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_control( 'section_background', [
            'label'     => __( 'Background Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#07160f',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-pshow-section' => 'background: {{VALUE}};' ],
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'style_cards', [
            'label' => __( 'Step Cards', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'card_padding', [
            'label'      => __( 'Card Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'default'    => [ 'top' => '22', 'right' => '24', 'bottom' => '22', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .cmp-pshow-step' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'card_gap', [
            'label'      => __( 'Gap Between Cards', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'default'    => [ 'size' => 16, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-pshow-list' => 'gap: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_control( 'card_background', [
            'label'     => __( 'Card Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(11, 33, 24, 0)',
            'selectors' => [ '{{WRAPPER}} .cmp-pshow-step' => 'background: {{VALUE}};' ],
        ] );
        $this->add_control( 'active_card_background', [
            'label'     => __( 'Active Card Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(255, 255, 255, 0.08)',
            'selectors' => [ '{{WRAPPER}} .cmp-pshow-step.is-active' => 'background: {{VALUE}};' ],
        ] );
        $this->add_responsive_control( 'card_radius', [
            'label'      => __( 'Card Radius', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
            'default'    => [ 'size' => 8, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-pshow-step' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
            'name'     => 'card_border',
            'selector' => '{{WRAPPER}} .cmp-pshow-step',
        ] );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
            'name'     => 'active_card_shadow',
            'selector' => '{{WRAPPER}} .cmp-pshow-step.is-active',
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'style_icon', [
            'label' => __( 'Icons', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'icon_box_size', [
            'label'      => __( 'Icon Box Size', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 28, 'max' => 120 ] ],
            'default'    => [ 'size' => 48, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-pshow-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_responsive_control( 'icon_size', [
            'label'      => __( 'Icon Size', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 10, 'max' => 64 ] ],
            'default'    => [ 'size' => 18, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-pshow-icon svg, {{WRAPPER}} .cmp-pshow-icon i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_control( 'icon_color', [
            'label'     => __( 'Icon Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#73a85b',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-pshow-icon' => 'color: {{VALUE}};' ],
        ] );
        $this->add_control( 'icon_bg', [
            'label'     => __( 'Icon Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(92, 138, 65, 0.18)',
            'selectors' => [ '{{WRAPPER}} .cmp-pshow-icon' => 'background: {{VALUE}};' ],
        ] );
        $this->add_control( 'active_icon_color', [
            'label'     => __( 'Active Icon Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .cmp-pshow-step.is-active .cmp-pshow-icon' => 'color: {{VALUE}};' ],
        ] );
        $this->add_control( 'active_icon_bg', [
            'label'     => __( 'Active Icon Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#4e7f3a',
            'selectors' => [ '{{WRAPPER}} .cmp-pshow-step.is-active .cmp-pshow-icon' => 'background: {{VALUE}};' ],
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'style_typography', [
            'label' => __( 'Typography', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'label_color', [
            'label'     => __( 'Step Label Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#73a85b',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-pshow-label' => 'color: {{VALUE}};' ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'label_typography',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ],
            'selector' => '{{WRAPPER}} .cmp-pshow-label',
        ] );
        $this->add_control( 'title_color', [
            'label'     => __( 'Title Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#f5f0e6',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-pshow-title' => 'color: {{VALUE}};' ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ],
            'selector' => '{{WRAPPER}} .cmp-pshow-title',
        ] );
        $this->add_control( 'desc_color', [
            'label'     => __( 'Description Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(245, 240, 230, 0.78)',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'selectors' => [ '{{WRAPPER}} .cmp-pshow-desc' => 'color: {{VALUE}};' ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'desc_typography',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-pshow-desc',
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'style_progress', [
            'label' => __( 'Progress Bar', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'progress_track', [
            'label'     => __( 'Track Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.22)',
            'selectors' => [ '{{WRAPPER}} .cmp-pshow-progress' => 'background: {{VALUE}};' ],
        ] );
        $this->add_control( 'progress_color', [
            'label'     => __( 'Progress Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#73a85b',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-pshow-progress span' => 'background: {{VALUE}};' ],
        ] );
        $this->add_responsive_control( 'progress_height', [
            'label'      => __( 'Progress Height', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 1, 'max' => 12 ] ],
            'default'    => [ 'size' => 3, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-pshow-progress' => 'height: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'style_image', [
            'label' => __( 'Image Panel', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'image_height', [
            'label'      => __( 'Image Height', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'vh' ],
            'range'      => [ 'px' => [ 'min' => 240, 'max' => 900 ], 'vh' => [ 'min' => 25, 'max' => 90 ] ],
            'default'    => [ 'size' => 460, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-pshow-media' => 'height: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_control( 'image_fit', [
            'label'   => __( 'Object Fit', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'cover',
            'options' => [
                'cover'   => __( 'Cover', 'arenex-digital-widgets' ),
                'contain' => __( 'Contain', 'arenex-digital-widgets' ),
                'fill'    => __( 'Fill', 'arenex-digital-widgets' ),
            ],
            'selectors' => [ '{{WRAPPER}} .cmp-pshow-image img' => 'object-fit: {{VALUE}};' ],
        ] );
        $this->add_control( 'image_position', [
            'label'   => __( 'Object Position', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'center center',
            'options' => [
                'center center' => __( 'Center Center', 'arenex-digital-widgets' ),
                'center top'    => __( 'Center Top', 'arenex-digital-widgets' ),
                'center bottom' => __( 'Center Bottom', 'arenex-digital-widgets' ),
                'left center'   => __( 'Left Center', 'arenex-digital-widgets' ),
                'right center'  => __( 'Right Center', 'arenex-digital-widgets' ),
            ],
            'selectors' => [ '{{WRAPPER}} .cmp-pshow-image img' => 'object-position: {{VALUE}};' ],
        ] );
        $this->add_responsive_control( 'image_radius', [
            'label'      => __( 'Image Radius', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'default'    => [ 'size' => 14, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-pshow-media' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_control( 'image_overlay', [
            'label'     => __( 'Image Overlay Opacity', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::NUMBER,
            'min'       => 0,
            'max'       => 0.9,
            'step'      => 0.05,
            'default'   => 0.35,
            'selectors' => [ '{{WRAPPER}} .cmp-pshow-image::after' => 'background: rgba(4, 16, 10, {{VALUE}});' ],
        ] );
        $this->add_control( 'image_label_color', [
            'label'     => __( 'Image Label Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .cmp-pshow-media-label' => 'color: {{VALUE}};' ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'image_label_typography',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ],
            'selector' => '{{WRAPPER}} .cmp-pshow-media-label',
        ] );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
            'name'     => 'image_border',
            'selector' => '{{WRAPPER}} .cmp-pshow-media',
        ] );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
            'name'     => 'image_shadow',
            'selector' => '{{WRAPPER}} .cmp-pshow-media',
        ] );

        $this->end_controls_section();
    }

    private function get_image_data( array $step, string $fallback_alt ) : array {
        $image  = $step['image'] ?? [];
        $url    = $image['url'] ?? \Elementor\Utils::get_placeholder_image_src();
        $id     = ! empty( $image['id'] ) ? absint( $image['id'] ) : 0;
        $width  = 1200;
        $height = 800;
        $alt    = ! empty( $step['image_alt'] ) ? $step['image_alt'] : $fallback_alt;

        if ( $id ) {
            $meta = wp_get_attachment_metadata( $id );
            if ( ! empty( $meta['width'] ) )  $width  = absint( $meta['width'] );
            if ( ! empty( $meta['height'] ) ) $height = absint( $meta['height'] );
            $stored_alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
            if ( $stored_alt && empty( $step['image_alt'] ) ) {
                $alt = $stored_alt;
            }
        }

        return [
            'url'    => $url,
            'alt'    => $alt,
            'width'  => $width,
            'height' => $height,
        ];
    }

    protected function render() {
        $s     = $this->get_settings_for_display();
        $steps = ! empty( $s['steps'] ) && is_array( $s['steps'] ) ? $s['steps'] : [];
        if ( empty( $steps ) ) return;

        $allowed_tags = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p' ];
        $initial      = max( 0, min( count( $steps ) - 1, absint( $s['initial_active'] ?? 1 ) - 1 ) );
        $autoplay     = ( $s['autoplay'] ?? 'yes' ) === 'yes' ? '1' : '0';
        $pause        = ( $s['pause_on_hover'] ?? 'yes' ) === 'yes' ? '1' : '0';
        $speed        = ! empty( $s['autoplay_speed'] ) ? absint( $s['autoplay_speed'] ) : 6200;
        ?>
        <section
            class="cmp-pshow-section cmp-widget-section"
            data-cmp-process-showcase
            data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
            data-pause-hover="<?php echo esc_attr( $pause ); ?>"
            data-speed="<?php echo esc_attr( $speed ); ?>"
            data-initial="<?php echo esc_attr( $initial ); ?>"
        >
            <div class="cmp-pshow-inner cmp-widget-inner">
                <div class="cmp-pshow-grid">
                    <div class="cmp-pshow-list" role="tablist" aria-label="<?php echo esc_attr__( 'Process steps', 'arenex-digital-widgets' ); ?>">
                        <?php foreach ( $steps as $index => $step ) :
                            $active    = $index === $initial;
                            $title_tag = in_array( ( $step['title_tag'] ?? 'h3' ), $allowed_tags, true ) ? $step['title_tag'] : 'h3';
                            $panel_id  = 'cmp-pshow-panel-' . esc_attr( $this->get_id() ) . '-' . (int) $index;
                        ?>
                        <article
                            class="cmp-pshow-step<?php echo $active ? ' is-active' : ''; ?>"
                            role="tab"
                            tabindex="<?php echo $active ? '0' : '-1'; ?>"
                            aria-selected="<?php echo $active ? 'true' : 'false'; ?>"
                            aria-controls="<?php echo esc_attr( $panel_id ); ?>"
                            data-index="<?php echo esc_attr( $index ); ?>"
                        >
                            <span class="cmp-pshow-icon" aria-hidden="true">
                                <?php \Elementor\Icons_Manager::render_icon( $step['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </span>
                            <span class="cmp-pshow-copy">
                                <span class="cmp-pshow-label"><?php echo esc_html( $step['step_label'] ?? sprintf( __( 'Step %d', 'arenex-digital-widgets' ), $index + 1 ) ); ?></span>
                                <<?php echo esc_attr( $title_tag ); ?> class="cmp-pshow-title"><?php echo esc_html( $step['title'] ?? '' ); ?></<?php echo esc_attr( $title_tag ); ?>>
                                <span class="cmp-pshow-desc"><?php echo esc_html( $step['description'] ?? '' ); ?></span>
                                <span class="cmp-pshow-progress" aria-hidden="true"><span></span></span>
                            </span>
                        </article>
                        <?php endforeach; ?>
                    </div>

                    <div class="cmp-pshow-media">
                        <?php foreach ( $steps as $index => $step ) :
                            $active   = $index === $initial;
                            $img      = $this->get_image_data( $step, $step['title'] ?? sprintf( __( 'Process step %d', 'arenex-digital-widgets' ), $index + 1 ) );
                            $panel_id = 'cmp-pshow-panel-' . esc_attr( $this->get_id() ) . '-' . (int) $index;
                        ?>
                        <figure
                            id="<?php echo esc_attr( $panel_id ); ?>"
                            class="cmp-pshow-image<?php echo $active ? ' is-active' : ''; ?>"
                            role="tabpanel"
                            <?php echo $active ? '' : 'hidden'; ?>
                        >
                            <img
                                src="<?php echo esc_url( $img['url'] ); ?>"
                                alt="<?php echo esc_attr( $img['alt'] ); ?>"
                                width="<?php echo esc_attr( $img['width'] ); ?>"
                                height="<?php echo esc_attr( $img['height'] ); ?>"
                                loading="lazy"
                            >
                            <?php if ( ! empty( $step['image_label'] ) ) : ?>
                                <figcaption class="cmp-pshow-media-label"><?php echo esc_html( $step['image_label'] ); ?></figcaption>
                            <?php endif; ?>
                        </figure>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }

    protected function content_template() {}
}
