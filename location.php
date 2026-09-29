<?php
require __DIR__ . '/includes/bootstrap.php';

$loc = location(query('slug'));
if ($loc === null) {
    require __DIR__ . '/404.php';
    exit;
}

$comingSoon = ($loc['status'] ?? '') === 'coming-soon';

$page = [
    'title'       => $comingSoon ? $loc['city'] . ' - Coming soon' : location_name($loc),
    'description' => $comingSoon
        ? 'The Lamora is coming to ' . $loc['city'] . '. Register your interest.'
        : ($loc['summary'] ?? ''),
    'slug'        => 'location',
    'body_class'  => $comingSoon ? 'is-coming-soon' : 'has-booking-bar',
];

include INC . '/head.php';
include INC . '/header.php';
?>
<main id="main">
<?php if ($comingSoon): ?>

    <?php component('hero', [
        'variant' => 'plain',
        'label'   => 'Coming soon',
        'title'   => $loc['city'],
        'lead'    => copy_line('promise'),
        'actions' => [
            ['label' => 'Register interest', 'href' => '#register'],
        ],
    ]); ?>

    <section class="section" id="register" aria-labelledby="register-title">
        <div class="container">
            <div class="grid">
                <div class="span-4 reveal">
                    <p class="label label--muted"><?= e($loc['city']) ?></p>
                    <h2 class="h2 register__title" id="register-title">Register your interest</h2>
                    <p class="muted register__text">Leave your details and we will be in touch when reservations open.</p>
                    <?php
                    $openLocations = array_filter(locations(), fn($l) => is_bookable($l));
                    if ($openLocations): ?>
                        <div class="register__elsewhere">
                            <p class="label label--muted">Also at The Lamora</p>
                            <?php foreach ($openLocations as $open): ?>
                                <a class="link-arrow" href="<?= e(location_url($open['slug'])) ?>"><?= e(location_name($open)) ?> <?= icon('arrow-right') ?></a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="span-7 start-6 reveal">
                    <?php component('enquiry-form', [
                        'mode'     => 'interest',
                        'location' => $loc['slug'],
                        'return'   => location_url($loc['slug'], 'register'),
                    ]); ?>
                </div>
            </div>
        </div>
    </section>

