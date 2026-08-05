<?php
/**
 * Rental calculator page ACF field registration.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers editable content and pricing fields for the rental calculator.
 */
class Progymorava_Child_Rental_Calculator_Fields {
	/**
	 * Register ACF hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'acf/init', array( __CLASS__, 'register_fields' ) );
	}

	/**
	 * Default editable discount table.
	 *
	 * The calculator reads the range from column one and the effective hourly
	 * rates from columns three and four.
	 *
	 * @return string
	 */
	public static function default_table() {
		return '<table><thead><tr><th>Hodín / mesiac</th><th>Zľava</th><th>Eff. mimo špičky</th><th>Eff. v špičke</th></tr></thead><tbody>'
			. '<tr><td>1–2 hod.</td><td>20 € / hod.</td><td>20,00 €</td><td>20,00 €</td></tr>'
			. '<tr><td>3–9 hod.</td><td>—</td><td>10,00 €</td><td>15,00 €</td></tr>'
			. '<tr><td>10–19 hod.</td><td>−5 %</td><td>9,50 €</td><td>14,25 €</td></tr>'
			. '<tr><td>20–29 hod.</td><td>−10 %</td><td>9,00 €</td><td>13,50 €</td></tr>'
			. '<tr><td>30–49 hod.</td><td>−15 %</td><td>8,50 €</td><td>12,75 €</td></tr>'
			. '<tr><td>50+ hod.</td><td>−20 %</td><td>8,00 €</td><td>12,00 €</td></tr>'
			. '</tbody></table>';
	}

	/**
	 * Register the calculator field group locally.
	 *
	 * @return void
	 */
	public static function register_fields() {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		$fields   = new Progymorava_Child_Acf_Field_Builder( 'field_pg_rental_calc_' );
		$textarea = array(
			'rows'      => 3,
			'new_lines' => '',
		);
		$image    = array(
			'return_format' => 'array',
			'preview_size'  => 'medium',
			'library'       => 'all',
		);

		$fields->tab( 'hero_tab', 'Úvodná sekcia' );
		$fields->field( 'hero_image', 'Obrázok úvodnej sekcie', 'rental_calc_hero_image', 'image', progymorava_child_home_placeholder_image_id(), $image );
		$fields->field( 'hero_eyebrow', 'Malý nadpis', 'rental_calc_hero_eyebrow', 'text', 'Prenájom priestorov' );
		$fields->field( 'hero_title', 'Hlavný nadpis', 'rental_calc_hero_title', 'text', 'Vypočítajte si cenu prenájmu' );
		$fields->field( 'hero_description', 'Popis', 'rental_calc_hero_description', 'textarea', 'Jednoduchý prehľad ceny za priestor podľa času a počtu hodín, ktoré chcete rezervovať každý mesiac.', $textarea );

		$fields->tab( 'rates_tab', 'Sadzby a zľavy' );
		$fields->field( 'intro', 'Úvodný text kalkulačky', 'rental_calc_intro', 'textarea', 'Vyberte počet hodín za mesiac. Objemovú zľavu automaticky zarátame do výslednej ceny.', $textarea );
		$fields->field( 'off_tag', 'Názov sadzby mimo špičky', 'rental_calc_off_tag', 'text', 'Off-peak' );
		$fields->field( 'off_rate', 'Cena za hodinu mimo špičky', 'rental_calc_off_rate', 'number', 10, array( 'min' => 0, 'step' => 0.01 ) );
		$fields->field( 'off_description', 'Popis času mimo špičky', 'rental_calc_off_description', 'textarea', "Po–Pi: 10:00–16:00, 20:00–22:00\nVíkend: mimo špičky", array_merge( $textarea, array( 'rows' => 2 ) ) );
		$fields->field( 'prime_tag', 'Názov sadzby v špičke', 'rental_calc_prime_tag', 'text', 'Primetime' );
		$fields->field( 'prime_rate', 'Cena za hodinu v špičke', 'rental_calc_prime_rate', 'number', 15, array( 'min' => 0, 'step' => 0.01 ) );
		$fields->field( 'prime_description', 'Popis času v špičke', 'rental_calc_prime_description', 'textarea', "Po–Pi: 07:00–10:00\nPo–Pi: 16:00–20:00", array_merge( $textarea, array( 'rows' => 2 ) ) );
		$fields->field( 'rate_suffix', 'Text za cenou', 'rental_calc_rate_suffix', 'text', '/ hod.' );
		$fields->field( 'discounts_title', 'Nadpis tabuľky', 'rental_calc_discounts_title', 'text', 'Množstevné zľavy' );
		$fields->field(
			'discount_table',
			'Tabuľka sadzieb a zliav',
			'rental_calc_discount_table',
			'wysiwyg',
			self::default_table(),
			array(
				'tabs'         => 'all',
				'toolbar'      => 'full',
				'media_upload' => 0,
				'instructions' => 'Ponechajte štyri stĺpce. V prvom stĺpci zadajte rozsah, napr. 10–19 alebo 50+. Tretí a štvrtý stĺpec musia obsahovať efektívnu hodinovú cenu. Kalkulačka číta hodnoty priamo z tejto tabuľky.',
			)
		);

		$fields->tab( 'booking_tab', 'Rezervácia a výsledok' );
		$fields->field( 'booking_title', 'Nadpis rezervácie', 'rental_calc_booking_title', 'text', 'Vaša rezervácia' );
		$fields->field( 'off_input_label', 'Popis hodín mimo špičky', 'rental_calc_off_input_label', 'text', 'Hodiny mimo špičky' );
		$fields->field( 'prime_input_label', 'Popis hodín v špičke', 'rental_calc_prime_input_label', 'text', 'Hodiny v špičke' );
		$fields->field( 'current_label', 'Nadpis aktuálneho nastavenia', 'rental_calc_current_label', 'text', 'Aktuálne nastavenie' );
		$fields->field( 'empty_message', 'Text pred zadaním hodín', 'rental_calc_empty_message', 'text', 'Zadajte počet hodín pre výpočet ceny.' );
		$fields->field( 'hours_suffix', 'Text za počtom hodín', 'rental_calc_hours_suffix', 'text', 'hod.' );
		$fields->field( 'summary_title', 'Nadpis mesačného prehľadu', 'rental_calc_summary_title', 'text', 'Mesačný prehľad' );
		$fields->field( 'total_hours_label', 'Popis celkového počtu hodín', 'rental_calc_total_hours_label', 'text', 'Hodiny celkom' );
		$fields->field( 'full_price_label', 'Popis ceny bez zľavy', 'rental_calc_full_price_label', 'text', 'Cena bez zľavy' );
		$fields->field( 'saving_label', 'Popis úspory', 'rental_calc_saving_label', 'text', 'Vaša úspora' );
		$fields->field( 'final_price_label', 'Popis výslednej ceny', 'rental_calc_final_price_label', 'text', 'Cena po zľave' );

		acf_add_local_field_group(
			array(
				'key'             => 'group_pg_rental_calculator_page',
				'title'           => 'Obsah kalkulačky prenájmu ProGym',
				'fields'          => $fields->fields(),
				'location'        => array(
					array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'templates/template-rental-calculator.php' ) ),
					array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'template-rental-calculator.php' ) ),
				),
				'position'        => 'acf_after_title',
				'label_placement' => 'top',
				'menu_order'      => 0,
				'active'          => true,
				'description'     => 'Polia pre texty, sadzby, tabuľku a výsledok kalkulačky prenájmu.',
			)
		);
	}
}

Progymorava_Child_Rental_Calculator_Fields::init();
