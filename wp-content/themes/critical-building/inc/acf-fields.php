<?php
/**
 * Groupes de champs ACF déclarés en PHP (versionnés avec le thème).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'cb_register_acf_fields' );

function cb_register_acf_fields() {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	/* -----------------------------------------------------------
	 * Réglages globaux (page d'options)
	 * --------------------------------------------------------- */
	acf_add_local_field_group( array(
		'key'      => 'group_cb_options',
		'title'    => 'Coordonnées & réseaux sociaux',
		'fields'   => array(
			array( 'key' => 'field_cb_telephone', 'name' => 'telephone', 'label' => 'Téléphone', 'type' => 'text' ),
			array( 'key' => 'field_cb_email', 'name' => 'email', 'label' => 'Email', 'type' => 'email' ),
			array( 'key' => 'field_cb_siege_adresse', 'name' => 'siege_adresse', 'label' => 'Adresse du siège', 'type' => 'textarea', 'rows' => 3 ),
			array( 'key' => 'field_cb_siege_latitude', 'name' => 'siege_latitude', 'label' => 'Latitude du siège', 'type' => 'number', 'step' => 'any' ),
			array( 'key' => 'field_cb_siege_longitude', 'name' => 'siege_longitude', 'label' => 'Longitude du siège', 'type' => 'number', 'step' => 'any' ),
			array( 'key' => 'field_cb_lyon_adresse', 'name' => 'lyon_adresse', 'label' => 'Adresse bureau de Lyon', 'type' => 'textarea', 'rows' => 3 ),
			array( 'key' => 'field_cb_linkedin_url', 'name' => 'linkedin_url', 'label' => 'URL LinkedIn', 'type' => 'url' ),
			array( 'key' => 'field_cb_copyright_text', 'name' => 'copyright_text', 'label' => 'Texte de copyright', 'type' => 'text' ),
		),
		'location' => array(
			array(
				array( 'param' => 'options_page', 'operator' => '==', 'value' => 'cb-options' ),
			),
		),
	) );

	/* -----------------------------------------------------------
	 * Page d'accueil (front page)
	 * --------------------------------------------------------- */
	acf_add_local_field_group( array(
		'key'    => 'group_cb_accueil',
		'title'  => 'Contenu de la page d’accueil',
		'fields' => array(
			array(
				'key'          => 'field_cb_hero_slides',
				'name'         => 'hero_slides',
				'label'        => 'Slider hero (diaporama plein écran)',
				'type'         => 'repeater',
				'layout'       => 'block',
				'button_label' => 'Ajouter une photo',
				'min'          => 1,
				'sub_fields'   => array(
					array(
						'key'           => 'field_cb_hero_slide_image',
						'name'          => 'image',
						'label'         => 'Photo (plein écran)',
						'type'          => 'image',
						'return_format' => 'id',
					),
				),
			),
			array( 'key' => 'field_cb_qsn_heading', 'name' => 'qsn_heading', 'label' => 'Titre section « Qui sommes-nous »', 'type' => 'text', 'default_value' => 'qui sommes-nous ?' ),
			array( 'key' => 'field_cb_qsn_texte', 'name' => 'qsn_texte', 'label' => 'Texte « Qui sommes-nous »', 'type' => 'wysiwyg', 'media_upload' => 0 ),
			array( 'key' => 'field_cb_metiers_heading', 'name' => 'metiers_heading', 'label' => 'Titre section « Nos métiers »', 'type' => 'text', 'default_value' => 'nos métiers' ),
			array( 'key' => 'field_cb_clients_heading', 'name' => 'clients_heading', 'label' => 'Titre section « Nos clients »', 'type' => 'text', 'default_value' => 'Nos clients' ),
			array(
				'key'          => 'field_cb_clients_blocks',
				'name'         => 'clients_blocks',
				'label'        => 'Segments clients',
				'type'         => 'repeater',
				'layout'       => 'block',
				'button_label' => 'Ajouter un segment',
				'sub_fields'   => array(
					array( 'key' => 'field_cb_client_titre', 'name' => 'titre', 'label' => 'Titre', 'type' => 'text' ),
					array( 'key' => 'field_cb_client_texte', 'name' => 'texte', 'label' => 'Texte', 'type' => 'textarea', 'rows' => 2 ),
					array( 'key' => 'field_cb_client_image', 'name' => 'image', 'label' => 'Image', 'type' => 'image', 'return_format' => 'id' ),
				),
			),
			array( 'key' => 'field_cb_clients_citation', 'name' => 'clients_citation', 'label' => 'Citation', 'type' => 'textarea', 'rows' => 3 ),
			array(
				'key'          => 'field_cb_partenaires',
				'name'         => 'partenaires',
				'label'        => 'Logos partenaires',
				'type'         => 'repeater',
				'layout'       => 'table',
				'button_label' => 'Ajouter un partenaire',
				'sub_fields'   => array(
					array( 'key' => 'field_cb_partenaire_logo', 'name' => 'logo', 'label' => 'Logo', 'type' => 'image', 'return_format' => 'id' ),
					array( 'key' => 'field_cb_partenaire_lien', 'name' => 'lien', 'label' => 'Lien', 'type' => 'url' ),
				),
			),
		),
		'location' => array(
			array(
				array( 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ),
			),
		),
	) );

	/* -----------------------------------------------------------
	 * Page Profil
	 * --------------------------------------------------------- */
	acf_add_local_field_group( array(
		'key'    => 'group_cb_profil',
		'title'  => 'Contenu page Profil',
		'fields' => array(
			array(
				'key'          => 'field_cb_profil_intro',
				'name'         => 'intro_lignes',
				'label'        => 'Lignes d’introduction (« qui sommes-nous »)',
				'type'         => 'repeater',
				'layout'       => 'block',
				'button_label' => 'Ajouter une ligne',
				'sub_fields'   => array(
					array( 'key' => 'field_cb_intro_texte', 'name' => 'texte', 'label' => 'Texte (noir)', 'type' => 'text' ),
					array( 'key' => 'field_cb_intro_texte_bleu', 'name' => 'texte_bleu', 'label' => 'Texte (bleu, suite de la phrase)', 'type' => 'text' ),
				),
			),
			array( 'key' => 'field_cb_profil_vision_titre', 'name' => 'vision_titre', 'label' => 'Titre bloc « Notre vision »', 'type' => 'text', 'default_value' => 'Notre vision' ),
			array( 'key' => 'field_cb_profil_vision_image', 'name' => 'vision_image', 'label' => 'Image bloc « Notre vision »', 'type' => 'image', 'return_format' => 'id' ),
			array( 'key' => 'field_cb_profil_vision_texte', 'name' => 'vision_texte', 'label' => 'Texte bloc « Notre vision »', 'type' => 'wysiwyg', 'media_upload' => 0 ),
			array( 'key' => 'field_cb_profil_mission_titre', 'name' => 'mission_titre', 'label' => 'Titre bloc « Notre mission »', 'type' => 'text', 'default_value' => 'Notre mission' ),
			array( 'key' => 'field_cb_profil_mission_image', 'name' => 'mission_image', 'label' => 'Image bloc « Notre mission »', 'type' => 'image', 'return_format' => 'id' ),
			array( 'key' => 'field_cb_profil_mission_texte', 'name' => 'mission_texte', 'label' => 'Texte bloc « Notre mission »', 'type' => 'wysiwyg', 'media_upload' => 0 ),
		),
		'location' => array(
			array(
				array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-templates/page-profil.php' ),
			),
		),
	) );

	/* -----------------------------------------------------------
	 * Pages métier (expertise-et-conseils / études-et-suivi)
	 * --------------------------------------------------------- */
	acf_add_local_field_group( array(
		'key'    => 'group_cb_metier',
		'title'  => 'Contenu page métier',
		'fields' => array(
			array( 'key' => 'field_cb_metier_intro', 'name' => 'intro_heading', 'label' => 'Titre d’introduction', 'type' => 'text' ),
			array( 'key' => 'field_cb_metier_image', 'name' => 'card_image', 'label' => 'Image (bannière + carte accueil)', 'type' => 'image', 'return_format' => 'id' ),
			array( 'key' => 'field_cb_metier_teaser', 'name' => 'card_teaser', 'label' => 'Accroche courte (carte accueil)', 'type' => 'textarea', 'rows' => 2 ),
		),
		'location' => array(
			array(
				array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-templates/page-metier.php' ),
			),
		),
	) );

	/* -----------------------------------------------------------
	 * CPT Réalisations
	 * --------------------------------------------------------- */
	acf_add_local_field_group( array(
		'key'    => 'group_cb_realisation',
		'title'  => 'Détails de la réalisation',
		'fields' => array(
			array( 'key' => 'field_cb_real_client', 'name' => 'nom_client', 'label' => 'Client / lieu (sous-titre)', 'type' => 'text' ),
			array( 'key' => 'field_cb_real_profil', 'name' => 'profil_client', 'label' => 'Profil client', 'type' => 'text' ),
			array( 'key' => 'field_cb_real_surface', 'name' => 'surface_it', 'label' => 'Surface IT', 'type' => 'text' ),
			array( 'key' => 'field_cb_real_application', 'name' => 'application', 'label' => 'Application', 'type' => 'text' ),
			array( 'key' => 'field_cb_real_livraison', 'name' => 'livraison', 'label' => 'Livraison', 'type' => 'text' ),
			array(
				'key'           => 'field_cb_real_galerie',
				'name'          => 'galerie',
				'label'         => 'Galerie photos',
				'type'          => 'gallery',
				'return_format' => 'id',
			),
		),
		'location' => array(
			array(
				array( 'param' => 'post_type', 'operator' => '==', 'value' => 'realisation' ),
			),
		),
	) );

	/* -----------------------------------------------------------
	 * CPT Offres d'emploi
	 * --------------------------------------------------------- */
	acf_add_local_field_group( array(
		'key'    => 'group_cb_offre',
		'title'  => 'Détails de l’offre',
		'fields' => array(
			array(
				'key'     => 'field_cb_offre_type',
				'name'    => 'type_contrat',
				'label'   => 'Type de contrat',
				'type'    => 'select',
				'choices' => array( 'CDI' => 'CDI', 'CDD' => 'CDD', 'Alternance' => 'Alternance', 'Stage' => 'Stage' ),
				'default_value' => 'CDI',
			),
			array( 'key' => 'field_cb_offre_lieu', 'name' => 'lieu', 'label' => 'Lieu', 'type' => 'text' ),
			array( 'key' => 'field_cb_offre_experience', 'name' => 'experience', 'label' => 'Expérience requise', 'type' => 'text' ),
		),
		'location' => array(
			array(
				array( 'param' => 'post_type', 'operator' => '==', 'value' => 'offre_emploi' ),
			),
		),
	) );
}
