<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Vertical_Image_Gallery extends \Elementor\Widget_Base {

    public function get_name()       { return 'cmp_vertical_image_gallery'; }
    public function get_title()      { return __( 'ADW — Vertical Image Gallery', 'arenex-digital-widgets' ); }
    public function get_icon()       { return 'eicon-gallery-grid'; }
    public function get_categories() { return [ 'arenex-digital' ]; }
    public function get_keywords()   { return [ 'gallery', 'vertical', 'carousel', 'images', 'scroll' ]; }
    public function get_style_depends()  { return [ 'adw-styles' ]; }
    public function get_script_depends() { return [ 'adw-front' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_images', [
            'label' => __( 'Images', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'image', [
            'label'   => __( 'Image', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );
        $repeater->add_control( 'alt_text', [
            'label'       => __( 'Alt Text', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => __( 'Project gallery image', 'arenex-digital-widgets' ),
            'label_block' => true,
        ] );

        $this->add_control( 'images', [
            'label'       => __( 'Gallery Images', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'alt_text' => __( 'Excavation project image', 'arenex-digital-widgets' ) ],
                [ 'alt_text' => __( 'Site preparation project image', 'arenex-digital-widgets' ) ],
                [ 'alt_text' => __( 'Land clearing project image', 'arenex-digital-widgets' ) ],
                [ 'alt_text' => __( 'Septic installation project image', 'arenex-digital-widgets' ) ],
                [ 'alt_text' => __( 'Grading project image', 'arenex-digital-widgets' ) ],
                [ 'alt_text' => __( 'Finished excavation project image', 'arenex-digital-widgets' ) ],
            ],
            'title_field' => '{{{ alt_text }}}',
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_behavior', [
            'label' => __( 'Behavior', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'autoplay', [
            'label'        => __( 'Auto Scroll', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
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
        $this->add_control( 'scroll_speed', [
            'label'     => __( 'Scroll Duration (seconds)', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::NUMBER,
            'min'       => 8,
            'max'       => 120,
            'step'      => 1,
            'default'   => 34,
            'condition' => [ 'autoplay' => 'yes' ],
        ] );
        $this->add_control( 'direction', [
            'label'   => __( 'First Column Direction', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'up',
            'options' => [
                'up'   => __( 'Up', 'arenex-digital-widgets' ),
                'down' => __( 'Down', 'arenex-digital-widgets' ),
            ],
            'condition' => [ 'autoplay' => 'yes' ],
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
            'selectors'  => [ '{{WRAPPER}} .cmp-vig-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'max_width', [
            'label'      => __( 'Max Width', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range'      => [ 'px' => [ 'min' => 260, 'max' => 1600 ], '%' => [ 'min' => 20, 'max' => 100 ] ],
            'default'    => [ 'size' => 720, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-vig-inner' => 'max-width: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'columns', [
            'label'          => __( 'Columns', 'arenex-digital-widgets' ),
            'type'           => \Elementor\Controls_Manager::SELECT,
            'default'        => '2',
            'tablet_default' => '2',
            'mobile_default' => '2',
            'description'    => __( 'The gallery renders two scrolling tracks — keep 2 columns on mobile so both stay visible.', 'arenex-digital-widgets' ),
            'options'        => [
                '1' => __( '1', 'arenex-digital-widgets' ),
                '2' => __( '2', 'arenex-digital-widgets' ),
            ],
            'selectors'      => [ '{{WRAPPER}} .cmp-vig-columns' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ],
        ] );
        $this->add_responsive_control( 'column_gap', [
            'label'      => __( 'Column Gap', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
            'default'    => [ 'size' => 24, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-vig-columns' => 'column-gap: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'row_gap', [
            'label'      => __( 'Image Gap', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
            'default'    => [ 'size' => 20, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-vig-track' => 'gap: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'gallery_height', [
            'label'          => __( 'Gallery Height', 'arenex-digital-widgets' ),
            'type'           => \Elementor\Controls_Manager::SLIDER,
            'size_units'     => [ 'px', 'vh' ],
            'range'          => [ 'px' => [ 'min' => 260, 'max' => 1200 ], 'vh' => [ 'min' => 30, 'max' => 100 ] ],
            'default'        => [ 'size' => 680, 'unit' => 'px' ],
            'tablet_default' => [ 'size' => 560, 'unit' => 'px' ],
            'mobile_default' => [ 'size' => 440, 'unit' => 'px' ],
            'selectors'      => [ '{{WRAPPER}} .cmp-vig-columns' => 'height: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'style_images', [
            'label' => __( 'Images', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'image_height', [
            'label'          => __( 'Image Height', 'arenex-digital-widgets' ),
            'type'           => \Elementor\Controls_Manager::SLIDER,
            'size_units'     => [ 'px', 'vh' ],
            'range'          => [ 'px' => [ 'min' => 120, 'max' => 720 ], 'vh' => [ 'min' => 10, 'max' => 70 ] ],
            'default'        => [ 'size' => 230, 'unit' => 'px' ],
            'mobile_default' => [ 'size' => 170, 'unit' => 'px' ],
            'selectors'      => [ '{{WRAPPER}} .cmp-vig-item img' => 'height: {{SIZE}}{{UNIT}};' ],
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
            'selectors' => [ '{{WRAPPER}} .cmp-vig-item img' => 'object-fit: {{VALUE}};' ],
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
            'selectors' => [ '{{WRAPPER}} .cmp-vig-item img' => 'object-position: {{VALUE}};' ],
        ] );
        $this->add_responsive_control( 'image_radius', [
            'label'      => __( 'Image Radius', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'default'    => [ 'size' => 8, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-vig-item img' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_control( 'image_opacity', [
            'label'     => __( 'Image Opacity', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::NUMBER,
            'min'       => 0.1,
            'max'       => 1,
            'step'      => 0.05,
            'default'   => 1,
            'selectors' => [ '{{WRAPPER}} .cmp-vig-item img' => 'opacity: {{VALUE}};' ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
            'name'     => 'image_border',
            'selector' => '{{WRAPPER}} .cmp-vig-item img',
        ] );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
            'name'     => 'image_shadow',
            'selector' => '{{WRAPPER}} .cmp-vig-item img',
        ] );

        $this->end_controls_section();
    }

    private function get_image_data( array $item, string $fallback_alt ) : array {
        $image  = $item['image'] ?? [];
        $url    = $image['url'] ?? \Elementor\Utils::get_placeholder_image_src();
        $id     = ! empty( $image['id'] ) ? absint( $image['id'] ) : 0;
        $width  = 1200;
        $height = 800;
        $alt    = ! empty( $item['alt_text'] ) ? $item['alt_text'] : $fallback_alt;

        if ( $id ) {
            $meta = wp_get_attachment_metadata( $id );
            if ( ! empty( $meta['width'] ) )  $width  = absint( $meta['width'] );
            if ( ! empty( $meta['height'] ) ) $height = absint( $meta['height'] );
            $stored_alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
            if ( $stored_alt && empty( $item['alt_text'] ) ) {
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

    private function render_image_item( array $item, int $index, bool $duplicate = false ) : void {
        $data = $this->get_image_data( $item, sprintf( __( 'Gallery image %d', 'arenex-digital-widgets' ), $index + 1 ) );
        $alt  = $duplicate ? '' : $data['alt'];
        ?>
        <figure class="cmp-vig-item"<?php echo $duplicate ? ' aria-hidden="true"' : ''; ?>>
            <img
                src="<?php echo esc_url( $data['url'] ); ?>"
                alt="<?php echo esc_attr( $alt ); ?>"
                width="<?php echo esc_attr( $data['width'] ); ?>"
                height="<?php echo esc_attr( $data['height'] ); ?>"
                loading="lazy"
            >
        </figure>
        <?php
    }

    protected function render() {
        $s      = $this->get_settings_for_display();
        $images = ! empty( $s['images'] ) && is_array( $s['images'] ) ? $s['images'] : [];
        if ( empty( $images ) ) return;

        $cols = [ [], [] ];
        foreach ( $images as $index => $image ) {
            $cols[ $index % 2 ][] = [ 'item' => $image, 'index' => $index ];
        }

        $autoplay = ( $s['autoplay'] ?? 'yes' ) === 'yes' ? '1' : '0';
        $pause    = ( $s['pause_on_hover'] ?? 'yes' ) === 'yes' ? '1' : '0';
        $speed    = ! empty( $s['scroll_speed'] ) ? absint( $s['scroll_speed'] ) : 34;
        $dir      = in_array( ( $s['direction'] ?? 'up' ), [ 'up', 'down' ], true ) ? $s['direction'] : 'up';
        ?>
        <section
            class="cmp-vig-section cmp-widget-section"
            data-cmp-vertical-gallery
            data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
            data-pause-hover="<?php echo esc_attr( $pause ); ?>"
            data-speed="<?php echo esc_attr( $speed ); ?>"
            data-direction="<?php echo esc_attr( $dir ); ?>"
        >
            <div class="cmp-vig-inner cmp-widget-inner">
                <div class="cmp-vig-columns" aria-label="<?php echo esc_attr__( 'Vertical image gallery', 'arenex-digital-widgets' ); ?>">
                    <?php foreach ( $cols as $col_index => $column ) :
                        if ( empty( $column ) ) continue;
                        $column_dir = ( $col_index % 2 === 0 ) ? $dir : ( $dir === 'up' ? 'down' : 'up' );
                    ?>
                    <div class="cmp-vig-column" data-direction="<?php echo esc_attr( $column_dir ); ?>">
                        <div class="cmp-vig-track">
                            <?php foreach ( $column as $entry ) $this->render_image_item( $entry['item'], $entry['index'] ); ?>
                            <?php foreach ( $column as $entry ) $this->render_image_item( $entry['item'], $entry['index'], true ); ?>
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
