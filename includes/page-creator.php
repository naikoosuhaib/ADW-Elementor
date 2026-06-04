<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Red Shield Page Creator
 * Creates pre-built Elementor pages for redshieldpropertycare.com
 * Access: WP Admin → Tools → Red Shield Pages
 */

/* ── Register admin menu ── */
add_action( 'admin_menu', function () {
    add_submenu_page(
        'tools.php',
        'Red Shield Page Creator',
        'Red Shield Pages',
        'manage_options',
        'rs-page-creator',
        'cmw_rs_page_creator_ui'
    );
} );

/* ── Helper: generate a unique 7-char Elementor element ID ── */
function cmw_eid( $seed = '' ) {
    return substr( md5( $seed . uniqid( '', true ) ), 0, 7 );
}

/* ── Helper: wrap a single widget in a section > column ── */
function cmw_section( $widget_type, $settings = [], $section_settings = [] ) {
    $s_id = cmw_eid( 's' . $widget_type );
    $c_id = cmw_eid( 'c' . $widget_type );
    $w_id = cmw_eid( 'w' . $widget_type );

    $default_section = [
        'layout'            => 'full_width',
        'content_width'     => [ 'unit' => '%', 'size' => 100 ],
        'padding'           => [ 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ],
    ];

    return [
        'id'       => $s_id,
        'elType'   => 'section',
        'settings' => array_merge( $default_section, $section_settings ),
        'elements' => [
            [
                'id'       => $c_id,
                'elType'   => 'column',
                'settings' => [ '_column_size' => 100, 'padding' => [ 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ] ],
                'elements' => [
                    [
                        'id'         => $w_id,
                        'elType'     => 'widget',
                        'widgetType' => $widget_type,
                        'settings'   => $settings,
                    ],
                ],
            ],
        ],
    ];
}

/* ── Build page JSON arrays ── */

