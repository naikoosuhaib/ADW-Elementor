<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Split_Scroll extends \Elementor\Widget_Base {

    public function get_name()       { return 'cmp_split_scroll'; }
    public function get_title()      { return __( 'ADW — Split Scroll', 'arenex-digital-widgets' ); }
    public function get_icon()       { return 'eicon-scroll'; }
    public function get_categories() { return [ 'arenex-digital' ]; }
    public function get_style_depends()  { return [ 'adw-styles' ]; }
    public function get_script_depends() { return [ 'adw-front' ]; }

    protected function register_controls() {

        /* ── Content Tab: Layout ── */
        $this->start_controls_section( 'section_layout', [ 'label' => __( 'Layout', 'arenex-digital-widgets' ) ] );

        $this->add_control( 'theme', [
            'label'   => __( 'Theme', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'dark',
            'options' => [
                'dark'  => __( 'Dark', 'arenex-digital-widgets' ),
                'light' => __( 'Light', 'arenex-digital-widgets' ),
            ],
        ] );

        $this->add_control( 'image_position', [
            'label'   => __( 'Image Position', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'left',
            'options' => [
                'left'  => __( 'Left', 'arenex-digital-widgets' ),
                'right' => __( 'Right', 'arenex-digital-widgets' ),
            ],
        ] );

        $this->add_responsive_control( 'panel_min_height', [
            'label'      => __( 'Panel Min Height', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'vh' ],
            'range'      => [ 'vh' => [ 'min' => 50, 'max' => 150, 'step' => 1 ] ],
            'default'    => [ 'size' => 100, 'unit' => 'vh' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-split-scroll__panel' => '--panel-min-height: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();

        /* ── Content Tab: Panels ── */
        $this->start_controls_section( 'section_panels', [ 'label' => __( 'Panels', 'arenex-digital-widgets' ) ] );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control( 'image', [
            'label' => __( 'Image', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );

        $repeater->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '',
        ] );

        $repeater->add_control( 'heading', [
            'label'   => __( 'Heading', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => '',
        ] );

        $repeater->add_control( 'description', [
            'label'   => __( 'Description', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::WYSIWYG,
            'default' => '',
        ] );

        $repeater->add_control( 'show_button', [
            'label'        => __( 'Show Button', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => '',
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
        ] );

        $repeater->add_control( 'button_text', [
            'label'     => __( 'Button Text', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => 'Learn More',
            'condition' => [ 'show_button' => 'yes' ],
        ] );

        $repeater->add_control( 'button_link', [
            'label'     => __( 'Button Link', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::URL,
            'default'   => [ 'url' => '#' ],
            'condition' => [ 'show_button' => 'yes' ],
        ] );

        $repeater->add_control( 'button_style', [
            'label'     => __( 'Button Style', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'primary',
            'options'   => [
                'primary' => __( 'Primary', 'arenex-digital-widgets' ),
                'ghost'   => __( 'Ghost', 'arenex-digital-widgets' ),
            ],
            'condition' => [ 'show_button' => 'yes' ],
        ] );

        $this->add_control( 'panels', [
            'label'       => __( 'Panels', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [
                    'eyebrow'     => 'The Problem',
                    'heading'     => 'Montana Weather Destroys Roofs',
                    'description' => '',
                    'show_button' => '',
                ],
                [
                    'eyebrow'     => 'The Solution',
                    'heading'     => 'Proactive Roof Care by Red Shield',
                    'description' => '',
                    'show_button' => '',
                ],
            ],
            'title_field' => '{{{ heading }}}',
        ] );

        $this->end_controls_section();

        /* ── Content Tab: Image Overlay ── */
        $this->start_controls_section( 'section_overlay', [ 'label' => __( 'Image Overlay', 'arenex-digital-widgets' ) ] );

        $this->add_control( 'show_overlay', [
            'label'        => __( 'Show Overlay', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
        ] );

        $this->add_control( 'overlay_color', [
            'label'     => __( 'Overlay Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(0,0,0,0.2)',
            'selectors' => [
                '{{WRAPPER}} .cmp-split-scroll__overlay' => 'background: {{VALUE}};',
            ],
            'condition' => [ 'show_overlay' => 'yes' ],
        ] );

        $this->end_controls_section();

        /* ── Style Tab: Section ── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Section', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'section_bg', [
            'label'     => __( 'Background Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [
                '{{WRAPPER}} .cmp-split-scroll' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'          => __( 'Section Padding', 'arenex-digital-widgets' ),
            'type'           => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units'     => [ 'px', 'em', '%' ],
            'default'        => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'selectors'      => [
                '{{WRAPPER}} .cmp-split-scroll' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'content_max_width', [
            'label'      => __( 'Content Max Width', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range'      => [ 'px' => [ 'min' => 300, 'max' => 1600 ] ],
            'default'    => [ 'size' => 1400, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-split-scroll__inner' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
            ],
        ] );

        $this->end_controls_section();

        /* ── Style Tab: Typography ── */
        $this->start_controls_section( 'style_typography', [
            'label' => __( 'Typography', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'eyebrow_color', [
            'label'     => __( 'Eyebrow Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#cc1010',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [
                '{{WRAPPER}} .cmp-split-scroll__eyebrow' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'heading_color', [
            'label'     => __( 'Heading Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#fff',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [
                '{{WRAPPER}} .cmp-split-scroll__heading' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'heading_typography',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ],
            'selector' => '{{WRAPPER}} .cmp-split-scroll__heading',
        ] );

        $this->add_control( 'desc_color', [
            'label'     => __( 'Description Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.6)',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'selectors' => [
                '{{WRAPPER}} .cmp-split-scroll__desc' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'desc_typography',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-split-scroll__desc',
        ] );

        $this->add_responsive_control( 'content_padding', [
            'label'      => __( 'Content Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'default'    => [
                'top'    => '80',
                'right'  => '64',
                'bottom' => '80',
                'left'   => '64',
                'unit'   => 'px',
            ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-split-scroll__panel-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();

        /* ── Style Tab: Image ── */
        $this->start_controls_section( 'style_image', [
            'label' => __( 'Image', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'image_border_radius', [
            'label'      => __( 'Border Radius', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-split-scroll__img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();

        /* ── Style Tab: Buttons ── */
        $this->start_controls_section( 'style_buttons', [
            'label' => __( 'Buttons', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'btn_primary_bg', [
            'label'     => __( 'Primary Button Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#cc1010',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [
                '{{WRAPPER}} .cmp-split-scroll__btn--primary' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'btn_ghost_border_color', [
            'label'     => __( 'Ghost Button Border Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.3)',
            'selectors' => [
                '{{WRAPPER}} .cmp-split-scroll__btn--ghost' => 'border-color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s      = $this->get_settings_for_display();
        $panels = $s['panels'];
        $theme  = esc_attr( $s['theme'] );
        $pos    = esc_attr( $s['image_position'] );
        ?>
        <section class="cmp-split-scroll cmp-split-scroll--<?php echo $theme; ?>" data-image-pos="<?php echo $pos; ?>">
            <div class="cmp-split-scroll__inner">
                <div class="cmp-split-scroll__media">
                    <div class="cmp-split-scroll__images">
                        <?php foreach ( $panels as $i => $panel ) :
                            $img_url = ! empty( $panel['image']['url'] ) ? esc_url( $panel['image']['url'] ) : '';
                            $alt     = ! empty( $panel['heading'] ) ? esc_attr( $panel['heading'] ) : '';
                        ?>
                        <img class="cmp-split-scroll__img<?php echo $i === 0 ? ' cmp-split-scroll__img--active' : ''; ?>"
                             src="<?php echo $img_url; ?>" alt="<?php echo $alt; ?>" data-index="<?php echo esc_attr( $i ); ?>"
                             style="<?php echo $i !== 0 ? 'opacity:0;' : ''; ?>">
                        <?php endforeach; ?>
                        <?php if ( 'yes' === $s['show_overlay'] ) : ?>
                        <div class="cmp-split-scroll__overlay"></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="cmp-split-scroll__panels">
                    <?php foreach ( $panels as $i => $panel ) :
                        $img_url = ! empty( $panel['image']['url'] ) ? esc_url( $panel['image']['url'] ) : '';
                        $alt     = ! empty( $panel['heading'] ) ? esc_attr( $panel['heading'] ) : '';
                    ?>
                    <div class="cmp-split-scroll__panel" data-index="<?php echo esc_attr( $i ); ?>">
                        <div class="cmp-split-scroll__panel-img-mobile">
                            <img src="<?php echo $img_url; ?>" alt="<?php echo $alt; ?>">
                        </div>
                        <div class="cmp-split-scroll__panel-content">
                            <?php if ( ! empty( $panel['eyebrow'] ) ) : ?>
                            <span class="cmp-split-scroll__eyebrow"><?php echo esc_html( $panel['eyebrow'] ); ?></span>
                            <?php endif; ?>
                            <?php if ( ! empty( $panel['heading'] ) ) : ?>
                            <h2 class="cmp-split-scroll__heading"><?php echo esc_html( $panel['heading'] ); ?></h2>
                            <?php endif; ?>
                            <?php if ( ! empty( $panel['description'] ) ) : ?>
                            <div class="cmp-split-scroll__desc"><?php echo wp_kses_post( $panel['description'] ); ?></div>
                            <?php endif; ?>
                            <?php if ( 'yes' === $panel['show_button'] && ! empty( $panel['button_text'] ) ) :
                                $btn_style = ! empty( $panel['button_style'] ) ? esc_attr( $panel['button_style'] ) : 'primary';
                                $btn_url   = ! empty( $panel['button_link']['url'] ) ? esc_url( $panel['button_link']['url'] ) : '#';
                                $btn_target = ! empty( $panel['button_link']['is_external'] ) ? ' target="_blank"' : '';
                                $btn_nofollow = ! empty( $panel['button_link']['nofollow'] ) ? ' rel="nofollow"' : '';
                            ?>
                            <a class="cmp-split-scroll__btn cmp-split-scroll__btn--<?php echo $btn_style; ?>"
                               href="<?php echo $btn_url; ?>"<?php echo $btn_target . $btn_nofollow; ?>><?php echo esc_html( $panel['button_text'] ); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    protected function content_template() {}
}
