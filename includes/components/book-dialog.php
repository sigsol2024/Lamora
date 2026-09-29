<?php
// "Book a Stay" location picker. Booking engines are set per location.
$rowIndex = 0;
?>
<dialog class="book-dialog" id="book-dialog" aria-labelledby="book-dialog-title" data-booking-dialog>
    <div class="book-dialog__inner">
        <div class="book-dialog__head">
            <div>
                <p class="label label--muted">Book a stay</p>
                <h2 class="h2" id="book-dialog-title">Choose a location</h2>
            </div>
            <button class="book-dialog__close" type="button" aria-label="Close" data-close-booking><?= icon('close') ?></button>
        </div>

        <div class="rows">
            <?php foreach (locations() as $loc): $rowIndex++; ?>
                <div class="book-dialog__row">
                    <?= hex_index(sprintf('%02d', $rowIndex)) ?>
                    <div>
                        <p class="book-dialog__city"><?= e($loc['city']) ?></p>
                        <p class="label label--muted"><?= e(status_label($loc)) ?></p>
                    </div>
                    <?php if (is_bookable($loc)): ?>
                        <a class="btn btn--small" href="<?= e(booking_url($loc)) ?>">Check availability</a>
                    <?php else: ?>
                        <a class="link-arrow" href="<?= e(interest_url($loc)) ?>">Register interest <?= icon('arrow-right') ?></a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <p class="book-dialog__note">For corporate, group and extended stays, contact <a class="text-link" href="mailto:<?= e(site('contact.reservations')) ?>"><?= e(site('contact.reservations')) ?></a>.</p>
    </div>
</dialog>