function cmw_rs_services_data() {
    return [
        cmw_section( 'cmp_site_header' ),
        cmw_section( 'cmp_page_hero', [
            'eyebrow'   => 'Our Services',
            'title'     => 'Roofing &amp; Property Care for Helena Homeowners',
            'subtitle'  => 'From annual inspections to emergency repairs, Red Shield provides complete roofing and exterior property services across Helena and the surrounding valley.',
            'show_breadcrumb' => 'yes',
            'breadcrumb_items' => [
                [ 'label' => 'Home', 'url' => '/' ],
                [ 'label' => 'Services', 'url' => '' ],
            ],
        ] ),
        cmw_section( 'cmp_services_section', [
            'theme'       => 'dark',
            'eyebrow'     => 'Roofing Services',
            'heading'     => 'Comprehensive Roof Inspections & Repair',
            'intro_text'  => 'Helena\'s climate demands regular roof attention. We inspect, repair, and maintain residential and commercial roofs across Lewis and Clark County — giving homeowners documentation they can use for insurance and peace of mind.',
            'show_image'  => 'yes',
            'image_position' => 'right',
            'columns'     => '3',
            'cards'       => [
                [ 'title' => 'Annual Roof Inspection', 'description' => 'A complete documented inspection covering all shingles, flashing, gutters, soffits, and penetrations. Perfect for homeowners who want to stay ahead of damage.' ],
                [ 'title' => 'Roof Leak Detection', 'description' => 'We locate the source of any roof leak — no guesswork. Advanced moisture detection and visual inspection to identify exactly where water is entering.' ],
                [ 'title' => 'Shingle Repair & Replacement', 'description' => 'From a handful of missing shingles to widespread wind or hail damage, we repair and replace to restore your roof\'s protection and appearance.' ],
                [ 'title' => 'Flashing Repair', 'description' => 'Damaged or improperly installed flashing is one of the most common causes of roof leaks. We reseal and replace chimney, pipe, and valley flashing.' ],
                [ 'title' => 'Ice Dam Removal', 'description' => 'Heavy snowfall and freeze-thaw cycles create ice dams that force water under your shingles. We safely remove ice dams and prevent future buildup.' ],
                [ 'title' => 'Storm Damage Assessment', 'description' => 'After hail or wind events, we perform a thorough damage assessment with photo documentation — ideal for insurance claims and contractor bids.' ],
            ],
        ] ),
        cmw_section( 'cmp_services_section', [
            'theme'       => 'light',
            'eyebrow'     => 'Preventative Programs',
            'heading'     => 'Maintenance That Extends Roof Life',
            'intro_text'  => 'A well-maintained roof can last 25–30 years in Montana\'s climate. Our seasonal maintenance programs keep your roof performing at its best and catch small issues before they become costly repairs.',
            'show_image'  => 'yes',
            'image_position' => 'left',
            'columns'     => '3',
            'cards'       => [
                [ 'title' => 'Spring Tune-Up', 'description' => 'Post-winter inspection and maintenance covering damage from ice dams, heavy snow loads, and freeze-thaw stress. We clean gutters and reseal exposed fasteners.' ],
                [ 'title' => 'Fall Preparation', 'description' => 'Pre-winter inspection to ensure your roof is sealed, secure, and ready for heavy snow loads. We identify any vulnerabilities before the season hits.' ],
                [ 'title' => 'Gutter Cleaning & Repair', 'description' => 'Clogged gutters back up water onto your roof. We clean, realign, and repair gutters to keep water moving away from your foundation and fascia.' ],
                [ 'title' => 'Moss & Algae Treatment', 'description' => 'Moss and algae hold moisture against your shingles, accelerating deterioration. We treat and prevent biological growth with lasting solutions.' ],
                [ 'title' => 'Insurance Documentation', 'description' => 'Detailed written and photo reports for your insurance carrier. We help you document pre-existing conditions and storm damage accurately.' ],
                [ 'title' => 'Annual Maintenance Plan', 'description' => 'Enroll in our annual maintenance program for priority scheduling, discounted rates, and twice-yearly inspections with full written reports.' ],
            ],
        ] ),
        cmw_section( 'cmp_services_section', [
            'theme'       => 'dark',
            'eyebrow'     => 'Exterior Care',
            'heading'     => 'Full Exterior Property Care',
            'intro_text'  => 'Your roof is only as good as the systems around it. Red Shield provides complete exterior property care — gutters, soffits, fascia, and more — to keep every element of your home\'s envelope working together.',
            'show_image'  => 'yes',
            'image_position' => 'right',
            'columns'     => '3',
            'cards'       => [
                [ 'title' => 'Soffit & Fascia Repair', 'description' => 'Damaged soffits and fascia allow water and pests into your attic. We repair and replace these critical components to protect your roof\'s edge.' ],
                [ 'title' => 'Chimney Flashing & Caulking', 'description' => 'Chimney penetrations are a top source of roof leaks. We reseal and repoint flashing, replace cracked caulk, and ensure a watertight connection.' ],
                [ 'title' => 'Ventilation Assessment', 'description' => 'Poor attic ventilation leads to ice dams in winter and shortened shingle life in summer. We assess and improve your attic ventilation system.' ],
                [ 'title' => 'Roof Coating & Sealant', 'description' => 'Protective coatings extend the life of aging roofs by sealing micro-cracks and reducing UV degradation. Applied in spring or fall for maximum benefit.' ],
                [ 'title' => 'Emergency Tarping', 'description' => 'When severe weather causes sudden roof damage, we provide rapid emergency tarping to prevent interior water damage while permanent repairs are scheduled.' ],
                [ 'title' => 'Exterior Inspection Report', 'description' => 'A full exterior property inspection covering roof, gutters, soffits, fascia, chimney, and visible exterior features — with a written report for your records.' ],
            ],
        ] ),
        cmw_section( 'cmp_faq_accordion', [
            'eyebrow'  => 'Common Questions',
            'heading'  => 'Roofing Questions, Answered',
            'theme'    => 'light',
            'items'    => [
                [ 'question' => 'How often should I have my roof inspected in Helena?', 'answer' => 'We recommend at minimum one inspection per year, ideally in spring after the winter season. Helena\'s freeze-thaw cycles and heavy snow loads create unique stress on roofing systems that benefit from regular professional review.' ],
                [ 'question' => 'What does a roof inspection include?', 'answer' => 'Our standard inspection covers all shingles, flashing, gutters, soffits, fascia, chimney, skylights, and any roof penetrations. You receive a written report with photographs documenting the condition of each component.' ],
                [ 'question' => 'Do you work with insurance companies?', 'answer' => 'Yes. We provide detailed written and photo documentation specifically formatted for insurance claims. We can also meet with your adjuster on-site to walk through our findings.' ],
                [ 'question' => 'How quickly can you respond to an emergency roof repair?', 'answer' => 'For Helena and East Helena, we typically respond same-day for emergency situations. Outlying areas like Clancy and Montana City are usually reached within 24 hours. Call us at (406) 555-1234 for urgent situations.' ],
                [ 'question' => 'What types of roofing materials do you work with?', 'answer' => 'We work with asphalt shingles (the most common roofing material in Helena), metal roofing, modified bitumen flat roofing, and most other residential and light commercial roofing systems.' ],
                [ 'question' => 'How much does a roof repair cost in Helena?', 'answer' => 'Minor repairs typically range from $150 to $500. More involved repairs involving structural damage or full sections of shingles can range from $800 to $2,500. We provide free, no-obligation estimates for all repairs.' ],
            ],
        ] ),
        cmw_section( 'cmp_footer_cta' ),
        cmw_section( 'cmp_site_footer' ),
    ];
}

