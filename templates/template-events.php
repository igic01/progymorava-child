<?php
/**
 * Template Name: ProGym Events
 * Template Post Type: page
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

get_header( 'home' );

$theme_images_url = get_stylesheet_directory_uri() . '/assets/images';
$event_posts      = progymorava_child_home_field( 'events_posts', array() );

get_template_part(
	'template-parts/shared/site',
	'header',
	array(
		'active_page' => 'organizujeme',
	)
);
?>

<main id="events">
	<section class="pg-events" aria-labelledby="events-title">
		<div class="pg-events__shell">
			<header class="pg-events__intro">
				<p class="pg-events__eyebrow"><?php echo esc_html( progymorava_child_home_field( 'events_eyebrow', 'ProGym gives back' ) ); ?></p>
				<h1 class="pg-events__title" id="events-title"><?php echo esc_html( progymorava_child_home_field( 'events_title', 'Stronger' ) ); ?> <span><?php echo esc_html( progymorava_child_home_field( 'events_title_accent', 'together.' ) ); ?></span></h1>
			</header>

			<div class="pg-events__list">
				<?php foreach ( (array) $event_posts as $index => $event_post ) : ?>
					<?php
					$post_id = is_object( $event_post ) ? $event_post->ID : (int) $event_post;

					if ( 'post' !== get_post_type( $post_id ) ) {
						continue;
					}

					$event_images = array_slice( (array) progymorava_child_home_field( 'event_images', array(), $post_id ), 0, 3 );
					$images       = array_filter(
						array_map(
							static function ( $image ) {
								$image_id = is_object( $image ) ? $image->ID : (int) $image;

								return wp_get_attachment_image_url( $image_id, 'large' );
							},
							$event_images
						)
					);

					if ( empty( $images ) ) {
						$images[] = get_the_post_thumbnail_url( $post_id, 'large' ) ?: $theme_images_url . '/placeholder.jpg';
					}

					$title       = progymorava_child_home_field( 'event_main_title', '', $post_id ) ?: get_the_title( $post_id );
					$small_title = progymorava_child_home_field( 'event_small_title', '', $post_id ) ?: 'Event';
					$year        = progymorava_child_home_field( 'event_year', '', $post_id ) ?: get_the_date( 'Y', $post_id );
					$short_one   = progymorava_child_home_field( 'event_short_description_one', '', $post_id ) ?: get_the_excerpt( $post_id );
					$short_two   = progymorava_child_home_field( 'event_short_description_two', '', $post_id );
					?>

					<article class="pg-event-card<?php echo $index % 2 ? ' pg-event-card--reverse' : ''; ?>" id="event-<?php echo esc_attr( $post_id ); ?>">
						<div class="pg-event-card__gallery">
							<?php foreach ( $images as $image ) : ?>
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
							<?php endforeach; ?>
						</div>

						<div class="pg-event-card__content">
							<span class="pg-event-card__year" aria-hidden="true"><?php echo esc_html( $year ); ?></span>
							<p class="pg-event-card__label"><?php echo esc_html( $small_title ); ?></p>
							<h2><?php echo esc_html( $title ); ?></h2>
							<p><?php echo esc_html( $short_one ); ?></p>

							<?php if ( $short_two ) : ?>
								<p class="pg-event-card__impact"><?php echo esc_html( $short_two ); ?></p>
							<?php endif; ?>

							<div class="pg-event-card__actions">
								<a class="pg-button pg-button--check pg-arrow-button" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
									Check event <span aria-hidden="true">→</span>
								</a>
							</div>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
</main>

<?php
get_template_part(
	'template-parts/shared/site',
	'footer',
	array(
		'include_contact'      => true,
		'include_contact_link' => true,
		'include_services'     => true,
		'extended_services'    => false,
		'include_follow'       => false,
	)
);

get_footer( 'home' );
