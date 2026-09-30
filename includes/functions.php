<?php
declare(strict_types=1);

/* ---------------------------------------------------------------- Output */

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function attrs(array $attributes): string
{
    $out = '';
    foreach ($attributes as $name => $value) {
        if ($value === null || $value === false) {
            continue;
        }
        $out .= $value === true ? ' ' . $name : sprintf(' %s="%s"', $name, e((string) $value));
    }
    return $out;
}

/* ---------------------------------------------------------------- URLs */

function detect_base_url(): string
{
    if (BASE_URL_OVERRIDE !== null) {
        return rtrim(BASE_URL_OVERRIDE, '/');
    }
    $docRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: '';
    $root = realpath(ROOT) ?: ROOT;
    if ($docRoot === '' || stripos($root, $docRoot) !== 0) {
        return '';
    }
    $base = str_replace('\\', '/', substr($root, strlen($docRoot)));
    $base = '/' . trim($base, '/');
    return $base === '/' ? '' : implode('/', array_map('rawurlencode', explode('/', $base)));
}

function url(string $path = ''): string
{
    $path = ltrim($path, '/');
    return BASE_URL . '/' . $path;
}

function asset(string $path): string
{
    $file = ROOT . '/assets/' . ltrim($path, '/');
    $version = is_file($file) ? '?v=' . filemtime($file) : '';
    return url('assets/' . ltrim($path, '/')) . $version;
}

function location_url(string $slug, string $anchor = ''): string
{
    return url('locations/' . $slug) . ($anchor !== '' ? '#' . $anchor : '');
}

function current_path(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $base = rawurldecode(BASE_URL);
    if ($base !== '' && stripos(rawurldecode($path), $base) === 0) {
        $path = substr(rawurldecode($path), strlen($base));
    }
    return '/' . trim($path, '/');
}

/* ---------------------------------------------------------------- Data */

function data(string $file): array
{
    static $cache = [];
    if (!isset($cache[$file])) {
        $path = DATA . '/' . $file . '.php';
        $cache[$file] = is_file($path) ? require $path : [];
    }
    return $cache[$file];
}

/** Dot-notation access to data/site.php, e.g. site('contact.info'). */
function site(string $key, mixed $default = null): mixed
{
    $value = data('site');
    foreach (explode('.', $key) as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }
    return $value;
}

/**
 * Campaign copy line. Lines are provisional until approved by Lamora; if a line is
 * missing the supplied fallback is used.
 */
function copy_line(string $key, string $fallback = ''): string
{
    return site('campaign_copy.' . $key . '.text', $fallback);
}

/** All registered locations, in registry order. */
function locations(): array
{
    static $all = null;
    if ($all === null) {
        $all = [];
        foreach (data('locations') as $slug) {
            $file = DATA . '/locations/' . $slug . '.php';
            if (is_file($file)) {
                $all[$slug] = (require $file) + ['slug' => $slug];
            }
        }
    }
    return $all;
}

function location(string $slug): ?array
{
    return locations()[$slug] ?? null;
}

function location_name(array $loc): string
{
    return $loc['name'] ?? $loc['city'];
}

function is_bookable(array $loc): bool
{
    return in_array($loc['status'] ?? '', ['open', 'opening-soon'], true);
}

function format_date(string $isoDate): string
{
    $date = DateTimeImmutable::createFromFormat('Y-m-d', $isoDate);
    return $date ? $date->format('j F Y') : $isoDate;
}

function status_label(array $loc): string
{
    return match ($loc['status'] ?? '') {
        'open'         => 'Now open',
        'opening-soon' => isset($loc['dates']['soft_opening'])
            ? 'Opening ' . format_date($loc['dates']['soft_opening'])
            : 'Opening soon',
        default        => 'Coming soon',
    };
}

/** Booking engine URL, or the reservation enquiry form while no engine is configured. */
function booking_url(array $loc): string
{
    $engine = BOOKING_URLS[$loc['slug']] ?? '';
    if ($engine !== '') {
        return $engine;
    }
    return url('contact') . '?location=' . rawurlencode($loc['slug']) . '&type=reservation#enquiry';
}

function interest_url(array $loc): string
{
    return location_url($loc['slug'], 'register');
}

/* ---------------------------------------------------------------- Suites */

/** Every suite category at a location, flagship last, each tagged with its location slug. */
function location_suites(array $loc): array
{
    $suites = $loc['suites'] ?? [];
    if (!empty($loc['presidential'])) {
        $suites[] = $loc['presidential'] + ['flagship' => true];
    }
    return array_map(fn(array $suite) => $suite + ['location' => $loc['slug']], $suites);
}

