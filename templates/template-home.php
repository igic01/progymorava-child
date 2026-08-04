<?php
/**
 * Template Name: ProGym Home
 * Template Post Type: page
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

get_header( 'home' );

$theme_images_url = get_stylesheet_directory_uri() . '/assets/images';
$placeholder_url  = $theme_images_url . '/placeholder.jpg';

$hero_image       = progymorava_child_home_image( 'home_hero_image', $placeholder_url, 'Focused athlete training inside the gym' );
$why_image        = progymorava_child_home_image( 'home_why_image', $placeholder_url, 'Athlete training inside the gym' );
$motivation_image = progymorava_child_home_image( 'home_motivation_image', $placeholder_url, 'Motivational gym training' );

$hero_action_label       = progymorava_child_home_field( 'home_hero_action_label', 'Start now' );
$training_link_label     = progymorava_child_home_field( 'home_training_link_label', 'See all' );
$training_card_count     = max( 0, (int) progymorava_child_home_field( 'home_training_card_count', 3 ) );
$training_card_defaults  = array(
	array( 'Personal training', 'Private training with a personal trainer' ),
	array( 'Group fitness classes', 'Group fitness training session' ),
	array( 'Functional training', 'Functional fitness training session' ),
);
$training_cards          = array();

for ( $number = 1; $number <= $training_card_count; $number++ ) {
	$suffix  = Progymorava_Child_Home_Fields::training_card_suffix( $number );
	$default = isset( $training_card_defaults[ $number - 1 ] )
		? $training_card_defaults[ $number - 1 ]
		: array( 'Training card ' . $number, 'Gym training session' );
	$prefix  = 'home_training_card_' . $suffix;

	$training_cards[] = array(
		'image' => progymorava_child_home_image( $prefix . '_image', $placeholder_url, $default[1] ),
		'title' => progymorava_child_home_field( $prefix . '_title', $default[0] ),
		'url'   => progymorava_child_home_field( $prefix . '_url', 'https://www.google.com/' ),
	);
}
$why_items               = array(
	array(
		'icon'  => progymorava_child_home_field( 'home_why_item_one_icon', '24' ),
		'title' => progymorava_child_home_field( 'home_why_item_one_title', '24/7 Access' ),
		'text'  => progymorava_child_home_field( 'home_why_item_one_text', 'Train early, late, or between shifts with round-the-clock entry that keeps your routine under your control.' ),
	),
	array(
		'icon'  => progymorava_child_home_field( 'home_why_item_two_icon', 'EQ' ),
		'title' => progymorava_child_home_field( 'home_why_item_two_title', 'Modern Equipment' ),
		'text'  => progymorava_child_home_field( 'home_why_item_two_text', 'Use reliable machines, quality free weights, and performance-focused training stations built for serious work.' ),
	),
	array(
		'icon'  => progymorava_child_home_field( 'home_why_item_three_icon', 'CE' ),
		'title' => progymorava_child_home_field( 'home_why_item_three_title', 'Certified Experts' ),
		'text'  => progymorava_child_home_field( 'home_why_item_three_text', 'Work with experienced coaches who know technique, progression, and how to turn effort into sustainable results.' ),
	),
);

$hide_hero       = 1 === (int) progymorava_child_home_field( 'home_hero_hide_section', 0 );
$hide_training   = 1 === (int) progymorava_child_home_field( 'home_training_hide_section', 0 );
$hide_promo      = 1 === (int) progymorava_child_home_field( 'home_promo_hide_section', 0 );
$hide_why        = 1 === (int) progymorava_child_home_field( 'home_why_hide_section', 0 );
$hide_motivation = 1 === (int) progymorava_child_home_field( 'home_motivation_hide_section', 0 );

$hero_headline  = progymorava_child_home_field( 'home_hero_headline', "Inside\nand\nout." );
$hero_lines     = preg_split( '/\R+/', trim( (string) $hero_headline ) );
$hero_line_one  = isset( $hero_lines[0] ) ? $hero_lines[0] : '';
$hero_line_two  = isset( $hero_lines[1] ) ? $hero_lines[1] : '';
$hero_line_mark = count( $hero_lines ) > 2 ? implode( ' ', array_slice( $hero_lines, 2 ) ) : '';

$promo_price_label   = progymorava_child_home_field( 'home_promo_price_label', 'Three-month membership' );
$promo_price         = progymorava_child_home_field( 'home_promo_price', '90€' );
$promo_regular_label = progymorava_child_home_field( 'home_promo_regular_label', 'Regularly' );
$promo_regular_price = progymorava_child_home_field( 'home_promo_regular_price', '115€' );

get_template_part(
	'template-parts/shared/site',
	'header',
	array(
		'active_page' => 'domov',
	)
);
?>

<main>
	<?php if ( ! $hide_hero ) : ?>
		<section class="pg-hero" id="pg-hero">
			<div class="pg-hero__shell">
				<div class="pg-hero__card">
					<img class="pg-hero__image" src="<?php echo esc_url( $hero_image['url'] ); ?>" alt="<?php echo esc_attr( $hero_image['alt'] ); ?>" />
					<div class="pg-hero__overlay"></div>
					<div class="pg-hero__grain" aria-hidden="true"></div>

					<div class="pg-hero__content">
						<div class="pg-hero__chips">
							<span class="pg-chip pg-chip--solid"><?php echo esc_html( progymorava_child_home_field( 'home_hero_badge', 'Open 24/7' ) ); ?></span>
						</div>

						<div class="pg-hero__headline">
							<?php echo esc_html( $hero_line_one ); ?><br /><?php echo esc_html( $hero_line_two ); ?>
							<?php if ( '' !== $hero_line_mark ) : ?>
								<span class="pg-hero__headline-mark"><?php echo esc_html( $hero_line_mark ); ?></span>
							<?php endif; ?>
						</div>

						<div class="pg-hero__bottom">
							<p class="pg-hero__summary">
								<?php echo nl2br( esc_html( progymorava_child_home_field( 'home_hero_summary', 'We build stronger bodies with focused coaching, premium equipment, and a high-performance space designed to keep your training consistent.' ) ) ); ?>
							</p>

							<div class="pg-hero__actions">
								<span class="pg-hero__meta"><?php echo esc_html( $hero_action_label ); ?></span>
								<a class="pg-hero__play" href="<?php echo esc_url( progymorava_child_home_field( 'home_hero_action_url', 'https://www.google.com/' ) ); ?>" aria-label="<?php echo esc_attr( $hero_action_label ); ?>">
									<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
										<path d="M8 5.14v13.72L19 12 8 5.14Z"></path>
									</svg>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( ! $hide_training ) : ?>
		<section class="pg-training" id="pg-training">
			<div class="pg-training__shell">
				<div class="pg-training__top">
					<p class="pg-training__eyebrow"><?php echo esc_html( progymorava_child_home_field( 'home_training_eyebrow', 'Trainings' ) ); ?></p>
					<a class="pg-training__link" href="<?php echo esc_url( progymorava_child_home_field( 'home_training_link_url', 'https://www.google.com/' ) ); ?>" aria-label="<?php echo esc_attr( $training_link_label ); ?>">
						<?php echo esc_html( $training_link_label ); ?>
						<span class="pg-training__link-dot" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
								<path d="M12 5v14"></path>
								<path d="M5 12h14"></path>
							</svg>
						</span>
					</a>
				</div>

				<div class="pg-training__list">
					<?php foreach ( $training_cards as $training_card ) : ?>
						<a class="pg-training__card" href="<?php echo esc_url( $training_card['url'] ); ?>" aria-label="<?php echo esc_attr( $training_card['title'] ); ?>">
							<img class="pg-training__image" src="<?php echo esc_url( $training_card['image']['url'] ); ?>" alt="<?php echo esc_attr( $training_card['image']['alt'] ); ?>" />
							<div class="pg-training__overlay"></div>
							<div class="pg-training__content">
								<h2 class="pg-training__title"><?php echo esc_html( $training_card['title'] ); ?></h2>
								<span class="pg-training__arrow" aria-hidden="true">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M5 12h14"></path>
										<path d="m12 5 7 7-7 7"></path>
									</svg>
								</span>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( ! $hide_promo ) : ?>
		<section class="pg-promo" aria-labelledby="promo-title">
			<div class="pg-promo__shell">
				<div class="pg-promo__copy">
					<p class="pg-promo__eyebrow"><?php echo esc_html( progymorava_child_home_field( 'home_promo_eyebrow', 'Limited offer' ) ); ?></p>
					<h2 id="promo-title"><?php echo esc_html( progymorava_child_home_field( 'home_promo_title', 'Three months. More momentum.' ) ); ?></h2>
					<p><?php echo nl2br( esc_html( progymorava_child_home_field( 'home_promo_text', 'Start your routine with a special three-month membership offer and give your progress time to build.' ) ) ); ?></p>
				</div>

				<div class="pg-promo__price" aria-label="<?php echo esc_attr( $promo_price_label . ' ' . $promo_price . ', ' . $promo_regular_label . ' ' . $promo_regular_price ); ?>">
					<span class="pg-promo__label"><?php echo esc_html( $promo_price_label ); ?></span>
					<strong><?php echo esc_html( $promo_price ); ?></strong>
					<span class="pg-promo__regular">
						<?php echo esc_html( $promo_regular_label ); ?> <s><?php echo esc_html( $promo_regular_price ); ?></s>
					</span>
				</div>

				<a class="pg-promo__action" href="<?php echo esc_url( progymorava_child_home_field( 'home_promo_action_url', 'https://www.google.com/' ) ); ?>">
					<?php echo esc_html( progymorava_child_home_field( 'home_promo_action_label', 'View price list' ) ); ?>
				</a>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( ! $hide_why ) : ?>
		<section class="pg-why" id="pg-why">
			<div class="pg-why__shell">
				<div class="pg-why__header">
					<p class="pg-why__eyebrow"><?php echo esc_html( progymorava_child_home_field( 'home_why_eyebrow', 'Why us' ) ); ?></p>
					<h2 class="pg-why__title">
						<?php echo esc_html( progymorava_child_home_field( 'home_why_title_before', 'Train with' ) ); ?>
						<span class="pg-why__title-mark"><?php echo esc_html( progymorava_child_home_field( 'home_why_title_mark', 'purpose' ) ); ?></span>
					</h2>
					<p class="pg-why__lead"><?php echo nl2br( esc_html( progymorava_child_home_field( 'home_why_lead', 'Built for people who want consistency, expert guidance, and a gym environment that supports real progress every day of the week.' ) ) ); ?></p>
				</div>

				<div class="pg-why__layout">
					<div class="pg-why__media">
						<img class="pg-why__image" src="<?php echo esc_url( $why_image['url'] ); ?>" alt="<?php echo esc_attr( $why_image['alt'] ); ?>" />
						<div class="pg-why__overlay"></div>
					</div>

					<div class="pg-why__list">
						<?php foreach ( $why_items as $why_item ) : ?>
							<article class="pg-why__item">
								<div class="pg-why__icon"><?php echo esc_html( $why_item['icon'] ); ?></div>
								<div>
									<h3 class="pg-why__item-title"><?php echo esc_html( $why_item['title'] ); ?></h3>
									<p class="pg-why__item-text"><?php echo nl2br( esc_html( $why_item['text'] ) ); ?></p>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( ! $hide_motivation ) : ?>
		<section class="pg-motivation" id="register">
			<div class="pg-motivation__shell">
				<div class="pg-motivation__frame">
					<img class="pg-motivation__image" src="<?php echo esc_url( $motivation_image['url'] ); ?>" alt="<?php echo esc_attr( $motivation_image['alt'] ); ?>" />
					<div class="pg-motivation__overlay"></div>

					<div class="pg-motivation__content">
						<p class="pg-motivation__eyebrow"><?php echo esc_html( progymorava_child_home_field( 'home_motivation_eyebrow', 'Stay consistent' ) ); ?></p>
						<h2 class="pg-motivation__quote">
							<?php echo esc_html( progymorava_child_home_field( 'home_motivation_quote_before', 'Strong habits.' ) ); ?>
							<span class="pg-motivation__quote-mark"><?php echo esc_html( progymorava_child_home_field( 'home_motivation_quote_mark', 'Stronger you.' ) ); ?></span>
						</h2>
						<p class="pg-motivation__text"><?php echo nl2br( esc_html( progymorava_child_home_field( 'home_motivation_text', 'Progress is not built in one perfect day. It is built by showing up again, training with intent, and choosing not to stop when it gets difficult.' ) ) ); ?></p>

						<div class="pg-motivation__actions">
							<a class="pg-motivation__button" href="<?php echo esc_url( progymorava_child_home_field( 'home_motivation_button_url', 'https://www.google.com/' ) ); ?>">
								<?php echo esc_html( progymorava_child_home_field( 'home_motivation_button_label', 'Register now' ) ); ?>
							</a>
							<span class="pg-motivation__hint"><?php echo esc_html( progymorava_child_home_field( 'home_motivation_hint', 'Your next level starts with one decision' ) ); ?></span>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>
</main>

<?php
get_template_part(
	'template-parts/shared/app',
	'popup',
	array(
		'post_id' => get_queried_object_id(),
	)
);

get_template_part(
	'template-parts/shared/site',
	'footer',
	array(
		'extended_services' => true,
		'include_follow'    => true,
	)
);

get_footer( 'home' );
