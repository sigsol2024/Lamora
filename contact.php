<?php
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'       => 'Contact',
    'description' => 'Contact The Lamora for reservations, corporate accounts and general enquiries.',
    'slug'        => 'contact',
];

$presetLocation = location(query('location')) ? query('location') : '';
$presetType = in_array(query('type'), ['reservation', 'corporate', 'dining', 'general'], true) ? query('type') : 'reservation';
$presetSuite = $presetLocation !== '' ? suite(location($presetLocation), query('suite')) : null;
$presetMessage = $presetSuite ? 'I would like to enquire about the ' . $presetSuite['name'] . '.' : '';

include INC . '/head.php';
include INC . '/header.php';
?>
<main id="main">

    <?php component('hero', [
        'variant' => 'plain',
        'label'   => 'Contact',
        'title'   => 'Contact us',
        'lead'    => 'For reservations, corporate accounts and general enquiries.',
    ]); ?>

    <section class="section contact" aria-label="Contact details and enquiry form">
        <div class="container">
            <div class="grid">
                <div class="span-4 contact__details">
                    <div class="contact__block reveal">
                        <h2 class="label label--muted">The Lamora</h2>
                        <dl class="contact__list">
                            <div>
                                <dt class="small muted">Reservations</dt>
                                <dd><a class="text-link" href="mailto:<?= e(site('contact.reservations')) ?>"><?= e(site('contact.reservations')) ?></a></dd>
                            </div>
                            <div>
                                <dt class="small muted">General enquiries</dt>
                                <dd><a class="text-link" href="mailto:<?= e(site('contact.info')) ?>"><?= e(site('contact.info')) ?></a></dd>
                            </div>
                        </dl>
                    </div>

                    <?php foreach (locations() as $loc): ?>
                        <div class="contact__block reveal">
                            <h2 class="label label--muted"><?= e(location_name($loc)) ?></h2>
                            <?php if (is_bookable($loc)): ?>
                                <?php if (!empty($loc['address'])): ?>
                                    <address class="contact__address"><?= e($loc['address']) ?></address>
                                <?php endif; ?>
                                <dl class="contact__list">
                                    <?php if (!empty($loc['contact']['phone'])): ?>
                                        <div>
                                            <dt class="small muted">Telephone</dt>
                                            <dd><a class="text-link figures" href="tel:<?= e($loc['contact']['phone_uri']) ?>"><?= e($loc['contact']['phone']) ?></a></dd>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($loc['contact']['email'])): ?>
                                        <div>
                                            <dt class="small muted">Email</dt>
                                            <dd><a class="text-link" href="mailto:<?= e($loc['contact']['email']) ?>"><?= e($loc['contact']['email']) ?></a></dd>
                                        </div>
                                    <?php endif; ?>
                                </dl>
                                <div class="contact__links">
                                    <?php if (!empty($loc['map_query'])): ?>
                                        <a class="link-arrow" href="https://www.google.com/maps/search/?api=1&amp;query=<?= e(rawurlencode($loc['map_query'])) ?>" target="_blank" rel="noopener">Get directions <?= icon('arrow-right') ?></a>
                                    <?php endif; ?>
                                    <a class="link-arrow" href="<?= e(location_url($loc['slug'])) ?>">View <?= e($loc['city']) ?> <?= icon('arrow-right') ?></a>
                                </div>
                            <?php else: ?>
                                <p class="small muted"><?= e(status_label($loc)) ?></p>
                                <div class="contact__links">
                                    <a class="link-arrow" href="<?= e(interest_url($loc)) ?>">Register interest <?= icon('arrow-right') ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="span-7 start-6 contact__form" id="enquiry">
                    <div class="reveal">
                        <p class="label label--muted">Enquiry</p>
                        <h2 class="h2 contact__title">Send an enquiry</h2>
                    </div>
                    <?php component('enquiry-form', [
                        'mode'     => 'full',
                        'location' => $presetLocation,
                        'type'     => $presetType,
                        'message'  => $presetMessage,
                        'return'   => url('contact') . '#enquiry',
                    ]); ?>
                </div>
            </div>
        </div>
    </section>

</main>
<?php include INC . '/footer.php'; ?>