function cmw_rs_service_area_data() {
    return [
        cmw_section( 'cmp_site_header' ),
        cmw_section( 'cmp_page_hero', [
            'eyebrow'  => 'Service Area',
            'title'    => 'Serving Helena &amp; Surrounding Communities',
            'subtitle' => 'Based in the heart of Helena, Red Shield Property Care delivers fast, reliable roofing and property care across the entire Helena Valley and beyond. Same-day response for most areas.',
            'show_breadcrumb' => 'yes',
            'breadcrumb_items' => [
                [ 'label' => 'Home', 'url' => '/' ],
                [ 'label' => 'Service Area', 'url' => '' ],
            ],
        ] ),
        cmw_section( 'cmp_location_feature', [
            'theme'          => 'light',
            'eyebrow'        => 'Primary Location',
            'heading'        => 'Our Home Base',
            'image_position' => 'right',
            'card_label'     => 'Primary Service Area',
            'card_city'      => 'Helena, Montana',
            'card_desc'      => 'Helena is our main base of operations and where the majority of our clients are located. As lifelong Helena residents, we understand the unique roofing challenges that come with Montana\'s capital city — from heavy snow loads and ice dams to summer hailstorms and high-altitude UV exposure. We provide the fastest response times here, often arriving same-day for inspections and emergency repairs.',
            'card_address'   => 'Helena, MT 59601 — Lewis and Clark County',
        ] ),
        cmw_section( 'cmp_area_cards', [
            'theme'   => 'dark',
            'eyebrow' => 'Surrounding Communities',
            'heading' => 'We Also Serve These Areas',
            'columns' => '4',
            'areas'   => [
                [ 'name' => 'East Helena',  'description' => 'Just minutes from our home base, East Helena receives the same fast response times as Helena proper. Full roofing and property care services available.' ],
                [ 'name' => 'Clancy',       'description' => 'We regularly serve Clancy and the surrounding rural properties along the I-15 corridor south of Helena. Inspections and repairs available with quick scheduling.' ],
                [ 'name' => 'Montana City', 'description' => 'Montana City residents enjoy full coverage for all of our roofing and property maintenance services. A short drive south of Helena with dependable response times.' ],
                [ 'name' => 'Boulder',      'description' => 'Located in Jefferson County, Boulder falls within our extended service area. We schedule regular trips to serve Boulder-area homeowners and property managers.' ],
            ],
        ] ),
        cmw_section( 'cmp_coverage_block', [
            'theme'        => 'light',
            'text_heading' => 'Coverage Across Two Counties',
            'text_body'    => '<p>Red Shield Property Care proudly serves both Lewis and Clark County and Jefferson County. Our coverage area spans from East Helena in the east to the communities along Interstate 15 heading south through Clancy, Montana City, and down to Boulder.</p><p>Response times vary by location. Helena and East Helena typically receive same-day service, while outlying areas like Clancy, Montana City, and Boulder are usually served within 24–48 hours of scheduling.</p><p>Not sure if your property falls within our coverage area? Give us a call at <a href="tel:+14065551234">(406) 555-1234</a> and we will confirm availability for your specific address.</p>',
            'list_heading' => 'Services Available in All Areas',
            'items'        => [
                [ 'item' => 'Comprehensive Roof Inspections' ],
                [ 'item' => 'Roof Leak Detection & Repair' ],
                [ 'item' => 'Preventative Maintenance Programs' ],
                [ 'item' => 'Storm & Hail Damage Assessment' ],
                [ 'item' => 'Insurance Claim Documentation' ],
                [ 'item' => 'Emergency Roof Repairs' ],
                [ 'item' => 'Exterior Property Care' ],
            ],
        ] ),
        cmw_section( 'cmp_content_block', [
            'theme'   => 'dark',
            'eyebrow' => 'Local Expertise',
            'heading' => "Helena's Trusted Local Roofing Specialist",
            'content' => '<p>Helena, Montana, sits at over 4,000 feet of elevation in the Rocky Mountain front range — and that geography creates roofing conditions unlike almost anywhere else in the country. From heavy, wet snowfall that can exceed 40 inches per year to sudden summer hailstorms rolling off the Continental Divide, Helena roofs take a beating. That is exactly why having a local roofing specialist who understands these conditions matters so much.</p><p>Red Shield Property Care was built to serve Helena and the surrounding communities with a level of care and expertise that out-of-town contractors simply cannot match. We know which neighborhoods sit in hail corridors. We understand how ice dams form along the north-facing slopes of the valley. We have seen firsthand how chinook winds can lift shingles overnight. When you work with Red Shield, you are getting 30+ years of local knowledge applied directly to your property.</p><p>Whether you own a historic home in the Lenox neighborhood, a newer build in the Helena Valley, or a commercial property downtown, Red Shield Property Care has the experience to protect your investment. We are proud to be Helena\'s owner-operated roofing company — and we back every job with honest pricing, documented inspections, and a commitment to doing the work right the first time.</p>',
        ] ),
        cmw_section( 'cmp_footer_cta' ),
        cmw_section( 'cmp_site_footer' ),
    ];
}

