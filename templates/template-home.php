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
$promo_gallery_images = array(
	progymorava_child_home_image( 'home_promo_gallery_image_one', $placeholder_url, 'ProGym fotografia 1' ),
	progymorava_child_home_image( 'home_promo_gallery_image_two', $placeholder_url, 'ProGym fotografia 2' ),
	progymorava_child_home_image( 'home_promo_gallery_image_three', $placeholder_url, 'ProGym fotografia 3' ),
);

$gallery_selection = (array) progymorava_child_home_field( 'home_gallery_media', array() );
$gallery_items     = array();

foreach ( $gallery_selection as $gallery_attachment ) {
	$attachment_id = is_object( $gallery_attachment ) ? (int) $gallery_attachment->ID : (int) $gallery_attachment;
	$mime_type     = (string) get_post_mime_type( $attachment_id );
	$is_image      = 0 === strpos( $mime_type, 'image/' );
	$is_video      = 0 === strpos( $mime_type, 'video/' );

	if ( ! $attachment_id || ( ! $is_image && ! $is_video ) ) {
		continue;
	}

	$media_url     = $is_image ? wp_get_attachment_image_url( $attachment_id, 'full' ) : wp_get_attachment_url( $attachment_id );
	$media_url     = $media_url ?: wp_get_attachment_url( $attachment_id );
	$thumbnail_url = $is_image ? wp_get_attachment_image_url( $attachment_id, 'large' ) : $media_url;
	$thumbnail_url = $thumbnail_url ?: $media_url;

	if ( ! $media_url || ! $thumbnail_url ) {
		continue;
	}

	$gallery_items[] = array(
		'type'          => $is_video ? 'video' : 'image',
		'url'           => $media_url,
		'thumbnail_url' => $thumbnail_url,
		'alt'           => (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ),
	);
}

$hide_gallery = 1 === (int) progymorava_child_home_field( 'home_gallery_hide_section', 0 );

$hide_app_stripe = 1 === (int) progymorava_child_home_field( 'home_app_stripe_hide', 0 );
$app_stripe_text = (string) progymorava_child_home_field( 'home_app_stripe_text', 'Stiahni si našu aplikáciu a vychutnaj si progym na vlastnej koži' );
$app_store_links = array(
	array(
		'class' => 'fa-apple',
		'label' => 'Stiahnuť v App Store',
		'url'   => progymorava_child_home_field( 'home_app_stripe_apple_url', 'https://apps.apple.com/us/app/progym-orava-z%C3%A1kamenn%C3%A9/id6791676566' ),
	),
	array(
		'class' => 'fa-android',
		'label' => 'Stiahnuť v Google Play',
		'url'   => progymorava_child_home_field( 'home_app_stripe_android_url', 'https://play.google.com/store/apps/details?id=com.progymorava' ),
	),
);

if ( ! $hide_app_stripe ) :
	?>
	<aside class="pg-app-stripe" aria-label="Aplikácia ProGym">
		<div class="pg-app-stripe__inner">
			<p class="pg-app-stripe__text"><?php echo esc_html( $app_stripe_text ); ?></p>
			<div class="pg-app-stripe__stores" aria-label="Stiahnuť aplikáciu ProGym">
				<?php foreach ( $app_store_links as $app_store_link ) : ?>
					<?php if ( '' === trim( (string) $app_store_link['url'] ) ) : ?>
						<?php continue; ?>
					<?php endif; ?>
					<a class="pg-app-stripe__store" href="<?php echo esc_url( $app_store_link['url'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $app_store_link['label'] ); ?>">
						<i class="fa-brands <?php echo esc_attr( $app_store_link['class'] ); ?>" aria-hidden="true"></i>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</aside>
	<?php
