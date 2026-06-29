<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Process_Steps extends \Elementor\Widget_Base {

    public function get_name()       { return 'cmp_process_steps'; }
    public function get_title()      { return __( 'ADW — Process Steps', 'arenex-digital-widgets' ); }
    public function get_icon()       { return 'eicon-flow'; }
    public function get_categories() { return [ 'arenex-digital' ]; }
    public function get_style_depends()  { return [ 'adw-styles' ]; }
    public function get_script_depends() { return [ 'adw-front' ]; }

    protected function register_controls() {

        /* ── CONTENT: Steps ── */
        $this->start_controls_section( 'section_steps', [ 'label' => __( 'Steps', 'arenex-digital-widgets' ) ] );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'number', [ 'label' => __( 'Number', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '01' ] );
        $repeater->add_control( 'title',  [ 'label' => __( 'Title', 'arenex-digital-widgets' ),  'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Step Title' ] );
        $repeater->add_control( 'description', [ 'label' => __( 'Description', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Step description.' ] );
        $repeater->add_control( 'image', [
            'label'       => __( 'Image (Accordion style only)', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::MEDIA,
            'description' => __( 'Used in Style 2 — Accordion. Square image recommended.', 'arenex-digital-widgets' ),
        ] );
        $this->add_control( 'steps', [
            'label'   => __( 'Steps', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'number' => '01', 'title' => 'Discovery',   'description' => 'We assess your needs and develop a comprehensive understanding of your goals.' ],
                [ 'number' => '02', 'title' => 'Strategy',    'description' => 'We map out a tailored plan that aligns with your goals and budget.' ],
                [ 'number' => '03', 'title' => 'Design & Build', 'description' => 'Our team brings the plan to life with precision and care.' ],
                [ 'number' => '04', 'title' => 'Launch & Support', 'description' => 'We launch and provide ongoing support to keep everything running smoothly.' ],
            ],
            'title_field' => '{{{ number }}} — {{{ title }}}',
        ] );
        $this->end_controls_section();

        /* ── CONTENT: Layout ── */
        $this->start_controls_section( 'section_layout', [ 'label' => __( 'Layout', 'arenex-digital-widgets' ) ] );

        $this->add_control( 'design_style', [
            'label'       => __( 'Design Style', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => 'style-2',
            'options'     => [
                'style-2'         => __( 'Style 1 — Grid with Accent Line', 'arenex-digital-widgets' ),
                'style-accordion' => __( 'Style 2 — Premium Accordion (with images)', 'arenex-digital-widgets' ),
                'style-tinted'    => __( 'Style 3 — Tinted Cards (Backdrop Numerals)', 'arenex-digital-widgets' ),
            ],
            'description' => __( 'More styles coming soon.', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'columns', [
            'label'       => __( 'Columns', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => 'auto',
            'options'     => [
                'auto' => __( 'Auto (responsive)', 'arenex-digital-widgets' ),
                '2'    => '2',
                '3'    => '3',
                '4'    => '4',
                '5'    => '5',
                '6'    => '6',
            ],
            'description' => __( 'Force all steps onto a fixed number of columns. Use Auto for responsive wrapping.', 'arenex-digital-widgets' ),
        ] );

        $this->add_responsive_control( 'max_width', [
            'label'      => __( 'Max Width', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range'      => [ 'px' => [ 'min' => 300, 'max' => 1600 ] ],
            'default'    => [ 'size' => 1000, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-process-steps' => 'max-width: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_control( 'show_connectors', [
            'label'        => __( 'Show Connectors', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );
        $this->add_control( 'hide_connectors_mobile', [
            'label'        => __( 'Hide Connectors on Mobile', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => [ 'show_connectors' => 'yes', 'design_style' => 'style-1' ],
        ] );
        $this->add_responsive_control( 'connector_align', [
            'label'     => __( 'Connector Alignment (Style 1)', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::CHOOSE,
            'options'   => [
                'flex-start' => [ 'title' => __( 'Left', 'arenex-digital-widgets' ),   'icon' => 'eicon-h-align-left' ],
                'center'     => [ 'title' => __( 'Center', 'arenex-digital-widgets' ), 'icon' => 'eicon-h-align-center' ],
                'flex-end'   => [ 'title' => __( 'Right', 'arenex-digital-widgets' ),  'icon' => 'eicon-h-align-right' ],
            ],
            'default'       => 'center',
            'tablet_default'=> 'center',
            'mobile_default'=> 'center',
            'selectors' => [
                '{{WRAPPER}} .cmp-process-style-1 .cmp-process-connector-wrap' => 'justify-content: {{VALUE}};',
            ],
            'condition' => [ 'show_connectors' => 'yes', 'design_style' => 'style-1' ],
        ] );
        $this->end_controls_section();

        /* ── STYLE: Numbers ── */
        $this->start_controls_section( 'style_numbers', [
            'label' => __( 'Numbers', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'number_color', [
            'label'     => __( 'Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#00B4D8',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-step-number' => 'color: {{VALUE}};' ],
        ] );
        $this->add_responsive_control( 'number_opacity', [
            'label'     => __( 'Opacity', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
            'default'   => [ 'size' => 0.2 ],
            'selectors' => [ '{{WRAPPER}} .cmp-step-number' => 'opacity: {{SIZE}};' ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'number_typography',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ],
            'selector' => '{{WRAPPER}} .cmp-step-number',
        ] );
        $this->end_controls_section();

        /* ── STYLE: Accent Line (Style 2) ── */
        $this->start_controls_section( 'style_accent_line', [
            'label'     => __( 'Accent Line (Style 2)', 'arenex-digital-widgets' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'design_style' => 'style-2' ],
        ] );
        $this->add_control( 'accent_line_color', [
            'label'     => __( 'Line Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#B71C1C',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-step-line' => 'background: {{VALUE}};' ],
        ] );
        $this->add_responsive_control( 'accent_line_width', [
            'label'      => __( 'Line Width', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 10, 'max' => 120 ] ],
            'default'    => [ 'size' => 40, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-step-line' => 'width: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'accent_line_height', [
            'label'      => __( 'Line Height', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 1, 'max' => 10 ] ],
            'default'    => [ 'size' => 3, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-step-line' => 'height: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->end_controls_section();

        /* ── STYLE: Title ── */
        $this->start_controls_section( 'style_title', [
            'label' => __( 'Title', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'title_color', [
            'label'     => __( 'Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#111827',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-step-content h3' => 'color: {{VALUE}};' ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ],
            'selector' => '{{WRAPPER}} .cmp-step-content h3',
        ] );
        $this->end_controls_section();

        /* ── STYLE: Description ── */
        $this->start_controls_section( 'style_description', [
            'label' => __( 'Description', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'desc_color', [
            'label'     => __( 'Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#6B7280',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'selectors' => [ '{{WRAPPER}} .cmp-step-content p' => 'color: {{VALUE}};' ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'desc_typography',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-step-content p',
        ] );
        $this->add_responsive_control( 'desc_max_width', [
            'label'      => __( 'Max Width', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range'      => [ 'px' => [ 'min' => 80, 'max' => 800 ] ],
            'default'    => [ 'size' => 320, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-step-content p' => 'max-width: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->end_controls_section();

        /* ── STYLE: Connector (Style 1) ── */
        $this->start_controls_section( 'style_connector', [
            'label'     => __( 'Connector (Style 1)', 'arenex-digital-widgets' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_connectors' => 'yes', 'design_style' => 'style-1' ],
        ] );
        $this->add_control( 'connector_color', [
            'label'     => __( 'Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#00B4D8',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-process-connector' => 'background-color: {{VALUE}};' ],
        ] );
        $this->add_responsive_control( 'connector_width', [
            'label'      => __( 'Width', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 10, 'max' => 200 ] ],
            'default'    => [ 'size' => 60, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-process-connector' => 'width: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'connector_height', [
            'label'      => __( 'Height', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 1, 'max' => 10 ] ],
            'default'    => [ 'size' => 2, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-process-connector' => 'height: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'connector_opacity', [
            'label'     => __( 'Opacity', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
            'default'   => [ 'size' => 0.4 ],
            'selectors' => [ '{{WRAPPER}} .cmp-process-connector' => 'opacity: {{SIZE}};' ],
        ] );
        $this->add_responsive_control( 'connector_offset', [
            'label'      => __( 'Offset from Number (vertical)', 'arenex-digital-widgets' ),
            'description'=> __( 'Space above the dash. Matches the offset used by the number + margin.', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
            'default'    => [ 'size' => 24, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-process-style-1 .cmp-process-connector-wrap' => 'margin-top: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->end_controls_section();

        /* ── STYLE: Dashed Connector (Style 2) ── */
        $this->start_controls_section( 'style_dashed_connector', [
            'label'     => __( 'Dashed Connector (Style 2)', 'arenex-digital-widgets' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_connectors' => 'yes', 'design_style' => 'style-2' ],
        ] );
        $this->add_control( 'dashed_color', [
            'label'     => __( 'Dash Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#6B7280',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-process-style-2 .cmp-process-steps::before' => '--cmp-dash-color: {{VALUE}};' ],
        ] );
        $this->add_responsive_control( 'dashed_opacity', [
            'label'     => __( 'Opacity', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
            'default'   => [ 'size' => 0.3 ],
            'selectors' => [ '{{WRAPPER}} .cmp-process-style-2 .cmp-process-steps::before' => 'opacity: {{SIZE}};' ],
        ] );
        $this->end_controls_section();

        /* ── STYLE: Spacing ── */
        $this->start_controls_section( 'style_spacing', [
            'label' => __( 'Spacing', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_responsive_control( 'section_padding', [
            'label'          => __( 'Section Padding', 'arenex-digital-widgets' ),
            'type'           => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units'     => [ 'px', 'em', '%' ],
            'default'        => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'tablet_default' => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'mobile_default' => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'selectors'      => [
                '{{WRAPPER}} .cmp-process-steps-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .cmp-sa-container'          => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );
        $this->add_responsive_control( 'step_padding', [
            'label'      => __( 'Step Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'default'    => [
                'top'    => '0',
                'right'  => '8',
                'bottom' => '0',
                'left'   => '8',
                'unit'   => 'px',
                'isLinked' => false,
            ],
            'selectors'  => [ '{{WRAPPER}} .cmp-process-step' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'step_gap', [
            'label'      => __( 'Gap Between Steps', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
            'selectors'  => [ '{{WRAPPER}} .cmp-process-steps' => 'gap: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'col_gap', [
            'label'      => __( 'Column Gap', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
            'selectors'  => [ '{{WRAPPER}} .cmp-process-steps' => 'column-gap: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s       = $this->get_settings_for_display();
        $steps   = $s['steps'];
        $count   = count( $steps );
        $show    = 'yes' === $s['show_connectors'];
        $hide_m  = ! empty( $s['hide_connectors_mobile'] ) && $s['hide_connectors_mobile'] === 'yes';
        $preset    = ! empty( $s['design_style'] ) ? $s['design_style'] : 'style-2';
        $cols_setting = $s['columns'] ?? 'auto';
        $step_cols    = ( $cols_setting !== 'auto' ) ? (int) $cols_setting : max( 1, min( 4, $count ) );
        $wrap_cls  = 'cmp-process-steps-wrapper cmp-process-' . esc_attr( $preset );
        if ( $hide_m ) $wrap_cls .= ' cmp-ps-hide-conn-mobile';
        ?>
        <?php if ( $preset === 'style-accordion' ) : ?>
            <div class="cmp-sa-container cmp-process-style-accordion" data-cmp-accordion>
                <?php foreach ( $steps as $i => $step ) :
                    $num    = ! empty( $step['number'] ) ? $step['number'] : str_pad( (string)( $i + 1 ), 2, '0', STR_PAD_LEFT );
                    $img    = $step['image']['url'] ?? '';
                    $img_id = $step['image']['id'] ?? 0;
                    $alt    = $img_id ? get_post_meta( $img_id, '_wp_attachment_image_alt', true ) : esc_attr( $step['title'] ?? '' );
                    $active = $i === 0 ? ' is-active' : '';
                ?>
                <div class="sa-card<?php echo esc_attr( $active ); ?>" data-index="<?php echo (int) $i; ?>">
                    <div class="sa-card-inner">
                        <div class="sa-toggle" aria-hidden="true">
                            <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round">
                                <line x1="7" y1="7" x2="17" y2="17"/><line x1="17" y1="7" x2="7" y2="17"/>
                            </svg>
                        </div>
                        <div class="sa-desc-wrap">
                            <div class="sa-desc-inner">
                                <p class="sa-desc"><?php echo esc_html( $step['description'] ); ?></p>
                            </div>
                        </div>
                        <div class="sa-bottom">
                            <div class="sa-meta">
                                <div class="sa-num-wrap">
                                    <div class="sa-num-circle" aria-hidden="true"></div>
                                    <span class="sa-num"><?php echo esc_html( $num ); ?></span>
                                </div>
                                <h3 class="sa-title"><?php echo esc_html( $step['title'] ); ?></h3>
                            </div>
                            <?php if ( $img ) : ?>
                            <div class="sa-image">
                                <img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
        <div class="<?php echo esc_attr( $wrap_cls ); ?>" style="--cmp-step-cols:<?php echo (int) $step_cols; ?>">
          <div class="cmp-process-steps">
            <?php if ( $preset === 'style-2' ) : ?>
                <?php foreach ( $steps as $i => $step ) :
                    $delay = ( $i % 4 ) + 1;
                ?>
                <div class="cmp-process-step cmp-reveal cmp-reveal-delay-<?php echo esc_attr( $delay ); ?>">
                    <?php if ( ! empty( trim( $step['number'] ) ) ) : ?>
                    <div class="cmp-step-number"><?php echo esc_html( $step['number'] ); ?></div>
                    <?php endif; ?>
                    <div class="cmp-step-line"></div>
                    <div class="cmp-step-content">
                        <h3><?php echo esc_html( $step['title'] ); ?></h3>
                        <p><?php echo esc_html( $step['description'] ); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php elseif ( $preset === 'style-tinted' ) : ?>
                <?php foreach ( $steps as $i => $step ) :
                    $delay = ( $i % 4 ) + 1;
                    $tint  = ( $i % 4 ) + 1;
                ?>
                <div class="cmp-process-step cmp-pst-card cmp-pst-tint-<?php echo (int) $tint; ?> cmp-reveal cmp-reveal-delay-<?php echo esc_attr( $delay ); ?>">
                    <?php if ( ! empty( trim( $step['number'] ) ) ) : ?>
                    <div class="cmp-step-number cmp-pst-num-bg" aria-hidden="true"><?php echo esc_html( $step['number'] ); ?></div>
                    <?php endif; ?>
                    <span class="cmp-pst-tag">
                        <span class="cmp-pst-tag-dot" aria-hidden="true"></span>
                        <?php echo esc_html( sprintf( __( 'Step %s', 'arenex-digital-widgets' ), $step['number'] ) ); ?>
                    </span>
                    <div class="cmp-step-content">
                        <h3><?php echo esc_html( $step['title'] ); ?></h3>
                        <p><?php echo esc_html( $step['description'] ); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else : /* style-1 default */ ?>
                <?php foreach ( $steps as $i => $step ) :
                    $delay = ( $i % 4 ) + 1;
                ?>
                <div class="cmp-process-step cmp-reveal cmp-reveal-delay-<?php echo esc_attr( $delay ); ?>">
                    <?php if ( ! empty( trim( $step['number'] ) ) ) : ?>
                    <div class="cmp-step-number"><?php echo esc_html( $step['number'] ); ?></div>
                    <?php endif; ?>
                    <div class="cmp-step-content">
                        <h3><?php echo esc_html( $step['title'] ); ?></h3>
                        <p><?php echo esc_html( $step['description'] ); ?></p>
                    </div>
                </div>
                <?php if ( $show && $i < $count - 1 ) : ?>
                <div class="cmp-process-connector-wrap"><div class="cmp-process-connector"></div></div>
                <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>
        <?php
    }

    protected function content_template() {}
}
