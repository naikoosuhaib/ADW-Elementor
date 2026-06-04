<?php
/**
 * ADW — Testimonials
 *
 * Single-card testimonial carousel with floating avatar orbit background.
 * Distinct from ADW — Reviews Carousel (which is the infinite marquee).
 *
 * Style 1 (default): Orbit — 10 customizable background avatars surround a central
 * testimonial card with prev/next + dot navigation and autoplay.
 * Future styles can be added via the Style selector.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Testimonials extends \Elementor\Widget_Base {

    public function get_name()       { return 'cmp_testimonials'; }
    public function get_title()      { return __( 'ADW — Testimonials', 'arenex-digital-widgets' ); }
    public function get_icon()       { return 'eicon-testimonial-carousel'; }
    public function get_categories() { return [ 'arenex-digital' ]; }
    public function get_style_depends()  { return [ 'adw-styles' ]; }
    public function get_script_depends() { return [ 'adw-front' ]; }

    protected function register_controls() {

        /* ==========================================
           CONTENT TAB — Layout
           ========================================== */
        $this->start_controls_section( 'section_layout', [
            'label' => __( 'Layout', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'design_style', [
            'label'   => __( 'Design Style', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'style-orbit',
            'options' => [
                'style-orbit' => __( 'Style 1 — Orbit (avatars surround card)', 'arenex-digital-widgets' ),
            ],
            'description' => __( 'More styles coming soon.', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'autoplay', [
            'label' => __( 'Autoplay', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ] );

        $this->add_control( 'autoplay_speed', [
            'label' => __( 'Autoplay Speed (ms)', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::NUMBER,
            'min'   => 2000,
            'max'   => 20000,
            'step'  => 500,
            'default' => 6000,
            'condition' => [ 'autoplay' => 'yes' ],
        ] );

        $this->add_control( 'pause_on_hover', [
            'label' => __( 'Pause on Hover', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
            'condition' => [ 'autoplay' => 'yes' ],
        ] );

        $this->add_responsive_control( 'stage_min_height', [
            'label' => __( 'Stage Min Height', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range' => [ 'px' => [ 'min' => 400, 'max' => 900 ] ],
            'default' => [ 'size' => 640, 'unit' => 'px' ],
            'tablet_default' => [ 'size' => 0, 'unit' => 'px' ],
            'mobile_default' => [ 'size' => 0, 'unit' => 'px' ],
            'selectors' => [ '{{WRAPPER}} .cmp-tst-stage' => 'min-height: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'card_max_width', [
            'label' => __( 'Card Max Width', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range' => [ 'px' => [ 'min' => 400, 'max' => 800 ] ],
            'default' => [ 'size' => 620, 'unit' => 'px' ],
            'selectors' => [ '{{WRAPPER}} .cmp-tst-center' => 'max-width: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();

        /* ==========================================
           CONTENT TAB — Testimonials (repeater)
           ========================================== */
        $this->start_controls_section( 'section_testimonials', [
            'label' => __( 'Testimonials', 'arenex-digital-widgets' ),
        ] );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control( 'quote', [
            'label'   => __( 'Quote', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __( "Their care made all the difference. Compassionate, on time, and professional every single visit.", 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'author_name', [
            'label'   => __( 'Author Name', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Maria L.', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'author_meta', [
            'label'   => __( 'Author Role / Location', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Daughter · Los Angeles', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'author_photo', [
            'label' => __( 'Author Photo', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );

        $this->add_control( 'testimonials', [
            'label' => __( 'Testimonials', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                [
                    'quote'        => __( "After my mother's hip surgery, we didn't know how we'd manage at home. The OPRA team showed up the first day with a plan, treated her with patience, and made sure my dad understood every step. Six weeks later she was walking again.", 'arenex-digital-widgets' ),
                    'author_name'  => 'Maria L.',
                    'author_meta'  => __( 'Daughter · Los Angeles', 'arenex-digital-widgets' ),
                    'author_photo' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
                ],
                [
                    'quote'        => __( "My nurse from OPRA caught a complication early that probably saved me a hospital stay. They don't just check boxes — they pay attention.", 'arenex-digital-widgets' ),
                    'author_name'  => 'Robert T.',
                    'author_meta'  => __( 'Patient · Westwood', 'arenex-digital-widgets' ),
                    'author_photo' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
                ],
                [
                    'quote'        => __( "Professional, kind, and on time every single visit. They explained everything to my dad in a way he could understand — and made him feel respected, not rushed.", 'arenex-digital-widgets' ),
                    'author_name'  => 'Jennifer K.',
                    'author_meta'  => __( 'Daughter · Brentwood', 'arenex-digital-widgets' ),
                    'author_photo' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
                ],
            ],
            'title_field' => '{{{ author_name }}}',
        ] );

        $this->end_controls_section();

        /* ==========================================
           CONTENT TAB — Background Avatars
           ========================================== */
        $this->start_controls_section( 'section_avatars', [
            'label' => __( 'Background Avatars', 'arenex-digital-widgets' ),
            'description' => __( 'Floating circular avatars surrounding the testimonial card. 10 positions are pre-defined; add or remove as needed.', 'arenex-digital-widgets' ),
        ] );

        $av_repeater = new \Elementor\Repeater();

        $av_repeater->add_control( 'avatar_image', [
            'label' => __( 'Image', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );

        $av_repeater->add_control( 'avatar_alt', [
            'label'   => __( 'Alt Text (optional)', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '',
        ] );

        $this->add_control( 'avatars', [
            'label' => __( 'Avatars', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::REPEATER,
            'fields' => $av_repeater->get_controls(),
            'default' => [
                [ 'avatar_image' => [ 'url' => 'https://randomuser.me/api/portraits/women/65.jpg' ] ],
                [ 'avatar_image' => [ 'url' => 'https://randomuser.me/api/portraits/men/72.jpg' ] ],
                [ 'avatar_image' => [ 'url' => 'https://randomuser.me/api/portraits/women/45.jpg' ] ],
                [ 'avatar_image' => [ 'url' => 'https://randomuser.me/api/portraits/men/52.jpg' ] ],
                [ 'avatar_image' => [ 'url' => 'https://randomuser.me/api/portraits/women/76.jpg' ] ],
                [ 'avatar_image' => [ 'url' => 'https://randomuser.me/api/portraits/men/68.jpg' ] ],
                [ 'avatar_image' => [ 'url' => 'https://randomuser.me/api/portraits/women/55.jpg' ] ],
                [ 'avatar_image' => [ 'url' => 'https://randomuser.me/api/portraits/men/41.jpg' ] ],
                [ 'avatar_image' => [ 'url' => 'https://randomuser.me/api/portraits/women/82.jpg' ] ],
                [ 'avatar_image' => [ 'url' => 'https://randomuser.me/api/portraits/men/85.jpg' ] ],
            ],
            'title_field' => 'Avatar {{{ "#" }}}',
        ] );

        $this->end_controls_section();

        /* ==========================================
           CONTENT TAB — Element Visibility
           ========================================== */
        $this->start_controls_section( 'section_visibility', [
            'label' => __( 'Element Visibility', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'show_orbit', [
            'label' => __( 'Show Background Avatars', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ] );
        $this->add_control( 'show_rings', [
            'label' => __( 'Show Decorative Rings', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ] );
        $this->add_control( 'show_quote_mark', [
            'label' => __( 'Show Quote Mark', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ] );
        $this->add_control( 'show_author_photo', [
            'label' => __( 'Show Author Photo', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ] );
        $this->add_control( 'show_nav_buttons', [
            'label' => __( 'Show Prev/Next Buttons', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ] );
        $this->add_control( 'show_dots', [
            'label' => __( 'Show Dot Indicators', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ] );
        $this->add_control( 'show_schema', [
            'label' => __( 'Output Review Schema (SEO)', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ] );

        $this->end_controls_section();

        /* ==========================================
           STYLE TAB — Card
           ========================================== */
        $this->start_controls_section( 'style_card', [
            'label' => __( 'Card', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'card_bg', [
            'label' => __( 'Background', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#FFFFFF',
            'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-tst-card' => 'background: {{VALUE}};' ],
        ] );

        $this->add_control( 'card_border_color', [
            'label' => __( 'Border Color', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#E8DDC7',
            'selectors' => [ '{{WRAPPER}} .cmp-tst-card' => 'border-color: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'card_border_width', [
            'label' => __( 'Border Width', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range' => [ 'px' => [ 'min' => 0, 'max' => 4 ] ],
            'default' => [ 'size' => 1, 'unit' => 'px' ],
            'selectors' => [ '{{WRAPPER}} .cmp-tst-card' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;' ],
        ] );

        $this->add_responsive_control( 'card_radius', [
            'label' => __( 'Border Radius', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
            'default' => [ 'size' => 16, 'unit' => 'px' ],
            'selectors' => [ '{{WRAPPER}} .cmp-tst-card' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'card_padding', [
            'label' => __( 'Padding', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'default' => [ 'top' => '44', 'right' => '44', 'bottom' => '36', 'left' => '44', 'unit' => 'px', 'isLinked' => false ],
            'mobile_default' => [ 'top' => '32', 'right' => '24', 'bottom' => '28', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
            'selectors' => [ '{{WRAPPER}} .cmp-tst-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
            'name' => 'card_shadow',
            'selector' => '{{WRAPPER}} .cmp-tst-card',
        ] );

        $this->end_controls_section();

        /* ==========================================
           STYLE TAB — Quote
           ========================================== */
        $this->start_controls_section( 'style_quote', [
            'label' => __( 'Quote', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'quote_mark_color', [
            'label' => __( 'Quote Mark Color', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#C9A26B',
            'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-tst-mark' => 'color: {{VALUE}};' ],
            'condition' => [ 'show_quote_mark' => 'yes' ],
        ] );

        $this->add_control( 'quote_mark_opacity', [
            'label' => __( 'Quote Mark Opacity', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SLIDER,
            'range' => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
            'default' => [ 'size' => 0.55 ],
            'selectors' => [ '{{WRAPPER}} .cmp-tst-mark' => 'opacity: {{SIZE}};' ],
            'condition' => [ 'show_quote_mark' => 'yes' ],
        ] );

        $this->add_control( 'quote_color', [
            'label' => __( 'Quote Text Color', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#2B1F15',
            'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'selectors' => [ '{{WRAPPER}} .cmp-tst-quote' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'quote_typography',
            'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ],
            'selector' => '{{WRAPPER}} .cmp-tst-quote',
        ] );

        $this->end_controls_section();

        /* ==========================================
           STYLE TAB — Author
           ========================================== */
        $this->start_controls_section( 'style_author', [
            'label' => __( 'Author', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'author_photo_size', [
            'label' => __( 'Photo Size', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range' => [ 'px' => [ 'min' => 32, 'max' => 96 ] ],
            'default' => [ 'size' => 56, 'unit' => 'px' ],
            'selectors' => [ '{{WRAPPER}} .cmp-tst-author-photo' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
            'condition' => [ 'show_author_photo' => 'yes' ],
        ] );

        $this->add_control( 'author_photo_border', [
            'label' => __( 'Photo Border Color', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#FAF5EC',
            'selectors' => [ '{{WRAPPER}} .cmp-tst-author-photo' => 'border-color: {{VALUE}};' ],
            'condition' => [ 'show_author_photo' => 'yes' ],
        ] );

        $this->add_control( 'author_name_color', [
            'label' => __( 'Name Color', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#5C3A1E',
            'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-tst-author-name' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'author_name_typography',
            'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ],
            'selector' => '{{WRAPPER}} .cmp-tst-author-name',
        ] );

        $this->add_control( 'author_meta_color', [
            'label' => __( 'Meta Color', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#6B5A4A',
            'selectors' => [ '{{WRAPPER}} .cmp-tst-author-meta' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name' => 'author_meta_typography',
            'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-tst-author-meta',
        ] );

        $this->end_controls_section();

        /* ==========================================
           STYLE TAB — Background Avatars
           ========================================== */
        $this->start_controls_section( 'style_avatars', [
            'label' => __( 'Background Avatars', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_orbit' => 'yes' ],
        ] );

        $this->add_control( 'orbit_border_color', [
            'label' => __( 'Avatar Border Color', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#FFFFFF',
            'selectors' => [ '{{WRAPPER}} .cmp-tst-avatar' => 'border-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'orbit_border_width', [
            'label' => __( 'Avatar Border Width', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range' => [ 'px' => [ 'min' => 0, 'max' => 8 ] ],
            'default' => [ 'size' => 4, 'unit' => 'px' ],
            'selectors' => [ '{{WRAPPER}} .cmp-tst-avatar' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;' ],
        ] );

        $this->add_control( 'orbit_size_scale', [
            'label' => __( 'Avatar Size Scale', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SLIDER,
            'range' => [ 'px' => [ 'min' => 0.6, 'max' => 1.4, 'step' => 0.05 ] ],
            'default' => [ 'size' => 1, 'unit' => 'px' ],
            'description' => __( 'Multiplier for all avatar sizes (1 = default).', 'arenex-digital-widgets' ),
            'selectors' => [ '{{WRAPPER}} .cmp-tst-orbit' => '--cmp-tst-scale: {{SIZE}};' ],
        ] );

        $this->add_control( 'rings_color', [
            'label' => __( 'Decorative Rings Color', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(201,162,107,0.25)',
            'selectors' => [
                '{{WRAPPER}} .cmp-tst-orbit::before, {{WRAPPER}} .cmp-tst-orbit::after' => 'border-color: {{VALUE}};',
            ],
            'condition' => [ 'show_rings' => 'yes' ],
        ] );

        $this->end_controls_section();

        /* ==========================================
           STYLE TAB — Controls
           ========================================== */
        $this->start_controls_section( 'style_controls', [
            'label' => __( 'Controls', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'btn_bg', [
            'label' => __( 'Button Background', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#FFFFFF',
            'selectors' => [ '{{WRAPPER}} .cmp-tst-btn' => 'background: {{VALUE}};' ],
            'condition' => [ 'show_nav_buttons' => 'yes' ],
        ] );

        $this->add_control( 'btn_color', [
            'label' => __( 'Button Text/Icon Color', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#5C3A1E',
            'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-tst-btn' => 'color: {{VALUE}};' ],
            'condition' => [ 'show_nav_buttons' => 'yes' ],
        ] );

        $this->add_control( 'btn_border', [
            'label' => __( 'Button Border Color', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#E8DDC7',
            'selectors' => [ '{{WRAPPER}} .cmp-tst-btn' => 'border-color: {{VALUE}};' ],
            'condition' => [ 'show_nav_buttons' => 'yes' ],
        ] );

        $this->add_control( 'btn_hover_bg', [
            'label' => __( 'Button Hover Background', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#5C3A1E',
            'selectors' => [ '{{WRAPPER}} .cmp-tst-btn:hover' => 'background: {{VALUE}}; border-color: {{VALUE}};' ],
            'condition' => [ 'show_nav_buttons' => 'yes' ],
        ] );

        $this->add_control( 'btn_hover_color', [
            'label' => __( 'Button Hover Text Color', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#FAF5EC',
            'selectors' => [ '{{WRAPPER}} .cmp-tst-btn:hover' => 'color: {{VALUE}};' ],
            'condition' => [ 'show_nav_buttons' => 'yes' ],
        ] );

        $this->add_control( 'dot_color', [
            'label' => __( 'Dot Color', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#E8DDC7',
            'selectors' => [ '{{WRAPPER}} .cmp-tst-dot' => 'background: {{VALUE}};' ],
            'condition' => [ 'show_dots' => 'yes' ],
        ] );

        $this->add_control( 'dot_active_color', [
            'label' => __( 'Active Dot Color', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::COLOR,
            'default' => '#5C3A1E',
            'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-tst-dot.is-active' => 'background: {{VALUE}};' ],
            'condition' => [ 'show_dots' => 'yes' ],
        ] );

        $this->end_controls_section();

        /* ==========================================
           STYLE TAB — Section Spacing
           ========================================== */
        $this->start_controls_section( 'style_spacing', [
            'label' => __( 'Section Spacing', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label' => __( 'Section Padding', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'default' => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'mobile_default' => [ 'top' => '0', 'right' => '16', 'bottom' => '0', 'left' => '16', 'unit' => 'px', 'isLinked' => false ],
            'selectors' => [ '{{WRAPPER}} .cmp-tst-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $testimonials = is_array( $s['testimonials'] ) ? $s['testimonials'] : [];
        $avatars      = is_array( $s['avatars'] ) ? $s['avatars'] : [];
        $design       = ! empty( $s['design_style'] ) ? $s['design_style'] : 'style-orbit';

        $show_orbit   = ( ! empty( $s['show_orbit'] ) && $s['show_orbit'] === 'yes' );
        $show_rings   = ( ! empty( $s['show_rings'] ) && $s['show_rings'] === 'yes' );
        $show_mark    = ( ! empty( $s['show_quote_mark'] ) && $s['show_quote_mark'] === 'yes' );
        $show_photo   = ( ! empty( $s['show_author_photo'] ) && $s['show_author_photo'] === 'yes' );
        $show_btns    = ( ! empty( $s['show_nav_buttons'] ) && $s['show_nav_buttons'] === 'yes' );
        $show_dots    = ( ! empty( $s['show_dots'] ) && $s['show_dots'] === 'yes' );
        $show_schema  = ( ! empty( $s['show_schema'] ) && $s['show_schema'] === 'yes' );

        $autoplay     = ( ! empty( $s['autoplay'] ) && $s['autoplay'] === 'yes' );
        $speed        = ! empty( $s['autoplay_speed'] ) ? intval( $s['autoplay_speed'] ) : 6000;
        $pause_hover  = ( ! empty( $s['pause_on_hover'] ) && $s['pause_on_hover'] === 'yes' );

        $no_orbit_class = $show_rings ? '' : ' cmp-tst-no-rings';
        $wid = 'cmp-tst-' . wp_unique_id();
        ?>
        <div class="cmp-tst-wrap cmp-tst-<?php echo esc_attr( $design ); ?>"
             id="<?php echo esc_attr( $wid ); ?>"
             data-cmp-testimonials
             data-autoplay="<?php echo $autoplay ? '1' : '0'; ?>"
             data-speed="<?php echo (int) $speed; ?>"
             data-pause-hover="<?php echo $pause_hover ? '1' : '0'; ?>">
            <div class="cmp-tst-stage">
                <?php if ( $show_orbit && ! empty( $avatars ) ) : ?>
                <div class="cmp-tst-orbit<?php echo esc_attr( $no_orbit_class ); ?>" aria-hidden="true">
                    <?php foreach ( $avatars as $i => $av ) :
                        if ( $i >= 10 ) break;
                        $img = $av['avatar_image']['url'] ?? '';
                        if ( ! $img ) continue;
                        $alt = ! empty( $av['avatar_alt'] ) ? $av['avatar_alt'] : '';
                    ?>
                    <div class="cmp-tst-avatar cmp-tst-orbit-<?php echo (int) ( $i + 1 ); ?>">
                        <img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $alt ); ?>" width="100" height="100" loading="lazy">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <div class="cmp-tst-center">
                    <?php if ( ! empty( $testimonials ) ) : ?>
                    <div class="cmp-tst-card" data-cmp-tst-card>
                        <?php foreach ( $testimonials as $i => $t ) :
                            $active = $i === 0 ? ' is-active' : '';
                            $photo  = $t['author_photo']['url'] ?? '';
                            $name   = $t['author_name'] ?? '';
                            $meta   = $t['author_meta'] ?? '';
                            $quote  = $t['quote'] ?? '';
                        ?>
                        <div class="cmp-tst-slide<?php echo esc_attr( $active ); ?>" data-index="<?php echo (int) $i; ?>">
                            <?php if ( $show_mark ) : ?>
                            <div class="cmp-tst-mark" aria-hidden="true">&ldquo;</div>
                            <?php endif; ?>
                            <blockquote class="cmp-tst-quote"><?php echo esc_html( $quote ); ?></blockquote>
                            <div class="cmp-tst-author">
                                <?php if ( $show_photo && $photo ) : ?>
                                <div class="cmp-tst-author-photo">
                                    <img src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( $name ); ?>" width="60" height="60" loading="lazy">
                                </div>
                                <?php endif; ?>
                                <div class="cmp-tst-author-info">
                                    <strong class="cmp-tst-author-name"><?php echo esc_html( $name ); ?></strong>
                                    <span class="cmp-tst-author-meta"><?php echo esc_html( $meta ); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if ( $show_btns || $show_dots ) : ?>
                    <div class="cmp-tst-controls">
                        <?php if ( $show_btns ) : ?>
                        <button class="cmp-tst-btn cmp-tst-prev" type="button" aria-label="<?php esc_attr_e( 'Previous testimonial', 'arenex-digital-widgets' ); ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
                            <span><?php esc_html_e( 'Previous', 'arenex-digital-widgets' ); ?></span>
                        </button>
                        <?php endif; ?>

                        <?php if ( $show_dots ) : ?>
                        <div class="cmp-tst-dots" role="tablist">
                            <?php foreach ( $testimonials as $i => $_ ) : ?>
                            <button class="cmp-tst-dot<?php echo $i === 0 ? ' is-active' : ''; ?>"
                                    type="button"
                                    data-index="<?php echo (int) $i; ?>"
                                    aria-label="<?php echo esc_attr( sprintf( __( 'Show testimonial %d', 'arenex-digital-widgets' ), $i + 1 ) ); ?>"></button>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                        <?php if ( $show_btns ) : ?>
                        <button class="cmp-tst-btn cmp-tst-next" type="button" aria-label="<?php esc_attr_e( 'Next testimonial', 'arenex-digital-widgets' ); ?>">
                            <span><?php esc_html_e( 'Next', 'arenex-digital-widgets' ); ?></span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ( $show_schema && ! empty( $testimonials ) ) : ?>
            <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "ItemList",
                "itemListElement": [
                    <?php $parts = []; foreach ( $testimonials as $i => $t ) :
                        $parts[] = wp_json_encode( [
                            '@type'    => 'Review',
                            'position' => $i + 1,
                            'reviewBody' => wp_strip_all_tags( $t['quote'] ?? '' ),
                            'author'   => [ '@type' => 'Person', 'name' => wp_strip_all_tags( $t['author_name'] ?? '' ) ],
                        ] );
                    endforeach; echo implode( ',', $parts ); ?>
                ]
            }
            </script>
            <?php endif; ?>
        </div>
        <?php
    }

    protected function content_template() {}
}
