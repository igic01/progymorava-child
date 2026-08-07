<?php
/**
 * Template Name: ProGym Prices
 * Template Post Type: page
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

get_header();

$theme_images_url = get_stylesheet_directory_uri() . '/assets/images';
$plan_count       = Progymorava_Child_Prices_Fields::current_page_count( 'prices_plan_count', 5 );
$extra_groups     = Progymorava_Child_Prices_Fields::extra_groups();
$faq_groups       = Progymorava_Child_Prices_FAQ::parse( progymorava_child_home_field( 'prices_faq_content', '' ) );
$faq_columns      = ! empty( $faq_groups ) ? array_chunk( $faq_groups, (int) ceil( count( $faq_groups ) / 2 ) ) : array();
$multisport_image = progymorava_child_home_image( 'prices_multisport_image', $theme_images_url . '/placeholder.jpg', 'MultiSport card training at ProGym' );
$room_image       = progymorava_child_home_image( 'prices_room_image', $theme_images_url . '/placeholder.jpg', 'Private gym room available for activities and testing' );
$hide_multisport  = 1 === (int) progymorava_child_home_field( 'prices_multisport_hide_section', 0 );
$hide_room        = 1 === (int) progymorava_child_home_field( 'prices_room_hide_section', 0 );

$parse_list = static function ( $content ) {
	$items = array_map( 'trim', preg_split( '/\R+/', (string) $content ) );

	return array_values( array_filter( $items, 'strlen' ) );
};

$nutrition_plan_defaults = array(
	array(
		'tag'            => '3 months',
		'price'          => '190€',
		'price_label'    => 'Structured start',
		'title'          => '3-mesačná spolupráca',
		'description'    => 'A structured start for practical, sustainable changes to your nutrition habits.',
		'includes_title' => 'What cooperation includes',
		'includes_items' => "2x InBody measurement\nIntroductory consultation\n3 follow-up check-in consultations with room for questions\nSample dining plan\nAdditional measurements and consultations with a 10€ discount\nWhatsApp or Messenger communication during cooperation",
		'benefits_title' => 'What you get',
		'benefits_items' => "Individual approach according to goals, health, and lifestyle\nBetter energy, regeneration, and performance support\nDiet aligned with your training plan and activity\nSupplement recommendations adjusted to your needs\nSupport for metabolism, digestion, sleep, and stress habits",
		'note'           => 'A strong option if you want guided change with enough time to build better routines.',
		'action_label'   => 'I am interested',
		'featured'       => false,
	),
	array(
		'tag'            => '6 months',
		'price'          => '350€',
		'price_label'    => 'Deeper transformation',
		'title'          => '6-mesačná spolupráca',
		'description'    => 'Extended cooperation with more space for detailed habit and regime adjustments.',
		'includes_title' => 'What cooperation includes',
		'includes_items' => "3x InBody measurement\nIntroductory consultation\n6 follow-up consultations\nTailor-made dining plan and optimisation\nAdditional measurements and consultations with a 10€ discount\nWhatsApp or Messenger communication during cooperation",
		'benefits_title' => 'What you get extra',
		'benefits_items' => "More space for detailed habit work and long-term change\nDeeper focus on regeneration and energy balance\nCloser matching of nutrition with training, work rhythm, and lifestyle\nStress management, recovery quality, and sleep support",
		'note'           => 'Best for members who want longer support, more feedback cycles, and deeper optimisation.',
		'action_label'   => 'I am interested',
		'featured'       => true,
	),
);
$nutrition_plans          = array();

foreach ( $nutrition_plan_defaults as $index => $defaults ) {
	$number = $index + 1;
	$prefix = 'prices_nutrition_plan_' . $number;

	$nutrition_plans[] = array(
		'hidden'      => 1 === (int) progymorava_child_home_field( $prefix . '_hide', 0 ),
		'featured'    => 1 === (int) progymorava_child_home_field( $prefix . '_featured', $defaults['featured'] ? 1 : 0 ),
		'tag'         => progymorava_child_home_field( $prefix . '_tag', $defaults['tag'] ),
		'price'       => progymorava_child_home_field( $prefix . '_price', $defaults['price'] ),
		'price_label' => progymorava_child_home_field( $prefix . '_price_label', $defaults['price_label'] ),
		'title'       => progymorava_child_home_field( $prefix . '_title', $defaults['title'] ),
		'description' => progymorava_child_home_field( $prefix . '_description', $defaults['description'] ),
		'lists'       => array(
			array(
				'title' => progymorava_child_home_field( $prefix . '_includes_title', $defaults['includes_title'] ),
				'items' => $parse_list( progymorava_child_home_field( $prefix . '_includes_items', $defaults['includes_items'] ) ),
			),
			array(
				'title' => progymorava_child_home_field( $prefix . '_benefits_title', $defaults['benefits_title'] ),
				'items' => $parse_list( progymorava_child_home_field( $prefix . '_benefits_items', $defaults['benefits_items'] ) ),
			),
		),
		'note'         => progymorava_child_home_field( $prefix . '_note', $defaults['note'] ),
		'action_label' => progymorava_child_home_field( $prefix . '_action_label', $defaults['action_label'] ),
		'action_url'   => progymorava_child_home_field( $prefix . '_action_url', '#register' ),
	);
}

?>

<main>
	<section class="pg-price-section" id="price-list">
		<div class="pg-price-shell">
			<div class="pg-price-heading">
				<div class="pg-price-copy">
					<p class="pg-price-eyebrow"><?php echo esc_html( progymorava_child_home_field( 'prices_plans_eyebrow', 'Pricing' ) ); ?></p>
					<h1 class="pg-price-title"><?php echo esc_html( progymorava_child_home_field( 'prices_plans_title', 'Choose your next level.' ) ); ?></h1>
					<p class="pg-price-description"><?php echo esc_html( progymorava_child_home_field( 'prices_plans_description', 'Flexible options for quick sessions, steady routines, or full-year consistency.' ) ); ?></p>
				</div>
			</div>

			<div class="pg-price-grid">
				<?php for ( $index = 1; $index <= $plan_count; $index++ ) : ?>
					<?php
					$prefix     = 'prices_plan_' . $index;
					$price_note = function_exists( 'get_field' ) ? trim( (string) get_field( $prefix . '_note' ) ) : '';
					?>
					<article class="pg-price-card" data-tilt-card>
						<div class="pg-price-card-inner">
							<span class="pg-price-badge"><?php echo esc_html( progymorava_child_home_field( $prefix . '_badge', 'Badge' ) ); ?></span>
							<h2 class="pg-price-plan"><?php echo esc_html( progymorava_child_home_field( $prefix . '_title', 'Title' ) ); ?></h2>
							<p class="pg-price-subtitle"><?php echo esc_html( progymorava_child_home_field( $prefix . '_description', 'Description' ) ); ?></p>

							<div class="pg-price-amount">
								<span class="pg-price-amount-value"><?php echo esc_html( progymorava_child_home_field( $prefix . '_price', 'Price' ) ); ?></span>
							</div>

							<a class="pg-price-action" href="<?php echo esc_url( progymorava_child_home_field( $prefix . '_action_url', 'https://www.google.com/' ) ); ?>"><?php echo esc_html( progymorava_child_home_field( $prefix . '_action_label', 'Action label' ) ); ?></a>
							<?php if ( '' !== $price_note ) : ?>
								<p class="pg-price-note"><?php echo esc_html( $price_note ); ?></p>
							<?php endif; ?>
						</div>
					</article>
				<?php endfor; ?>
			</div>
		</div>
	</section>

	<?php if ( ! $hide_multisport ) : ?>
		<section class="pg-about-mission" id="multisport">
			<div class="pg-about-mission__grid">
				<div class="pg-about-mission__copy">
					<p class="pg-about-kicker"><?php echo esc_html( progymorava_child_home_field( 'prices_multisport_eyebrow', 'MultiSport card' ) ); ?></p>
					<h2><?php echo esc_html( progymorava_child_home_field( 'prices_multisport_title', 'Train with your MultiSport card.' ) ); ?></h2>
					<p><?php echo nl2br( esc_html( progymorava_child_home_field( 'prices_multisport_description', 'MultiSport card holders can use ProGym for their training sessions. Bring your valid card and a photo ID to reception.' ) ) ); ?></p>
				</div>

				<div class="pg-about-mission__media">
					<img src="<?php echo esc_url( $multisport_image['url'] ); ?>" alt="<?php echo esc_attr( $multisport_image['alt'] ); ?>" />
				</div>
			</div>
		</section>
	<?php endif; ?>

	<section class="pg-trainer-app" id="trainer-app" aria-labelledby="trainer-app-title">
		<div class="pg-trainer-app__copy">
			<p class="pg-trainer-app__eyebrow"><?php echo esc_html( progymorava_child_home_field( 'prices_trainer_app_eyebrow', 'Personal training' ) ); ?></p>
			<h2 id="trainer-app-title"><?php echo esc_html( progymorava_child_home_field( 'prices_trainer_app_title', 'Find your trainer in the ProGym app.' ) ); ?></h2>
			<p><?php echo esc_html( progymorava_child_home_field( 'prices_trainer_app_description', 'Interested in personal training? Download the ProGym Orava app to get in touch with our trainers and find the support that fits your goals.' ) ); ?></p>
		</div>

		<div class="pg-trainer-app__stores" aria-label="Download the ProGym Orava app">
			<a class="pg-trainer-app__store" href="<?php echo esc_url( progymorava_child_home_field( 'prices_trainer_google_url', 'https://play.google.com/store/apps/details?id=com.progymorava' ) ); ?>" target="_blank" rel="noopener noreferrer">
				<span>
					<small><?php echo esc_html( progymorava_child_home_field( 'prices_trainer_google_small_label', 'Get it on' ) ); ?></small>
					<strong><?php echo esc_html( progymorava_child_home_field( 'prices_trainer_google_label', 'Google Play' ) ); ?></strong>
				</span>
			</a>
			<a class="pg-trainer-app__store" href="<?php echo esc_url( progymorava_child_home_field( 'prices_trainer_apple_url', 'https://apps.apple.com/us/app/progym-orava-z%C3%A1kamenn%C3%A9/id6791676566' ) ); ?>" target="_blank" rel="noopener noreferrer">
				<span>
					<small><?php echo esc_html( progymorava_child_home_field( 'prices_trainer_apple_small_label', 'Download on the' ) ); ?></small>
					<strong><?php echo esc_html( progymorava_child_home_field( 'prices_trainer_apple_label', 'App Store' ) ); ?></strong>
				</span>
			</a>
		</div>
	</section>

	<section class="pg-extra-section" id="services">
		<div class="pg-extra-shell">
			<div class="pg-extra-groups">
				<?php foreach ( $extra_groups as $extra_group ) : ?>
					<?php
					$group_prefix = $extra_group['field_prefix'];
					$item_count   = Progymorava_Child_Prices_Fields::current_page_count( $group_prefix . '_count', $extra_group['default_count'] );
					?>
					<section class="pg-extra-group">
						<div class="pg-extra-group-head">
							<div>
								<h2 class="pg-extra-group-title"><?php echo esc_html( progymorava_child_home_field( $group_prefix . '_section_title', $extra_group['label'] ) ); ?></h2>
								<p class="pg-extra-group-text"><?php echo nl2br( esc_html( progymorava_child_home_field( $group_prefix . '_section_description', $extra_group['default_description'] ) ) ); ?></p>
							</div>
							<span class="pg-extra-chip"><?php echo esc_html( progymorava_child_home_field( $group_prefix . '_section_chip', $extra_group['default_chip'] ) ); ?></span>
						</div>

						<div class="pg-extra-items">
							<?php for ( $index = 1; $index <= $item_count; $index++ ) : ?>
								<?php $prefix = $group_prefix . '_' . $index; ?>
								<div class="pg-extra-item">
									<div>
										<h3 class="pg-extra-item-title"><?php echo esc_html( progymorava_child_home_field( $prefix . '_title', 'Title' ) ); ?></h3>
										<p class="pg-extra-item-text"><?php echo esc_html( progymorava_child_home_field( $prefix . '_description', 'Description' ) ); ?></p>
									</div>
									<div class="pg-extra-price"><?php echo esc_html( progymorava_child_home_field( $prefix . '_price', 'Price' ) ); ?></div>
									<a class="pg-extra-action" href="<?php echo esc_url( progymorava_child_home_field( $prefix . '_action_url', 'https://www.google.com/' ) ); ?>"><?php echo esc_html( progymorava_child_home_field( $prefix . '_action_label', 'Action label' ) ); ?></a>
								</div>
							<?php endfor; ?>
						</div>
					</section>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="pg-nutrition-section" id="nutrition">
		<div class="pg-nutrition-shell">
			<div class="pg-nutrition-head">
				<div class="pg-nutrition-copy">
					<p class="pg-nutrition-eyebrow"><?php echo esc_html( progymorava_child_home_field( 'prices_nutrition_eyebrow', 'Recommendation' ) ); ?></p>
					<h2 class="pg-nutrition-title"><?php echo esc_html( progymorava_child_home_field( 'prices_nutrition_title', 'Choose the depth of cooperation.' ) ); ?></h2>
					<p class="pg-nutrition-description"><?php echo nl2br( esc_html( progymorava_child_home_field( 'prices_nutrition_description', 'Long-term nutrition cooperation tailored to your needs and lifestyle.' ) ) ); ?></p>
				</div>

				<div class="pg-nutrition-badge">
					<strong><?php echo esc_html( progymorava_child_home_field( 'prices_nutrition_badge_title', 'Long-term guidance' ) ); ?></strong>
					<?php echo nl2br( esc_html( progymorava_child_home_field( 'prices_nutrition_badge_text', 'Habit-focused support without strict short-lived dieting.' ) ) ); ?>
				</div>
			</div>

			<div class="pg-nutrition-plans">
				<?php foreach ( $nutrition_plans as $nutrition_plan ) : ?>
					<?php if ( $nutrition_plan['hidden'] ) : ?>
						<?php continue; ?>
					<?php endif; ?>
					<article class="pg-nutrition-plan<?php echo $nutrition_plan['featured'] ? ' is-featured' : ''; ?>">
						<div class="pg-nutrition-plan-head">
							<div class="pg-nutrition-plan-top">
								<span class="pg-nutrition-tag"><?php echo esc_html( $nutrition_plan['tag'] ); ?></span>
								<div class="pg-nutrition-price">
									<?php echo esc_html( $nutrition_plan['price'] ); ?>
									<span><?php echo esc_html( $nutrition_plan['price_label'] ); ?></span>
								</div>
							</div>

							<h3 class="pg-nutrition-plan-title"><?php echo esc_html( $nutrition_plan['title'] ); ?></h3>
							<p class="pg-nutrition-plan-description"><?php echo nl2br( esc_html( $nutrition_plan['description'] ) ); ?></p>
						</div>

						<div class="pg-nutrition-body">
							<?php foreach ( $nutrition_plan['lists'] as $list ) : ?>
								<div class="pg-nutrition-block">
									<h4><?php echo esc_html( $list['title'] ); ?></h4>
									<ul class="pg-nutrition-list">
										<?php foreach ( $list['items'] as $item ) : ?>
											<li><?php echo esc_html( $item ); ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endforeach; ?>
						</div>

						<div class="pg-nutrition-footer">
							<p class="pg-nutrition-note"><?php echo nl2br( esc_html( $nutrition_plan['note'] ) ); ?></p>
							<a class="pg-nutrition-action" href="<?php echo esc_url( $nutrition_plan['action_url'] ); ?>"><?php echo esc_html( $nutrition_plan['action_label'] ); ?></a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php if ( ! $hide_room ) : ?>
		<section class="pg-room-cta" aria-labelledby="room-cta-title">
			<div class="pg-room-cta__frame">
				<img class="pg-room-cta__image" src="<?php echo esc_url( $room_image['url'] ); ?>" alt="<?php echo esc_attr( $room_image['alt'] ); ?>" />
				<div class="pg-room-cta__overlay" aria-hidden="true"></div>

				<div class="pg-room-cta__content">
					<p class="pg-room-cta__eyebrow"><?php echo esc_html( progymorava_child_home_field( 'prices_room_eyebrow', 'Back room reservations' ) ); ?></p>
					<h2 id="room-cta-title"><?php echo esc_html( progymorava_child_home_field( 'prices_room_title', 'Your activity needs its own space.' ) ); ?></h2>
					<p><?php echo nl2br( esc_html( progymorava_child_home_field( 'prices_room_description', 'Reserve our back room for boxing, Zumba, small group sessions, diagnostics, and performance testing.' ) ) ); ?></p>
					<p class="pg-room-cta__linked-text">
						<a href="<?php echo esc_url( progymorava_child_home_field( 'prices_room_link_url', home_url( '/sluzby/' ) ) ); ?>">
							<?php echo esc_html( progymorava_child_home_field( 'prices_room_link_text', 'Viac informácií o priestore' ) ); ?>
							<span aria-hidden="true">&rarr;</span>
						</a>
					</p>

					<div class="pg-room-cta__actions">
						<a class="pg-room-cta__button" href="<?php echo esc_url( progymorava_child_home_field( 'prices_room_action_url', home_url( '/kontakt/' ) ) ); ?>"><?php echo esc_html( progymorava_child_home_field( 'prices_room_action_label', 'Rent the back room' ) ); ?></a>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<section class="pg-faq" id="faq">
		<div class="pg-faq__shell">
			<div class="pg-faq__heading">
				<p class="pg-faq__eyebrow"><?php echo esc_html( progymorava_child_home_field( 'prices_faq_eyebrow', 'FAQ' ) ); ?></p>
				<h2><?php echo esc_html( progymorava_child_home_field( 'prices_faq_title', 'Questions, answered.' ) ); ?></h2>
				<p><?php echo nl2br( esc_html( progymorava_child_home_field( 'prices_faq_description', 'Everything you may need before your first visit, membership, or training session.' ) ) ); ?></p>
			</div>

			<div class="pg-faq__groups">
				<?php foreach ( $faq_columns as $column ) : ?>
					<div class="pg-faq__column">
						<?php foreach ( $column as $group ) : ?>
							<section class="pg-faq__group">
								<h3><?php echo esc_html( $group['title'] ); ?></h3>
								<?php foreach ( $group['items'] as $item ) : ?>
									<details class="pg-faq__item">
										<summary><?php echo esc_html( $item['question'] ); ?></summary>
										<p><?php echo nl2br( esc_html( $item['answer'] ) ); ?></p>
									</details>
								<?php endforeach; ?>
							</section>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
</main>

<?php get_footer();
