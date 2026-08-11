<?php
/**
 * Services page ACF field registration.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the local ACF field group used by the Services page template.
 *
 * Counts generate the individual fields so this works with the free ACF
 * plugin: save after changing a count, then refresh the page editor.
 */
class Progymorava_Child_Services_Fields {
	/** @return void */
	public static function init() {
		add_action( 'acf/init', array( __CLASS__, 'register_fields' ) );
		add_filter( 'acf/fields/relationship/query', array( __CLASS__, 'limit_gallery_media' ), 10, 3 );
	}

	/**
	 * Restrict coach-gallery relationship searches to media that the modal can show.
	 *
	 * @param array<string,mixed> $args    WordPress query arguments.
	 * @param array<string,mixed> $field   Current ACF field settings.
	 * @param string|int          $post_id Edited post ID.
	 * @return array<string,mixed>
	 */
	public static function limit_gallery_media( $args, $field, $post_id ) {
		$field_name = isset( $field['name'] ) ? (string) $field['name'] : '';

		if ( 1 === preg_match( '/^services_coach_\d+_gallery$/', $field_name ) ) {
			$args['post_type']      = array( 'attachment' );
			$args['post_mime_type'] = array( 'image', 'video' );
		}

		return $args;
	}

	/** @return int */
	public static function count( $field_name, $fallback ) {
		return Progymorava_Child_Acf_Page_Context::count_field( $field_name, $fallback );
	}

