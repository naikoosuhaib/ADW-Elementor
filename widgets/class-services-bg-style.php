<?php
/**
 * ADW — Services BG Style
 *
 * Boxed services cards with tinted backgrounds, pill tags, and faded right-side images.
 * Sister widget to ADW — Services Grid; safe to use side-by-side.
 *
 * Pattern reference: Arenex Digital design system (warm-cream tints + gold accents).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Services_BG_Style extends \Elementor\Widget_Base {

    public function get_name()       { return 'cmp_services_bg_style'; }
    public function get_title()      { return __( 'ADW — Services BG Style', 'arenex-digital-widgets' ); }
    public function get_icon()       { return 'eicon-posts-grid'; }
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

        $this->add_responsive_control( 'columns', [
            'label'          => __( 'Columns', 'arenex-digital-widgets' ),
            'type'           => \Elementor\Controls_Manager::NUMBER,
            'min'            => 1,
            'max'            => 3,
            'default'        => 2,
            'tablet_default' => 2,
            'mobile_default' => 1,
            'selectors'      => [
                '{{WRAPPER}} .cmp-svcbg-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ] );

        $this->add_responsive_control( 'card_min_height', [
            'label'      => __( 'Card Min Height', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 200, 'max' => 480 ] ],
            'default'    => [ 'size' => 300, 'unit' => 'px' ],
            'tablet_default' => [ 'size' => 260, 'unit' => 'px' ],
            'mobile_default' => [ 'size' => 0,   'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-svcbg-card' => 'min-height: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'image_position', [
            'label'   => __( 'Image Side', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'right',
            'options' => [
                'right' => __( 'Right (faded into card)', 'arenex-digital-widgets' ),
                'left'  => __( 'Left (faded into card)', 'arenex-digital-widgets' ),
                'none'  => __( 'No image', 'arenex-digital-widgets' ),
            ],
        ] );

        $this->add_control( 'tint_mode', [
            'label'   => __( 'Background Tint Rotation', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'rotate3',
            'options' => [
                'rotate3' => __( 'Rotate 3 tints (1→2→3 repeating)', 'arenex-digital-widgets' ),
                'rotate4' => __( 'Rotate 4 tints (1→2→3→4 repeating)', 'arenex-digital-widgets' ),
                'alternate' => __( 'Alternate 2 tints (1→2 repeating)', 'arenex-digital-widgets' ),
                'single'  => __( 'Single tint (use Tint 1)', 'arenex-digital-widgets' ),
            ],
        ] );

        $this->add_control( 'hover_style', [
            'label'   => __( 'Hover Effect', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'lift',
            'options' => [
                'lift'      => __( 'Lift + Shadow', 'arenex-digital-widgets' ),
                'lift-zoom' => __( 'Lift + Image Zoom', 'arenex-digital-widgets' ),
                'border'    => __( 'Border Glow', 'arenex-digital-widgets' ),
                'none'      => __( 'None', 'arenex-digital-widgets' ),
            ],
        ] );

        $this->end_controls_section();

        /* ==========================================
           CONTENT TAB — Cards (Repeater)
           ========================================== */
        $this->start_controls_section( 'section_cards', [
            'label' => __( 'Service Cards', 'arenex-digital-widgets' ),
        ] );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control( 'tag_text', [
            'label'   => __( 'Tag (pill label)', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Category', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'title', [
            'label'   => __( 'Title', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Service Title', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'title_tag', [
            'label'   => __( 'Title HTML Tag', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'h3',
            'options' => [
                'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'div' => 'div', 'span' => 'span',
            ],
        ] );

        $repeater->add_control( 'description', [
            'label'   => __( 'Description', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => __( 'Short service description with a <strong>highlighted phrase</strong> in the middle.', 'arenex-digital-widgets' ),
            'description' => __( 'HTML allowed. Wrap key phrases in &lt;strong&gt; for emphasis.', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'image', [
            'label' => __( 'Image (right/left side)', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );

        $repeater->add_control( 'link_text', [
            'label'   => __( 'Link Text', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Learn more', 'arenex-digital-widgets' ),
        ] );

        $repeater->add_control( 'link_url', [
            'label'       => __( 'Link URL', 'arenex-digital-widgets' ),
            'type'        => \Elementor\Controls_Manager::URL,
            'placeholder' => 'https://example.com',
            'default'     => [ 'url' => '#' ],
        ] );

        $this->add_control( 'cards', [
            'label'   => __( 'Cards', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [
                    'tag_text'    => __( 'Licensed RN & LVN', 'arenex-digital-widgets' ),
                    'title'       => __( 'Skilled Nursing', 'arenex-digital-widgets' ),
                    'title_tag'   => 'h3',
                    'description' => __( '<strong>Licensed RN and LVN visits</strong> for wound care, medication management, and post-surgical recovery.', 'arenex-digital-widgets' ),
                    'image'       => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
                    'link_text'   => __( 'Learn more', 'arenex-digital-widgets' ),
                    'link_url'    => [ 'url' => '#' ],
                ],
                [
                    'tag_text'    => __( 'Strength & Mobility', 'arenex-digital-widgets' ),
                    'title'       => __( 'Physical Therapy', 'arenex-digital-widgets' ),
                    'title_tag'   => 'h3',
                    'description' => __( 'In-home physical therapy to <strong>rebuild strength and improve balance</strong> after injury or surgery.', 'arenex-digital-widgets' ),
                    'image'       => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
                    'link_text'   => __( 'Learn more', 'arenex-digital-widgets' ),
                    'link_url'    => [ 'url' => '#' ],
                ],
                [
                    'tag_text'    => __( 'Daily Living', 'arenex-digital-widgets' ),
                    'title'       => __( 'Occupational Therapy', 'arenex-digital-widgets' ),
                    'title_tag'   => 'h3',
                    'description' => __( 'Help regaining the skills you need for <strong>daily living</strong> — dressing, bathing, cooking, and moving safely at home.', 'arenex-digital-widgets' ),
                    'image'       => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
                    'link_text'   => __( 'Learn more', 'arenex-digital-widgets' ),
                    'link_url'    => [ 'url' => '#' ],
                ],
                [
                    'tag_text'    => __( 'Stroke Recovery', 'arenex-digital-widgets' ),
                    'title'       => __( 'Speech Therapy', 'arenex-digital-widgets' ),
                    'title_tag'   => 'h3',
                    'description' => __( 'Recovery support for <strong>speech, language, cognition,</strong> and swallowing after stroke or neurological events.', 'arenex-digital-widgets' ),
                    'image'       => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
                    'link_text'   => __( 'Learn more', 'arenex-digital-widgets' ),
                    'link_url'    => [ 'url' => '#' ],
                ],
                [
                    'tag_text'    => __( 'Family Support', 'arenex-digital-widgets' ),
                    'title'       => __( 'Medical Social Services', 'arenex-digital-widgets' ),
                    'title_tag'   => 'h3',
                    'description' => __( 'Guidance navigating <strong>insurance and community resources</strong> with emotional support for patients and families.', 'arenex-digital-widgets' ),
                    'image'       => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
                    'link_text'   => __( 'Learn more', 'arenex-digital-widgets' ),
                    'link_url'    => [ 'url' => '#' ],
                ],
                [
                    'tag_text'    => __( 'Personal Care', 'arenex-digital-widgets' ),
                    'title'       => __( 'Home Health Aide', 'arenex-digital-widgets' ),
                    'title_tag'   => 'h3',
                    'description' => __( 'Compassionate, hands-on help with <strong>bathing, grooming, and mobility</strong> — with dignity and respect.', 'arenex-digital-widgets' ),
                    'image'       => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
                    'link_text'   => __( 'Learn more', 'arenex-digital-widgets' ),
                    'link_url'    => [ 'url' => '#' ],
                ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();

        /* ==========================================
           CONTENT TAB — Element Visibility
           ========================================== */
        $this->start_controls_section( 'section_visibility', [
            'label' => __( 'Element Visibility', 'arenex-digital-widgets' ),
        ] );

        $this->add_control( 'show_tag', [
            'label' => __( 'Show Tag Pill', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ] );

        $this->add_control( 'show_description', [
            'label' => __( 'Show Description', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ] );

        $this->add_control( 'show_link', [
            'label' => __( 'Show Link', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ] );

        $this->add_control( 'show_schema', [
            'label' => __( 'Output Service Schema (SEO)', 'arenex-digital-widgets' ),
            'type'  => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ] );

        $this->end_controls_section();

        /* ==========================================
           STYLE TAB — Layout Spacing
           ========================================== */
        $this->start_controls_section( 'style_layout', [
            'label' => __( 'Layout', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'grid_gap', [
            'label'      => __( 'Grid Gap', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'default'    => [ 'size' => 24, 'unit' => 'px' ],
            'tablet_default' => [ 'size' => 16, 'unit' => 'px' ],
            'mobile_default' => [ 'size' => 12, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-svcbg-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'max_width', [
            'label'      => __( 'Max Width', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range'      => [ 'px' => [ 'min' => 600, 'max' => 1600 ] ],
            'default'    => [ 'size' => 1180, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-svcbg-grid' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
            ],
        ] );

        $this->end_controls_section();

        /* ==========================================
           STYLE TAB — Card Tints
           ========================================== */
        $this->start_controls_section( 'style_tints', [
            'label' => __( 'Card Background Tints', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'tint_1', [
            'label'   => __( 'Tint 1', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#F4E8D1',
            'global'  => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-svcbg-card.tint-1' => 'background: {{VALUE}};' ],
        ] );

        $this->add_control( 'tint_2', [
            'label'   => __( 'Tint 2', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#ECE2CC',
            'selectors' => [ '{{WRAPPER}} .cmp-svcbg-card.tint-2' => 'background: {{VALUE}};' ],
        ] );

        $this->add_control( 'tint_3', [
            'label'   => __( 'Tint 3', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#F9F0DD',
            'selectors' => [ '{{WRAPPER}} .cmp-svcbg-card.tint-3' => 'background: {{VALUE}};' ],
        ] );

        $this->add_control( 'tint_4', [
            'label'   => __( 'Tint 4', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#F0E5CE',
            'selectors' => [ '{{WRAPPER}} .cmp-svcbg-card.tint-4' => 'background: {{VALUE}};' ],
            'condition' => [ 'tint_mode' => 'rotate4' ],
        ] );

        $this->end_controls_section();

        /* ==========================================
           STYLE TAB — Card
           ========================================== */
        $this->start_controls_section( 'style_card', [
            'label' => __( 'Card Style', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'card_padding', [
            'label'      => __( 'Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'default'    => [ 'top' => '40', 'right' => '44', 'bottom' => '40', 'left' => '44', 'unit' => 'px', 'isLinked' => false ],
            'tablet_default' => [ 'top' => '32', 'right' => '32', 'bottom' => '32', 'left' => '32', 'unit' => 'px', 'isLinked' => true ],
            'mobile_default' => [ 'top' => '28', 'right' => '24', 'bottom' => '28', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-svcbg-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'card_radius', [
            'label'      => __( 'Border Radius', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 48 ] ],
            'default'    => [ 'size' => 16, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-svcbg-card' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'card_border_color', [
            'label'   => __( 'Border Color', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(201,162,107,0)',
            'selectors' => [ '{{WRAPPER}} .cmp-svcbg-card' => 'border-color: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'card_border_width', [
            'label'      => __( 'Border Width', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 6 ] ],
            'default'    => [ 'size' => 0, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-svcbg-card' => 'border-width: {{SIZE}}{{UNIT}}; border-style: solid;',
            ],
        ] );

        $this->add_control( 'hover_border_color', [
            'label'     => __( 'Hover Border Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#C9A26B',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-svcbg-hover-border .cmp-svcbg-card:hover' => 'border-color: {{VALUE}};' ],
            'condition' => [ 'hover_style' => 'border' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_shadow',
            'selector' => '{{WRAPPER}} .cmp-svcbg-card:hover',
        ] );

        $this->end_controls_section();

        /* ==========================================
           STYLE TAB — Image
           ========================================== */
        $this->start_controls_section( 'style_image', [
            'label' => __( 'Image Style', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'image_position!' => 'none' ],
        ] );

        $this->add_responsive_control( 'image_width', [
            'label'      => __( 'Image Width (% of card)', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ '%' ],
            'range'      => [ '%' => [ 'min' => 30, 'max' => 70 ] ],
            'default'    => [ 'size' => 52, 'unit' => '%' ],
            'tablet_default' => [ 'size' => 100, 'unit' => '%' ],
            'mobile_default' => [ 'size' => 100, 'unit' => '%' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-svcbg-card-img' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'fade_intensity', [
            'label'      => __( 'Fade Intensity', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ '%' ],
            'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
            'default'    => [ 'size' => 70, 'unit' => '%' ],
            'description' => __( 'Higher = more fade into card background.', 'arenex-digital-widgets' ),
            'selectors'  => [
                '{{WRAPPER}} .cmp-svcbg-card-img::after' => 'background: linear-gradient(to right, var(--cmp-card-bg) 0%, transparent {{SIZE}}{{UNIT}});',
                '{{WRAPPER}} .cmp-svcbg-card--left .cmp-svcbg-card-img::after' => 'background: linear-gradient(to left, var(--cmp-card-bg) 0%, transparent {{SIZE}}{{UNIT}});',
            ],
        ] );

        $this->add_control( 'image_object_fit', [
            'label'   => __( 'Object Fit', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'cover',
            'options' => [
                'cover'   => 'Cover',
                'contain' => 'Contain',
            ],
            'selectors' => [
                '{{WRAPPER}} .cmp-svcbg-card-img img' => 'object-fit: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'image_object_position', [
            'label'   => __( 'Object Position', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'center',
            'options' => [
                'center'      => 'Center',
                'top'         => 'Top',
                'bottom'      => 'Bottom',
                'left'        => 'Left',
                'right'       => 'Right',
            ],
            'selectors' => [
                '{{WRAPPER}} .cmp-svcbg-card-img img' => 'object-position: {{VALUE}};',
            ],
        ] );

        $this->end_controls_section();

        /* ==========================================
           STYLE TAB — Tag Pill
           ========================================== */
        $this->start_controls_section( 'style_tag', [
            'label' => __( 'Tag Pill', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_tag' => 'yes' ],
        ] );

        $this->add_control( 'tag_bg', [
            'label'   => __( 'Background', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(255,255,255,0.85)',
            'selectors' => [ '{{WRAPPER}} .cmp-svcbg-tag' => 'background: {{VALUE}};' ],
        ] );

        $this->add_control( 'tag_text_color', [
            'label'   => __( 'Text Color', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#5C3A1E',
            'global'  => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-svcbg-tag' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'tag_dot_color', [
            'label'   => __( 'Dot Color', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#C9A26B',
            'global'  => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-svcbg-tag-dot' => 'background: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'tag_typography',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ],
            'selector' => '{{WRAPPER}} .cmp-svcbg-tag',
        ] );

        $this->add_responsive_control( 'tag_padding', [
            'label'      => __( 'Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'default'    => [ 'top' => '8', 'right' => '16', 'bottom' => '8', 'left' => '12', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-svcbg-tag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'tag_bottom_spacing', [
            'label'      => __( 'Bottom Spacing', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'default'    => [ 'size' => 22, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-svcbg-tag' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();

        /* ==========================================
           STYLE TAB — Title
           ========================================== */
        $this->start_controls_section( 'style_title', [
            'label' => __( 'Title', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'title_color', [
            'label'   => __( 'Color', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#5C3A1E',
            'global'  => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-svcbg-title' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ],
            'selector' => '{{WRAPPER}} .cmp-svcbg-title',
        ] );

        $this->add_responsive_control( 'title_bottom_spacing', [
            'label'      => __( 'Bottom Spacing', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
            'default'    => [ 'size' => 12, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-svcbg-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();

        /* ==========================================
           STYLE TAB — Description
           ========================================== */
        $this->start_controls_section( 'style_desc', [
            'label' => __( 'Description', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_description' => 'yes' ],
        ] );

        $this->add_control( 'desc_color', [
            'label'   => __( 'Color', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#2B1F15',
            'global'  => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'selectors' => [ '{{WRAPPER}} .cmp-svcbg-desc' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'desc_strong_color', [
            'label'   => __( 'Highlighted Phrase Color', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#5C3A1E',
            'global'  => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-svcbg-desc strong' => 'color: {{VALUE}}; font-weight: 600;' ],
        ] );

        $this->add_control( 'desc_opacity', [
            'label'      => __( 'Opacity', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'range'      => [ 'px' => [ 'min' => 0.4, 'max' => 1, 'step' => 0.02 ] ],
            'default'    => [ 'size' => 0.82, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-svcbg-desc' => 'opacity: {{SIZE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'desc_typography',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-svcbg-desc',
        ] );

        $this->add_responsive_control( 'desc_bottom_spacing', [
            'label'      => __( 'Bottom Spacing', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'default'    => [ 'size' => 24, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-svcbg-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();

        /* ==========================================
           STYLE TAB — Link
           ========================================== */
        $this->start_controls_section( 'style_link', [
            'label' => __( 'Link', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_link' => 'yes' ],
        ] );

        $this->add_control( 'link_color', [
            'label'   => __( 'Color', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#5C3A1E',
            'global'  => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-svcbg-link' => 'color: {{VALUE}}; border-bottom-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'link_hover_color', [
            'label'   => __( 'Hover Color', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#A8854F',
            'global'  => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-svcbg-card:hover .cmp-svcbg-link' => 'color: {{VALUE}}; border-bottom-color: {{VALUE}};' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'link_typography',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ],
            'selector' => '{{WRAPPER}} .cmp-svcbg-link',
        ] );

        $this->end_controls_section();

        /* ==========================================
           STYLE TAB — Animation
           ========================================== */
        $this->start_controls_section( 'style_animation', [
            'label' => __( 'Animation', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'reveal_animation', [
            'label'   => __( 'Reveal On Scroll', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ] );

        $this->add_control( 'stagger_delay', [
            'label'      => __( 'Stagger Delay (ms)', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 400, 'step' => 25 ] ],
            'default'    => [ 'size' => 100, 'unit' => 'px' ],
            'condition'  => [ 'reveal_animation' => 'yes' ],
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
            'label'      => __( 'Section Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'mobile_default' => [ 'top' => '0', 'right' => '16', 'bottom' => '0', 'left' => '16', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [
                '{{WRAPPER}} .cmp-svcbg-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $show_tag         = ( ! empty( $s['show_tag'] ) && $s['show_tag'] === 'yes' );
        $show_description = ( ! empty( $s['show_description'] ) && $s['show_description'] === 'yes' );
        $show_link        = ( ! empty( $s['show_link'] ) && $s['show_link'] === 'yes' );
        $show_schema      = ( ! empty( $s['show_schema'] ) && $s['show_schema'] === 'yes' );

        $image_position = ! empty( $s['image_position'] ) ? $s['image_position'] : 'right';
        $tint_mode      = ! empty( $s['tint_mode'] ) ? $s['tint_mode'] : 'rotate3';
        $hover_style    = ! empty( $s['hover_style'] ) ? $s['hover_style'] : 'lift';
        $reveal         = ( ! empty( $s['reveal_animation'] ) && $s['reveal_animation'] === 'yes' );
        $stagger        = ! empty( $s['stagger_delay']['size'] ) ? intval( $s['stagger_delay']['size'] ) : 100;

        $allowed_tags  = [ 'h2','h3','h4','h5','div','span','p' ];
        $allowed_html  = [ 'strong' => [], 'em' => [], 'b' => [], 'i' => [], 'br' => [], 'span' => [ 'class' => true ] ];

        $tint_count = ( $tint_mode === 'rotate4' ) ? 4 : ( $tint_mode === 'alternate' ? 2 : ( $tint_mode === 'single' ? 1 : 3 ) );

        $wrap_classes = 'cmp-svcbg-wrap cmp-svcbg-hover-' . esc_attr( $hover_style );
        if ( $hover_style === 'border' ) $wrap_classes .= ' cmp-svcbg-hover-border';
        ?>
        <div class="<?php echo esc_attr( $wrap_classes ); ?>">
            <div class="cmp-svcbg-grid">
                <?php foreach ( (array) $s['cards'] as $i => $card ) :
                    $tint_index = ( $i % $tint_count ) + 1;
                    $card_class = 'cmp-svcbg-card tint-' . $tint_index . ' cmp-svcbg-card--' . esc_attr( $image_position );
                    if ( $reveal ) $card_class .= ' cmp-reveal';
                    $delay_ms   = $reveal ? ( ( $i % 6 ) * $stagger ) : 0;
                    $tag_text   = ! empty( $card['tag_text'] ) ? $card['tag_text'] : '';
                    $title      = ! empty( $card['title'] ) ? $card['title'] : '';
                    $title_tag  = in_array( ($card['title_tag'] ?? 'h3'), $allowed_tags, true ) ? $card['title_tag'] : 'h3';
                    $desc       = ! empty( $card['description'] ) ? $card['description'] : '';
                    $img_url    = ! empty( $card['image']['url'] ) ? $card['image']['url'] : '';
                    $img_alt    = ! empty( $card['image']['alt'] ) ? $card['image']['alt'] : $title;
                    $link_url   = ! empty( $card['link_url']['url'] ) ? $card['link_url']['url'] : '';
                    $link_text  = ! empty( $card['link_text'] ) ? $card['link_text'] : '';
                    $link_target = ! empty( $card['link_url']['is_external'] ) ? ' target="_blank"' : '';
                    $link_rel    = ! empty( $card['link_url']['is_external'] ) ? ' rel="noopener noreferrer"' : ( ! empty( $card['link_url']['nofollow'] ) ? ' rel="nofollow"' : '' );
                ?>
                <article class="<?php echo esc_attr( $card_class ); ?>"
                         <?php if ( $delay_ms ) echo 'style="--cmp-reveal-delay:' . esc_attr( $delay_ms ) . 'ms;"'; ?>>
                    <div class="cmp-svcbg-content">
                        <?php if ( $show_tag && $tag_text ) : ?>
                        <span class="cmp-svcbg-tag">
                            <span class="cmp-svcbg-tag-dot" aria-hidden="true"></span>
                            <?php echo esc_html( $tag_text ); ?>
                        </span>
                        <?php endif; ?>

                        <?php if ( $title ) : ?>
                        <<?php echo esc_attr( $title_tag ); ?> class="cmp-svcbg-title"><?php echo esc_html( $title ); ?></<?php echo esc_attr( $title_tag ); ?>>
                        <?php endif; ?>

                        <?php if ( $show_description && $desc ) : ?>
                        <p class="cmp-svcbg-desc"><?php echo wp_kses( $desc, $allowed_html ); ?></p>
                        <?php endif; ?>

                        <?php if ( $show_link && $link_url && $link_text ) : ?>
                        <a class="cmp-svcbg-link" href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_target . $link_rel; ?>>
                            <?php echo esc_html( $link_text ); ?>
                            <span class="cmp-svcbg-link-arrow" aria-hidden="true">→</span>
                        </a>
                        <?php endif; ?>
                    </div>

                    <?php if ( $image_position !== 'none' && $img_url ) : ?>
                    <div class="cmp-svcbg-card-img">
                        <img src="<?php echo esc_url( $img_url ); ?>"
                             alt="<?php echo esc_attr( $img_alt ); ?>"
                             width="700" height="500"
                             loading="lazy">
                    </div>
                    <?php endif; ?>
                </article>

                <?php if ( $show_schema && $title ) : ?>
                <script type="application/ld+json">
                {
                    "@context": "https://schema.org",
                    "@type": "Service",
                    "name": <?php echo wp_json_encode( wp_strip_all_tags( $title ) ); ?>,
                    "description": <?php echo wp_json_encode( wp_strip_all_tags( $desc ) ); ?><?php if ( $link_url ) : ?>,
                    "url": <?php echo wp_json_encode( esc_url_raw( $link_url ) ); ?><?php endif; ?>
                }
                </script>
                <?php endif; ?>

                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}
}
