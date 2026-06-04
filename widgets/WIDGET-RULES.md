# Arenex Digital Widgets — Widget Building Rules

**Last updated:** April 2026
**Plugin version:** v3.8.x
**Purpose:** Mandatory rules every Elementor widget in this plugin MUST follow. Paste this into any new Claude chat when building or evolving widgets.

---

## SESSION RULE 0: Live-Plugin Editing Workflow (MUST FOLLOW EVERY SESSION)

**The plugin is the source of truth — it's reused across every client site, so all fixes go into plugin code, never into one site's Customizer or per-widget Custom CSS.**

### Confirm at start of every iteration session
At the top of any session that involves changes, ask once: **"Do you have hosting / WP admin access to this site? So if anything breaks we can roll back."**
- If yes → proceed with live-plugin edits via **WP Admin → Plugins → Plugin File Editor** (or FTP/cPanel if user provides credentials)
- If no → fall back to workspace edits + final zip upload

### Live edit cycle (the user wants this — do not deviate)
1. **Edit plugin files directly on the live server** via WP Admin → Plugins → Plugin File Editor
   - CSS edits → `arenex-digital-widgets/assets/css/arenex-digital-sections.css`
   - PHP edits → `arenex-digital-widgets/widgets/class-*.php`
   - JS edits → `arenex-digital-widgets/assets/js/arenex-digital-front.js`
2. **MIRROR the same change** into the workspace at `/Users/suhaibahmadnaikoo/Desktop/Claude/Build Plugin/v4.0-work/...` so the eventual zip carries the fix
3. **Hard-refresh the page** to verify the change worked live
4. **Never repackage the plugin zip** during iteration

### NEVER do these
- ❌ Never inject CSS into WP Customizer / Appearance → Additional CSS — that's per-site only and won't carry to other client builds
- ❌ Never write CSS in the Elementor per-widget Custom CSS panel — same problem
- ❌ Never repackage and ask the user to re-upload the zip after each individual change. The user will say "the plugin is for many websites, I cannot upload it 100 times for one tweak"
- ❌ Never make changes only in the workspace and expect the live site to update. The workspace is for accumulation; the live server is what the user actually sees

### Final delivery
- **Only repackage when the user explicitly says** "give me the plugin", "fresh plugin files", "package it", "ship it", or similar
- Repackage from the workspace (which has been kept in sync via mirrored edits) to `/Users/suhaibahmadnaikoo/Desktop/Plugins/Widgets/Arenex Digital v3.x.x.zip` with proper top-level folder `arenex-digital-widgets/`

---

## CORE RULE: A widget is NOT done until ALL of these are present

If a widget is missing any of these when it ships, it is **broken** and must be fixed:

- [ ] Default text content in every text field (no empty defaults)
- [ ] Default colors set on every color control
- [ ] Default typography hooked to Elementor Global Typography
- [ ] Default colors hooked to Elementor Global Colors
- [ ] Spacing controls (outer + inner) with sensible defaults
- [ ] Padding controls on every visual element (responsive)
- [ ] Section padding top/bottom controls (responsive)
- [ ] Max-width control (responsive)
- [ ] Mobile + tablet breakpoints tested
- [ ] Hover states defined (where applicable)
- [ ] Image controls (height, object-fit, object-position) where images exist
- [ ] **NO built-in section heading** — user adds headings separately via Elementor Heading widget
- [ ] All CSS in `arenex-digital-sections.css` (NO inline `<style>` blocks)
- [ ] All JS in `arenex-digital-front.js` `cmpInit()` function
- [ ] Outer wrapper has ZERO hardcoded padding/margin/max-width in CSS file
- [ ] Every SLIDER control has both `unit` AND `size` in its default
- [ ] Widget machine name (`get_name()`) NEVER changes after first ship
- [ ] Default styles use `:where()` selector so user controls win
- [ ] Text inside narrow columns has explicit `text-align: center` (not just inherited)

---

## 1. Plugin Conventions (DO NOT change)

| Item | Value |
|---|---|
| Class prefix | `CMP_` (e.g., `CMP_Hero_Section`) |
| CSS classname prefix | `cmp-` (e.g., `.cmp-hero-section`) |
| Widget category | `arenex-digital` |
| Widget base class | `\Elementor\Widget_Base` |
| Style dependency | `adw-styles` |
| Script dependency | `adw-front` |
| Text domain | `arenex-digital-widgets` |
| Version constant | `ADW_VERSION` (auto-timestamp: `'3.x.x.' . date('YmdHi')`) |
| CSS file | `assets/css/arenex-digital-sections.css` |
| JS file | `assets/js/arenex-digital-front.js` |

---

## 2. Widget File Skeleton (mandatory boilerplate)

Every widget file `widgets/class-widget-name.php` MUST start with this exact pattern:

