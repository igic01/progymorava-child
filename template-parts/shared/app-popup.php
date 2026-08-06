<?php
/**
 * Reusable ProGym application download popup.
 *
 * Optional arguments can override the Home-page ACF values:
 * - enabled: Whether the popup markup should be rendered.
 * - post_id: Post containing the ACF values.
 * - storage_key: Browser-storage key used to remember an explicit dismissal.
 * - phone_image: Array with url and alt values.
 * - eyebrow, title_before, title_mark, description, button_label,
 *   google_url, apple_url, availability: Popup content.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

$post_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_queried_object_id();
$field   = static function ( $argument, $field_name, $fallback ) use ( $args, $post_id ) {
	if ( array_key_exists( $argument, $args ) ) {
		return $args[ $argument ];
	}

	return progymorava_child_home_field( $field_name, $fallback, $post_id );
};

$enabled = array_key_exists( 'enabled', $args )
	? (bool) $args['enabled']
	: (bool) progymorava_child_home_field( 'home_app_popup_enabled', 1, $post_id );

if ( ! $enabled ) {
	return;
}

$storage_key = isset( $args['storage_key'] ) ? (string) $args['storage_key'] : 'progymorava_app_popup_dismissed_v2';

if ( isset( $_COOKIE[ $storage_key ] ) && '1' === sanitize_text_field( wp_unslash( $_COOKIE[ $storage_key ] ) ) ) {
	return;
}

$fallback_image = get_stylesheet_directory_uri() . '/assets/images/app-popup-screen.svg';
$phone_image    = isset( $args['phone_image'] ) && is_array( $args['phone_image'] )
	? $args['phone_image']
	: progymorava_child_home_image( 'home_app_popup_phone_image', $fallback_image, 'Aplikácia ProGym Orava', $post_id );
$eyebrow        = (string) $field( 'eyebrow', 'home_app_popup_eyebrow', 'ProGym vo vrecku' );
$title_before   = (string) $field( 'title_before', 'home_app_popup_title_before', 'Tvoj tréning.' );
$title_mark     = (string) $field( 'title_mark', 'home_app_popup_title_mark', 'Vždy poruke.' );
$description    = (string) $field( 'description', 'home_app_popup_description', 'Stiahni si aplikáciu ProGym Orava a maj všetko potrebné pre svoj tréning pohodlne vo svojom mobile.' );
$button_label   = (string) $field( 'button_label', 'home_app_popup_button_label', 'Stiahnuť aplikáciu' );
$google_url     = (string) $field( 'google_url', 'home_app_popup_google_url', 'https://play.google.com/store/apps/details?id=com.progymorava' );
$apple_url      = (string) $field( 'apple_url', 'home_app_popup_apple_url', 'https://apps.apple.com/us/app/progym-orava-z%C3%A1kamenn%C3%A9/id6791676566' );
$availability   = (string) $field( 'availability', 'home_app_popup_availability', 'Dostupné pre iOS a Android' );
?>

<div
	class="pg-app-popup-layer"
	data-pg-app-popup
	data-storage-key="<?php echo esc_attr( $storage_key ); ?>"
	hidden
	aria-hidden="true"
>
	<section
		class="pg-app-popup"
		role="dialog"
		aria-modal="true"
		aria-labelledby="pg-app-popup-title"
		aria-describedby="pg-app-popup-description"
	>
		<button class="pg-app-popup__close" type="button" data-pg-app-popup-close aria-label="Zatvoriť okno">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
				<path d="M6 6l12 12M18 6L6 18"></path>
			</svg>
		</button>

		<figure class="pg-app-popup__visual">
			<div class="pg-app-popup__phone">
				<span class="pg-app-popup__speaker" aria-hidden="true"></span>
				<div class="pg-app-popup__screen">
					<img
						class="pg-app-popup__screen-image"
						src="<?php echo esc_url( $phone_image['url'] ); ?>"
						alt="<?php echo esc_attr( $phone_image['alt'] ); ?>"
					/>
				</div>
			</div>
		</figure>

		<div class="pg-app-popup__body">
			<?php if ( '' !== $eyebrow ) : ?>
				<p class="pg-app-popup__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>

			<h2 class="pg-app-popup__title" id="pg-app-popup-title">
				<?php echo esc_html( $title_before ); ?>
				<?php if ( '' !== $title_mark ) : ?>
					<span><?php echo esc_html( $title_mark ); ?></span>
				<?php endif; ?>
			</h2>

			<p class="pg-app-popup__description" id="pg-app-popup-description"><?php echo nl2br( esc_html( $description ) ); ?></p>

			<a
				class="pg-app-popup__download"
				data-pg-app-download
				data-google-url="<?php echo esc_url( $google_url ); ?>"
				data-apple-url="<?php echo esc_url( $apple_url ); ?>"
				href="<?php echo esc_url( $google_url ); ?>"
				target="_blank"
				rel="noopener noreferrer"
			>
				<span><?php echo esc_html( $button_label ); ?></span>
				<span class="pg-app-popup__download-icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="M12 3v12"></path>
						<path d="m7 10 5 5 5-5"></path>
						<path d="M5 21h14"></path>
					</svg>
				</span>
			</a>

			<?php if ( '' !== $availability ) : ?>
				<p class="pg-app-popup__availability"><?php echo esc_html( $availability ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</div>
