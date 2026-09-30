<?php
require __DIR__ . '/includes/bootstrap.php';

$loc   = location(query('location'));
$suite = $loc ? suite($loc, query('suite')) : null;
if ($suite === null) {
    require __DIR__ . '/404.php';
    exit;
}

$page = [
    'title'       => $suite['name'] . ' - ' . location_name($loc),
    'description' => $suite['role'],
    'slug'        => 'suite',
    'body_class'  => 'has-booking-bar',
];

$gallery = array_values(array_filter($suite['gallery'] ?? [$suite['image']], fn(string $slot) => img_data($slot) !== null));
$others  = array_values(array_filter(location_suites($loc), fn(array $s) => $s['slug'] !== $suite['slug']));
$enquire = url('contact') . '?location=' . rawurlencode($loc['slug']) . '&type=reservation&suite=' . rawurlencode($suite['slug']) . '#enquiry';
$place   = trim(($loc['district'] ?? '') . ', ' . $loc['city'], ', ');

$policy = static function (string $label) use ($loc): ?string {
    foreach ($loc['policies'] ?? [] as $item) {
        if ($item['label'] === $label) {
            return rtrim($item['text'], '.');
        }
    }
    return null;
};

$glance = array_filter([
    'Guests'              => 'Up to ' . (int) $suite['guests'],
    'Bedrooms'            => bedroom_label((int) ($suite['bedrooms'] ?? 0)),
    'Size'                => !empty($suite['size']) ? (int) $suite['size'] . ' m²' : null,
    'Suites of this type' => (string) (int) $suite['units'],
    'Check-in'            => $policy('Check-in'),
    'Check-out'           => $policy('Check-out'),
]);

