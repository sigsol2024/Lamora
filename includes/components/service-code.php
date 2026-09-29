<?php
/**
 * The LAMORA Service Code (spec sheet).
 *
 * @var string|null $title
 */
$title = $title ?? 'Six commitments behind every stay.';
?>
<section class="section service-code" aria-labelledby="code-title">
    <div class="container">
        <div class="grid">
            <div class="span-4 reveal">
                <p class="label label--muted">The LAMORA Service Code</p>
                <h2 class="h2 service-code__title" id="code-title"><?= e($title) ?></h2>
                <p class="muted service-code__intro">Our operating culture is supported by the LAMORA Service Code.</p>
            </div>
            <ol class="span-7 start-6 service-code__list rows">
                <?php foreach (site('service_code') as $row): ?>
                    <li class="reveal">
                        <span class="service-code__letter" aria-hidden="true"><?= e($row['letter']) ?></span>
                        <span class="service-code__name"><?= e($row['name']) ?></span>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>