```php
<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CMP_WidgetName extends \Elementor\Widget_Base {

    public function get_name()       { return 'cmp_widget_name'; }
    public function get_title()      { return __( 'ADW — Widget Name', 'arenex-digital-widgets' ); }
    public function get_icon()       { return 'eicon-icon-name'; }
    public function get_categories() { return [ 'arenex-digital' ]; }
    public function get_style_depends()  { return [ 'adw-styles' ]; }
    public function get_script_depends() { return [ 'adw-front' ]; }

    protected function register_controls() {
        // Content tab
        $this->register_content_section_header();
        $this->register_content_main();
        $this->register_content_layout();

        // Style tab
        $this->register_style_section_header();
        $this->register_style_layout();
        $this->register_style_card();
        $this->register_style_image();
        $this->register_style_typography();
        $this->register_style_animation();
        $this->register_style_spacing();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        // Render HTML using $s
    }

    protected function content_template() {}
}
```

**Register file in main plugin:** `arenex-digital-widgets.php` `$widgets` array
```php
'class-widget-name.php' => 'CMP_WidgetName',
```

---

## 3. CRITICAL: NO Built-In Section Heading

**Widgets MUST NOT include a built-in section heading block** (eyebrow / heading / subheading).

The user adds section headings separately using Elementor's native **Heading widget** (or a dedicated `cmp_section_header` widget if needed). This keeps every other widget focused on ONLY its core content.

### Why this rule exists
- More flexible — user can use any heading style/typography they want
- Widget settings panels stay clean and focused
- User can position the heading anywhere (above, beside, inside its own container)
- No fighting against widget defaults when user wants a custom title style
- Smaller widgets, easier to evolve and maintain

### What this means in practice

❌ **DO NOT** add these inside any widget:
- `eyebrow_text` control
- `heading_text` control
- `subheading_text` control
- `show_section_header` switcher
- `section_header` content section
- `style_section_header` style section
- Any `.cmp-section-header`, `.cmp-eyebrow`, `.cmp-heading`, `.cmp-subheading` markup
- Any `header_alignment`, `header_max_width`, `header_bottom_spacing` controls

✅ **DO** start the widget directly with its core content:
- Timeline → just timeline items
- Services Grid → just service cards
- Testimonials → just testimonial cards
- Hero → just the hero content (title goes inside `cmp_hero` because hero IS a heading widget — the exception)
- Process Steps → just the numbered steps

### Exception
If the widget IS fundamentally a heading-display widget (e.g. `cmp_hero`, `cmp_page_banner`, `cmp_dark_hero`), then heading text is part of its core content — that's fine. The rule only forbids "section heading on TOP of a content widget" — i.e. a content widget like Services Grid should not have its own title control.

### If you need a reusable section-header pattern
Build ONE dedicated widget called `cmp_section_header` with eyebrow / heading / subheading / alignment / typography controls. Use it as a separate widget above any content widget.

---

## 4. MANDATORY Control: Layout Section

```php
$this->start_controls_section( 'style_layout', [
    'label' => __( 'Layout', 'arenex-digital-widgets' ),
    'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
] );

// Layout style (if widget has variants)
$this->add_control( 'layout_style', [
    'label'   => __( 'Layout Style', 'arenex-digital-widgets' ),
    'type'    => \Elementor\Controls_Manager::SELECT,
    'default' => 'grid',
    'options' => [
        'grid'       => __( 'Grid', 'arenex-digital-widgets' ),
        'list'       => __( 'List', 'arenex-digital-widgets' ),
        'carousel'   => __( 'Carousel', 'arenex-digital-widgets' ),
        // add as needed
    ],
] );

// Max width (responsive)
$this->add_responsive_control( 'max_width', [
    'label'      => __( 'Max Width', 'arenex-digital-widgets' ),
    'type'       => \Elementor\Controls_Manager::SLIDER,
    'size_units' => [ 'px', '%' ],
    'range'      => [ 'px' => [ 'min' => 300, 'max' => 1600 ] ],
    'default'    => [ 'size' => 1200, 'unit' => 'px' ],
    'selectors'  => [ '{{WRAPPER}} .cmp-widget-inner' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;' ],
] );

// Columns (responsive)
$this->add_responsive_control( 'columns', [
    'label'           => __( 'Columns', 'arenex-digital-widgets' ),
    'type'            => \Elementor\Controls_Manager::SELECT,
    'default'         => '4',
    'tablet_default'  => '2',
    'mobile_default'  => '1',
    'options'         => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6' ],
    'selectors'       => [ '{{WRAPPER}} .cmp-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ],
] );

// Gap (responsive)
$this->add_responsive_control( 'gap', [
    'label'      => __( 'Gap', 'arenex-digital-widgets' ),
    'type'       => \Elementor\Controls_Manager::SLIDER,
    'size_units' => [ 'px' ],
    'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
    'default'    => [ 'size' => 24, 'unit' => 'px' ],
    'selectors'  => [ '{{WRAPPER}} .cmp-grid' => 'gap: {{SIZE}}{{UNIT}};' ],
] );

// Section padding top/bottom (responsive)
$this->add_responsive_control( 'section_padding', [
    'label'      => __( 'Section Padding', 'arenex-digital-widgets' ),
    'type'       => \Elementor\Controls_Manager::DIMENSIONS,
    'size_units' => [ 'px', 'em', '%' ],
    'default'    => [ 'top' => '80', 'right' => '0', 'bottom' => '80', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
    'selectors'  => [ '{{WRAPPER}} .cmp-widget-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
] );

$this->end_controls_section();
```

