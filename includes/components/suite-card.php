<?php
/**
 * @var array $suite name, image, guests, units, role, ideal_for
 */
?>
<article class="suite-card reveal">
    <?= img($suite['image'], ['ratio' => '3x2', 'sizes' => '(min-width: 768px) 45vw, 100vw']) ?>
    <div class="suite-card__body">
        <h3 class="h3"><?= e($suite['name']) ?></h3>
        <p class="suite-card__meta label figures">
            <span>Up to <?= (int) $suite['guests'] ?> guests</span>
            <span><?= (int) $suite['units'] ?> suites</span>
        </p>
        <p><?= e($suite['role']) ?></p>
        <?php if (!empty($suite['ideal_for'])): ?>
            <p class="suite-card__ideal small">Ideal for <?= e(lcfirst($suite['ideal_for'])) ?></p>
        <?php endif; ?>
    </div>
</article>
