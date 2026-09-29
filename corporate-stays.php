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
?>
<main id="main">

    <?php component('hero', [
        'variant' => 'split',
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
        <div class="container">
            <div class="grid">
                <div class="span-3 reveal">
                    <p class="label label--muted">The corporate advantage</p>
                </div>
                <p class="span-8 start-5 h3 corporate-advantage__text reveal" id="advantage-title"><?= e(site('corporate_advantage')) ?></p>
            </div>
        </div>
    </section>

    <!-- Corporate services -->
    <section class="section section--flush-top corporate-services" aria-labelledby="services-title">
        <div class="container">
            <div class="grid corporate-services__grid">
                <div class="span-5 bleed-left reveal">
                    <?= img('corporate.work', ['ratio' => '4x5', 'sizes' => '(min-width: 960px) 40vw, 100vw']) ?>
                </div>
                <div class="span-6 start-7 corporate-services__text reveal">
                    <p class="label label--muted">For companies</p>
                    <h2 class="h2" id="services-title">Corporate services</h2>
                    <ul class="rows corporate-services__list small">
                        <?php foreach (site('corporate_services') as $service): ?><li><?= e($service) ?></li><?php endforeach; ?>
                    </ul>
                    <p class="small muted">Credit facilities are subject to prior approval.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Extended stays -->
    <section class="section surface-cream extended" aria-labelledby="extended-title">
        <div class="container">
            <div class="grid">
                <div class="span-5 reveal">
                    <p class="label label--muted">Extended stays</p>
                    <h2 class="h2 extended__title" id="extended-title"><?= e(copy_line('ways_title')) ?></h2>
                    <dl class="rows extended__profiles">
                        <?php foreach (site('stay_profiles') as $profile): ?>
                            <div>
                                <dt class="h4"><?= e($profile['name']) ?></dt>
                                <dd class="small muted"><?= e($profile['text']) ?></dd>
                            </div>
                        <?php endforeach; ?>
                    </dl>
                </div>
                <div class="span-5 start-8 reveal">
                    <h3 class="label extended__label">Made for longer stays</h3>
                    <ul class="rows small">
                        <?php foreach (site('extended_stay') as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
                    </ul>
                </div>
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