---

## 5. MANDATORY Control: Card / Item Styling (if widget has cards)

```php
$this->start_controls_section( 'style_card', [
    'label' => __( 'Cards', 'arenex-digital-widgets' ),
    'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
] );

// Background
$this->add_group_control( \Elementor\Group_Control_Background::get_type(), [
    'name'     => 'card_background',
    'types'    => [ 'classic', 'gradient' ],
    'selector' => '{{WRAPPER}} .cmp-card',
    'fields_options' => [
        'background' => [ 'default' => 'classic' ],
        'color'      => [ 'default' => '#FFFFFF' ],
    ],
] );

// Border
$this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
    'name'     => 'card_border',
    'selector' => '{{WRAPPER}} .cmp-card',
] );

// Border radius
$this->add_responsive_control( 'card_border_radius', [
    'label'      => __( 'Border Radius', 'arenex-digital-widgets' ),
    'type'       => \Elementor\Controls_Manager::DIMENSIONS,
    'size_units' => [ 'px', '%' ],
    'default'    => [ 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px', 'isLinked' => true ],
    'selectors'  => [ '{{WRAPPER}} .cmp-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
] );

// Box shadow
$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
    'name'     => 'card_box_shadow',
    'selector' => '{{WRAPPER}} .cmp-card',
] );

// Padding
$this->add_responsive_control( 'card_padding', [
    'label'      => __( 'Padding', 'arenex-digital-widgets' ),
    'type'       => \Elementor\Controls_Manager::DIMENSIONS,
    'size_units' => [ 'px', 'em', '%' ],
    'default'    => [ 'top' => '32', 'right' => '32', 'bottom' => '32', 'left' => '32', 'unit' => 'px', 'isLinked' => true ],
    'selectors'  => [ '{{WRAPPER}} .cmp-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
] );

// HOVER STATE — use tabs for normal/hover
$this->start_controls_tabs( 'card_state_tabs' );

    $this->start_controls_tab( 'card_normal_tab', [ 'label' => __( 'Normal', 'arenex-digital-widgets' ) ] );
    // Normal-state extras can go here
    $this->end_controls_tab();

    $this->start_controls_tab( 'card_hover_tab', [ 'label' => __( 'Hover', 'arenex-digital-widgets' ) ] );

        $this->add_control( 'card_hover_bg', [
            'label'     => __( 'Background', 'arenex-digital-widgets' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .cmp-card:hover' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'card_hover_transform', [
            'label'   => __( 'Lift on Hover (px)', 'arenex-digital-widgets' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 0,
            'max'     => 20,
            'default' => 4,
            'selectors' => [ '{{WRAPPER}} .cmp-card' => 'transition: transform 0.3s ease;' ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_hover_shadow',
            'selector' => '{{WRAPPER}} .cmp-card:hover',
        ] );

    $this->end_controls_tab();

$this->end_controls_tabs();

$this->end_controls_section();
```

---

## 6. MANDATORY Control: Image Section (if widget has images)

