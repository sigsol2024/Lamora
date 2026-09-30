<?php
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'       => '',
    'description' => site('meta_description'),
    'slug'        => 'home',
];

include INC . '/head.php';
include INC . '/header.php';

$locationIndex = 0;
?>
<main id="main">

    <?php component('hero-slider', [
        'slides'  => site('home_slides'),
        'heading' => SITE_NAME . ': luxury serviced apartments in Nigeria',
    ]); ?>

    <div class="hero-strip">
        <div class="container hero-strip__inner">
            <?php foreach (locations() as $loc): ?>
                <a class="hero-strip__item" href="<?= e(location_url($loc['slug'])) ?>"><?= e($loc['city']) ?></a>
            <?php endforeach; ?>
            <span class="hero-strip__item hero-strip__item--muted">More cities to follow</span>
        </div>
    </div>

    <!-- The Lamora promise -->
    <section class="section promise" aria-labelledby="promise-title">
        <div class="container">
            <div class="grid">
                <div class="span-7 reveal">
                    <p class="label label--muted">The Lamora</p>
                    <h2 class="display promise__title" id="promise-title"><?= e(copy_line('promise_title')) ?></h2>
                </div>
                <div class="span-4 start-9 align-end reveal">
                    <p class="lead promise__text"><?= e(copy_line('promise')) ?></p>
                    <div class="actions">
                        <a class="link-arrow" href="<?= e(url('about')) ?>">About The Lamora <?= icon('arrow-right') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured apartments -->
    <?php $featured = featured_suites(); if ($featured): ?>
        <section class="section section--flush-top featured" id="featured" aria-labelledby="featured-title">
            <div class="container">
                <?php component('section-heading', [
                    'label' => 'Featured apartments',
                    'title' => site('featured_intro.title'),
                    'intro' => site('featured_intro.text'),
                    'split' => true,
                    'id'    => 'featured-title',
                ]); ?>
                <?php component('apartment-carousel', [
                    'suites' => $featured,
                    'id'     => 'featured-track',
                    'label'  => 'Featured apartments',
                ]); ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Locations -->
    <section class="section surface-mist locations" id="locations" aria-labelledby="locations-title">
        <div class="hex-pattern locations__pattern" aria-hidden="true"></div>
        <div class="container locations__inner">
            <?php component('section-heading', [
                'label' => 'Locations',
                'title' => 'Our locations',
                'id'    => 'locations-title',
                'intro' => 'Every Lamora location follows the same standard of privacy, space and service. Lagos opens first, with Abuja and further Nigerian cities to follow.',
                'split' => true,
            ]); ?>

            <div class="location-grid">
                <?php foreach (locations() as $loc): $locationIndex++; ?>
                    <?php component('location-card', ['loc' => $loc, 'index' => $locationIndex]); ?>
                <?php endforeach; ?>
                <?php component('location-card', ['loc' => null, 'index' => $locationIndex + 1]); ?>
            </div>
        </div>
    </section>

    <!-- One address across the day -->
    <section class="section day" aria-labelledby="day-title">
        <div class="container">
            <?php component('section-heading', [
                'label' => 'One address across the day',
                'title' => copy_line('day_title'),
                'id'    => 'day-title',
                'split' => true,
            ]); ?>
            <?php component('day-strip', ['steps' => site('day')]); ?>
            <p class="small muted day__note reveal">Facilities vary by location. Each location page lists its own.</p>
        </div>
    </section>

    <!-- Ways to stay -->
    <section class="ways surface-cream" aria-labelledby="ways-title">
        <div class="container">
            <div class="grid ways__grid">
                <div class="span-5 bleed-left ways__media reveal">
                    <?= img('home.ways', ['ratio' => '4x5', 'sizes' => '(min-width: 960px) 40vw, 100vw']) ?>
                </div>
                <div class="span-6 start-7 ways__text">
                    <div class="reveal">
                        <p class="label label--muted">Ways to stay</p>
                        <h2 class="h2 ways__title" id="ways-title"><?= e(copy_line('ways_title')) ?></h2>
                    </div>

                    <dl class="rows ways__profiles reveal">
                        <?php foreach (site('stay_profiles') as $profile): ?>
                            <div>
                                <dt class="h4"><?= e($profile['name']) ?></dt>
                                <dd class="small muted"><?= e($profile['text']) ?></dd>
                            </div>
                        <?php endforeach; ?>
                    </dl>

                    <div class="reveal">
                        <p class="label label--muted ways__audience-label">Who The Lamora is for</p>
                        <p class="ways__audience-title"><?= e(copy_line('audience_title')) ?></p>
                        <ul class="ways__audiences small">
                            <?php foreach (site('audiences') as $audience): ?>
                                <li><?= e($audience) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="actions">
                            <a class="link-arrow" href="<?= e(url('corporate-stays')) ?>">Corporate and extended stays <?= icon('arrow-right') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php component('service-code'); ?>

    <?php component('cta-band', [
        'label' => 'Plan your stay',
        'title' => 'Choose a location to check availability.',
        'text'  => 'For corporate, group and extended stays, please contact our reservations team.',
    ]); ?>

</main>
<?php include INC . '/footer.php'; ?>