	/** @return void */
	public static function register_fields() {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		$fields             = new Progymorava_Child_Acf_Field_Builder( 'field_pg_services_' );
		$image_settings     = array( 'return_format' => 'array', 'preview_size' => 'medium', 'library' => 'all' );
		$textarea_settings  = array( 'rows' => 3, 'new_lines' => '' );
		$placeholder_image  = progymorava_child_home_placeholder_image_id();
		$coach_defaults     = array(
			array( 'Alex Morgan', 'Strength & conditioning', 'Barbell foundations and sustainable strength', 'Alex helps members build confidence with the fundamentals. His sessions combine precise technique, progressive loading, and a straightforward plan that fits real life.' ),
			array( 'Mia Novak', 'Personal training', 'Goal-led training and body recomposition', 'Mia creates practical, personal programmes for people who want to feel stronger and move better. Expect thoughtful coaching, clear milestones, and plenty of encouragement.' ),
			array( 'Marco Silva', 'Athletic performance', 'Speed, power, and sport-specific conditioning', 'Marco works with athletes and ambitious gym-goers to develop power that carries beyond the gym floor. Every session is built around purposeful movement and measurable progress.' ),
			array( 'Sara Chen', 'Mobility & recovery', 'Movement quality, mobility, and recovery', 'Sara makes recovery an active part of performance. She pairs targeted mobility work with simple habits that help you train consistently and feel ready for the next session.' ),
			array( 'Daniel Reed', 'Group fitness', 'High-energy classes for every fitness level', 'Daniel brings focused energy to every group class. His coaching makes challenging sessions approachable, with scalable options and a strong sense of team momentum.' ),
		);
		$physio_defaults    = array(
			array( 'Elena Varga', 'Sports rehabilitation' ),
			array( 'Tomas Kral', 'Manual therapy' ),
			array( 'Nina Horvat', 'Mobility & recovery' ),
		);
		$fields->tab( 'coaches_tab', 'Gym coaches' );
		$fields->field( 'coaches_hide', 'Hide this section', 'services_coaches_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$fields->field( 'coaches_eyebrow', 'Kicker', 'services_coaches_eyebrow', 'text', 'Meet the team' );
		$fields->field( 'coaches_title', 'Title', 'services_coaches_title', 'text', 'Gym' );
		$fields->field( 'coaches_accent', 'Title accent', 'services_coaches_title_accent', 'text', 'coaches' );
		$fields->field( 'coaches_lead', 'Description', 'services_coaches_lead', 'textarea', 'Meet the people who turn focused sessions into lasting progress. Select a coach to learn more about their approach.', $textarea_settings );
		$fields->field( 'coaches_action_label', 'Button label', 'services_coaches_action_label', 'text', 'View price list' );
		$fields->field( 'coaches_action_url', 'Button URL', 'services_coaches_action_url', 'url', home_url( '/prices/' ) );
		$fields->field( 'coaches_count', 'Coach count', 'services_coaches_count', 'number', 5, array( 'min' => 0, 'step' => 1, 'instructions' => 'Save after changing this number, then refresh the editor to show the generated coach fields.' ) );

		for ( $number = 1; $number <= self::count( 'services_coaches_count', 5 ); $number++ ) {
			$default = isset( $coach_defaults[ $number - 1 ] ) ? $coach_defaults[ $number - 1 ] : array( 'Coach name', 'Coach role', 'Specialty', 'Coach profile text.' );
			$fields->field( 'coach_' . $number . '_image', 'Coach ' . $number . ' profile/card image', 'services_coach_' . $number . '_image', 'image', $placeholder_image, $image_settings );
			$fields->field( 'coach_' . $number . '_name', 'Coach ' . $number . ' name', 'services_coach_' . $number . '_name', 'text', $default[0] );
			$fields->field( 'coach_' . $number . '_role', 'Coach ' . $number . ' role', 'services_coach_' . $number . '_role', 'text', $default[1] );
			$fields->field( 'coach_' . $number . '_specialty', 'Coach ' . $number . ' specialty', 'services_coach_' . $number . '_specialty', 'text', $default[2] );
			$fields->field( 'coach_' . $number . '_bio', 'Coach ' . $number . ' profile text', 'services_coach_' . $number . '_bio', 'textarea', $default[3], $textarea_settings );
			$fields->field(
				'coach_' . $number . '_gallery',
				'Coach ' . $number . ' gallery media',
				'services_coach_' . $number . '_gallery',
				'relationship',
				null,
				array(
					'post_type'     => array( 'attachment' ),
					'filters'       => array( 'search' ),
					'return_format' => 'object',
					'instructions'  => 'Select any number of images or videos for this coach. Only image and video attachments are offered.',
				)
			);
		}

		$fields->tab( 'nutrition_tab', 'Nutrition' );
		$fields->field( 'nutrition_hide', 'Hide this section', 'services_nutrition_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$fields->field( 'nutrition_image', 'Image', 'services_nutrition_image', 'image', $placeholder_image, $image_settings );
		$fields->field( 'nutrition_eyebrow', 'Kicker', 'services_nutrition_eyebrow', 'text', 'Nutrition advisor' );
		$fields->field( 'nutrition_title', 'Title', 'services_nutrition_title', 'text', 'Fuel your' );
		$fields->field( 'nutrition_accent', 'Title accent', 'services_nutrition_title_accent', 'text', 'progress.' );
		$fields->field( 'nutrition_text_one', 'First paragraph', 'services_nutrition_text_one', 'textarea', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis tellus eget nisl finibus vulputate. Donec efficitur, justo id interdum aliquet, massa tellus finibus odio, vitae interdum turpis arcu vitae est.', $textarea_settings );
		$fields->field( 'nutrition_text_two', 'Second paragraph', 'services_nutrition_text_two', 'textarea', 'Praesent vitae tempor tellus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris quis sem eget mi congue pellentesque.', $textarea_settings );
		$fields->field( 'nutrition_action_label', 'Button label', 'services_nutrition_action_label', 'text', 'View price list' );
		$fields->field( 'nutrition_action_url', 'Button URL', 'services_nutrition_action_url', 'url', home_url( '/prices/' ) );

		$fields->tab( 'physio_tab', 'Physiotherapy' );
		$fields->field( 'physio_hide', 'Hide this section', 'services_physio_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$fields->field( 'physio_eyebrow', 'Kicker', 'services_physio_eyebrow', 'text', 'Move with confidence' );
		$fields->field( 'physio_title', 'Title', 'services_physio_title', 'text', 'Physio' );
		$fields->field( 'physio_accent', 'Title accent', 'services_physio_title_accent', 'text', 'therapy' );
		$fields->field( 'physio_lead', 'Description', 'services_physio_lead', 'textarea', 'Focused care for recovery, mobility, and feeling strong in your everyday movement.', $textarea_settings );
		$fields->field( 'physio_count', 'Physiotherapist count', 'services_physio_count', 'number', 3, array( 'min' => 0, 'step' => 1, 'instructions' => 'Save after changing this number, then refresh the editor to show the generated physiotherapist fields.' ) );

		for ( $number = 1; $number <= self::count( 'services_physio_count', 3 ); $number++ ) {
			$default = isset( $physio_defaults[ $number - 1 ] ) ? $physio_defaults[ $number - 1 ] : array( 'Physiotherapist', 'Specialty' );
			$fields->field( 'physio_' . $number . '_image', 'Physiotherapist ' . $number . ' image', 'services_physio_' . $number . '_image', 'image', $placeholder_image, $image_settings );
			$fields->field( 'physio_' . $number . '_name', 'Physiotherapist ' . $number . ' name', 'services_physio_' . $number . '_name', 'text', $default[0] );
			$fields->field( 'physio_' . $number . '_role', 'Physiotherapist ' . $number . ' specialty', 'services_physio_' . $number . '_role', 'text', $default[1] );
			$fields->field( 'physio_' . $number . '_facebook', 'Physiotherapist ' . $number . ' Facebook URL', 'services_physio_' . $number . '_facebook', 'url' );
			$fields->field( 'physio_' . $number . '_instagram', 'Physiotherapist ' . $number . ' Instagram URL', 'services_physio_' . $number . '_instagram', 'url' );
			$fields->field(
				'physio_' . $number . '_phone',
				'Physiotherapist ' . $number . ' phone',
				'services_physio_' . $number . '_phone',
				'text',
				null,
				array( 'instructions' => 'Enter a phone number, for example +421 123 123 123. The phone link will be generated as tel:+421123123123.' )
			);
		}

		$fields->tab( 'prices_cta_tab', 'Price list call to action' );
		$fields->field( 'prices_cta_hide', 'Hide this section', 'services_prices_cta_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$fields->field( 'prices_cta_image', 'Image', 'services_prices_cta_image', 'image', $placeholder_image, $image_settings );
		$fields->field( 'prices_cta_eyebrow', 'Kicker', 'services_prices_cta_eyebrow', 'text', 'Your membership' );
		$fields->field( 'prices_cta_title', 'Title', 'services_prices_cta_title', 'text', 'Make your next move' );
		$fields->field( 'prices_cta_accent', 'Title accent', 'services_prices_cta_title_accent', 'text', 'count.' );
		$fields->field( 'prices_cta_text', 'Description', 'services_prices_cta_text', 'textarea', 'Explore flexible options for training, recovery, and the support that keeps your progress moving.', $textarea_settings );
		$fields->field( 'prices_cta_action_label', 'Button label', 'services_prices_cta_action_label', 'text', 'View price list' );
		$fields->field( 'prices_cta_action_url', 'Button URL', 'services_prices_cta_action_url', 'url', home_url( '/prices/' ) );

		acf_add_local_field_group(
			array(
				'key' => 'group_pg_services_page',
				'title' => 'Obsah stránky služieb ProGym',
				'fields' => $fields->fields(),
				'location' => array(
					array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'templates/template-services.php' ) ),
					array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'template-services.php' ) ),
				),
				'position' => 'acf_after_title',
				'label_placement' => 'top',
				'active' => true,
			)
		);
	}
}

Progymorava_Child_Services_Fields::init();
