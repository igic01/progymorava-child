<?php
/**
 * Contact page ACF field registration.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the fields used by the ProGym Contact page template.
 */
class Progymorava_Child_Contact_Fields {
	/**
	 * Register ACF hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'acf/init', array( __CLASS__, 'register_fields' ) );
	}

	/**
	 * Register the Contact page field group locally.
	 *
	 * @return void
	 */
	public static function register_fields() {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		$fields   = new Progymorava_Child_Acf_Field_Builder( 'field_pg_contact_' );
		$textarea = array(
			'rows'      => 3,
			'new_lines' => '',
		);
		$image    = array(
			'return_format' => 'array',
			'preview_size'  => 'medium',
			'library'       => 'all',
		);

		$fields->tab( 'intro_tab', 'Introduction' );
		$fields->field( 'intro_eyebrow', 'Eyebrow', 'contact_intro_eyebrow', 'text', 'Get in touch' );
		$fields->field( 'intro_title_before', 'Title first part', 'contact_intro_title_before', 'text', 'Let’s start your' );
		$fields->field( 'intro_title_mark', 'Title highlighted part', 'contact_intro_title_mark', 'text', 'next chapter.' );

		$fields->tab( 'form_tab', 'Form' );
		$fields->field( 'primary_hide_section', 'Hide form section', 'contact_primary_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$fields->field( 'primary_image', 'Image', 'contact_primary_image', 'image', progymorava_child_home_placeholder_image_id(), $image );
		$fields->field( 'form_eyebrow', 'Form heading', 'contact_form_eyebrow', 'text', 'Send a message' );
		$fields->field( 'form_shortcode', 'Form shortcode', 'contact_form_shortcode', 'textarea', '', array( 'rows' => 3, 'new_lines' => '', 'instructions' => 'Paste the complete shortcode from your form plugin here, for example [contact-form-7 id="123" title="Contact form"].' ) );

		$fields->tab( 'details_tab', 'Contact details & map' );
		$fields->field( 'details_hide_section', 'Hide contact details and map', 'contact_details_hide_section', 'true_false', 0, array( 'ui' => 1 ) );
		$fields->field( 'details_eyebrow', 'Eyebrow', 'contact_details_eyebrow', 'text', 'Visit ProGym' );
		$fields->field( 'details_title_before', 'Title first part', 'contact_details_title_before', 'text', 'Find your' );
		$fields->field( 'details_title_mark', 'Title highlighted part', 'contact_details_title_mark', 'text', 'stronger self.' );
		$fields->field( 'address_label', 'Address label', 'contact_address_label', 'text', 'Address' );
		$fields->field( 'address', 'Address', 'contact_address', 'textarea', "Hlavná ulica 1587/99\nZákamenné", array_merge( $textarea, array( 'rows' => 2 ) ) );
		$fields->field( 'email_label', 'Email label', 'contact_email_label', 'text', 'Email' );
		$fields->field( 'email', 'Email address', 'contact_email', 'email', 'info@progymorava.sk' );
		$fields->field( 'phone_label', 'Phone label', 'contact_phone_label', 'text', 'Phone number' );
		$fields->field( 'phone', 'Phone number', 'contact_phone', 'text', '+421 944 439 345' );
		$fields->field( 'map_embed_url', 'Google Maps embed URL', 'contact_map_embed_url', 'url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2597.738146241121!2d19.264001500000003!3d49.3760275!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4715b52597980229%3A0x602fb036a149e0e0!2sProGym%20Fitness%20Centrum!5e0!3m2!1sen!2ssk!4v1784816680191!5m2!1sen!2ssk', array( 'instructions' => 'Paste the URL from the src attribute in Google Maps’ embed iframe code.' ) );
		$fields->field( 'map_title', 'Map accessibility title', 'contact_map_title', 'text', 'ProGym Fitness Centrum location' );

		acf_add_local_field_group(
			array(
				'key'             => 'group_pg_contact_page',
				'title'           => 'Obsah kontaktnej stránky ProGym',
				'fields'          => $fields->fields(),
				'location'        => array(
					array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'templates/template-contact.php' ) ),
					array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'template-contact.php' ) ),
				),
				'position'        => 'acf_after_title',
				'label_placement' => 'top',
				'menu_order'      => 0,
				'active'          => true,
				'description'     => 'Tieto polia sa registrujú automaticky pre stránky používajúce kontaktnú šablónu ProGym.',
			)
		);
	}
}

Progymorava_Child_Contact_Fields::init();
