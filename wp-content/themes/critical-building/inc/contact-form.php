<?php
/**
 * Création automatique du formulaire Contact Form 7 "Formulaire de contact"
 * (si absent) à l'activation du thème, avec les champs relevés sur le site actuel :
 * Nom Prénom, Entreprise, Téléphone, Email, Message.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Version de la structure du formulaire (bump = re-synchronise le markup
 * même si le formulaire existe déjà, sans toucher aux réglages mail personnalisés).
 */
define( 'CB_CONTACT_FORM_MARKUP_VERSION', '2' );

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

function cb_create_contact_form() {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return;
	}

	$existing_id = get_option( 'cb_contact_form_id' );

	// Le formulaire existe déjà : on resynchronise juste le markup si sa version a changé.
	if ( $existing_id && get_post( $existing_id ) ) {
		if ( get_option( 'cb_contact_form_markup_version' ) !== CB_CONTACT_FORM_MARKUP_VERSION ) {
			$existing_form = WPCF7_ContactForm::get_instance( $existing_id );
			if ( $existing_form ) {
				$existing_form->set_properties( array( 'form' => cb_contact_form_markup() ) );
				$existing_form->save();
				update_option( 'cb_contact_form_markup_version', CB_CONTACT_FORM_MARKUP_VERSION );
			}
		}
		return;
	}

	// Formulaire déjà présent (créé manuellement) ?
	$found = get_page_by_title( 'Formulaire de contact', OBJECT, 'wpcf7_contact_form' );
	if ( $found ) {
		update_option( 'cb_contact_form_id', $found->ID );
		return;
	}

	$contact_form = WPCF7_ContactForm::get_template( array( 'title' => 'Formulaire de contact' ) );

	$mail_recipient = function_exists( 'get_field' ) ? get_field( 'email', 'option' ) : '';
	if ( empty( $mail_recipient ) ) {
		$mail_recipient = 'info@criticalbuilding.fr';
	}

	$properties = $contact_form->get_properties();

	$properties['form'] = cb_contact_form_markup();

	$properties['mail']['subject']    = 'Nouveau message depuis criticalbuilding.fr : [nom-prenom]';
	$properties['mail']['sender']     = 'Site Critical Building <wordpress@criticalbuilding.fr>';
	$properties['mail']['recipient']  = $mail_recipient;
	$properties['mail']['additional_headers'] = 'Reply-To: [email]';
	$properties['mail']['body']       = "Nom Prénom : [nom-prenom]\nEntreprise : [entreprise]\nTéléphone : [telephone]\nEmail : [email]\n\nMessage :\n[message]";

	$properties['messages']['mail_sent_ok']    = 'Merci ! Votre message a bien été envoyé.';
	$properties['messages']['mail_sent_ng']    = "Une erreur s'est produite lors de l'envoi. Merci de réessayer.";
	$properties['messages']['validation_error'] = 'Merci de vérifier les champs surlignés ci-dessous.';

	foreach ( $properties as $key => $value ) {
		$contact_form->set_properties( array( $key => $value ) );
	}

	$contact_form->save();

	update_option( 'cb_contact_form_id', $contact_form->id() );
	update_option( 'cb_contact_form_markup_version', CB_CONTACT_FORM_MARKUP_VERSION );
}
add_action( 'after_switch_theme', 'cb_create_contact_form' );
add_action( 'admin_init', 'cb_create_contact_form' );
