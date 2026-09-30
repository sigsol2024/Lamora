<?php
/**
 * Enquiry form, posted to /enquire.
 *   mode 'full'     : contact page (location, enquiry type, dates, guests, message).
 *   mode 'interest' : register interest for a coming-soon location.
 *
 * @var string      $mode
 * @var string|null $location  Pre-selected location slug.
 * @var string|null $type      Pre-selected enquiry type.
 * @var string|null $message   Pre-filled message.
 * @var string      $return    Local path to return to after submission.
 */
$mode     = $mode ?? 'full';
$location = $location ?? '';
$type     = $type ?? '';
$message  = $message ?? '';
$state    = flash('enquiry') ?? [];
$old      = $state['old'] ?? [];
$errors   = $state['errors'] ?? [];
$status   = $state['status'] ?? null;

$types = [
    'reservation' => 'Reservation',
    'corporate'   => 'Corporate or extended stay',
    'dining'      => 'Dining and events',
    'general'     => 'General enquiry',
];

$value = static fn(string $key, string $default = ''): string => (string) ($old[$key] ?? $default);
$error = static function (string $key) use ($errors): string {
    if (empty($errors[$key])) {
        return '';
    }
    return '<span class="field-error" id="error-' . e($key) . '">' . icon('alert') . e($errors[$key]) . '</span>';
};
$invalid = static fn(string $key): string => empty($errors[$key]) ? '' : ' aria-invalid="true" aria-describedby="error-' . e($key) . '"';
?>
<?php if ($status === 'success'): ?>
    <div class="form-message form-message--success" role="status">
        <?= icon('check') ?>
        <p><?= $mode === 'interest'
            ? 'Thank you. Your interest has been registered and we will be in touch when reservations open.'
            : 'Thank you. Your enquiry has been received and our team will reply shortly.' ?></p>
    </div>
<?php elseif ($status === 'error'): ?>
    <div class="form-message form-message--error" role="alert">
        <?= icon('alert') ?>
        <p>Please check the highlighted fields and try again.</p>
    </div>
<?php endif; ?>

<form class="enquiry-form" action="<?= e(url('enquire')) ?>" method="post" novalidate>
    <?= csrf_field() ?>
    <input type="hidden" name="mode" value="<?= e($mode) ?>">
    <input type="hidden" name="return" value="<?= e($return) ?>">
    <div class="hp-field" aria-hidden="true">
        <label>Leave this field empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
    </div>

    <div class="form-grid">
        <label class="field">
            <span>Full name</span>
            <input class="input" type="text" name="name" autocomplete="name" required value="<?= e($value('name')) ?>"<?= $invalid('name') ?>>
            <?= $error('name') ?>
        </label>
        <label class="field">
            <span>Email</span>
            <input class="input" type="email" name="email" autocomplete="email" required value="<?= e($value('email')) ?>"<?= $invalid('email') ?>>
            <?= $error('email') ?>
        </label>
        <label class="field">
            <span>Phone (optional)</span>
            <input class="input" type="tel" name="phone" autocomplete="tel" value="<?= e($value('phone')) ?>">
        </label>

        <?php if ($mode === 'interest'): ?>
            <input type="hidden" name="location" value="<?= e($location) ?>">
            <input type="hidden" name="type" value="interest">
        <?php else: ?>
            <label class="field">
                <span>Location</span>
                <select class="select" name="location"<?= $invalid('location') ?>>
                    <?php foreach (locations() as $option): ?>
                        <option value="<?= e($option['slug']) ?>"<?= $value('location', $location) === $option['slug'] ? ' selected' : '' ?>>
                            <?= e($option['city']) ?><?= is_bookable($option) ? '' : ' (coming soon)' ?>
                        </option>
                    <?php endforeach; ?>
                    <option value="group"<?= $value('location', $location) === 'group' ? ' selected' : '' ?>>Not location specific</option>
                </select>
            </label>
            <label class="field">
                <span>Enquiry</span>
                <select class="select" name="type">
                    <?php foreach ($types as $key => $label): ?>
                        <option value="<?= e($key) ?>"<?= $value('type', $type) === $key ? ' selected' : '' ?>><?= e($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="field">
                <span>Guests (optional)</span>
                <input class="input" type="number" name="guests" min="1" max="120" inputmode="numeric" value="<?= e($value('guests')) ?>">
            </label>
            <label class="field">
                <span>Arrival (optional)</span>
                <input class="input" type="date" name="arrival" value="<?= e($value('arrival')) ?>">
            </label>
            <label class="field">
                <span>Departure (optional)</span>
                <input class="input" type="date" name="departure" value="<?= e($value('departure')) ?>">
            </label>
        <?php endif; ?>

        <label class="field field--full">
            <span>Message<?= $mode === 'interest' ? ' (optional)' : '' ?></span>
            <textarea class="textarea" name="message" rows="4"<?= $invalid('message') ?>><?= e($value('message', $message)) ?></textarea>
            <?= $error('message') ?>
        </label>

        <div class="field--full">
            <label class="checkbox">
                <input type="checkbox" name="consent" value="1" required<?= $value('consent') === '1' ? ' checked' : '' ?><?= $invalid('consent') ?>>
                <span>I agree that The Lamora may use these details to respond to my enquiry, as described in the <a class="text-link" href="<?= e(url('privacy')) ?>">Privacy Policy</a>.</span>
            </label>
            <?= $error('consent') ?>
        </div>
    </div>

    <div class="actions">
        <button class="btn" type="submit"><?= $mode === 'interest' ? 'Register interest' : 'Send enquiry' ?></button>
    </div>
</form>
