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
	$marqueur_fields = function ( $prefix ) {
		return array(
			array( 'key' => "field_cb_{$prefix}_nom", 'name' => 'nom', 'label' => 'Nom (ex. « Siège Paris »)', 'type' => 'text' ),
			array( 'key' => "field_cb_{$prefix}_adresse", 'name' => 'adresse', 'label' => 'Adresse (affichée dans l’info-bulle)', 'type' => 'textarea', 'rows' => 2 ),
			array( 'key' => "field_cb_{$prefix}_latitude", 'name' => 'latitude', 'label' => 'Latitude', 'type' => 'number', 'step' => 'any', 'instructions' => 'Sur Google Maps : clic droit sur le point → les coordonnées s’affichent en haut du menu, à copier-coller.' ),
			array( 'key' => "field_cb_{$prefix}_longitude", 'name' => 'longitude', 'label' => 'Longitude', 'type' => 'number', 'step' => 'any' ),
		);
	};

	acf_add_local_field_group( array(
		'key'      => 'group_cb_options',
		'title'    => 'Coordonnées & réseaux sociaux',
		'fields'   => array(
			array( 'key' => 'field_cb_telephone', 'name' => 'telephone', 'label' => 'Téléphone', 'type' => 'text' ),
			array( 'key' => 'field_cb_email', 'name' => 'email', 'label' => 'Email', 'type' => 'email' ),
			array( 'key' => 'field_cb_siege_adresse', 'name' => 'siege_adresse', 'label' => 'Adresse du siège (texte pied de page / page contact)', 'type' => 'textarea', 'rows' => 3 ),
			array( 'key' => 'field_cb_lyon_adresse', 'name' => 'lyon_adresse', 'label' => 'Adresse bureau de Lyon (texte pied de page / page contact)', 'type' => 'textarea', 'rows' => 3 ),
			array( 'key' => 'field_cb_linkedin_url', 'name' => 'linkedin_url', 'label' => 'URL LinkedIn', 'type' => 'url' ),
			array( 'key' => 'field_cb_copyright_text', 'name' => 'copyright_text', 'label' => 'Texte de copyright', 'type' => 'text' ),

			array(
				'key'     => 'field_cb_carte_note',
				'name'    => 'carte_note',
				'label'   => 'Points sur la carte (page Contact)',
				'type'    => 'message',
				'message' => 'Jusqu’à 4 points affichables sur la carte. Laissez « Nom » vide pour ne pas afficher un point.',
			),
			array( 'key' => 'field_cb_marqueur_1', 'name' => 'marqueur_1', 'label' => 'Point 1', 'type' => 'group', 'sub_fields' => $marqueur_fields( 'marqueur_1' ) ),
			array( 'key' => 'field_cb_marqueur_2', 'name' => 'marqueur_2', 'label' => 'Point 2', 'type' => 'group', 'sub_fields' => $marqueur_fields( 'marqueur_2' ) ),
			array( 'key' => 'field_cb_marqueur_3', 'name' => 'marqueur_3', 'label' => 'Point 3', 'type' => 'group', 'sub_fields' => $marqueur_fields( 'marqueur_3' ) ),
			array( 'key' => 'field_cb_marqueur_4', 'name' => 'marqueur_4', 'label' => 'Point 4', 'type' => 'group', 'sub_fields' => $marqueur_fields( 'marqueur_4' ) ),
		),
		'location' => array(
			array(
				array( 'param' => 'options_page', 'operator' => '==', 'value' => 'cb-options' ),
			),
		),
	) );

	/* -----------------------------------------------------------
	 * Page d'accueil (front page)
	 *
	 * NB : ACF gratuit n'a PAS les champs Repeater/Gallery/Flexible Content/Clone
	 * (réservés à ACF PRO). Le slider, les segments clients et les logos partenaires
	 * sont donc déclarés en champs "Group" fixes (nombre d'éléments figé mais
	 * chaque groupe reste 100% éditable depuis l'admin, sans dépendance à PRO).
	 * --------------------------------------------------------- */
	$client_group_fields = function ( $prefix ) {
		return array(
			array( 'key' => "field_cb_{$prefix}_titre", 'name' => 'titre', 'label' => 'Titre', 'type' => 'text' ),
			array( 'key' => "field_cb_{$prefix}_texte", 'name' => 'texte', 'label' => 'Texte', 'type' => 'textarea', 'rows' => 2 ),
			array( 'key' => "field_cb_{$prefix}_image", 'name' => 'image', 'label' => 'Image', 'type' => 'image', 'return_format' => 'id' ),
		);
	};
	$partenaire_group_fields = function ( $prefix ) {
		return array(
			array( 'key' => "field_cb_{$prefix}_logo", 'name' => 'logo', 'label' => 'Logo', 'type' => 'image', 'return_format' => 'id' ),
			array( 'key' => "field_cb_{$prefix}_lien", 'name' => 'lien', 'label' => 'Lien', 'type' => 'url' ),
		);
	};

	acf_add_local_field_group( array(
		'key'    => 'group_cb_accueil',
		'title'  => 'Contenu de la page d’accueil',
		'fields' => array(
			array(
				'key'     => 'field_cb_hero_slider_note',
				'name'    => 'hero_slider_note',
				'label'   => 'Slider hero (photos plein écran)',
				'type'    => 'message',
				'message' => 'Ajoutez un bloc « Galerie » dans le contenu de cette page (ci-dessus) pour gérer les photos du diaporama d’accueil : autant de photos que vous voulez, réordonnables au glisser-déposer.',
			),
			array(
				'key'          => 'field_cb_hero_titre',
				'name'         => 'hero_titre',
				'label'        => 'Titre du slider hero',
				'type'         => 'textarea',
				'rows'         => 4,
				'instructions' => 'Une ligne = un retour à la ligne affiché sur le slider (4 lignes courtes recommandées).',
			),

			array( 'key' => 'field_cb_qsn_heading', 'name' => 'qsn_heading', 'label' => 'Titre section « Qui sommes-nous »', 'type' => 'text', 'default_value' => 'qui sommes-nous ?' ),
			array( 'key' => 'field_cb_qsn_texte', 'name' => 'qsn_texte', 'label' => 'Texte « Qui sommes-nous »', 'type' => 'wysiwyg', 'media_upload' => 0 ),
			array( 'key' => 'field_cb_metiers_heading', 'name' => 'metiers_heading', 'label' => 'Titre section « Nos métiers »', 'type' => 'text', 'default_value' => 'nos métiers' ),
			array( 'key' => 'field_cb_clients_heading', 'name' => 'clients_heading', 'label' => 'Titre section « Nos clients »', 'type' => 'text', 'default_value' => 'Nos clients' ),

			array( 'key' => 'field_cb_client_1', 'name' => 'client_1', 'label' => 'Segment client 1', 'type' => 'group', 'sub_fields' => $client_group_fields( 'client_1' ) ),
			array( 'key' => 'field_cb_client_2', 'name' => 'client_2', 'label' => 'Segment client 2', 'type' => 'group', 'sub_fields' => $client_group_fields( 'client_2' ) ),
			array( 'key' => 'field_cb_client_3', 'name' => 'client_3', 'label' => 'Segment client 3', 'type' => 'group', 'sub_fields' => $client_group_fields( 'client_3' ) ),

			array( 'key' => 'field_cb_clients_citation', 'name' => 'clients_citation', 'label' => 'Citation', 'type' => 'textarea', 'rows' => 3 ),

			array( 'key' => 'field_cb_partenaire_1', 'name' => 'partenaire_1', 'label' => 'Partenaire 1', 'type' => 'group', 'sub_fields' => $partenaire_group_fields( 'partenaire_1' ) ),
			array( 'key' => 'field_cb_partenaire_2', 'name' => 'partenaire_2', 'label' => 'Partenaire 2', 'type' => 'group', 'sub_fields' => $partenaire_group_fields( 'partenaire_2' ) ),
			array( 'key' => 'field_cb_partenaire_3', 'name' => 'partenaire_3', 'label' => 'Partenaire 3', 'type' => 'group', 'sub_fields' => $partenaire_group_fields( 'partenaire_3' ) ),
			array( 'key' => 'field_cb_partenaire_4', 'name' => 'partenaire_4', 'label' => 'Partenaire 4', 'type' => 'group', 'sub_fields' => $partenaire_group_fields( 'partenaire_4' ) ),
			array( 'key' => 'field_cb_partenaire_5', 'name' => 'partenaire_5', 'label' => 'Partenaire 5', 'type' => 'group', 'sub_fields' => $partenaire_group_fields( 'partenaire_5' ) ),
			array( 'key' => 'field_cb_partenaire_6', 'name' => 'partenaire_6', 'label' => 'Partenaire 6', 'type' => 'group', 'sub_fields' => $partenaire_group_fields( 'partenaire_6' ) ),
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
	$intro_ligne_fields = function ( $prefix ) {
		return array(
			array( 'key' => "field_cb_{$prefix}_texte", 'name' => 'texte', 'label' => 'Texte (noir)', 'type' => 'text' ),
			array( 'key' => "field_cb_{$prefix}_texte_bleu", 'name' => 'texte_bleu', 'label' => 'Texte (bleu, suite de la phrase)', 'type' => 'text' ),
		);
	};

	acf_add_local_field_group( array(
		'key'    => 'group_cb_profil',
		'title'  => 'Contenu page Profil',
		'fields' => array(
			array( 'key' => 'field_cb_profil_ligne_1', 'name' => 'intro_ligne_1', 'label' => 'Ligne d’introduction 1', 'type' => 'group', 'sub_fields' => $intro_ligne_fields( 'profil_ligne_1' ) ),
			array( 'key' => 'field_cb_profil_ligne_2', 'name' => 'intro_ligne_2', 'label' => 'Ligne d’introduction 2', 'type' => 'group', 'sub_fields' => $intro_ligne_fields( 'profil_ligne_2' ) ),
			array( 'key' => 'field_cb_profil_ligne_3', 'name' => 'intro_ligne_3', 'label' => 'Ligne d’introduction 3', 'type' => 'group', 'sub_fields' => $intro_ligne_fields( 'profil_ligne_3' ) ),
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
			array( 'key' => 'field_cb_metier_hero_image', 'name' => 'hero_image', 'label' => 'Image du bandeau d’en-tête', 'type' => 'image', 'return_format' => 'id' ),
			array( 'key' => 'field_cb_metier_image', 'name' => 'card_image', 'label' => 'Image de la carte accueil (« Nos métiers »)', 'type' => 'image', 'return_format' => 'id' ),
			array( 'key' => 'field_cb_metier_teaser', 'name' => 'card_teaser', 'label' => 'Accroche courte (carte accueil)', 'type' => 'textarea', 'rows' => 2 ),

			array( 'key' => 'field_cb_metier_intro', 'name' => 'intro_heading', 'label' => 'Titre du 1er bloc', 'type' => 'text' ),
			array( 'key' => 'field_cb_metier_intro_texte', 'name' => 'intro_texte', 'label' => 'Texte du 1er bloc', 'type' => 'wysiwyg', 'media_upload' => 0 ),
			array( 'key' => 'field_cb_metier_intro_image', 'name' => 'intro_image', 'label' => 'Image du 1er bloc (pleine largeur, sous le texte)', 'type' => 'image', 'return_format' => 'id' ),

			array( 'key' => 'field_cb_metier_champs_heading', 'name' => 'champs_heading', 'label' => 'Titre du 2e bloc', 'type' => 'text', 'default_value' => 'Champs d’intervention' ),
			array( 'key' => 'field_cb_metier_champs_texte', 'name' => 'champs_texte', 'label' => 'Texte du 2e bloc', 'type' => 'wysiwyg', 'media_upload' => 0 ),
			array( 'key' => 'field_cb_metier_champs_image', 'name' => 'champs_image', 'label' => 'Image du 2e bloc (à côté du texte)', 'type' => 'image', 'return_format' => 'id' ),
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
				'key'     => 'field_cb_real_galerie_note',
				'name'    => 'galerie_note',
				'label'   => 'Galerie photos',
				'type'    => 'message',
				'message' => 'Ajoutez un bloc « Galerie » dans le contenu de la fiche (ci-dessus) pour gérer les photos affichées dans la visionneuse. Vous pouvez ajouter une légende à chaque photo directement dans ce bloc.',
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
