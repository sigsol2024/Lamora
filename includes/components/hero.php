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
 */
$variant = $variant ?? 'plain';
$actions = $actions ?? [];
$lead    = $lead ?? null;
$status  = $status ?? null;

$renderActions = static function (array $actions): void {
    if (!$actions) {
        return;
    }
    echo '<div class="actions">';
    foreach ($actions as $action) {
        $extra = attrs($action['attrs'] ?? []);
        if (($action['style'] ?? 'primary') === 'link') {
            printf('<a class="link-arrow" href="%s"%s>%s %s</a>', e($action['href']), $extra, e($action['label']), icon('arrow-right'));
        } elseif (!empty($action['button'])) {
            printf('<button class="btn" type="button"%s>%s</button>', $extra, e($action['label']));
        } else {
            printf('<a class="btn" href="%s"%s>%s</a>', e($action['href']), $extra, e($action['label']));
        }
    }
    echo '</div>';
};
?>
<?php if ($variant === 'split'): ?>
    <section class="hero-split" aria-labelledby="hero-title">
        <div class="container">
            <div class="grid hero-split__grid">
                <div class="hero-split__text span-5">
                    <p class="label label--muted"><?= e($label) ?></p>
                    <h1 class="<?= e($title_class ?? 'h1') ?>" id="hero-title"><?= e($title) ?></h1>
                    <?php if ($lead): ?><p class="lead"><?= e($lead) ?></p><?php endif; ?>
                    <?php if ($status): ?><p class="label hero-split__status"><?= e($status) ?></p><?php endif; ?>
                    <?php $renderActions($actions); ?>
                </div>
                <div class="hero-split__media span-6 start-7 bleed-right">
                    <?= img($image, ['priority' => true, 'sizes' => '(min-width: 960px) 55vw, 100vw']) ?>
                </div>
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
