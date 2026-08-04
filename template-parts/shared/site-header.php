<?php
/**
 * Shared public-site header.
 *
 * Expected arguments:
 * - active_page: domov, o-nas, cennik, sluzby, organizujeme, kontakt, or an empty string.
 *
 * @package Progymorava_Child
 */

defined( 'ABSPATH' ) || exit;

$active_page = isset( $args['active_page'] ) ? (string) $args['active_page'] : '';
$home_link   = home_url( '/domov/' );
$menu_items  = array(
	'domov'        => array( 'label' => 'Domov', 'path' => '/domov/' ),
	'o-nas'        => array( 'label' => 'O nás', 'path' => '/o-nas/' ),
	'cennik'       => array( 'label' => 'Cenník', 'path' => '/cennik/' ),
	'sluzby'       => array( 'label' => 'Služby', 'path' => '/sluzby/' ),
	'organizujeme' => array( 'label' => 'Organizujeme', 'path' => '/organizujeme/' ),
	'kontakt'      => array( 'label' => 'Kontakt', 'path' => '/kontakt/' ),
);
?>

<header class="pg-header" id="pg-header">
	<div class="pg-header__shell">
		<a class="pg-header__brand" href="<?php echo esc_url( $home_link ); ?>" aria-label="ProGym home">
			<img class="pg-header__logo" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/wide white.svg' ); ?>" alt="ProGym" />
		</a>

		<nav class="pg-header__nav" aria-label="Primary navigation">
			<ul class="pg-header__menu">
				<?php foreach ( $menu_items as $page_key => $menu_item ) : ?>
					<li class="pg-header__item">
						<a class="pg-header__link<?php echo $page_key === $active_page ? ' pg-header__link--active' : ''; ?>" href="<?php echo esc_url( home_url( $menu_item['path'] ) ); ?>"<?php echo $page_key === $active_page ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $menu_item['label'] ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	</div>
</header>
