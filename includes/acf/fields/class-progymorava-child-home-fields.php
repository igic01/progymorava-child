<?php
/**
 * Home page ACF field registration.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the fields used by the ProGym Home page template.
 */
class Progymorava_Child_Home_Fields {
	/**
	 * Get the saved number of training cards for dynamic ACF registration.
	 *
	 * @return int
	 */
	public static function training_card_count() {
		return Progymorava_Child_Acf_Page_Context::count_field( 'home_training_card_count', 3 );
	}

	/**
	 * Keep the original first-three field names compatible with saved content.
	 *
	 * @param int $number One-based card number.
	 * @return string
	 */
	public static function training_card_suffix( $number ) {
		$legacy_suffixes = array( 1 => 'one', 2 => 'two', 3 => 'three' );

		return isset( $legacy_suffixes[ $number ] ) ? $legacy_suffixes[ $number ] : (string) $number;
	}

	/**
	 * Register ACF hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'acf/init', array( __CLASS__, 'register_fields' ) );
		add_filter( 'acf/fields/relationship/query', array( __CLASS__, 'limit_gallery_media' ), 10, 3 );
	}

	/**
	 * Limit the home gallery selector to image and video attachments.
	 *
	 * @param array      $args    Relationship query arguments.
	 * @param array      $field   ACF field settings.
	 * @param string|int $post_id Edited post ID.
	 * @return array
	 */
	public static function limit_gallery_media( $args, $field, $post_id ) {
		$field_name = isset( $field['name'] ) ? (string) $field['name'] : '';

		if ( 'home_gallery_media' === $field_name ) {
			$args['post_type']      = array( 'attachment' );
			$args['post_mime_type'] = array( 'image', 'video' );
		}

		return $args;
	}

