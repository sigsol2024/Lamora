<?php
/**
 * Hero for inner pages (the homepage uses hero-slider).
 *   split : White text column with an image bleeding to the right edge.
 *   plain : typographic header on a soft grey field with a faint hexagon accent.
 *
 * @var string      $variant
 * @var string      $label
 * @var string      $title
 * @var string|null $lead
 * @var string|null $image    Image slot (split).
 * @var string|null $status   Small status line (split).
 * @var array|null  $actions  [['label', 'href', 'style' => 'primary'|'link', 'attrs' => []]]
 * @var string|null $title_class  Defaults to h1.
 * @var string|null $tone     'navy' (split): Navy field, Cream title, and the
 *                            photograph filling the right side, fading into the
 *                            Navy on its left, its left edge closing into a
 *                            hexagon point on load.
 * @var bool|null   $reverse  Navy tone only: photograph on the left, text on the
 *                            right on desktop (mobile is unchanged).
 * @var array|null  $slides   Navy tone only: image slots shown as a crossfading
 *                            slider inside the same hexagon frame, with
 *                            previous/next controls on the photograph.
 * @var bool|null   $fit      Fill the screen below the header on desktop.
 */
$variant = $variant ?? 'plain';
$actions = $actions ?? [];
$lead    = $lead ?? null;
$status  = $status ?? null;
$navy    = ($tone ?? null) === 'navy';
$reverse = $navy && !empty($reverse);
$slides  = $navy && !empty($slides) && count($slides) > 1 ? array_values($slides) : [];
$fit     = !empty($fit) || $reverse;

if ($reverse) {
    $textCols  = 'span-5 start-8 row-1';
    $mediaCols = 'span-7 start-1 row-1 bleed-left hero-split__media--hex';
} elseif ($navy) {
    $textCols  = 'span-5';
    $mediaCols = 'span-7 start-6 bleed-right hero-split__media--hex';
} else {
    $textCols  = 'span-5';
    $mediaCols = 'span-6 start-7 bleed-right';
}

$renderActions = static function (array $actions) use ($navy): void {
    if (!$actions) {
        return;
    }
    $btn = $navy ? 'btn btn--cream' : 'btn';
    echo '<div class="actions">';
    foreach ($actions as $action) {
        $extra = attrs($action['attrs'] ?? []);
        if (($action['style'] ?? 'primary') === 'link') {
            printf('<a class="link-arrow" href="%s"%s>%s %s</a>', e($action['href']), $extra, e($action['label']), icon('arrow-right'));
        } elseif (!empty($action['button'])) {
            printf('<button class="%s" type="button"%s>%s</button>', $btn, $extra, e($action['label']));
        } else {
            printf('<a class="%s" href="%s"%s>%s</a>', $btn, e($action['href']), $extra, e($action['label']));
        }
    }
    echo '</div>';
};
?>
<?php if ($variant === 'split'): ?>
    <section class="hero-split<?= $navy ? ' hero-split--navy surface-navy' : '' ?><?= $reverse ? ' hero-split--reverse' : '' ?><?= $fit ? ' hero-split--fit' : '' ?>" aria-labelledby="hero-title">
        <?php if ($navy): ?><div class="hex-pattern hex-pattern--cream hero-split__pattern" aria-hidden="true"></div><?php endif; ?>
        <div class="container">
            <div class="grid hero-split__grid">
                <div class="hero-split__text <?= $textCols ?>">
                    <p class="label label--muted"><?= e($label) ?></p>
                    <h1 class="<?= e($title_class ?? 'h1') ?>" id="hero-title"><?= e($title) ?></h1>
                    <?php if ($lead): ?><p class="lead"><?= e($lead) ?></p><?php endif; ?>
                    <?php if ($status): ?><p class="label hero-split__status"><?= e($status) ?></p><?php endif; ?>
                    <?php $renderActions($actions); ?>
                </div>
                <?php if ($slides): $count = count($slides); ?>
                    <div class="hero-split__media <?= $mediaCols ?>" data-hero-slides>
                        <div class="media hero-slides" role="group" aria-roledescription="carousel" aria-label="Photographs">
                            <?php foreach ($slides as $i => $slot): ?>
                                <div class="hero-slides__slide<?= $i === 0 ? ' is-active' : '' ?>" role="group" aria-roledescription="slide" aria-label="<?= $i + 1 ?> of <?= $count ?>"<?= $i === 0 ? '' : ' aria-hidden="true"' ?> data-hero-slide>
                                    <?= img($slot, ['priority' => $i === 0, 'sizes' => '(min-width: 960px) 60vw, 100vw']) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="hero-slides__nav">
                            <span class="hero-slides__count figures" aria-hidden="true"><span data-hero-current>01</span> / <?= sprintf('%02d', $count) ?></span>
                            <button class="round-button round-button--light" type="button" aria-label="Previous photograph" data-hero-prev><?= icon('arrow-left') ?></button>
                            <button class="round-button round-button--light" type="button" aria-label="Next photograph" data-hero-next><?= icon('arrow-right') ?></button>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="hero-split__media <?= $mediaCols ?>">
                        <?= img($image, ['priority' => true, 'sizes' => $navy ? '(min-width: 960px) 60vw, 100vw' : '(min-width: 960px) 55vw, 100vw']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php else: ?>
    <section class="hero-plain surface-mist" aria-labelledby="hero-title">
        <div class="hex-pattern" aria-hidden="true"></div>
        <div class="container hero-plain__inner">
            <p class="label label--muted"><?= e($label) ?></p>
            <h1 class="<?= e($title_class ?? 'h1') ?>" id="hero-title"><?= e($title) ?></h1>
            <?php if ($lead): ?><p class="lead"><?= e($lead) ?></p><?php endif; ?>
            <?php $renderActions($actions); ?>
        </div>
    </section>
<?php endif; ?>
