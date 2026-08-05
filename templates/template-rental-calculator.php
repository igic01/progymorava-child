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

$theme_images_url  = get_stylesheet_directory_uri() . '/assets/images';
$hero_image        = progymorava_child_home_image( 'rental_calc_hero_image', $theme_images_url . '/placeholder.jpg', 'Priestor na prenájom v ProGym Orava' );
$off_rate          = max( 0, (float) progymorava_child_home_field( 'rental_calc_off_rate', 10 ) );
$prime_rate        = max( 0, (float) progymorava_child_home_field( 'rental_calc_prime_rate', 15 ) );
$discount_table    = (string) progymorava_child_home_field( 'rental_calc_discount_table', Progymorava_Child_Rental_Calculator_Fields::default_table() );
$format_rate       = static function ( $rate ) {
	$decimals = floor( $rate ) === $rate ? 0 : 2;

	return number_format_i18n( $rate, $decimals ) . ' €';
};

get_template_part(
	'template-parts/shared/site',
	'header',
	array(
		'active_page' => 'cennik',
	)
);
?>

<main
	class="pg-calc"
	id="calculator"
	data-off-rate="<?php echo esc_attr( $off_rate ); ?>"
	data-prime-rate="<?php echo esc_attr( $prime_rate ); ?>"
	data-current-label="<?php echo esc_attr( progymorava_child_home_field( 'rental_calc_current_label', 'Aktuálne nastavenie' ) ); ?>"
	data-empty-message="<?php echo esc_attr( progymorava_child_home_field( 'rental_calc_empty_message', 'Zadajte počet hodín pre výpočet ceny.' ) ); ?>"
	data-hours-suffix="<?php echo esc_attr( progymorava_child_home_field( 'rental_calc_hours_suffix', 'hod.' ) ); ?>"
>
	<section class="pg-calc__hero">
		<div class="pg-calc__hero-inner" style="--pg-calc-hero-image: url('<?php echo esc_url( $hero_image['url'] ); ?>');">
			<p class="pg-calc__eyebrow"><?php echo esc_html( progymorava_child_home_field( 'rental_calc_hero_eyebrow', 'Prenájom priestorov' ) ); ?></p>
			<h1><?php echo esc_html( progymorava_child_home_field( 'rental_calc_hero_title', 'Vypočítajte si cenu prenájmu' ) ); ?></h1>
			<p><?php echo nl2br( esc_html( progymorava_child_home_field( 'rental_calc_hero_description', 'Jednoduchý prehľad ceny za priestor podľa času a počtu hodín, ktoré chcete rezervovať každý mesiac.' ) ) ); ?></p>
		</div>
	</section>

	<section class="pg-calc__panel" aria-label="Kalkulačka prenájmu">
		<p class="pg-calc__intro"><?php echo nl2br( esc_html( progymorava_child_home_field( 'rental_calc_intro', 'Vyberte počet hodín za mesiac. Objemovú zľavu automaticky zarátame do výslednej ceny.' ) ) ); ?></p>

		<div class="pg-calc__layout">
			<div class="pg-calc__primary">
				<section class="pg-calc__rates" aria-label="Cenník prenájmu">
					<article class="pg-calc__rate">
						<span class="pg-calc__tag"><?php echo esc_html( progymorava_child_home_field( 'rental_calc_off_tag', 'Off-peak' ) ); ?></span>
						<div class="pg-calc__rate-price"><?php echo esc_html( $format_rate( $off_rate ) ); ?> <span><?php echo esc_html( progymorava_child_home_field( 'rental_calc_rate_suffix', '/ hod.' ) ); ?></span></div>
						<p><?php echo nl2br( esc_html( progymorava_child_home_field( 'rental_calc_off_description', "Po–Pi: 10:00–16:00, 20:00–22:00\nVíkend: mimo špičky" ) ) ); ?></p>
					</article>
					<article class="pg-calc__rate pg-calc__rate--prime">
						<span class="pg-calc__tag"><?php echo esc_html( progymorava_child_home_field( 'rental_calc_prime_tag', 'Primetime' ) ); ?></span>
						<div class="pg-calc__rate-price"><?php echo esc_html( $format_rate( $prime_rate ) ); ?> <span><?php echo esc_html( progymorava_child_home_field( 'rental_calc_rate_suffix', '/ hod.' ) ); ?></span></div>
						<p><?php echo nl2br( esc_html( progymorava_child_home_field( 'rental_calc_prime_description', "Po–Pi: 07:00–10:00\nPo–Pi: 16:00–20:00" ) ) ); ?></p>
					</article>
				</section>

				<section class="pg-calc__discounts" aria-labelledby="pg-calc-discounts-title">
					<h2 id="pg-calc-discounts-title"><?php echo esc_html( progymorava_child_home_field( 'rental_calc_discounts_title', 'Množstevné zľavy' ) ); ?></h2>
					<div class="pg-calc__table-wrap">
						<div class="pg-calc__table-content">
							<?php echo wp_kses_post( apply_filters( 'the_content', $discount_table ) ); ?>
						</div>
					</div>
				</section>
			</div>

			<section class="pg-calc__booking" aria-labelledby="pg-calc-booking-title">
				<div>
					<h2 id="pg-calc-booking-title"><?php echo esc_html( progymorava_child_home_field( 'rental_calc_booking_title', 'Vaša rezervácia' ) ); ?></h2>
					<div class="pg-calc__fields">
						<label><?php echo esc_html( progymorava_child_home_field( 'rental_calc_off_input_label', 'Hodiny mimo špičky' ) ); ?><input id="pg-calc-hours-off" type="number" min="0" value="0" inputmode="numeric"></label>
						<label><?php echo esc_html( progymorava_child_home_field( 'rental_calc_prime_input_label', 'Hodiny v špičke' ) ); ?><input id="pg-calc-hours-prime" type="number" min="0" value="0" inputmode="numeric"></label>
					</div>
					<div class="pg-calc__tier" id="pg-calc-tier"></div>
				</div>

				<aside class="pg-calc__summary">
					<p><?php echo esc_html( progymorava_child_home_field( 'rental_calc_summary_title', 'Mesačný prehľad' ) ); ?></p>
					<div><span><?php echo esc_html( progymorava_child_home_field( 'rental_calc_total_hours_label', 'Hodiny celkom' ) ); ?></span><strong id="pg-calc-total-hours">—</strong></div>
					<div><span><?php echo esc_html( progymorava_child_home_field( 'rental_calc_full_price_label', 'Cena bez zľavy' ) ); ?></span><strong id="pg-calc-full-price">—</strong></div>
					<div><span><?php echo esc_html( progymorava_child_home_field( 'rental_calc_saving_label', 'Vaša úspora' ) ); ?></span><strong class="pg-calc__saving" id="pg-calc-saving">—</strong></div>
					<div class="pg-calc__summary-total"><span><?php echo esc_html( progymorava_child_home_field( 'rental_calc_final_price_label', 'Cena po zľave' ) ); ?></span><strong id="pg-calc-final-price">—</strong></div>
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
