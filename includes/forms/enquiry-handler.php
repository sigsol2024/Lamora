<?php
declare(strict_types=1);

/**
 * Handles enquiry and register-interest submissions (POST /enquire).
 * Validates, then emails MAIL_TO when MAIL_ENABLED, otherwise appends to
 * storage/enquiries.log. Always redirects back (post/redirect/get).
 */

$return = (string) ($_POST['return'] ?? '');
if ($return === '' || $return[0] !== '/' || str_starts_with($return, '//')) {
    $return = url('contact') . '#enquiry';
}

$redirect = static function (string $to): never {
    header('Location: ' . $to, true, 303);
    exit;
};

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    $redirect(url('contact'));
}

// Honeypot: pretend success for bots.
if (!empty($_POST['website'])) {
    flash('enquiry', ['status' => 'success']);
    $redirect($return);
}

$clean = static fn(string $key, int $max = 200): string => mb_substr(trim(strip_tags((string) ($_POST[$key] ?? ''))), 0, $max);

$input = [
    'mode'      => $clean('mode', 20),
    'name'      => $clean('name', 120),
    'email'     => $clean('email', 160),
    'phone'     => $clean('phone', 40),
    'location'  => $clean('location', 40),
    'type'      => $clean('type', 20),
    'guests'    => $clean('guests', 4),
    'arrival'   => $clean('arrival', 10),
    'departure' => $clean('departure', 10),
    'message'   => $clean('message', 4000),
    'consent'   => isset($_POST['consent']) ? '1' : '',
];

$types = ['reservation', 'corporate', 'dining', 'general', 'interest'];
if (!in_array($input['type'], $types, true)) {
    $input['type'] = $input['mode'] === 'interest' ? 'interest' : 'general';
}

$errors = [];
if (!csrf_valid(is_string($_POST['csrf'] ?? null) ? $_POST['csrf'] : null)) {
    $errors['form'] = 'Your session expired. Please try again.';
}
if ($input['name'] === '') {
    $errors['name'] = 'Please enter your name.';
}
if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please enter a valid email address.';
}
if ($input['location'] !== 'group' && location($input['location']) === null) {
    $errors['location'] = 'Please choose a location.';
}
if ($input['mode'] !== 'interest' && $input['message'] === '') {
    $errors['message'] = 'Please tell us how we can help.';
}
if ($input['consent'] !== '1') {
    $errors['consent'] = 'Please confirm you agree so that we can reply.';
}

if ($errors) {
    flash('enquiry', ['status' => 'error', 'errors' => $errors, 'old' => $input]);
    $redirect($return);
}

$loc = location($input['location']);
$lines = [
    'Received: ' . date('Y-m-d H:i:s'),
    'Type: ' . ($input['type'] ?: 'general'),
    'Location: ' . ($loc ? location_name($loc) : 'Not location specific'),
    'Name: ' . $input['name'],
    'Email: ' . $input['email'],
    'Phone: ' . ($input['phone'] ?: '-'),
    'Guests: ' . ($input['guests'] ?: '-'),
    'Arrival: ' . ($input['arrival'] ?: '-'),
    'Departure: ' . ($input['departure'] ?: '-'),
    '',
    $input['message'] ?: '-',
];
$body = implode("\n", $lines);

$sent = false;
if (MAIL_ENABLED) {
    $subject = sprintf('[%s] %s enquiry: %s', SITE_NAME, ucfirst($input['type'] ?: 'general'), $input['name']);
    $headers = [
        'From: ' . MAIL_FROM,
        'Reply-To: ' . str_replace(["\r", "\n"], '', $input['email']),
        'Content-Type: text/plain; charset=UTF-8',
    ];
    $sent = mail(MAIL_TO, $subject, $body, implode("\r\n", $headers));
}

if (!$sent) {
    $dir = ROOT . '/storage';
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    file_put_contents($dir . '/enquiries.log', $body . "\n" . str_repeat('-', 40) . "\n", FILE_APPEND | LOCK_EX);
}

flash('enquiry', ['status' => 'success']);
$redirect($return);