function cmw_rs_about_data() {
    return [
        cmw_section( 'cmp_site_header' ),
        cmw_section( 'cmp_page_hero', [
            'eyebrow'  => 'About Us',
            'title'    => 'Owner-Operated Roofing. 30+ Years of Local Experience.',
            'subtitle' => 'Red Shield Property Care is Helena\'s trusted owner-operated roofing and property care specialist. No subcontractors. No shortcuts. Just honest work from someone who takes your home as seriously as his own.',
            'show_breadcrumb' => 'yes',
            'breadcrumb_items' => [
                [ 'label' => 'Home', 'url' => '/' ],
                [ 'label' => 'About', 'url' => '' ],
            ],
        ] ),
        cmw_section( 'cmp_owner_section', [
            'theme'         => 'light',
            'eyebrow'       => 'Our Story',
            'heading'       => "Born and Raised in Helena.\nBuilt on Doing the Work Right.",
            'body'          => '<p>I started Red Shield Property Care because I was tired of seeing Helena homeowners get taken advantage of by contractors who didn\'t understand our climate, didn\'t show up when they said they would, and didn\'t stand behind their work. I\'ve been working on roofs in this valley for over 30 years. I know every neighborhood, every common failure point, and exactly how our weather — from chinook winds to summer hail — damages a roof.</p><p>Every job I take, I do myself. That means when you call Red Shield, you\'re getting me — not a subcontractor, not an apprentice crew. I bring 30+ years of hands-on experience to every inspection, every repair, and every estimate. And when the work is done, I put my name on it.</p><p>Red Shield Property Care is licensed, insured, and proud to be a Montana-owned business serving the Helena community I grew up in.</p>',
            'owner_name'    => 'Owner, Red Shield Property Care',
            'years_exp'     => '30+',
            'projects'      => '500+',
            'rating'        => '5.0',
        ] ),
        cmw_section( 'cmp_icon_cards', [
            'theme'   => 'light',
            'eyebrow' => 'Our Values',
            'heading' => 'How We Approach Every Job',
            'columns' => '3',
            'cards'   => [
                [ 'title' => 'Radical Honesty',      'description' => 'We tell you what your roof actually needs — not what generates the most revenue. If a repair will hold, we repair it. If you need a replacement, we\'ll tell you that too.' ],
                [ 'title' => 'Owner on Every Job',   'description' => 'There are no crews, no subcontractors, no hand-offs. The owner of Red Shield performs every inspection and repair personally, ensuring consistent quality.' ],
                [ 'title' => 'Local Knowledge',      'description' => 'We\'ve been working on Helena roofs for 30+ years. We understand the local climate, common failure modes, and what materials perform best in Montana conditions.' ],
                [ 'title' => 'Documentation First',  'description' => 'Every job includes a written inspection report with photographs. You own that documentation — use it for insurance, for records, or for your own peace of mind.' ],
                [ 'title' => 'Fair Pricing',          'description' => 'We price based on what the job requires, not what we think you\'ll pay. Our estimates are detailed, our invoices are clean, and there are no surprise line items.' ],
                [ 'title' => 'Guaranteed Work',       'description' => 'We stand behind every repair we perform. If a repair fails within the warranty period, we come back and make it right — no arguments, no fees.' ],
            ],
        ] ),
        cmw_section( 'cmp_why_us', [
            'theme'   => 'dark',
            'eyebrow' => 'Why Red Shield',
            'heading' => 'What Makes Us Different',
        ] ),
        cmw_section( 'cmp_footer_cta' ),
        cmw_section( 'cmp_site_footer' ),
    ];
}

