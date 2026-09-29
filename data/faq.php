<?php
/*
 * FAQ. 'location' is 'group' for answers that apply to The Lamora as a whole, or a
 * location slug. Answers come from the spec sheet and fact sheet; unconfirmed
 * policies (children, extra guests, smoking, pets) are left out until supplied.
 */

return [
    [
        'group' => 'Locations',
        'items' => [
            ['location' => 'group', 'q' => 'Where is The Lamora?', 'a' => ['The Lamora Lagos is in Victoria Island, Lagos. Abuja is coming soon, and more Nigerian cities will follow.']],
            ['location' => 'lagos', 'q' => 'When does The Lamora Lagos open?', 'a' => ['The soft opening is on 1 November 2026, followed by the official launch on 1 December 2026.']],
            ['location' => 'lagos', 'q' => 'What is the address in Lagos?', 'a' => ['2 Lasode Crescent, Victoria Island, Lagos, Nigeria.']],
        ],
    ],
    [
        'group' => 'Booking',
        'items' => [
            ['location' => 'group', 'q' => 'How do I make a reservation?', 'a' => ['Choose a location and select Check availability, or contact our reservations team at reservations@thelamora.com.']],
            ['location' => 'group', 'q' => 'Can I book a weekly or monthly stay?', 'a' => ['Yes. We welcome nightly, weekly and monthly stays, as well as bespoke extended-stay agreements. Long-stay terms are agreed individually.']],
            ['location' => 'group', 'q' => 'Do you offer corporate accounts?', 'a' => ['Yes. We offer negotiated corporate rates, company-specific agreements and direct billing for approved corporate accounts. Credit facilities are subject to prior approval by our Finance Department.']],
            ['location' => 'group', 'q' => 'What is your cancellation policy?', 'a' => ['Cancellation and no-show conditions are set out in your confirmed rate and booking terms.']],
        ],
    ],
    [
        'group' => 'Your stay',
        'items' => [
            ['location' => 'lagos', 'q' => 'What are the check-in and check-out times?', 'a' => ['Check-in is from 15:00 and check-out is by 11:00. Early check-in and late check-out are subject to availability and applicable charges.']],
            ['location' => 'group', 'q' => 'What do I need at check-in?', 'a' => ['Valid government-issued identification is required.']],
            ['location' => 'group', 'q' => 'Can I receive visitors?', 'a' => ['Visitor access is controlled in accordance with our security policy.']],
            ['location' => 'lagos', 'q' => 'Can you arrange airport transfers?', 'a' => ['Yes. Airport transfers and chauffeur arrangements are available on request.']],
            ['location' => 'lagos', 'q' => 'Is parking available?', 'a' => ['Yes. Guest parking is available, with controlled access and taxi and chauffeur drop-off.']],
        ],
    ],
    [
        'group' => 'Suites & facilities',
        'items' => [
            ['location' => 'lagos', 'q' => 'What suites are available in Lagos?', 'a' => ['Thirty-one serviced suites in five categories: Studio, 1-Bedroom, 2-Bedroom and 3-Bedroom Suites, and a 4-Bedroom Presidential Suite. Suites accommodate from two to eight guests.']],
            ['location' => 'group', 'q' => 'Do suites have kitchen facilities?', 'a' => ['Suites include kitchen or kitchenette facilities, with crockery, cutlery and glassware. Larger suites add dining areas and separate living spaces.']],
            ['location' => 'group', 'q' => 'Is there Wi-Fi?', 'a' => ['Yes. High-speed wireless internet is included in every suite.']],
            ['location' => 'lagos', 'q' => 'What facilities are there in Lagos?', 'a' => ['A Restaurant, VIP Lounge and Coffee Shop, a Meeting Room and Boardroom, a Work-from-Home Space, a gym, a swimming pool, guest laundry and in-suite dining.']],
            ['location' => 'lagos', 'q' => 'Is there backup power?', 'a' => ['Yes. The property has backup power generation.']],
        ],
    ],
    [
        'group' => 'Payment',
        'items' => [
            ['location' => 'group', 'q' => 'Which payment methods do you accept?', 'a' => ['Nigerian Naira, major debit and credit cards, bank transfer, approved corporate credit arrangements and approved online payment gateways.']],
        ],
    ],
];
