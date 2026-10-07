<?php
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'       => 'Contact',
    'description' => 'Contact The Lamora for reservations, corporate accounts and general enquiries.',
    'slug'        => 'contact',
];

$open   = array_values(array_filter(locations(), 'is_bookable'));
$mapLoc = null;
foreach ($open as $loc) {
    if (!empty($loc['map_query'])) {
        $mapLoc = $loc;
        break;
    }
}
$directions = static fn (array $loc): string => 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($loc['map_query']);

$emails = [
    ['label' => 'Reservations',      'email' => site('contact.reservations')],
    ['label' => 'General enquiries', 'email' => site('contact.info')],
    ['label' => 'Sales',             'email' => site('contact.sales')],
];

include INC . '/head.php';
include INC . '/header.php';
?>
<main id="main">

    <?php component('hero', [
        'variant' => 'split',
        'tone'    => 'navy',
        'reverse' => true,
        'image'   => 'contact.hero',
        'label'   => 'Contact',
        'title'   => 'Contact us',
        'lead'    => 'For reservations, corporate accounts and general enquiries.',
        'actions' => array_filter([
            ['label' => 'Email reservations', 'href' => 'mailto:' . site('contact.reservations')],
            $mapLoc ? ['label' => 'Find us', 'href' => '#map', 'style' => 'link'] : null,
        ]),
    ]); ?>

    <!-- Contact details: emails, address and directions, social channels -->
    <section class="section contact" id="enquiry" aria-label="Contact details">
        <div class="container contact__grid">

            <div class="contact__col reveal">
                <h2 class="label label--muted contact__heading">The Lamora</h2>
                <dl class="contact__list">
                    <?php foreach ($emails as $item): ?>
                        <div>
                            <dt class="small muted"><?= e($item['label']) ?></dt>
                            <dd><a class="text-link" href="mailto:<?= e($item['email']) ?>"><?= e($item['email']) ?></a></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
            </div>

            <div class="contact__col reveal">
                <?php foreach ($open as $loc): ?>
                    <h2 class="label label--muted contact__heading"><?= e(location_name($loc)) ?></h2>
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
                        <?php if (!empty($loc['arrival'])): ?>
                            <div>
                                <dt class="small muted">Guest directions</dt>
                                <dd>
                                    <ul class="contact__arrival small">
                                        <?php foreach ($loc['arrival'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
                                    </ul>
                                </dd>
                            </div>
                        <?php endif; ?>
                    </dl>
                    <div class="contact__links">
                        <?php if (!empty($loc['map_query'])): ?>
                            <a class="link-arrow" href="<?= e($directions($loc)) ?>" target="_blank" rel="noopener">Get directions <?= icon('arrow-right') ?></a>
                        <?php endif; ?>
                        <a class="link-arrow" href="<?= e(location_url($loc['slug'])) ?>">View <?= e($loc['city']) ?> <?= icon('arrow-right') ?></a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="contact__col reveal">
                <h2 class="label label--muted contact__heading">Follow us</h2>
                <ul class="contact-social">
                    <?php foreach (site('social') as $social): ?>
                        <li>
                            <a class="contact-social__link" href="<?= e($social['url']) ?>" target="_blank" rel="noopener noreferrer">
                                <span class="contact-social__mark" aria-hidden="true">
                                    <svg class="contact-social__hex" viewBox="0 0 44 50" focusable="false"><path d="M22 1.5 42.5 13.25v23.5L22 48.5 1.5 36.75v-23.5Z"/></svg>
                                    <?= icon($social['icon']) ?>
                                </span>
                                <span><?= e($social['label']) ?><span class="visually-hidden"> (opens in a new tab)</span></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
    </section>

    <?php if ($mapLoc): ?>
        <!-- Map on Navy -->
        <section class="section surface-navy contact-map" id="map" aria-labelledby="map-title">
            <div class="hex-pattern hex-pattern--cream contact-map__pattern" aria-hidden="true"></div>
            <div class="container contact-map__inner">
                <div class="contact-map__head reveal">
                    <div>
                        <p class="label label--muted">Find us</p>
                        <h2 class="h2" id="map-title"><?= e(location_name($mapLoc)) ?></h2>
                    </div>
                    <div class="contact-map__meta">
                        <address class="muted"><?= e($mapLoc['address']) ?></address>
                        <a class="link-arrow" href="<?= e($directions($mapLoc)) ?>" target="_blank" rel="noopener">Get directions <?= icon('arrow-right') ?></a>
                    </div>
                </div>
                <div class="contact-map__frame reveal">
                    <iframe
                        title="Map showing <?= e(location_name($mapLoc)) ?>"
                        src="https://maps.google.com/maps?q=<?= e(rawurlencode($mapLoc['map_query'])) ?>&amp;z=15&amp;output=embed"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </section>
    <?php endif; ?>

</main>
<?php include INC . '/footer.php'; ?>
