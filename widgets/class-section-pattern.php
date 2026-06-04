<?php
/**
 * ADW — Section Pattern
 *
 * Drop this widget anywhere inside a section/container to overlay a
 * decorative background pattern (dots, grid, stripes, diagonal hairlines,
 * SVG noise) on the parent. Pattern color picks up from Elementor's
 * Global Colors so swapping a kit re-paints the patterns.
 *
 * Renders as an absolutely-positioned overlay div that fills the parent
 * (z-index 0, pointer-events none). The widget itself takes no flow space.
 *
 * Usage:
 *   - Add to a section
 *   - Pick pattern type (Dots / Grid / Stripes / Diagonal / Noise)
 *   - Pick color (defaults to "Accent" global)
 *   - Adjust opacity + density
 *   - Done
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Section_Pattern extends \Elementor\Widget_Base {

	public function get_name()       { return 'cmp_section_pattern'; }
	public function get_title()      { return __( 'ADW — Section Pattern', 'arenex-digital-widgets' ); }
	public function get_icon()       { return 'eicon-background'; }
	public function get_categories() { return [ 'arenex-digital' ]; }
	public function get_keywords()   { return [ 'pattern', 'background', 'dots', 'grid', 'stripes', 'overlay' ]; }
	public function get_style_depends()  { return [ 'adw-styles' ]; }

	protected function register_controls() {

		$this->start_controls_section( 'section_pattern', [
			'label' => __( 'Pattern', 'arenex-digital-widgets' ),
		] );

		$this->add_control( 'pattern_type', [
			'label'   => __( 'Pattern', 'arenex-digital-widgets' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'dots',
			'options' => [
				'dots'     => __( 'Dots', 'arenex-digital-widgets' ),
				'grid'     => __( 'Grid', 'arenex-digital-widgets' ),
				'stripes'  => __( 'Stripes (45°)', 'arenex-digital-widgets' ),
				'diagonal' => __( 'Diagonal Hairlines (135°)', 'arenex-digital-widgets' ),
				'noise'    => __( 'SVG Noise', 'arenex-digital-widgets' ),
			],
		] );

		$this->add_control( 'pattern_color', [
			'label'       => __( 'Color', 'arenex-digital-widgets' ),
			'type'        => \Elementor\Controls_Manager::COLOR,
			'default'     => '#0D0D0D',
			'global'      => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
			'description' => __( 'Pattern color. Tip: pick a Global Color so it follows your active kit.', 'arenex-digital-widgets' ),
		] );

		$this->add_control( 'pattern_opacity', [
			'label'      => __( 'Opacity', 'arenex-digital-widgets' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100, 'step' => 1 ] ],
			'default'    => [ 'unit' => '%', 'size' => 12 ],
			'description' => __( 'Lower = subtler.', 'arenex-digital-widgets' ),
		] );

		$this->add_control( 'pattern_density', [
			'label'      => __( 'Density', 'arenex-digital-widgets' ),
			'type'       => \Elementor\Controls_Manager::SELECT,
			'default'    => 'normal',
			'options'    => [
				'tight'  => __( 'Tight', 'arenex-digital-widgets' ),
				'normal' => __( 'Normal', 'arenex-digital-widgets' ),
				'loose'  => __( 'Loose', 'arenex-digital-widgets' ),
			],
			'condition'  => [ 'pattern_type!' => 'noise' ],
		] );

		$this->add_control( 'pattern_blend', [
			'label'      => __( 'Blend Mode', 'arenex-digital-widgets' ),
			'type'       => \Elementor\Controls_Manager::SELECT,
			'default'    => 'normal',
			'options'    => [
				'normal'      => __( 'Normal', 'arenex-digital-widgets' ),
				'multiply'    => __( 'Multiply', 'arenex-digital-widgets' ),
				'screen'      => __( 'Screen', 'arenex-digital-widgets' ),
				'overlay'     => __( 'Overlay', 'arenex-digital-widgets' ),
				'soft-light'  => __( 'Soft Light', 'arenex-digital-widgets' ),
				'difference'  => __( 'Difference', 'arenex-digital-widgets' ),
			],
		] );

		$this->add_control( 'apply_to', [
			'label'      => __( 'Apply To', 'arenex-digital-widgets' ),
			'type'       => \Elementor\Controls_Manager::SELECT,
			'default'    => 'parent-section',
			'options'    => [
				'parent-section' => __( 'Parent section/container (default)', 'arenex-digital-widgets' ),
				'self'           => __( 'Just this widget area', 'arenex-digital-widgets' ),
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s        = $this->get_settings_for_display();
		$type     = $s['pattern_type']    ?? 'dots';
		$color    = $s['pattern_color']   ?? '#0D0D0D';
		$opacity  = isset( $s['pattern_opacity']['size'] ) ? (int) $s['pattern_opacity']['size'] : 12;
		$density  = $s['pattern_density'] ?? 'normal';
		$blend    = $s['pattern_blend']   ?? 'normal';
		$apply_to = $s['apply_to']        ?? 'parent-section';

		// Density → background-size
		$size_map = [
			'dots'     => [ 'tight' => '14px 14px', 'normal' => '22px 22px', 'loose' => '36px 36px' ],
			'grid'     => [ 'tight' => '24px 24px', 'normal' => '40px 40px', 'loose' => '64px 64px' ],
			'stripes'  => [ 'tight' => '8px 8px',   'normal' => '12px 12px', 'loose' => '20px 20px' ],
			'diagonal' => [ 'tight' => '12px 12px', 'normal' => '18px 18px', 'loose' => '28px 28px' ],
		];

		// Build CSS variables for the pattern
		$css = '';
		$rgba_color = $color ? $color : 'rgba(0,0,0,1)';

		if ( $type === 'dots' ) {
			$bgsize = $size_map['dots'][ $density ] ?? $size_map['dots']['normal'];
			$css = "background-image: radial-gradient(circle, {$rgba_color} 1.5px, transparent 1.5px); background-size: {$bgsize};";
		} elseif ( $type === 'grid' ) {
			$bgsize = $size_map['grid'][ $density ] ?? $size_map['grid']['normal'];
			$css = "background-image: linear-gradient(to right, {$rgba_color} 1px, transparent 1px), linear-gradient(to bottom, {$rgba_color} 1px, transparent 1px); background-size: {$bgsize};";
		} elseif ( $type === 'stripes' ) {
			$bgsize = $size_map['stripes'][ $density ] ?? $size_map['stripes']['normal'];
			list( $stripe_w ) = explode( 'px', $bgsize );
			$css = "background-image: repeating-linear-gradient(45deg, {$rgba_color} 0 {$stripe_w}px, transparent {$stripe_w}px " . ( (int) $stripe_w * 2 ) . "px);";
		} elseif ( $type === 'diagonal' ) {
			$bgsize = $size_map['diagonal'][ $density ] ?? $size_map['diagonal']['normal'];
			list( $line_gap ) = explode( 'px', $bgsize );
			$css = "background-image: repeating-linear-gradient(135deg, transparent 0 {$line_gap}px, {$rgba_color} {$line_gap}px " . ( (int) $line_gap + 1 ) . "px);";
		} elseif ( $type === 'noise' ) {
			$css = "background-image: url(\"data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.5' numOctaves='2' /%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.35'/%3E%3C/svg%3E\");";
		}

		$opacity_dec = number_format( $opacity / 100, 2 );
		$style       = sprintf(
			'%s opacity: %s; mix-blend-mode: %s;',
			$css,
			esc_attr( $opacity_dec ),
			esc_attr( $blend )
		);

		$selector = $apply_to === 'self' ? '' : ' data-apply-parent="1"';
		?>
		<div class="cmp-section-pattern"<?php echo $selector; ?>>
			<div class="cmp-section-pattern__overlay" style="<?php echo esc_attr( $style ); ?>"></div>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<#
		var type    = settings.pattern_type    || 'dots';
		var color   = settings.pattern_color   || '#0D0D0D';
		var opacity = ( settings.pattern_opacity && settings.pattern_opacity.size !== undefined ) ? settings.pattern_opacity.size : 12;
		var density = settings.pattern_density || 'normal';
		var blend   = settings.pattern_blend   || 'normal';
		var sizeMap = {
			dots:     { tight: '14px 14px', normal: '22px 22px', loose: '36px 36px' },
			grid:     { tight: '24px 24px', normal: '40px 40px', loose: '64px 64px' },
			stripes:  { tight: '8px 8px',   normal: '12px 12px', loose: '20px 20px' },
			diagonal: { tight: '12px 12px', normal: '18px 18px', loose: '28px 28px' }
		};
		var bgImage = '', bgSize = '';
		var bgSizeRaw = (sizeMap[type] && sizeMap[type][density]) || (sizeMap[type] && sizeMap[type].normal) || '';
		if ( type === 'dots' ) {
			bgImage = 'radial-gradient(circle, ' + color + ' 1.5px, transparent 1.5px)'; bgSize = bgSizeRaw;
		} else if ( type === 'grid' ) {
			bgImage = 'linear-gradient(to right, ' + color + ' 1px, transparent 1px), linear-gradient(to bottom, ' + color + ' 1px, transparent 1px)'; bgSize = bgSizeRaw;
		} else if ( type === 'stripes' ) {
			var sw = parseInt(bgSizeRaw,10) || 12;
			bgImage = 'repeating-linear-gradient(45deg, ' + color + ' 0 ' + sw + 'px, transparent ' + sw + 'px ' + (sw*2) + 'px)';
		} else if ( type === 'diagonal' ) {
			var lg = parseInt(bgSizeRaw,10) || 18;
			bgImage = 'repeating-linear-gradient(135deg, transparent 0 ' + lg + 'px, ' + color + ' ' + lg + 'px ' + (lg+1) + 'px)';
		} else if ( type === 'noise' ) {
			bgImage = "url(\"data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='1.5' numOctaves='2' /%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.35'/%3E%3C/svg%3E\")";
		}
		var style = 'background-image:' + bgImage + ';';
		if ( bgSize ) { style += 'background-size:' + bgSize + ';'; }
		style += 'opacity:' + (opacity/100).toFixed(2) + ';mix-blend-mode:' + blend + ';';
		#>
		<div class="cmp-section-pattern cmp-section-pattern--editor-preview">
			<div class="cmp-section-pattern__overlay" style="{{ style }}"></div>
			<small class="cmp-section-pattern__label">ADW — Section Pattern (preview)</small>
		</div>
		<?php
	}
}
