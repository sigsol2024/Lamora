<?php
/*
 * Site configuration. Values marked PLACEHOLDER must be replaced before launch.
 */

const SITE_NAME   = 'The Lamora';
const SITE_DOMAIN = 'thelamora.com';

// Base path of the site. Leave null to detect automatically (works at the web
// root and in a sub-folder such as http://localhost/Lamora).
const BASE_URL_OVERRIDE = null;

/*
 * Logo. PLACEHOLDER: the development placeholder is a neutral box marked "LOGO".
 * Replace with the supplied group artwork (SVG or transparent PNG) once issued.
 * Never recreate the logo in type.
 */
const LOGO_GROUP = 'assets/img/brand/_dev/logo-placeholder.svg';
const LOGO_GROUP_WIDTH  = 160;
const LOGO_GROUP_HEIGHT = 64;

/*
 * Booking engine URLs per location. PLACEHOLDER: empty until the booking engine is
 * confirmed. While empty, "Check availability" falls back to the reservation
 * enquiry form for that location.
 */
const BOOKING_URLS = [
    'lagos' => '',
];

// Enquiry form delivery. While MAIL_ENABLED is false, enquiries are written to
// storage/enquiries.log instead of being emailed.
const MAIL_ENABLED = false;
const MAIL_TO      = 'reservations@thelamora.com';
const MAIL_FROM    = 'no-reply@thelamora.com';

// Shows discreet "draft" notes (for example on legal pages) during development.
const SHOW_DRAFT_NOTES = true;
