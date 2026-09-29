<?php
/**
 * FAQ accordion using native <details>, so it works without JavaScript.
 *
 * @var array $items [['location', 'q', 'a' => []]]
 */
?>
<div class="accordion">
    <?php foreach ($items as $item):
        $loc = $item['location'] === 'group' ? null : location($item['location']);
    ?>
        <details class="accordion__item" data-location="<?= e($item['location']) ?>">
            <summary>
                <span>
                    <?php if ($loc): ?><span class="label accordion__tag"><?= e($loc['city']) ?></span><?php endif; ?>
                    <span class="accordion__question"><?= e($item['q']) ?></span>
                </span>
                <span class="accordion__sign" aria-hidden="true"></span>
            </summary>
            <div class="accordion__answer">
                <?php foreach ($item['a'] as $paragraph): ?><p><?= e($paragraph) ?></p><?php endforeach; ?>
            </div>
        </details>
    <?php endforeach; ?>
</div>
