<footer class="site-footer surface-mist">
    <div class="site-footer__pattern hex-pattern" aria-hidden="true"></div>
    <div class="container site-footer__inner">
        <div class="site-footer__brand">
            <a class="site-footer__logo" href="<?= e(url()) ?>" aria-label="<?= e(SITE_NAME) ?> - home">
                <img src="<?= e(asset(substr(LOGO_GROUP, strlen('assets/')))) ?>" alt="" width="<?= LOGO_GROUP_WIDTH ?>" height="<?= LOGO_GROUP_HEIGHT ?>">
            </a>
            <p class="site-footer__statement"><?= e(site('footer_statement')) ?></p>
        </div>

        <div class="site-footer__col">
            <h2 class="label label--muted">Locations</h2>
            <ul>
                <?php foreach (locations() as $footerLoc): ?>
                    <li>
                        <a href="<?= e(location_url($footerLoc['slug'])) ?>"><?= e($footerLoc['city']) ?></a>
                        <span class="site-footer__status"><?= e(status_label($footerLoc)) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="site-footer__col">
            <h2 class="label label--muted">The Lamora</h2>
            <ul>
                <li><a href="<?= e(url('about')) ?>">About</a></li>
                <li><a href="<?= e(url('corporate-stays')) ?>">Corporate Stays</a></li>
                <li><a href="<?= e(url('faq')) ?>">FAQ</a></li>
                <li><a href="<?= e(url('contact')) ?>">Contact</a></li>
            </ul>
        </div>

        <div class="site-footer__col">
            <h2 class="label label--muted">Enquiries</h2>
            <ul>
                <li><a href="mailto:<?= e(site('contact.info')) ?>"><?= e(site('contact.info')) ?></a></li>
                <li><a href="mailto:<?= e(site('contact.reservations')) ?>"><?= e(site('contact.reservations')) ?></a></li>
            </ul>
        </div>
    </div>

    <div class="container site-footer__base">
        <p>&copy; <?= date('Y') ?> <?= e(SITE_NAME) ?></p>
        <ul>
            <li><a href="<?= e(url('terms')) ?>">Terms &amp; Conditions</a></li>
            <li><a href="<?= e(url('privacy')) ?>">Privacy Policy</a></li>
        </ul>
    </div>
</footer>

<?php component('book-dialog'); ?>
</body>
</html>
