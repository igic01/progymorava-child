<?php
/**
 * Prices page ACF field registration.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

class Progymorava_Child_Prices_Fields {
	/**
	 * Register WordPress hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'acf/init', array( __CLASS__, 'register_fields' ) );
	}

	/**
	 * Read a saved number field for the current page during ACF registration.
	 *
	 * @param string $field_name ACF field name.
	 * @param int    $fallback   Default count.
	 * @return int
	 */
	public static function current_page_count( $field_name, $fallback ) {
		return Progymorava_Child_Acf_Page_Context::count_field( $field_name, $fallback );
	}

	/**
	 * Register local ACF fields for the ProGym Prices template.
	 *
	 * @return void
	 */
	public static function register_fields() {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		$builder     = new Progymorava_Child_Acf_Field_Builder( 'field_pg_prices_' );
		$textarea    = array(
			'rows'      => 3,
			'new_lines' => '',
		);
		$image       = array(
			'return_format' => 'array',
			'preview_size'  => 'medium',
			'library'       => 'all',
		);
		$placeholder_image_id = progymorava_child_home_placeholder_image_id();
		$default_url = 'https://www.google.com/';
		$groups      = array(
			'plans'             => array(
				'label'         => 'Choose your next level.',
				'field_prefix'  => 'prices_plan',
				'default_count' => 5,
				'is_plan'       => true,
			),
			'physio'            => array(
				'label'         => 'Fyzioterapia',
				'field_prefix'  => 'prices_physio',
				'default_count' => 4,
				'is_plan'       => false,
			),
			'nutrition_advisor' => array(
				'label'         => 'Výživový poradca',
				'field_prefix'  => 'prices_nutrition_advisor',
				'default_count' => 3,
				'is_plan'       => false,
			),
		);

		foreach ( $groups as $group_key => $group ) {
			$builder->add_tab( $group_key . '_tab', $group['label'] );

			if ( 'plans' === $group_key ) {
				$builder->add_field( 'plans_eyebrow', 'Eyebrow', 'prices_plans_eyebrow', 'text', 'Pricing' );
				$builder->add_field( 'plans_title', 'Title', 'prices_plans_title', 'text', 'Choose your next level.' );
				$builder->add_field( 'plans_description', 'Description', 'prices_plans_description', 'textarea', 'Flexible options for quick sessions, steady routines, or full-year consistency.', $textarea );
			} elseif ( 'physio' === $group_key ) {
				$builder->add_field( 'physio_section_title', 'Title', 'prices_physio_section_title', 'text', 'Fyzioterapia' );
				$builder->add_field( 'physio_section_description', 'Description', 'prices_physio_section_description', 'textarea', 'Recovery and movement services.', $textarea );
				$builder->add_field( 'physio_section_chip', 'Right-side label', 'prices_physio_section_chip', 'text', 'Recovery' );
			} elseif ( 'nutrition_advisor' === $group_key ) {
				$builder->add_field( 'advisor_section_title', 'Title', 'prices_nutrition_advisor_section_title', 'text', 'Výživový poradca' );
				$builder->add_field( 'advisor_section_description', 'Description', 'prices_nutrition_advisor_section_description', 'textarea', 'Diagnostics, consultations, and meal planning.', $textarea );
				$builder->add_field( 'advisor_section_chip', 'Right-side label', 'prices_nutrition_advisor_section_chip', 'text', 'Nutrition' );
			}

			$count_name = $group['field_prefix'] . '_count';
			$builder->add_field(
				$group_key . '_count',
				'Number of items',
				$count_name,
				'number',
				$group['default_count'],
				array(
					'min'          => 0,
					'step'         => 1,
					'instructions' => 'Save the page after changing this number, then refresh the editor to show the generated fields.',
				)
			);

			$count = self::current_page_count( $count_name, $group['default_count'] );

			for ( $index = 1; $index <= $count; $index++ ) {
				$prefix = $group['field_prefix'] . '_' . $index;

				$builder->add_field( $prefix . '_title', 'Item ' . $index . ' title', $prefix . '_title', 'text', 'Title' );
				$builder->add_field( $prefix . '_description', 'Item ' . $index . ' description', $prefix . '_description', 'textarea', 'Description', $textarea );

				if ( $group['is_plan'] ) {
					$builder->add_field( $prefix . '_badge', 'Item ' . $index . ' badge', $prefix . '_badge', 'text', 'Badge' );
					$builder->add_field( $prefix . '_price', 'Item ' . $index . ' price', $prefix . '_price', 'text', 'Price' );
					$builder->add_field( $prefix . '_action_label', 'Item ' . $index . ' action label', $prefix . '_action_label', 'text', 'Action label' );
					$builder->add_field( $prefix . '_action_url', 'Item ' . $index . ' action URL', $prefix . '_action_url', 'url', $default_url );
					$builder->add_field( $prefix . '_note', 'Item ' . $index . ' note', $prefix . '_note', 'textarea', 'Note', $textarea );
				} else {
					$builder->add_field( $prefix . '_price', 'Item ' . $index . ' price', $prefix . '_price', 'text', 'Price' );
					$builder->add_field( $prefix . '_action_label', 'Item ' . $index . ' action label', $prefix . '_action_label', 'text', 'Action label' );
					$builder->add_field( $prefix . '_action_url', 'Item ' . $index . ' action URL', $prefix . '_action_url', 'url', $default_url );
				}
			}
		}

		$builder->add_tab( 'multisport_tab', 'MultiSport' );
		$builder->add_field( 'multisport_hide_section', 'Hide this section', 'prices_multisport_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$builder->add_field( 'multisport_image', 'Image', 'prices_multisport_image', 'image', $placeholder_image_id, $image );
		$builder->add_field( 'multisport_eyebrow', 'Eyebrow', 'prices_multisport_eyebrow', 'text', 'MultiSport card' );
		$builder->add_field( 'multisport_title', 'Title', 'prices_multisport_title', 'text', 'Train with your MultiSport card.' );
		$builder->add_field( 'multisport_description', 'Description', 'prices_multisport_description', 'textarea', 'MultiSport card holders can use ProGym for their training sessions. Bring your valid card and a photo ID to reception.', $textarea );

		$builder->add_tab( 'trainer_app_tab', 'ProGym app' );
		$builder->add_field( 'trainer_app_eyebrow', 'Eyebrow', 'prices_trainer_app_eyebrow', 'text', 'Personal training' );
		$builder->add_field( 'trainer_app_title', 'Title', 'prices_trainer_app_title', 'text', 'Find your trainer in the ProGym app.' );
		$builder->add_field( 'trainer_app_description', 'Description', 'prices_trainer_app_description', 'textarea', 'Interested in personal training? Download the ProGym Orava app to get in touch with our trainers and find the support that fits your goals.', $textarea );
		$builder->add_field( 'trainer_google_small_label', 'Google Play small label', 'prices_trainer_google_small_label', 'text', 'Get it on' );
		$builder->add_field( 'trainer_google_label', 'Google Play label', 'prices_trainer_google_label', 'text', 'Google Play' );
		$builder->add_field( 'trainer_google_url', 'Google Play URL', 'prices_trainer_google_url', 'url', 'https://play.google.com/store/apps/details?id=com.progymorava' );
		$builder->add_field( 'trainer_apple_small_label', 'App Store small label', 'prices_trainer_apple_small_label', 'text', 'Download on the' );
		$builder->add_field( 'trainer_apple_label', 'App Store label', 'prices_trainer_apple_label', 'text', 'App Store' );
		$builder->add_field( 'trainer_apple_url', 'App Store URL', 'prices_trainer_apple_url', 'url', 'https://apps.apple.com/us/app/progym-orava-z%C3%A1kamenn%C3%A9/id6791676566' );

		$builder->add_tab( 'nutrition_cooperation_tab', 'Nutrition cooperation' );
		$builder->add_field( 'nutrition_eyebrow', 'Eyebrow', 'prices_nutrition_eyebrow', 'text', 'Recommendation' );
		$builder->add_field( 'nutrition_title', 'Title', 'prices_nutrition_title', 'text', 'Choose the depth of cooperation.' );
		$builder->add_field( 'nutrition_description', 'Description', 'prices_nutrition_description', 'textarea', 'Long-term nutrition cooperation tailored to your needs and lifestyle.', $textarea );
		$builder->add_field( 'nutrition_badge_title', 'Badge title', 'prices_nutrition_badge_title', 'text', 'Long-term guidance' );
		$builder->add_field( 'nutrition_badge_text', 'Badge text', 'prices_nutrition_badge_text', 'textarea', 'Habit-focused support without strict short-lived dieting.', $textarea );

		$nutrition_plans = array(
			array(
				'tag'             => '3 months',
				'price'           => '190€',
				'price_label'     => 'Structured start',
				'title'           => '3-mesačná spolupráca',
				'description'     => 'A structured start for practical, sustainable changes to your nutrition habits.',
				'includes_title'  => 'What cooperation includes',
				'includes_items'  => "2x InBody measurement\nIntroductory consultation\n3 follow-up check-in consultations with room for questions\nSample dining plan\nAdditional measurements and consultations with a 10€ discount\nWhatsApp or Messenger communication during cooperation",
				'benefits_title'  => 'What you get',
				'benefits_items'  => "Individual approach according to goals, health, and lifestyle\nBetter energy, regeneration, and performance support\nDiet aligned with your training plan and activity\nSupplement recommendations adjusted to your needs\nSupport for metabolism, digestion, sleep, and stress habits",
				'note'            => 'A strong option if you want guided change with enough time to build better routines.',
				'action_label'    => 'I am interested',
				'featured'        => 0,
			),
			array(
				'tag'             => '6 months',
				'price'           => '350€',
				'price_label'     => 'Deeper transformation',
				'title'           => '6-mesačná spolupráca',
				'description'     => 'Extended cooperation with more space for detailed habit and regime adjustments.',
				'includes_title'  => 'What cooperation includes',
				'includes_items'  => "3x InBody measurement\nIntroductory consultation\n6 follow-up consultations\nTailor-made dining plan and optimisation\nAdditional measurements and consultations with a 10€ discount\nWhatsApp or Messenger communication during cooperation",
				'benefits_title'  => 'What you get extra',
				'benefits_items'  => "More space for detailed habit work and long-term change\nDeeper focus on regeneration and energy balance\nCloser matching of nutrition with training, work rhythm, and lifestyle\nStress management, recovery quality, and sleep support",
				'note'            => 'Best for members who want longer support, more feedback cycles, and deeper optimisation.',
				'action_label'    => 'I am interested',
				'featured'        => 1,
			),
		);

		foreach ( $nutrition_plans as $index => $plan ) {
			$number = $index + 1;
			$prefix = 'prices_nutrition_plan_' . $number;

			$builder->add_field( 'nutrition_plan_' . $number . '_hide', 'Hide this recommendation', $prefix . '_hide', 'true_false', 0, array( 'ui' => 1 ) );
			$builder->add_field( 'nutrition_plan_' . $number . '_featured', 'Plan ' . $number . ' featured', $prefix . '_featured', 'true_false', $plan['featured'], array( 'ui' => 1 ) );
			$builder->add_field( 'nutrition_plan_' . $number . '_tag', 'Plan ' . $number . ' tag', $prefix . '_tag', 'text', $plan['tag'] );
			$builder->add_field( 'nutrition_plan_' . $number . '_price', 'Plan ' . $number . ' price', $prefix . '_price', 'text', $plan['price'] );
			$builder->add_field( 'nutrition_plan_' . $number . '_price_label', 'Plan ' . $number . ' price label', $prefix . '_price_label', 'text', $plan['price_label'] );
			$builder->add_field( 'nutrition_plan_' . $number . '_title', 'Plan ' . $number . ' title', $prefix . '_title', 'text', $plan['title'] );
			$builder->add_field( 'nutrition_plan_' . $number . '_description', 'Plan ' . $number . ' description', $prefix . '_description', 'textarea', $plan['description'], $textarea );
			$builder->add_field( 'nutrition_plan_' . $number . '_includes_title', 'Plan ' . $number . ' first list title', $prefix . '_includes_title', 'text', $plan['includes_title'] );
			$builder->add_field( 'nutrition_plan_' . $number . '_includes_items', 'Plan ' . $number . ' first list items', $prefix . '_includes_items', 'textarea', $plan['includes_items'], array( 'rows' => 7, 'new_lines' => '', 'instructions' => 'Enter one item per line.' ) );
			$builder->add_field( 'nutrition_plan_' . $number . '_benefits_title', 'Plan ' . $number . ' second list title', $prefix . '_benefits_title', 'text', $plan['benefits_title'] );
			$builder->add_field( 'nutrition_plan_' . $number . '_benefits_items', 'Plan ' . $number . ' second list items', $prefix . '_benefits_items', 'textarea', $plan['benefits_items'], array( 'rows' => 7, 'new_lines' => '', 'instructions' => 'Enter one item per line.' ) );
			$builder->add_field( 'nutrition_plan_' . $number . '_note', 'Plan ' . $number . ' note', $prefix . '_note', 'textarea', $plan['note'], $textarea );
			$builder->add_field( 'nutrition_plan_' . $number . '_action_label', 'Plan ' . $number . ' action label', $prefix . '_action_label', 'text', $plan['action_label'] );
			$builder->add_field( 'nutrition_plan_' . $number . '_action_url', 'Plan ' . $number . ' action URL', $prefix . '_action_url', 'url', home_url( '/#register' ) );
		}

		$builder->add_tab( 'room_tab', 'Back room' );
		$builder->add_field( 'room_hide_section', 'Hide this section', 'prices_room_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$builder->add_field( 'room_image', 'Image', 'prices_room_image', 'image', $placeholder_image_id, $image );
		$builder->add_field( 'room_eyebrow', 'Eyebrow', 'prices_room_eyebrow', 'text', 'Back room reservations' );
		$builder->add_field( 'room_title', 'Title', 'prices_room_title', 'text', 'Your activity needs its own space.' );
		$builder->add_field( 'room_description', 'Description', 'prices_room_description', 'textarea', 'Reserve our back room for boxing, Zumba, small group sessions, diagnostics, and performance testing.', $textarea );
		$builder->add_field( 'room_link_text', 'Text odkazového odseku', 'prices_room_link_text', 'text', 'Viac informácií o priestore' );
		$builder->add_field( 'room_link_url', 'URL odkazového odseku', 'prices_room_link_url', 'url', home_url( '/sluzby/' ) );
		$builder->add_field( 'room_action_label', 'Action label', 'prices_room_action_label', 'text', 'Rent the back room' );
		$builder->add_field( 'room_action_url', 'Action URL', 'prices_room_action_url', 'url', home_url( '/kontakt/' ) );

		$builder->add_tab( 'faq_tab', 'FAQ' );
		$builder->add_field( 'faq_eyebrow', 'Eyebrow', 'prices_faq_eyebrow', 'text', 'FAQ' );
		$builder->add_field( 'faq_title', 'Title', 'prices_faq_title', 'text', 'Questions, answered.' );
		$builder->add_field( 'faq_description', 'Description', 'prices_faq_description', 'textarea', 'Everything you may need before your first visit, membership, or training session.', $textarea );
		$builder->add_field(
			'faq_content',
			'FAQ content',
			'prices_faq_content',
			'textarea',
			'',
			array(
				'rows'         => 18,
				'new_lines'    => '',
				'placeholder'  => "T: \"Category title\"\nQ: \"Question\"\nA: \"Answer\"",
				'instructions' => 'Write one entry per line. Use T for a category title, Q for a question, and A for its answer. Start with T; every Q must be followed by A. You cannot repeat T, Q, or A without the required next line between them.',
			)
		);

		acf_add_local_field_group(
			array(
				'key'             => 'group_pg_prices_page',
				'title'           => 'Obsah stránky cenníka ProGym',
				'fields'          => $builder->get_fields(),
				'location'        => array(
					array(
						array(
							'param'    => 'page_template',
							'operator' => '==',
							'value'    => 'templates/template-prices.php',
						),
					),
					array(
						array(
							'param'    => 'page_template',
							'operator' => '==',
							'value'    => 'template-prices.php',
						),
					),
				),
				'position'        => 'acf_after_title',
				'label_placement' => 'top',
				'active'          => true,
			)
		);
	}
}

Progymorava_Child_Prices_Fields::init();
