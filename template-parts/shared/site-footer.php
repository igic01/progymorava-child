<?php
/**
 * Shared public-site footer.
 *
 * Expected arguments:
 * - include_contact: Whether to show the email and phone links.
 * - include_contact_link: Whether Explore includes Contact.
 * - include_services: Whether to show the Services column.
 * - extended_services: Whether to add app and FAQ links.
 * - include_follow: Whether to show the Follow column.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

$include_contact      = ! isset( $args['include_contact'] ) || (bool) $args['include_contact'];
$include_contact_link = ! isset( $args['include_contact_link'] ) || (bool) $args['include_contact_link'];
$include_services     = ! isset( $args['include_services'] ) || (bool) $args['include_services'];
$extended_services    = ! empty( $args['extended_services'] );
$include_follow       = ! empty( $args['include_follow'] );
$home_url             = home_url( '/temp-home/' );
$theme_images_url     = get_stylesheet_directory_uri() . '/assets/images';
?>

<footer class="pg-footer">
	<div class="pg-footer__shell">
		<div class="pg-footer__brand">
			<a class="pg-footer__brand-logo" href="<?php echo esc_url( $home_url ); ?>" aria-label="ProGym home">
				<img src="<?php echo esc_url( $theme_images_url . '/logo dual.svg' ); ?>" alt="ProGym" />
			</a>
			<p class="pg-footer__text">Cielený tréning. Silnejšie návyky. Lepšie výsledky.</p>

			<?php if ( $include_contact ) : ?>
				<div class="pg-footer__contact">
					<a href="mailto:<?php echo esc_attr( antispambot( 'info@progymorava.sk' ) ); ?>"><?php echo esc_html( antispambot( 'info@progymorava.sk' ) ); ?></a>
					<a href="tel:+421944439345">+421 944 439 345</a>
				</div>
			<?php endif; ?>
		</div>

		<nav class="pg-footer__column" aria-label="Navigácia">
			<h2>Navigácia</h2>
			<a href="<?php echo esc_url( $home_url ); ?>">Domov</a>
			<a href="<?php echo esc_url( home_url( '/aboutus/' ) ); ?>">O nás</a>
			<a href="<?php echo esc_url( home_url( '/prices/' ) ); ?>">Cenník</a>
			<a href="<?php echo esc_url( home_url( '/events/' ) ); ?>">Organizujeme</a>
			<?php if ( $include_contact_link ) : ?>
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Kontakt</a>
			<?php endif; ?>
		</nav>

		<?php if ( $include_services ) : ?>
			<nav class="pg-footer__column" aria-label="Služby">
				<h2>Služby</h2>
				<a href="<?php echo esc_url( home_url( '/services/#coaches' ) ); ?>">Osobné tréningy</a>
				<a href="<?php echo esc_url( home_url( '/services/#nutrition' ) ); ?>">Výživa</a>
				<a href="<?php echo esc_url( home_url( '/services/#physiotherapy' ) ); ?>">Fyzioterapia</a>
				<?php if ( $extended_services ) : ?>
					<a href="<?php echo esc_url( home_url( '/prices/#trainer-app' ) ); ?>">Aplikácia ProGym</a>
					<a href="<?php echo esc_url( home_url( '/prices/#faq' ) ); ?>">Časté otázky</a>
				<?php endif; ?>
			</nav>
		<?php endif; ?>

		<?php if ( $include_follow ) : ?>
			<nav class="pg-footer__column" aria-label="Sledujte nás">
				<h2>Sledujte nás</h2>
				<a href="https://facebook.com" target="_blank" rel="noopener noreferrer">Facebook</a>
				<a href="https://instagram.com" target="_blank" rel="noopener noreferrer">Instagram</a>
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Hlavná ulica 1587/99, Zákamenné</a>
			</nav>
		<?php endif; ?>
	</div>

	<div class="pg-footer__bottom">
		<span>&copy; 2026 ProGym. Všetky práva vyhradené.</span>
		<span>Trénujte s cieľom.</span>
	</div>
</footer>
