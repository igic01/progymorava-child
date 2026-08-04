<?php
/**
 * Shared ACF value, placeholder-image, and image-alt helpers.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Provides the small, stable ACF API used by page templates.
 */
class Progymorava_Child_Acf_Utils {
	/**
	 * Register ACF hooks.
	 *
	 * A type-based image hook supports dynamic About team-member fields without
	 * needing to register one filter for each possible member count.
	 *
	 * @return void
	 */
	public static function init() {
		add_filter( 'acf/load_value/type=image', array( __CLASS__, 'placeholder_value' ), 10, 3 );
	}

	/**
	 * Return the Media Library ID used as a fallback image in the page editor.
	 *
	 * @return int
	 */
	public static function placeholder_id() {
		static $attachment_id = null;

		if ( null !== $attachment_id ) {
			return $attachment_id;
		}

		$attachment_id = 0;

		if ( ! is_admin() || ! current_user_can( 'upload_files' ) ) {
			return $attachment_id;
		}

		$existing = get_posts(
			array(
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'meta_key'       => '_progymorava_child_home_placeholder',
				'meta_value'     => '1',
			)
		);

		if ( ! empty( $existing ) ) {
			$attachment_id = (int) $existing[0];

			return $attachment_id;
		}

		$placeholder_path = get_stylesheet_directory() . '/assets/images/placeholder.jpg';

		if ( ! is_readable( $placeholder_path ) ) {
			return $attachment_id;
		}

		$upload = wp_upload_bits(
			'progymorava-home-placeholder.jpg',
			null,
			file_get_contents( $placeholder_path )
		);

		if ( ! empty( $upload['error'] ) ) {
			return $attachment_id;
		}

		$file_type = wp_check_filetype( $upload['file'] );
		$attachment_id = wp_insert_attachment(
			array(
				'post_mime_type' => $file_type['type'],
				'post_title'     => 'ProGym Home placeholder',
				'post_status'    => 'inherit',
			),
			$upload['file']
		);

		if ( is_wp_error( $attachment_id ) || ! $attachment_id ) {
			$attachment_id = 0;

			return $attachment_id;
		}

		require_once ABSPATH . 'wp-admin/includes/image.php';
		wp_update_attachment_metadata(
			$attachment_id,
			wp_generate_attachment_metadata( $attachment_id, $upload['file'] )
		);
		update_post_meta( $attachment_id, '_progymorava_child_home_placeholder', '1' );

		return $attachment_id;
	}

	/**
	 * Supply the editor placeholder for supported empty image fields.
	 *
	 * @param mixed                    $value   Stored field value.
	 * @param string|int               $post_id Post ID supplied by ACF.
	 * @param array<string,mixed>|null $field   ACF field settings.
	 * @return mixed
	 */
	public static function placeholder_value( $value, $post_id = null, $field = array() ) {
		if ( empty( $value ) && is_admin() && self::uses_placeholder( $field ) ) {
			return self::placeholder_id();
		}

		return $value;
	}

	/**
	 * Determine whether a local image field should receive the theme fallback.
	 *
	 * @param array<string,mixed>|null $field ACF field settings.
	 * @return bool
	 */
	private static function uses_placeholder( $field ) {
		$field_name = is_array( $field ) && isset( $field['name'] ) ? (string) $field['name'] : '';

		return in_array(
			$field_name,
			array(
				'home_hero_image',
				'home_training_card_one_image',
				'home_training_card_two_image',
				'home_training_card_three_image',
				'home_why_image',
				'home_motivation_image',
				'contact_primary_image',
				'about_mission_image',
				'about_partner_image',
				'prices_multisport_image',
				'prices_room_image',
			),
			true
		) || 1 === preg_match( '/^(home_training_card_\d+|about_team_member|services_(coach|physio|journey)_\d+|services_nutrition|services_prices_cta)_image$/', $field_name );
	}

	/**
	 * Get an ACF value, retaining the template's static design as a fallback.
	 *
	 * @param string     $field_name ACF field name.
	 * @param mixed      $fallback   Value used when the ACF field is empty.
	 * @param string|int $post_id    Optional post ID.
	 * @return mixed
	 */
	public static function field( $field_name, $fallback = '', $post_id = false ) {
		if ( ! function_exists( 'get_field' ) ) {
			return $fallback;
		}

		$value = false !== $post_id ? get_field( $field_name, $post_id ) : get_field( $field_name );

		return null !== $value && '' !== $value ? $value : $fallback;
	}

	/**
	 * Make an image filename suitable for use as an alt attribute.
	 *
	 * @param string $image_url Image URL.
	 * @param string $fallback  Value used when the URL has no filename.
	 * @return string
	 */
	public static function filename_alt( $image_url, $fallback = '' ) {
		$path     = wp_parse_url( (string) $image_url, PHP_URL_PATH );
		$filename = $path ? pathinfo( wp_basename( $path ), PATHINFO_FILENAME ) : '';
		$alt      = trim( preg_replace( '/[\s_-]+/', ' ', rawurldecode( $filename ) ) );

		return '' !== $alt ? $alt : $fallback;
	}

	/**
	 * Resolve an ACF image field to a URL and filename-derived alt-text pair.
	 *
	 * @param string     $field_name   ACF field name.
	 * @param string     $fallback_url Fallback image URL.
	 * @param string     $fallback_alt Fallback alt text.
	 * @param string|int $post_id      Optional post ID.
	 * @return array{url:string,alt:string}
	 */
	public static function image( $field_name, $fallback_url, $fallback_alt = '', $post_id = false ) {
		$image = self::field( $field_name, array(), $post_id );

		if ( is_array( $image ) ) {
			$image_url = ! empty( $image['url'] ) ? $image['url'] : $fallback_url;
		} elseif ( is_numeric( $image ) && function_exists( 'wp_get_attachment_image_url' ) ) {
			$image_url = wp_get_attachment_image_url( (int) $image, 'full' ) ?: $fallback_url;
		} else {
			$image_url = is_string( $image ) && '' !== $image ? $image : $fallback_url;
		}

		return array(
			'url' => $image_url,
			'alt' => self::filename_alt( $image_url, $fallback_alt ),
		);
	}
}

Progymorava_Child_Acf_Utils::init();

/**
 * Template compatibility helpers.
 *
 * Keep template calls short while delegating their implementation to the
 * dedicated ACF utility class above.
 */
function progymorava_child_home_placeholder_image_id() {
	return Progymorava_Child_Acf_Utils::placeholder_id();
}

function progymorava_child_home_field( $field_name, $fallback = '', $post_id = false ) {
	return Progymorava_Child_Acf_Utils::field( $field_name, $fallback, $post_id );
}

function progymorava_child_home_image( $field_name, $fallback_url, $fallback_alt = '', $post_id = false ) {
	return Progymorava_Child_Acf_Utils::image( $field_name, $fallback_url, $fallback_alt, $post_id );
}
