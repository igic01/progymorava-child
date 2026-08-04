<?php
/**
 * Footer used only by templates that call get_footer( 'redesign' ).
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;
?>

		</div>
	</div>

	<?php
	/*
	 * Redesign footer boundary.
	 *
	 * These GeneratePress hooks preserve the current footer for now. They can
	 * later be replaced with the new footer markup without changing pages that
	 * use the standard footer.php file.
	 */
	do_action( 'generate_before_footer' );
	?>

	<div <?php generate_do_attr( 'footer' ); ?>>
		<?php
		do_action( 'generate_before_footer_content' );
		do_action( 'generate_footer' );
		do_action( 'generate_after_footer_content' );
		?>
	</div>

	<?php
	do_action( 'generate_after_footer' );
	wp_footer();
	?>
</body>
</html>
