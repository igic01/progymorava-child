<?php
/**
 * About Us page ACF field registration.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the local ACF field group used by the About Us page template.
 */
class Progymorava_Child_About_Fields {
	/**
	 * Register WordPress hooks for this field group.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'acf/init', array( __CLASS__, 'register_fields' ) );
	}

	/**
	 * Get the saved team-member count for the page currently being edited.
	 *
	 * The count controls the number of generated image, name, and role fields.
	 * Editors must save after changing it, then refresh the editor.
	 *
	 * @return int
	 */
	public static function team_member_count() {
		return Progymorava_Child_Acf_Page_Context::count_field( 'about_team_member_count', 9 );
	}

	/**
	 * Register the About Us page fields locally.
	 *
	 * @return void
	 */
	public static function register_fields() {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		$builder = new Progymorava_Child_Acf_Field_Builder( 'field_pg_about_' );
		$image_settings = array(
			'return_format' => 'array',
			'preview_size'  => 'medium',
			'library'       => 'all',
		);
		$textarea_settings = array(
			'rows'      => 3,
			'new_lines' => '',
		);
		$placeholder_image_id = progymorava_child_home_placeholder_image_id();
		$default_url          = 'https://www.google.com/';

		$builder->tab( 'mission_tab', 'Mission' );
		$builder->field( 'mission_hide_section', 'Hide this section', 'about_mission_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$builder->field( 'mission_kicker', 'Kicker', 'about_mission_kicker', 'text', 'Our mission' );
		$builder->field( 'mission_title', 'Title', 'about_mission_title', 'textarea', 'We build stronger people, not just stronger workouts.', $textarea_settings );
		$builder->field( 'mission_text_one', 'First paragraph', 'about_mission_text_one', 'textarea', 'Our mission is to create a gym environment where progress feels clear, coaching feels personal, and every client knows exactly why they are improving. We combine modern training, real human guidance, and long-term discipline into a system that helps people become better.', $textarea_settings );
		$builder->field( 'mission_text_two', 'Second paragraph', 'about_mission_text_two', 'textarea', 'This is not just about intensity. It is about consistency, smart structure, and the confidence that comes from training with purpose.', $textarea_settings );
		$builder->field( 'mission_image', 'Image', 'about_mission_image', 'image', $placeholder_image_id, $image_settings );

		$builder->tab( 'team_tab', 'Team' );
		$builder->field( 'team_hide_section', 'Hide this section', 'about_team_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$builder->field( 'team_kicker', 'Kicker', 'about_team_kicker', 'text', 'About us' );
		$builder->field( 'team_title', 'Title', 'about_team_title', 'text', 'Meet the coaches.' );
		$builder->field( 'team_text', 'Description', 'about_team_text', 'textarea', 'A compact team section with a draggable member rail. Pull the lineup to the side and browse all nine people without breaking the clean layout.', $textarea_settings );
		$builder->field( 'team_drag_label', 'Drag hint', 'about_team_drag_label', 'text', 'Drag to explore' );
		$builder->field( 'team_member_count', 'Team members count', 'about_team_member_count', 'number', 9, array( 'min' => 0, 'step' => 1, 'instructions' => 'Save the page after changing this number, then refresh the editor to show the generated member fields.' ) );

		$team_member_count = self::team_member_count();

		for ( $index = 0; $index < $team_member_count; $index++ ) {
			$number = $index + 1;
			$builder->field( 'team_member_' . $number . '_image', 'Member ' . $number . ' image', 'about_team_member_' . $number . '_image', 'image', $placeholder_image_id, $image_settings );
			$builder->field( 'team_member_' . $number . '_name', 'Member ' . $number . ' name', 'about_team_member_' . $number . '_name', 'text', 'Name' );
			$builder->field( 'team_member_' . $number . '_role', 'Member ' . $number . ' role', 'about_team_member_' . $number . '_role', 'text', 'Role' );
		}

		$builder->field( 'team_end_title', 'End card title', 'about_team_end_title', 'textarea', 'Those are all of our members, ready to help you.', $textarea_settings );
		$builder->field( 'team_end_text', 'End card text', 'about_team_end_text', 'textarea', 'You reached the end of the team list. Every coach in this section is here to support clients with training, guidance, and day-to-day motivation.', $textarea_settings );

		$builder->tab( 'partner_tab', 'Partner' );
		$builder->field( 'partner_hide_section', 'Hide this section', 'about_partner_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$builder->field( 'partner_image', 'Image', 'about_partner_image', 'image', $placeholder_image_id, $image_settings );
		$builder->field( 'partner_kicker', 'Kicker', 'about_partner_kicker', 'text', 'Pro Gym Partner' );
		$builder->field( 'partner_title', 'Title', 'about_partner_title', 'textarea', 'Build your coaching business with us.', $textarea_settings );
		$builder->field( 'partner_text_one', 'First paragraph', 'about_partner_text_one', 'textarea', 'Are you a trainer, instructor, therapist, or movement specialist with your own client base? Bring your expertise to ProGym and work in a professional environment built for consistent, high-quality coaching.', $textarea_settings );
		$builder->field( 'partner_text_two', 'Second paragraph', 'about_partner_text_two', 'textarea', 'We are looking for motivated partners who want to grow their work, support their clients, and become part of an ambitious training community.', $textarea_settings );
		$builder->field( 'partner_action_label', 'Action label', 'about_partner_action_label', 'text', 'Become a partner' );
		$builder->field( 'partner_action_url', 'Action URL', 'about_partner_action_url', 'url', $default_url );
		$builder->field( 'partner_hint', 'Hint', 'about_partner_hint', 'text', 'For trainers, instructors, and movement specialists.' );

		acf_add_local_field_group(
			array(
				'key'       => 'group_pg_about_page',
				'title'     => 'Obsah stránky O nás ProGym',
				'fields'    => $builder->fields(),
				'location'  => array(
					array(
						array(
							'param'    => 'page_template',
							'operator' => '==',
							'value'    => 'templates/template-aboutus.php',
						),
					),
					array(
						array(
							'param'    => 'page_template',
							'operator' => '==',
							'value'    => 'template-aboutus.php',
						),
					),
				),
				'position'        => 'acf_after_title',
				'label_placement' => 'top',
				'menu_order'      => 0,
				'active'          => true,
				'description'     => 'Tieto polia sa registrujú automaticky pre stránky používajúce šablónu ProGym O nás.',
			)
		);
	}
}

Progymorava_Child_About_Fields::init();
