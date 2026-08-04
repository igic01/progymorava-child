<?php
/**
 * Template Name: ProGym Rental Calculator
 * Template Post Type: page
 *
 * Static rental-price calculator page.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

get_header( 'home' );

$theme_images_url = get_stylesheet_directory_uri() . '/assets/images';

get_template_part(
	'template-parts/shared/site',
	'header',
	array(
		'active_page' => 'prices',
		'cta_target'  => '#calculator',
	)
);
?>

<main class="pg-calc" id="calculator">
	<section class="pg-calc__hero">
		<div class="pg-calc__hero-inner" style="--pg-calc-hero-image: url('<?php echo esc_url( $theme_images_url . '/placeholder.jpg' ); ?>');">
			<p class="pg-calc__eyebrow">Prenájom priestorov</p>
			<h1>Vypočítajte si cenu prenájmu</h1>
			<p>Jednoduchý prehľad ceny za priestor podľa času a počtu hodín, ktoré chcete rezervovať každý mesiac.</p>
		</div>
	</section>

	<section class="pg-calc__panel" aria-label="Kalkulačka prenájmu">
		<p class="pg-calc__intro">Vyberte počet hodín za mesiac. Objemovú zľavu automaticky zarátame do výslednej ceny.</p>

		<div class="pg-calc__layout">
			<div class="pg-calc__primary">
				<section class="pg-calc__rates" aria-label="Cenník prenájmu">
					<article class="pg-calc__rate">
						<span class="pg-calc__tag">Off-peak</span>
						<div class="pg-calc__rate-price">10 € <span>/ hod.</span></div>
						<p>Po–Pi: 10:00–16:00, 20:00–22:00<br>Víkend: mimo špičky</p>
					</article>
					<article class="pg-calc__rate pg-calc__rate--prime">
						<span class="pg-calc__tag">Primetime</span>
						<div class="pg-calc__rate-price">15 € <span>/ hod.</span></div>
						<p>Po–Pi: 07:00–10:00<br>Po–Pi: 16:00–20:00</p>
					</article>
				</section>

				<section class="pg-calc__discounts" aria-labelledby="pg-calc-discounts-title">
					<h2 id="pg-calc-discounts-title">Množstevné zľavy</h2>
					<div class="pg-calc__table-wrap">
						<table class="pg-calc__table">
							<thead><tr><th>Hodín / mesiac</th><th>Zľava</th><th>Eff. off-peak</th><th>Eff. primetime</th></tr></thead>
							<tbody id="pg-calc-discount-rows"></tbody>
						</table>
					</div>
				</section>
			</div>

			<section class="pg-calc__booking" aria-labelledby="pg-calc-booking-title">
				<div>
					<h2 id="pg-calc-booking-title">Vaša rezervácia</h2>
					<div class="pg-calc__fields">
						<label>Hodiny mimo špičky<input id="pg-calc-hours-off" type="number" min="0" value="0" inputmode="numeric"></label>
						<label>Hodiny v špičke<input id="pg-calc-hours-prime" type="number" min="0" value="0" inputmode="numeric"></label>
					</div>
					<div class="pg-calc__tier" id="pg-calc-tier"></div>
				</div>

				<aside class="pg-calc__summary">
					<p>Mesačný prehľad</p>
					<div><span>Hodiny celkom</span><strong id="pg-calc-total-hours">—</strong></div>
					<div><span>Cena bez zľavy</span><strong id="pg-calc-full-price">—</strong></div>
					<div><span>Vaša úspora</span><strong class="pg-calc__saving" id="pg-calc-saving">—</strong></div>
					<div class="pg-calc__summary-total"><span>Cena po zľave</span><strong id="pg-calc-final-price">—</strong></div>
				</aside>
			</section>
		</div>
	</section>
</main>

<?php
get_template_part(
	'template-parts/shared/site',
	'footer',
	array(
		'extended_services' => true,
		'include_follow'    => true,
	)
);

get_footer( 'home' );
