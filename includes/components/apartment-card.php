<?php
/**
 * Apartment card: image with the location on it, then title and the key figures.
 * The whole card links to the suite page.
 *
 * @var array $suite A suite from location_suites().
 */
$cardLoc = location($suite['location']);
$place   = trim(($cardLoc['district'] ?? '') . ', ' . ($cardLoc['city'] ?? ''), ', ');
?>
<article class="apartment-card">
    <div class="apartment-card__visual">
        <?= img($suite['image'], ['sizes' => '(min-width: 1100px) 30vw, (min-width: 640px) 45vw, 85vw']) ?>
        <p class="apartment-card__place"><?= icon('map-pin', 'icon--xs') ?><span><?= e($place) ?></span></p>
    </div>
    <div class="apartment-card__body">
        <p class="label label--muted"><?= e(location_name($cardLoc)) ?></p>
        <h3 class="apartment-card__title"><a href="<?= e(suite_url($suite)) ?>"><?= e($suite['name']) ?></a></h3>
        <ul class="apartment-card__meta" aria-label="Key details">
            <li><?= icon('users', 'icon--s') ?>Up to <?= (int) $suite['guests'] ?> guests</li>
            <li><?= icon('bed', 'icon--s') ?><?= e(bedroom_label((int) ($suite['bedrooms'] ?? 0))) ?></li>
            <?php if (!empty($suite['size'])): ?>
                <li><?= icon('door', 'icon--s') ?><?= (int) $suite['size'] ?> m²</li>
            <?php endif; ?>
        </ul>
        <span class="link-arrow apartment-card__more" aria-hidden="true">View suite <?= icon('arrow-right') ?></span>
    </div>
</article>