```php
$this->start_controls_section( 'style_image', [
    'label' => __( 'Image', 'arenex-digital-widgets' ),
    'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
] );

$this->add_responsive_control( 'image_height', [
    'label'      => __( 'Image Height', 'arenex-digital-widgets' ),
    'type'       => \Elementor\Controls_Manager::SLIDER,
    'size_units' => [ 'px', 'vh', '%' ],
    'range'      => [ 'px' => [ 'min' => 100, 'max' => 800 ], 'vh' => [ 'min' => 20, 'max' => 100 ] ],
    'default'    => [ 'size' => 240, 'unit' => 'px' ],
    'selectors'  => [ '{{WRAPPER}} .cmp-card-image' => 'height: {{SIZE}}{{UNIT}};' ],
] );

$this->add_control( 'image_object_fit', [
    'label'   => __( 'Object Fit', 'arenex-digital-widgets' ),
    'type'    => \Elementor\Controls_Manager::SELECT,
    'default' => 'cover',
    'options' => [
        'cover'      => __( 'Cover', 'arenex-digital-widgets' ),
        'contain'    => __( 'Contain', 'arenex-digital-widgets' ),
        'fill'       => __( 'Fill', 'arenex-digital-widgets' ),
        'none'       => __( 'None', 'arenex-digital-widgets' ),
        'scale-down' => __( 'Scale Down', 'arenex-digital-widgets' ),
    ],
    'selectors' => [ '{{WRAPPER}} .cmp-card-image img' => 'object-fit: {{VALUE}};' ],
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
        'top left'      => __( 'Top Left', 'arenex-digital-widgets' ),
        'top right'     => __( 'Top Right', 'arenex-digital-widgets' ),
        'bottom left'   => __( 'Bottom Left', 'arenex-digital-widgets' ),
        'bottom right'  => __( 'Bottom Right', 'arenex-digital-widgets' ),
    ],
    'selectors' => [ '{{WRAPPER}} .cmp-card-image img' => 'object-position: {{VALUE}};' ],
] );

$this->add_responsive_control( 'image_border_radius', [
    'label'      => __( 'Border Radius', 'arenex-digital-widgets' ),
    'type'       => \Elementor\Controls_Manager::DIMENSIONS,
    'size_units' => [ 'px', '%' ],
    'selectors'  => [ '{{WRAPPER}} .cmp-card-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
] );

// For split layouts: image position SELECT
$this->add_control( 'image_position', [
    'label'   => __( 'Image Position', 'arenex-digital-widgets' ),
    'type'    => \Elementor\Controls_Manager::SELECT,
    'default' => 'left',
    'options' => [
        'left'  => __( 'Left', 'arenex-digital-widgets' ),
        'right' => __( 'Right', 'arenex-digital-widgets' ),
        'top'   => __( 'Top', 'arenex-digital-widgets' ),
    ],
    'condition' => [ 'layout_style' => 'split' ], // optional
] );

$this->end_controls_section();
```

---

## 7. MANDATORY Default Values (NEVER ship empty defaults)

### Text fields
```php
'default' => __( 'Lorem ipsum dolor sit amet', 'arenex-digital-widgets' ),
```

### Textareas
```php
'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque euismod neque a felis pretium aliquam.', 'arenex-digital-widgets' ),
```

### Repeater defaults — populate at LEAST 3-4 items
```php
'default' => [
    [ 'title' => 'Feature One',   'description' => 'Short feature description here.', 'icon' => [ 'value' => 'fas fa-check', 'library' => 'fa-solid' ] ],
    [ 'title' => 'Feature Two',   'description' => 'Short feature description here.', 'icon' => [ 'value' => 'fas fa-star',  'library' => 'fa-solid' ] ],
    [ 'title' => 'Feature Three', 'description' => 'Short feature description here.', 'icon' => [ 'value' => 'fas fa-bolt',  'library' => 'fa-solid' ] ],
    [ 'title' => 'Feature Four',  'description' => 'Short feature description here.', 'icon' => [ 'value' => 'fas fa-heart', 'library' => 'fa-solid' ] ],
],
```

### Image fields — use Elementor's placeholder
```php
'default' => [
    'url' => \Elementor\Utils::get_placeholder_image_src(),
],
```

### Color controls — ALWAYS hook to global
```php
'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
// Options:
// COLOR_PRIMARY, COLOR_SECONDARY, COLOR_TEXT, COLOR_ACCENT
```

### Typography controls — ALWAYS hook to global
```php
'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ],
// Options:
// TYPOGRAPHY_PRIMARY, TYPOGRAPHY_SECONDARY, TYPOGRAPHY_TEXT, TYPOGRAPHY_ACCENT
```

---

## 8. MANDATORY Spacing Rules

**Outer container (the widget wrapper):**
- ZERO padding by default
- ZERO margin by default
- ZERO max-width by default (unless explicitly set via control)
- Elementor's container handles outer spacing

**Inner items (cards, list items, etc.):**
- CAN have padding
- MUST have a control to edit padding (responsive DIMENSIONS)
- Default padding: 24-32px on cards, 16-20px on list items

**Section padding (top/bottom):**
- Default: 80px top, 80px bottom (responsive)
- Tablet: 60px / 60px
- Mobile: 40px / 40px

**Inline spacing examples:**

```php
// CORRECT:
'default' => [ 'top' => '80', 'right' => '0', 'bottom' => '80', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],

// WRONG (outer left/right padding — Elementor handles this):
'default' => [ 'top' => '80', 'right' => '40', 'bottom' => '80', 'left' => '40', 'unit' => 'px' ],
```

---

## 9. MANDATORY Responsive Rules

EVERY visual control uses `add_responsive_control` (not `add_control`):