<?php else: ?>

    <?php component('hero', [
        'variant' => 'split',
        'image'   => $loc['slug'] . '.hero',
        'label'   => ($loc['district'] ?? '') . ', ' . $loc['city'],
        'title'   => location_name($loc),
        'lead'    => $loc['hero']['lead'] ?? null,
        'status'  => status_label($loc),
        'actions' => [
            ['label' => 'Check availability', 'href' => booking_url($loc)],
            ['label' => 'Enquire', 'href' => url('contact') . '?location=' . rawurlencode($loc['slug']) . '#enquiry', 'style' => 'link'],
        ],
    ]); ?>

    <?php if (!empty($loc['facts'])): ?>
        <div class="container">
            <dl class="facts">
                <?php foreach ($loc['facts'] as $fact): ?>
                    <div class="facts__item">
                        <dt class="label label--muted"><?= e($fact['label']) ?></dt>
                        <dd class="facts__value"><?= e($fact['value']) ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    <?php endif; ?>

    <?php
    $links = [['id' => 'overview', 'label' => 'Overview'], ['id' => 'suites', 'label' => 'Suites']];
    if (!empty($loc['outlets'])) $links[] = ['id' => 'dining', 'label' => 'Dining'];
    if (!empty($loc['facilities'])) $links[] = ['id' => 'facilities', 'label' => 'Facilities'];
    if (!empty($loc['address'])) $links[] = ['id' => 'location', 'label' => 'Location'];
    if (!empty($loc['policies'])) $links[] = ['id' => 'good-to-know', 'label' => 'Good to know'];
    component('location-subnav', ['loc' => $loc, 'links' => $links]);
    ?>

    <!-- Overview -->
    <section class="section overview" id="overview" aria-labelledby="overview-title">
        <div class="container">
            <div class="grid">
                <div class="span-6 reveal">
                    <p class="label label--muted">Overview</p>
                    <h2 class="h2 overview__title" id="overview-title"><?= e($loc['overview']['title']) ?></h2>
                    <div class="body-copy overview__body">
                        <?php foreach ($loc['overview']['body'] as $paragraph): ?><p><?= e($paragraph) ?></p><?php endforeach; ?>
                    </div>
                </div>
                <div class="span-5 start-8 offset-down reveal">
                    <?= img($loc['slug'] . '.overview', ['ratio' => '4x5', 'sizes' => '(min-width: 960px) 38vw, 100vw']) ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Suites -->
    <section class="section section--flush-top suites" id="suites" aria-labelledby="suites-title">
        <div class="container">
            <?php component('section-heading', [
                'label' => 'The apartment collection',
                'title' => $loc['suites_intro']['title'],
                'intro' => $loc['suites_intro']['text'],
                'split' => true,
            ]); ?>
            <div class="suite-grid">
                <?php foreach ($loc['suites'] as $suite): ?>
                    <?php component('suite-card', ['suite' => $suite]); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php if (!empty($loc['presidential'])): $p = $loc['presidential']; ?>
        <section class="presidential surface-navy" aria-labelledby="presidential-title">
            <div class="container">
                <div class="grid presidential__grid">
                    <div class="span-6 bleed-left presidential__media reveal">
                        <?= img($p['image'], ['sizes' => '(min-width: 960px) 50vw, 100vw']) ?>
                    </div>
                    <div class="span-5 start-8 presidential__text reveal">
                        <p class="label label--muted">The flagship</p>
                        <h2 class="h2 presidential__title" id="presidential-title"><?= e($p['name']) ?></h2>
                        <p class="label figures muted presidential__meta">Up to <?= (int) $p['guests'] ?> guests</p>
                        <p class="lead presidential__role"><?= e($p['role']) ?></p>
                        <p class="muted"><?= e($p['text']) ?></p>
                        <ul class="rows presidential__config small">
                            <?php foreach ($p['config'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
                        </ul>
                        <div class="actions">
                            <a class="btn btn--cream" href="<?= e(url('contact') . '?location=' . rawurlencode($loc['slug']) . '&type=reservation#enquiry') ?>">Enquire</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- In every suite -->
    <?php if (!empty($loc['suite_features'])): ?>
        <section class="section features" aria-labelledby="features-title">
            <div class="container">
                <div class="grid">
                    <div class="span-4 reveal">
                        <p class="label label--muted">In every suite</p>
                        <h2 class="h2 features__title" id="features-title">Residential comfort, hotel-grade servicing.</h2>
                        <div class="features__media">
                            <?= img($loc['slug'] . '.detail', ['ratio' => '4x5', 'sizes' => '(min-width: 960px) 28vw, 100vw']) ?>
                        </div>
                    </div>
                    <div class="span-7 start-6 reveal">
                        <ul class="feature-list">
                            <?php foreach ($loc['suite_features'] as $feature): ?>
                                <li><?= icon($feature['icon'], 'icon--s') ?><span><?= e($feature['text']) ?></span></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="actions">
                            <a class="btn" href="<?= e(booking_url($loc)) ?>">Check availability</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Dining & social -->
    <?php if (!empty($loc['outlets'])): ?>
        <section id="dining" class="dining" aria-labelledby="dining-title">
            <div class="container dining__intro">
                <?php component('section-heading', [
                    'label' => 'Dining & social',
                    'title' => 'Three places to meet, dine and unwind.',
                    'intro' => 'Contemporary Afro-Fusion dining, a discreet VIP Lounge and a relaxed Coffee Shop.',
                    'split' => true,
                ]); ?>
            </div>
            <?php
            $surfaces = ['restaurant' => 'surface-white', 'vip_lounge' => 'surface-navy', 'coffee_shop' => 'surface-cream'];
            $i = 0;
            foreach ($loc['outlets'] as $key => $outlet): $i++; $reverse = $i % 2 === 0; ?>
                <article class="outlet <?= e($surfaces[$key] ?? 'surface-white') ?><?= $reverse ? ' outlet--reverse' : '' ?>" aria-labelledby="outlet-<?= e($key) ?>">
                    <div class="container">
                        <div class="grid outlet__grid">
                            <div class="outlet__media span-6 <?= $reverse ? 'start-7 bleed-right' : 'bleed-left' ?> reveal">
                                <?= img($outlet['image'], ['ratio' => '3x2', 'sizes' => '(min-width: 960px) 50vw, 100vw']) ?>
                            </div>
                            <div class="outlet__text span-4 <?= $reverse ? 'start-2 row-1' : 'start-8' ?> reveal">
                                <p class="label label--muted"><?= e($outlet['label']) ?></p>
                                <h3 class="h2 outlet__title" id="outlet-<?= e($key) ?>"><?= e($outlet['name']) ?></h3>
                                <p class="outlet__desc"><?= e($outlet['text']) ?></p>
                                <ul class="outlet__details small muted">
                                    <?php foreach ($outlet['details'] as $detail): ?><li><?= e($detail) ?></li><?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <!-- Facilities -->
    <?php if (!empty($loc['facilities'])): ?>
        <section class="section facilities" id="facilities" aria-labelledby="facilities-title">
            <div class="container">
                <?php component('section-heading', [
                    'label' => 'Facilities',
                    'title' => 'Everything for work and rest, at one address.',
                    'split' => true,
                ]); ?>

                <?php if (!empty($loc['facility_images'])): ?>
                    <div class="facility-images">
                        <?php foreach ($loc['facility_images'] as $figure): ?>
                            <figure class="reveal">
                                <?= img($figure['image'], ['ratio' => '4x5', 'sizes' => '(min-width: 960px) 30vw, 100vw']) ?>
                                <figcaption class="label label--muted"><?= e($figure['caption']) ?></figcaption>
                            </figure>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php component('facility-list', ['items' => $loc['facilities']]); ?>

                <div class="grid services">
                    <div class="span-5 reveal">
                        <h3 class="label services__label">Guest services</h3>
                        <ul class="rows services__list small">
                            <?php foreach ($loc['services'] as $service): ?><li><?= e($service) ?></li><?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="span-5 start-8 reveal">
                        <h3 class="label services__label">Security &amp; peace of mind</h3>
                        <ul class="rows services__list small">
                            <?php foreach ($loc['security'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Corporate advantage -->
    <section class="section corporate-band surface-navy" aria-labelledby="corporate-title">
        <div class="container">
            <div class="grid">
                <div class="span-3 reveal">
                    <p class="label label--muted">Corporate advantage</p>
                </div>
                <div class="span-8 start-5 reveal">
                    <p class="h3 corporate-band__statement" id="corporate-title"><?= e(site('corporate_advantage')) ?></p>
                    <div class="actions">
                        <a class="link-arrow" href="<?= e(url('corporate-stays')) ?>">Corporate and extended stays <?= icon('arrow-right') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location -->
    <?php if (!empty($loc['address'])): ?>
        <section class="section place" id="location" aria-labelledby="place-title">
            <div class="container">
                <div class="grid">
                    <div class="span-5 reveal">
                        <p class="label label--muted">Location</p>
                        <h2 class="h2 place__title" id="place-title"><?= e($loc['district'] ?? $loc['city']) ?></h2>
                        <div class="body-copy place__body muted">
                            <?php foreach ($loc['location_text'] as $paragraph): ?><p><?= e($paragraph) ?></p><?php endforeach; ?>
                        </div>
                        <address class="place__address">
                            <?= icon('map-pin', 'icon--s') ?>
                            <span><?= e($loc['address']) ?></span>
                        </address>
                        <?php if (!empty($loc['arrival'])): ?>
                            <ul class="rows place__arrival small">
                                <?php foreach ($loc['arrival'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <?php if (!empty($loc['nearby'])): ?>
                            <dl class="rows policy-list place__nearby">
                                <?php foreach ($loc['nearby'] as $place): ?>
                                    <div><dt><?= e($place['name']) ?></dt><dd><?= e($place['distance']) ?></dd></div>
                                <?php endforeach; ?>
                            </dl>
                        <?php endif; ?>
                        <div class="actions">
                            <a class="link-arrow" href="https://www.google.com/maps/search/?api=1&amp;query=<?= e(rawurlencode($loc['map_query'])) ?>" target="_blank" rel="noopener">Get directions <?= icon('arrow-right') ?></a>
                        </div>
                    </div>
                    <div class="span-6 start-7 bleed-right reveal">
                        <div class="place__map">
                            <iframe
                                title="Map showing <?= e(location_name($loc)) ?>"
                                src="https://maps.google.com/maps?q=<?= e(rawurlencode($loc['map_query'])) ?>&amp;z=15&amp;output=embed"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Good to know -->
    <?php if (!empty($loc['policies'])): ?>
        <section class="section section--flush-top good-to-know" id="good-to-know" aria-labelledby="policies-title">
            <div class="container">
                <div class="grid">
                    <div class="span-4 reveal">
                        <p class="label label--muted">Good to know</p>
                        <h2 class="h2 good-to-know__title" id="policies-title">Before you arrive.</h2>
                        <div class="actions">
                            <a class="link-arrow" href="<?= e(url('faq')) ?>">Frequently asked questions <?= icon('arrow-right') ?></a>
                            <a class="link-arrow" href="<?= e(url('terms')) ?>">Terms &amp; Conditions <?= icon('arrow-right') ?></a>
                        </div>
                    </div>
                    <dl class="span-7 start-6 rows policy-list reveal">
                        <?php foreach ($loc['policies'] as $policy): ?>
                            <div><dt><?= e($policy['label']) ?></dt><dd><?= e($policy['text']) ?></dd></div>
                        <?php endforeach; ?>
                    </dl>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php component('cta-band', [
        'label' => 'Reservations',
        'title' => 'Reserve at ' . location_name($loc) . '.',
        'text'  => status_label($loc) . '. Speak to our reservations team about nightly, weekly and extended stays.',
        'loc'   => $loc,
    ]); ?>

    <div class="booking-bar" aria-label="Book <?= e(location_name($loc)) ?>">
        <div class="booking-bar__text">
            <span class="booking-bar__city"><?= e(location_name($loc)) ?></span>
            <span class="label label--muted"><?= e(status_label($loc)) ?></span>
        </div>
        <a class="btn btn--cream btn--small" href="<?= e(booking_url($loc)) ?>">Check availability</a>
    </div>

<?php endif; ?>
</main>
<?php include INC . '/footer.php'; ?>
