<?php
/**
 * Minimal document header for the ProGym home template.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

$body_classes = 'pg-home';

if ( is_singular( 'post' ) ) {
	$body_classes = array( 'pg-home', 'pg-event-page' );
} elseif ( is_page_template( array( 'templates/template-aboutus.php', 'template-aboutus.php' ) ) ) {
	$body_classes = array( 'pg-home', 'pg-about-page' );
} elseif ( is_page_template( array( 'templates/template-prices.php', 'template-prices.php' ) ) ) {
	$body_classes = array( 'pg-home', 'pg-prices-page' );
} elseif ( is_page_template( array( 'templates/template-events.php', 'template-events.php' ) ) ) {
	$body_classes = array( 'pg-home', 'pg-events-page' );
} elseif ( is_page_template( array( 'templates/template-contact.php', 'template-contact.php' ) ) ) {
	$body_classes = array( 'pg-home', 'pg-contact-page' );
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( $body_classes ); ?>>
	<?php wp_body_open(); ?>
