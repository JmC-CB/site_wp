<?php
/**
 * En-tête du site : <head> + navigation principale
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class( is_front_page() ? 'cb-home' : '' ); ?>>
<?php wp_body_open(); ?>

<a class="cb-skip-link screen-reader-text" href="#cb-content">Aller au contenu</a>

<header class="cb-header" id="cb-header">
	<div class="cb-container cb-header__inner">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="cb-logo">
			<img src="<?php echo esc_url( CB_THEME_URI . '/assets/img/logo-critical-building.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>">
		</a>

		<nav class="cb-nav" id="cb-nav" aria-label="Menu principal">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'cb-nav__list',
				'fallback_cb'    => 'cb_fallback_menu',
			) );
			?>
		</nav>

		<button type="button" class="cb-nav-toggle" id="cb-nav-toggle" aria-expanded="false" aria-controls="cb-nav">
			<span></span><span></span><span></span>
			<span class="screen-reader-text">Menu</span>
		</button>
	</div>
</header>

<main id="cb-content" class="cb-main">
