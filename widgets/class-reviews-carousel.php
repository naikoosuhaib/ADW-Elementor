<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Reviews_Carousel extends \Elementor\Widget_Base {

    public function get_name()       { return 'cmp_reviews_carousel'; }
    public function get_title()      { return __( 'ADW — Reviews Carousel', 'arenex-digital-widgets' ); }
    public function get_icon()       { return 'eicon-review'; }
    public function get_categories() { return [ 'arenex-digital' ]; }
    public function get_style_depends()  { return [ 'adw-styles' ]; }
    public function get_script_depends() { return [ 'adw-front' ]; }

    protected function register_controls() {

        /* ── CONTENT: Reviews ── */
        $this->start_controls_section( 'section_reviews', [ 'label' => __( 'Reviews', 'arenex-digital-widgets' ) ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'stars', [ 'label' => __( 'Stars (1-5)', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::NUMBER, 'min' => 1, 'max' => 5, 'default' => 5 ] );
        $repeater->add_control( 'quote', [ 'label' => __( 'Quote', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => __( 'Enter review quote here.', 'arenex-digital-widgets' ) ] );
        $repeater->add_control( 'image', [
            'label'       => __( 'Avatar Image', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::MEDIA,
            'description' => __( 'Optional. When an image is selected, the initials will be hidden.', 'arenex-digital-widgets' ),
        ] );
        $repeater->add_control( 'initials', [
            'label'       => __( 'Initials', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => 'AB',
            'description' => __( 'Used as avatar fallback when no image is set.', 'arenex-digital-widgets' ),
        ] );
        $repeater->add_control( 'name', [ 'label' => __( 'Name', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Client Name', 'arenex-digital-widgets' ) ] );
        $repeater->add_control( 'role', [ 'label' => __( 'Role / Location', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => __( 'Happy Client', 'arenex-digital-widgets' ) ] );

        $this->add_control( 'reviews', [
            'label'  => __( 'Reviews', 'arenex-digital-widgets' ),
            'type'   => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                [ 'stars' => 5, 'quote' => 'Absolutely outstanding service. The team was professional, on time, and the finished result exceeded our expectations.', 'initials' => 'JM', 'name' => 'James Miller', 'role' => 'Homeowner' ],
                [ 'stars' => 5, 'quote' => 'Quick response, great communication from start to finish. Would not hesitate to recommend to anyone looking for quality work.', 'initials' => 'KD', 'name' => 'Karen Davis', 'role' => 'Property Owner' ],
                [ 'stars' => 5, 'quote' => 'Got three quotes and chose this team for their thoroughness. Fair pricing, solid craftsmanship, and they left the site immaculate.', 'initials' => 'TP', 'name' => 'Tom Peterson', 'role' => 'Business Owner' ],
                [ 'stars' => 5, 'quote' => 'The crew was respectful, on time, and left everything cleaner than they found it. Exceptional from first call to final walkthrough.', 'initials' => 'SB', 'name' => 'Sarah Brooks', 'role' => 'Happy Client' ],
                [ 'stars' => 5, 'quote' => 'They helped us navigate a complicated project and had everything completed ahead of schedule. Lifesavers — genuine professionals.', 'initials' => 'MR', 'name' => 'Mike Reynolds', 'role' => 'Homeowner' ],
                [ 'stars' => 5, 'quote' => 'We use this company for all our properties. Consistent quality, honest assessments, and they stand behind their work every single time.', 'initials' => 'LW', 'name' => 'Linda Walsh', 'role' => 'Property Manager' ],
            ],
            'title_field' => '{{{ name }}}',
        ] );

        $this->end_controls_section();

        /* ── CONTENT: Settings ── */
        $this->start_controls_section( 'section_settings', [ 'label' => __( 'Settings', 'arenex-digital-widgets' ) ] );

        $this->add_control( 'speed', [
            'label'       => __( 'Duration in seconds (Desktop)', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'min'         => 5,
            'max'         => 120,
            'default'     => 35,
            'description' => __( 'Lower = faster scroll.', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'speed_tablet', [
            'label'       => __( 'Duration in seconds (Tablet)', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'min'         => 5,
            'max'         => 120,
            'default'     => 25,
            'description' => __( 'Leave empty to inherit desktop value.', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'speed_mobile', [
            'label'       => __( 'Duration in seconds (Mobile)', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'min'         => 5,
            'max'         => 120,
            'default'     => 15,
            'description' => __( 'Leave empty to inherit tablet/desktop value.', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'pause_on_hover', [
            'label'        => __( 'Pause on Hover', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
        ] );

        $this->add_responsive_control( 'card_width', [
            'label'          => __( 'Card Width', 'arenex-digital-widgets' ),
            'type'           => \Elementor\Controls_Manager::SLIDER,
            'size_units'     => [ 'px' ],
            'range'          => [ 'px' => [ 'min' => 240, 'max' => 600 ] ],
            'default'        => [ 'size' => 380, 'unit' => 'px' ],
            'tablet_default' => [ 'size' => 340, 'unit' => 'px' ],
            'mobile_default' => [ 'size' => 300, 'unit' => 'px' ],
            'selectors'      => [ '{{WRAPPER}} .cmp-review-card' => 'flex: 0 0 {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();

        /* ── STYLE: Section ── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Section', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'section_bg', [
            'label'     => __( 'Background Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-reviews-carousel' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'          => __( 'Section Padding', 'arenex-digital-widgets' ),
            'type'           => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units'     => [ 'px', 'em', '%' ],
            'default'        => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'tablet_default' => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'mobile_default' => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'selectors'      => [ '{{WRAPPER}} .cmp-reviews-carousel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();

        /* ── STYLE: Cards ── */
        $this->start_controls_section( 'style_card', [
            'label' => __( 'Cards', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'card_bg', [
            'label'     => __( 'Card Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-review-card' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'card_border_radius', [
            'label'      => __( 'Border Radius', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'default'    => [ 'top' => '4', 'right' => '4', 'bottom' => '4', 'left' => '4', 'unit' => 'px', 'isLinked' => true ],
            'selectors'  => [ '{{WRAPPER}} .cmp-review-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'card_padding', [
            'label'      => __( 'Card Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'default'    => [ 'top' => '32', 'right' => '32', 'bottom' => '32', 'left' => '32', 'unit' => 'px', 'isLinked' => true ],
            'selectors'  => [ '{{WRAPPER}} .cmp-review-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_control( 'hover_border_color', [
            'label'     => __( 'Hover Accent Border', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#B71C1C',
            'selectors' => [ '{{WRAPPER}} .cmp-review-card:hover' => 'border-top-color: {{VALUE}};' ],
        ] );

        $this->end_controls_section();

        /* ── STYLE: Content ── */
        $this->start_controls_section( 'style_content', [
            'label' => __( 'Content', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'stars_color', [
            'label'     => __( 'Stars Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#F59E0B',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-review-stars' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'quote_color', [
            'label'     => __( 'Quote Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#3A3A3A',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'selectors' => [ '{{WRAPPER}} .cmp-review-quote' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'quote_typography',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-review-quote',
        ] );

        $this->add_control( 'name_color', [
            'label'     => __( 'Name Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#1A1A1A',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-review-name' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'role_color', [
            'label'     => __( 'Role Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#6E6E6E',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'selectors' => [ '{{WRAPPER}} .cmp-review-role' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'avatar_bg', [
            'label'     => __( 'Avatar Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#B71C1C',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-review-avatar' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'avatar_color', [
            'label'     => __( 'Avatar Text Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-review-avatar' => 'color: {{VALUE}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s       = $this->get_settings_for_display();
        $reviews = $s['reviews'];
        $speed   = ! empty( $s['speed'] )        ? intval( $s['speed'] )        : 35;
        $speed_t = ! empty( $s['speed_tablet'] ) ? intval( $s['speed_tablet'] ) : $speed;
        $speed_m = ! empty( $s['speed_mobile'] ) ? intval( $s['speed_mobile'] ) : $speed_t;
        $pause   = ( isset( $s['pause_on_hover'] ) && $s['pause_on_hover'] === 'yes' ) ? 'yes' : 'no';

        // Build the responsive speed CSS custom props as an inline style on the track element
        $track_style = '--review-speed:' . $speed . 's; --review-speed-t:' . $speed_t . 's; --review-speed-m:' . $speed_m . 's;';
        ?>
        <section class="cmp-reviews-carousel cmp-reveal">
            <div class="cmp-reviews-track-wrap">
                <div class="cmp-reviews-track" data-pause="<?php echo esc_attr( $pause ); ?>" style="<?php echo esc_attr( $track_style ); ?>">
                    <?php
                    $render_card = function( $review ) {
                        $stars   = str_repeat( "\xe2\x98\x85", intval( $review['stars'] ?? 5 ) );
                        $img_url = ! empty( $review['image']['url'] ) ? $review['image']['url'] : '';
                        $name    = $review['name'] ?? '';
                        ?>
                        <div class="cmp-review-card">
                            <div class="cmp-review-stars"><?php echo esc_html( $stars ); ?></div>
                            <blockquote class="cmp-review-quote">&ldquo;<?php echo esc_html( $review['quote'] ); ?>&rdquo;</blockquote>
                            <div class="cmp-review-author">
                                <?php if ( $img_url ) : ?>
                                    <img class="cmp-review-avatar cmp-review-avatar--img" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy" />
                                <?php else : ?>
                                    <div class="cmp-review-avatar"><?php echo esc_html( $review['initials'] ?? '' ); ?></div>
                                <?php endif; ?>
                                <div class="cmp-review-author-info">
                                    <strong class="cmp-review-name"><?php echo esc_html( $name ); ?></strong>
                                    <span class="cmp-review-role"><?php echo esc_html( $review['role'] ?? '' ); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php
                    };
                    foreach ( $reviews as $review ) { $render_card( $review ); }
                    ?>
                    <div aria-hidden="true" style="display:contents;">
                        <?php foreach ( $reviews as $review ) { $render_card( $review ); } ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }

    protected function content_template() {}
}
