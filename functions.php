<?php
/**
 * Progymorava child theme bootstrap.
 *
 * Each feature registers itself from a focused module in /includes. Keeping
 * this file as an explicit dependency list makes it easy to find the owner of
 * every theme responsibility.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

require_once get_stylesheet_directory() . '/includes/class-progymorava-child-assets.php';
require_once get_stylesheet_directory() . '/includes/class-progymorava-child-acf-utils.php';

require_once get_stylesheet_directory() . '/includes/acf/class-progymorava-child-acf-field-builder.php';
require_once get_stylesheet_directory() . '/includes/acf/class-progymorava-child-acf-page-context.php';
require_once get_stylesheet_directory() . '/includes/acf/fields/class-progymorava-child-home-fields.php';
require_once get_stylesheet_directory() . '/includes/acf/fields/class-progymorava-child-contact-fields.php';
require_once get_stylesheet_directory() . '/includes/acf/fields/class-progymorava-child-about-fields.php';
require_once get_stylesheet_directory() . '/includes/acf/fields/class-progymorava-child-prices-fields.php';
require_once get_stylesheet_directory() . '/includes/acf/fields/class-progymorava-child-events-fields.php';
require_once get_stylesheet_directory() . '/includes/acf/fields/class-progymorava-child-services-fields.php';
require_once get_stylesheet_directory() . '/includes/acf/fields/class-progymorava-child-rental-calculator-fields.php';

require_once get_stylesheet_directory() . '/includes/pricing/class-progymorava-child-prices-faq.php';
require_once get_stylesheet_directory() . '/includes/admin/class-progymorava-child-legacy-cleanup.php';