function cmw_rs_roof_repair_data() {
    return [
        cmw_section( 'cmp_site_header' ),
        cmw_section( 'cmp_dark_hero', [
            'eyebrow'   => 'Roof Repair Helena Montana',
            'title'     => 'Fast, Reliable <span>Roof Repair</span> in Helena, Montana',
            'subtitle'  => 'From minor leaks to major storm damage — we locate the problem, repair it properly, and back our work with a written warranty. Owner-operated with 30+ years of Helena roofing experience.',
            'btn1_text' => 'Get Free Inspection',
            'btn1_url'  => '#footer-form',
            'btn2_text' => 'Call (406) 555-1234',
            'btn2_url'  => 'tel:+14065551234',
        ] ),
        cmw_section( 'cmp_icon_cards', [
            'theme'   => 'light',
            'eyebrow' => 'Common Repairs',
            'heading' => 'Roof Repairs We Handle in Helena',
            'columns' => '3',
            'cards'   => [
                [ 'title' => 'Leak Repair',             'description' => 'We locate the source of any roof leak and repair it properly — not just a patch job. Full diagnosis included with every leak repair.' ],
                [ 'title' => 'Shingle Repair',          'description' => 'Missing, cracked, or curled shingles leave your roof vulnerable. We match and replace damaged shingles to restore full protection.' ],
                [ 'title' => 'Storm Damage Repair',     'description' => 'Hail, wind, and falling branches cause damage that isn\'t always visible from the ground. We assess and repair storm damage with insurance documentation.' ],
                [ 'title' => 'Flashing Repair',         'description' => 'Chimney, pipe, and valley flashing are frequent leak sources. We reseal and replace flashing to stop water intrusion at the source.' ],
                [ 'title' => 'Ice Dam Damage',          'description' => 'Ice dams force water beneath your shingles and into your attic. We repair ice dam damage and address the underlying causes to prevent recurrence.' ],
                [ 'title' => 'Emergency Repairs',       'description' => 'When sudden damage threatens your interior, we respond fast. Emergency tarping and rapid repairs to protect your home while permanent work is scheduled.' ],
            ],
        ] ),
        cmw_section( 'cmp_compare_cards', [
            'theme'       => 'light',
            'eyebrow'     => 'Why It Matters',
            'heading'     => "Small Repairs Today Prevent\nBig Problems Tomorrow",
            'left_label'  => 'The Risk',
            'left_title'  => 'Ignoring Minor Roof Damage',
            'left_body'   => '<p>A small leak or a few missing shingles might seem harmless. But in Helena\'s climate, minor damage escalates fast. Water seeps beneath the surface, freeze-thaw cycles expand cracks, and before long, what was a <strong>simple repair turns into a full roof replacement</strong>.</p><p>Most homeowners don\'t realize the damage is spreading until they see water stains on their ceiling or notice mold in the attic. By that point, the structural damage is already done and the repair costs have multiplied.</p>',
            'right_label' => 'The Smart Move',
            'right_title' => 'Catching Damage Early',
            'right_body'  => '<p>A professional roof repair at the first sign of trouble typically costs between <strong>$150 and $500</strong>. That same problem left unaddressed for a season can escalate to <strong>$5,000 to $15,000</strong> in structural repairs or replacement.</p><p>Red Shield\'s approach is simple: <strong>inspect regularly, repair immediately, and maintain proactively</strong>. Our Helena homeowners save thousands over the life of their roof because we fix small problems while they\'re still small.</p>',
        ] ),
        cmw_section( 'cmp_process_steps', [
            'theme'   => 'dark',
            'eyebrow' => 'Our Process',
            'heading' => 'How a Red Shield Repair Works',
            'steps'   => [
                [ 'number' => '01', 'title' => 'Contact Us',         'description' => 'Call or submit our online form. We\'ll confirm your location and schedule a time that works for you — often same-day or next-day for Helena.' ],
                [ 'number' => '02', 'title' => 'Roof Inspection',    'description' => 'We perform a thorough inspection of your roof, identifying all damage — not just what you reported. You\'ll see exactly what we find, with photographs.' ],
                [ 'number' => '03', 'title' => 'Written Estimate',   'description' => 'You receive a clear, itemized estimate before any work begins. No surprises, no pressure. We walk you through every line item.' ],
                [ 'number' => '04', 'title' => 'Repair Completed',   'description' => 'We perform all repairs ourselves — no subcontractors. Work is done to manufacturer specifications with premium materials built for Montana\'s climate.' ],
                [ 'number' => '05', 'title' => 'Final Walkthrough',  'description' => 'After repairs, we walk the roof with you, review our work, and provide a written completion report. You\'ll know exactly what was done and why.' ],
            ],
        ] ),
        cmw_section( 'cmp_review_grid', [
            'theme'   => 'dark',
            'eyebrow' => 'Customer Reviews',
            'heading' => 'What Helena Homeowners Say',
            'columns' => '3',
        ] ),
        cmw_section( 'cmp_footer_cta' ),
        cmw_section( 'cmp_site_footer' ),
    ];
}

