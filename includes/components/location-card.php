<?php
/**
 * Location card. Every location uses the same structure and size; only the status
 * differs. Coming-soon locations and the "more cities" tile show a blurred
 * photograph labelled "Coming soon".
 *
 * @var array|null $loc    Location data, or null for the "more cities" tile.
 * @var int        $index
 */
$number = sprintf('%02d', $index);
$soon   = $loc === null || ($loc['status'] ?? '') === 'coming-soon';
$slot   = $loc === null ? 'home.more-cities' : $loc['slug'] . '.card';
?>
<article class="location-card reveal<?= $soon ? ' location-card--soon' : '' ?>">
    <div class="location-card__visual"<?= $soon ? ' aria-hidden="true"' : '' ?>>
        <?= img($slot, ['sizes' => '(min-width: 960px) 30vw, 100vw']) ?>
        <?php if ($soon): ?><span class="location-card__soon">Coming soon</span><?php endif; ?>
    </div>
    <div class="location-card__body">
        <?php if ($loc === null): ?>
            <?= hex_index($number, 'hex-index--solid') ?>
            <h3 class="location-card__city">More cities</h3>
            <p class="label location-card__meta">To follow across Nigeria</p>
        <?php else: ?>
            <?= hex_index($number, 'hex-index--solid') ?>
            <h3 class="location-card__city"><a href="<?= e(location_url($loc['slug'])) ?>"><?= e($loc['city']) ?></a></h3>
            <p class="label location-card__meta"><?= e(!$soon && ($loc['district'] ?? '') !== '' ? $loc['district'] . ' / ' . status_label($loc) : status_label($loc)) ?></p>
        <?php endif; ?>
    </div>
</article>
