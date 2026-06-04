<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Bento_Grid extends \Elementor\Widget_Base {

    public function get_name()       { return 'cmp_bento_grid'; }
    public function get_title()      { return __( 'ADW — Bento Grid', 'arenex-digital-widgets' ); }
    public function get_icon()       { return 'eicon-gallery-grid'; }
    public function get_categories() { return [ 'arenex-digital' ]; }
    public function get_style_depends()  { return [ 'adw-styles' ]; }
    public function get_script_depends() { return [ 'adw-front' ]; }

    protected function register_controls() {

        /* ══════════════════════════════════════════
           CONTENT TAB — Bento Items
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'section_bento_items', [
            'label' => __( 'Bento Items', 'arenex-digital-widgets' ),
        ] );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control( 'title', [
            'label'   => __( 'Card Title', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Card Title Text', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'description', [
            'label'   => __( 'Description', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __( 'Card description text goes here. Elevating your sleep quality and overall wellbeing.', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'label', [
            'label'   => __( 'Small Label / Category', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'PRIMARY CARE', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'number', [
            'label'   => __( 'Number Text', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( '01', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'icon', [
            'label'   => __( 'Icon', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::ICONS,
            'default' => [ 'value' => 'fas fa-heartbeat', 'library' => 'fa-solid' ],
        ] );

        $repeater->add_control( 'image', [
            'label'   => __( 'Image', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );

        $repeater->add_control( 'bg_image_position', [
            'label'     => __( 'Image Position (when card is Background Image)', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'center right',
            'options'   => [
                'center center' => __( 'Center',       'arenex-digital-widgets' ),
                'center right'  => __( 'Center Right', 'arenex-digital-widgets' ),
                'center left'   => __( 'Center Left',  'arenex-digital-widgets' ),
                'top right'     => __( 'Top Right',    'arenex-digital-widgets' ),
                'top left'      => __( 'Top Left',     'arenex-digital-widgets' ),
                'top center'    => __( 'Top Center',   'arenex-digital-widgets' ),
                'bottom right'  => __( 'Bottom Right', 'arenex-digital-widgets' ),
                'bottom left'   => __( 'Bottom Left',  'arenex-digital-widgets' ),
                'bottom center' => __( 'Bottom Center',  'arenex-digital-widgets' ),
            ],
            'description' => __( 'Anchor the background image so the focal point stays visible while text sits on the opposite side.', 'arenex-digital-widgets' ),
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .cmp-bento-card-bg-media' => 'background-position: {{VALUE}} !important;',
            ],
        ] );

        $repeater->add_control( 'image_alt', [
            'label'   => __( 'Image Alt Fallback', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Bento Card Graphic', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'link_text', [
            'label'   => __( 'Button / Link Text', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Learn More', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'link_url', [
            'label'   => __( 'Link URL', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::URL,
            'placeholder' => __( 'https://example.com', 'arenex-digital-widgets' ),
            'default' => [
                'url' => '#',
                'is_external' => '',
                'nofollow' => '',
            ],
        ] );

        $repeater->add_control( 'features', [
            'label'       => __( 'Sub-features / Bullets (one per line)', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => '',
            'description' => __( 'Optional. Adds clean bullets inside large featured cards.', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'card_size', [
            'label'   => __( 'Choose Card Size', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'normal',
            'options' => [
                'featured' => __( 'Featured (Large)', 'arenex-digital-widgets' ),
                'wide'     => __( 'Wide (2 Cols)', 'arenex-digital-widgets' ),
                'normal'   => __( 'Normal (1 Col)', 'arenex-digital-widgets' ),
                'small'    => __( 'Small', 'arenex-digital-widgets' ),
            ],
        ] );

        $repeater->add_control( 'visual_type', [
            'label'   => __( 'Choose Card Visual Type', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'plain',
            'options' => [
                'plain'       => __( 'Plain Card', 'arenex-digital-widgets' ),
                'bg_image'    => __( 'Background Image with Overlay', 'arenex-digital-widgets' ),
                'image_right' => __( 'Image on Right (Split)', 'arenex-digital-widgets' ),
                'image_left'  => __( 'Image on Left (Split)', 'arenex-digital-widgets' ),
                'icon_only'   => __( 'Icon Only Card', 'arenex-digital-widgets' ),
            ],
        ] );

        $repeater->add_control( 'show_icon', [
            'label'        => __( 'Show Icon', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $repeater->add_control( 'show_image', [
            'label'        => __( 'Show Image', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $repeater->add_control( 'show_number', [
            'label'        => __( 'Show Number', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $repeater->add_control( 'show_cta', [
            'label'        => __( 'Show CTA', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off'    => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $repeater->add_responsive_control( 'content_max_width', [
            'label'      => __( 'Text Column Width (% of card)', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ '%' ],
            'range'      => [ '%' => [ 'min' => 30, 'max' => 100 ] ],
            'default'    => [ 'size' => 100, 'unit' => '%' ],
            'tablet_default' => [ 'size' => 100, 'unit' => '%' ],
            'mobile_default' => [ 'size' => 100, 'unit' => '%' ],
            'description' => __( 'Per-card text column width. Use 50% on cards with images so text doesn\'t go under the image; use 100% for text-only cards.', 'arenex-digital-widgets' ),
            'selectors'  => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .cmp-bento-card-content' => 'max-width: {{SIZE}}{{UNIT}} !important;',
            ],
        ] );

        // Card style overrides inside the repeater
        $repeater->add_control( 'custom_bg_heading', [
            'label'     => __( 'Card Colors Override', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $repeater->add_control( 'custom_bg_type', [
            'label'   => __( 'Override Background', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default'  => __( 'Default Setting', 'arenex-digital-widgets' ),
                'color'    => __( 'Custom Color', 'arenex-digital-widgets' ),
                'gradient' => __( 'Custom Gradient', 'arenex-digital-widgets' ),
            ],
        ] );

        $repeater->add_control( 'custom_bg_color', [
            'label'     => __( 'Card Background Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#fafaf9',
            'selectors' => [ '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}} !important; background-image: none !important;' ],
            'condition' => [ 'custom_bg_type' => 'color' ],
        ] );

        $repeater->add_control( 'custom_grad_start', [
            'label'     => __( 'Gradient Start', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#102446',
            'condition' => [ 'custom_bg_type' => 'gradient' ],
        ] );

        $repeater->add_control( 'custom_grad_end', [
            'label'     => __( 'Gradient End', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#1e355f',
            'selectors' => [ '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-image: linear-gradient(135deg, {{custom_grad_start.VALUE}} 0%, {{VALUE}} 100%) !important; background-color: transparent !important;' ],
            'condition' => [ 'custom_bg_type' => 'gradient' ],
        ] );

        $repeater->add_control( 'custom_theme_type', [
            'label'   => __( 'Override Text Theme', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => __( 'Default Theme', 'arenex-digital-widgets' ),
                'light'   => __( 'Light Theme (White Text)', 'arenex-digital-widgets' ),
                'dark'    => __( 'Dark Theme (Dark Text)', 'arenex-digital-widgets' ),
            ],
        ] );

        $repeater->add_control( 'custom_label_color', [
            'label'     => __( 'Custom Label Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#0ea5e9',
            'selectors' => [ '{{WRAPPER}} {{CURRENT_ITEM}} .cmp-bento-card-label' => 'color: {{VALUE}} !important;' ],
            'condition' => [ 'custom_theme_type!' => 'default' ],
        ] );

        $repeater->add_control( 'custom_title_color', [
            'label'     => __( 'Custom Title Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} {{CURRENT_ITEM}} .cmp-bento-card-title' => 'color: {{VALUE}} !important;' ],
            'condition' => [ 'custom_theme_type!' => 'default' ],
        ] );

        $repeater->add_control( 'custom_desc_color', [
            'label'     => __( 'Custom Description Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#e2e8f0',
            'selectors' => [ '{{WRAPPER}} {{CURRENT_ITEM}} .cmp-bento-card-desc, {{WRAPPER}} {{CURRENT_ITEM}} .cmp-bento-card-features li' => 'color: {{VALUE}} !important;' ],
            'condition' => [ 'custom_theme_type!' => 'default' ],
        ] );

        $repeater->add_control( 'custom_cta_color', [
            'label'     => __( 'Custom CTA Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} {{CURRENT_ITEM}} .cmp-bento-card-cta' => 'color: {{VALUE}} !important; border-color: {{VALUE}} !important;' ],
            'condition' => [ 'custom_theme_type!' => 'default' ],
        ] );

        $this->add_control( 'items', [
            'label'       => __( 'Bento Cards', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [
                    'title'             => __( 'Sleep Apnea & CPAP Care', 'arenex-digital-widgets' ),
                    'description'       => __( 'Diagnosis and management of sleep-disordered breathing. Comprehensive CPAP care including equipment setup, mask fitting, and therapy monitoring for long-term success.', 'arenex-digital-widgets' ),
                    'label'             => __( 'PRIMARY TREATMENT', 'arenex-digital-widgets' ),
                    'number'            => __( '01', 'arenex-digital-widgets' ),
                    'icon'              => [ 'value' => 'fas fa-heartbeat', 'library' => 'fa-solid' ],
                    'card_size'         => 'featured',
                    'visual_type'       => 'plain',
                    'custom_bg_type'    => 'gradient',
                    'custom_grad_start' => '#102446',
                    'custom_grad_end'   => '#1e355f',
                    'custom_theme_type' => 'light',
                    'custom_label_color'=> '#38bdf8',
                    'custom_title_color'=> '#ffffff',
                    'custom_desc_color' => '#cbd5e1',
                    'custom_cta_color'  => '#ffffff',
                    'link_text'         => __( 'Request CPAP Consult', 'arenex-digital-widgets' ),
                    'link_url'          => [ 'url' => '#' ],
                    'features'          => "Personalized Care\nInsurance Friendly\nLong-Term Support",
                ],
                [
                    'title'             => __( 'Home Sleep Study', 'arenex-digital-widgets' ),
                    'description'       => __( 'Convenient overnight diagnostic testing using modern monitoring technology in the peace and privacy of your own home.', 'arenex-digital-widgets' ),
                    'label'             => __( 'DIAGNOSTICS', 'arenex-digital-widgets' ),
                    'number'            => __( '02', 'arenex-digital-widgets' ),
                    'icon'              => [ 'value' => 'fas fa-home', 'library' => 'fa-solid' ],
                    'card_size'         => 'normal',
                    'visual_type'       => 'image_right',
                    'custom_bg_type'    => 'color',
                    'custom_bg_color'   => '#f0f7ff',
                    'custom_theme_type' => 'dark',
                    'custom_label_color'=> '#0ea5e9',
                    'custom_title_color'=> '#1e355f',
                    'custom_desc_color' => '#475569',
                    'custom_cta_color'  => '#0ea5e9',
                    'link_text'         => __( 'Learn About Studies', 'arenex-digital-widgets' ),
                    'link_url'          => [ 'url' => '#' ],
                ],
                [
                    'title'             => __( 'Insomnia Treatment', 'arenex-digital-widgets' ),
                    'description'       => __( 'Evidence-based therapies, clinical medication management, and CBT-I referrals for lasting relief and deep rest.', 'arenex-digital-widgets' ),
                    'label'             => __( 'THERAPY', 'arenex-digital-widgets' ),
                    'number'            => __( '03', 'arenex-digital-widgets' ),
                    'icon'              => [ 'value' => 'fas fa-bed', 'library' => 'fa-solid' ],
                    'card_size'         => 'normal',
                    'visual_type'       => 'image_right',
                    'custom_bg_type'    => 'color',
                    'custom_bg_color'   => '#f0fdf4',
                    'custom_theme_type' => 'dark',
                    'custom_label_color'=> '#16a34a',
                    'custom_title_color'=> '#1e355f',
                    'custom_desc_color' => '#475569',
                    'custom_cta_color'  => '#16a34a',
                    'link_text'         => __( 'Explore CBT-I Options', 'arenex-digital-widgets' ),
                    'link_url'          => [ 'url' => '#' ],
                ],
                [
                    'title'             => __( 'Restless Leg Syndrome', 'arenex-digital-widgets' ),
                    'description'       => __( 'Targeted medical evaluation and individualized treatment planning to relieve chronic discomfort and improve sleep quality.', 'arenex-digital-widgets' ),
                    'label'             => __( 'NEUROLOGICAL', 'arenex-digital-widgets' ),
                    'number'            => __( '04', 'arenex-digital-widgets' ),
                    'icon'              => [ 'value' => 'fas fa-walking', 'library' => 'fa-solid' ],
                    'card_size'         => 'normal',
                    'visual_type'       => 'image_right',
                    'custom_bg_type'    => 'color',
                    'custom_bg_color'   => '#faf5ff',
                    'custom_theme_type' => 'dark',
                    'custom_label_color'=> '#7c3aed',
                    'custom_title_color'=> '#1e355f',
                    'custom_desc_color' => '#475569',
                    'custom_cta_color'  => '#7c3aed',
                    'link_text'         => __( 'RLS Evaluation', 'arenex-digital-widgets' ),
                    'link_url'          => [ 'url' => '#' ],
                ],
                [
                    'title'             => __( 'Hypersomnia & Narcolepsy', 'arenex-digital-widgets' ),
                    'description'       => __( 'Personalized management strategies and advanced therapies to resolve persistent excessive daytime sleepiness.', 'arenex-digital-widgets' ),
                    'label'             => __( 'SOMNOLOGIC', 'arenex-digital-widgets' ),
                    'number'            => __( '05', 'arenex-digital-widgets' ),
                    'icon'              => [ 'value' => 'fas fa-clock', 'library' => 'fa-solid' ],
                    'card_size'         => 'normal',
                    'visual_type'       => 'image_right',
                    'custom_bg_type'    => 'color',
                    'custom_bg_color'   => '#fffbeb',
                    'custom_theme_type' => 'dark',
                    'custom_label_color'=> '#d97706',
                    'custom_title_color'=> '#1e355f',
                    'custom_desc_color' => '#475569',
                    'custom_cta_color'  => '#d97706',
                    'link_text'         => __( 'Schedule Somnolence Assessment', 'arenex-digital-widgets' ),
                    'link_url'          => [ 'url' => '#' ],
                ],
                [
                    'title'             => __( 'Parasomnias & Telehealth', 'arenex-digital-widgets' ),
                    'description'       => __( 'Treatment for REM sleep behavior disorders, sleepwalking, night terrors, and more. Virtual visits available for consultations and follow-ups.', 'arenex-digital-widgets' ),
                    'label'             => __( 'ADDITIONAL CARE', 'arenex-digital-widgets' ),
                    'number'            => __( '06', 'arenex-digital-widgets' ),
                    'icon'              => [ 'value' => 'fas fa-laptop-medical', 'library' => 'fa-solid' ],
                    'card_size'         => 'normal',
                    'visual_type'       => 'image_right',
                    'custom_bg_type'    => 'color',
                    'custom_bg_color'   => '#f0f9ff',
                    'custom_theme_type' => 'dark',
                    'custom_label_color'=> '#0284c7',
                    'custom_title_color'=> '#1e355f',
                    'custom_desc_color' => '#475569',
                    'custom_cta_color'  => '#0284c7',
                    'link_text'         => __( 'See Telehealth Options', 'arenex-digital-widgets' ),
                    'link_url'          => [ 'url' => '#' ],
                ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           CONTENT TAB — Layout Settings
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'section_layout_settings', [
            'label' => __( 'Layout Settings', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'layout_style', [
            'label'   => __( 'Layout Style', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'masonry',
            'options' => [
                'masonry' => __( 'Masonry Bento', 'arenex-digital-widgets' ),
                'grid'    => __( 'Equal Grid', 'arenex-digital-widgets' ),
                'compact' => __( 'Compact Minimal', 'arenex-digital-widgets' ),
            ],
        ] );

        $this->add_responsive_control( 'columns', [
            'label'           => __( 'Columns (Desktop)', 'arenex-digital-widgets' ),
            'type'            => \Elementor\Controls_Manager::SELECT,
            'default'         => '3',
            'tablet_default'  => '2',
            'mobile_default'  => '1',
            'options'         => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ],
            'selectors'       => [
                '{{WRAPPER}} .cmp-bento-grid-layout' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ] );

        $this->add_responsive_control( 'card_min_height', [
            'label'      => __( 'Card Min Height', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'vh' ],
            'range'      => [
                'px' => [ 'min' => 150, 'max' => 800 ],
                'vh' => [ 'min' => 10, 'max' => 100 ],
            ],
            'default'    => [ 'size' => 200, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-bento-card' => 'min-height: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'featured_col_span', [
            'label'      => __( 'Featured Card Col Span', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'col' ],
            'range'      => [
                'col' => [ 'min' => 1, 'max' => 4 ],
            ],
            'default'    => [ 'size' => 2, 'unit' => 'col' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-bento-card-featured' => 'grid-column: span {{SIZE}};',
            ],
            'condition'  => [ 'layout_style' => 'masonry' ],
        ] );

        $this->add_control( 'featured_asym_enable', [
            'label'        => __( 'Asymmetric Featured Layout', 'arenex-digital-widgets' ),
            'description'  => __( 'Put featured card on the left at a custom width, with cards 02 and 03 stacked on the right. Overrides Col/Row Span when on.', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
            'condition'    => [ 'layout_style' => 'masonry' ],
        ] );

        $this->add_responsive_control( 'featured_width_cols', [
            'label'      => __( 'Featured Width (out of 12 cols)', 'arenex-digital-widgets' ),
            'description'=> __( 'Featured spans this many of 12 cols. Cards 02 + 03 stack in the remainder. Cards 04 / 05 / 06 always sit in a 3-column row below.', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'col' ],
            'range'      => [ 'col' => [ 'min' => 6, 'max' => 10, 'step' => 1 ] ],
            'default'    => [ 'size' => 8, 'unit' => 'col' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-bento-grid-layout' => '--cmp-feat-cols: {{SIZE}}; grid-template-columns: repeat(12, 1fr) !important; grid-auto-flow: dense;',
                '{{WRAPPER}} .cmp-bento-card-featured' => 'grid-column: 1 / span {{SIZE}} !important; grid-row: 1 / span 2 !important;',
                '{{WRAPPER}} .cmp-bento-card:not(.cmp-bento-card-featured):nth-child(2)' => 'grid-column: calc({{SIZE}} + 1) / -1 !important; grid-row: 1 !important;',
                '{{WRAPPER}} .cmp-bento-card:not(.cmp-bento-card-featured):nth-child(3)' => 'grid-column: calc({{SIZE}} + 1) / -1 !important; grid-row: 2 !important;',
                '{{WRAPPER}} .cmp-bento-card:not(.cmp-bento-card-featured):nth-child(4)' => 'grid-column: 1 / span 4 !important; grid-row: 3 !important;',
                '{{WRAPPER}} .cmp-bento-card:not(.cmp-bento-card-featured):nth-child(5)' => 'grid-column: 5 / span 4 !important; grid-row: 3 !important;',
                '{{WRAPPER}} .cmp-bento-card:not(.cmp-bento-card-featured):nth-child(6)' => 'grid-column: 9 / span 4 !important; grid-row: 3 !important;',
            ],
            'condition'  => [ 'layout_style' => 'masonry', 'featured_asym_enable' => 'yes' ],
        ] );

        $this->add_responsive_control( 'featured_row_span', [
            'label'      => __( 'Featured Card Row Span', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'row' ],
            'range'      => [
                'row' => [ 'min' => 1, 'max' => 4 ],
            ],
            'default'    => [ 'size' => 2, 'unit' => 'row' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-bento-card-featured' => 'grid-row: span {{SIZE}};',
            ],
            'condition'  => [ 'layout_style' => 'masonry' ],
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           STYLE TAB — Layout
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'style_layout', [
            'label' => __( 'Layout', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'max_width', [
            'label'      => __( 'Max Width', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range'      => [
                'px' => [ 'min' => 600, 'max' => 1600 ],
                '%'  => [ 'min' => 50, 'max' => 100 ],
            ],
            'default'    => [ 'size' => 1200, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-bento-grid-inner' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
            ],
        ] );

        $this->add_responsive_control( 'gap', [
            'label'      => __( 'Gap', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [
                'px' => [ 'min' => 0, 'max' => 100 ],
            ],
            'default'    => [ 'size' => 24, 'unit' => 'px' ],
            'tablet_default' => [ 'size' => 16, 'unit' => 'px' ],
            'mobile_default' => [ 'size' => 12, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-bento-grid-layout' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'section_padding', [
            'label'      => __( 'Section Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'default'    => [
                'top'    => '80',
                'right'  => '0',
                'bottom' => '80',
                'left'   => '0',
                'unit'   => 'px',
                'isLinked' => false,
            ],
            'tablet_default' => [
                'top'    => '60',
                'right'  => '0',
                'bottom' => '60',
                'left'   => '0',
                'unit'   => 'px',
                'isLinked' => false,
            ],
            'mobile_default' => [
                'top'    => '40',
                'right'  => '0',
                'bottom' => '40',
                'left'   => '0',
                'unit'   => 'px',
                'isLinked' => false,
            ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-bento-grid-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           STYLE TAB — Card Styling
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'style_card', [
            'label' => __( 'Cards', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_group_control( \Elementor\Group_Control_Background::get_type(), [
            'name'     => 'card_background',
            'types'    => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .cmp-bento-card',
            'fields_options' => [
                'background' => [ 'default' => 'classic' ],
                'color'      => [ 'default' => '#ffffff' ],
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
            'name'     => 'card_border',
            'selector' => '{{WRAPPER}} .cmp-bento-card',
        ] );

        $this->add_responsive_control( 'card_border_radius', [
            'label'      => __( 'Border Radius', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'default'    => [
                'top'    => '20',
                'right'  => '20',
                'bottom' => '20',
                'left'   => '20',
                'unit'   => 'px',
                'isLinked' => true,
            ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-bento-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_box_shadow',
            'selector' => '{{WRAPPER}} .cmp-bento-card',
        ] );

        $this->add_responsive_control( 'card_padding', [
            'label'      => __( 'Card Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'default'    => [
                'top'    => '36',
                'right'  => '36',
                'bottom' => '36',
                'left'   => '36',
                'unit'   => 'px',
                'isLinked' => true,
            ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-bento-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'card_overflow', [
            'label'     => __( 'Card Overflow Hidden', 'arenex-digital-widgets' ),
            'type'     => \Elementor\Controls_Manager::SWITCHER,
            'label_on'  => __( 'Yes', 'arenex-digital-widgets' ),
            'label_off' => __( 'No', 'arenex-digital-widgets' ),
            'return_value' => 'hidden',
            'default'   => 'hidden',
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card' => 'overflow: {{VALUE}};' ],
        ] );

        // HOVER STATE
        $this->start_controls_tabs( 'card_state_tabs' );

        $this->start_controls_tab( 'card_normal_tab', [
            'label' => __( 'Normal', 'arenex-digital-widgets' ),
        ] );
        $this->end_controls_tab();

        $this->start_controls_tab( 'card_hover_tab', [
            'label' => __( 'Hover', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'card_hover_bg', [
            'label'     => __( 'Hover Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card:hover' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'card_hover_lift', [
            'label'     => __( 'Lift on Hover (px)', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::NUMBER,
            'min'       => 0,
            'max'       => 20,
            'default'   => 4,
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card:hover' => 'transform: translateY(-{{VALUE}}px);' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_hover_shadow',
            'selector' => '{{WRAPPER}} .cmp-bento-card:hover',
        ] );

        $this->add_control( 'card_hover_image_scale', [
            'label'     => __( 'Hover Image Scale', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'size_units'=> [ 'factor' ],
            'range'     => [
                'factor' => [ 'min' => 1, 'max' => 1.2, 'step' => 0.01 ],
            ],
            'default'   => [ 'size' => 1.05, 'unit' => 'factor' ],
            'selectors' => [
                '{{WRAPPER}} .cmp-bento-card:hover .cmp-bento-card-media img' => 'transform: scale({{SIZE}});',
            ],
        ] );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           STYLE TAB — Image Controls
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'style_image', [
            'label' => __( 'Images', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'image_width', [
            'label'      => __( 'Split Image Width (%)', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ '%' ],
            'range'      => [
                '%' => [ 'min' => 20, 'max' => 80 ],
            ],
            'default'    => [ 'size' => 45, 'unit' => '%' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-bento-card-split .cmp-bento-card-media' => 'width: {{SIZE}}{{UNIT}}; flex-basis: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cmp-bento-card-split .cmp-bento-card-content' => 'width: calc(100% - {{SIZE}}{{UNIT}}); flex-basis: calc(100% - {{SIZE}}{{UNIT}});',
            ],
        ] );

        $this->add_responsive_control( 'image_height', [
            'label'      => __( 'Image Height (px)', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'vh' ],
            'range'      => [
                'px' => [ 'min' => 100, 'max' => 600 ],
            ],
            'default'    => [ 'size' => 220, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-bento-card-media'    => 'height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .cmp-bento-card:not(.cmp-bento-card-featured) .cmp-bento-card-bg-media' => 'height: {{SIZE}}{{UNIT}} !important;',
            ],
        ] );

        $this->add_responsive_control( 'image_top_gap', [
            'label'      => __( 'Image Top Gap (px) — mobile bg-image cards', 'arenex-digital-widgets' ),
            'description'=> __( 'Space between text block and image when card stacks on mobile.', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
            'default'    => [ 'size' => 0, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-bento-card-bg_image:not(.cmp-bento-card-featured)' => '--cmp-mobile-img-top-gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'image_object_fit', [
            'label'   => __( 'Object Fit', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'cover',
            'options' => [
                'cover'      => __( 'Cover', 'arenex-digital-widgets' ),
                'contain'    => __( 'Contain', 'arenex-digital-widgets' ),
                'fill'       => __( 'Fill', 'arenex-digital-widgets' ),
            ],
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-media img' => 'object-fit: {{VALUE}};' ],
        ] );

        $this->add_control( 'image_object_position', [
            'label'   => __( 'Object Position', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'center center',
            'options' => [
                'center center' => __( 'Center', 'arenex-digital-widgets' ),
                'top center'    => __( 'Top', 'arenex-digital-widgets' ),
                'bottom center' => __( 'Bottom', 'arenex-digital-widgets' ),
                'center left'   => __( 'Left', 'arenex-digital-widgets' ),
                'center right'  => __( 'Right', 'arenex-digital-widgets' ),
            ],
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-media img' => 'object-position: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'image_border_radius', [
            'label'      => __( 'Border Radius', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-bento-card-media, {{WRAPPER}} .cmp-bento-card-media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'bg_overlay_color', [
            'label'     => __( 'Background Overlay Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'rgba(15, 25, 46, 0.4)',
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-bg-overlay' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'overlay_opacity', [
            'label'     => __( 'Overlay Opacity', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'size_units'=> [ 'opacity' ],
            'range'     => [
                'opacity' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ],
            ],
            'default'   => [ 'size' => 0.4, 'unit' => 'opacity' ],
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-bg-overlay' => 'opacity: {{SIZE}};' ],
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           STYLE TAB — Typography Controls
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'style_typography', [
            'label' => __( 'Typography', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'card_title_tag', [
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

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'label'    => __( 'Title Typography', 'arenex-digital-widgets' ),
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ],
            'selector' => '{{WRAPPER}} .cmp-bento-card-title',
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'description_typography',
            'label'    => __( 'Description Typography', 'arenex-digital-widgets' ),
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-bento-card-desc, {{WRAPPER}} .cmp-bento-card-features li',
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'label_typography',
            'label'    => __( 'Label / Category Typography', 'arenex-digital-widgets' ),
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ],
            'selector' => '{{WRAPPER}} .cmp-bento-card-label',
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'number_typography',
            'label'    => __( 'Number Typography', 'arenex-digital-widgets' ),
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ],
            'selector' => '{{WRAPPER}} .cmp-bento-card-number',
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'cta_typography',
            'label'    => __( 'CTA Typography', 'arenex-digital-widgets' ),
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ],
            'selector' => '{{WRAPPER}} .cmp-bento-card-cta',
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           STYLE TAB — Color Controls
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'style_color', [
            'label' => __( 'Colors', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'title_color', [
            'label'     => __( 'Title Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#1e355f',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-title' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'description_color', [
            'label'     => __( 'Description Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#475569',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-desc, {{WRAPPER}} .cmp-bento-card-features li' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'label_color', [
            'label'     => __( 'Label Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#0ea5e9',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-label' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'number_color', [
            'label'     => __( 'Number Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#0ea5e9',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-number' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'cta_color', [
            'label'     => __( 'CTA Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#0ea5e9',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-cta' => 'color: {{VALUE}}; border-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'icon_color', [
            'label'     => __( 'Icon Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#0ea5e9',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-icon i' => 'color: {{VALUE}};', '{{WRAPPER}} .cmp-bento-card-icon svg' => 'fill: {{VALUE}};' ],
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           STYLE TAB — Animation Controls
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'style_animation', [
            'label' => __( 'Animation', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'entrance_animation', [
            'label'   => __( 'Entrance Animation', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'fade-up',
            'options' => [
                ''          => __( 'None', 'arenex-digital-widgets' ),
                'fade-up'   => __( 'Fade Up', 'arenex-digital-widgets' ),
                'fade-in'   => __( 'Fade In', 'arenex-digital-widgets' ),
                'slide-in'  => __( 'Slide In', 'arenex-digital-widgets' ),
                'zoom'      => __( 'Zoom In', 'arenex-digital-widgets' ),
            ],
        ] );

        $this->add_control( 'hover_effect', [
            'label'   => __( 'Hover Effect', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'lift',
            'options' => [
                ''       => __( 'None', 'arenex-digital-widgets' ),
                'lift'   => __( 'Lift', 'arenex-digital-widgets' ),
                'scale'  => __( 'Scale', 'arenex-digital-widgets' ),
                'glow'   => __( 'Glow', 'arenex-digital-widgets' ),
                'border' => __( 'Border Highlight', 'arenex-digital-widgets' ),
            ],
        ] );

        $this->end_controls_section();

        /* ══════════════════════════════════════════
           STYLE TAB — Spacing Controls
           ══════════════════════════════════════════ */
        $this->start_controls_section( 'style_spacing', [
            'label' => __( 'Spacing', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'title_spacing', [
            'label'     => __( 'Title Bottom Spacing', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'default'   => [ 'size' => 12, 'unit' => 'px' ],
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-title' => 'margin-bottom: {{SIZE}}px;' ],
        ] );

        $this->add_responsive_control( 'label_spacing', [
            'label'     => __( 'Label Bottom Spacing', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'default'   => [ 'size' => 8, 'unit' => 'px' ],
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-label-row' => 'margin-bottom: {{SIZE}}px;' ],
        ] );

        $this->add_responsive_control( 'desc_spacing', [
            'label'     => __( 'Description Bottom Spacing', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'default'   => [ 'size' => 20, 'unit' => 'px' ],
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-desc' => 'margin-bottom: {{SIZE}}px;' ],
        ] );

        $this->add_responsive_control( 'features_item_spacing', [
            'label'     => __( 'Bullet List Item Gap', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
            'default'   => [ 'size' => 8, 'unit' => 'px' ],
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-features li' => 'margin-bottom: {{SIZE}}px;' ],
        ] );

        $this->add_responsive_control( 'icon_spacing', [
            'label'     => __( 'Icon Bottom Spacing', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
            'default'   => [ 'size' => 16, 'unit' => 'px' ],
            'description' => __( 'Gap between the icon and the label/title below.', 'arenex-digital-widgets' ),
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-icon-top' => 'margin-bottom: {{SIZE}}px;' ],
        ] );

        $this->add_responsive_control( 'cta_spacing', [
            'label'     => __( 'Button / CTA Top Spacing', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
            'default'   => [ 'size' => 0, 'unit' => 'px' ],
            'description' => __( 'Extra space above the CTA button — useful for separating it from icon/content.', 'arenex-digital-widgets' ),
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-cta' => 'margin-top: {{SIZE}}px;' ],
        ] );

        $this->add_responsive_control( 'split_content_max_width', [
            'label'     => __( 'Split Card Text Max Width (%)', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::SLIDER,
            'size_units'=> [ '%' ],
            'range'     => [ '%' => [ 'min' => 30, 'max' => 100 ] ],
            'default'   => [ 'size' => 100, 'unit' => '%' ],
            'description' => __( 'Caps text width inside split cards. Lower it to give breathing room when image is wide.', 'arenex-digital-widgets' ),
            'selectors' => [ '{{WRAPPER}} .cmp-bento-card-split .cmp-bento-card-content' => 'max-width: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $uid = $this->get_id();

        // Allowed tag validator
        $allowed_tags = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p' ];
        $tag = ! empty( $s['card_title_tag'] ) && in_array( $s['card_title_tag'], $allowed_tags )
            ? $s['card_title_tag']
            : 'h3';

        // Render Service JSON-LD Schema (SEO & Accessibility)
        $schema_items = [];
        foreach ( $s['items'] as $item ) {
            $schema_items[] = [
                '@type'       => 'Service',
                'name'        => esc_html( $item['title'] ),
                'description' => esc_html( $item['description'] ),
                'provider'    => [
                    '@type' => 'LocalBusiness',
                    'name'  => get_bloginfo( 'name' ),
                ],
            ];
        }

        if ( ! empty( $schema_items ) ) {
            $schema = [
                '@context'        => 'https://schema.org',
                '@type'           => 'ItemList',
                'itemListElement' => array_map( function( $item, $index ) {
                    return [
                        '@type'    => 'ListItem',
                        'position' => $index + 1,
                        'item'     => $item,
                    ];
                }, $schema_items, array_keys( $schema_items ) ),
            ];
            echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
        }
        ?>

        <section class="cmp-bento-grid-wrapper cmp-widget-section">
            <div class="cmp-bento-grid-inner cmp-widget-inner">
                <div class="cmp-bento-grid-layout cmp-layout-<?php echo esc_attr( $s['layout_style'] ); ?>">
                    <?php 
                    foreach ( $s['items'] as $i => $item ) :
                        $delay = ( $i % 4 ) + 1;
                        
                        // Layout size classes
                        $size_class = 'cmp-bento-card-' . esc_attr( $item['card_size'] );
                        
                        // Visual type classes
                        $visual_class = 'cmp-bento-card-' . esc_attr( $item['visual_type'] );
                        if ( in_array( $item['visual_type'], [ 'image_left', 'image_right' ], true ) ) {
                            $visual_class = 'cmp-bento-card-split cmp-bento-card-' . esc_attr( $item['visual_type'] );
                        }
                        
                        // Toggle variables
                        $show_icon   = ( ! empty( $item['show_icon'] ) && $item['show_icon'] === 'yes' );
                        $show_image  = ( ! empty( $item['show_image'] ) && $item['show_image'] === 'yes' && ! empty( $item['image']['url'] ) );
                        $show_number = ( ! empty( $item['show_number'] ) && $item['show_number'] === 'yes' );
                        $show_cta    = ( ! empty( $item['show_cta'] ) && $item['show_cta'] === 'yes' && ! empty( $item['link_text'] ) );
                        
                        // Item unique ID
                        $item_key = 'repeater_item_' . $item['_id'];

                        // Card CSS Class assembly
                        $card_classes = array(
                            'cmp-bento-card',
                            $size_class,
                            $visual_class,
                            'elementor-repeater-item-' . esc_attr( $item['_id'] ),
                        );
                        
                        if ( ! empty( $s['entrance_animation'] ) ) {
                            $card_classes[] = 'cmp-reveal';
                            $card_classes[] = 'cmp-reveal-delay-' . $delay;
                        }
                        if ( ! empty( $s['hover_effect'] ) ) {
                            $card_classes[] = 'cmp-hover-' . esc_attr( $s['hover_effect'] );
                        }
                        ?>
                        <article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">
                            
                            <?php if ( $item['visual_type'] === 'bg_image' && ! empty( $item['image']['url'] ) ) : ?>
                                <div class="cmp-bento-card-bg-overlay"></div>
                                <div class="cmp-bento-card-bg-media" style="background-image: url('<?php echo esc_url( $item['image']['url'] ); ?>');"></div>
                            <?php endif; ?>

                            <?php if ( $show_image && in_array( $item['visual_type'], [ 'image_left' ], true ) ) : ?>
                                <div class="cmp-bento-card-media">
                                    <img src="<?php echo esc_url( $item['image']['url'] ); ?>" 
                                         alt="<?php echo esc_attr( ! empty( $item['image_alt'] ) ? $item['image_alt'] : ( ! empty( $item['image']['alt'] ) ? $item['image']['alt'] : $item['title'] ) ); ?>" 
                                         width="<?php echo esc_attr( ! empty( $item['image']['width'] ) ? $item['image']['width'] : '' ); ?>"
                                         height="<?php echo esc_attr( ! empty( $item['image']['height'] ) ? $item['image']['height'] : '' ); ?>"
                                         loading="lazy">
                                </div>
                            <?php endif; ?>

                            <div class="cmp-bento-card-content">

                                <?php if ( $show_icon && ! empty( $item['icon']['value'] ) && $item['visual_type'] !== 'icon_only' ) : ?>
                                    <div class="cmp-bento-card-icon cmp-bento-card-icon-top">
                                        <?php \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="cmp-bento-card-label-row">
                                    <?php if ( $show_number && ! empty( $item['number'] ) ) : ?>
                                        <span class="cmp-bento-card-number"><?php echo esc_html( $item['number'] ); ?></span>
                                    <?php endif; ?>
                                    
                                    <?php if ( ! empty( $item['label'] ) ) : ?>
                                        <span class="cmp-bento-card-label"><?php echo esc_html( $item['label'] ); ?></span>
                                    <?php endif; ?>
                                </div>

                                <<?php echo esc_attr( $tag ); ?> class="cmp-bento-card-title">
                                    <?php echo esc_html( $item['title'] ); ?>
                                </<?php echo esc_attr( $tag ); ?>>

                                <?php if ( ! empty( $item['description'] ) ) : ?>
                                    <p class="cmp-bento-card-desc"><?php echo esc_html( $item['description'] ); ?></p>
                                <?php endif; ?>

                                <?php
                                if ( ! empty( $item['features'] ) && $item['card_size'] === 'featured' ) :
                                    $features = array_filter( array_map( 'trim', explode( "\n", $item['features'] ) ) );
                                    if ( ! empty( $features ) ) : ?>
                                        <ul class="cmp-bento-card-features">
                                            <?php foreach ( $features as $feature ) :
                                                // Support "icon-class | text" syntax for per-feature icons
                                                if ( strpos( $feature, '|' ) !== false ) {
                                                    $parts     = array_map( 'trim', explode( '|', $feature, 2 ) );
                                                    $feat_icon = $parts[0];
                                                    $feat_text = isset( $parts[1] ) ? $parts[1] : '';
                                                } else {
                                                    $feat_icon = '';
                                                    $feat_text = $feature;
                                                }
                                            ?>
                                                <li>
                                                    <?php if ( $feat_icon ) : ?>
                                                        <span class="cmp-feature-icon"><i class="<?php echo esc_attr( $feat_icon ); ?>" aria-hidden="true"></i></span>
                                                    <?php else : ?>
                                                        <svg class="cmp-feature-check" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                                            <polyline points="20 6 9 17 4 12"></polyline>
                                                        </svg>
                                                    <?php endif; ?>
                                                    <?php echo esc_html( $feat_text ); ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                <?php endif; endif; ?>

                                <?php if ( $show_cta && ! empty( $item['link_url']['url'] ) ) : 
                                    $target   = ! empty( $item['link_url']['is_external'] ) ? ' target="_blank"' : '';
                                    $nofollow = ! empty( $item['link_url']['nofollow'] ) ? ' rel="nofollow noopener noreferrer"' : ' rel="noopener noreferrer"';
                                    if ( $item['visual_type'] === 'icon_only' && ! empty( $item['icon']['value'] ) ) {
                                        $aria_label = ' aria-label="' . esc_attr( $item['title'] ) . '"';
                                    } else {
                                        $aria_label = '';
                                    }
                                    ?>
                                    <a href="<?php echo esc_url( $item['link_url']['url'] ); ?>"<?php echo $target . $nofollow . $aria_label; ?> class="cmp-bento-card-cta">
                                        <?php echo esc_html( $item['link_text'] ); ?>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                            <path d="M5 12h14M12 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                <?php endif; ?>

                            </div>

                            <?php if ( $show_image && in_array( $item['visual_type'], [ 'image_right' ], true ) ) : ?>
                                <div class="cmp-bento-card-media">
                                    <img src="<?php echo esc_url( $item['image']['url'] ); ?>" 
                                         alt="<?php echo esc_attr( ! empty( $item['image_alt'] ) ? $item['image_alt'] : ( ! empty( $item['image']['alt'] ) ? $item['image']['alt'] : $item['title'] ) ); ?>" 
                                         width="<?php echo esc_attr( ! empty( $item['image']['width'] ) ? $item['image']['width'] : '' ); ?>"
                                         height="<?php echo esc_attr( ! empty( $item['image']['height'] ) ? $item['image']['height'] : '' ); ?>"
                                         loading="lazy">
                                </div>
                            <?php endif; ?>

                            <?php if ( $show_icon && ! empty( $item['icon']['value'] ) && $item['visual_type'] === 'icon_only' ) : ?>
                                <div class="cmp-bento-card-icon cmp-bento-card-icon-only">
                                    <?php \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                </div>
                            <?php endif; ?>

                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php
    }

    protected function content_template() {}
}