function cmw_rs_roofing_helena_data() {
    return [
        cmw_section( 'cmp_site_header' ),
        cmw_section( 'cmp_dark_hero', [
            'eyebrow'   => 'Roofing Helena MT',
            'title'     => '<span>Roofing Helena MT</span> — Expert Inspections, Repairs & Maintenance',
            'subtitle'  => 'Looking for a reliable roofing contractor in Helena? Red Shield Property Care is Helena\'s trusted owner-operated roofing specialist — 30+ years of experience, no subcontractors, free inspections.',
            'btn1_text' => 'Get Free Inspection',
            'btn1_url'  => '#footer-form',
            'btn2_text' => 'Call (406) 555-1234',
            'btn2_url'  => 'tel:+14065551234',
        ] ),
        cmw_section( 'cmp_location_feature', [
            'theme'          => 'light',
            'eyebrow'        => 'Local Expertise',
            'heading'        => "Helena's Trusted Roofing Specialist",
            'image_position' => 'right',
            'card_label'     => 'Serving Helena Since 1994',
            'card_city'      => 'Helena, Montana',
            'card_desc'      => 'Helena sits at over 4,000 feet on the Rocky Mountain front range. Heavy snow loads, ice dams, freeze-thaw cycles, and summer hailstorms create roofing conditions that demand a specialist who truly understands local conditions.',
            'card_address'   => 'Helena, MT 59601 — Lewis and Clark County',
        ] ),
        cmw_section( 'cmp_icon_cards', [
            'theme'   => 'dark',
            'eyebrow' => 'What We Do',
            'heading' => 'Roofing Services in Helena MT',
            'columns' => '4',
            'cards'   => [
                [ 'title' => 'Roof Inspections',            'description' => 'Comprehensive documented inspections covering all shingles, flashing, gutters, and penetrations. Written reports for insurance and records.' ],
                [ 'title' => 'Roof Repair',                 'description' => 'Leak detection and repair, shingle replacement, flashing repair, ice dam damage, storm damage, and emergency service.' ],
                [ 'title' => 'Preventative Maintenance',    'description' => 'Seasonal maintenance programs to extend your roof\'s life and catch small problems before they become expensive ones.' ],
                [ 'title' => 'Exterior Property Care',      'description' => 'Gutters, soffits, fascia, chimney flashing, and full exterior inspections to protect every part of your home\'s envelope.' ],
            ],
        ] ),
        cmw_section( 'cmp_why_us', [
            'theme'   => 'light',
            'eyebrow' => 'Why Red Shield',
            'heading' => "Helena's Owner-Operated Roofing Company",
        ] ),
        cmw_section( 'cmp_reviews_carousel', [
            'theme'   => 'dark',
            'eyebrow' => 'Reviews',
            'heading' => 'Trusted by Helena Homeowners',
        ] ),
        cmw_section( 'cmp_content_block', [
            'theme'   => 'light',
            'eyebrow' => 'About Our Work in Helena',
            'heading' => 'Why Local Roofing Expertise Matters in Helena MT',
            'content' => '<p>Helena, Montana presents some of the most demanding conditions for residential roofing in the American West. At over 4,000 feet of elevation, the city experiences heavy, wet snowfall exceeding 40 inches annually, sudden temperature swings that create destructive freeze-thaw cycles, and summer hailstorms that can strip shingles in minutes. Add the powerful chinook winds that funnel through the valley and you have a roofing environment that punishes shortcuts and rewards quality craftsmanship.</p><p>Red Shield Property Care has been working on Helena roofs for over 30 years. That means we know which streets sit in hail corridors, how north-facing slopes in the valley trap moisture and accelerate ice dam formation, and exactly how different roofing materials perform under Montana\'s specific conditions. When you hire a national franchise or an out-of-town crew, you get general roofing knowledge. When you hire Red Shield, you get three decades of Helena-specific experience.</p><p>Our service area covers all of Helena, East Helena, and the surrounding communities in Lewis and Clark County and Jefferson County. Whether you\'re in an older home in the Lenox neighborhood, a newer construction in the Helena Valley, or managing a commercial property near downtown, Red Shield has the experience and equipment to protect your investment. Call us today at (406) 555-1234 for your free inspection.</p>',
        ] ),
        cmw_section( 'cmp_footer_cta' ),
        cmw_section( 'cmp_site_footer' ),
    ];
}

