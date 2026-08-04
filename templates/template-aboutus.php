<?php
/**
 * Template Name: ProGym About Us
 * Template Post Type: page
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

get_header( 'home' );

$theme_images_url   = get_stylesheet_directory_uri() . '/assets/images';
$placeholder_url    = $theme_images_url . '/placeholder.jpg';
$mission_image      = progymorava_child_home_image( 'about_mission_image', $placeholder_url, 'ProGym mission' );
$partner_image      = progymorava_child_home_image( 'about_partner_image', $placeholder_url, 'ProGym partner training' );
$hide_mission       = 1 === (int) progymorava_child_home_field( 'about_mission_hide_section', 0 );
$hide_team          = 1 === (int) progymorava_child_home_field( 'about_team_hide_section', 0 );
$hide_partner       = 1 === (int) progymorava_child_home_field( 'about_partner_hide_section', 0 );
$team_member_count  = Progymorava_Child_About_Fields::team_member_count();
$team_member_default = array( 'Name', 'Role' );
$team_members       = array();

for ( $index = 0; $index < $team_member_count; $index++ ) {
	$number         = $index + 1;
	$team_members[] = array(
		'image' => progymorava_child_home_image( 'about_team_member_' . $number . '_image', $placeholder_url, $team_member_default[0] ),
		'name'  => progymorava_child_home_field( 'about_team_member_' . $number . '_name', $team_member_default[0] ),
		'role'  => progymorava_child_home_field( 'about_team_member_' . $number . '_role', $team_member_default[1] ),
	);
}

get_template_part(
	'template-parts/shared/site',
	'header',
	array(
		'active_page'   => 'aboutus',
		'cta_target'    => '#team',
		'show_services' => true,
	)
);
?>

<main>
	<?php if ( ! $hide_mission ) : ?>
		<section class="pg-about-mission" id="about" aria-labelledby="mission-title">
			<div class="pg-about-mission__grid">
				<div class="pg-about-mission__copy">
					<p class="pg-about-kicker"><?php echo esc_html( progymorava_child_home_field( 'about_mission_kicker', 'Our mission' ) ); ?></p>
					<h1 id="mission-title"><?php echo esc_html( progymorava_child_home_field( 'about_mission_title', 'We build stronger people, not just stronger workouts.' ) ); ?></h1>
					<p><?php echo nl2br( esc_html( progymorava_child_home_field( 'about_mission_text_one', 'Our mission is to create a gym environment where progress feels clear, coaching feels personal, and every client knows exactly why they are improving. We combine modern training, real human guidance, and long-term discipline into a system that helps people become better.' ) ) ); ?></p>
					<p><?php echo nl2br( esc_html( progymorava_child_home_field( 'about_mission_text_two', 'This is not just about intensity. It is about consistency, smart structure, and the confidence that comes from training with purpose.' ) ) ); ?></p>
				</div>

				<div class="pg-about-mission__media" data-magnifier>
					<img src="<?php echo esc_url( $mission_image['url'] ); ?>" alt="<?php echo esc_attr( $mission_image['alt'] ); ?>" />
					<span class="pg-about-mission__lens" aria-hidden="true"></span>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( ! $hide_team ) : ?>
		<section class="pg-about-team" id="team" aria-labelledby="team-title">
			<div class="pg-about-team__shell">
				<div class="pg-about-team__copy">
					<p class="pg-about-kicker"><?php echo esc_html( progymorava_child_home_field( 'about_team_kicker', 'About us' ) ); ?></p>
					<h2 id="team-title"><?php echo esc_html( progymorava_child_home_field( 'about_team_title', 'Meet the coaches.' ) ); ?></h2>
					<p><?php echo nl2br( esc_html( progymorava_child_home_field( 'about_team_text', 'A compact team section with a draggable member rail. Pull the lineup to the side and browse all nine people without breaking the clean layout.' ) ) ); ?></p>
					<span class="pg-about-team__pill"><?php echo esc_html( progymorava_child_home_field( 'about_team_drag_label', 'Drag to explore' ) ); ?></span>
				</div>

				<div class="pg-about-team__stage">
					<span class="pg-about-team__cursor" aria-hidden="true"></span>
					<div class="pg-about-team__track" aria-label="ProGym team members">
						<?php foreach ( $team_members as $member ) : ?>
							<article class="pg-about-team__card">
								<div class="pg-about-team__photo">
									<img src="<?php echo esc_url( $member['image']['url'] ); ?>" alt="<?php echo esc_attr( $member['image']['alt'] ); ?>" />
								</div>
								<h3><?php echo esc_html( $member['name'] ); ?></h3>
								<p><?php echo esc_html( $member['role'] ); ?></p>
							</article>
						<?php endforeach; ?>

						<?php if ( ! empty( $team_members ) ) : ?>
							<aside class="pg-about-team__end">
								<h3><?php echo esc_html( progymorava_child_home_field( 'about_team_end_title', 'Those are all of our members, ready to help you.' ) ); ?></h3>
								<p><?php echo esc_html( progymorava_child_home_field( 'about_team_end_text', 'You reached the end of the team list. Every coach in this section is here to support clients with training, guidance, and day-to-day motivation.' ) ); ?></p>
							</aside>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( ! $hide_partner ) : ?>
		<section class="pg-about-partner" id="partner" aria-labelledby="partner-title">
			<div class="pg-about-partner__media">
				<img src="<?php echo esc_url( $partner_image['url'] ); ?>" alt="<?php echo esc_attr( $partner_image['alt'] ); ?>" />
			</div>

			<div class="pg-about-partner__content">
				<div>
					<p class="pg-about-kicker"><?php echo esc_html( progymorava_child_home_field( 'about_partner_kicker', 'Pro Gym Partner' ) ); ?></p>
					<h2 id="partner-title"><?php echo esc_html( progymorava_child_home_field( 'about_partner_title', 'Build your coaching business with us.' ) ); ?></h2>
					<p><?php echo nl2br( esc_html( progymorava_child_home_field( 'about_partner_text_one', 'Are you a trainer, instructor, therapist, or movement specialist with your own client base? Bring your expertise to ProGym and work in a professional environment built for consistent, high-quality coaching.' ) ) ); ?></p>
					<p><?php echo nl2br( esc_html( progymorava_child_home_field( 'about_partner_text_two', 'We are looking for motivated partners who want to grow their work, support their clients, and become part of an ambitious training community.' ) ) ); ?></p>
				</div>

				<div class="pg-about-partner__footer">
					<a class="pg-about-partner__action" href="<?php echo esc_url( progymorava_child_home_field( 'about_partner_action_url', 'https://www.google.com/' ) ); ?>"><?php echo esc_html( progymorava_child_home_field( 'about_partner_action_label', 'Become a partner' ) ); ?></a>
					<span><?php echo esc_html( progymorava_child_home_field( 'about_partner_hint', 'For trainers, instructors, and movement specialists.' ) ); ?></span>
				</div>
			</div>
		</section>
	<?php endif; ?>
</main>

<?php
get_template_part(
	'template-parts/shared/site',
	'footer',
	array(
		'include_contact'      => true,
		'include_contact_link' => true,
		'include_services'     => true,
		'extended_services'    => true,
		'include_follow'       => true,
	)
);

get_footer( 'home' );
