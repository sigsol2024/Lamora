<?php
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'       => 'About',
    'description' => 'About The Lamora: private, design-led luxury apartment hospitality across Nigeria.',
    'slug'        => 'about',
];

include INC . '/head.php';
include INC . '/header.php';

$values = site('values');
?>
<main id="main">

    <?php component('hero', [
        'variant' => 'split',
        'image'   => 'about.hero',
        'label'   => 'About',
        'title'   => SITE_NAME,
        'lead'    => site('positioning.text'),
        'actions' => [
            ['label' => 'Our locations', 'href' => url() . '#locations'],
            ['label' => 'Contact us', 'href' => url('contact'), 'style' => 'link'],
        ],
    ]); ?>

    <!-- Positioning -->
    <section class="section positioning" aria-labelledby="positioning-title">
        <div class="container">
            <div class="grid">
                <div class="span-7 reveal">
                    <p class="label label--muted">Our position</p>
                    <h2 class="display positioning__title" id="positioning-title"><?= e(copy_line('personal')) ?></h2>
                </div>
                <div class="span-4 start-9 align-end reveal">
                    <p class="lead"><?= e(site('positioning.detail')) ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision and mission -->
    <section class="section surface-navy purpose" aria-label="Vision and mission">
        <div class="hex-pattern hex-pattern--cream purpose__pattern" aria-hidden="true"></div>
        <div class="container purpose__inner">
            <div class="grid">
                <?php foreach (['vision' => 'Vision', 'mission' => 'Mission'] as $key => $label): ?>
                    <article class="span-5 <?= $key === 'mission' ? 'start-8' : '' ?> purpose__item reveal">
                        <p class="label label--muted"><?= e($label) ?></p>
                        <h2 class="h3 purpose__title"><?= e(site($key . '.title')) ?></h2>
                        <p class="muted"><?= e(site($key . '.text')) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="section values" aria-labelledby="values-title">
        <div class="container">
            <?php component('section-heading', [
                'label' => 'Our values',
                'title' => 'What we stand for.',
                'split' => true,
                'intro' => 'Six values shape how we host, whichever city you stay in.',
            ]); ?>
            <ol class="values__list">
                <?php foreach ($values as $i => $value): ?>
                    <li class="values__item reveal">
                        <?= hex_index(sprintf('%02d', $i + 1)) ?>
                        <h3 class="h4"><?= e($value['name']) ?></h3>
                        <p class="small muted"><?= e($value['text']) ?></p>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>

    <!-- Service attributes and personality -->
    <section class="section surface-cream attributes" aria-labelledby="attributes-title">
        <div class="container">
            <div class="grid">
                <div class="span-4 reveal">
                    <p class="label label--muted">Our service</p>
                    <h2 class="h2 attributes__title" id="attributes-title">How we deliver our service.</h2>
                </div>
                <ul class="span-7 start-6 rows attributes__list">
                    <?php foreach (site('service_attributes') as $attribute): ?>
                        <li class="reveal">
                            <h3 class="h4"><?= e($attribute['name']) ?></h3>
                            <p class="small muted"><?= e($attribute['text']) ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="grid personality reveal">
                <p class="span-4 label label--muted personality__label">Our personality</p>
                <ul class="span-7 start-6 personality__list">
                    <?php foreach (site('personality') as $trait): ?><li><?= e($trait) ?></li><?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <?php component('service-code'); ?>

    <!-- Locations index -->
    <section class="section section--flush-top location-index-section" aria-labelledby="index-title">
        <div class="container">
            <div class="grid">
                <div class="span-4 reveal">
                    <p class="label label--muted">Locations</p>
                    <h2 class="h2" id="index-title">One standard, city by city.</h2>
                </div>
                <ol class="span-7 start-6 location-index">
                    <?php $n = 0; foreach (locations() as $loc): $n++; ?>
                        <li class="reveal">
                            <a class="location-index__link" href="<?= e(location_url($loc['slug'])) ?>">
                                <?= hex_index(sprintf('%02d', $n)) ?>
                                <span class="location-index__city"><?= e($loc['city']) ?></span>
                                <span class="label label--muted"><?= e(status_label($loc)) ?></span>
                                <?= icon('arrow-right') ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    <li class="location-index__more reveal">
                        <?= hex_index(sprintf('%02d', $n + 1), 'hex-index--faint') ?>
                        <span class="location-index__city muted">More Nigerian cities to follow</span>
                    </li>
                </ol>
            </div>
        </div>
    </section>

    <?php component('cta-band', [
        'label' => 'Plan your stay',
        'title' => 'Choose a location to check availability.',
        'text'  => 'For corporate, group and extended stays, please contact our reservations team.',
    ]); ?>

</main>
<?php include INC . '/footer.php'; ?>
