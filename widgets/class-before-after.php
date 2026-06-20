<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ADW — Before / After Image Slider
 * Drag-to-reveal comparison slider. Horizontal or vertical wipe,
 * responsive height, before/after label text with font-size + flexible
 * placement (top / middle / bottom / on the handle / below the image).
 * Touch + keyboard accessible. No external libs — clip-path based, no distortion.
 */
class CMP_Before_After extends \Elementor\Widget_Base {

    public function get_name()       { return 'cmp_before_after'; }
    public function get_title()      { return __( 'ADW — Before / After Slider', 'arenex-digital-widgets' ); }
    public function get_icon()       { return 'eicon-image-before-after'; }
    public function get_categories() { return [ 'arenex-digital' ]; }
    public function get_keywords()   { return [ 'before', 'after', 'compare', 'slider', 'image', 'reveal', 'twentytwenty' ]; }
    public function get_style_depends()  { return [ 'adw-styles' ]; }
    public function get_script_depends() { return [ 'adw-front' ]; }

    protected function register_controls() {

        /* ════════════════ CONTENT ════════════════ */
        $this->start_controls_section( 'section_images', [
            'label' => __( 'Images', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'before_image', [
            'label'   => __( 'Before Image', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );
        $this->add_control( 'after_image', [
            'label'   => __( 'After Image', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );
        $this->add_control( 'alt_text', [
            'label'       => __( 'Alt Text', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __( 'Before and after comparison', 'arenex-digital-widgets' ),
            'label_block' => true,
        ] );

        $this->end_controls_section();

        /* ──────────── Labels ──────────── */
        $this->start_controls_section( 'section_labels', [
            'label' => __( 'Labels', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'show_labels', [
            'label'        => __( 'Show Labels', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );
        $this->add_control( 'before_text', [
            'label'       => __( 'Before Label', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __( 'Before', 'arenex-digital-widgets' ),
            'label_block' => true,
            'condition'   => [ 'show_labels' => 'yes' ],
        ] );
        $this->add_control( 'after_text', [
            'label'       => __( 'After Label', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __( 'After', 'arenex-digital-widgets' ),
            'label_block' => true,
            'condition'   => [ 'show_labels' => 'yes' ],
        ] );
        $this->add_control( 'label_position', [
            'label'     => __( 'Label Position', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'top',
            'options'   => [
                'top'    => __( 'Top of image', 'arenex-digital-widgets' ),
                'middle' => __( 'Middle of image', 'arenex-digital-widgets' ),
                'bottom' => __( 'Bottom of image', 'arenex-digital-widgets' ),
                'handle' => __( 'On the slider handle', 'arenex-digital-widgets' ),
                'below'  => __( 'Below the image (caption)', 'arenex-digital-widgets' ),
            ],
            'description' => __( 'The "Before" label hugs the left/before side and "After" hugs the right/after side automatically.', 'arenex-digital-widgets' ),
            'condition' => [ 'show_labels' => 'yes' ],
        ] );

        $this->end_controls_section();

        /* ──────────── Behavior ──────────── */
        $this->start_controls_section( 'section_behavior', [
            'label' => __( 'Behavior', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'orientation', [
            'label'   => __( 'Slide Direction', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'horizontal',
            'options' => [
                'horizontal' => __( 'Horizontal (left / right)', 'arenex-digital-widgets' ),
                'vertical'   => __( 'Vertical (top / bottom)', 'arenex-digital-widgets' ),
            ],
        ] );
        $this->add_control( 'start_position', [
            'label'      => __( 'Starting Position', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ '%' ],
            'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
            'default'    => [ 'size' => 50, 'unit' => '%' ],
        ] );
        $this->add_control( 'hover_mode', [
            'label'        => __( 'Move on Hover', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
            'description'  => __( 'Follow the cursor without clicking (falls back to drag on touch devices).', 'arenex-digital-widgets' ),
        ] );

        $this->end_controls_section();

        /* ════════════════ STYLE — Layout ════════════════ */
        $this->start_controls_section( 'style_layout', [
            'label' => __( 'Layout', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'max_width', [
            'label'      => __( 'Max Width', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range'      => [ 'px' => [ 'min' => 240, 'max' => 1600 ], '%' => [ 'min' => 20, 'max' => 100 ] ],
            'default'    => [ 'size' => 960, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-ba-inner' => 'max-width: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'align', [
            'label'     => __( 'Alignment', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::CHOOSE,
            'default'   => 'center',
            'options'   => [
                'flex-start' => [ 'title' => __( 'Left', 'arenex-digital-widgets' ),   'icon' => 'eicon-text-align-left' ],
                'center'     => [ 'title' => __( 'Center', 'arenex-digital-widgets' ), 'icon' => 'eicon-text-align-center' ],
                'flex-end'   => [ 'title' => __( 'Right', 'arenex-digital-widgets' ),  'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [ '{{WRAPPER}} .cmp-ba-section' => 'display:flex; justify-content: {{VALUE}};' ],
        ] );
        $this->add_responsive_control( 'height', [
            'label'          => __( 'Height', 'arenex-digital-widgets' ),
            'type'           => \Elementor\Controls_Manager::SLIDER,
            'size_units'     => [ 'px', 'vh' ],
            'range'          => [ 'px' => [ 'min' => 180, 'max' => 1000 ], 'vh' => [ 'min' => 20, 'max' => 100 ] ],
            'default'        => [ 'size' => 520, 'unit' => 'px' ],
            'tablet_default' => [ 'size' => 420, 'unit' => 'px' ],
            'mobile_default' => [ 'size' => 320, 'unit' => 'px' ],
            'selectors'      => [ '{{WRAPPER}} .cmp-ba-figure' => 'height: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_control( 'image_fit', [
            'label'     => __( 'Image Fit', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'cover',
            'options'   => [
                'cover'   => __( 'Cover', 'arenex-digital-widgets' ),
                'contain' => __( 'Contain', 'arenex-digital-widgets' ),
                'fill'    => __( 'Fill', 'arenex-digital-widgets' ),
            ],
            'selectors' => [ '{{WRAPPER}} .cmp-ba-figure img' => 'object-fit: {{VALUE}};' ],
        ] );
        $this->add_responsive_control( 'radius', [
            'label'      => __( 'Corner Radius', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'default'    => [ 'size' => 14, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-ba-figure' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
            'name'     => 'figure_shadow',
            'selector' => '{{WRAPPER}} .cmp-ba-figure',
        ] );

        $this->end_controls_section();

        /* ════════════════ STYLE — Handle ════════════════ */
        $this->start_controls_section( 'style_handle', [
            'label' => __( 'Handle & Divider', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'line_color', [
            'label'     => __( 'Divider Line Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .cmp-ba-divider' => 'background: {{VALUE}};' ],
        ] );
        $this->add_responsive_control( 'line_width', [
            'label'      => __( 'Divider Thickness', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 1, 'max' => 12 ] ],
            'default'    => [ 'size' => 3, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-ba-slider' => '--cmp-ba-line: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_control( 'handle_bg', [
            'label'     => __( 'Handle Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .cmp-ba-handle' => 'background: {{VALUE}};' ],
        ] );
        $this->add_control( 'handle_svg', [
            'label'       => __( 'Handle Icon (SVG / image upload)', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::MEDIA,
            'media_types' => [ 'image', 'svg' ],
            'description' => __( 'Upload a custom SVG (or PNG) to use as the handle. This is the simplest option and overrides the icon picker and built-in arrows. Requires SVG uploads enabled in Elementor.', 'arenex-digital-widgets' ),
        ] );
        $this->add_control( 'handle_icon', [
            'label'       => __( 'Handle Icon (library)', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::ICONS,
            'description' => __( 'Optional. Used only if no SVG/image is uploaded above. Leave empty for the built-in arrows.', 'arenex-digital-widgets' ),
        ] );
        $this->add_control( 'handle_icon_color', [
            'label'     => __( 'Handle Arrow Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#111111',
            'selectors' => [
                // `color` drives currentColor for the built-in chevron, Font Awesome font icons (i), and FA inline-SVG icons (fill:currentColor).
                '{{WRAPPER}} .cmp-ba-handle'             => 'color: {{VALUE}};',
                '{{WRAPPER}} .cmp-ba-handle i'           => 'color: {{VALUE}};',
                '{{WRAPPER}} .cmp-ba-handle svg path'    => 'stroke: {{VALUE}};',
            ],
        ] );
        $this->add_responsive_control( 'handle_size', [
            'label'      => __( 'Handle Size', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 28, 'max' => 80 ] ],
            'default'    => [ 'size' => 46, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-ba-handle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'handle_icon_size', [
            'label'       => __( 'Handle Icon Size', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::SLIDER,
            'size_units'  => [ '%' ],
            'range'       => [ '%' => [ 'min' => 15, 'max' => 90 ] ],
            'default'     => [ 'size' => 40, 'unit' => '%' ],
            'description' => __( 'Icon size relative to the handle.', 'arenex-digital-widgets' ),
            'selectors'   => [
                '{{WRAPPER}} .cmp-ba-handle svg'                => 'width: {{SIZE}}%; height: {{SIZE}}%;',
                '{{WRAPPER}} .cmp-ba-handle .cmp-ba-handle-img' => 'width: {{SIZE}}%; height: {{SIZE}}%;',
            ],
        ] );
        $this->add_responsive_control( 'handle_padding', [
            'label'      => __( 'Handle Inner Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
            'default'    => [ 'size' => 0, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-ba-handle' => 'padding: {{SIZE}}{{UNIT}} !important;' ],
        ] );
        $this->add_responsive_control( 'handle_border_width', [
            'label'       => __( 'Handle Border Width', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::SLIDER,
            'size_units'  => [ 'px' ],
            'range'       => [ 'px' => [ 'min' => 0, 'max' => 12 ] ],
            'default'     => [ 'size' => 0, 'unit' => 'px' ],
            'description' => __( 'Outline ring around the handle. 0 = no ring.', 'arenex-digital-widgets' ),
            'selectors'   => [ '{{WRAPPER}} .cmp-ba-handle' => 'border-style: solid !important; border-width: {{SIZE}}{{UNIT}} !important;' ],
        ] );
        $this->add_control( 'handle_border_color', [
            'label'     => __( 'Handle Border Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .cmp-ba-handle' => 'border-color: {{VALUE}} !important;' ],
        ] );

        $this->end_controls_section();

        /* ════════════════ STYLE — Labels ════════════════ */
        $this->start_controls_section( 'style_labels', [
            'label'     => __( 'Labels', 'arenex-digital-widgets' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_labels' => 'yes' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'label_typography',
            'selector' => '{{WRAPPER}} .cmp-ba-label',
        ] );
        $this->add_responsive_control( 'label_font_size', [
            'label'      => __( 'Font Size', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 9, 'max' => 40 ] ],
            'default'    => [ 'size' => 13, 'unit' => 'px' ],
            'mobile_default' => [ 'size' => 11, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-ba-label' => 'font-size: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_control( 'label_color', [
            'label'     => __( 'Text Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .cmp-ba-label' => 'color: {{VALUE}};' ],
        ] );
        $this->add_control( 'label_bg', [
            'label'     => __( 'Background Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(17,17,17,0.72)',
            'selectors' => [ '{{WRAPPER}} .cmp-ba-label' => 'background: {{VALUE}};' ],
        ] );
        $this->add_responsive_control( 'label_padding', [
            'label'      => __( 'Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'default'    => [ 'top' => '6', 'right' => '12', 'bottom' => '6', 'left' => '12', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .cmp-ba-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'label_radius', [
            'label'      => __( 'Label Radius', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
            'default'    => [ 'size' => 999, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-ba-label' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'label_offset', [
            'label'       => __( 'Edge Offset', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::SLIDER,
            'size_units'  => [ 'px' ],
            'range'       => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'default'     => [ 'size' => 16, 'unit' => 'px' ],
            'selectors'   => [ '{{WRAPPER}} .cmp-ba-figure' => '--cmp-ba-label-offset: {{SIZE}}{{UNIT}};' ],
            'description'  => __( 'Distance of the labels from the image edges (ignored for the "Below" position).', 'arenex-digital-widgets' ),
            'condition'   => [ 'label_position!' => 'below' ],
        ] );

        $this->end_controls_section();
    }

    /** Resolve a MEDIA control to url + dimensions + alt. */
    private function img( array $media, string $fallback_alt ) : array {
        $url = $media['url'] ?? \Elementor\Utils::get_placeholder_image_src();
        $id  = ! empty( $media['id'] ) ? absint( $media['id'] ) : 0;
        $w   = 1200;
        $h   = 800;
        $alt = $fallback_alt;
        if ( $id ) {
            $meta = wp_get_attachment_metadata( $id );
            if ( ! empty( $meta['width'] ) )  $w = absint( $meta['width'] );
            if ( ! empty( $meta['height'] ) ) $h = absint( $meta['height'] );
            $stored = get_post_meta( $id, '_wp_attachment_image_alt', true );
            if ( $stored ) $alt = $stored;
        }
        return [ 'url' => $url, 'w' => $w, 'h' => $h, 'alt' => $alt ];
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $base_alt = ! empty( $s['alt_text'] ) ? $s['alt_text'] : __( 'Before and after comparison', 'arenex-digital-widgets' );
        $before   = $this->img( $s['before_image'] ?? [], __( 'Before image', 'arenex-digital-widgets' ) );
        $after    = $this->img( $s['after_image'] ?? [],  __( 'After image', 'arenex-digital-widgets' ) );

        $handle_svg      = $s['handle_svg'] ?? [];
        $has_handle_svg  = ! empty( $handle_svg['url'] );
        $handle_icon     = $s['handle_icon'] ?? [];
        $has_handle_icon = ! empty( $handle_icon['value'] );

        $orientation = ( $s['orientation'] ?? 'horizontal' ) === 'vertical' ? 'vertical' : 'horizontal';
        $start       = isset( $s['start_position']['size'] ) ? max( 0, min( 100, (float) $s['start_position']['size'] ) ) : 50;
        $hover       = ( $s['hover_mode'] ?? '' ) === 'yes' ? '1' : '0';

        $show_labels = ( $s['show_labels'] ?? 'yes' ) === 'yes';
        $pos         = $s['label_position'] ?? 'top';
        $before_text = $s['before_text'] ?? '';
        $after_text  = $s['after_text'] ?? '';
        $has_labels  = $show_labels && ( $before_text !== '' || $after_text !== '' );

        // Vertical comparison only makes sense for top/bottom corners + handle.
        $section_classes = [ 'cmp-ba-section', 'cmp-widget-section' ];
        ?>
        <div class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>">
            <div class="cmp-ba-inner cmp-widget-inner">
                <div
                    class="cmp-ba-slider cmp-ba-<?php echo esc_attr( $orientation ); ?> cmp-ba-labels-<?php echo esc_attr( $pos ); ?>"
                    data-cmp-before-after
                    data-orientation="<?php echo esc_attr( $orientation ); ?>"
                    data-start="<?php echo esc_attr( $start ); ?>"
                    data-hover="<?php echo esc_attr( $hover ); ?>"
                    style="--cmp-ba-pos: <?php echo esc_attr( $start ); ?>%;"
                >
                    <figure class="cmp-ba-figure">
                        <div class="cmp-ba-after">
                            <img src="<?php echo esc_url( $after['url'] ); ?>" alt="<?php echo esc_attr( $base_alt ); ?>"
                                 width="<?php echo esc_attr( $after['w'] ); ?>" height="<?php echo esc_attr( $after['h'] ); ?>" draggable="false">
                        </div>
                        <div class="cmp-ba-before">
                            <img src="<?php echo esc_url( $before['url'] ); ?>" alt="" aria-hidden="true"
                                 width="<?php echo esc_attr( $before['w'] ); ?>" height="<?php echo esc_attr( $before['h'] ); ?>" draggable="false">
                        </div>

                        <?php if ( $has_labels && $pos !== 'below' ) : ?>
                            <?php if ( $before_text !== '' ) : ?>
                                <span class="cmp-ba-label cmp-ba-label-before"><?php echo esc_html( $before_text ); ?></span>
                            <?php endif; ?>
                            <?php if ( $after_text !== '' ) : ?>
                                <span class="cmp-ba-label cmp-ba-label-after"><?php echo esc_html( $after_text ); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>

                        <div class="cmp-ba-divider" aria-hidden="true"></div>
                        <button type="button" class="cmp-ba-handle"
                                role="slider"
                                aria-label="<?php echo esc_attr__( 'Drag to compare before and after', 'arenex-digital-widgets' ); ?>"
                                aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?php echo esc_attr( round( $start ) ); ?>"
                                tabindex="0">
                            <?php if ( $has_handle_svg ) : ?>
                                <img class="cmp-ba-handle-img" src="<?php echo esc_url( $handle_svg['url'] ); ?>" alt="" aria-hidden="true" draggable="false">
                            <?php elseif ( $has_handle_icon ) :
                                \Elementor\Icons_Manager::render_icon( $handle_icon, [ 'aria-hidden' => 'true' ] );
                            else : ?>
                                <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
                                    <path d="M9.5 7L5 12l4.5 5M14.5 7l4.5 5-4.5 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            <?php endif; ?>
                        </button>
                    </figure>

                    <?php if ( $has_labels && $pos === 'below' ) : ?>
                        <div class="cmp-ba-caption">
                            <span class="cmp-ba-label cmp-ba-label-before"><?php echo esc_html( $before_text ); ?></span>
                            <span class="cmp-ba-label cmp-ba-label-after"><?php echo esc_html( $after_text ); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}
}
