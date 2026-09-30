<?php
/*
 * The Lamora Lagos.
 * Sources: TLL Spec Sheet and TLL Fact Sheet 2026 Rev1. Items still marked TBC in
 * the sources (hours, capacities, distances, WhatsApp, some policies) are left out
 * and templates hide their sections until they are supplied.
 */

return [
    'slug'     => 'lagos',
    'name'     => 'The Lamora Lagos',
    'city'     => 'Lagos',
    'district' => 'Victoria Island',
    'status'   => 'opening-soon', // open | opening-soon | coming-soon
    'dates'    => [
        'soft_opening' => '2026-11-01',
        'launch'       => '2026-12-01',
    ],

    'summary' => 'Luxury serviced apartments in Victoria Island, with the independence of a private residence and the service of an upscale hotel.',

    'hero' => [
        'lead' => 'A premium luxury lifestyle apartment hotel delivering privacy, exclusivity and personalised hospitality in the heart of Victoria Island.',
    ],

    'overview' => [
        'title' => 'Contemporary luxury. Personalised hospitality. The heart of Lagos.',
        'body'  => [
            'The Lamora Lagos is a contemporary luxury serviced apartment hotel in Victoria Island, one of Lagos\' foremost commercial, diplomatic and lifestyle districts.',
            'It combines the independence and residential comfort of a private apartment with the professional service standards of an upscale hotel. Thirty-one serviced suites, from Studio Suites to a four-bedroom Presidential Suite, give guests more space and privacy than conventional hotel accommodation.',
        ],
    ],

    'facts' => [
        ['value' => '31', 'label' => 'Serviced suites'],
        ['value' => '5', 'label' => 'Suite categories'],
        ['value' => '116', 'label' => 'Guests, maximum'],
        ['value' => '15:00', 'label' => 'Check-in'],
        ['value' => '11:00', 'label' => 'Check-out'],
    ],

    'address'   => '2 Lasode Crescent, Victoria Island, Lagos, Nigeria',
    'map_query' => '2 Lasode Crescent, Victoria Island, Lagos, Nigeria',
    'contact'   => [
        'phone'     => '+234 (0)911 555 6555',
        'phone_uri' => '+2349115556555',
        'email'     => 'reservations@thelamora.com',
        'whatsapp'  => null, // TBC
    ],

    'suites_intro' => [
        'title' => '31 suites. Five ways to stay.',
        'text'  => 'The accommodation mix supports solo executives, couples, families, long-stay residents, project teams and VIP entourages.',
    ],

    /*
     * Suite categories. Each has its own page at /locations/lagos/suites/{slug}.
     * role: fact sheet positioning line. description, layout, ideal_for: spec sheet
     * section 4 (layouts are "typical configuration, subject to final unit design").
     * size (m²), bed types and views are not in the source documents yet: leave null
     * and the templates hide them. 'featured' => false keeps a suite off the homepage.
     */
    'suites' => [
        [
            'slug'        => 'studio-suite',
            'name'        => 'Studio Suite',
            'image'       => 'lagos.studio',
            'gallery'     => ['lagos.studio', 'lagos.studio-desk', 'lagos.studio-storage', 'lagos.studio-bed', 'lagos.studio-bath'],
            'units'       => 6,
            'guests'      => 2,
            'bedrooms'    => 0,
            'size'        => null,
            'role'        => 'An efficient premium base for individual executives and short stays.',
            'description' => [
                'An elegant and efficient residential space, designed primarily for individual business travellers and couples.',
                'Sleeping, relaxation and everyday living come together in one contemporary open-plan arrangement.',
            ],
            'layout'      => ['Open-plan sleeping and living area', 'Work desk', 'Kitchenette facilities', 'Wardrobe and luggage storage'],
            'ideal_for'   => ['Individual corporate travellers', 'Couples', 'Short business stays', 'Consultants', 'Weekend stays', 'Single extended-stay residents'],
        ],
        [
            'slug'        => 'one-bedroom-suite',
            'name'        => '1-Bedroom Suite',
            'image'       => 'lagos.one-bed',
            'gallery'     => ['lagos.one-bed', 'lagos.one-bed-living', 'lagos.one-bed-bedroom', 'lagos.one-bed-lounge', 'lagos.one-bed-bath'],
            'units'       => 6,
            'guests'      => 2,
            'bedrooms'    => 1,
            'size'        => null,
            'role'        => 'A separate bedroom and living space for business and extended stays.',
            'description' => [
                'Greater separation between sleeping and living areas, for enhanced privacy and residential comfort.',
                'A private bedroom with its own bathroom opens onto a separate living area, with a workstation and kitchen facilities for longer stays.',
            ],
            'layout'      => ['One private bedroom', 'Ensuite bathroom', 'Separate living area', 'Dining area, where applicable', 'Kitchen or kitchenette facilities', 'Workstation', 'Residential storage'],
            'ideal_for'   => ['Corporate executives', 'Couples', 'Extended-stay guests', 'Expatriate residents', 'Project consultants', 'Diplomatic travellers'],
        ],
        [
            'slug'        => 'two-bedroom-suite',
            'name'        => '2-Bedroom Suite',
            'image'       => 'lagos.two-bed',
            'gallery'     => ['lagos.two-bed', 'lagos.two-bed-bedroom', 'lagos.two-bed-second', 'lagos.two-bed-living', 'lagos.two-bed-bath'],
            'units'       => 12,
            'guests'      => 4,
            'bedrooms'    => 2,
            'size'        => null,
            'role'        => 'The core family, colleague-sharing and project-team suite.',
            'description' => [
                'Our largest category, with twelve suites, for guests who need more room and flexibility.',
                'Two bedrooms share residential living, dining and kitchen facilities, with a dedicated area for work.',
            ],
            'layout'      => ['Two bedrooms', 'Living and lounge area', 'Dining area', 'Kitchen facilities', 'Workstation or business-use area', 'Storage'],
            'ideal_for'   => ['Families', 'Corporate colleagues', 'Long-stay project teams', 'Diplomatic guests', 'Relocation stays', 'Executive sharing arrangements'],
        ],
        [
            'slug'        => 'three-bedroom-suite',
            'name'        => '3-Bedroom Suite',
            'image'       => 'lagos.three-bed',
            'gallery'     => ['lagos.three-bed', 'lagos.three-bed-bedroom', 'lagos.three-bed-living', 'lagos.three-bed-second', 'lagos.three-bed-kitchen', 'lagos.three-bed-bath'],
            'units'       => 6,
            'guests'      => 6,
            'bedrooms'    => 3,
            'size'        => null,
            'role'        => 'A premium multi-guest solution for families and senior teams.',
            'description' => [
                'Spacious residential accommodation for families, executive groups and longer-stay guests.',
                'Three bedrooms, a substantial living area, dining and a kitchen give a travelling group the space of a private home.',
            ],
            'layout'      => ['Three bedrooms', 'Multiple bathrooms', 'Substantial living area', 'Dining area', 'Kitchen', 'Enhanced storage'],
            'ideal_for'   => ['Families', 'Senior executive groups', 'Diplomatic delegations', 'Long-stay residents', 'Corporate project teams', 'Relocation guests', 'Small travelling groups'],
        ],
    ],

    'presidential' => [
        'slug'        => 'presidential-suite',
        'name'        => '4-Bedroom Presidential Suite',
        'image'       => 'lagos.presidential',
        'gallery'     => ['lagos.presidential', 'lagos.presidential-living', 'lagos.presidential-bedroom', 'lagos.presidential-dining', 'lagos.presidential-second', 'lagos.presidential-bath'],
        'units'       => 1,
        'guests'      => 8,
        'bedrooms'    => 4,
        'size'        => null,
        'role'        => 'The flagship private residence for executive, family and VIP hosting.',
        'text'        => 'Designed for senior executives, VIP guests, diplomatic visitors and families requiring exceptional privacy and space.',
        'description' => [
            'The flagship accommodation at The Lamora Lagos.',
            'Designed for senior executives, VIP guests, diplomatic visitors, prominent personalities and families requiring exceptional privacy and space, it offers the property\'s premium residential experience.',
        ],
        'highlights'  => ['Four private bedrooms', 'Premium bathroom facilities', 'Expansive living and entertainment areas', 'Full residential kitchen', 'Executive workspace', 'Personalised VIP service'],
        'layout'      => ['Four private bedrooms', 'Premium bathroom facilities', 'Expansive living and entertainment areas', 'Dining facilities', 'Full residential kitchen', 'Executive workspace', 'Premium furnishings and finishes', 'Enhanced privacy', 'Personalised VIP service'],
        'ideal_for'   => ['VIP guests', 'Senior corporate executives', 'Diplomatic guests', 'Government delegations', 'Public personalities', 'Premium family stays', 'Private executive hosting'],
    ],

    'suite_features' => [
        ['icon' => 'bed', 'text' => 'Premium bed and bedding'],
        ['icon' => 'bath', 'text' => 'Ensuite or dedicated bathroom'],
        ['icon' => 'wifi', 'text' => 'High-speed wireless internet'],
        ['icon' => 'tv', 'text' => 'Smart television'],
        ['icon' => 'wind', 'text' => 'Individually controlled air-conditioning'],
        ['icon' => 'laptop', 'text' => 'Work desk or workstation'],
        ['icon' => 'utensils', 'text' => 'Kitchenette, crockery and glassware'],
        ['icon' => 'coffee', 'text' => 'Tea and coffee-making facilities'],
        ['icon' => 'lock', 'text' => 'Electronic in-room safe'],
        ['icon' => 'moon', 'text' => 'Blackout window treatments'],
        ['icon' => 'plug', 'text' => 'Bedside power and USB charging'],
        ['icon' => 'droplet', 'text' => 'Complimentary bottled water on arrival'],
    ],

    'outlets' => [
        'restaurant' => [
            'name'    => 'The Restaurant',
            'label'   => 'Contemporary Afro-Fusion',
            'image'   => 'lagos.restaurant',
            'text'    => 'A refined but approachable dining room serving residents, corporate guests and visitors, with breakfast, lunch, dinner, room service and corporate hosting.',
            'details' => ['Breakfast, lunch and dinner', 'À la carte dining', 'Room service', 'Selected special dining experiences'],
        ],
        'vip_lounge' => [
            'name'    => 'The VIP Lounge',
            'label'   => 'Controlled access',
            'image'   => 'lagos.vip-lounge',
            'text'    => 'A discreet, controlled-access environment for premium beverages, executive hosting and private social occasions.',
            'details' => ['Private meetings and informal business discussions', 'Premium beverages and curated food', 'Intimate social gatherings'],
        ],
        'coffee_shop' => [
            'name'    => 'The Coffee Shop',
            'label'   => 'Daytime',
            'image'   => 'lagos.coffee-shop',
            'text'    => 'A relaxed setting for residents, visitors and business guests, with specialty coffee, premium and herbal teas, pastries, light meals and grab-and-go.',
            'details' => ['Specialty coffee and premium teas', 'Freshly baked pastries and desserts', 'Light meals and fresh juices', 'Takeaway'],
        ],
    ],

    'facilities' => [
        ['icon' => 'table', 'name' => 'Meeting Room & Boardroom', 'text' => 'Private executive scale for leadership meetings, interviews, presentations, workshops and strategy sessions.'],
        ['icon' => 'laptop', 'name' => 'Work-from-Home Space', 'text' => 'Professional workspace with connectivity, power, ergonomic seating and access to coffee, meals and meeting facilities.'],
        ['icon' => 'dumbbell', 'name' => 'Gym', 'text' => 'A gym that extends the residential proposition for short and extended stays.'],
        ['icon' => 'waves', 'name' => 'Swimming Pool', 'text' => 'A swimming pool for residents and guests.'],
        ['icon' => 'shirt', 'name' => 'Guest Laundry', 'text' => 'Laundry service and guest laundry support for short and extended stays.'],
        ['icon' => 'bell', 'name' => 'In-Suite Dining', 'text' => 'Dining delivered to the suite from the Restaurant.'],
    ],

    'facility_images' => [
        ['image' => 'lagos.pool', 'caption' => 'Swimming Pool'],
        ['image' => 'lagos.gym', 'caption' => 'Gym'],
        ['image' => 'lagos.boardroom', 'caption' => 'Meeting Room'],
    ],

    'services' => [
        'Reception and guest relations',
        'Concierge assistance',
        'Housekeeping',
        'Laundry service',
        'Luggage assistance',
        'Restaurant reservations',
        'Corporate account services',
        'Airport transfers, on request',
        'Chauffeur and transport arrangements, on request',
        'Wake-up calls, on request',
        '24-hour management support',
    ],

    'security' => [
        'Controlled property, resident and visitor access',
        'Professional security personnel and CCTV',
        'Electronic suite access controls',
        'Guest privacy protocols',
        'Secure guest parking',
        'Backup power generation',
    ],

    'location_text' => [
        'Victoria Island is one of Lagos\' principal business, hospitality and lifestyle districts.',
        'The property offers convenient access to corporate headquarters, financial institutions, diplomatic and consular establishments, restaurants, shopping and event venues, and the main Victoria Island and Lagos transport corridors.',
    ],

    'nearby' => [], // Distances TBC; section stays hidden until supplied.

    'arrival' => [
        'Guest parking available',
        'Taxi and chauffeur drop-off',
        'Airport transfers on request',
    ],

    'policies' => [
        ['label' => 'Check-in', 'text' => 'From 15:00.'],
        ['label' => 'Check-out', 'text' => 'By 11:00.'],
        ['label' => 'Early arrival and late departure', 'text' => 'Early check-in and late check-out are subject to availability and applicable charges.'],
        ['label' => 'Identification', 'text' => 'Valid government-issued identification is required at check-in.'],
        ['label' => 'Visitors', 'text' => 'Visitor access is controlled in accordance with our security policy.'],
        ['label' => 'Cancellation and no-show', 'text' => 'As set out in your confirmed rate and booking terms.'],
        ['label' => 'Long stays', 'text' => 'Weekly, monthly and bespoke extended stays are subject to individual agreement.'],
        ['label' => 'Payment', 'text' => 'Nigerian Naira, major debit and credit cards, bank transfer and approved corporate credit. Credit facilities are subject to prior approval.'],
    ],
];