function suite(array $loc, string $slug): ?array
{
    foreach (location_suites($loc) as $suite) {
        if (($suite['slug'] ?? '') === $slug) {
            return $suite;
        }
    }
    return null;
}

function suite_url(array $suite): string
{
    return url('locations/' . $suite['location'] . '/suites/' . $suite['slug']);
}

/**
 * Homepage selection: up to $perLocation featured suites from every bookable
 * location, interleaved so no single location fills the start of the carousel.
 */
function featured_suites(int $perLocation = 8): array
{
    $queues = [];
    foreach (locations() as $loc) {
        if (!is_bookable($loc)) {
            continue;
        }
        $featured = array_filter(location_suites($loc), fn(array $s) => ($s['featured'] ?? true) && !empty($s['slug']));
        $queues[] = array_slice(array_values($featured), 0, $perLocation);
    }
    $out = [];
    for ($i = 0; $queues && $i < $perLocation; $i++) {
        foreach ($queues as $queue) {
            if (isset($queue[$i])) {
                $out[] = $queue[$i];
            }
        }
    }
    return $out;
}

function bedroom_label(int $bedrooms): string
{
    return match (true) {
        $bedrooms === 0 => 'Studio',
        $bedrooms === 1 => '1 bedroom',
        default         => $bedrooms . ' bedrooms',
    };
}

/* ---------------------------------------------------------------- Media */

/**
 * Responsive image for a named slot in data/images.php.
 * Options: class, ratio (16x9 | 4x5 | 3x2), priority (bool), sizes.
 */
function img(string $slot, array $options = []): string
{
    $image = data('images')[$slot] ?? null;
    if ($image === null) {
        return '';
    }
    $file = ROOT . '/assets/img/' . $image['file'];
    [$width, $height] = @getimagesize($file) ?: [null, null];
    $priority = !empty($options['priority']);

    $tag = '<img' . attrs([
        'src'           => asset('img/' . $image['file']),
        'alt'           => $image['alt'] ?? '',
        'width'         => $width,
        'height'        => $height,
        'loading'       => $priority ? 'eager' : 'lazy',
        'decoding'      => $priority ? 'sync' : 'async',
        'fetchpriority' => $priority ? 'high' : null,
        'sizes'         => $options['sizes'] ?? null,
        'style'         => 'object-position: ' . ($image['focus'] ?? '50% 50%'),
    ]) . '>';

    $classes = trim('media ' . (isset($options['ratio']) ? 'media--' . $options['ratio'] : '') . ' ' . ($options['class'] ?? ''));
    return '<div class="' . e($classes) . '">' . $tag . '</div>';
}

/** Raw source and alt text for a slot, for scripts that load the full image (lightbox). */
function img_data(string $slot): ?array
{
    $image = data('images')[$slot] ?? null;
    return $image === null ? null : ['src' => asset('img/' . $image['file']), 'alt' => $image['alt'] ?? ''];
}

function icon(string $name, string $class = ''): string
{
    return sprintf(
        '<svg class="icon %s" aria-hidden="true" focusable="false"><use href="%s#%s"></use></svg>',
        e($class),
        e(asset('icons/sprite.svg')),
        e($name)
    );
}

/** Hexagon outline framing an index number, echoing the monogram's outer geometry. */
function hex_index(string $number, string $class = ''): string
{
    return '<span class="hex-index ' . e($class) . '" aria-hidden="true">'
        . '<svg viewBox="0 0 44 50"><path d="M22 1.5 42.5 13.25v23.5L22 48.5 1.5 36.75v-23.5Z"/></svg>'
        . '<span>' . e($number) . '</span></span>';
}

/* ---------------------------------------------------------------- Components */

function component(string $name, array $vars = []): void
{
    extract($vars, EXTR_SKIP);
    include INC . '/components/' . $name . '.php';
}

/* ---------------------------------------------------------------- Forms */

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_valid(?string $token): bool
{
    return is_string($token) && !empty($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

function flash(string $key, mixed $value = null): mixed
{
    if (func_num_args() === 2) {
        $_SESSION['flash'][$key] = $value;
        return null;
    }
    $stored = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $stored;
}

function query(string $key, string $default = ''): string
{
    $value = $_GET[$key] ?? $default;
    return is_string($value) ? $value : $default;
}