include INC . '/head.php';
include INC . '/header.php';
?>
<main id="main">

    <section class="suite-hero" aria-labelledby="suite-title">
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <ol>
                    <li><a href="<?= e(url()) ?>">Home</a></li>
                    <li><a href="<?= e(location_url($loc['slug'])) ?>"><?= e(location_name($loc)) ?></a></li>
                    <li><a href="<?= e(location_url($loc['slug'], 'suites')) ?>">Suites</a></li>
                    <li aria-current="page"><?= e($suite['name']) ?></li>
                </ol>
            </nav>

            <div class="suite-hero__head">
                <div>
                    <p class="label label--muted"><?= e(location_name($loc)) ?> · <?= e($place) ?></p>
                    <h1 class="h1 suite-hero__title" id="suite-title"><?= e($suite['name']) ?></h1>
                    <ul class="suite-meta" aria-label="Key details">
                        <li><?= icon('users', 'icon--s') ?>Up to <?= (int) $suite['guests'] ?> guests</li>
                        <li><?= icon('bed', 'icon--s') ?><?= e(bedroom_label((int) ($suite['bedrooms'] ?? 0))) ?></li>
                        <?php if (!empty($suite['size'])): ?>
                            <li><?= icon('door', 'icon--s') ?><?= (int) $suite['size'] ?> m²</li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="actions suite-hero__actions">
                    <a class="btn" href="<?= e(booking_url($loc)) ?>">Check availability</a>
                    <a class="link-arrow" href="<?= e($enquire) ?>">Enquire <?= icon('arrow-right') ?></a>
                </div>
            </div>
        </div>

        <?php if ($gallery): ?>
            <div class="container">
                <div class="suite-gallery" data-gallery='<?= e(json_encode(array_map('img_data', $gallery), JSON_UNESCAPED_SLASHES)) ?>'>
                    <?php foreach ($gallery as $i => $slot): $photo = img_data($slot); ?>
                        <a class="suite-gallery__item" href="<?= e($photo['src']) ?>" data-gallery-open="<?= $i ?>">
                            <?= img($slot, [
                                'priority' => $i === 0,
                                'sizes'    => $i === 0 ? '(min-width: 768px) 50vw, 86vw' : '(min-width: 768px) 25vw, 86vw',
                            ]) ?>
                            <span class="visually-hidden">Open photo <?= $i + 1 ?> of <?= count($gallery) ?></span>
                        </a>
                    <?php endforeach; ?>
                    <?php if (count($gallery) > 1): ?>
                        <button class="suite-gallery__all" type="button" data-gallery-open="0" hidden>
                            <?= icon('grid', 'icon--s') ?>View all <?= count($gallery) ?> photos
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <section class="section suite-detail" aria-labelledby="suite-overview-title">
        <div class="container">
            <div class="grid">
                <div class="span-7 suite-detail__main">
                    <div class="reveal">
                        <h2 class="label label--muted" id="suite-overview-title">Overview</h2>
                        <p class="lead suite-detail__role"><?= e($suite['role']) ?></p>
                        <div class="body-copy suite-detail__body">
                            <?php foreach ($suite['description'] ?? [] as $paragraph): ?><p><?= e($paragraph) ?></p><?php endforeach; ?>
                        </div>
                    </div>

                    <?php if (!empty($suite['layout'])): ?>
                        <div class="suite-detail__block reveal">
                            <h2 class="h3">The layout</h2>
                            <ul class="rows suite-detail__layout">
                                <?php foreach ($suite['layout'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
                            </ul>
                            <p class="small muted suite-detail__note">Typical configuration, subject to final unit design.</p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($loc['suite_features'])): ?>
                        <div class="suite-detail__block reveal">
                            <h2 class="h3">In every suite</h2>
                            <ul class="feature-list suite-detail__features">
                                <?php foreach ($loc['suite_features'] as $feature): ?>
                                    <li><?= icon($feature['icon'], 'icon--s') ?><span><?= e($feature['text']) ?></span></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($suite['ideal_for'])): ?>
                        <div class="suite-detail__block reveal">
                            <h2 class="h3">Ideal for</h2>
                            <ul class="tag-list">
                                <?php foreach ($suite['ideal_for'] as $guest): ?><li><?= e($guest) ?></li><?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>

                <aside class="span-4 start-9 suite-aside" aria-labelledby="suite-glance-title">
                    <div class="suite-aside__card">
                        <h2 class="label label--muted" id="suite-glance-title">At a glance</h2>
                        <dl class="suite-aside__facts">
                            <?php foreach ($glance as $label => $value): ?>
                                <div><dt><?= e($label) ?></dt><dd class="figures"><?= e($value) ?></dd></div>
                            <?php endforeach; ?>
                        </dl>
                        <a class="btn btn--block" href="<?= e(booking_url($loc)) ?>">Check availability</a>
                        <a class="link-arrow suite-aside__enquire" href="<?= e($enquire) ?>">Enquire about this suite <?= icon('arrow-right') ?></a>
                        <p class="small muted suite-aside__status"><?= e(status_label($loc)) ?><?php if (!empty($loc['contact']['phone'])): ?>. Reservations <a class="text-link" href="tel:<?= e($loc['contact']['phone_uri']) ?>"><?= e($loc['contact']['phone']) ?></a><?php endif; ?></p>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <?php if ($others): ?>
        <section class="section section--flush-top suite-others" aria-labelledby="others-title">
            <div class="container">
                <?php component('section-heading', [
                    'label' => 'The apartment collection',
                    'title' => 'More suites at ' . location_name($loc) . '.',
                    'id'    => 'others-title',
                    'split' => true,
                    'intro' => $loc['suites_intro']['text'] ?? null,
                ]); ?>
                <?php component('apartment-carousel', [
                    'suites' => $others,
                    'id'     => 'other-suites',
                    'label'  => 'More suites at ' . location_name($loc),
                ]); ?>
            </div>
        </section>
    <?php endif; ?>

    <?php component('cta-band', [
        'label' => 'Reservations',
        'title' => 'Reserve the ' . $suite['name'] . '.',
        'text'  => status_label($loc) . '. Speak to our reservations team about nightly, weekly and extended stays.',
        'loc'   => $loc,
    ]); ?>

    <div class="booking-bar" aria-label="Book the <?= e($suite['name']) ?>">
        <div class="booking-bar__text">
            <span class="booking-bar__city"><?= e($suite['name']) ?></span>
            <span class="label label--muted"><?= e(location_name($loc)) ?></span>
        </div>
        <a class="btn btn--small" href="<?= e(booking_url($loc)) ?>">Check availability</a>
    </div>

    <?php if (count($gallery) > 1): ?>
        <dialog class="lightbox" aria-label="Photos of the <?= e($suite['name']) ?>" data-lightbox>
            <div class="lightbox__bar">
                <p class="label lightbox__count" data-lightbox-count></p>
                <button class="lightbox__close" type="button" aria-label="Close photos" data-lightbox-close><?= icon('close') ?></button>
            </div>
            <figure class="lightbox__figure">
                <img alt="" data-lightbox-image>
                <figcaption class="small muted lightbox__caption" data-lightbox-caption></figcaption>
            </figure>
            <button class="round-button lightbox__prev" type="button" aria-label="Previous photo" data-lightbox-prev><?= icon('arrow-left', 'icon--s') ?></button>
            <button class="round-button lightbox__next" type="button" aria-label="Next photo" data-lightbox-next><?= icon('arrow-right', 'icon--s') ?></button>
        </dialog>
    <?php endif; ?>

</main>
<?php include INC . '/footer.php'; ?>