```php
// WRONG — only sets desktop value
$this->add_control( 'gap', [ 'type' => SLIDER, 'default' => [ 'size' => 24 ] ] );

// CORRECT — desktop + tablet + mobile
$this->add_responsive_control( 'gap', [
    'type'           => SLIDER,
    'default'        => [ 'size' => 24 ],
    'tablet_default' => [ 'size' => 16 ],
    'mobile_default' => [ 'size' => 12 ],
] );
```

**Mandatory responsive defaults:**
- Columns: desktop 4 / tablet 2 / mobile 1
- Section padding: desktop 80px / tablet 60px / mobile 40px
- Gap: desktop 24px / tablet 16px / mobile 12px
- Heading typography: desktop 48px / tablet 36px / mobile 28px

---

## 10. MANDATORY Animation Section

```php
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
```

In render(), apply via classes:
```php
<div class="cmp-card cmp-reveal cmp-reveal-delay-<?php echo esc_attr( $i + 1 ); ?> cmp-hover-<?php echo esc_attr( $s['hover_effect'] ); ?>">
```

---

## 11. CSS Rules

### File location
ALL CSS goes in: `assets/css/arenex-digital-sections.css`

**FORBIDDEN:** inline `<style>` blocks inside widget render() — move them to the external CSS file.

### Block format
Each widget gets its own CSS block, delimited:
```css
/* ══════════════════════════════════════════════
   WIDGET NAME — cmp-widget-name
   ══════════════════════════════════════════════ */
.cmp-widget-name { ... }
.cmp-widget-name .cmp-card { ... }
@media (max-width: 1024px) { ... }
@media (max-width: 767px) { ... }
```

### Outer container = ZERO
```css
/* CORRECT */
.cmp-widget-name {
    width: 100%;
    /* NO padding, NO margin, NO max-width here */
}

/* CORRECT — inner item gets max-width */
.cmp-widget-name .cmp-widget-inner {
    max-width: 1200px;
    margin: 0 auto;
}
```

### Responsive breakpoints
- Desktop: default
- Tablet: `@media (max-width: 1024px)`
- Mobile: `@media (max-width: 767px)`

### Hover transitions
Always include transitions:
```css
.cmp-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
}
.cmp-card:hover {
    transform: translateY(-4px);
}
```

---

## 12. JavaScript Rules

### File location
ALL JS goes in: `assets/js/arenex-digital-front.js`

### Pattern
```js
(function($) {
    'use strict';

    function initWidgetName(scope) {
        // your widget init code
        // scope = either document or a specific widget element
        const widgets = $(scope).find('.cmp-widget-name');
        widgets.each(function() {
            // init logic per instance
        });
    }

    function cmpInit(scope) {
        scope = scope || document;
        // ... existing inits ...
        initWidgetName(scope);
    }

    // Run on Elementor frontend init + on full DOM ready
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/cmp_widget_name.default',
            function($element) { cmpInit($element[0]); }
        );
    });

    $(document).ready(function() { cmpInit(document); });

})(jQuery);
```

---

## 13. Render Pattern

```php
protected function render() {
    $s   = $this->get_settings_for_display();
    $uid = $this->get_id();
    ?>
    <div class="cmp-widget-name cmp-layout-<?php echo esc_attr( $s['layout_style'] ); ?>">
        <div class="cmp-widget-inner">

            <?php /* NO section header inside the widget — user adds Elementor Heading widget separately above this widget. */ ?>

            <div class="cmp-grid">
                <?php foreach ( $s['items'] as $i => $item ) : ?>
                <div class="cmp-card cmp-reveal cmp-reveal-delay-<?php echo esc_attr( ( $i % 4 ) + 1 ); ?>">
                    <?php if ( ! empty( $item['image']['url'] ) ) : ?>
                    <div class="cmp-card-image">
                        <img src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" loading="lazy">
                    </div>
                    <?php endif; ?>

                    <div class="cmp-card-body">
                        <?php if ( ! empty( $item['icon']['value'] ) ) : ?>
                            <div class="cmp-card-icon"><?php \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
                        <?php endif; ?>
                        <h3 class="cmp-card-title"><?php echo esc_html( $item['title'] ); ?></h3>
                        <p class="cmp-card-desc"><?php echo esc_html( $item['description'] ); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
    <?php
}
```

---

## 14. STRICT Pre-Ship Checklist (each item is a HARD PASS/FAIL gate)

Before marking a widget as DONE, **run the verification script in Section 21**. The widget MUST pass every check below. No exceptions.

### Content
- [ ] All text fields have meaningful default text (not empty, not "Step 1", not single word)
- [ ] Repeater has 3-4 default items populated (not 1, not 0)
- [ ] All image fields use `\Elementor\Utils::get_placeholder_image_src()` as default
- [ ] **NO section header controls** (`eyebrow_text`, `heading_text`, `subheading_text`, `show_section_header`) — they are FORBIDDEN unless the widget IS a heading widget itself

