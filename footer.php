<?php
/**
 * Default site footer.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

$footer_home_url         = home_url( '/domov/' );
$footer_theme_images_url = get_stylesheet_directory_uri() . '/assets/images';
?>
	<footer class="pg-footer">
		<div class="pg-footer__shell">
			<div class="pg-footer__brand">
				<a class="pg-footer__brand-logo" href="<?php echo esc_url( $footer_home_url ); ?>" aria-label="ProGym home">
					<img src="<?php echo esc_url( $footer_theme_images_url . '/logo dual.svg' ); ?>" alt="ProGym" />
				</a>
				<p class="pg-footer__text">Cielený tréning. Silnejšie návyky. Lepšie výsledky.</p>

				<div class="pg-footer__contact">
					<a href="mailto:<?php echo esc_attr( antispambot( 'info@progymorava.sk' ) ); ?>"><?php echo esc_html( antispambot( 'info@progymorava.sk' ) ); ?></a>
					<a href="tel:+421944439345">+421 944 439 345</a>
					<span class="pg-footer__phone-hours">Na tel. čísle dostupné od 9:00 do 18:00</span>
				</div>
			</div>

			<nav class="pg-footer__column" aria-label="Navigácia">
				<h2>Navigácia</h2>
				<a href="<?php echo esc_url( $footer_home_url ); ?>">Domov</a>
				<a href="<?php echo esc_url( home_url( '/o-nas/' ) ); ?>">O nás</a>
				<a href="<?php echo esc_url( home_url( '/cennik/' ) ); ?>">Cenník</a>
				<a href="https://progymorava.sk/calculator/">Kalkulačka prenájmu</a>
				<a href="<?php echo esc_url( home_url( '/organizujeme/' ) ); ?>">Organizujeme</a>
				<a href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>">Kontakt</a>
			</nav>

			<nav class="pg-footer__column" aria-label="Služby">
				<h2>Služby</h2>
				<a href="<?php echo esc_url( home_url( '/sluzby/#coaches' ) ); ?>">Osobné tréningy</a>
				<a href="<?php echo esc_url( home_url( '/sluzby/#nutrition' ) ); ?>">Výživa</a>
				<a href="<?php echo esc_url( home_url( '/sluzby/#physiotherapy' ) ); ?>">Fyzioterapia</a>
				<a href="<?php echo esc_url( home_url( '/cennik/#trainer-app' ) ); ?>">Aplikácia ProGym</a>
				<a href="<?php echo esc_url( home_url( '/cennik/#faq' ) ); ?>">Časté otázky</a>
			</nav>

			<nav class="pg-footer__column" aria-label="Sledujte nás">
				<h2>Sledujte nás</h2>
				<a href="https://www.facebook.com/progymorava/?locale=sk_SK" target="_blank" rel="noopener noreferrer">Facebook</a>
				<a href="https://www.instagram.com/PROGYM_ORAVA/" target="_blank" rel="noopener noreferrer">Instagram</a>
				<a href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>">Športová 176/7, 029 56 Zákamenné</a>
			</nav>
		</div>

		<div class="pg-footer__bottom">
			<span>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> ProGym. Všetky práva vyhradené.</span>
			<a class="pg-footer__legal-link" href="https://progymorava.sk/vseobecne-obchodne-podmienky/">Všeobecné obchodné podmienky</a>
			<span>Trénujte s cieľom.</span>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>