	/**
	 * Register the Home page field group locally.
	 *
	 * @return void
	 */
	public static function register_fields() {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		$fields               = new Progymorava_Child_Acf_Field_Builder( 'field_pg_home_' );
		$image_settings       = array(
			'return_format' => 'array',
			'preview_size'  => 'medium',
			'library'       => 'all',
		);
		$placeholder_image_id = progymorava_child_home_placeholder_image_id();
		$textarea_settings    = array(
			'rows'      => 3,
			'new_lines' => '',
		);
		$default_url          = 'https://www.google.com/';

		$fields->tab( 'app_stripe_tab', 'Lišta aplikácie' );
		$fields->field(
			'app_stripe_hide',
			'Vypnúť lištu aplikácie',
			'home_app_stripe_hide',
			'true_false',
			0,
			array(
				'ui'           => 1,
				'instructions' => 'Po zapnutí sa lišta v hornej časti domovskej stránky nebude zobrazovať.',
			)
		);
		$fields->field( 'app_stripe_text', 'Text lišty', 'home_app_stripe_text', 'text', 'Stiahni si našu aplikáciu a vychutnaj si progym na vlastnej koži' );
		$fields->field( 'app_stripe_apple_url', 'Odkaz pre Apple', 'home_app_stripe_apple_url', 'url', 'https://apps.apple.com/us/app/progym-orava-z%C3%A1kamenn%C3%A9/id6791676566' );
		$fields->field( 'app_stripe_android_url', 'Odkaz pre Android', 'home_app_stripe_android_url', 'url', 'https://play.google.com/store/apps/details?id=com.progymorava' );

		$fields->tab( 'hero_tab', 'Hero' );
		$fields->field( 'hero_hide_section', 'Hide this section', 'home_hero_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$fields->field( 'hero_image', 'Hero image', 'home_hero_image', 'image', $placeholder_image_id, $image_settings );
		$fields->field( 'hero_badge', 'Badge', 'home_hero_badge', 'text', 'Open 24/7' );
		$fields->field( 'hero_headline', 'Hero headline', 'home_hero_headline', 'textarea', "Inside\nand\nout.", array_merge( $textarea_settings, array( 'rows' => 3, 'instructions' => 'Enter one line per row. The final line keeps the green accent.' ) ) );
		$fields->field( 'hero_summary', 'Summary', 'home_hero_summary', 'textarea', 'We build stronger bodies with focused coaching, premium equipment, and a high-performance space designed to keep your training consistent.', $textarea_settings );
		$fields->field( 'hero_action_label', 'Action label', 'home_hero_action_label', 'text', 'Start now' );
		$fields->field( 'hero_action_url', 'Action URL', 'home_hero_action_url', 'url', $default_url );

		$fields->tab( 'training_tab', 'Training' );
		$fields->field( 'training_card_count', 'Počet tréningových kariet', 'home_training_card_count', 'number', 3, array( 'min' => 0, 'step' => 1, 'instructions' => 'Po zmene tohto počtu stránku uložte a potom obnovte editor, aby sa zobrazili vygenerované polia kariet.' ) );
		$fields->field( 'training_hide_section', 'Hide this section', 'home_training_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$fields->field( 'training_eyebrow', 'Section heading', 'home_training_eyebrow', 'text', 'Trainings' );
		$fields->field( 'training_link_label', 'Section link label', 'home_training_link_label', 'text', 'See all' );
		$fields->field( 'training_link_url', 'Section link URL', 'home_training_link_url', 'url', $default_url );

		$training_card_defaults = array(
			array( 'Personal training', 'Private training with a personal trainer' ),
			array( 'Group fitness classes', 'Group fitness training session' ),
			array( 'Functional training', 'Functional fitness training session' ),
		);

		for ( $number = 1; $number <= self::training_card_count(); $number++ ) {
			$suffix  = self::training_card_suffix( $number );
			$default = isset( $training_card_defaults[ $number - 1 ] )
				? $training_card_defaults[ $number - 1 ]
				: array( 'Training card ' . $number, 'Gym training session' );
			$prefix  = 'home_training_card_' . $suffix;

			$fields->field( 'training_card_' . $suffix . '_title', 'Training card ' . $number . ' title', $prefix . '_title', 'text', $default[0] );
			$fields->field( 'training_card_' . $suffix . '_url', 'Training card ' . $number . ' URL', $prefix . '_url', 'url', $default_url );
			$fields->field( 'training_card_' . $suffix . '_image', 'Training card ' . $number . ' image', $prefix . '_image', 'image', $placeholder_image_id, $image_settings );
		}

		$fields->tab( 'promo_tab', 'Promotion' );
		$fields->field( 'promo_hide_section', 'Hide this section', 'home_promo_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$fields->field( 'promo_eyebrow', 'Eyebrow', 'home_promo_eyebrow', 'text', 'Limited offer' );
		$fields->field( 'promo_title', 'Title', 'home_promo_title', 'text', 'Three months. More momentum.' );
		$fields->field( 'promo_text', 'Description', 'home_promo_text', 'textarea', 'Start your routine with a special three-month membership offer and give your progress time to build.', $textarea_settings );
		$fields->field( 'promo_price_label', 'Price label', 'home_promo_price_label', 'text', 'Three-month membership' );
		$fields->field( 'promo_price', 'Promotional price', 'home_promo_price', 'text', '90€' );
		$fields->field( 'promo_regular_label', 'Regular price label', 'home_promo_regular_label', 'text', 'Regularly' );
		$fields->field( 'promo_regular_price', 'Regular price', 'home_promo_regular_price', 'text', '115€' );
		$fields->field( 'promo_action_label', 'Action label', 'home_promo_action_label', 'text', 'View price list' );
		$fields->field( 'promo_action_url', 'Action URL', 'home_promo_action_url', 'url', $default_url );
		$fields->field( 'promo_gallery_title', 'Nadpis fotografickej karty', 'home_promo_gallery_title', 'text', 'Nahliadni do ProGym' );
		$fields->field( 'promo_gallery_image_one', 'Prvá fotografia', 'home_promo_gallery_image_one', 'image', $placeholder_image_id, $image_settings );
		$fields->field( 'promo_gallery_image_two', 'Druhá fotografia', 'home_promo_gallery_image_two', 'image', $placeholder_image_id, $image_settings );
		$fields->field( 'promo_gallery_image_three', 'Tretia fotografia', 'home_promo_gallery_image_three', 'image', $placeholder_image_id, $image_settings );
		$fields->field( 'promo_gallery_button_label', 'Text tlačidla fotografickej karty', 'home_promo_gallery_button_label', 'text', 'Pozrieť galériu' );
		$fields->field( 'promo_gallery_button_url', 'URL tlačidla fotografickej karty', 'home_promo_gallery_button_url', 'url', $default_url );

		$fields->tab( 'why_tab', 'Why us' );
		$fields->field( 'why_hide_section', 'Hide this section', 'home_why_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$fields->field( 'why_eyebrow', 'Eyebrow', 'home_why_eyebrow', 'text', 'Why us' );
		$fields->field( 'why_title_before', 'Title first part', 'home_why_title_before', 'text', 'Train with' );
		$fields->field( 'why_title_mark', 'Title highlighted part', 'home_why_title_mark', 'text', 'purpose' );
		$fields->field( 'why_lead', 'Lead text', 'home_why_lead', 'textarea', 'Built for people who want consistency, expert guidance, and a gym environment that supports real progress every day of the week.', $textarea_settings );
		$fields->field( 'why_image', 'Why us image', 'home_why_image', 'image', $placeholder_image_id, $image_settings );
		$fields->field( 'why_item_one_icon', 'First item icon', 'home_why_item_one_icon', 'text', '24' );
		$fields->field( 'why_item_one_title', 'First item title', 'home_why_item_one_title', 'text', '24/7 Access' );
		$fields->field( 'why_item_one_text', 'First item text', 'home_why_item_one_text', 'textarea', 'Train early, late, or between shifts with round-the-clock entry that keeps your routine under your control.', $textarea_settings );
		$fields->field( 'why_item_two_icon', 'Second item icon', 'home_why_item_two_icon', 'text', 'EQ' );
		$fields->field( 'why_item_two_title', 'Second item title', 'home_why_item_two_title', 'text', 'Modern Equipment' );
		$fields->field( 'why_item_two_text', 'Second item text', 'home_why_item_two_text', 'textarea', 'Use reliable machines, quality free weights, and performance-focused training stations built for serious work.', $textarea_settings );
		$fields->field( 'why_item_three_icon', 'Third item icon', 'home_why_item_three_icon', 'text', 'CE' );
		$fields->field( 'why_item_three_title', 'Third item title', 'home_why_item_three_title', 'text', 'Certified Experts' );
		$fields->field( 'why_item_three_text', 'Third item text', 'home_why_item_three_text', 'textarea', 'Work with experienced coaches who know technique, progression, and how to turn effort into sustainable results.', $textarea_settings );

		$fields->tab( 'motivation_tab', 'Motivation' );
		$fields->field( 'motivation_hide_section', 'Hide this section', 'home_motivation_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$fields->field( 'motivation_image', 'Motivation image', 'home_motivation_image', 'image', $placeholder_image_id, $image_settings );
		$fields->field( 'motivation_eyebrow', 'Eyebrow', 'home_motivation_eyebrow', 'text', 'Stay consistent' );
		$fields->field( 'motivation_quote_before', 'Quote first part', 'home_motivation_quote_before', 'text', 'Strong habits.' );
		$fields->field( 'motivation_quote_mark', 'Quote highlighted part', 'home_motivation_quote_mark', 'text', 'Stronger you.' );
		$fields->field( 'motivation_text', 'Text', 'home_motivation_text', 'textarea', 'Progress is not built in one perfect day. It is built by showing up again, training with intent, and choosing not to stop when it gets difficult.', $textarea_settings );
		$fields->field( 'motivation_button_label', 'Button label', 'home_motivation_button_label', 'text', 'Register now' );
		$fields->field( 'motivation_button_url', 'Button URL', 'home_motivation_button_url', 'url', $default_url );
		$fields->field( 'motivation_hint', 'Hint', 'home_motivation_hint', 'text', 'Your next level starts with one decision' );

		$fields->tab( 'gallery_tab', 'Galéria' );
		$fields->field( 'gallery_hide_section', 'Skryť túto sekciu', 'home_gallery_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$fields->field( 'gallery_eyebrow', 'Malý nadpis', 'home_gallery_eyebrow', 'text', 'Galéria' );
		$fields->field( 'gallery_title', 'Nadpis galérie', 'home_gallery_title', 'text', 'Pozrite si ProGym zblízka' );
		$fields->field(
			'gallery_media',
			'Obrázky a videá',
			'home_gallery_media',
			'relationship',
			null,
			array(
				'post_type'     => array( 'attachment' ),
				'filters'       => array( 'search' ),
				'return_format' => 'object',
				'instructions'  => 'Vyberte obrázky alebo videá z knižnice médií. Príspevky nie je možné vybrať.',
			)
		);

		$fields->tab( 'app_popup_tab', 'Popup aplikácie' );
		$fields->field(
			'app_popup_enabled',
			'Zobraziť popup aplikácie',
			'home_app_popup_enabled',
			'true_false',
			1,
			array(
				'ui'           => 1,
				'instructions' => 'Popup sa návštevníkovi zobrazí iba pri prvej návšteve domovskej stránky v danom prehliadači.',
			)
		);
		$fields->field( 'app_popup_phone_image', 'Obrázok obrazovky telefónu', 'home_app_popup_phone_image', 'image', null, array_merge( $image_settings, array( 'instructions' => 'Použite zvislý obrázok alebo snímku obrazovky aplikácie.' ) ) );
		$fields->field( 'app_popup_eyebrow', 'Malý nadpis', 'home_app_popup_eyebrow', 'text', 'ProGym vo vrecku' );
		$fields->field( 'app_popup_title_before', 'Prvá časť nadpisu', 'home_app_popup_title_before', 'text', 'Tvoj tréning.' );
		$fields->field( 'app_popup_title_mark', 'Zvýraznená časť nadpisu', 'home_app_popup_title_mark', 'text', 'Vždy poruke.' );
		$fields->field( 'app_popup_description', 'Popis', 'home_app_popup_description', 'textarea', 'Stiahni si aplikáciu ProGym Orava a maj všetko potrebné pre svoj tréning pohodlne vo svojom mobile.', $textarea_settings );
		$fields->field( 'app_popup_button_label', 'Text tlačidla', 'home_app_popup_button_label', 'text', 'Stiahnuť aplikáciu' );
		$fields->field( 'app_popup_google_url', 'URL aplikácie v Google Play', 'home_app_popup_google_url', 'url', 'https://play.google.com/store/apps/details?id=com.progymorava' );
		$fields->field( 'app_popup_apple_url', 'URL aplikácie v App Store', 'home_app_popup_apple_url', 'url', 'https://apps.apple.com/us/app/progym-orava-z%C3%A1kamenn%C3%A9/id6791676566' );
		$fields->field( 'app_popup_availability', 'Text dostupnosti', 'home_app_popup_availability', 'text', 'Dostupné pre iOS a Android' );

		acf_add_local_field_group(
			array(
				'key'       => 'group_pg_home_page',
				'title'     => 'Obsah domovskej stránky ProGym',
				'fields'    => $fields->fields(),
				'location'  => array(
					array(
						array(
							'param'    => 'page_template',
							'operator' => '==',
							'value'    => 'templates/template-home.php',
						),
					),
					array(
						array(
							'param'    => 'page_template',
							'operator' => '==',
							'value'    => 'template-home.php',
						),
					),
				),
				'position'        => 'acf_after_title',
				'label_placement' => 'top',
				'menu_order'      => 0,
				'active'          => true,
				'description'     => 'Tieto polia sa registrujú automaticky a zobrazia sa pod názvom stránok používajúcich šablónu ProGym Home.',
			)
		);
	}
}

Progymorava_Child_Home_Fields::init();
