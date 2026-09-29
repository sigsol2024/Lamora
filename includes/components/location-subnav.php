<?php
/**
 * Sticky secondary navigation for a location page, with a location switcher.
 *
 * @var array $loc
 * @var array $links [['id', 'label']]
 */
?>
<nav class="subnav" aria-label="<?= e(location_name($loc)) ?>">
    <div class="container subnav__inner">
        <p class="subnav__name"><?= e(location_name($loc)) ?></p>

        <div class="subnav__links" data-subnav>
            <?php foreach ($links as $link): ?>
                <a href="#<?= e($link['id']) ?>"><?= e($link['label']) ?></a>
            <?php endforeach; ?>
        </div>

        <div class="subnav__actions">
            <div class="switcher" data-switcher>
                <button class="switcher__button" type="button" aria-expanded="false" aria-controls="switcher-list" data-switcher-toggle>
                    Switch location <?= icon('chevron-down', 'icon--xs') ?>
                </button>
                <div class="switcher__list" id="switcher-list" hidden data-switcher-list>
                    <?php foreach (locations() as $option): ?>
                        <a href="<?= e(location_url($option['slug'])) ?>"<?= $option['slug'] === $loc['slug'] ? ' aria-current="page"' : '' ?>>
                            <span class="switcher__city"><?= e($option['city']) ?></span>
                            <span class="label label--muted"><?= e(status_label($option)) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php if (is_bookable($loc)): ?>
                <a class="btn btn--small" href="<?= e(booking_url($loc)) ?>">Check availability</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