### Style — Defaults (every single control)
- [ ] Every COLOR control has a literal default `#hex` AND `'global' => [ 'default' => Global_Colors::... ]`
- [ ] Every TYPOGRAPHY group has `'global' => [ 'default' => Global_Typography::... ]`
- [ ] Every SLIDER has BOTH `'unit'` AND `'size'` in default — `[ 'size' => N, 'unit' => 'px' ]`
- [ ] Every DIMENSIONS has full `top/right/bottom/left/unit/isLinked` keys in default
- [ ] Every padding control has a default value (responsive)
- [ ] Every margin control has a default value (responsive)

### Style — Required sections
- [ ] Layout style block (max-width, columns, gap, section padding)
- [ ] Card/Item style block (bg, border, radius, shadow, padding, hover tabs)
- [ ] Image style block (height, object-fit, object-position) — if images
- [ ] Typography style blocks (title + description, with global hooks)
- [ ] Animation style block (entrance + hover effect)

### Responsive
- [ ] EVERY visual control uses `add_responsive_control` (not `add_control`)
- [ ] Tablet defaults set for columns, gap, padding, typography
- [ ] Mobile defaults set for columns, gap, padding, typography
- [ ] Tested in browser at 1024px and 767px widths

### Code quality (HARD checks)
- [ ] Widget extends `\Elementor\Widget_Base`
- [ ] `get_style_depends()` returns `[ 'adw-styles' ]`
- [ ] `get_script_depends()` returns `[ 'adw-front' ]`
- [ ] `get_categories()` returns `[ 'arenex-digital' ]`
- [ ] All CSS in `arenex-digital-sections.css`, ZERO inline `<style>` blocks in widget render()
- [ ] All JS in `arenex-digital-front.js`, called from `cmpInit()`
- [ ] **CSS file has ZERO `padding:` rules on outer wrapper selectors** (any `.cmp-widget-name { ... padding: ... }` is a FAIL)
- [ ] Outer wrapper has ZERO hardcoded margin/max-width/padding
- [ ] Inner container has the max-width control applied
- [ ] Default-style CSS uses `:where(.cmp-x)` so user controls override (see Section 22)
- [ ] All paragraph text inside narrow columns has explicit `text-align: center`, not just inherited
- [ ] All output text uses `esc_html()` or `esc_attr()` or `esc_url()`
- [ ] Icons use `\Elementor\Icons_Manager::render_icon()`
- [ ] Widget `get_name()` value matches existing released name (NEVER changed once shipped)

### Registration
- [ ] Added to main file `arenex-digital-widgets.php` `$widgets` array
- [ ] Plugin version bumped if shipping fix

---

## 15. Anti-patterns (DO NOT DO — each is an automatic FAIL)

### Content / structure
❌ **Built-in section header inside a content widget**
```php
// WRONG — never inside cmp_services_grid, cmp_timeline, cmp_testimonials_grid, etc.
$this->add_control( 'heading_text', [ ... ] );
$this->add_control( 'eyebrow_text', [ ... ] );
```
✅ User adds heading separately via Elementor's Heading widget.

❌ **Empty default text fields** — every text field needs default content
❌ **Repeater with only 1 default item** — minimum 3-4 items
❌ **Missing translation domain** — all `__()` calls must use `'arenex-digital-widgets'`

### CSS / outer wrapper (THE BIG ONE — most common violation)
❌ **Hardcoded padding on outer widget wrapper in CSS file**
```css
/* WRONG — caught on hotpink-penguin test site */
.cmp-hero-section {
    padding: 100px 40px;  /* ← FAIL: outer wrapper must have ZERO padding */
}
```
✅ Section padding goes through a `DIMENSIONS` CONTROL (responsive), not in CSS.
✅ Left/right padding stays at ZERO — Elementor's container handles horizontal spacing.

❌ **Hardcoded `margin` or `max-width` on outer wrapper in CSS file**
```css
/* WRONG */
.cmp-widget-name { max-width: 1200px; margin: 0 auto; }
```
✅ Apply `max-width` to `.cmp-widget-inner` (the inner element) via a control.

❌ **CSS default styles at FULL specificity that beat user controls**
```css
/* WRONG — this beats Elementor user controls */
.cmp-card-title { font-size: 24px; }
```
✅ Wrap defaults in `:where()` (zero specificity, user always wins):
```css
:where(.cmp-card-title) { font-size: 24px; }
```

### PHP control patterns
❌ **Inline `<style>` blocks inside render()** — move to `arenex-digital-sections.css`
❌ **Hard-coded colors without `global` hook** — always use Global Colors via `'global' => [ 'default' => ... ]`
❌ **`add_control` for visual properties** — use `add_responsive_control` for ANY style with breakpoints
❌ **SLIDER default missing `size`**
```php
// WRONG — outputs invalid CSS like `max-width: px;`
'default' => [ 'unit' => 'px' ],
```
```php
// CORRECT
'default' => [ 'size' => 1200, 'unit' => 'px' ],
```

