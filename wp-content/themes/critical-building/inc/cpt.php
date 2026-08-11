<?php
/**
 * Types de contenu personnalisés : Réalisations & Offres d'emploi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function cb_register_post_types() {

	register_post_type( 'realisation', array(
		'labels' => array(
			'name'               => __( 'Réalisations', 'critical-building' ),
			'singular_name'      => __( 'Réalisation', 'critical-building' ),
			'add_new_item'       => __( 'Ajouter une réalisation', 'critical-building' ),
			'edit_item'          => __( 'Modifier la réalisation', 'critical-building' ),
			'new_item'           => __( 'Nouvelle réalisation', 'critical-building' ),
			'view_item'          => __( 'Voir la réalisation', 'critical-building' ),
			'all_items'          => __( 'Toutes les réalisations', 'critical-building' ),
			'search_items'       => __( 'Rechercher une réalisation', 'critical-building' ),
			'not_found'          => __( 'Aucune réalisation trouvée', 'critical-building' ),
			'menu_name'          => __( 'Réalisations', 'critical-building' ),
		),
		'public'        => true,
		'menu_icon'     => 'dashicons-building',
		'menu_position' => 20,
		'supports'      => array( 'title', 'editor', 'thumbnail' ),
		'has_archive'   => false,
		'rewrite'       => array( 'slug' => 'realisations', 'with_front' => false ),
		'show_in_rest'  => true,
	) );

	register_post_type( 'offre_emploi', array(
		'labels' => array(
			'name'               => __( "Offres d'emploi", 'critical-building' ),
			'singular_name'      => __( "Offre d'emploi", 'critical-building' ),
			'add_new_item'       => __( 'Ajouter une offre', 'critical-building' ),
			'edit_item'          => __( "Modifier l'offre", 'critical-building' ),
			'new_item'           => __( 'Nouvelle offre', 'critical-building' ),
			'view_item'          => __( "Voir l'offre", 'critical-building' ),
			'all_items'          => __( 'Toutes les offres', 'critical-building' ),
			'search_items'       => __( 'Rechercher une offre', 'critical-building' ),
			'not_found'          => __( 'Aucune offre trouvée', 'critical-building' ),
			'menu_name'          => __( "Offres d'emploi", 'critical-building' ),
		),
		'public'        => true,
		'menu_icon'     => 'dashicons-groups',
		'menu_position' => 21,
		'supports'      => array( 'title', 'editor' ),
		'has_archive'   => false,
		'rewrite'       => array( 'slug' => 'nous-rejoindre', 'with_front' => false ),
		'show_in_rest'  => true,
	) );

	register_taxonomy( 'profil_client', array( 'realisation' ), array(
		'labels' => array(
			'name'          => __( 'Profils clients', 'critical-building' ),
			'singular_name' => __( 'Profil client', 'critical-building' ),
		),
		'public'       => true,
		'hierarchical' => false,
		'rewrite'      => array( 'slug' => 'profil-client' ),
		'show_in_rest' => true,
	) );
}
add_action( 'init', 'cb_register_post_types' );