/* ── Page definitions ── */
function cmw_rs_pages() {
    return [
        'services' => [
            'label'    => 'Services',
            'slug'     => 'services',
            'title'    => 'Roofing &amp; Property Care Services | Red Shield Property Care Helena MT',
            'seo_desc' => 'Complete roofing and property protection services in Helena MT. Inspections, repairs, preventative maintenance, and exterior care. Owner-operated, 30+ years experience.',
            'data_fn'  => 'cmw_rs_services_data',
        ],
        'service-area' => [
            'label'    => 'Service Area',
            'slug'     => 'service-area',
            'title'    => 'Service Area — Helena MT Roofing | Red Shield Property Care',
            'seo_desc' => 'Red Shield Property Care serves Helena, East Helena, Clancy, Montana City, Boulder & surrounding communities. Fast response across the Helena Valley. Call today.',
            'data_fn'  => 'cmw_rs_service_area_data',
        ],
        'about' => [
            'label'    => 'About',
            'slug'     => 'about',
            'title'    => 'About Red Shield Property Care | Helena MT Roofing Specialist',
            'seo_desc' => 'Learn about Red Shield Property Care LLC — Helena\'s owner-operated roofing and property care specialist with 30+ years of hands-on experience. No subcontractors, no shortcuts.',
            'data_fn'  => 'cmw_rs_about_data',
        ],
        'roof-repair-helena-montana' => [
            'label'    => 'Roof Repair Helena Montana',
            'slug'     => 'roof-repair-helena-montana',
            'title'    => 'Roof Repair Helena Montana | Red Shield Property Care',
            'seo_desc' => 'Fast, reliable roof repair in Helena, Montana. Leak repair, storm damage, flashing, ice dam damage, and emergency service. Owner-operated with 30+ years experience. Call today.',
            'data_fn'  => 'cmw_rs_roof_repair_data',
        ],
        'roofing-helena-mt' => [
            'label'    => 'Roofing Helena MT',
            'slug'     => 'roofing-helena-mt',
            'title'    => 'Roofing Helena MT | Red Shield Property Care',
            'seo_desc' => 'Looking for reliable roofing in Helena MT? Red Shield Property Care offers expert inspections, repairs, and preventative maintenance. Owner-operated, 30+ years experience. Call today.',
            'data_fn'  => 'cmw_rs_roofing_helena_data',
        ],
    ];
}

/* ── Handle form POST ── */
add_action( 'admin_post_rs_create_page', function () {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Unauthorized' );
    }
    check_admin_referer( 'rs_create_page', 'rs_nonce' );

    $page_key = sanitize_text_field( $_POST['page_key'] ?? '' );
    $pages    = cmw_rs_pages();

    if ( ! isset( $pages[ $page_key ] ) ) {
        wp_die( 'Unknown page key.' );
    }

    $def     = $pages[ $page_key ];
    $data_fn = $def['data_fn'];
    $data    = function_exists( $data_fn ) ? $data_fn() : [];

    // Check if page with this slug already exists
    $existing = get_page_by_path( $def['slug'], OBJECT, 'page' );
    $post_id  = $existing ? $existing->ID : 0;

    $post_data = [
        'post_title'   => html_entity_decode( $def['title'], ENT_QUOTES | ENT_HTML5, 'UTF-8' ),
        'post_name'    => $def['slug'],
        'post_status'  => 'publish',
        'post_type'    => 'page',
    ];

    if ( $post_id ) {
        $post_data['ID'] = $post_id;
        wp_update_post( $post_data );
    } else {
        $post_id = wp_insert_post( $post_data );
    }

    if ( is_wp_error( $post_id ) || ! $post_id ) {
        wp_die( 'Failed to create page: ' . ( is_wp_error( $post_id ) ? $post_id->get_error_message() : 'Unknown error' ) );
    }

    // Set Elementor data
    update_post_meta( $post_id, '_elementor_data',          wp_slash( wp_json_encode( $data ) ) );
    update_post_meta( $post_id, '_elementor_edit_mode',     'builder' );
    update_post_meta( $post_id, '_elementor_template_type', 'wp-page' );
    update_post_meta( $post_id, '_elementor_version',       '3.25.0' );

    // Set Yoast SEO meta if Yoast is active
    if ( defined( 'WPSEO_VERSION' ) ) {
        update_post_meta( $post_id, '_yoast_wpseo_title',    $def['title'] );
        update_post_meta( $post_id, '_yoast_wpseo_metadesc', $def['seo_desc'] );
    }

    $action = $existing ? 'updated' : 'created';

    wp_redirect( add_query_arg( [
        'page'    => 'rs-page-creator',
        'action'  => 'success',
        'created' => $page_key,
        'post_id' => $post_id,
        'what'    => $action,
    ], admin_url( 'tools.php' ) ) );
    exit;
} );

