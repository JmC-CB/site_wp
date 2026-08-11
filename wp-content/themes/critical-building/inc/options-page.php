<?php
/**
 * Page d'options ACF : réglages globaux (coordonnées, réseaux sociaux)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}
	acf_add_options_page( array(
		'page_title' => __( 'Réglages Critical Building', 'critical-building' ),
		'menu_title' => __( 'Réglages du site', 'critical-building' ),
		'menu_slug'  => 'cb-options',
		'capability' => 'manage_options',
		'icon_url'   => 'dashicons-admin-generic',
		'position'   => 60,
	) );
} );
