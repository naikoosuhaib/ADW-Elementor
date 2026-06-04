<?php
/**
 * ADW — Timeline
 *
 * Vertical or horizontal timeline of events. Per-item: marker text/year,
 * title, description, optional icon. Marker style options: dot / number /
 * year-pill / icon. Two-column mode pairs a section heading on the left
 * with items on the right (replaces the timeline-on-right-of-Story-Section
 * pattern).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Timeline extends \Elementor\Widget_Base {

	public function get_name()           { return 'cmp_timeline'; }
	public function get_title()          { return __( 'ADW — Timeline', 'arenex-digital-widgets' ); }
	public function get_icon()           { return 'eicon-time-line'; }
	public function get_categories()     { return [ 'arenex-digital' ]; }
	public function get_keywords()       { return [ 'timeline', 'history', 'milestones', 'story', 'journey' ]; }
	public function get_style_depends()  { return [ 'adw-styles' ]; }
	public function get_script_depends() { return [ 'adw-front' ]; }

	protected function register_controls() {

		/* ── LAYOUT ── */
		$this->start_controls_section( 'sec_layout', [
			'label' => __( 'Layout', 'arenex-digital-widgets' ),
		] );

		$this->add_control( 'design_style', [
			'label'       => __( 'Design Style', 'arenex-digital-widgets' ),
			'type'        => \Elementor\Controls_Manager::SELECT,
			'default'     => 'style-1',
			'options'     => [
				'style-1' => __( 'Style 1 — Classic', 'arenex-digital-widgets' ),
			],
			'description' => __( 'More styles coming soon.', 'arenex-digital-widgets' ),
		] );

		$this->add_control( 'orientation', [
			'label'   => __( 'Orientation', 'arenex-digital-widgets' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'vertical',
			'options' => [
				'vertical'   => __( 'Vertical', 'arenex-digital-widgets' ),
				'horizontal' => __( 'Horizontal', 'arenex-digital-widgets' ),
			],
		] );

		$this->add_control( 'vertical_layout', [
			'label'       => __( 'Vertical Layout', 'arenex-digital-widgets' ),
			'type'        => \Elementor\Controls_Manager::SELECT,
			'default'     => 'standard',
			'options'     => [
				'standard' => __( 'Standard (single side)', 'arenex-digital-widgets' ),
				'alt'      => __( 'Alternating (zig-zag)', 'arenex-digital-widgets' ),
			],
			'condition'   => [ 'orientation' => 'vertical' ],
			'description' => __( 'Alternating places each card on alternating sides of a centered line — great for a "Next Steps" / process section. Add a per-item button in the Items tab.', 'arenex-digital-widgets' ),
		] );

		$this->add_control( 'theme', [
			'label'   => __( 'Theme', 'arenex-digital-widgets' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'light',
			'options' => [
				'light' => __( 'Light', 'arenex-digital-widgets' ),
				'dark'  => __( 'Dark', 'arenex-digital-widgets' ),
			],
		] );

		$this->add_control( 'marker_style', [
			'label'   => __( 'Marker Style', 'arenex-digital-widgets' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'number',
			'options' => [
				'number'    => __( 'Number (1, 2, 3…)', 'arenex-digital-widgets' ),
				'dot'       => __( 'Dot', 'arenex-digital-widgets' ),
				'icon'      => __( 'Icon (per item)', 'arenex-digital-widgets' ),
				'year-pill' => __( 'Year pill (uses item year)', 'arenex-digital-widgets' ),
			],
		] );

		$this->add_control( 'show_item_icon', [
			'label'        => __( 'Show Item Icon (below marker)', 'arenex-digital-widgets' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => __( 'Yes', 'arenex-digital-widgets' ),
			'label_off'    => __( 'No', 'arenex-digital-widgets' ),
			'return_value' => 'yes',
			'default'      => '',
			'description'  => __( 'Renders the per-item icon as a separate element between the marker and the title. Combine with Marker Style = Number/Dot for the "number-in-circle + icon-below + title" layout.', 'arenex-digital-widgets' ),
			'condition'    => [
				'marker_style!' => 'icon',
			],
		] );

		$this->add_control( 'show_year', [
			'label'        => __( 'Show Year / Marker Text', 'arenex-digital-widgets' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => __( 'Show', 'arenex-digital-widgets' ),
			'label_off'    => __( 'Hide', 'arenex-digital-widgets' ),
			'return_value' => 'yes',
			'default'      => 'yes',
			'description'  => __( 'Show or hide the year/marker text label that sits under each marker.', 'arenex-digital-widgets' ),
		] );

		$this->add_control( 'item_align', [
			'label'     => __( 'Item Alignment', 'arenex-digital-widgets' ),
			'type'      => \Elementor\Controls_Manager::CHOOSE,
			'options'   => [
				'left'   => [ 'title' => __( 'Left',   'arenex-digital-widgets' ), 'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => __( 'Center', 'arenex-digital-widgets' ), 'icon' => 'eicon-text-align-center' ],
				'right'  => [ 'title' => __( 'Right',  'arenex-digital-widgets' ), 'icon' => 'eicon-text-align-right' ],
			],
			'default'   => 'center',
			'toggle'    => false,
			'condition' => [ 'orientation' => 'horizontal' ],
			'description' => __( 'Aligns the marker, icon, and text under it. Use Left when the section heading above is also left-aligned (no gap).', 'arenex-digital-widgets' ),
		] );

		$this->end_controls_section();

		/* ── ITEMS ── */
		$this->start_controls_section( 'sec_items', [
			'label' => __( 'Items', 'arenex-digital-widgets' ),
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'year', [
			'label'   => __( 'Year / Marker Text', 'arenex-digital-widgets' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '2020',
		] );

		$repeater->add_control( 'title', [
			'label'   => __( 'Title', 'arenex-digital-widgets' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Milestone Title',
		] );

		$repeater->add_control( 'description', [
			'label'   => __( 'Description', 'arenex-digital-widgets' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'Short description of what happened at this milestone.',
		] );

		$repeater->add_control( 'icon', [
			'label'   => __( 'Icon (when Marker Style = Icon)', 'arenex-digital-widgets' ),
			'type'    => \Elementor\Controls_Manager::ICONS,
			'default' => [ 'value' => 'fas fa-star', 'library' => 'fa-solid' ],
		] );

		$repeater->add_control( 'button_text', [
			'label'       => __( 'Button Text (optional)', 'arenex-digital-widgets' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '',
			'placeholder' => __( 'e.g. Get Started', 'arenex-digital-widgets' ),
			'description' => __( 'Leave empty for no button on this item.', 'arenex-digital-widgets' ),
		] );

		$repeater->add_control( 'button_link', [
			'label'       => __( 'Button Link', 'arenex-digital-widgets' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'default'     => [ 'url' => '#' ],
			'placeholder' => __( 'https://your-link.com', 'arenex-digital-widgets' ),
			'condition'   => [ 'button_text!' => '' ],
		] );

		$this->add_control( 'items', [
			'label'       => __( 'Timeline Items', 'arenex-digital-widgets' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ year }}} — {{{ title }}}',
			'default'     => [
				[ 'year' => '2020', 'title' => 'Founded',    'description' => 'Started with a clear vision and small team.', 'button_text' => 'Get Started', 'button_link' => [ 'url' => '#' ] ],
				[ 'year' => '2022', 'title' => 'Expansion',  'description' => 'Doubled the team and opened a second location.' ],
				[ 'year' => '2024', 'title' => 'Recognition','description' => 'Industry awards and major client wins.' ],
				[ 'year' => 'Now',  'title' => 'Today',      'description' => 'Continuing to push standards forward.' ],
			],
		] );

		$this->end_controls_section();

		/* ── STYLE: Layout ── */
		$this->start_controls_section( 'sec_style_layout', [
			'label' => __( 'Layout', 'arenex-digital-widgets' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'section_padding', [
			'label'          => __( 'Section Padding', 'arenex-digital-widgets' ),
			'type'           => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units'     => [ 'px', 'em', '%' ],
			'default'        => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
			'tablet_default' => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
			'mobile_default' => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
			'selectors'      => [ '{{WRAPPER}} .cmp-timeline' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'items_max_width', [
			'label'      => __( 'Max Width', 'arenex-digital-widgets' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 400, 'max' => 1600 ] ],
			'default'    => [ 'size' => 1200, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .cmp-timeline__inner' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;' ],
		] );

		$this->add_responsive_control( 'items_gap', [
			'label'          => __( 'Item Gap', 'arenex-digital-widgets' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'default'        => [ 'size' => 32, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 24, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 20, 'unit' => 'px' ],
			'selectors'      => [
				'{{WRAPPER}} .cmp-timeline--vertical .cmp-timeline__item'   => 'padding-bottom: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .cmp-timeline--horizontal .cmp-timeline__items' => 'gap: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		/* ── STYLE: Items ── */
		$this->start_controls_section( 'sec_style_items', [
			'label' => __( 'Items', 'arenex-digital-widgets' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'item_title_color', [
			'label'     => __( 'Title Color', 'arenex-digital-widgets' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#1A1A1A',
			'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
			'selectors' => [ '{{WRAPPER}} .cmp-timeline__title' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'item_title_typo',
			'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_SECONDARY ],
			'selector' => '{{WRAPPER}} .cmp-timeline__title',
		] );

		$this->add_control( 'item_desc_color', [
			'label'     => __( 'Description Color', 'arenex-digital-widgets' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#3A3A3A',
			'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
			'selectors' => [ '{{WRAPPER}} .cmp-timeline__desc' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'item_desc_typo',
			'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
			'selector' => '{{WRAPPER}} .cmp-timeline__desc',
		] );

		$this->add_control( 'year_color', [
			'label'     => __( 'Year / Marker Text Color', 'arenex-digital-widgets' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFEB00',
			'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
			'selectors' => [ '{{WRAPPER}} .cmp-timeline__year' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'year_typo',
			'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT ],
			'selector' => '{{WRAPPER}} .cmp-timeline__year',
		] );

		$this->end_controls_section();

		/* ── STYLE: Marker ── */
		$this->start_controls_section( 'sec_style_marker', [
			'label' => __( 'Marker', 'arenex-digital-widgets' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'marker_bg', [
			'label'     => __( 'Marker Background', 'arenex-digital-widgets' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFEB00',
			'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
			'selectors' => [ '{{WRAPPER}} .cmp-timeline__marker' => 'background: {{VALUE}};' ],
		] );

		$this->add_control( 'marker_text_color', [
			'label'     => __( 'Marker Icon / Text Color', 'arenex-digital-widgets' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#0D0D0D',
			'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
			'selectors' => [ '{{WRAPPER}} .cmp-timeline__marker' => 'color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'marker_size', [
			'label'          => __( 'Marker Size', 'arenex-digital-widgets' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 20, 'max' => 72 ] ],
			'default'        => [ 'size' => 36, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 32, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 30, 'unit' => 'px' ],
			'selectors'      => [
				'{{WRAPPER}}' => '--cmp-marker-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .cmp-timeline--vertical .cmp-timeline__marker'   => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .cmp-timeline--horizontal .cmp-timeline__marker' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		/* ── STYLE: Item Icon ── */
		$this->start_controls_section( 'sec_style_item_icon', [
			'label'     => __( 'Item Icon', 'arenex-digital-widgets' ),
			'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_item_icon' => 'yes' ],
		] );

		$this->add_control( 'item_icon_color', [
			'label'     => __( 'Icon Color', 'arenex-digital-widgets' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#0D0D0D',
			'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
			'selectors' => [
				'{{WRAPPER}} .cmp-timeline__icon'     => 'color: {{VALUE}};',
				'{{WRAPPER}} .cmp-timeline__icon svg' => 'fill: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'item_icon_size', [
			'label'          => __( 'Icon Size', 'arenex-digital-widgets' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 12, 'max' => 96 ] ],
			'default'        => [ 'size' => 32, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 28, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 26, 'unit' => 'px' ],
			'selectors'      => [
				'{{WRAPPER}} .cmp-timeline__icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .cmp-timeline__icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'item_icon_gap_top', [
			'label'      => __( 'Gap Above (from marker)', 'arenex-digital-widgets' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'size' => 18, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .cmp-timeline__icon' => 'margin-top: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'item_icon_gap_bottom', [
			'label'      => __( 'Gap Below (to title)', 'arenex-digital-widgets' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'size' => 14, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .cmp-timeline__icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		/* ── STYLE: Button ── */
		$this->start_controls_section( 'sec_style_button', [
			'label' => __( 'Button', 'arenex-digital-widgets' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'button_color', [
			'label'     => __( 'Text Color', 'arenex-digital-widgets' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFFFFF',
			'selectors' => [ '{{WRAPPER}} .cmp-timeline__btn' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'button_bg', [
			'label'     => __( 'Background', 'arenex-digital-widgets' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#176470',
			'selectors' => [ '{{WRAPPER}} .cmp-timeline__btn' => 'background: {{VALUE}};' ],
		] );

		$this->add_control( 'button_color_hover', [
			'label'     => __( 'Text Color (Hover)', 'arenex-digital-widgets' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .cmp-timeline__btn:hover' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'button_bg_hover', [
			'label'     => __( 'Background (Hover)', 'arenex-digital-widgets' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .cmp-timeline__btn:hover' => 'background: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'button_typo',
			'selector' => '{{WRAPPER}} .cmp-timeline__btn',
		] );

		$this->add_responsive_control( 'button_padding', [
			'label'      => __( 'Padding', 'arenex-digital-widgets' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'default'    => [ 'top' => '11', 'right' => '22', 'bottom' => '11', 'left' => '22', 'unit' => 'px', 'isLinked' => false ],
			'selectors'  => [ '{{WRAPPER}} .cmp-timeline__btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'button_radius', [
			'label'      => __( 'Border Radius', 'arenex-digital-widgets' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 6, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .cmp-timeline__btn' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		/* ── STYLE: Line ── */
		$this->start_controls_section( 'sec_style_line', [
			'label' => __( 'Line', 'arenex-digital-widgets' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'line_color', [
			'label'     => __( 'Line Color', 'arenex-digital-widgets' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#E0E0E0',
			'selectors' => [
				'{{WRAPPER}} .cmp-timeline__items::before'             => 'border-color: {{VALUE}};',
				'{{WRAPPER}} .cmp-timeline--alt .cmp-timeline__item::before' => 'border-color: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'line_thickness', [
			'label'      => __( 'Line Thickness', 'arenex-digital-widgets' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 1, 'max' => 8 ] ],
			'default'    => [ 'size' => 2, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .cmp-timeline--vertical .cmp-timeline__items::before'   => 'border-left-width: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .cmp-timeline--horizontal .cmp-timeline__items::before' => 'border-top-width: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .cmp-timeline--alt .cmp-timeline__item::before'         => 'border-left-width: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'line_style', [
			'label'     => __( 'Line Style', 'arenex-digital-widgets' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'solid',
			'options'   => [
				'solid'  => __( 'Solid', 'arenex-digital-widgets' ),
				'dashed' => __( 'Dashed', 'arenex-digital-widgets' ),
				'dotted' => __( 'Dotted', 'arenex-digital-widgets' ),
				'none'   => __( 'None (hide line)', 'arenex-digital-widgets' ),
			],
			'selectors' => [
				'{{WRAPPER}} .cmp-timeline--vertical .cmp-timeline__items::before'   => 'border-left-style: {{VALUE}};',
				'{{WRAPPER}} .cmp-timeline--horizontal .cmp-timeline__items::before' => 'border-top-style: {{VALUE}};',
				'{{WRAPPER}} .cmp-timeline--alt .cmp-timeline__item::before'         => 'border-left-style: {{VALUE}};',
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();

		$orientation = $s['orientation']  ?? 'vertical';
		$theme       = $s['theme']        ?? 'light';
		$marker      = $s['marker_style'] ?? 'number';
		$item_align  = $s['item_align']   ?? 'center';
		$show_year   = ( $s['show_year']  ?? 'yes' ) === 'yes';
		$v_layout    = $s['vertical_layout'] ?? 'standard';

		$classes  = [ 'cmp-timeline' ];
		$classes[] = 'cmp-timeline--' . esc_attr( $orientation );
		$classes[] = 'cmp-timeline--' . esc_attr( $theme );
		$classes[] = 'cmp-timeline--align-' . esc_attr( $item_align );
		if ( $orientation === 'vertical' && $v_layout === 'alt' ) {
			$classes[] = 'cmp-timeline--alt';
		}

		?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<div class="cmp-timeline__inner">
				<div class="cmp-timeline__items">
					<?php
					if ( ! empty( $s['items'] ) && is_array( $s['items'] ) ) :
						foreach ( $s['items'] as $i => $item ) :
							$year  = $item['year']  ?? '';
							$title = $item['title'] ?? '';
							$desc  = $item['description'] ?? '';
							$num   = $i + 1;

							// Marker content
							$marker_content = '';
							if ( $marker === 'number' ) {
								$marker_content = (string) $num;
							} elseif ( $marker === 'year-pill' ) {
								$marker_content = esc_html( $year );
							} elseif ( $marker === 'dot' ) {
								$marker_content = '';
							} elseif ( $marker === 'icon' && ! empty( $item['icon'] ) ) {
								ob_start();
								\Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
								$marker_content = ob_get_clean();
							}
							?>
							<div class="cmp-timeline__item">
								<div class="cmp-timeline__marker"><?php echo $marker_content; ?></div>
								<div class="cmp-timeline__content">
									<?php
									// Item icon rendered as a separate element (below marker / above title)
									// when the "Show Item Icon" switcher is on and marker isn't already an icon.
									$show_item_icon = ( $s['show_item_icon'] ?? '' ) === 'yes';
									if ( $show_item_icon && $marker !== 'icon' && ! empty( $item['icon']['value'] ) ) :
										?>
										<div class="cmp-timeline__icon">
											<?php \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</div>
										<?php
									endif;
									?>
									<?php if ( $show_year && $year && $marker !== 'year-pill' ) : ?>
										<div class="cmp-timeline__year"><?php echo esc_html( $year ); ?></div>
									<?php endif; ?>
									<?php if ( $title ) : ?>
										<h3 class="cmp-timeline__title"><?php echo esc_html( $title ); ?></h3>
									<?php endif; ?>
									<?php if ( $desc ) : ?>
										<p class="cmp-timeline__desc"><?php echo esc_html( $desc ); ?></p>
									<?php endif; ?>
									<?php
									// Optional per-item button (text + link). Renders in any layout;
									// pairs especially well with the Alternating layout.
									$btn_text = $item['button_text'] ?? '';
									if ( $btn_text !== '' ) :
										$btn_link = $item['button_link'] ?? [];
										$btn_url  = ! empty( $btn_link['url'] ) ? $btn_link['url'] : '#';
										$btn_tgt  = ! empty( $btn_link['is_external'] ) ? ' target="_blank"' : '';
										$btn_rel  = ! empty( $btn_link['nofollow'] ) ? ' rel="nofollow"' : '';
										?>
										<a class="cmp-timeline__btn" href="<?php echo esc_url( $btn_url ); ?>"<?php echo $btn_tgt . $btn_rel; ?>><?php echo esc_html( $btn_text ); ?></a>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach;
					endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	protected function content_template() {}
}
