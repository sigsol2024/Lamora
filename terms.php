<?php
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'       => 'Terms & Conditions',
    'description' => 'Terms and conditions for stays and use of the website of The Lamora.',
    'slug'        => 'legal',
];

include INC . '/head.php';
include INC . '/header.php';
?>
<main id="main">

    <?php component('hero', [
        'variant' => 'plain',
        'label'   => 'Legal',
        'title'   => 'Terms & Conditions',
    ]); ?>

    <section class="section legal">
        <div class="container">
            <div class="grid">
                <aside class="span-3 legal__meta">
                    <p class="label label--muted">Applies to</p>
                    <p class="small">All locations of The Lamora and thelamora.com</p>
                </aside>

                <div class="span-7 start-5 legal__body body-copy">
                    <?php if (SHOW_DRAFT_NOTES): ?>
                        <p class="legal__draft small">Draft for review by The Lamora and its legal advisers. Not yet in force.</p>
                    <?php endif; ?>

                    <h2 class="h3">1. About these terms</h2>
                    <p>These terms apply to reservations and stays at locations operating under The Lamora name, and to the use of this website. Your confirmed rate and booking terms form part of your agreement with us and take precedence where they differ.</p>

                    <h2 class="h3">2. Reservations</h2>
                    <p>A reservation is confirmed only when you receive written confirmation from The Lamora or its booking partner. Rates, inclusions and conditions depend on the rate booked and the length of stay.</p>
                    <p>Weekly, monthly and bespoke extended stays are subject to individual agreement.</p>

                    <h2 class="h3">3. Arrival and departure</h2>
                    <p>Check-in and check-out times are shown on each location page and in your confirmation. Early check-in and late check-out are subject to availability and applicable charges.</p>
                    <p>Valid government-issued identification is required at check-in.</p>

                    <h2 class="h3">4. Cancellation and no-show</h2>
                    <p>Cancellation and no-show conditions are set out in your confirmed rate and booking terms.</p>

                    <h2 class="h3">5. Payment</h2>
                    <p>We accept Nigerian Naira, major debit and credit cards, bank transfer, approved corporate credit arrangements and approved online payment gateways. Corporate credit facilities are subject to prior approval.</p>

                    <h2 class="h3">6. Visitors and security</h2>
                    <p>Access to the property is controlled. Visitor access is managed in accordance with our security policy, and guests are responsible for their visitors while on the property.</p>

                    <h2 class="h3">7. Care of the suite</h2>
                    <p>Guests are asked to treat suites, furnishings and shared facilities with care. Charges may apply for loss or damage beyond normal use.</p>

                    <h2 class="h3">8. Use of this website</h2>
                    <p>Information on this website is provided in good faith and may change. Images are for illustration. Facilities, services and opening dates may vary by location and are confirmed at the time of booking.</p>

                    <h2 class="h3">9. Governing law</h2>
                    <p>These terms are governed by the laws of the Federal Republic of Nigeria.</p>

                    <h2 class="h3">10. Contact</h2>
                    <p>Questions about these terms can be sent to <a class="text-link" href="mailto:<?= e(site('contact.info')) ?>"><?= e(site('contact.info')) ?></a>.</p>
                </div>
            </div>
        </div>
    </section>

</main>
<?php include INC . '/footer.php'; ?>
