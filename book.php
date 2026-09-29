<?php
// Receives the "Plan your stay" form and forwards to the chosen location's booking
// engine, or to its register-interest section when the location is not yet bookable.
require __DIR__ . '/includes/bootstrap.php';

$loc = location(query('location'));

if ($loc === null) {
    header('Location: ' . url() . '#locations', true, 303);
    exit;
}

header('Location: ' . (is_bookable($loc) ? booking_url($loc) : interest_url($loc)), true, 303);
exit;