/* ── Admin UI ── */
function cmw_rs_page_creator_ui() {
    $pages = cmw_rs_pages();

    // Success message
    $success = '';
    if ( ! empty( $_GET['action'] ) && $_GET['action'] === 'success' ) {
        $key     = sanitize_text_field( $_GET['created'] ?? '' );
        $post_id = absint( $_GET['post_id'] ?? 0 );
        $what    = sanitize_text_field( $_GET['what'] ?? 'created' );
        $label   = $pages[ $key ]['label'] ?? $key;
        $edit    = $post_id ? '<a href="' . admin_url( 'post.php?post=' . $post_id . '&action=elementor' ) . '" target="_blank">Edit in Elementor →</a>' : '';
        $view    = $post_id ? '<a href="' . get_permalink( $post_id ) . '" target="_blank">View Page →</a>' : '';
        $success = '<div class="notice notice-success"><p>✅ <strong>' . esc_html( $label ) . '</strong> page ' . esc_html( $what ) . ' successfully. &nbsp; ' . $edit . ' &nbsp; ' . $view . '</p></div>';
    }

    ?>
    <div class="wrap">
        <h1>🏠 Red Shield Page Creator</h1>
        <p>Click a button to create (or re-build) each page on the live site. Pages are created with full Elementor widget data pre-populated from the HTML prototypes.</p>
        <p><strong>Note:</strong> Re-building an existing page will overwrite its Elementor content. Use the "Edit in Elementor" link after creation to fine-tune.</p>

        <?php echo $success; ?>

        <table class="widefat" style="max-width:800px; margin-top:24px;">
            <thead>
                <tr>
                    <th style="width:180px;">Page</th>
                    <th>Slug</th>
                    <th>Widgets</th>
                    <th style="width:200px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $widget_map = [
                    'services'                  => 'Site Header, Page Hero, 3× Services Section, FAQ, Footer CTA, Footer',
                    'service-area'              => 'Site Header, Page Hero, Location Feature, Area Cards, Coverage Block, Content Block, Footer CTA, Footer',
                    'about'                     => 'Site Header, Page Hero, Owner Section, Icon Cards, Why Us, Footer CTA, Footer',
                    'roof-repair-helena-montana' => 'Site Header, Dark Hero, Icon Cards, Compare Cards, Process Steps, Review Grid, Footer CTA, Footer',
                    'roofing-helena-mt'         => 'Site Header, Dark Hero, Location Feature, Icon Cards, Why Us, Reviews Carousel, Content Block, Footer CTA, Footer',
                ];
                foreach ( $pages as $key => $def ) :
                    $existing = get_page_by_path( $def['slug'], OBJECT, 'page' );
                    $status   = $existing
                        ? '<span style="color:#2a7; font-weight:600;">✓ Exists</span> (ID ' . $existing->ID . ')'
                        : '<span style="color:#888;">Not yet created</span>';
                    ?>
                    <tr>
                        <td><strong><?php echo esc_html( $def['label'] ); ?></strong><br><small><?php echo $status; ?></small></td>
                        <td><code>/<?php echo esc_html( $def['slug'] ); ?></code></td>
                        <td style="font-size:12px; color:#666;"><?php echo esc_html( $widget_map[ $key ] ?? '' ); ?></td>
                        <td>
                            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                                <?php wp_nonce_field( 'rs_create_page', 'rs_nonce' ); ?>
                                <input type="hidden" name="action" value="rs_create_page">
                                <input type="hidden" name="page_key" value="<?php echo esc_attr( $key ); ?>">
                                <button type="submit" class="button button-primary"
                                        onclick="return confirm('<?php echo $existing ? 'This will overwrite the existing Elementor content. Continue?' : 'Create this page?'; ?>')">
                                    <?php echo $existing ? '↺ Rebuild Page' : '+ Create Page'; ?>
                                </button>
                                <?php if ( $existing ) : ?>
                                    &nbsp;
                                    <a href="<?php echo esc_url( admin_url( 'post.php?post=' . $existing->ID . '&action=elementor' ) ); ?>"
                                       class="button" target="_blank">Edit</a>
                                    <a href="<?php echo esc_url( get_permalink( $existing->ID ) ); ?>"
                                       class="button" target="_blank" style="margin-left:4px;">View</a>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="margin-top:32px; padding:16px 20px; background:#f9f9f9; border-left:4px solid #B71C1C; max-width:800px;">
            <strong>After Creating Pages:</strong>
            <ol style="margin:8px 0 0 0; padding-left:20px; line-height:1.8;">
                <li>Open each page in Elementor editor to review content and upload real images</li>
                <li>Replace placeholder phone number <code>(406) 555-1234</code> with the real number in Footer CTA and Site Header widgets</li>
                <li>Set the <strong>Services</strong> page as the services menu link in Site Header widget</li>
                <li>Assign pages to menu in <strong>Appearance → Menus</strong></li>
                <li>Set the <strong>Homepage</strong> under <strong>Settings → Reading</strong> if needed</li>
            </ol>
        </div>
    </div>
    <?php
}
