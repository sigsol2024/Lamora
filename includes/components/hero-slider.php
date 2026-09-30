<?php
/**
 * Homepage hero slider: full-width image, one title and one action per slide.
 * Without JavaScript the first slide shows on its own. Autoplay pauses on hover,
 * on focus and with the pause button, and is off for reduced-motion users.
 *
 * @var array  $slides [['title', 'image', 'action' => ['label', 'href']]]
 * @var string $heading Visually hidden page heading.
 */
$slides = array_values($slides ?? []);
$count  = count($slides);
?>
<section class="hero-slider" aria-roledescription="carousel" aria-label="Introducing <?= e(SITE_NAME) ?>" data-slider>
    <h1 class="visually-hidden"><?= e($heading ?? SITE_NAME) ?></h1>

    <div class="hero-slider__slides" aria-live="off" data-slider-track>
        <?php foreach ($slides as $i => $slide):
            $href = str_starts_with($slide['action']['href'], '#') ? $slide['action']['href'] : url($slide['action']['href']); ?>
            <div class="hero-slider__slide<?= $i === 0 ? ' is-active' : '' ?>" role="group" aria-roledescription="slide" aria-label="<?= $i + 1 ?> of <?= $count ?>"<?= $i === 0 ? '' : ' aria-hidden="true" inert' ?> data-slide>
                <?= img($slide['image'], ['class' => 'hero-slider__media', 'priority' => $i === 0, 'sizes' => '100vw']) ?>
                <div class="hero-slider__content">
                    <div class="container">
                        <h2 class="h-hero hero-slider__title"><?= e($slide['title']) ?></h2>
                        <a class="btn btn--light" href="<?= e($href) ?>"><?= e($slide['action']['label']) ?></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($count > 1): ?>
        <div class="hero-slider__controls" data-slider-controls hidden>
            <div class="container hero-slider__controls-inner">
                <div class="hero-slider__dots">
                    <?php foreach ($slides as $i => $slide): ?>
                        <button class="hero-slider__dot" type="button" aria-label="Show slide <?= $i + 1 ?>: <?= e($slide['title']) ?>"<?= $i === 0 ? ' aria-current="true"' : '' ?> data-slide-to="<?= $i ?>">
                            <span class="hero-slider__dot-number"><?= sprintf('%02d', $i + 1) ?></span>
                            <span class="hero-slider__dot-line"><span></span></span>
                        </button>
                    <?php endforeach; ?>
                </div>
                <div class="hero-slider__buttons">
                    <button class="round-button round-button--light" type="button" aria-label="Pause slideshow" data-slider-pause>
                        <?= icon('pause', 'icon--s round-button__pause') ?>
                        <?= icon('play', 'icon--s round-button__play') ?>
                    </button>
                    <button class="round-button round-button--light" type="button" aria-label="Previous slide" data-slider-prev>
                        <?= icon('arrow-left', 'icon--s') ?>
                    </button>
                    <button class="round-button round-button--light" type="button" aria-label="Next slide" data-slider-next>
                        <?= icon('arrow-right', 'icon--s') ?>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
