<?php
/**
 * Navy booking band.
 *   Group pages: a location selector posting to /book.
 *   Location pages: pass $loc for a direct "Check availability" and contact details.
 *
 * @var string      $label
 * @var string      $title
 * @var string|null $text
 * @var array|null  $loc
 */
$loc  = $loc ?? null;
$text = $text ?? null;
?>
<section class="cta-band surface-navy section--sm" aria-labelledby="cta-title">
    <div class="container">
        <div class="grid cta-band__grid">
            <div class="span-6 reveal">
                <p class="label label--muted"><?= e($label) ?></p>
                <h2 class="h2 cta-band__title" id="cta-title"><?= e($title) ?></h2>
                <?php if ($text): ?><p class="muted cta-band__text"><?= e($text) ?></p><?php endif; ?>
            </div>

            <div class="span-5 start-8 reveal">
                <?php if ($loc): ?>
                    <a class="btn btn--cream" href="<?= e(booking_url($loc)) ?>">Check availability</a>
                    <?php if (!empty($loc['contact'])): ?>
                        <div class="cta-band__contact">
                            <?php if (!empty($loc['contact']['phone'])): ?>
                                <a href="tel:<?= e($loc['contact']['phone_uri']) ?>"><?= e($loc['contact']['phone']) ?></a>
                            <?php endif; ?>
                            <?php if (!empty($loc['contact']['email'])): ?>
                                <a href="mailto:<?= e($loc['contact']['email']) ?>"><?= e($loc['contact']['email']) ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <form class="cta-band__form" action="<?= e(url('book')) ?>" method="get">
                        <label class="field">
                            <span>Location</span>
                            <select class="select" name="location">
                                <?php foreach (locations() as $option): ?>
                                    <option value="<?= e($option['slug']) ?>"><?= e($option['city']) ?><?= is_bookable($option) ? '' : ' (coming soon, register interest)' ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <button class="btn btn--cream" type="submit">Check availability</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
