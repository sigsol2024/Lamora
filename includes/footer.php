<footer class="site-footer surface-mist">
    <div class="site-footer__pattern hex-pattern" aria-hidden="true"></div>
    <div class="container site-footer__inner">
        <div class="site-footer__brand">
            <?php component('logo', ['class' => 'site-footer__logo']); ?>
            <p class="site-footer__statement"><?= e(site('footer_statement')) ?></p>
            <ul class="social" aria-label="The Lamora on social media">
                <?php foreach (site('social') as $social): ?>
                    <li>
                        <a class="social__link" href="<?= e($social['url']) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= e($social['label']) ?> (opens in a new tab)">
                            <svg class="social__hex" viewBox="0 0 44 50" aria-hidden="true" focusable="false"><path d="M22 1.5 42.5 13.25v23.5L22 48.5 1.5 36.75v-23.5Z"/></svg>
                            <?= icon($social['icon']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
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
