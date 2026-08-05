<?php
/**
 * Theme asset loading.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

class Progymorava_Child_Assets {
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ), 20 );
	}

	public static function version( $relative_path ) {
		$absolute_path = get_stylesheet_directory() . $relative_path;
		return file_exists( $absolute_path ) ? (string) filemtime( $absolute_path ) : (string) wp_get_theme()->get( 'Version' );
	}

	public static function enqueue_assets() {
		wp_enqueue_style( 'progymorava-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css', array(), '6.7.2' );

		$main_stylesheet = '/assets/css/main.css';
		wp_enqueue_style( 'progymorava-main', get_stylesheet_directory_uri() . $main_stylesheet, array(), self::version( $main_stylesheet ) );

		$header_script = '/assets/js/components/site-header.js';
		wp_enqueue_script( 'progymorava-site-header', get_stylesheet_directory_uri() . $header_script, array(), self::version( $header_script ), true );

		$popup_stylesheet = '/assets/css/components/app-popup.css';
		$popup_script     = '/assets/js/components/app-popup.js';
		wp_enqueue_style( 'progymorava-app-popup', get_stylesheet_directory_uri() . $popup_stylesheet, array( 'progymorava-main' ), self::version( $popup_stylesheet ) );
		wp_enqueue_script( 'progymorava-app-popup', get_stylesheet_directory_uri() . $popup_script, array(), self::version( $popup_script ), true );

		if ( is_singular( 'post' ) ) {
			$stylesheet = '/assets/css/templates/single.css';
			wp_enqueue_style( 'progymorava-single-event', get_stylesheet_directory_uri() . $stylesheet, array( 'progymorava-main' ), self::version( $stylesheet ) );
			wp_enqueue_style( 'progymorava-google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Roboto:wght@400;500;700&display=swap', array(), null );
			return;
		}

		if ( ! is_page() || ! get_page_template() ) {
			return;
		}

		$template_name = sanitize_file_name( pathinfo( get_page_template(), PATHINFO_FILENAME ) );
		$stylesheet    = '/assets/css/templates/' . $template_name . '.css';
		if ( ! file_exists( get_stylesheet_directory() . $stylesheet ) ) {
			return;
		}

		wp_enqueue_style( 'progymorava-template-' . $template_name, get_stylesheet_directory_uri() . $stylesheet, array( 'progymorava-main' ), self::version( $stylesheet ) );
		if ( in_array( $template_name, array( 'template-home', 'template-aboutus', 'template-prices', 'template-events', 'template-contact', 'template-services', 'template-rental-calculator' ), true ) ) {
			wp_enqueue_style( 'progymorava-google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Roboto:wght@400;500;700&display=swap', array(), null );
		}
		$script = '/assets/js/templates/' . $template_name . '.js';
		if ( file_exists( get_stylesheet_directory() . $script ) ) {
			wp_enqueue_script(
				'progymorava-template-' . $template_name,
				get_stylesheet_directory_uri() . $script,
				array(),
				self::version( $script ),
				true
			);
		}
	}
}

Progymorava_Child_Assets::init();
