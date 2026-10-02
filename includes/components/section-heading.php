<?php
/**
 * @var string      $label  Small tracked label above the title.
 * @var string      $title
 * @var string|null $intro
 * @var bool|null   $split  Title left, intro hanging on the right.
 * @var bool|null   $center Label, title and intro stacked and centred.
 * @var string|null $tag    Heading element (default h2).
 * @var string|null $size   Heading class (default h2).
 * @var string|null $id     Heading id, for the section's aria-labelledby.
 */
$tag    = $tag ?? 'h2';
$size   = $size ?? 'h2';
$split  = $split ?? false;
$center = $center ?? false;
?>
<header class="section-head<?= $split ? ' section-head--split' : '' ?><?= $center ? ' section-head--center' : '' ?> reveal">
    <div class="section-head__main">
        <?php if (!empty($label)): ?><p class="label label--muted"><?= e($label) ?></p><?php endif; ?>
        <<?= $tag ?> class="<?= e($size) ?>"<?= attrs(['id' => $id ?? null]) ?>><?= e($title) ?></<?= $tag ?>>
    </div>
    <?php if (!empty($intro)): ?>
        <p class="section-head__intro lead"><?= e($intro) ?></p>
    <?php endif; ?>
</header>
