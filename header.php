<?php
/**
 * Default site header.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

$body_classes = array( 'pg-home' );
$active_page  = '';

if ( is_singular( 'post' ) ) {
	$body_classes[] = 'pg-event-page';
	$active_page    = 'organizujeme';
} elseif ( is_page_template( array( 'templates/template-home.php', 'template-home.php' ) ) || is_page( 'domov' ) ) {
	$active_page = 'domov';
} elseif ( is_page_template( array( 'templates/template-aboutus.php', 'template-aboutus.php' ) ) || is_page( 'o-nas' ) ) {
	$body_classes[] = 'pg-about-page';
	$active_page    = 'o-nas';
} elseif ( is_page_template( array( 'templates/template-prices.php', 'template-prices.php' ) ) || is_page( 'cennik' ) ) {
	$body_classes[] = 'pg-prices-page';
	$active_page    = 'cennik';
} elseif ( is_page_template( array( 'templates/template-services.php', 'template-services.php' ) ) || is_page( 'sluzby' ) ) {
	$body_classes[] = 'pg-services-page';
	$active_page    = 'sluzby';
} elseif ( is_page_template( array( 'templates/template-events.php', 'template-events.php' ) ) || is_page( 'organizujeme' ) ) {
	$body_classes[] = 'pg-events-page';
	$active_page    = 'organizujeme';
} elseif ( is_page_template( array( 'templates/template-contact.php', 'template-contact.php' ) ) || is_page( 'kontakt' ) ) {
	$body_classes[] = 'pg-contact-page';
	$active_page    = 'kontakt';
} elseif ( is_page_template( array( 'templates/template-rental-calculator.php', 'template-rental-calculator.php' ) ) || is_page( 'calculator' ) ) {
	$body_classes[] = 'pg-rental-calculator-page';
	$active_page    = 'prenajom';
}

$home_link  = home_url( '/domov/' );
$menu_items = array(
	'domov'        => array( 'label' => 'Domov', 'url' => home_url( '/domov/' ) ),
	'o-nas'        => array( 'label' => 'O nás', 'url' => home_url( '/o-nas/' ) ),
	'cennik'       => array( 'label' => 'Cenník', 'url' => home_url( '/cennik/' ) ),
	'sluzby'       => array( 'label' => 'Služby', 'url' => home_url( '/sluzby/' ) ),
	'organizujeme' => array( 'label' => 'Organizujeme', 'url' => home_url( '/organizujeme/' ) ),
	'kontakt'      => array( 'label' => 'Kontakt', 'url' => home_url( '/kontakt/' ) ),
	'prenajom'     => array( 'label' => 'Prenájom miestnosti', 'url' => 'https://progymorava.sk/calculator/' ),
);

$show_app_stripe = is_page_template( array( 'templates/template-home.php', 'template-home.php' ) )
	&& 1 !== (int) progymorava_child_home_field( 'home_app_stripe_hide', 0 );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( $body_classes ); ?>>
	<?php wp_body_open(); ?>

	<?php if ( $show_app_stripe ) : ?>
		<?php
		$app_stripe_text = (string) progymorava_child_home_field( 'home_app_stripe_text', 'Stiahni si našu aplikáciu a vychutnaj si progym na vlastnej koži' );
		$app_store_links = array(
			array(
				'class' => 'fa-apple',
				'label' => 'Stiahnuť v App Store',
				'url'   => progymorava_child_home_field( 'home_app_stripe_apple_url', 'https://apps.apple.com/us/app/progym-orava-z%C3%A1kamenn%C3%A9/id6791676566' ),
			),
			array(
				'class' => 'fa-android',
				'label' => 'Stiahnuť v Google Play',
				'url'   => progymorava_child_home_field( 'home_app_stripe_android_url', 'https://play.google.com/store/apps/details?id=com.progymorava' ),
			),
		);
		?>
		<aside class="pg-app-stripe" aria-label="Aplikácia ProGym">
			<div class="pg-app-stripe__inner">
				<p class="pg-app-stripe__text"><?php echo esc_html( $app_stripe_text ); ?></p>
				<div class="pg-app-stripe__stores" aria-label="Stiahnuť aplikáciu ProGym">
					<?php foreach ( $app_store_links as $app_store_link ) : ?>
						<a class="pg-app-stripe__store" href="<?php echo esc_url( $app_store_link['url'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $app_store_link['label'] ); ?>">
							<i class="fa-brands <?php echo esc_attr( $app_store_link['class'] ); ?>" aria-hidden="true"></i>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</aside>
	<?php endif; ?>

	<header class="pg-header" id="pg-header">
		<div class="pg-header__shell">
			<a class="pg-header__brand" href="<?php echo esc_url( $home_link ); ?>" aria-label="ProGym home">
				<img class="pg-header__logo" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/clear_logo.svg' ); ?>" alt="ProGym" />
			</a>

			<nav class="pg-header__nav" aria-label="Hlavná navigácia">
				<ul class="pg-header__menu">
					<?php foreach ( $menu_items as $page_key => $menu_item ) : ?>
						<li class="pg-header__item">
							<a class="pg-header__link<?php echo $page_key === $active_page ? ' pg-header__link--active' : ''; ?>" href="<?php echo esc_url( $menu_item['url'] ); ?>"<?php echo $page_key === $active_page ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $menu_item['label'] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
		</div>
	</header>
