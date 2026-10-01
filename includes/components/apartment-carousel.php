<?php
/**
 * Horizontally scrolling row of apartment cards with previous/next arrows on
 * either side. Works as a plain swipeable, scroll-snapping row without JavaScript.
 *
 * @var array  $suites
 * @var string $id     Unique id for the track.
 * @var string $label  Accessible name for the list.
 */
?>
<div class="apartment-carousel" data-carousel>
    <ul class="apartment-carousel__track" id="<?= e($id) ?>" aria-label="<?= e($label) ?>" data-carousel-track>
        <?php foreach ($suites as $suite): ?>
            <li class="apartment-carousel__item"><?php component('apartment-card', ['suite' => $suite]); ?></li>
        <?php endforeach; ?>
    </ul>
    <button class="round-button apartment-carousel__arrow apartment-carousel__arrow--prev" type="button" aria-controls="<?= e($id) ?>" aria-label="Previous apartments" hidden data-carousel-prev><?= icon('arrow-left', 'icon--s') ?></button>
    <button class="round-button apartment-carousel__arrow apartment-carousel__arrow--next" type="button" aria-controls="<?= e($id) ?>" aria-label="Next apartments" hidden data-carousel-next><?= icon('arrow-right', 'icon--s') ?></button>
</div>
