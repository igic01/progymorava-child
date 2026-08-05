<?php
/**
 * Template Name: Progymorava Example
 * Template Post Type: page
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

	<div <?php generate_do_attr( 'content' ); ?>>
		<main <?php generate_do_attr( 'main' ); ?>>
			<?php
			do_action( 'generate_before_main_content' );

			while ( have_posts() ) :
				the_post();
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'pg-example' ); ?>>
					<div class="pg-container">
						<h1 class="pg-example__title"><?php the_title(); ?></h1>

						<div class="pg-example__content">
							<?php the_content(); ?>
						</div>
					</div>
				</article>

				<?php
			endwhile;

			do_action( 'generate_after_main_content' );
			?>
		</main>
	</div>

<?php
do_action( 'generate_after_primary_content_area' );

get_footer();
