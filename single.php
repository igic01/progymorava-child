<?php
/**
 * Event post detail template.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

get_header();

$theme_images_url = get_stylesheet_directory_uri() . '/assets/images';
?>

<?php while ( have_posts() ) : ?>
	<?php
	the_post();

	$event_images = array_slice( (array) progymorava_child_home_field( 'event_images', array() ), 0, 3 );
	$images       = array();

	foreach ( $event_images as $event_image ) {
		$image_id = is_object( $event_image ) ? $event_image->ID : (int) $event_image;
		$images[] = wp_get_attachment_image_url( $image_id, 'full' );
	}

	$images = array_filter( $images );

	if ( empty( $images ) ) {
		$images[] = get_the_post_thumbnail_url( get_the_ID(), 'full' ) ?: $theme_images_url . '/placeholder.jpg';
	}

	$main_title       = progymorava_child_home_field( 'event_main_title', get_the_title() );
	$small_title      = progymorava_child_home_field( 'event_small_title', 'Event' );
	$year             = progymorava_child_home_field( 'event_year', get_the_date( 'Y' ) );
	$short_one        = progymorava_child_home_field( 'event_short_description_one', get_the_excerpt() );
	$short_two        = progymorava_child_home_field( 'event_short_description_two', '' );
	$full_description = progymorava_child_home_field( 'event_full_description', '' );
	?>

	<main>
		<section class="pg-event-hero" aria-labelledby="event-title">
			<div class="pg-event-hero__shell">
				<a class="pg-event-hero__back" href="<?php echo esc_url( home_url( '/events/' ) ); ?>">
					<span aria-hidden="true">←</span> All events
				</a>

				<div class="pg-event-hero__photos">
					<?php foreach ( $images as $image ) : ?>
						<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $main_title ); ?>" />
					<?php endforeach; ?>
				</div>

				<div class="pg-event-hero__copy">
					<p class="pg-event-hero__label"><?php echo esc_html( $small_title ); ?></p>
					<span class="pg-event-hero__year" aria-hidden="true"><?php echo esc_html( $year ); ?></span>
					<h1 id="event-title"><?php echo esc_html( $main_title ); ?></h1>
					<p class="pg-event-hero__lead"><?php echo esc_html( $short_one ); ?></p>

					<?php if ( '' !== $short_two ) : ?>
						<p class="pg-event-hero__lead"><?php echo esc_html( $short_two ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<article class="pg-event-article">
			<?php echo '' !== $full_description ? apply_filters( 'the_content', $full_description ) : apply_filters( 'the_content', get_the_content() ); ?>
		</article>
	</main>
<?php endwhile; ?>

<?php get_footer();
