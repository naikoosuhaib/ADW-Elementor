<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Hero extends \Elementor\Widget_Base {

    public function get_name()       { return 'cmp_hero'; }
    public function get_title()      { return __( 'ADW — Hero', 'arenex-digital-widgets' ); }
    public function get_icon()       { return 'eicon-header'; }
    public function get_categories() { return [ 'arenex-digital' ]; }
    public function get_style_depends()  { return [ 'adw-styles' ]; }
    public function get_script_depends() { return [ 'adw-front' ]; }

    protected function register_controls() {

        /* ── CONTENT: Layout ── */
        $this->start_controls_section( 'section_layout', [ 'label' => __( 'Layout', 'arenex-digital-widgets' ) ] );

        /* Design Style — pattern matches CMP_Process_Steps.
         * v4.0.0 ships with Style 1 only. v4.1+ adds Style 2 (full-bg + gradient
         * overlay), Style 3 (centered + badge + stats), Style 4 (light bg),
         * Style 5 (video bg), Style 6 (asymmetric).
         */
        $this->add_control( 'design_style', [
            'label'   => __( 'Design Style', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'style-1',
            'options' => [
                'style-1' => __( 'Style 1 — Classic (split / centered)', 'arenex-digital-widgets' ),
                'style-2' => __( 'Style 2 — Full BG Image + Overlay', 'arenex-digital-widgets' ),
            ],
        ] );

        $this->add_control( 'layout', [
            'label'     => __( 'Layout', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'split',
            'options'   => [
                'centered'   => __( 'Centered', 'arenex-digital-widgets' ),
                'split'      => __( 'Split — Image Right', 'arenex-digital-widgets' ),
                'split-left' => __( 'Split — Image Left', 'arenex-digital-widgets' ),
            ],
            'condition' => [ 'design_style' => 'style-1' ],
        ] );
        $this->add_control( 'hero_image', [
            'label'     => __( 'Hero Image', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::MEDIA,
            'condition' => [ 'design_style' => 'style-1', 'layout!' => 'centered' ],
        ] );

        $this->add_control( 'mobile_layout', [
            'label'     => __( 'Mobile Layout Order', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'image-first',
            'options'   => [
                'image-first' => __( 'Image First → Text Second', 'arenex-digital-widgets' ),
                'text-first'  => __( 'Text First → Image Second', 'arenex-digital-widgets' ),
            ],
            'description' => __( 'Stacking order on tablet & mobile.', 'arenex-digital-widgets' ),
            'condition'   => [ 'design_style' => 'style-1', 'layout!' => 'centered' ],
        ] );

        /* Style 2 — layout controls */
        $this->add_control( 'hero_bg_image2', [
            'label'       => __( 'Background Image', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::MEDIA,
            'description' => __( 'Full-screen background image. Add overlay settings in the Style tab.', 'arenex-digital-widgets' ),
            'condition'   => [ 'design_style' => 'style-2' ],
        ] );
        $this->add_control( 's2_content_align', [
            'label'     => __( 'Horizontal Alignment', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'left',
            'options'   => [
                'left'   => __( 'Left', 'arenex-digital-widgets' ),
                'center' => __( 'Center', 'arenex-digital-widgets' ),
                'right'  => __( 'Right', 'arenex-digital-widgets' ),
            ],
            'condition' => [ 'design_style' => 'style-2' ],
        ] );

        $this->add_control( 's2_vertical_align', [
            'label'     => __( 'Vertical Alignment', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'center',
            'options'   => [
                'top'    => __( 'Top', 'arenex-digital-widgets' ),
                'center' => __( 'Center', 'arenex-digital-widgets' ),
                'bottom' => __( 'Bottom', 'arenex-digital-widgets' ),
            ],
            'condition' => [ 'design_style' => 'style-2' ],
        ] );

        $this->end_controls_section();

        /* ── CONTENT: Text ── */
        $this->start_controls_section( 'section_content', [ 'label' => __( 'Content', 'arenex-digital-widgets' ) ] );
        $this->add_control( 'header_type', [
            'label'   => __( 'Header Type', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'badge',
            'options' => [
                'badge'   => __( 'Badge (rounded pill with dot)', 'arenex-digital-widgets' ),
                'eyebrow' => __( 'Eyebrow (mono with line accent)', 'arenex-digital-widgets' ),
                'none'    => __( 'None', 'arenex-digital-widgets' ),
            ],
        ] );
        // Legacy "show_badge" kept for backward-compat — not user-facing
        $this->add_control( 'show_badge', [ 'label' => __( 'Show Badge', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::HIDDEN, 'default' => 'yes' ] );
        $this->add_control( 'badge_text', [
            'label'     => __( 'Header Text', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => 'Serving Hampton Roads Since Day One',
            'condition' => [ 'header_type!' => 'none' ],
        ] );
        $this->add_control( 'heading', [ 'label' => __( 'Heading', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Reliable Network, Security &\n<span class=\"cmp-gradient-text\">Audio Visual Solutions</span>", 'description' => __( 'Use &lt;span class="cmp-gradient-text"&gt; for gradient, &lt;em&gt;, &lt;strong&gt;, &lt;br&gt;.', 'arenex-digital-widgets' ) ] );
        $this->add_control( 'show_subheading', [ 'label' => __( 'Show Subheading', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes' ] );
        $this->add_control( 'subheading', [ 'label' => __( 'Subheading', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'We deliver enterprise-grade networking, structured cabling, security camera systems, and commercial AV installations across your region.', 'condition' => [ 'show_subheading' => 'yes' ] ] );
        $this->end_controls_section();

        /* ── CONTENT: Buttons ── */
        $this->start_controls_section( 'section_buttons', [ 'label' => __( 'Buttons', 'arenex-digital-widgets' ) ] );
        $this->add_control( 'show_btn1', [ 'label' => __( 'Show Primary Button', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes' ] );
        $this->add_control( 'btn1_text', [ 'label' => __( 'Text', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Request a Quote', 'condition' => [ 'show_btn1' => 'yes' ] ] );
        $this->add_control( 'btn1_link', [ 'label' => __( 'Link', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => '#contact' ], 'condition' => [ 'show_btn1' => 'yes' ] ] );
        $this->add_control( 'btn1_icon', [
            'label' => __( 'Icon', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::ICONS,
            'default' => [ 'value' => 'fas fa-arrow-right', 'library' => 'fa-solid' ],
            'condition' => [ 'show_btn1' => 'yes' ],
        ] );
        $this->add_control( 'btn1_icon_position', [ 'label' => __( 'Icon Position', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'after', 'options' => [ 'before' => __( 'Before', 'arenex-digital-widgets' ), 'after' => __( 'After', 'arenex-digital-widgets' ), 'none' => __( 'No Icon', 'arenex-digital-widgets' ) ], 'condition' => [ 'show_btn1' => 'yes' ] ] );

        $this->add_control( 'hr_btn', [ 'type' => \Elementor\Controls_Manager::DIVIDER ] );

        $this->add_control( 'show_btn2', [ 'label' => __( 'Show Secondary Button', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes' ] );
        $this->add_control( 'btn2_text', [ 'label' => __( 'Text', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Call Now', 'condition' => [ 'show_btn2' => 'yes' ] ] );
        $this->add_control( 'btn2_link', [ 'label' => __( 'Link', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => 'tel:+1234567890' ], 'condition' => [ 'show_btn2' => 'yes' ] ] );
        $this->add_control( 'btn2_icon', [
            'label' => __( 'Icon', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::ICONS,
            'default' => [ 'value' => 'fas fa-phone-alt', 'library' => 'fa-solid' ],
            'condition' => [ 'show_btn2' => 'yes' ],
        ] );
        $this->add_control( 'btn2_icon_position', [ 'label' => __( 'Icon Position', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT, 'default' => 'before', 'options' => [ 'before' => __( 'Before', 'arenex-digital-widgets' ), 'after' => __( 'After', 'arenex-digital-widgets' ), 'none' => __( 'No Icon', 'arenex-digital-widgets' ) ], 'condition' => [ 'show_btn2' => 'yes' ] ] );
        $this->end_controls_section();

        /* ── CONTENT: Stats ── */
        $this->start_controls_section( 'section_stats', [ 'label' => __( 'Stats', 'arenex-digital-widgets' ) ] );
        $this->add_control( 'show_stats', [ 'label' => __( 'Show Stats Bar', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes' ] );
        $this->add_control( 'show_stat_dividers', [ 'label' => __( 'Show Dividers', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes', 'condition' => [ 'show_stats' => 'yes' ] ] );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'number', [ 'label' => __( 'Number', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '500' ] );
        $repeater->add_control( 'suffix', [ 'label' => __( 'Suffix (+, %, etc)', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '+' ] );
        $repeater->add_control( 'label',  [ 'label' => __( 'Label', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Projects Completed' ] );
        $this->add_control( 'stats', [
            'label'   => __( 'Stats', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'number' => '500', 'suffix' => '+', 'label' => 'Projects Completed' ],
                [ 'number' => '150', 'suffix' => '+', 'label' => 'Happy Clients' ],
                [ 'number' => '6',   'suffix' => '',  'label' => 'Cities Served' ],
                [ 'number' => '100', 'suffix' => '%', 'label' => 'Satisfaction Rate' ],
            ],
            'title_field' => '{{{ number }}}{{{ suffix }}} — {{{ label }}}',
            'condition' => [ 'show_stats' => 'yes' ],
        ] );
        $this->end_controls_section();

        /* ── CONTENT: Scroll ── */
        $this->start_controls_section( 'section_scroll', [ 'label' => __( 'Scroll Indicator', 'arenex-digital-widgets' ) ] );
        $this->add_control( 'show_scroll', [ 'label' => __( 'Show Scroll Indicator', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes' ] );
        $this->add_control( 'scroll_text', [ 'label' => __( 'Scroll Text', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Scroll to explore', 'condition' => [ 'show_scroll' => 'yes' ] ] );
        $this->add_control( 'scroll_text_color', [ 'label' => __( 'Text Color', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-scroll' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'scroll_line_color', [ 'label' => __( 'Line Color', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-scroll .scroll-line' => 'background: {{VALUE}};', '{{WRAPPER}} .cmp-dark-hero-scroll-line' => 'background: {{VALUE}};' ] ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'scroll_typography', 'selector' => '{{WRAPPER}} .cmp-dark-hero-scroll' ] );
        $this->end_controls_section();

        /* ── STYLE: Background ── */
        $this->start_controls_section( 'style_bg', [ 'label' => __( 'Background', 'arenex-digital-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );
        $this->add_control( 'bg_color', [ 'label' => __( 'Background Color', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#0A1B3D', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ], 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero, {{WRAPPER}} .cmp-dark-hero-bg' => 'background-color: {{VALUE}};' ] ] );
        $this->add_responsive_control( 'min_height', [
            'label' => __( 'Min Height', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'vh' ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 1200 ], 'vh' => [ 'min' => 0, 'max' => 100 ] ],
            'default' => [ 'size' => 100, 'unit' => 'vh' ],
            'selectors' => [
                '{{WRAPPER}} .cmp-dark-hero' => 'min-height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}}'                => 'min-height: {{SIZE}}{{UNIT}};',
            ],
        ] );
        $this->add_responsive_control( 'section_padding', [
            'label'          => __( 'Section Padding', 'arenex-digital-widgets' ),
            'type'           => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units'     => [ 'px', 'em', '%' ],
            'default'        => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'tablet_default' => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'mobile_default' => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'selectors'      => [ '{{WRAPPER}} .cmp-dark-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );
        $this->end_controls_section();

        /* ── STYLE: Image ── */
        $this->start_controls_section( 'style_image', [ 'label' => __( 'Image', 'arenex-digital-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => [ 'design_style' => 'style-1', 'layout!' => 'centered' ] ] );
        $this->add_responsive_control( 'image_border_radius', [
            'label' => __( 'Border Radius', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ], 'default' => [ 'size' => 16 ],
            'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-image img' => 'border-radius: {{SIZE}}px;' ],
        ] );
        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [ 'name' => 'image_shadow', 'selector' => '{{WRAPPER}} .cmp-dark-hero-image img' ] );
        $this->add_responsive_control( 'image_width', [
            'label' => __( 'Width (%)', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [ 'px' => [ 'min' => 10, 'max' => 100 ] ],
            'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-image img' => 'width: {{SIZE}}%;' ],
        ] );
        $this->add_responsive_control( 'image_height', [
            'label' => __( 'Height (px)', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [ 'px' => [ 'min' => 100, 'max' => 800 ] ],
            'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-image img' => 'height: {{SIZE}}px;' ],
        ] );
        $this->add_control( 'image_object_fit', [
            'label' => __( 'Object Fit', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'cover',
            'options' => [ '' => __( 'Default', 'arenex-digital-widgets' ), 'fill' => __( 'Fill', 'arenex-digital-widgets' ), 'cover' => __( 'Cover', 'arenex-digital-widgets' ), 'contain' => __( 'Contain', 'arenex-digital-widgets' ), 'scale-down' => __( 'Scale Down', 'arenex-digital-widgets' ) ],
            'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-image img' => 'object-fit: {{VALUE}};' ],
        ] );
        $this->end_controls_section();

        /* ── STYLE: BG Overlay (Style 2) ── */
        $this->start_controls_section( 'style_overlay2', [
            'label'     => __( 'BG Overlay', 'arenex-digital-widgets' ),
            'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'design_style' => 'style-2' ],
        ] );
        $this->add_control( 's2_overlay_dir', [
            'label'   => __( 'Gradient Direction', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'left',
            'options' => [
                'left'   => __( 'Dark Left → Right', 'arenex-digital-widgets' ),
                'right'  => __( 'Dark Right → Left', 'arenex-digital-widgets' ),
                'top'    => __( 'Dark Top → Bottom', 'arenex-digital-widgets' ),
                'bottom' => __( 'Dark Bottom → Top', 'arenex-digital-widgets' ),
                'solid'  => __( 'Solid (full tint)', 'arenex-digital-widgets' ),
            ],
        ] );
        $this->add_control( 's2_overlay_color', [
            'label'       => __( 'Desktop / Tablet Overlay Color', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::COLOR,
            'default'     => 'rgba(0,0,0,0.72)',
            'description' => __( 'Used in the directional gradient at >768px. Includes its own alpha.', 'arenex-digital-widgets' ),
            'selectors'   => [ '{{WRAPPER}} .cmp-hero2-overlay' => '--cmp-h2-ov-start: {{VALUE}};' ],
        ] );

        $this->add_control( 's2_mobile_overlay_color', [
            'label'       => __( 'Mobile Overlay Color', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::COLOR,
            'default'     => 'rgba(0,0,0,0.85)',
            'description' => __( 'Solid overlay applied on mobile (≤768px) so text stays readable. Pick the alpha here independently from desktop — e.g. 0.85 black.', 'arenex-digital-widgets' ),
            'selectors'   => [ '{{WRAPPER}} .cmp-hero2-overlay' => '--cmp-h2-mobile-ov: {{VALUE}};' ],
        ] );
        $this->add_responsive_control( 's2_min_height', [
            'label'      => __( 'Min Height', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'vh' ],
            'range'      => [ 'px' => [ 'min' => 200, 'max' => 1200 ], 'vh' => [ 'min' => 20, 'max' => 100 ] ],
            'default'    => [ 'size' => 100, 'unit' => 'vh' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-dark-hero--style-2' => 'min-height: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 's2_content_padding', [
            'label'          => __( 'Content Padding', 'arenex-digital-widgets' ),
            'type'           => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units'     => [ 'px', 'em', '%' ],
            'default'        => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'tablet_default' => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'mobile_default' => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'selectors'      => [ '{{WRAPPER}} .cmp-hero2-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 's2_content_max_width', [
            'label'      => __( 'Content Max Width', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range'      => [ 'px' => [ 'min' => 300, 'max' => 1400 ] ],
            'default'    => [ 'size' => 700, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-hero2-inner' => 'max-width: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->end_controls_section();

        /* ── STYLE: Badge ── */
        $this->start_controls_section( 'style_badge', [ 'label' => __( 'Badge', 'arenex-digital-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => [ 'show_badge' => 'yes' ] ] );
        $this->add_control( 'badge_bg', [ 'label' => __( 'Background', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ], 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-badge' => 'background: {{VALUE}};' ] ] );
        $this->add_control( 'badge_text_color', [ 'label' => __( 'Text Color', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ], 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-badge' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'badge_border_color', [ 'label' => __( 'Border Color', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-badge' => 'border-color: {{VALUE}};' ] ] );
        $this->add_control( 'badge_dot_color', [ 'label' => __( 'Pulse Dot Color', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#22c55e', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ], 'selectors' => [ '{{WRAPPER}} .cmp-pulse-dot' => 'background: {{VALUE}};' ] ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'badge_typography', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ], 'selector' => '{{WRAPPER}} .cmp-dark-hero-badge' ] );
        $this->add_responsive_control( 'badge_spacing', [ 'label' => __( 'Bottom Spacing', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 100 ] ], 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-badge' => 'margin-bottom: {{SIZE}}px;' ] ] );
        $this->end_controls_section();

        /* ── STYLE: Eyebrow ── */
        $this->start_controls_section( 'style_eyebrow', [ 'label' => __( 'Eyebrow', 'arenex-digital-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );
        $this->add_control( 'eyebrow_color', [ 'label' => __( 'Color', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-eyebrow' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'eyebrow_line_color', [ 'label' => __( 'Line/Dash Color', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-eyebrow::before' => 'background: {{VALUE}} !important;', '{{WRAPPER}} .cmp-dark-hero-eyebrow' => '--eyebrow-line-color: {{VALUE}};' ] ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'eyebrow_typography', 'selector' => '{{WRAPPER}} .cmp-dark-hero-eyebrow' ] );
        $this->add_responsive_control( 'eyebrow_spacing', [ 'label' => __( 'Bottom Spacing', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 100 ] ], 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-eyebrow' => 'margin-bottom: {{SIZE}}px;' ] ] );
        $this->end_controls_section();

        /* ── STYLE: Heading ── */
        $this->start_controls_section( 'style_heading', [ 'label' => __( 'Heading', 'arenex-digital-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );
        $this->add_control( 'heading_color', [ 'label' => __( 'Color', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#ffffff', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ], 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-heading' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'gradient_start', [ 'label' => __( 'Gradient Start', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#00B4D8', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ], 'selectors' => [ '{{WRAPPER}} .cmp-gradient-text' => 'background: linear-gradient(135deg, {{VALUE}}, var(--cmp-gradient-end, #48D1E8)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;' ] ] );
        $this->add_control( 'gradient_end', [ 'label' => __( 'Gradient End', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#48D1E8', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ], 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero' => '--cmp-gradient-end: {{VALUE}};' ] ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'heading_typography', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ], 'selector' => '{{WRAPPER}} .cmp-dark-hero-heading' ] );
        $this->add_responsive_control( 'heading_top_spacing', [ 'label' => __( 'Top Spacing', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => -100, 'max' => 100 ] ], 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-heading' => 'margin-top: {{SIZE}}px;' ] ] );
        $this->add_responsive_control( 'heading_spacing', [ 'label' => __( 'Bottom Spacing', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 80 ] ], 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-heading' => 'margin-bottom: {{SIZE}}px;' ] ] );
        $this->add_responsive_control( 'heading_max_width', [
            'label' => __( 'Max Width', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [ 'px' => [ 'min' => 200, 'max' => 1200 ] ],
            'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-heading' => 'max-width: {{SIZE}}px;' ],
        ] );
        $this->end_controls_section();

        /* ── STYLE: Subheading ── */
        $this->start_controls_section( 'style_sub', [ 'label' => __( 'Subheading', 'arenex-digital-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => [ 'show_subheading' => 'yes' ] ] );
        $this->add_control( 'sub_color', [ 'label' => __( 'Color', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#9CA3AF', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ], 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-sub' => 'color: {{VALUE}};' ] ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'sub_typography', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ], 'selector' => '{{WRAPPER}} .cmp-dark-hero-sub' ] );
        $this->add_responsive_control( 'sub_spacing', [ 'label' => __( 'Bottom Spacing', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 80 ] ], 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-sub' => 'margin-bottom: {{SIZE}}px;' ] ] );
        $this->end_controls_section();

        /* ── STYLE: Buttons ── */
        $this->start_controls_section( 'style_buttons', [ 'label' => __( 'Buttons', 'arenex-digital-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );
        $this->add_control( 'btn_mobile_fullwidth', [
            'label' => __( 'Full Width on Mobile', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'Yes', 'arenex-digital-widgets' ), 'label_off' => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes', 'default' => '',
            'separator' => 'after',
        ] );
        $this->add_control( 'btn1_h', [ 'label' => __( 'Primary Button', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING ] );
        $this->add_control( 'btn1_bg', [ 'label' => __( 'Background', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#00B4D8', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ], 'selectors' => [ '{{WRAPPER}} .cmp-btn-primary' => 'background: {{VALUE}}; border-color: {{VALUE}};' ] ] );
        $this->add_control( 'btn1_color', [ 'label' => __( 'Text', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#fff', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ], 'selectors' => [ '{{WRAPPER}} .cmp-btn-primary' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'btn1_hover_bg', [ 'label' => __( 'Hover BG', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ], 'selectors' => [ '{{WRAPPER}} .cmp-btn-primary:hover' => 'background: {{VALUE}}; border-color: {{VALUE}};' ] ] );
        $this->add_responsive_control( 'btn1_radius', [ 'label' => __( 'Radius', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ], 'default' => [ 'size' => 8 ], 'selectors' => [ '{{WRAPPER}} .cmp-btn-primary' => 'border-radius: {{SIZE}}px;' ] ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'btn1_typo', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ], 'selector' => '{{WRAPPER}} .cmp-btn-primary' ] );
        $this->add_responsive_control( 'btn1_padding', [ 'label' => __( 'Padding', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => [ 'px' ], 'default' => [ 'top' => '16', 'right' => '36', 'bottom' => '16', 'left' => '36', 'unit' => 'px', 'isLinked' => false ], 'selectors' => [ '{{WRAPPER}} .cmp-btn-primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );

        $this->add_control( 'btn2_h', [ 'label' => __( 'Secondary Button', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::HEADING, 'separator' => 'before' ] );
        $this->add_control( 'btn2_border_color', [ 'label' => __( 'Border', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'rgba(255,255,255,0.3)', 'selectors' => [ '{{WRAPPER}} .cmp-btn-outline-light' => 'border-color: {{VALUE}};' ] ] );
        $this->add_control( 'btn2_color', [ 'label' => __( 'Text', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#fff', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ], 'selectors' => [ '{{WRAPPER}} .cmp-btn-outline-light' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'btn2_hover_bg', [ 'label' => __( 'Hover BG', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ], 'selectors' => [ '{{WRAPPER}} .cmp-btn-outline-light:hover' => 'background: {{VALUE}};' ] ] );
        $this->add_responsive_control( 'btn2_radius', [ 'label' => __( 'Radius', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ], 'default' => [ 'size' => 8 ], 'selectors' => [ '{{WRAPPER}} .cmp-btn-outline-light' => 'border-radius: {{SIZE}}px;' ] ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'btn2_typo', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ], 'selector' => '{{WRAPPER}} .cmp-btn-outline-light' ] );
        $this->add_responsive_control( 'btn2_padding', [ 'label' => __( 'Padding', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'size_units' => [ 'px' ], 'default' => [ 'top' => '16', 'right' => '36', 'bottom' => '16', 'left' => '36', 'unit' => 'px', 'isLinked' => false ], 'selectors' => [ '{{WRAPPER}} .cmp-btn-outline-light' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );

        $this->add_control( 'btn_icon_h', [
            'label'     => __( 'Icon Colors', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ] );
        $this->add_control( 'btn1_icon_color', [
            'label'     => __( 'Primary Button Icon', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [
                '{{WRAPPER}} .cmp-btn-primary svg'                   => 'fill: {{VALUE}};',
                '{{WRAPPER}} .cmp-btn-primary i'                     => 'color: {{VALUE}};',
                '{{WRAPPER}} .cmp-btn-primary .e-font-icon-svg'      => 'fill: {{VALUE}};',
                '{{WRAPPER}} .cmp-btn-primary .e-font-icon-svg path' => 'fill: {{VALUE}};',
            ],
        ] );
        $this->add_control( 'btn2_icon_color', [
            'label'     => __( 'Secondary Button Icon', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [
                '{{WRAPPER}} .cmp-btn-outline-light svg'                   => 'fill: {{VALUE}};',
                '{{WRAPPER}} .cmp-btn-outline-light i'                     => 'color: {{VALUE}};',
                '{{WRAPPER}} .cmp-btn-outline-light .e-font-icon-svg'      => 'fill: {{VALUE}};',
                '{{WRAPPER}} .cmp-btn-outline-light .e-font-icon-svg path' => 'fill: {{VALUE}};',
            ],
        ] );

        $this->end_controls_section();

        /* ── STYLE: Stats ── */
        $this->start_controls_section( 'style_stats', [ 'label' => __( 'Stats', 'arenex-digital-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE, 'condition' => [ 'show_stats' => 'yes' ] ] );
        $this->add_control( 'stat_num_color', [ 'label' => __( 'Number Color', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#ffffff', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ], 'selectors' => [ '{{WRAPPER}} .cmp-stat-number' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'stat_suffix_color', [ 'label' => __( 'Suffix Color', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#00B4D8', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ], 'selectors' => [ '{{WRAPPER}} .cmp-stat-suffix' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'stat_label_color', [ 'label' => __( 'Label Color', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#9CA3AF', 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ], 'selectors' => [ '{{WRAPPER}} .cmp-stat-label' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'stat_divider_color', [ 'label' => __( 'Divider Color', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'rgba(255,255,255,0.08)', 'selectors' => [ '{{WRAPPER}} .cmp-stat-divider' => 'background: {{VALUE}};', '{{WRAPPER}} .cmp-dark-hero-stats' => 'border-color: {{VALUE}};' ], 'condition' => [ 'show_stat_dividers' => 'yes' ] ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'stat_num_typo', 'label' => __( 'Number Typography', 'arenex-digital-widgets' ), 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ], 'selector' => '{{WRAPPER}} .cmp-stat-number, {{WRAPPER}} .cmp-stat-suffix' ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'stat_label_typo', 'label' => __( 'Label Typography', 'arenex-digital-widgets' ), 'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ], 'selector' => '{{WRAPPER}} .cmp-stat-label' ] );
        $this->add_responsive_control( 'stat_gap', [ 'label' => __( 'Gap', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 80 ] ], 'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-stats' => 'gap: {{SIZE}}px;' ] ] );
        $this->end_controls_section();

        /* ── STYLE: Layout Spacing ── */
        $this->start_controls_section( 'style_spacing', [ 'label' => __( 'Layout', 'arenex-digital-widgets' ), 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );
        $this->add_responsive_control( 'grid_gap', [
            'label' => __( 'Grid Gap (Split)', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [ 'px' => [ 'min' => 0, 'max' => 120 ] ], 'default' => [ 'size' => 60 ],
            'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-grid' => 'gap: {{SIZE}}px;' ],
            'condition' => [ 'layout!' => 'centered' ],
        ] );
        $this->add_responsive_control( 'content_max_width', [
            'label' => __( 'Content Max Width', 'arenex-digital-widgets' ), 'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ], 'range' => [ 'px' => [ 'min' => 300, 'max' => 1400 ] ],
            'default' => [ 'size' => 1200, 'unit' => 'px' ],
            'selectors' => [ '{{WRAPPER}} .cmp-dark-hero-grid, {{WRAPPER}} .cmp-dark-hero-inner' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;' ],
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s            = $this->get_settings_for_display();
        $design_style = $s['design_style'] ?? 'style-1';
        $allowed      = [ 'span' => [ 'class' => [] ], 'em' => [], 'strong' => [], 'br' => [] ];

        /* ── Style 2 — Full BG Image + Overlay ── */
        if ( $design_style === 'style-2' ) {
            $s2_align     = $s['s2_content_align']  ?? 'left';
            $s2_v_align   = $s['s2_vertical_align'] ?? 'center';
            $s2_ov_dir    = $s['s2_overlay_dir']    ?? 'left';
            $header_type  = $s['header_type']       ?? 'badge';
            $bg_url       = ! empty( $s['hero_bg_image2']['url'] ) ? $s['hero_bg_image2']['url'] : '';
            $s2_classes = 'cmp-dark-hero cmp-dark-hero--style-2';
            if ( $s2_align === 'center' )   $s2_classes .= ' cmp-dark-hero--align-center';
            if ( $s2_align === 'right' )    $s2_classes .= ' cmp-dark-hero--align-right';
            if ( $s2_v_align === 'top' )    $s2_classes .= ' cmp-dark-hero--valign-top';
            if ( $s2_v_align === 'bottom' ) $s2_classes .= ' cmp-dark-hero--valign-bottom';
            ?>
            <section class="<?php echo esc_attr( $s2_classes ); ?>">
                <div class="cmp-hero2-bg"<?php echo $bg_url ? ' style="background-image:url(\'' . esc_url( $bg_url ) . '\')"' : ''; ?>></div>
                <div class="cmp-hero2-overlay cmp-hero2--ov-<?php echo esc_attr( $s2_ov_dir ); ?>"></div>
                <div class="cmp-hero2-inner cmp-reveal">
                    <?php if ( $header_type === 'badge' && ! empty( $s['badge_text'] ) ) : ?>
                    <div class="cmp-dark-hero-badge-wrap">
                        <span class="cmp-dark-hero-badge"><span class="cmp-pulse-dot"></span> <?php echo esc_html( $s['badge_text'] ); ?></span>
                    </div>
                    <?php elseif ( $header_type === 'eyebrow' && ! empty( $s['badge_text'] ) ) : ?>
                    <div class="cmp-dark-hero-eyebrow"><?php echo esc_html( $s['badge_text'] ); ?></div>
                    <?php endif; ?>
                    <?php if ( ! empty( $s['heading'] ) ) : ?>
                    <h1 class="cmp-dark-hero-heading"><?php echo wp_kses( $s['heading'], $allowed ); ?></h1>
                    <?php endif; ?>
                    <?php if ( ( $s['show_subheading'] ?? '' ) === 'yes' && ! empty( $s['subheading'] ) ) : ?>
                    <p class="cmp-dark-hero-sub"><?php echo esc_html( $s['subheading'] ); ?></p>
                    <?php endif; ?>
                    <?php if ( ( $s['show_btn1'] ?? '' ) === 'yes' || ( $s['show_btn2'] ?? '' ) === 'yes' ) : ?>
                    <div class="cmp-dark-hero-actions<?php echo ( ! empty( $s['btn_mobile_fullwidth'] ) && $s['btn_mobile_fullwidth'] === 'yes' ) ? ' cmp-hero-btns-mobile-full' : ''; ?>">
                        <?php if ( ( $s['show_btn1'] ?? '' ) === 'yes' && ! empty( $s['btn1_text'] ) ) : ?>
                        <a href="<?php echo esc_url( $s['btn1_link']['url'] ?? '#' ); ?>" class="cmp-btn cmp-btn-primary"<?php echo ! empty( $s['btn1_link']['is_external'] ) ? ' target="_blank"' : ''; ?><?php echo ! empty( $s['btn1_link']['nofollow'] ) ? ' rel="nofollow"' : ''; ?>>
                            <?php if ( ( $s['btn1_icon_position'] ?? '' ) === 'before' && ! empty( $s['btn1_icon']['value'] ) ) \Elementor\Icons_Manager::render_icon( $s['btn1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            <?php echo esc_html( $s['btn1_text'] ); ?>
                            <?php if ( ( $s['btn1_icon_position'] ?? '' ) === 'after' && ! empty( $s['btn1_icon']['value'] ) ) \Elementor\Icons_Manager::render_icon( $s['btn1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </a>
                        <?php endif; ?>
                        <?php if ( ( $s['show_btn2'] ?? '' ) === 'yes' && ! empty( $s['btn2_text'] ) ) : ?>
                        <a href="<?php echo esc_url( $s['btn2_link']['url'] ?? '#' ); ?>" class="cmp-btn cmp-btn-outline-light"<?php echo ! empty( $s['btn2_link']['is_external'] ) ? ' target="_blank"' : ''; ?><?php echo ! empty( $s['btn2_link']['nofollow'] ) ? ' rel="nofollow"' : ''; ?>>
                            <?php if ( ( $s['btn2_icon_position'] ?? '' ) === 'before' && ! empty( $s['btn2_icon']['value'] ) ) \Elementor\Icons_Manager::render_icon( $s['btn2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            <?php echo esc_html( $s['btn2_text'] ); ?>
                            <?php if ( ( $s['btn2_icon_position'] ?? '' ) === 'after' && ! empty( $s['btn2_icon']['value'] ) ) \Elementor\Icons_Manager::render_icon( $s['btn2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php if ( ( $s['show_stats'] ?? '' ) === 'yes' && ! empty( $s['stats'] ) ) : ?>
                    <div class="cmp-dark-hero-stats cmp-reveal">
                        <?php $total = count( $s['stats'] ); foreach ( $s['stats'] as $i => $stat ) : ?>
                        <div class="cmp-stat">
                            <div class="cmp-stat-row">
                                <span class="cmp-stat-number" data-count="<?php echo esc_attr( $stat['number'] ); ?>">0</span><?php if ( ! empty( $stat['suffix'] ) ) : ?><span class="cmp-stat-suffix"><?php echo esc_html( $stat['suffix'] ); ?></span><?php endif; ?>
                            </div>
                            <span class="cmp-stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
                        </div>
                        <?php if ( ( $s['show_stat_dividers'] ?? '' ) === 'yes' && $i < $total - 1 ) : ?><div class="cmp-stat-divider"></div><?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if ( ( $s['show_scroll'] ?? '' ) === 'yes' && ! empty( $s['scroll_text'] ) ) : ?>
                <div class="cmp-dark-hero-scroll">
                    <span><?php echo esc_html( $s['scroll_text'] ); ?></span>
                    <div class="cmp-scroll-line"></div>
                </div>
                <?php endif; ?>
            </section>
            <?php
            return;
        }

        /* ── Style 1 — Classic (split / centered) ── */
        $layout   = $s['layout'];
        $is_split = $layout !== 'centered';
        ?>
        <section class="cmp-dark-hero">
            <div class="cmp-dark-hero-bg"></div>
            <div class="cmp-dark-hero-overlay"></div>
            <div class="cmp-dark-hero-grid-pattern"></div>

            <?php if ( $is_split ) : ?>
            <div class="cmp-dark-hero-grid<?php echo $layout === 'split-left' ? ' cmp-dark-hero-grid--reversed' : ''; ?><?php echo ( $s['mobile_layout'] ?? '' ) === 'text-first' ? ' cmp-hero-mobile-text-first' : ''; ?>">
                <div class="cmp-dark-hero-left cmp-reveal">
            <?php else : ?>
            <div class="cmp-dark-hero-inner cmp-reveal">
            <?php endif; ?>

                <?php $hdr = $s['header_type'] ?? 'badge'; ?>
                <?php if ( $hdr === 'badge' && ! empty( $s['badge_text'] ) ) : ?>
                <div class="cmp-dark-hero-badge-wrap">
                    <span class="cmp-dark-hero-badge"><span class="cmp-pulse-dot"></span> <?php echo esc_html( $s['badge_text'] ); ?></span>
                </div>
                <?php elseif ( $hdr === 'eyebrow' && ! empty( $s['badge_text'] ) ) : ?>
                <div class="cmp-dark-hero-eyebrow"><?php echo esc_html( $s['badge_text'] ); ?></div>
                <?php endif; ?>

                <h1 class="cmp-dark-hero-heading"><?php echo wp_kses( $s['heading'], $allowed ); ?></h1>

                <?php if ( $s['show_subheading'] === 'yes' && ! empty( $s['subheading'] ) ) : ?>
                <p class="cmp-dark-hero-sub"><?php echo esc_html( $s['subheading'] ); ?></p>
                <?php endif; ?>

                <?php if ( $s['show_btn1'] === 'yes' || $s['show_btn2'] === 'yes' ) : ?>
                <div class="cmp-dark-hero-actions<?php echo ( ! empty( $s['btn_mobile_fullwidth'] ) && $s['btn_mobile_fullwidth'] === 'yes' ) ? ' cmp-hero-btns-mobile-full' : ''; ?>">
                    <?php if ( $s['show_btn1'] === 'yes' && ! empty( $s['btn1_text'] ) ) : ?>
                    <a href="<?php echo esc_url( $s['btn1_link']['url'] ?? '#' ); ?>" class="cmp-btn cmp-btn-primary"<?php echo ( ! empty( $s['btn1_link']['is_external'] ) ) ? ' target="_blank"' : ''; ?><?php echo ( ! empty( $s['btn1_link']['nofollow'] ) ) ? ' rel="nofollow"' : ''; ?>>
                        <?php if ( $s['btn1_icon_position'] === 'before' && ! empty( $s['btn1_icon']['value'] ) ) \Elementor\Icons_Manager::render_icon( $s['btn1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <?php echo esc_html( $s['btn1_text'] ); ?>
                        <?php if ( $s['btn1_icon_position'] === 'after' && ! empty( $s['btn1_icon']['value'] ) ) \Elementor\Icons_Manager::render_icon( $s['btn1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </a>
                    <?php endif; ?>
                    <?php if ( $s['show_btn2'] === 'yes' && ! empty( $s['btn2_text'] ) ) : ?>
                    <a href="<?php echo esc_url( $s['btn2_link']['url'] ?? '#' ); ?>" class="cmp-btn cmp-btn-outline-light"<?php echo ( ! empty( $s['btn2_link']['is_external'] ) ) ? ' target="_blank"' : ''; ?><?php echo ( ! empty( $s['btn2_link']['nofollow'] ) ) ? ' rel="nofollow"' : ''; ?>>
                        <?php if ( $s['btn2_icon_position'] === 'before' && ! empty( $s['btn2_icon']['value'] ) ) \Elementor\Icons_Manager::render_icon( $s['btn2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <?php echo esc_html( $s['btn2_text'] ); ?>
                        <?php if ( $s['btn2_icon_position'] === 'after' && ! empty( $s['btn2_icon']['value'] ) ) \Elementor\Icons_Manager::render_icon( $s['btn2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            <?php if ( $is_split ) : ?>
                </div>
                <div class="cmp-dark-hero-image cmp-reveal">
                    <?php if ( ! empty( $s['hero_image']['url'] ) ) : ?>
                    <img src="<?php echo esc_url( $s['hero_image']['url'] ); ?>" alt="<?php echo esc_attr( \Elementor\Control_Media::get_image_alt( $s['hero_image'] ) ); ?>" loading="eager">
                    <?php endif; ?>
                </div>

                <?php if ( $s['show_stats'] === 'yes' && ! empty( $s['stats'] ) ) : ?>
                <div class="cmp-dark-hero-stats cmp-reveal">
                    <?php $total = count( $s['stats'] ); foreach ( $s['stats'] as $i => $stat ) : ?>
                    <div class="cmp-stat">
                        <div class="cmp-stat-row">
                            <span class="cmp-stat-number" data-count="<?php echo esc_attr( $stat['number'] ); ?>">0</span><?php if ( ! empty( $stat['suffix'] ) ) : ?><span class="cmp-stat-suffix"><?php echo esc_html( $stat['suffix'] ); ?></span><?php endif; ?>
                        </div>
                        <span class="cmp-stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
                    </div>
                    <?php if ( $s['show_stat_dividers'] === 'yes' && $i < $total - 1 ) : ?><div class="cmp-stat-divider"></div><?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php else : ?>

                <?php if ( $s['show_stats'] === 'yes' && ! empty( $s['stats'] ) ) : ?>
                <div class="cmp-dark-hero-stats cmp-reveal" style="max-width:800px;">
                    <?php $total = count( $s['stats'] ); foreach ( $s['stats'] as $i => $stat ) : ?>
                    <div class="cmp-stat">
                        <div class="cmp-stat-row">
                            <span class="cmp-stat-number" data-count="<?php echo esc_attr( $stat['number'] ); ?>">0</span><?php if ( ! empty( $stat['suffix'] ) ) : ?><span class="cmp-stat-suffix"><?php echo esc_html( $stat['suffix'] ); ?></span><?php endif; ?>
                        </div>
                        <span class="cmp-stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
                    </div>
                    <?php if ( $s['show_stat_dividers'] === 'yes' && $i < $total - 1 ) : ?><div class="cmp-stat-divider"></div><?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ( $s['show_scroll'] === 'yes' && ! empty( $s['scroll_text'] ) ) : ?>
            <div class="cmp-dark-hero-scroll">
                <span><?php echo esc_html( $s['scroll_text'] ); ?></span>
                <div class="cmp-scroll-line"></div>
            </div>
            <?php endif; ?>
        </section>
        <?php
    }

    protected function content_template() {}
}
