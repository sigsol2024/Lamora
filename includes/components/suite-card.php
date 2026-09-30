<?php
/**
 * @var array $suite A suite from location_suites(): name, image, guests, units, role, ideal_for
 */
?>
<article class="suite-card reveal">
    <?= img($suite['image'], ['ratio' => '3x2', 'sizes' => '(min-width: 768px) 45vw, 100vw']) ?>
    <div class="suite-card__body">
        <h3 class="h3"><a class="suite-card__link" href="<?= e(suite_url($suite)) ?>"><?= e($suite['name']) ?></a></h3>
        <p class="suite-card__meta label figures">
            <span>Up to <?= (int) $suite['guests'] ?> guests</span>
            <span><?= e(bedroom_label((int) ($suite['bedrooms'] ?? 0))) ?></span>
            <span><?= (int) $suite['units'] ?> suites</span>
        </p>
        <p><?= e($suite['role']) ?></p>
        <?php if (!empty($suite['ideal_for'])): ?>
            <p class="suite-card__ideal small">Ideal for <?= e(lcfirst(implode(', ', array_slice($suite['ideal_for'], 0, 4)))) ?>.</p>
        <?php endif; ?>
        <span class="link-arrow suite-card__more" aria-hidden="true">View suite <?= icon('arrow-right') ?></span>
    </div>
</article>
