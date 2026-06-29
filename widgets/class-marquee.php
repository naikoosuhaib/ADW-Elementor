<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_Marquee extends \Elementor\Widget_Base {

    public function get_name()       { return 'cmp_marquee'; }
    public function get_title()      { return __( 'ADW — Marquee', 'arenex-digital-widgets' ); }
    public function get_icon()       { return 'eicon-scroll'; }
    public function get_categories() { return [ 'arenex-digital' ]; }
    public function get_style_depends()  { return [ 'adw-styles' ]; }
    public function get_script_depends() { return [ 'adw-front' ]; }

    protected function register_controls() {

        /* ── CONTENT: Items ── */
        $this->start_controls_section( 'section_items', [ 'label' => __( 'Items', 'arenex-digital-widgets' ) ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'text', [
            'label'   => __( 'Text', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Ticker item',
        ] );

        $this->add_control( 'items', [
            'label'   => __( 'Items', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'text' => 'Licensed & Insured' ],
                [ 'text' => 'Free Inspections' ],
                [ 'text' => '5-Star Rated' ],
                [ 'text' => 'Design • Build • Launch' ],
                [ 'text' => 'Locally Owned' ],
                [ 'text' => '24/7 Emergency Service' ],
            ],
            'title_field' => '{{{ text }}}',
        ] );

        $this->end_controls_section();

        /* ── CONTENT: Settings ── */
        $this->start_controls_section( 'section_settings', [ 'label' => __( 'Settings', 'arenex-digital-widgets' ) ] );

        $this->add_control( 'separator', [
            'label'   => __( 'Separator', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'dot',
            'options' => [
                'dot'     => __( 'Dot ●', 'arenex-digital-widgets' ),
                'diamond' => __( 'Diamond ◆', 'arenex-digital-widgets' ),
                'dash'    => __( 'Dash —', 'arenex-digital-widgets' ),
                'pipe'    => __( 'Pipe |', 'arenex-digital-widgets' ),
                'star'    => __( 'Star ★', 'arenex-digital-widgets' ),
                'custom'  => __( 'Custom', 'arenex-digital-widgets' ),
            ],
        ] );
        $this->add_control( 'custom_separator', [
            'label'     => __( 'Custom Separator', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => '•',
            'condition' => [ 'separator' => 'custom' ],
        ] );
        $this->add_control( 'speed', [
            'label'   => __( 'Speed (seconds)', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => 30,
            'min'     => 5,
            'max'     => 120,
        ] );
        $this->add_control( 'pause_on_hover', [
            'label'        => __( 'Pause on Hover', 'arenex-digital-widgets' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'label_on'     => 'Yes',
            'label_off'    => 'No',
            'return_value' => 'yes',
        ] );
        $this->add_control( 'direction', [
            'label'   => __( 'Direction', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'left',
            'options' => [
                'left'  => __( 'Left', 'arenex-digital-widgets' ),
                'right' => __( 'Right', 'arenex-digital-widgets' ),
            ],
        ] );

        $this->end_controls_section();

        /* ── STYLE: Section ── */
        $this->start_controls_section( 'style_section', [
            'label' => __( 'Section', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'ticker_bg', [
            'label'     => __( 'Background Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#cc1010',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY ],
            'selectors' => [ '{{WRAPPER}} .cmp-trust-ticker' => 'background-color: {{VALUE}};' ],
        ] );
        $this->add_responsive_control( 'ticker_padding', [
            'label'      => __( 'Padding', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'default'    => [ 'top' => '16', 'right' => '0', 'bottom' => '16', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [ '{{WRAPPER}} .cmp-trust-ticker' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );
        $this->end_controls_section();

        /* ── STYLE: Text ── */
        $this->start_controls_section( 'style_text', [
            'label' => __( 'Text', 'arenex-digital-widgets' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'item_typo',
            'global'   => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
            'selector' => '{{WRAPPER}} .cmp-trust-ticker__item',
        ] );
        $this->add_control( 'text_color', [
            'label'     => __( 'Text Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
            'selectors' => [ '{{WRAPPER}} .cmp-trust-ticker__item' => 'color: {{VALUE}};' ],
        ] );
        $this->add_control( 'sep_color', [
            'label'     => __( 'Separator Color', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'global'    => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
            'selectors' => [ '{{WRAPPER}} .cmp-trust-ticker__sep' => 'color: {{VALUE}};' ],
        ] );
        $this->add_responsive_control( 'sep_size', [
            'label'      => __( 'Separator Size', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-trust-ticker__sep' => 'font-size: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->add_responsive_control( 'item_gap', [
            'label'      => __( 'Item Gap', 'arenex-digital-widgets' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'selectors'  => [ '{{WRAPPER}} .cmp-trust-ticker__track' => 'gap: {{SIZE}}{{UNIT}};' ],
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s     = $this->get_settings_for_display();
        $items = $s['items'];
        $speed = ! empty( $s['speed'] ) ? intval( $s['speed'] ) : 30;
        $dir   = ( 'right' === $s['direction'] ) ? 'reverse' : 'normal';
        $pause = ( 'yes' === $s['pause_on_hover'] ) ? '1' : '0';

        $sep_map = [
            'dot'     => '●',
            'diamond' => '◆',
            'dash'    => '—',
            'pipe'    => '|',
            'star'    => '★',
            'custom'  => $s['custom_separator'] ?? '•',
        ];
        $sep = $sep_map[ $s['separator'] ] ?? '●';
        ?>
        <div class="cmp-trust-ticker"
             style="--ticker-speed: <?php echo esc_attr( $speed ); ?>s; --ticker-direction: <?php echo esc_attr( $dir ); ?>;"
             data-pause="<?php echo esc_attr( $pause ); ?>">
            <div class="cmp-trust-ticker__track">
                <?php
                // Render items TWICE for seamless infinite loop
                for ( $loop = 0; $loop < 2; $loop++ ) :
                    foreach ( $items as $i => $item ) :
                        if ( $i > 0 || $loop > 0 ) : ?>
                            <span class="cmp-trust-ticker__sep"><?php echo esc_html( $sep ); ?></span>
                        <?php endif; ?>
                        <span class="cmp-trust-ticker__item"><?php echo esc_html( $item['text'] ); ?></span>
                    <?php endforeach;
                endfor; ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}
}
