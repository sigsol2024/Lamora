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
    'body_class'  => $comingSoon ? 'is-coming-soon' : '',
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
        'tone'    => 'navy',
        'fit'     => true,
        'image'   => $loc['slug'] . '.hero',
        'slides'  => $loc['hero']['slides'] ?? [],
        'label'   => ($loc['district'] ?? '') . ', ' . $loc['city'],
        'title'   => location_name($loc),
        'lead'    => $loc['hero']['lead'] ?? null,
        'status'  => status_label($loc),
        'actions' => [
            ['label' => 'Check availability', 'href' => '#booking'],
            ['label' => 'Enquire', 'href' => url('contact') . '?location=' . rawurlencode($loc['slug']) . '#enquiry', 'style' => 'link'],
        ],
    ]); ?>

    <?php
    // Booking calendar. Dates go to the booking engine when one is configured,
    // otherwise into an email to reservations.
    $opening   = $loc['dates']['soft_opening'] ?? null;
    $minDate   = max(date('Y-m-d'), $opening ?? '');
    $bookSuites = location_suites($loc);
    ?>
    <section class="booking surface-mist" id="booking" aria-labelledby="booking-title">
        <div class="container">
            <form class="booking-form reveal" action="<?= e(booking_url($loc)) ?>" method="get" novalidate
                  data-booking-form
                  data-engine="<?= e(BOOKING_URLS[$loc['slug']] ?? '') ?>"
                  data-email="<?= e($loc['contact']['email'] ?? site('contact.reservations')) ?>"
                  data-location="<?= e(location_name($loc)) ?>">
                <div class="booking-form__head">
                    <h2 class="label label--muted" id="booking-title">Check availability</h2>
                    <p class="small muted"><?= e(status_label($loc)) ?></p>
                </div>
                <label class="field">
                    <span>Check-in</span>
                    <input class="input" type="date" name="checkin" min="<?= e($minDate) ?>" required data-booking-in>
                </label>
                <label class="field">
                    <span>Check-out</span>
                    <input class="input" type="date" name="checkout" min="<?= e($minDate) ?>" required data-booking-out>
                </label>
                <label class="field">
                    <span>Guests</span>
                    <select class="select" name="guests">
                        <?php for ($g = 1; $g <= 8; $g++): ?><option value="<?= $g ?>"<?= $g === 2 ? ' selected' : '' ?>><?= $g ?> <?= $g === 1 ? 'guest' : 'guests' ?></option><?php endfor; ?>
                    </select>
                </label>
                <label class="field">
                    <span>Suite</span>
                    <select class="select" name="suite">
                        <option value="">Any suite</option>
                        <?php foreach ($bookSuites as $s): ?><option value="<?= e($s['slug']) ?>"><?= e($s['name']) ?></option><?php endforeach; ?>
                    </select>
                </label>
                <button class="btn booking-form__submit" type="submit">Check availability</button>
            </form>

            <?php if (!empty($loc['facts'])): ?>
                <dl class="facts">
                    <?php foreach ($loc['facts'] as $fact): ?>
                        <div class="facts__item">
                            <dt class="label label--muted"><?= e($fact['label']) ?></dt>
                            <dd class="facts__value"><?= e($fact['value']) ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
            <?php endif; ?>
        </div>
    </section>

    <!-- Overview -->
    <section class="section overview" id="overview" aria-labelledby="overview-title">
        <div class="container">
            <div class="grid overview__grid">
                <div class="span-5 overview__text reveal">
                    <p class="label label--muted">Overview</p>
                    <h2 class="h2 overview__title" id="overview-title"><?= e($loc['overview']['title']) ?></h2>
                    <div class="body-copy overview__body">
                        <?php foreach ($loc['overview']['body'] as $paragraph): ?><p><?= e($paragraph) ?></p><?php endforeach; ?>
                    </div>
                </div>
                <?php $overviewSlides = $loc['overview']['slides'] ?? [$loc['slug'] . '.overview']; ?>
                <div class="span-7 start-6 overview__media reveal">
                    <div class="coverflow" data-coverflow role="group" aria-roledescription="carousel" aria-label="Photographs of <?= e(location_name($loc)) ?>">
                        <div class="coverflow__stage">
                            <?php $slideCount = count($overviewSlides);
                            foreach ($overviewSlides as $i => $slot):
                                $pos = $i === 0 ? 0 : ($i === 1 ? 1 : ($i === $slideCount - 1 ? -1 : 2)); ?>
                                <figure class="coverflow__item" data-coverflow-item data-pos="<?= $pos ?>"<?= $pos !== 0 ? ' aria-hidden="true"' : '' ?>>
                                    <?= img($slot, ['ratio' => '4x5', 'sizes' => '(min-width: 960px) 24vw, 60vw']) ?>
                                </figure>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($overviewSlides) > 1): ?>
                            <div class="coverflow__nav">
                                <button class="round-button" type="button" aria-label="Previous photograph" data-coverflow-prev><?= icon('arrow-left') ?></button>
                                <span class="coverflow__count figures" aria-hidden="true"><span data-coverflow-current>01</span> / <?= sprintf('%02d', count($overviewSlides)) ?></span>
                                <button class="round-button" type="button" aria-label="Next photograph" data-coverflow-next><?= icon('arrow-right') ?></button>
                            </div>
                        <?php endif; ?>
                    </div>
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
                'id'    => 'suites-title',
                'intro' => $loc['suites_intro']['text'],
            ]); ?>
            <?php component('apartment-carousel', [
                'suites' => array_values(array_filter(location_suites($loc), static fn ($s) => empty($s['flagship']))),
                'id'     => 'suites-track',
                'label'  => 'Apartments at ' . location_name($loc),
            ]); ?>
        </div>
    </section>

    <?php if (!empty($loc['presidential'])): $p = suite($loc, $loc['presidential']['slug']); ?>
        <section class="presidential surface-mist" aria-labelledby="presidential-title">
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
                            <?php foreach ($p['highlights'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
                        </ul>
                        <div class="actions">
                            <a class="btn" href="<?= e(suite_url($p)) ?>">View the suite</a>
                            <a class="link-arrow" href="<?= e(url('contact') . '?location=' . rawurlencode($loc['slug']) . '&type=reservation#enquiry') ?>">Enquire <?= icon('arrow-right') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- In every suite -->
    <?php if (!empty($loc['suite_features'])): ?>
        <section class="section features surface-navy" aria-labelledby="features-title">
            <div class="hex-pattern hex-pattern--cream features__pattern" aria-hidden="true"></div>
            <div class="container">
                <div class="grid features__grid">
                    <div class="span-4 features__intro reveal">
                        <p class="label label--muted">In every suite</p>
                        <h2 class="h2 features__title" id="features-title">Residential comfort, hotel-grade servicing.</h2>
                        <div class="features__media">
                            <?= img($loc['slug'] . '.detail', ['sizes' => '(min-width: 960px) 28vw, 100vw']) ?>
                        </div>
                    </div>
                    <div class="span-7 start-6 reveal">
                        <ul class="feature-list">
                            <?php foreach ($loc['suite_features'] as $feature): ?>
                                <li><?= icon($feature['icon'], 'icon--s') ?><span><?= e($feature['text']) ?></span></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="actions">
                            <a class="btn btn--cream" href="#booking">Check availability</a>
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
                    'id'    => 'dining-title',
                    'intro' => 'Contemporary Afro-Fusion dining, a discreet VIP Lounge and a relaxed Coffee Shop.',
                ]); ?>
            </div>
            <?php
            $surfaces = ['restaurant' => 'surface-white', 'vip_lounge' => 'surface-mist', 'coffee_shop' => 'surface-cream'];
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
                    'id'    => 'facilities-title',
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
        <div class="hex-pattern hex-pattern--cream corporate-band__pattern" aria-hidden="true"></div>
        <div class="container corporate-band__inner reveal">
            <h2 class="h2 corporate-band__title" id="corporate-title">Corporate advantage</h2>
            <p class="corporate-band__statement"><?= e(site('corporate_advantage')) ?></p>
            <div class="actions">
                <a class="link-arrow" href="<?= e(url('corporate-stays')) ?>">Corporate and extended stays <?= icon('arrow-right') ?></a>
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

<?php endif; ?>
</main>
<?php include INC . '/footer.php'; ?>
