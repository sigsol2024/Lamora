<?php
/**
 * @var array $steps [['name', 'icon', 'text']]
 */
?>
<ol class="day-strip">
    <?php foreach ($steps as $step): ?>
        <li class="day-strip__step reveal">
            <?= icon($step['icon'], 'icon--l') ?>
            <h3 class="h3"><?= e($step['name']) ?></h3>
            <p><?= e($step['text']) ?></p>
        </li>
    <?php endforeach; ?>
</ol>
