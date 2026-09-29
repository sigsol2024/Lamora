<?php
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'       => 'Privacy Policy',
    'description' => 'How The Lamora collects, uses and protects personal information.',
    'slug'        => 'legal',
];

include INC . '/head.php';
include INC . '/header.php';
?>
<main id="main">

    <?php component('hero', [
        'variant' => 'plain',
        'label'   => 'Legal',
        'title'   => 'Privacy Policy',
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

                    <p>Discretion is one of our values. This policy explains what personal information we collect, how we use it and the choices you have, in line with the Nigeria Data Protection Act 2023.</p>

                    <h2 class="h3">1. Information we collect</h2>
                    <p>When you send an enquiry or register interest, we collect the details you provide: your name, email address, telephone number, preferred location, dates, number of guests and your message.</p>
                    <p>When you stay with us, we collect the information needed to manage your reservation and stay, including identification required at check-in, payment details and service preferences you share with us.</p>

                    <h2 class="h3">2. How we use it</h2>
                    <p>We use your information to respond to enquiries, manage reservations and stays, provide the services you request, meet legal and security obligations, and remember preferences so that we can personalise future stays.</p>
                    <p>We do not sell personal information.</p>

                    <h2 class="h3">3. Legal basis</h2>
                    <p>We process personal information with your consent, to perform a contract with you or take steps at your request before entering one, to comply with legal obligations, or for our legitimate interests in operating a safe and secure property.</p>

                    <h2 class="h3">4. Sharing</h2>
                    <p>We share information only where necessary: with our booking and payment providers, with service providers who support our operations under appropriate safeguards, or where required by law.</p>

                    <h2 class="h3">5. Retention</h2>
                    <p>We keep personal information only for as long as needed for the purposes above, or as required by law.</p>

                    <h2 class="h3">6. Cookies and third-party services</h2>
                    <p>This website uses a session cookie to keep forms secure. It does not use advertising cookies.</p>
                    <p>Fonts are loaded from Google Fonts, and location pages include an embedded Google Map. These services receive your IP address when they load and are governed by Google's privacy policy.</p>

                    <h2 class="h3">7. Your rights</h2>
                    <p>You may ask to access, correct or delete your personal information, object to or restrict its processing, or withdraw your consent at any time. You may also complain to the Nigeria Data Protection Commission.</p>

                    <h2 class="h3">8. Contact</h2>
                    <p>To exercise your rights or ask about this policy, email <a class="text-link" href="mailto:<?= e(site('contact.info')) ?>"><?= e(site('contact.info')) ?></a>.</p>
                </div>
            </div>
        </div>
    </section>

</main>
<?php include INC . '/footer.php'; ?>
