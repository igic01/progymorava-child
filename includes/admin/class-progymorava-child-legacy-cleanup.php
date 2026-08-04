<?php
/**
 * One-time cleanup for values seeded by earlier theme versions.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Removes only the original default team values from About Us pages.
 */
class Progymorava_Child_Legacy_Cleanup {
	/**
	 * Register WordPress hooks for legacy cleanup tasks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'admin_init', array( __CLASS__, 'clear_seeded_about_team_values' ) );
	}

	/**
	 * Remove only the original seeded team values from existing About Us pages.
	 *
	 * This migration leaves any client-edited name or role untouched and runs
	 * once for administrators.
	 *
	 * @return void
	 */
	public static function clear_seeded_about_team_values() {
		if ( ! current_user_can( 'manage_options' ) || get_option( 'progymorava_child_team_defaults_cleared' ) ) {
			return;
		}

		$seeded_members = array(
			array( 'Ariana Stone', 'Head Coach' ),
			array( 'Lena Brooks', 'Strength Specialist' ),
			array( 'Mila Carter', 'Mobility Coach' ),
			array( 'Eva Hayes', 'HIIT Instructor' ),
			array( 'Nora Blake', 'Boxing Coach' ),
			array( 'Sofia Lane', 'Nutrition Advisor' ),
			array( 'Nina Ward', 'Recovery Lead' ),
			array( 'Clara Voss', 'Performance Coach' ),
			array( 'Zoe Hart', 'Community Manager' ),
		);
		$page_ids = get_posts(
			array(
				'post_type'      => 'page',
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'meta_key'       => '_wp_page_template',
				'meta_value'     => array( 'templates/template-aboutus.php', 'template-aboutus.php' ),
				'meta_compare'   => 'IN',
			)
		);

		foreach ( $page_ids as $page_id ) {
			foreach ( $seeded_members as $index => $member ) {
				$number     = $index + 1;
				$name_field = 'about_team_member_' . $number . '_name';
				$role_field = 'about_team_member_' . $number . '_role';

				if ( $member[0] === get_post_meta( $page_id, $name_field, true ) ) {
					delete_post_meta( $page_id, $name_field );
					delete_post_meta( $page_id, '_' . $name_field );
				}

				if ( $member[1] === get_post_meta( $page_id, $role_field, true ) ) {
					delete_post_meta( $page_id, $role_field );
					delete_post_meta( $page_id, '_' . $role_field );
				}
			}
		}

		update_option( 'progymorava_child_team_defaults_cleared', 1, false );
	}
}

Progymorava_Child_Legacy_Cleanup::init();
