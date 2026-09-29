<?php
require_once __DIR__ . '/includes/bootstrap.php';

http_response_code(404);

$page = [
    'title'       => 'Page not found',
    'description' => '',
    'slug'        => 'not-found',
];

include INC . '/head.php';
include INC . '/header.php';
?>
<main id="main">
    <section class="hero-plain surface-navy not-found" aria-labelledby="hero-title">
        <div class="hex-pattern hex-pattern--cream" aria-hidden="true"></div>
        <div class="container hero-plain__inner">
            <p class="label label--muted">Page not found</p>
            <h1 class="h1" id="hero-title">This page could not be found.</h1>
            <p class="lead">The address may have changed, or the page may no longer exist.</p>
            <div class="actions">
                <a class="btn btn--cream" href="<?= e(url()) ?>">Return home</a>
                <a class="link-arrow" href="<?= e(url() . '#locations') ?>">Our locations <?= icon('arrow-right') ?></a>
            </div>
        </div>
    </section>
</main>
<?php include INC . '/footer.php'; ?>
