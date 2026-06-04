<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Portfolio_Carousel extends \Elementor\Widget_Base {

    public function get_name() { return 'cmp_portfolio_carousel'; }
    public function get_title() { return __( 'ADW — Portfolio Carousel', 'arenex-digital-widgets' ); }
    public function get_icon() { return 'eicon-slider-push'; }
    public function get_categories() { return [ 'arenex-digital' ]; }

    public function get_style_depends() { return [ 'adw-styles' ]; }
    public function get_script_depends() { return [ 'adw-front' ]; }

    protected function register_controls() {
        /* ── LAYOUT ── */
        $this->start_controls_section( 'section_layout', [ 'label' => __( 'Layout & Speed', 'arenex-digital-widgets' ) ] );

        $this->add_control( 'rows_desktop', [
            'label'   => __( 'Rows on Desktop / Laptop', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '2',
            'options' => [ '1' => '1 Row', '2' => '2 Rows' ],
        ] );

        $this->add_control( 'rows_mobile', [
            'label'   => __( 'Rows on Mobile / Tablet', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => '1',
            'options' => [ '1' => '1 Row', '2' => '2 Rows' ],
        ] );

        $this->add_control( 'row1_speed', [
            'label'   => __( 'Row 1 Speed (seconds) — lower = faster', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SLIDER,
            'range'   => [ 'px' => [ 'min' => 5, 'max' => 120, 'step' => 5 ] ],
            'default' => [ 'size' => 40 ],
        ] );
        $this->add_control( 'row2_speed', [
            'label'   => __( 'Row 2 Speed (seconds) — lower = faster', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SLIDER,
            'range'   => [ 'px' => [ 'min' => 5, 'max' => 120, 'step' => 5 ] ],
            'default' => [ 'size' => 45 ],
            'condition' => [ 'rows_desktop' => '2' ],
        ] );

        $this->add_control( 'mobile_speed_heading', [
            'label'     => __( 'Mobile Speed', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ] );
        $this->add_control( 'mobile_row1_speed', [
            'label'   => __( 'Mobile Row 1 Speed (seconds)', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SLIDER,
            'range'   => [ 'px' => [ 'min' => 5, 'max' => 60, 'step' => 5 ] ],
            'default' => [ 'size' => 25 ],
        ] );
        $this->add_control( 'mobile_row2_speed', [
            'label'   => __( 'Mobile Row 2 Speed (seconds)', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SLIDER,
            'range'   => [ 'px' => [ 'min' => 5, 'max' => 60, 'step' => 5 ] ],
            'default' => [ 'size' => 30 ],
            'condition' => [ 'rows_mobile' => '2' ],
        ] );

        $this->add_control( 'pause_on_hover', [
            'label'        => __( 'Pause on Hover/Touch', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => 'Yes',
            'label_off'    => 'No',
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );
        $this->end_controls_section();

        /* ── Row 1 Items ── */
        $this->start_controls_section( 'section_row1', [ 'label' => __( 'Row 1 Items', 'arenex-digital-widgets' ) ] );
        $r1 = new \Elementor\Repeater();
        $r1->add_control( 'cat', [ 'label' => 'Category', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Corporate' ] );
        $r1->add_control( 'title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Project Name' ] );
        $r1->add_control( 'desc', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Project description.' ] );
        $r1->add_control( 'image', [ 'label' => 'Image', 'type' => \Elementor\Controls_Manager::MEDIA ] );
        $this->add_control( 'row1', [
            'label' => 'Row 1', 'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $r1->get_controls(),
            'default' => [
                [ 'cat' => 'Corporate', 'title' => 'TechCorp Brand Film', 'desc' => "A cinematic brand story for Silicon Valley's fastest-growing startup." ],
                [ 'cat' => 'Real Estate', 'title' => 'Oceanview Villa Tour', 'desc' => 'Luxury property walkthrough with aerial drone footage. Sold in 7 days.' ],
                [ 'cat' => 'Commercial', 'title' => 'Urban Eats Campaign', 'desc' => 'Multi-platform ad campaign for a new restaurant chain launch.' ],
                [ 'cat' => 'Drone', 'title' => 'Downtown Aerial Tour', 'desc' => '4K aerial tour of downtown skyline and waterfront district.' ],
                [ 'cat' => 'Corporate', 'title' => 'Annual Summit Recap', 'desc' => 'Event coverage and highlight reel for a 3-day industry conference.' ],
                [ 'cat' => 'Real Estate', 'title' => 'Hillside Ranch Estate', 'desc' => 'Full cinematic production for a $4.5M ranch property listing.' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );
        $this->end_controls_section();

        /* ── Row 2 Items ── */
        $this->start_controls_section( 'section_row2', [ 'label' => __( 'Row 2 Items', 'arenex-digital-widgets' ) ] );
        $r2 = new \Elementor\Repeater();
        $r2->add_control( 'cat', [ 'label' => 'Category', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Social Media' ] );
        $r2->add_control( 'title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Project Name' ] );
        $r2->add_control( 'desc', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Project description.' ] );
        $r2->add_control( 'image', [ 'label' => 'Image', 'type' => \Elementor\Controls_Manager::MEDIA ] );
        $this->add_control( 'row2', [
            'label' => 'Row 2', 'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $r2->get_controls(),
            'default' => [
                [ 'cat' => 'Social Media', 'title' => 'Fitness Brand Reels', 'desc' => 'Monthly social content package for a premium fitness brand.' ],
                [ 'cat' => 'Commercial', 'title' => 'Auto Dealership Spot', 'desc' => '30-second TV commercial for a luxury auto dealership.' ],
                [ 'cat' => 'Real Estate', 'title' => 'Penthouse Sky Loft', 'desc' => 'Downtown penthouse with city views. Drone and interior coverage.' ],
                [ 'cat' => 'Corporate', 'title' => 'Product Launch Event', 'desc' => 'Live event coverage and post-event highlight film.' ],
                [ 'cat' => 'Drone', 'title' => 'Coastal Resort Flyover', 'desc' => 'Aerial showcase of a beachfront resort property and grounds.' ],
                [ 'cat' => 'Commercial', 'title' => 'Fashion Lookbook Film', 'desc' => 'Cinematic fashion film for a seasonal collection launch.' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );
        $this->end_controls_section();

        /* ── STYLE ── */
        $this->start_controls_section( 'style_carousel', [ 'label' => __( 'Style', 'arenex-digital-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );
        $this->add_control( 'item_radius', [ 'label' => __( 'Card Border Radius', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ], 'selectors' => [ '{{WRAPPER}} .cmp-carousel-item' => 'border-radius: {{SIZE}}px;' ] ] );
        $this->add_control( 'item_width', [ 'label' => __( 'Card Width (px)', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 150, 'max' => 600 ] ], 'default' => [ 'size' => 350 ], 'selectors' => [ '{{WRAPPER}} .cmp-carousel-item' => 'width: {{SIZE}}px;' ] ] );
        $this->add_control( 'item_height', [ 'label' => __( 'Card Height (px)', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 100, 'max' => 500 ] ], 'default' => [ 'size' => 240 ], 'selectors' => [ '{{WRAPPER}} .cmp-carousel-item' => 'height: {{SIZE}}px;' ] ] );
        $this->add_control( 'overlay_bg', [ 'label' => __( 'Overlay Background', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ], 'selectors' => [ '{{WRAPPER}} .cmp-carousel-item-overlay' => 'background: linear-gradient(to top, {{VALUE}} 0%, transparent 60%);' ] ] );
        $this->add_control( 'cat_color', [ 'label' => __( 'Category Label Color', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ], 'selectors' => [ '{{WRAPPER}} .cmp-carousel-item-overlay span' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'item_title_color', [ 'label' => __( 'Item Title Color', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ], 'selectors' => [ '{{WRAPPER}} .cmp-carousel-item-overlay h4' => 'color: {{VALUE}};' ] ] );

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
            'selectors'  => [ '{{WRAPPER}} .cmp-carousel-wrapper' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s             = $this->get_settings_for_display();
        $global_index  = 0;
        $r1_speed      = ! empty( $s['row1_speed']['size'] )        ? intval( $s['row1_speed']['size'] )        : 40;
        $r2_speed      = ! empty( $s['row2_speed']['size'] )        ? intval( $s['row2_speed']['size'] )        : 45;
        $mob_r1_speed  = ! empty( $s['mobile_row1_speed']['size'] ) ? intval( $s['mobile_row1_speed']['size'] ) : 25;
        $mob_r2_speed  = ! empty( $s['mobile_row2_speed']['size'] ) ? intval( $s['mobile_row2_speed']['size'] ) : 30;
        $rows_desktop  = isset( $s['rows_desktop'] ) ? $s['rows_desktop'] : '2';
        $rows_mobile   = isset( $s['rows_mobile'] )  ? $s['rows_mobile']  : '1';

        $wrapper_class = 'cmp-carousel-wrapper cmp-reveal';
        $wrapper_class .= ' cmp-car-desk-' . $rows_desktop;
        $wrapper_class .= ' cmp-car-mob-' . $rows_mobile;
        ?>
        <div class="<?php echo esc_attr( $wrapper_class ); ?>">
            <!-- Row 1 -->
            <div class="cmp-carousel-row cmp-carousel-row-1"
                 data-speed="<?php echo esc_attr( $r1_speed ); ?>"
                 data-mob-speed="<?php echo esc_attr( $mob_r1_speed ); ?>">
                <?php for ( $dup = 0; $dup < 2; $dup++ ) : foreach ( $s['row1'] as $item ) : ?>
                <div class="cmp-carousel-item"
                     data-index="<?php echo esc_attr( $global_index ); ?>"
                     data-cat="<?php echo esc_attr( $item['cat'] ); ?>"
                     data-title="<?php echo esc_attr( $item['title'] ); ?>"
                     data-desc="<?php echo esc_attr( $item['desc'] ); ?>">
                    <div class="cmp-carousel-item-bg" style="<?php echo ! empty( $item['image']['url'] ) ? 'background-image:url(' . esc_url( $item['image']['url'] ) . ')' : ''; ?>"></div>
                    <div class="cmp-carousel-item-overlay">
                        <span><?php echo esc_html( $item['cat'] ); ?></span>
                        <h4><?php echo esc_html( $item['title'] ); ?></h4>
                    </div>
                </div>
                <?php $global_index++; endforeach; endfor; ?>
            </div>
            <!-- Row 2 -->
            <div class="cmp-carousel-row cmp-carousel-row-2"
                 data-speed="<?php echo esc_attr( $r2_speed ); ?>"
                 data-mob-speed="<?php echo esc_attr( $mob_r2_speed ); ?>">
                <?php $gi2 = count( $s['row1'] ); for ( $dup = 0; $dup < 2; $dup++ ) : foreach ( $s['row2'] as $item ) : ?>
                <div class="cmp-carousel-item"
                     data-index="<?php echo esc_attr( $gi2 ); ?>"
                     data-cat="<?php echo esc_attr( $item['cat'] ); ?>"
                     data-title="<?php echo esc_attr( $item['title'] ); ?>"
                     data-desc="<?php echo esc_attr( $item['desc'] ); ?>">
                    <div class="cmp-carousel-item-bg" style="<?php echo ! empty( $item['image']['url'] ) ? 'background-image:url(' . esc_url( $item['image']['url'] ) . ')' : ''; ?>"></div>
                    <div class="cmp-carousel-item-overlay">
                        <span><?php echo esc_html( $item['cat'] ); ?></span>
                        <h4><?php echo esc_html( $item['title'] ); ?></h4>
                    </div>
                </div>
                <?php $gi2++; endforeach; endfor; ?>
            </div>
        </div>

        <!-- Lightbox -->
        <div class="cmp-lightbox">
            <div class="cmp-lightbox-content">
                <button class="cmp-lightbox-close">&times;</button>
                <button class="cmp-lightbox-nav cmp-lightbox-prev">&#8249;</button>
                <button class="cmp-lightbox-nav cmp-lightbox-next">&#8250;</button>
                <div class="cmp-lightbox-img"></div>
                <div class="cmp-lightbox-info">
                    <span class="cmp-lightbox-cat"></span>
                    <h3 class="cmp-lightbox-title"></h3>
                    <p class="cmp-lightbox-desc"></p>
                </div>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}
}
