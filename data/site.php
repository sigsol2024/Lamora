<?php
/*
 * The Lamora master brand.
 *
 * Sources: The Lamora Lagos Brand Guidelines 2026, TLL Guest-Facing Brand Application
 * Standards, TLL Spec Sheet and TLL Fact Sheet 2026 Rev1 (via the Consolidated Content
 * Guide). Wording that referred to one city in the source documents has been made
 * location-neutral here and is marked 'draft' for Lamora's approval.
 */

return [
    'brand'  => 'The Lamora',
    'domain' => 'thelamora.com',

    'meta_description' => 'The Lamora: private, design-led luxury serviced apartments with hotel service, in Lagos and, soon, Abuja.',

    'contact' => [
        'info'         => 'info@thelamora.com',
        'reservations' => 'reservations@thelamora.com',
    ],

    /*
     * Campaign copy. NONE of these lines is an approved tagline. The guidelines state
     * that no official external tagline has been supplied; until Lamora approves a
     * line, templates fall back to the brand name with a plain descriptive line.
     * source: 'guidelines' = example copy in the Brand Guidelines,
     *         'fact-sheet' = client-authored fact sheet, not yet confirmed for web,
     *         'spec-sheet' = client-authored spec sheet, not yet confirmed for web,
     *         'draft'      = written for the website, needs approval.
     */
    'campaign_copy' => [
        'home_hero'      => ['text' => 'Private comfort, beautifully considered.', 'source' => 'guidelines', 'approved' => false],
        'home_hero_sub'  => ['text' => 'Luxury apartment hospitality across Nigeria.', 'source' => 'draft', 'approved' => false],
        'promise_title'  => ['text' => 'A private residence with hotel discipline.', 'source' => 'fact-sheet', 'approved' => false],
        'promise'        => ['text' => 'More privacy than a large hotel, more service than an independent apartment, and more utility than a conventional residence.', 'source' => 'fact-sheet', 'approved' => false],
        'day_title'      => ['text' => 'Stay, work, meet, dine and unwind without leaving the property.', 'source' => 'fact-sheet', 'approved' => false],
        'ways_title'     => ['text' => 'Stay for a night, a week or an extended period.', 'source' => 'guidelines', 'approved' => false],
        'audience_title' => ['text' => 'Commercially flexible. Operationally disciplined. Personally delivered.', 'source' => 'fact-sheet', 'approved' => false],
        'personal'       => ['text' => 'A more personal way to stay.', 'source' => 'guidelines', 'approved' => false],
    ],

    'footer_statement' => 'Private, design-led apartment hospitality, delivered with hotel precision.',

    // Guidelines: positioning, reworded for the group (original names Victoria Island).
    'positioning' => [
        'text'   => 'A premium luxury lifestyle apartment hotel brand delivering privacy, exclusivity and personalised hospitality.',
        'source' => 'draft',
        'detail' => 'Residential ease with hotel discipline: private rather than remote, refined rather than ostentatious, contemporary rather than trend-led, and personalised without becoming intrusive.',
    ],

    'vision' => [
        'title'  => 'To become Nigeria\'s benchmark for private, design-led luxury apartment hospitality.',
        'text'   => 'A place where discerning guests feel recognised, protected and entirely at ease, whether they stay for a night, a week or an extended period.',
        'source' => 'draft', // original: "Victoria Island's benchmark"
    ],

    'mission' => [
        'title'  => 'To deliver personalised residential-style hospitality with hotel precision.',
        'text'   => 'We combine privacy, thoughtful design, the character of each city and consistently intuitive service, so that every guest experiences luxury as ease rather than excess.',
        'source' => 'draft', // original: "contemporary Lagos character"
    ],

    'values' => [
        ['name' => 'Discretion', 'text' => 'We protect privacy, use information responsibly and never confuse attentiveness with intrusion.'],
        ['name' => 'Personalisation', 'text' => 'We remember preferences, adapt intelligently and make the guest feel recognised rather than processed.'],
        ['name' => 'Refined Comfort', 'text' => 'Luxury is expressed through ease, quality, proportion, calm and thoughtful detail.'],
        ['name' => 'Contemporary Character', 'text' => 'We are cosmopolitan and locally grounded, expressing each city through confidence, culture and craft, not cliché.', 'source' => 'draft'], // original: "Contemporary Lagos"
        ['name' => 'Reliability', 'text' => 'Operational excellence, cleanliness, security, technology and consistency are part of the brand promise.'],
        ['name' => 'Thoughtful Responsibility', 'text' => 'We choose durable materials, reduce waste, respect people and build partnerships that strengthen the local ecosystem.'],
    ],

    'personality' => ['Refined', 'Assured', 'Warm', 'Discreet', 'Contemporary', 'Human'],

    // Spec sheet: service attributes (used as body content, not as a tagline).
    'service_attributes' => [
        ['name' => 'Personal', 'text' => 'We recognise the individual and tailor the experience around the guest.'],
        ['name' => 'Effortless', 'text' => 'We remove unnecessary friction and make each stage of the guest journey simple and intuitive.'],
        ['name' => 'Refined', 'text' => 'We deliver our service with discretion, attention to detail, consistency and understated sophistication.'],
    ],

    // Spec sheet: the LAMORA Service Code.
    'service_code' => [
        ['letter' => 'L', 'name' => 'Listen & Learn'],
        ['letter' => 'A', 'name' => 'Anticipate'],
        ['letter' => 'M', 'name' => 'Make it Personal'],
        ['letter' => 'O', 'name' => 'Own the Outcome'],
        ['letter' => 'R', 'name' => 'Respond with Grace'],
        ['letter' => 'A', 'name' => 'Always Elevate'],
    ],

    // Fact sheet: stay profiles. The one-line descriptions are drafted from the spec
    // sheet's "ideal for" lists and extended-stay section (source: draft).
    'stay_profiles' => [
        ['name' => 'Nightly', 'text' => 'Short business trips, weekends and occasions.'],
        ['name' => 'Weekly', 'text' => 'Assignments, visits and relocations that need a settled base.'],
        ['name' => 'Monthly', 'text' => 'Residential living with hotel-grade servicing.'],
        ['name' => 'Bespoke', 'text' => 'Extended-stay agreements structured around length of stay and account volume.'],
    ],

    // Fact sheet: who The Lamora is for.
    'audiences' => [
        'Senior corporate executives seeking a private base.',
        'Embassy personnel and diplomatic delegations requiring discretion and controlled access.',
        'Expatriates, relocation guests and project teams requiring weekly or monthly residence solutions.',
        'Families and multi-guest parties needing apartment-style flexibility with professional hospitality support.',
        'Companies requiring accommodation, meetings, meals and executive hosting from one address.',
        'Premium leisure and staycation guests who prefer low-density, residential-style luxury.',
    ],

    // Fact sheet: one address across the day. Facilities vary by location.
    'day' => [
        ['name' => 'Stay', 'icon' => 'bed', 'text' => 'Residential suites designed for short and extended stays.'],
        ['name' => 'Work', 'icon' => 'laptop', 'text' => 'Professional workspace with connectivity, power and ergonomic seating.'],
        ['name' => 'Meet', 'icon' => 'table', 'text' => 'A private boardroom for leadership meetings, interviews and workshops.'],
        ['name' => 'Dine', 'icon' => 'utensils', 'text' => 'Restaurant, coffee shop and in-suite dining.'],
        ['name' => 'Unwind', 'icon' => 'waves', 'text' => 'Gym, swimming pool and a discreet lounge for private occasions.'],
    ],

    // Fact sheet: corporate advantage (Lagos wording "additional Lagos travel" made neutral).
    'corporate_advantage' => 'A company can accommodate executives, host a boardroom session, provide a working lunch, continue conversations in the VIP Lounge and return guests to their suites without additional travel across the city.',

    // Spec sheet: corporate services.
    'corporate_services' => [
        'Negotiated corporate accommodation rates',
        'Company-specific rate agreements',
        'Direct billing for approved corporate accounts',
        'Short- and extended-stay packages',
        'Group and project-team accommodation',
        'Preferential long-stay packages',
        'Executive accommodation and VIP hosting',
        'Airport transfer arrangements',
        'Business support and high-speed Wi-Fi',
        'Work-friendly suites and private lounge facilities',
    ],

    // Spec sheet: extended-stay functionality.
    'extended_stay' => [
        'Residential-style living areas',
        'Separate bedrooms in applicable categories',
        'Kitchen and kitchenette facilities',
        'Enhanced wardrobe and storage capacity',
        'Regular housekeeping and laundry support',
        'Corporate billing arrangements',
        'Personalised guest-preference records',
        'Engineering, maintenance and security support',
    ],

    // Spec sheet: payment methods (subject to final operating policy).
    'payment_methods' => [
        'Nigerian Naira',
        'Major debit and credit cards',
        'Bank transfer',
        'Approved corporate credit arrangements',
        'Approved online payment gateways',
    ],
];
