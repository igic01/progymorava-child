<?php
/**
 * Events page and event-post ACF field registration.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the local ACF fields used by the Events listing and event posts.
 */
class Progymorava_Child_Events_Fields {
	/**
	 * Register WordPress hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'acf/init', array( __CLASS__, 'register_fields' ) );
	}

	/**
	 * Register the Events page and event-post field groups.
	 *
	 * @return void
	 */
	public static function register_fields() {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		self::register_events_page_fields();
		self::register_event_post_fields();
	}

	/**
	 * Register the relationship field used by the Events page.
	 *
	 * @return void
	 */
	private static function register_events_page_fields() {
		$fields = new Progymorava_Child_Acf_Field_Builder( 'field_pg_' );
		$fields->field(
			'events_posts',
			'Event posts',
			'events_posts',
			'relationship',
			null,
			array(
				'post_type'     => array( 'post' ),
				'filters'       => array( 'search' ),
				'return_format' => 'object',
				'instructions'  => 'Select the posts to show as event cards. Only WordPress posts can be selected.',
			)
		);
		$fields->field( 'events_eyebrow', 'Section kicker', 'events_eyebrow', 'text', 'ProGym gives back' );
		$fields->field( 'events_title', 'Section title', 'events_title', 'text', 'Stronger' );
		$fields->field( 'events_title_accent', 'Section title accent', 'events_title_accent', 'text', 'together.' );

		acf_add_local_field_group(
			array(
				'key'      => 'group_pg_events_page',
				'title'    => 'Obsah stránky podujatí ProGym',
				'fields'   => $fields->fields(),
				'location' => array(
					array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'templates/template-events.php' ) ),
					array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'template-events.php' ) ),
				),
				'position' => 'acf_after_title',
				'active'   => true,
			)
		);
	}

	/**
	 * Register content fields available on normal WordPress posts.
	 *
	 * @return void
	 */
	private static function register_event_post_fields() {
		$fields = new Progymorava_Child_Acf_Field_Builder( 'field_pg_event_' );
		$fields->field(
			'images',
			'Event images',
			'event_images',
			'relationship',
			null,
			array(
				'post_type'     => array( 'attachment' ),
				'filters'       => array( 'search' ),
				'return_format' => 'object',
				'max'           => 3,
				'instructions'  => 'Select up to three images from the Media Library.',
			)
		);
		$fields->field( 'main_title', 'Main title', 'event_main_title' );
		$fields->field( 'small_title', 'Small title', 'event_small_title' );
		$fields->field( 'year', 'Year', 'event_year', 'number', null, array( 'min' => 0, 'step' => 1 ) );
		$fields->field( 'short_description_one', 'Short description 1', 'event_short_description_one', 'textarea', null, array( 'rows' => 3, 'new_lines' => '' ) );
		$fields->field( 'short_description_two', 'Short description 2', 'event_short_description_two', 'textarea', null, array( 'rows' => 3, 'new_lines' => '' ) );
		$fields->field( 'full_description', 'Full description', 'event_full_description', 'wysiwyg', null, array( 'tabs' => 'all', 'toolbar' => 'full', 'media_upload' => 1 ) );

		acf_add_local_field_group(
			array(
				'key'      => 'group_pg_event_post',
				'title'    => 'Obsah príspevku o podujatí ProGym',
				'fields'   => $fields->fields(),
				'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'post' ) ) ),
				'position' => 'acf_after_title',
				'active'   => true,
			)
		);
	}
}

Progymorava_Child_Events_Fields::init();