❌ **Missing hover state** — every card needs at least transform/shadow on hover
❌ **No image controls** — height/object-fit/object-position are mandatory if widget has images
❌ **Unique CSS classes that break naming** — always `cmp-widget-name-element`
❌ **Custom JS not in `cmpInit()`** — must be hookable for Elementor reload

### Stability / breaking changes
❌ **Changing widget machine name (`get_name()`) after first release**
```php
// WRONG — was 'cmp_services_grid' in v3.8, changing to 'cmp_services' in v3.9
// Breaks every page that used the old widget. Saved page data orphans.
```
✅ Once a `get_name()` value ships in any released version, it is FROZEN. Change `get_title()` freely (display label only). Never change `get_name()`.

### Text alignment
❌ **Relying on text-align inheritance for paragraphs in narrow columns**
```css
/* WRONG — paragraph inherits text-align:center from parent, but each line ends up
   visually similar width and looks left-aligned */
.cmp-process-step { text-align: center; }
.cmp-process-step p { /* no text-align */ }
```
✅ Set `text-align: center` explicitly on the paragraph too:
```css
.cmp-process-step { text-align: center; }
.cmp-process-step p { text-align: center; }
```

---

## 16. Quick reference — Common controls

| Need | Use |
|---|---|
| Text input | `Controls_Manager::TEXT` |
| Multi-line text | `Controls_Manager::TEXTAREA` |
| Rich text | `Controls_Manager::WYSIWYG` |
| Number | `Controls_Manager::NUMBER` |
| Slider (px, %, em) | `Controls_Manager::SLIDER` |
| Color | `Controls_Manager::COLOR` (+ `global`) |
| Image | `Controls_Manager::MEDIA` |
| Icon | `Controls_Manager::ICONS` |
| Dropdown | `Controls_Manager::SELECT` |
| Toggle | `Controls_Manager::SWITCHER` (+ `return_value => 'yes'`) |
| Alignment | `Controls_Manager::CHOOSE` |
| Padding/margin | `Controls_Manager::DIMENSIONS` |
| Repeater | `new \Elementor\Repeater()` |
| Typography group | `Group_Control_Typography::get_type()` |
| Background group | `Group_Control_Background::get_type()` |
| Border group | `Group_Control_Border::get_type()` |
| Box shadow group | `Group_Control_Box_Shadow::get_type()` |
| Text shadow group | `Group_Control_Text_Shadow::get_type()` |
| CSS filter group | `Group_Control_Css_Filter::get_type()` |

---

## 17. Conditional control visibility

Show a control only when another is set:
```php
'condition' => [ 'show_section_header' => 'yes' ],
'condition' => [ 'layout_style' => 'carousel' ],
'condition' => [ 'show_button' => 'yes', 'button_style' => 'outline' ], // multiple = AND
```

---

## 18. Selectors pattern

Always scope to `{{WRAPPER}}` (the widget instance):
```php
'selectors' => [ '{{WRAPPER}} .cmp-card' => 'background-color: {{VALUE}};' ],
'selectors' => [ '{{WRAPPER}} .cmp-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
'selectors' => [ '{{WRAPPER}} .cmp-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ],
```

---

## 19. Translation strings

Every user-facing string MUST use the translation function:
```php
__( 'My Label', 'arenex-digital-widgets' )
```
Never raw strings.

---

## 20. Final mantra

> **Every widget must be production-ready out of the box. The user should be able to drag it onto a page and see something complete and styled — not an empty skeleton needing 30 minutes of setup.**

If a widget needs the user to manually set 10 things before it looks right, the defaults are wrong. Fix the defaults.

---

## 21. AUTOMATED VERIFICATION SCRIPT (run before saying "done")

When building or evolving a widget, run these grep commands automatically. **Each one must return ZERO results** — any non-zero result means the widget FAILS the check and must be fixed before shipping.

Replace `WIDGET_FILE` with the actual path (e.g. `widgets/class-services-grid.php`) and `WIDGET_CSS_BLOCK` with the widget's CSS section in `arenex-digital-sections.css`.

