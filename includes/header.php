<?php
$navItems = [
    ['label' => 'About', 'href' => url('about'), 'slug' => 'about'],
    ['label' => 'Corporate Stays', 'href' => url('corporate-stays'), 'slug' => 'corporate-stays'],
    ['label' => 'FAQ', 'href' => url('faq'), 'slug' => 'faq'],
    ['label' => 'Contact', 'href' => url('contact'), 'slug' => 'contact'],
];
$activeSlug = $page['slug'] ?? '';
$navIndex = 0;
?>
<header class="site-header" data-header>
    <div class="site-header__inner container">
        <a class="site-header__logo" href="<?= e(url()) ?>" aria-label="<?= e(SITE_NAME) ?> - home">
            <img src="<?= e(asset(substr(LOGO_GROUP, strlen('assets/')))) ?>" alt="" width="<?= LOGO_GROUP_WIDTH ?>" height="<?= LOGO_GROUP_HEIGHT ?>">
        </a>

        <nav class="site-nav" aria-label="Main">
            <ul class="site-nav__list">
                <li class="site-nav__item site-nav__item--locations">
                    <button class="site-nav__link site-nav__toggle" type="button" aria-expanded="false" aria-controls="locations-panel" data-dropdown-toggle<?= $activeSlug === 'location' ? ' aria-current="true"' : '' ?>>
                        Locations <?= icon('chevron-down', 'icon--xs') ?>
                    </button>
                </li>
                <?php foreach ($navItems as $item): ?>
                    <li class="site-nav__item">
                        <a class="site-nav__link" href="<?= e($item['href']) ?>"<?= $activeSlug === $item['slug'] ? ' aria-current="page"' : '' ?>><?= e($item['label']) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="site-header__actions">
            <button class="btn btn--cream btn--small" type="button" data-open-booking>Book a Stay</button>
            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="mobile-menu" data-menu-toggle>
                <span class="menu-toggle__label">Menu</span>
                <span class="menu-toggle__lines" aria-hidden="true"><span></span><span></span></span>
            </button>
        </div>
    </div>

    <div class="locations-panel" id="locations-panel" hidden data-dropdown-panel>
        <div class="container locations-panel__inner">
            <p class="label locations-panel__label">The Lamora locations</p>
            <ul class="locations-panel__list">
                <?php foreach (locations() as $navLoc): $navIndex++; ?>
                    <li>
                        <a class="locations-panel__link" href="<?= e(location_url($navLoc['slug'])) ?>">
                            <?= hex_index(sprintf('%02d', $navIndex), 'hex-index--cream') ?>
                            <span class="locations-panel__text">
                                <span class="locations-panel__city"><?= e($navLoc['city']) ?></span>
                                <span class="label label--muted"><?= e(status_label($navLoc)) ?></span>
                            </span>
                        </a>
                    </li>
                <?php endforeach; ?>
                <li class="locations-panel__more">
                    <?= hex_index(sprintf('%02d', $navIndex + 1), 'hex-index--cream hex-index--faint') ?>
                    <span class="label label--muted">More Nigerian cities to follow</span>
                </li>
            </ul>
        </div>
    </div>
</header>

<div class="mobile-menu" id="mobile-menu" hidden data-menu>
    <div class="mobile-menu__inner container">
        <p class="label label--muted">Locations</p>
        <ul class="mobile-menu__locations">
            <?php foreach (locations() as $navLoc): ?>
                <li>
                    <a href="<?= e(location_url($navLoc['slug'])) ?>">
                        <span class="mobile-menu__city"><?= e($navLoc['city']) ?></span>
                        <span class="label label--muted"><?= e(status_label($navLoc)) ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <ul class="mobile-menu__links">
            <li><a href="<?= e(url()) ?>">Home</a></li>
            <?php foreach ($navItems as $item): ?>
                <li><a href="<?= e($item['href']) ?>"<?= $activeSlug === $item['slug'] ? ' aria-current="page"' : '' ?>><?= e($item['label']) ?></a></li>
            <?php endforeach; ?>
        </ul>
        <button class="btn btn--cream" type="button" data-open-booking>Book a Stay</button>
    </div>
</div>