endif;

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

			<article class="pg-promo-gallery" data-promo-gallery aria-labelledby="promo-gallery-title">
				<div class="pg-promo-gallery__top">
					<h3 id="promo-gallery-title"><?php echo esc_html( progymorava_child_home_field( 'home_promo_gallery_title', 'Nahliadni do ProGym' ) ); ?></h3>
				</div>

				<div class="pg-promo-gallery__grid">
					<?php foreach ( $promo_gallery_images as $promo_gallery_index => $promo_gallery_image ) : ?>
						<button
							class="pg-promo-gallery__image-button"
							type="button"
							data-promo-gallery-item
							data-image-url="<?php echo esc_url( $promo_gallery_image['url'] ); ?>"
							aria-label="<?php echo esc_attr( sprintf( 'Otvoriť fotografiu %d', $promo_gallery_index + 1 ) ); ?>"
						>
							<img src="<?php echo esc_url( $promo_gallery_image['url'] ); ?>" alt="<?php echo esc_attr( $promo_gallery_image['alt'] ); ?>" loading="lazy" decoding="async" />
						</button>
					<?php endforeach; ?>
				</div>

				<a class="pg-promo-gallery__action" href="<?php echo esc_url( progymorava_child_home_field( 'home_promo_gallery_button_url', 'https://www.google.com/' ) ); ?>">
					<?php echo esc_html( progymorava_child_home_field( 'home_promo_gallery_button_label', 'Pozrieť galériu' ) ); ?>
				</a>

				<dialog class="pg-promo-gallery__lightbox" data-promo-gallery-lightbox aria-label="Náhľad fotografie">
					<button class="pg-promo-gallery__close" type="button" data-promo-gallery-close aria-label="Zavrieť fotografiu">&times;</button>
					<div class="pg-promo-gallery__stage">
						<img data-promo-gallery-image alt="" />
					</div>
				</dialog>
			</article>
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

	<?php if ( ! $hide_gallery && $gallery_items ) : ?>
		<section class="pg-home-gallery" data-home-gallery aria-labelledby="pg-home-gallery-title">
			<div class="pg-home-gallery__shell">
				<header class="pg-home-gallery__header">
					<?php $gallery_eyebrow = (string) progymorava_child_home_field( 'home_gallery_eyebrow', 'Galéria' ); ?>
					<?php if ( '' !== trim( $gallery_eyebrow ) ) : ?>
						<p><?php echo esc_html( $gallery_eyebrow ); ?></p>
					<?php endif; ?>
					<h2 id="pg-home-gallery-title"><?php echo esc_html( progymorava_child_home_field( 'home_gallery_title', 'Pozrite si ProGym zblízka' ) ); ?></h2>
				</header>

				<div class="pg-home-gallery__grid">
					<?php foreach ( $gallery_items as $gallery_index => $gallery_item ) : ?>
						<button
							class="pg-home-gallery__item pg-home-gallery__item--<?php echo esc_attr( $gallery_item['type'] ); ?>"
							type="button"
							data-home-gallery-item
							data-media-type="<?php echo esc_attr( $gallery_item['type'] ); ?>"
							data-media-url="<?php echo esc_url( $gallery_item['url'] ); ?>"
							data-media-alt="<?php echo esc_attr( $gallery_item['alt'] ); ?>"
							aria-label="<?php echo esc_attr( sprintf( 'Otvoriť %s galérie %d', 'video' === $gallery_item['type'] ? 'video' : 'obrázok', $gallery_index + 1 ) ); ?>"
						>
							<?php if ( 'video' === $gallery_item['type'] ) : ?>
								<video muted playsinline preload="metadata" src="<?php echo esc_url( $gallery_item['thumbnail_url'] ); ?>" aria-hidden="true"></video>
								<span class="pg-home-gallery__play" aria-hidden="true">
									<svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5.14v13.72L19 12 8 5.14Z"></path></svg>
								</span>
							<?php else : ?>
								<img src="<?php echo esc_url( $gallery_item['thumbnail_url'] ); ?>" alt="<?php echo esc_attr( $gallery_item['alt'] ); ?>" loading="lazy" decoding="async">
							<?php endif; ?>
						</button>
					<?php endforeach; ?>
				</div>
			</div>

			<dialog class="pg-home-gallery__lightbox" data-home-gallery-lightbox aria-label="Náhľad galérie">
				<button class="pg-home-gallery__close" type="button" data-home-gallery-close aria-label="Zavrieť galériu">
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m7 7 10 10M17 7 7 17"></path></svg>
				</button>
				<button class="pg-home-gallery__nav pg-home-gallery__nav--previous" type="button" data-home-gallery-previous aria-label="Predchádzajúce médium">
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 5-7 7 7 7"></path></svg>
				</button>
				<div class="pg-home-gallery__stage">
					<img data-home-gallery-image src="" alt="" hidden>
					<video data-home-gallery-video controls playsinline preload="metadata" hidden></video>
				</div>
				<button class="pg-home-gallery__nav pg-home-gallery__nav--next" type="button" data-home-gallery-next aria-label="Nasledujúce médium">
					<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m9 5 7 7-7 7"></path></svg>
				</button>
			</dialog>
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
