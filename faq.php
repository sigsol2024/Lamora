<?php
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'title'       => 'Frequently Asked Questions',
    'description' => 'Answers to common questions about booking, staying and paying at The Lamora.',
    'slug'        => 'faq',
];

$groups = data('faq');

// Filter options: The Lamora, plus each location that has its own answers.
$used = [];
foreach ($groups as $group) {
    foreach ($group['items'] as $item) {
        $used[$item['location']] = true;
    }
}
$filters = ['all' => 'All', 'group' => SITE_NAME];
foreach (locations() as $loc) {
    if (isset($used[$loc['slug']])) {
        $filters[$loc['slug']] = $loc['city'];
    }
}

include INC . '/head.php';
include INC . '/header.php';
?>
<main id="main">

    <?php component('hero', [
        'variant' => 'plain',
        'label'   => 'FAQ',
        'title'   => 'Frequently asked questions',
        'lead'    => 'Answers for The Lamora as a whole, and for each location.',
    ]); ?>

    <section class="section faq" aria-label="Questions and answers">
        <div class="container">
            <div class="faq__filter" data-faq-filter role="group" aria-label="Show answers for" hidden>
                <?php foreach ($filters as $value => $label): ?>
                    <button type="button" class="faq__filter-button" data-value="<?= e($value) ?>" aria-pressed="<?= $value === 'all' ? 'true' : 'false' ?>"><?= e($label) ?></button>
                <?php endforeach; ?>
            </div>

            <?php foreach ($groups as $group): ?>
                <div class="grid faq__group" data-faq-group>
                    <h2 class="span-3 h3 faq__group-title reveal"><?= e($group['group']) ?></h2>
                    <div class="span-8 start-5 reveal">
                        <?php component('accordion', ['items' => $group['items']]); ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="grid faq__more">
                <div class="span-8 start-5">
                    <p class="muted">Can't find what you need? <a class="text-link" href="<?= e(url('contact')) ?>">Contact our team</a> or email <a class="text-link" href="mailto:<?= e(site('contact.reservations')) ?>"><?= e(site('contact.reservations')) ?></a>.</p>
                </div>
            </div>
        </div>
    </section>

</main>
<?php include INC . '/footer.php'; ?>