```bash
# === PHP CHECKS ===

# 1. FAIL: Inline <style> block inside render()
grep -nE '<style' "$WIDGET_FILE"

# 2. FAIL: Forbidden section header controls (unless widget IS a heading widget)
grep -nE "heading_text|eyebrow_text|subheading_text|show_section_header" "$WIDGET_FILE"

# 3. FAIL: SLIDER default with unit but no size
grep -nE "'default'\s*=>\s*\[\s*'unit'\s*=>" "$WIDGET_FILE"

# 4. FAIL: add_control used for visual property (must be add_responsive_control)
grep -nE "add_control\(\s*'[a-z_]*(padding|margin|gap|width|height|spacing|columns)" "$WIDGET_FILE"

# 5. FAIL: Color control without 'global' default
grep -B1 -A6 "Controls_Manager::COLOR" "$WIDGET_FILE" | grep -B5 "selectors" | grep -L "Global_Colors::"

# 6. FAIL: Typography group without 'global' default
grep -B1 -A4 "Group_Control_Typography" "$WIDGET_FILE" | grep -L "Global_Typography::"

# 7. FAIL: Empty default text
grep -nE "'default'\s*=>\s*''" "$WIDGET_FILE"

# 8. FAIL: Translation missing or wrong domain
grep -nE "__\(\s*'[^']+'\s*\)" "$WIDGET_FILE"
grep -cE "'arenex-digital-widgets'" "$WIDGET_FILE"

# 9. FAIL: get_style_depends/get_script_depends not using 'adw-styles'/'adw-front'
grep -E "get_style_depends|get_script_depends" "$WIDGET_FILE"

# 10. FAIL: Missing escaping in render output
grep -nE "echo\s+\\\$" "$WIDGET_FILE"

# === CSS CHECKS (run on the widget's CSS block) ===

# 11. FAIL: Outer wrapper has hardcoded padding/margin/max-width
grep -nE "^\.cmp-[a-z][a-z0-9-]+\s*\{[^}]*(padding|margin|max-width)" "$CSS_FILE"

# 12. FAIL: Default styles at full specificity (should use :where())
# Manually inspect — defaults like font-size/color on basic selectors should be in :where()

# 13. FAIL: Paragraph in centered column missing explicit text-align
# Manually check — every .cmp-*-step p, .cmp-card-desc inside text-align:center parent
# must have its own text-align: center
```

### Quick "is this widget done?" one-liner

Run this single shell line on a widget file. If it prints anything other than `OK`, fix it:

```bash
WIDGET_FILE="widgets/class-services-grid.php"; \
ISSUES=""; \
grep -q '<style' "$WIDGET_FILE" && ISSUES="$ISSUES inline-style"; \
grep -qE "heading_text|eyebrow_text|subheading_text" "$WIDGET_FILE" && ISSUES="$ISSUES forbidden-section-header"; \
grep -qE "'default'\s*=>\s*\[\s*'unit'\s*=>\s*'[a-z]+'\s*\]" "$WIDGET_FILE" && ISSUES="$ISSUES slider-no-size"; \
grep -qE "'default'\s*=>\s*''" "$WIDGET_FILE" && ISSUES="$ISSUES empty-default"; \
[ -z "$ISSUES" ] && echo "OK" || echo "FAIL:$ISSUES"
```

---

## 22. CSS specificity rule (`:where()`)

When writing widget CSS, **separate "layout-critical" rules from "default styling"**:

- **Layout-critical** = rules required for the widget to function (flex, grid, position). Use full specificity.
- **Defaults** = aesthetic values (colors, fonts, sizes) that user style controls SHOULD be able to override. Wrap in `:where()` for zero specificity.

```css
/* Layout-critical — full specificity (user can't break the layout) */
.cmp-services-grid { display: grid; gap: 24px; }
.cmp-services-grid .cmp-card { display: flex; flex-direction: column; }

/* Defaults — :where() = zero specificity (any user control wins) */
:where(.cmp-services-grid .cmp-card-title) { font-size: 20px; font-weight: 600; }
:where(.cmp-services-grid .cmp-card-desc) { font-size: 14px; line-height: 1.6; }
```

Why this matters: when a user adjusts the Title typography in Elementor's Style tab, Elementor outputs CSS selectors like `.elementor-element-XYZ .cmp-card-title { font-size: 24px; }`. If your default `.cmp-card-title { font-size: 20px; }` has the same specificity, the user's change might not win because of source order. `:where()` solves this — your defaults always lose to user controls.

---

## 23. Stop wasting time on the same checks

These are the issues that have come up repeatedly across sessions. The verification script in Section 21 catches all of them automatically. **Run the script. Don't ask the user to verify these manually.**

| Repeated issue | Auto-detected by | First seen |
|---|---|---|
| Outer wrapper hardcoded padding | Section 21 check #11 | hotpink-penguin test site v3.9.0 |
| Inline `<style>` blocks | Section 21 check #1 | class-process-steps.php |
| Empty section header (now forbidden) | Section 21 check #2 | ADW Timeline widget on test site |
| SLIDER default missing `size` | Section 21 check #3 | desc_max_width control |
| Color control without `global` hook | Section 21 check #5 | many widgets |
| Text-align inheritance (paragraphs) | Manual check (Section 15 anti-pattern) | Atlantic process steps |

When asked "is this widget done?", run Section 21 verification first. Only then say done.

---

**End of rules.** Save this file and reference it in every chat where new widgets are being built or existing widgets are being evolved.
