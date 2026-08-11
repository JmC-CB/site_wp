<?php
/**
 * Critical Building - fonctions du thème
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CB_THEME_VERSION', '1.1.6' );
define( 'CB_THEME_DIR', get_template_directory() );
define( 'CB_THEME_URI', get_template_directory_uri() );

/**
 * Setup général du thème
 */
function cb_setup() {
	load_theme_textdomain( 'critical-building', CB_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	set_post_thumbnail_size( 940, 600, true );
	add_image_size( 'cb-hero', 1920, 1080, true );
	add_image_size( 'cb-card', 600, 450, true );

	register_nav_menus( array(
		'primary' => __( 'Menu principal', 'critical-building' ),
		'footer'  => __( 'Plan du site (pied de page)', 'critical-building' ),
	) );
}
add_action( 'after_setup_theme', 'cb_setup' );

/**
 * Feuilles de style / scripts
 */
function cb_enqueue_assets() {
	wp_enqueue_style( 'cb-fonts', CB_THEME_URI . '/assets/css/fonts.css', array(), CB_THEME_VERSION );
	wp_enqueue_style( 'cb-main', CB_THEME_URI . '/assets/css/main.css', array( 'cb-fonts' ), CB_THEME_VERSION );

	wp_enqueue_script( 'cb-main', CB_THEME_URI . '/assets/js/main.js', array(), CB_THEME_VERSION, true );

	// Leaflet (uniquement sur la page contact)
	if ( is_page_template( 'page-templates/page-contact.php' ) ) {
		wp_enqueue_style( 'leaflet', CB_THEME_URI . '/assets/vendor/leaflet/leaflet.css', array(), '1.9.4' );
		wp_enqueue_script( 'leaflet', CB_THEME_URI . '/assets/vendor/leaflet/leaflet.js', array(), '1.9.4', true );
		wp_enqueue_script( 'cb-map', CB_THEME_URI . '/assets/js/map.js', array( 'leaflet' ), CB_THEME_VERSION, true );

		wp_localize_script( 'cb-map', 'cbMapData', array(
			'lat'     => function_exists( 'get_field' ) ? get_field( 'siege_latitude', 'option' ) : 48.7906,
			'lng'     => function_exists( 'get_field' ) ? get_field( 'siege_longitude', 'option' ) : 2.2887,
			'popup'   => function_exists( 'get_field' ) ? get_field( 'siege_adresse', 'option' ) : '',
			'tileUrl' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
			'attrib'  => '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
			'icon'    => CB_THEME_URI . '/assets/vendor/leaflet/images/marker-icon.png',
			'icon2x'  => CB_THEME_URI . '/assets/vendor/leaflet/images/marker-icon-2x.png',
			'shadow'  => CB_THEME_URI . '/assets/vendor/leaflet/images/marker-shadow.png',
		) );
	}
}
add_action( 'wp_enqueue_scripts', 'cb_enqueue_assets' );

/**
 * Widgets (footer, non utilisé pour l'instant mais utile pour l'admin)
 */
function cb_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Pied de page', 'critical-building' ),
		'id'            => 'footer-1',
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="footer-heading">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'cb_widgets_init' );

/**
 * Nettoyage <head>
 */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

/**
 * Includes
 */
require_once CB_THEME_DIR . '/inc/cpt.php';
require_once CB_THEME_DIR . '/inc/options-page.php';
require_once CB_THEME_DIR . '/inc/acf-fields.php';
require_once CB_THEME_DIR . '/inc/template-tags.php';
require_once CB_THEME_DIR . '/inc/contact-form.php';

/**
 * Menu de secours si aucun menu n'est assigné à l'emplacement "primary"
 */
function cb_fallback_menu() {
	echo '<ul class="nav-menu">';
	wp_list_pages( array( 'title_li' => '' ) );
	echo '</ul>';
}
