<?php
/**
 * Shared context helpers for dynamic local ACF fields.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Resolves the page being edited or viewed while ACF fields are registered.
 */
class Progymorava_Child_Acf_Page_Context {
	/**
	 * Return the page being edited in wp-admin or queried on the front end.
	 *
	 * @return int
	 */
	public static function current_post_id() {
		if ( is_admin() && isset( $_GET['post'] ) ) {
			return absint( $_GET['post'] );
		}

		return is_singular() ? get_queried_object_id() : 0;
	}

	/**
	 * Read a non-negative dynamic-field count from the current page.
	 *
	 * @param string $field_name ACF field name.
	 * @param int    $fallback   Default count when the page has no saved value.
	 * @return int
	 */
	public static function count_field( $field_name, $fallback ) {
		$post_id = self::current_post_id();

		if ( $post_id ) {
			$value = get_post_meta( $post_id, $field_name, true );

			if ( '' !== $value ) {
				return max( 0, (int) $value );
			}
		}

		return max( 0, (int) $fallback );
	}
}
