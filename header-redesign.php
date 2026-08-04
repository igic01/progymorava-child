<?php
/**
 * Header used only by templates that call get_header( 'redesign' ).
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'pg-redesign' ); ?> <?php generate_do_microdata( 'body' ); ?>>
	<?php
	do_action( 'wp_body_open' );

	/*
	 * Redesign header boundary.
	 *
	 * These GeneratePress hooks preserve the current header and navigation for
	 * now. They can later be replaced with the new header markup without
	 * changing pages that use the standard header.php file.
	 */
	do_action( 'generate_before_header' );
	do_action( 'generate_header' );
	do_action( 'generate_after_header' );
	?>

	<div <?php generate_do_attr( 'page' ); ?>>
		<?php do_action( 'generate_inside_site_container' ); ?>

		<div <?php generate_do_attr( 'site-content' ); ?>>
			<?php do_action( 'generate_inside_container' ); ?>
