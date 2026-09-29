<?php
/**
 * @var array $items [['icon', 'name', 'text']]
 */
?>
<ul class="facility-list">
    <?php foreach ($items as $item): ?>
        <li class="facility-list__item reveal">
            <?= icon($item['icon'], 'icon--l') ?>
            <h3 class="h4"><?= e($item['name']) ?></h3>
            <p><?= e($item['text']) ?></p>
        </li>
    <?php endforeach; ?>
</ul>
