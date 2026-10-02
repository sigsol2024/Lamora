<?php
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'       => 'Corporate & Extended Stays',
    'description' => 'Corporate accounts, project-team accommodation and extended stays at The Lamora.',
    'slug'        => 'corporate-stays',
];

include INC . '/head.php';
include INC . '/header.php';

$corporateEnquiry = url('contact') . '?type=corporate#enquiry';

$stayImages = [
    'Nightly' => 'corporate.nightly',
    'Weekly'  => 'corporate.weekly',
    'Monthly' => 'corporate.monthly',
    'Bespoke' => 'corporate.bespoke',
];

// Each slide shows the extended-stay feature it is captioned with.
$extended   = site('extended_stay');
$longSlides = [
    ['image' => 'corporate.long-living',       'caption' => $extended[0]],
    ['image' => 'corporate.long-bedroom',      'caption' => $extended[1]],
    ['image' => 'corporate.long-kitchen',      'caption' => $extended[2]],
    ['image' => 'corporate.long-storage',      'caption' => $extended[3]],
    ['image' => 'corporate.long-housekeeping', 'caption' => $extended[4]],
];
?>
<main id="main">

    <?php component('hero', [
        'variant' => 'split',
        'tone'    => 'navy',
        'reverse' => true,
        'image'   => 'corporate.hero',
        'label'   => 'Corporate & extended stays',
        'title'   => 'Accommodation, meetings, meals and hosting from one address.',
        'title_class' => 'h2',
        'lead'    => copy_line('audience_title'),
        'actions' => [
            ['label' => 'Make a corporate enquiry', 'href' => $corporateEnquiry],
            ['label' => 'Our locations', 'href' => url() . '#locations', 'style' => 'link'],
        ],
    ]); ?>

    <!-- Corporate advantage -->
    <section class="section corporate-advantage" aria-labelledby="advantage-title">
        <div class="container corporate-advantage__inner reveal">
            <p class="label label--muted">The corporate advantage</p>
            <p class="h3 corporate-advantage__text" id="advantage-title"><?= e(site('corporate_advantage')) ?></p>
        </div>
    </section>

    <!-- Corporate services: photograph behind a Navy gradient, auto-scrolling cards -->
    <section class="section surface-navy corporate-services" aria-labelledby="services-title">
        <div class="corporate-services__bg" aria-hidden="true">
            <?= img('corporate.work', ['sizes' => '100vw']) ?>
        </div>
        <div class="hex-pattern hex-pattern--cream corporate-services__pattern" aria-hidden="true"></div>

        <div class="container corporate-services__inner">
            <div class="corporate-services__head reveal">
                <p class="label label--muted">For companies</p>
                <h2 class="h2" id="services-title">Corporate services</h2>
            </div>

            <div class="service-slider reveal" data-autoscroll>
                <ul class="service-slider__track" data-autoscroll-track aria-label="Corporate services" tabindex="0">
                    <?php foreach (site('corporate_services') as $i => $service): ?>
                        <li class="service-card">
                            <?= hex_index(sprintf('%02d', $i + 1), 'hex-index--cream') ?>
                            <p class="service-card__text"><?= e($service) ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="service-slider__footer">
                    <p class="small muted service-slider__note">Credit facilities are subject to prior approval.</p>
                    <div class="service-slider__progress" aria-hidden="true"><span data-autoscroll-bar></span></div>
                    <div class="service-slider__buttons">
                        <button class="round-button round-button--light" type="button" aria-label="Previous services" data-autoscroll-prev><?= icon('arrow-left') ?></button>
                        <button class="round-button round-button--light" type="button" aria-label="Next services" data-autoscroll-next><?= icon('arrow-right') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Extended stays: one image-led card per stay type -->
    <section class="section surface-cream extended" aria-labelledby="extended-title">
        <div class="container">
            <div class="grid extended__grid">
                <div class="span-4 reveal">
                    <p class="label label--muted">Extended stays</p>
                    <h2 class="h2 extended__title" id="extended-title"><?= e(copy_line('ways_title')) ?></h2>
                </div>
                <ul class="span-8 start-5 stay-cards">
                    <?php foreach (site('stay_profiles') as $profile): ?>
                        <li class="stay-card reveal">
                            <?= img($stayImages[$profile['name']] ?? 'corporate.monthly', ['ratio' => '3x2', 'sizes' => '(min-width: 960px) 30vw, 50vw']) ?>
                            <h3 class="h4 stay-card__title"><?= e($profile['name']) ?></h3>
                            <p class="small muted stay-card__text"><?= e($profile['text']) ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <!-- Made for longer stays: vertical looping slider (30%) beside the detail (70%) -->
    <section class="section longer" aria-labelledby="longer-title">
        <div class="container longer__layout">
            <div class="vslider reveal" data-vslider>
                <div class="vslider__viewport" data-vslider-viewport>
                    <ul class="vslider__track" data-vslider-track>
                        <?php foreach ($longSlides as $slide): ?>
                            <li class="vslider__item">
                                <?= img($slide['image'], ['ratio' => '3x2', 'sizes' => '(min-width: 960px) 26vw, 90vw']) ?>
                                <p class="label label--muted vslider__caption"><?= e($slide['caption']) ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="vslider__buttons">
                    <button class="round-button" type="button" aria-label="Previous photographs" data-vslider-prev><?= icon('arrow-left') ?></button>
                    <button class="round-button" type="button" aria-label="Next photographs" data-vslider-next><?= icon('arrow-right') ?></button>
                </div>
            </div>

            <div class="longer__content reveal">
                <h2 class="h2 longer__title" id="longer-title">Made for longer stays</h2>
                <ul class="rows small longer__list">
                    <?php foreach ($extended as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <!-- Who we host -->
    <section class="section audiences" aria-labelledby="audiences-title">
        <div class="container">
            <div class="grid">
                <div class="span-4 reveal">
                    <p class="label label--muted">Who we host</p>
                    <h2 class="h2" id="audiences-title">Guests who value privacy, space and service.</h2>
                </div>
                <ol class="span-7 start-6 audiences__list">
                    <?php foreach (site('audiences') as $i => $audience): ?>
                        <li class="reveal">
                            <?= hex_index(sprintf('%02d', $i + 1)) ?>
                            <span><?= e($audience) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
            <div class="grid payment reveal">
                <p class="span-4 label label--muted">Payment</p>
                <ul class="span-7 start-6 payment__list small">
                    <?php foreach (site('payment_methods') as $method): ?><li><?= e($method) ?></li><?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <!-- Enquire by location -->
    <section class="section surface-navy corporate-locations" aria-labelledby="corporate-locations-title">
        <div class="container">
            <div class="grid">
                <div class="span-5 reveal">
                    <p class="label label--muted">Enquire</p>
                    <h2 class="h2" id="corporate-locations-title">Speak to our reservations team.</h2>
                    <p class="muted corporate-locations__text">Tell us about your team, your dates and what you need.</p>
                    <p class="corporate-locations__email"><a class="text-link" href="mailto:<?= e(site('contact.reservations')) ?>"><?= e(site('contact.reservations')) ?></a></p>
                </div>
                <ol class="span-6 start-7 corporate-locations__list">
                    <?php $n = 0; foreach (locations() as $loc): $n++; ?>
                        <li class="reveal">
                            <?= hex_index(sprintf('%02d', $n), 'hex-index--cream') ?>
                            <div>
                                <span class="corporate-locations__city"><?= e($loc['city']) ?></span>
                                <span class="label label--muted"><?= e(status_label($loc)) ?></span>
                            </div>
                            <?php if (is_bookable($loc)): ?>
                                <a class="link-arrow" href="<?= e(url('contact') . '?location=' . rawurlencode($loc['slug']) . '&type=corporate#enquiry') ?>">Corporate enquiry <?= icon('arrow-right') ?></a>
                            <?php else: ?>
                                <a class="link-arrow" href="<?= e(interest_url($loc)) ?>">Register interest <?= icon('arrow-right') ?></a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
    </section>

</main>
<?php include INC . '/footer.php'; ?>
