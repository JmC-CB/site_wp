<?php
/**
 * Page de réglages globaux (coordonnées, réseaux sociaux, points de carte).
 *
 * ACF gratuit n'a PAS la fonctionnalité "Options Page" (`acf_add_options_page()` /
 * `acf_get_options_pages()` sont réservées à ACF PRO — confirmé : ces fonctions
 * n'existent pas du tout dans cette installation). On reconstruit donc l'équivalent
 * à la main avec une page wp-admin standard qui affiche le groupe de champs
 * `group_cb_options` (déclaré dans acf-fields.php) via `acf_form()`, lequel EST
 * disponible en version gratuite. Les valeurs sont stockées comme avec une vraie
 * page d'options ACF (contexte 'option', table wp_options, clés `options_*`) —
 * get_field( $champ, 'option' ) / cb_option() continuent de fonctionner à l'identique.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_menu', 'cb_register_options_page' );

function cb_register_options_page() {
	if ( ! function_exists( 'acf_form' ) ) {
		return;
	}
	$hook = add_menu_page(
		__( 'Réglages Critical Building', 'critical-building' ),
		__( 'Réglages du site', 'critical-building' ),
		'manage_options',
		'cb-options',
		'cb_render_options_page',
		'dashicons-admin-generic',
		60
	);
	// acf_form_head() doit s'exécuter avant tout envoi de sortie (traitement du
	// formulaire + enregistrement des scripts/styles ACF) : le hook load-{page}
	// se déclenche assez tôt dans le cycle d'admin pour ça.
	add_action( "load-$hook", 'cb_options_page_head' );
}

function cb_options_page_head() {
	if ( function_exists( 'acf_form_head' ) ) {
		acf_form_head();
	}
}

function cb_render_options_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Réglages Critical Building', 'critical-building' ); ?></h1>
		<?php
		acf_form( array(
			'id'            => 'cb-options-form',
			'post_id'       => 'option',
			'field_groups'  => array( 'group_cb_options' ),
			'form'          => true,
			'html_submit_button' => '<input type="submit" value="%s" class="button button-primary" />',
			'submit_value'  => __( 'Mettre à jour', 'critical-building' ),
			'updated_message' => __( 'Réglages mis à jour.', 'critical-building' ),
		) );
		?>
	</div>
	<?php
}
