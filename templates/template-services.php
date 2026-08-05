<?php
/**
 * Template Name: ProGym Services
 * Template Post Type: page
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

get_header( 'home' );

$theme_images_url = get_stylesheet_directory_uri() . '/assets/images';
$placeholder_url  = $theme_images_url . '/placeholder.jpg';
$coach_count      = Progymorava_Child_Services_Fields::count( 'services_coaches_count', 5 );
$physio_count     = Progymorava_Child_Services_Fields::count( 'services_physio_count', 3 );
$journey_count    = Progymorava_Child_Services_Fields::count( 'services_journey_count', 4 );
$coaches          = array();
$physios          = array();
$journey_items    = array();

for ( $index = 1; $index <= $coach_count; $index++ ) {
	$gallery = array();

	$gallery_attachments = (array) progymorava_child_home_field( 'services_coach_' . $index . '_gallery', array() );

	foreach ( $gallery_attachments as $attachment ) {
		$attachment_id = is_object( $attachment ) ? (int) $attachment->ID : (int) $attachment;
		$mime_type     = $attachment_id ? (string) get_post_mime_type( $attachment_id ) : '';
		$media_url     = $attachment_id ? wp_get_attachment_url( $attachment_id ) : '';

		if ( ! $media_url || ( 0 !== strpos( $mime_type, 'image/' ) && 0 !== strpos( $mime_type, 'video/' ) ) ) {
			continue;
		}

		$gallery_alt = (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

		$gallery[] = array(
			'url'  => $media_url,
			'alt'  => $gallery_alt ?: 'Coach gallery media',
			'type' => 0 === strpos( $mime_type, 'video/' ) ? 'video' : 'image',
		);
	}

	$coaches[] = array(
		'image'     => progymorava_child_home_image( 'services_coach_' . $index . '_image', $placeholder_url, 'ProGym coach' ),
		'name'      => progymorava_child_home_field( 'services_coach_' . $index . '_name', 'Coach name' ),
		'role'      => progymorava_child_home_field( 'services_coach_' . $index . '_role', 'Coach role' ),
		'specialty' => progymorava_child_home_field( 'services_coach_' . $index . '_specialty', 'Specialty' ),
		'bio'       => progymorava_child_home_field( 'services_coach_' . $index . '_bio', 'Coach profile text.' ),
		'gallery'   => $gallery,
	);
}

for ( $index = 1; $index <= $physio_count; $index++ ) {
	$physios[] = array(
		'image'     => progymorava_child_home_image( 'services_physio_' . $index . '_image', $placeholder_url, 'ProGym physiotherapist' ),
		'name'      => progymorava_child_home_field( 'services_physio_' . $index . '_name', 'Physiotherapist' ),
		'role'      => progymorava_child_home_field( 'services_physio_' . $index . '_role', 'Specialty' ),
		'facebook'  => progymorava_child_home_field( 'services_physio_' . $index . '_facebook', '' ),
		'instagram' => progymorava_child_home_field( 'services_physio_' . $index . '_instagram', '' ),
		'phone'     => progymorava_child_home_field( 'services_physio_' . $index . '_phone', '' ),
	);
}

for ( $index = 1; $index <= $journey_count; $index++ ) {
	$journey_items[] = array(
		'image' => progymorava_child_home_image( 'services_journey_' . $index . '_image', $placeholder_url, 'ProGym milestone' ),
		'year'  => progymorava_child_home_field( 'services_journey_' . $index . '_year', 'Year' ),
		'label' => progymorava_child_home_field( 'services_journey_' . $index . '_label', 'Milestone' ),
		'title' => progymorava_child_home_field( 'services_journey_' . $index . '_title', 'Milestone title' ),
		'text'  => progymorava_child_home_field( 'services_journey_' . $index . '_text', 'Timeline description.' ),
	);
}

get_template_part(
	'template-parts/shared/site',
	'header',
	array(
		'active_page' => 'sluzby',
	)
);
?>

<main id="services">
	<?php if ( ! (int) progymorava_child_home_field( 'services_coaches_hide_section', 0 ) ) : ?>
		<section class="pg-coaches" id="coaches" aria-labelledby="coaches-title">
			<div class="pg-coaches__shell">
				<div class="pg-coaches__intro">
					<p class="pg-coaches__eyebrow"><?php echo esc_html( progymorava_child_home_field( 'services_coaches_eyebrow', 'Meet the team' ) ); ?></p>
					<h1 class="pg-coaches__title" id="coaches-title"><?php echo esc_html( progymorava_child_home_field( 'services_coaches_title', 'Gym' ) ); ?> <span><?php echo esc_html( progymorava_child_home_field( 'services_coaches_title_accent', 'coaches' ) ); ?></span></h1>
					<p class="pg-coaches__lead"><?php echo nl2br( esc_html( progymorava_child_home_field( 'services_coaches_lead', 'Meet the people who turn focused sessions into lasting progress. Select a coach to learn more about their approach.' ) ) ); ?></p>
					<a class="pg-coaches__button pg-arrow-button" href="<?php echo esc_url( progymorava_child_home_field( 'services_coaches_action_url', home_url( '/prices/' ) ) ); ?>"><?php echo esc_html( progymorava_child_home_field( 'services_coaches_action_label', 'View price list' ) ); ?> <span aria-hidden="true">&rarr;</span></a>
				</div>

				<?php if ( ! empty( $coaches ) ) : ?>
					<div class="pg-coaches__list" aria-label="Gym coaches">
						<?php foreach ( $coaches as $index => $coach ) : ?>
							<button class="pg-coach-card" type="button" data-coach-card aria-haspopup="dialog">
								<img src="<?php echo esc_url( $coach['image']['url'] ); ?>" alt="<?php echo esc_attr( $coach['image']['alt'] ?: $coach['name'] ); ?>" />
								<span class="pg-coach-card__shade"></span>
								<span class="pg-coach-card__number"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
								<span class="pg-coach-card__content"><span class="pg-coach-card__name"><?php echo esc_html( $coach['name'] ); ?></span><span class="pg-coach-card__role"><?php echo esc_html( $coach['role'] ); ?></span><span class="pg-coach-card__more">Zobraziť <b aria-hidden="true">&rarr;</b></span></span>
								<span class="pg-coach-card__profile" hidden data-coach-profile data-role="<?php echo esc_attr( $coach['role'] ); ?>" data-specialty="<?php echo esc_attr( $coach['specialty'] ); ?>" data-bio="<?php echo esc_attr( $coach['bio'] ); ?>">
									<?php foreach ( $coach['gallery'] as $gallery_item ) : ?>
										<?php if ( 'video' === $gallery_item['type'] ) : ?>
											<video data-coach-gallery preload="metadata" src="<?php echo esc_url( $gallery_item['url'] ); ?>"></video>
										<?php else : ?>
											<img data-coach-gallery src="<?php echo esc_url( $gallery_item['url'] ); ?>" alt="<?php echo esc_attr( $gallery_item['alt'] ?: $coach['name'] ); ?>" />
										<?php endif; ?>
									<?php endforeach; ?>
								</span>
							</button>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( ! (int) progymorava_child_home_field( 'services_nutrition_hide_section', 0 ) ) : ?>
		<?php $nutrition_image = progymorava_child_home_image( 'services_nutrition_image', $placeholder_url, 'ProGym nutrition advisor' ); ?>
		<section class="pg-nutrition" id="nutrition" aria-labelledby="nutrition-title">
			<div class="pg-nutrition__shell">
				<div class="pg-nutrition__photo"><img src="<?php echo esc_url( $nutrition_image['url'] ); ?>" alt="<?php echo esc_attr( $nutrition_image['alt'] ); ?>" /></div>
				<div class="pg-nutrition__content">
					<p class="pg-nutrition__eyebrow"><?php echo esc_html( progymorava_child_home_field( 'services_nutrition_eyebrow', 'Nutrition advisor' ) ); ?></p>
					<h2 id="nutrition-title"><?php echo esc_html( progymorava_child_home_field( 'services_nutrition_title', 'Fuel your' ) ); ?> <span><?php echo esc_html( progymorava_child_home_field( 'services_nutrition_title_accent', 'progress.' ) ); ?></span></h2>
					<div class="pg-nutrition__bio"><p><?php echo nl2br( esc_html( progymorava_child_home_field( 'services_nutrition_text_one', '' ) ) ); ?></p><p><?php echo nl2br( esc_html( progymorava_child_home_field( 'services_nutrition_text_two', '' ) ) ); ?></p></div>
					<a class="pg-nutrition__button pg-arrow-button" href="<?php echo esc_url( progymorava_child_home_field( 'services_nutrition_action_url', home_url( '/prices/' ) ) ); ?>"><?php echo esc_html( progymorava_child_home_field( 'services_nutrition_action_label', 'View price list' ) ); ?> <span aria-hidden="true">&rarr;</span></a>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( ! (int) progymorava_child_home_field( 'services_physio_hide_section', 0 ) ) : ?>
		<section class="pg-physio" id="physiotherapy" aria-labelledby="physio-title">
			<div class="pg-physio__shell">
				<div class="pg-physio__intro"><p class="pg-physio__eyebrow"><?php echo esc_html( progymorava_child_home_field( 'services_physio_eyebrow', 'Move with confidence' ) ); ?></p><h2 id="physio-title"><?php echo esc_html( progymorava_child_home_field( 'services_physio_title', 'Physio' ) ); ?><span><?php echo esc_html( progymorava_child_home_field( 'services_physio_title_accent', 'therapy' ) ); ?></span></h2><p><?php echo nl2br( esc_html( progymorava_child_home_field( 'services_physio_lead', 'Focused care for recovery, mobility, and feeling strong in your everyday movement.' ) ) ); ?></p></div>
				<?php if ( ! empty( $physios ) ) : ?><div class="pg-physio__team" aria-label="Physiotherapy team">
					<?php foreach ( $physios as $person ) : ?><article class="pg-physio__person"><img src="<?php echo esc_url( $person['image']['url'] ); ?>" alt="<?php echo esc_attr( $person['image']['alt'] ?: $person['name'] ); ?>" /><div class="pg-physio__shade"></div><div class="pg-physio__content"><h3><?php echo esc_html( $person['name'] ); ?></h3><p><?php echo esc_html( $person['role'] ); ?></p><div class="pg-physio__socials" aria-label="Contact <?php echo esc_attr( $person['name'] ); ?>"><?php if ( $person['facebook'] ) : ?><a href="<?php echo esc_url( $person['facebook'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $person['name'] ); ?> on Facebook">f</a><?php endif; ?><?php if ( $person['instagram'] ) : ?><a href="<?php echo esc_url( $person['instagram'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $person['name'] ); ?> on Instagram">ig</a><?php endif; ?><?php if ( $person['phone'] ) : ?><a href="<?php echo esc_url( $person['phone'] ); ?>" aria-label="Call <?php echo esc_attr( $person['name'] ); ?>">&#9742;</a><?php endif; ?></div></div></article><?php endforeach; ?>
				</div><?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( ! (int) progymorava_child_home_field( 'services_journey_hide_section', 0 ) && ! empty( $journey_items ) ) : ?>
		<section class="pg-journey" aria-labelledby="journey-title"><div class="pg-journey__shell"><div class="pg-journey__intro"><p class="pg-journey__eyebrow"><?php echo esc_html( progymorava_child_home_field( 'services_journey_eyebrow', 'Our journey' ) ); ?></p><h2 id="journey-title"><?php echo esc_html( progymorava_child_home_field( 'services_journey_title', 'Progress, year by' ) ); ?> <span><?php echo esc_html( progymorava_child_home_field( 'services_journey_title_accent', 'year.' ) ); ?></span></h2><p><?php echo nl2br( esc_html( progymorava_child_home_field( 'services_journey_lead', 'From the work we do today to the moments that shaped us, each year has moved our community forward.' ) ) ); ?></p></div><div class="pg-journey__viewport"><div class="pg-journey__events"><?php foreach ( $journey_items as $index => $item ) : ?><article class="pg-journey__event<?php echo $index < 3 ? ' is-visible' : ''; ?>" data-journey-index="<?php echo esc_attr( $index ); ?>"><img src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="<?php echo esc_attr( $item['image']['alt'] ?: $item['title'] ); ?>" /><div><p class="pg-journey__event-year"><?php echo esc_html( $item['year'] ); ?></p><h3><?php echo esc_html( $item['title'] ); ?></h3><p><?php echo esc_html( $item['text'] ); ?></p></div></article><?php endforeach; ?></div><ol class="pg-journey__timeline" aria-label="ProGym timeline"><?php foreach ( $journey_items as $index => $item ) : ?><li class="<?php echo $index < 3 ? 'is-active' : ''; ?>"><span><?php echo esc_html( $item['year'] ); ?></span><small><?php echo esc_html( $item['label'] ); ?></small></li><?php endforeach; ?></ol><?php if ( count( $journey_items ) > 3 ) : ?><div class="pg-journey__controls" aria-label="Timeline navigation"><button class="pg-journey__control" type="button" data-journey-newer disabled>&larr; Newer years</button><button class="pg-journey__control" type="button" data-journey-older>Earlier years &rarr;</button></div><?php endif; ?></div></div></section>
	<?php endif; ?>

	<?php if ( ! (int) progymorava_child_home_field( 'services_prices_cta_hide_section', 0 ) ) : ?>
		<?php $cta_image = progymorava_child_home_image( 'services_prices_cta_image', $placeholder_url, 'Member training at ProGym' ); ?>
		<section class="pg-prices-cta" aria-labelledby="prices-cta-title"><div class="pg-prices-cta__shell"><div class="pg-prices-cta__photo"><img src="<?php echo esc_url( $cta_image['url'] ); ?>" alt="<?php echo esc_attr( $cta_image['alt'] ); ?>" /><div class="pg-prices-cta__shade"></div><div class="pg-prices-cta__content"><p class="pg-prices-cta__eyebrow"><?php echo esc_html( progymorava_child_home_field( 'services_prices_cta_eyebrow', 'Your membership' ) ); ?></p><h2 id="prices-cta-title"><?php echo esc_html( progymorava_child_home_field( 'services_prices_cta_title', 'Make your next move' ) ); ?> <span><?php echo esc_html( progymorava_child_home_field( 'services_prices_cta_title_accent', 'count.' ) ); ?></span></h2><p><?php echo nl2br( esc_html( progymorava_child_home_field( 'services_prices_cta_text', 'Explore flexible options for training, recovery, and the support that keeps your progress moving.' ) ) ); ?></p><a class="pg-prices-cta__button pg-arrow-button" href="<?php echo esc_url( progymorava_child_home_field( 'services_prices_cta_action_url', home_url( '/prices/' ) ) ); ?>"><?php echo esc_html( progymorava_child_home_field( 'services_prices_cta_action_label', 'View price list' ) ); ?> <span aria-hidden="true">&rarr;</span></a></div></div></div></section>
	<?php endif; ?>

	<dialog class="pg-coach-modal" aria-labelledby="coach-modal-name"><button class="pg-coach-modal__close" type="button" aria-label="Close coach profile"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m7 7 10 10M17 7 7 17" /></svg></button><div class="pg-coach-modal__grid"><img class="pg-coach-modal__image" src="<?php echo esc_url( $placeholder_url ); ?>" alt="" /><div class="pg-coach-modal__content"><p class="pg-coach-modal__eyebrow" id="coach-modal-role"></p><h2 id="coach-modal-name"></h2><p id="coach-modal-text"></p><p class="pg-coach-modal__specialty"><strong>Specialty</strong><span id="coach-modal-specialty"></span></p></div></div><div class="pg-coach-modal__gallery" id="coach-modal-gallery" hidden><div class="pg-coach-modal__gallery-heading"><p>Coach gallery</p><span>Click a photo to zoom</span></div><div class="pg-coach-modal__photos" id="coach-modal-photos"></div></div></dialog>
</main>

<?php
get_template_part( 'template-parts/shared/site', 'footer', array( 'include_contact' => true, 'include_contact_link' => true, 'include_services' => true, 'extended_services' => true, 'include_follow' => true ) );
get_footer( 'home' );
