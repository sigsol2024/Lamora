<?php
/**
 * Group logo: the hexagonal monogram beside "The Lamora" set in the display face,
 * echoing the stacked THE / LAMORA arrangement of the master lockup.
 *
 * @var string $class Extra classes (for example site-header__logo).
 */
?>
<a class="logo <?= e($class ?? '') ?>" href="<?= e(url()) ?>" aria-label="<?= e(SITE_NAME) ?> - home">
    <img class="logo__mark" src="<?= e(asset(substr(LOGO_GROUP, strlen('assets/')))) ?>" alt="" width="<?= LOGO_GROUP_WIDTH ?>" height="<?= LOGO_GROUP_HEIGHT ?>">
    <span class="logo__type" aria-hidden="true">
        <span class="logo__the">The</span>
        <span class="logo__name">Lamora</span>
    </span>
</a>
