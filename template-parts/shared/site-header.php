<?php
/**
 * Shared public-site header.
 *
 * Expected arguments:
 * - active_page: aboutus, prices, services, events, contact, or an empty string.
 * - cta_target: Optional on-page destination for the registration link.
 * - home_link: Optional home link; the home template uses its hero anchor.
 * - show_services: Whether to include the Services menu.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

$active_page   = isset( $args['active_page'] ) ? (string) $args['active_page'] : '';
$cta_target    = isset( $args['cta_target'] ) ? (string) $args['cta_target'] : '';
$home_link     = isset( $args['home_link'] ) ? (string) $args['home_link'] : home_url( '/temp-home/' );
$show_services = ! isset( $args['show_services'] ) || (bool) $args['show_services'];
$login_url     = 'https://prihlasenie.progymorava.sk/login';
?>

<header class="pg-header" id="pg-header">
	<div class="pg-header__shell">
		<a class="pg-header__brand" href="<?php echo esc_url( $home_link ); ?>" aria-label="ProGym home">
			<img class="pg-header__logo" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/wide white.svg' ); ?>" alt="ProGym" />
		</a>

		<nav class="pg-header__nav" aria-label="Primary navigation">
			<ul class="pg-header__menu">
				<li class="pg-header__item">
					<a class="pg-header__link<?php echo 'aboutus' === $active_page ? ' pg-header__link--active' : ''; ?>" href="<?php echo esc_url( home_url( '/aboutus/' ) ); ?>"<?php echo 'aboutus' === $active_page ? ' aria-current="page"' : ''; ?>>O nás</a>
				</li>
				<li class="pg-header__item">
					<a class="pg-header__link<?php echo 'prices' === $active_page ? ' pg-header__link--active' : ''; ?>" href="<?php echo esc_url( home_url( '/prices/' ) ); ?>"<?php echo 'prices' === $active_page ? ' aria-current="page"' : ''; ?>>Cenník</a>
				</li>

				<?php if ( $show_services ) : ?>
					<li class="pg-header__item pg-header__item--dropdown">
						<a class="pg-header__link<?php echo 'services' === $active_page ? ' pg-header__link--active' : ''; ?>" href="<?php echo esc_url( home_url( '/services/' ) ); ?>"<?php echo 'services' === $active_page ? ' aria-current="page"' : ''; ?>>
							Služby <span class="pg-header__caret" aria-hidden="true"></span>
						</a>
						<ul class="pg-header__submenu">
							<li><a class="pg-header__submenu-link" href="<?php echo esc_url( home_url( '/services/#coaches' ) ); ?>">Fitness tréneri</a></li>
							<li><a class="pg-header__submenu-link" href="<?php echo esc_url( home_url( '/services/#nutrition' ) ); ?>">Výživa a progres</a></li>
							<li><a class="pg-header__submenu-link" href="<?php echo esc_url( home_url( '/services/#physiotherapy' ) ); ?>">Fyzioterapia</a></li>
						</ul>
					</li>
				<?php endif; ?>

				<li class="pg-header__item">
					<a class="pg-header__link<?php echo 'events' === $active_page ? ' pg-header__link--active' : ''; ?>" href="<?php echo esc_url( home_url( '/events/' ) ); ?>"<?php echo 'events' === $active_page ? ' aria-current="page"' : ''; ?>>Organizujeme</a>
				</li>
				<li class="pg-header__item">
					<a class="pg-header__link<?php echo 'contact' === $active_page ? ' pg-header__link--active' : ''; ?>" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"<?php echo 'contact' === $active_page ? ' aria-current="page"' : ''; ?>>Kontakt</a>
				</li>
			</ul>
		</nav>

		<?php if ( '' !== $cta_target ) : ?>
			<a class="pg-header__cta" href="<?php echo esc_url( $login_url ); ?>">Prihlásenie / Registrácia</a>
		<?php endif; ?>
	</div>
</header>
