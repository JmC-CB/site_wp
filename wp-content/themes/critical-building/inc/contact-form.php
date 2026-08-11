<?php
/**
 * Création automatique des formulaires Contact Form 7 (si absents) à l'activation du thème.
 * Le site source a deux présentations différentes du même formulaire :
 * - "Formulaire de contact" : version compacte (placeholders, sans labels visibles),
 *   utilisée dans les sections "Nous contacter" reprises en bas de la plupart des pages.
 * - "Formulaire de contact (page Contact)" : version avec labels visibles au-dessus de
 *   chaque champ et inputs soulignés, propre à la page /contact.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Version du markup de chaque formulaire (bump = resynchronise le champ « form »
 * même si le formulaire existe déjà, sans toucher aux réglages mail personnalisés).
 */
define( 'CB_CONTACT_FORM_MARKUP_VERSION', '2' );
define( 'CB_CONTACT_FORM_PAGE_MARKUP_VERSION', '2' );

function cb_contact_form_markup() {
	return '<div class="cb-form-grid">
<div class="cb-form-cell">[text* nom-prenom placeholder "Nom Prénom"]</div>
<div class="cb-form-cell">[text entreprise placeholder "Entreprise"]</div>
<div class="cb-form-cell">[tel telephone placeholder "Téléphone"]</div>
<div class="cb-form-cell">[email* email placeholder "Email"]</div>
<div class="cb-form-cell cb-form-cell--full">[textarea message placeholder "Message"]</div>
</div>
<div class="cb-form-submit">[submit "Envoyer"]</div>';
}

function cb_contact_form_page_markup() {
	return '<label for="cb-np">Nom Prénom</label>
[text* nom-prenom id:cb-np placeholder "Nom Prénom"]
<label for="cb-ent">Entreprise</label>
[text entreprise id:cb-ent placeholder "Nom de l’entreprise"]
<label for="cb-tel">Téléphone</label>
[tel telephone id:cb-tel placeholder "Téléphone"]
<label for="cb-mail">Email</label>
[email* email id:cb-mail placeholder "Email"]
<label for="cb-msg">Message</label>
[textarea message id:cb-msg placeholder "Écrivez ici votre message"]
[submit "Envoyer"]';
}

/**
 * Crée (ou resynchronise le markup d')un formulaire CF7.
 */
function cb_create_or_sync_form( $title, $option_id, $option_version, $version, $markup_callback ) {
	$existing_id = get_option( $option_id );

	if ( $existing_id && get_post( $existing_id ) ) {
		if ( get_option( $option_version ) !== $version ) {
			$existing_form = WPCF7_ContactForm::get_instance( $existing_id );
			if ( $existing_form ) {
				$existing_form->set_properties( array( 'form' => call_user_func( $markup_callback ) ) );
				$existing_form->save();
				update_option( $option_version, $version );
			}
		}
		return;
	}

	$found = get_page_by_title( $title, OBJECT, 'wpcf7_contact_form' );
	if ( $found ) {
		update_option( $option_id, $found->ID );
		update_option( $option_version, $version );
		return;
	}

	$contact_form = WPCF7_ContactForm::get_template( array( 'title' => $title ) );

	$mail_recipient = function_exists( 'get_field' ) ? get_field( 'email', 'option' ) : '';
	if ( empty( $mail_recipient ) ) {
		$mail_recipient = 'info@criticalbuilding.fr';
	}

	$properties = $contact_form->get_properties();

	$properties['form'] = call_user_func( $markup_callback );

	$properties['mail']['subject']    = 'Nouveau message depuis criticalbuilding.fr : [nom-prenom]';
	$properties['mail']['sender']     = 'Site Critical Building <wordpress@criticalbuilding.fr>';
	$properties['mail']['recipient']  = $mail_recipient;
	$properties['mail']['additional_headers'] = 'Reply-To: [email]';
	$properties['mail']['body']       = "Nom Prénom : [nom-prenom]\nEntreprise : [entreprise]\nTéléphone : [telephone]\nEmail : [email]\n\nMessage :\n[message]";

	$properties['messages']['mail_sent_ok']     = 'Merci ! Votre message a bien été envoyé.';
	$properties['messages']['mail_sent_ng']     = "Une erreur s'est produite lors de l'envoi. Merci de réessayer.";
	$properties['messages']['validation_error'] = 'Merci de vérifier les champs surlignés ci-dessous.';

	foreach ( $properties as $key => $value ) {
		$contact_form->set_properties( array( $key => $value ) );
	}

	$contact_form->save();

	update_option( $option_id, $contact_form->id() );
	update_option( $option_version, $version );
}

function cb_create_contact_form() {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return;
	}

	cb_create_or_sync_form(
		'Formulaire de contact',
		'cb_contact_form_id',
		'cb_contact_form_markup_version',
		CB_CONTACT_FORM_MARKUP_VERSION,
		'cb_contact_form_markup'
	);

	cb_create_or_sync_form(
		'Formulaire de contact (page Contact)',
		'cb_contact_form_page_id',
		'cb_contact_form_page_markup_version',
		CB_CONTACT_FORM_PAGE_MARKUP_VERSION,
		'cb_contact_form_page_markup'
	);
}
add_action( 'after_switch_theme', 'cb_create_contact_form' );
add_action( 'admin_init', 'cb_create_contact_form' );
