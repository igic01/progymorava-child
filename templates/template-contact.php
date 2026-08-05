<?php
/**
 * Template Name: ProGym Contact
 * Template Post Type: page
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

get_header();

$theme_images_url = get_stylesheet_directory_uri() . '/assets/images';
$placeholder_url  = $theme_images_url . '/placeholder.jpg';
$contact_image    = progymorava_child_home_image( 'contact_primary_image', $placeholder_url, 'ProGym fitness center interior' );
$form_shortcode   = trim( (string) progymorava_child_home_field( 'contact_form_shortcode', '' ) );
$contact_email    = sanitize_email( progymorava_child_home_field( 'contact_email', 'info@progymorava.sk' ) );
$contact_phone    = progymorava_child_home_field( 'contact_phone', '+421 944 439 345' );
$phone_href       = preg_replace( '/[^0-9+]/', '', $contact_phone );
$hide_primary     = 1 === (int) progymorava_child_home_field( 'contact_primary_hide_section', 0 );
$hide_details     = 1 === (int) progymorava_child_home_field( 'contact_details_hide_section', 0 );

?>

<main id="contact">
	<section class="pg-contact" aria-labelledby="contact-title">
		<div class="pg-contact__shell">
			<header class="pg-contact__intro">
				<p class="pg-contact__eyebrow">
					<?php echo esc_html( progymorava_child_home_field( 'contact_intro_eyebrow', 'Get in touch' ) ); ?>
				</p>
				<h1 id="contact-title">
					<?php echo esc_html( progymorava_child_home_field( 'contact_intro_title_before', 'Let’s start your' ) ); ?>
					<span><?php echo esc_html( progymorava_child_home_field( 'contact_intro_title_mark', 'next chapter.' ) ); ?></span>
				</h1>
			</header>

			<?php if ( ! $hide_primary ) : ?>
				<div class="pg-contact__primary">
					<div class="pg-contact__photo">
						<img src="<?php echo esc_url( $contact_image['url'] ); ?>" alt="<?php echo esc_attr( $contact_image['alt'] ); ?>" />
					</div>

					<div class="pg-contact-form" id="contact-form">
						<p class="pg-contact-form__eyebrow">
							<?php echo esc_html( progymorava_child_home_field( 'contact_form_eyebrow', 'Send a message' ) ); ?>
						</p>

						<?php if ( '' !== $form_shortcode ) : ?>
							<?php
							echo do_shortcode( $form_shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- The editor-managed shortcode generates the form markup.
							?>
						<?php else : ?>
							<p class="pg-contact-form__empty">
								<?php echo esc_html__( 'Add your form shortcode in the “Form” tab of this page.', 'progymorava-child' ); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! $hide_details ) : ?>
				<div class="pg-contact__secondary">
					<aside class="pg-contact-details" aria-label="Contact information">
						<p class="pg-contact-details__eyebrow">
							<?php echo esc_html( progymorava_child_home_field( 'contact_details_eyebrow', 'Visit ProGym' ) ); ?>
						</p>
						<h2>
							<?php echo esc_html( progymorava_child_home_field( 'contact_details_title_before', 'Find your' ) ); ?>
							<span><?php echo esc_html( progymorava_child_home_field( 'contact_details_title_mark', 'stronger self.' ) ); ?></span>
						</h2>

						<dl>
							<div>
								<dt><?php echo esc_html( progymorava_child_home_field( 'contact_address_label', 'Address' ) ); ?></dt>
								<dd>
									<?php
									echo nl2br(
										esc_html(
											progymorava_child_home_field(
												'contact_address',
												"Hlavná ulica 1587/99\nZákamenné"
											)
										)
									);
									?>
								</dd>
							</div>
							<div>
								<dt><?php echo esc_html( progymorava_child_home_field( 'contact_email_label', 'Email' ) ); ?></dt>
								<dd>
									<a href="mailto:<?php echo esc_attr( antispambot( $contact_email ) ); ?>">
										<?php echo esc_html( antispambot( $contact_email ) ); ?>
									</a>
								</dd>
							</div>
							<div>
								<dt><?php echo esc_html( progymorava_child_home_field( 'contact_phone_label', 'Phone number' ) ); ?></dt>
								<dd>
									<a href="tel:<?php echo esc_attr( $phone_href ); ?>">
										<?php echo esc_html( $contact_phone ); ?>
									</a>
								</dd>
							</div>
						</dl>
					</aside>

					<div class="pg-contact__map">
						<iframe
							src="<?php echo esc_url( progymorava_child_home_field( 'contact_map_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2597.738146241121!2d19.264001500000003!3d49.3760275!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4715b52597980229%3A0x602fb036a149e0e0!2sProGym%20Fitness%20Centrum!5e0!3m2!1sen!2ssk!4v1784816680191!5m2!1sen!2ssk' ) ); ?>"
							loading="lazy"
							referrerpolicy="strict-origin-when-cross-origin"
							title="<?php echo esc_attr( progymorava_child_home_field( 'contact_map_title', 'ProGym Fitness Centrum location' ) ); ?>"
						></iframe>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer();
