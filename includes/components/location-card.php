<?php
/**
 * Location card. Every location uses the same structure and size; only the status
 * differs. Coming-soon locations show a Cream field with the hexagon pattern and no
 * photography.
 *
 * @var array|null $loc    Location data, or null for the "more cities" tile.
 * @var int        $index
 */
$number = sprintf('%02d', $index);
$hexMark = '<svg class="location-card__visual-mark" viewBox="0 0 44 50" aria-hidden="true"><path d="M22 1.5 42.5 13.25v23.5L22 48.5 1.5 36.75v-23.5Z"/></svg>';
?>
<article class="location-card reveal">
    <?php if ($loc === null): ?>
        <div class="location-card__visual location-card__visual--outline" aria-hidden="true"><?= $hexMark ?></div>
        <div class="location-card__body">
            <?= hex_index($number, 'hex-index--cream hex-index--faint') ?>
            <h3 class="location-card__city">More cities</h3>
            <p class="label location-card__meta">To follow across Nigeria</p>
        </div>

    <?php elseif (($loc['status'] ?? '') === 'coming-soon'): ?>
        <div class="location-card__visual location-card__visual--cream" aria-hidden="true">
            <div class="hex-pattern"></div>
            <?= $hexMark ?>
        </div>
        <div class="location-card__body">
            <?= hex_index($number, 'hex-index--cream') ?>
            <h3 class="location-card__city"><a href="<?= e(location_url($loc['slug'])) ?>"><?= e($loc['city']) ?></a></h3>
            <p class="label location-card__meta"><?= e(status_label($loc)) ?></p>
        </div>

    <?php else: ?>
        <div class="location-card__visual">
            <?= img($loc['slug'] . '.card', ['sizes' => '(min-width: 960px) 30vw, 100vw']) ?>
        </div>
        <div class="location-card__body">
            <?= hex_index($number, 'hex-index--cream') ?>
            <h3 class="location-card__city"><a href="<?= e(location_url($loc['slug'])) ?>"><?= e($loc['city']) ?></a></h3>
            <p class="label location-card__meta"><?= e(($loc['district'] ?? '') !== '' ? $loc['district'] . ' / ' . status_label($loc) : status_label($loc)) ?></p>
        </div>
    <?php endif; ?>
</article>
