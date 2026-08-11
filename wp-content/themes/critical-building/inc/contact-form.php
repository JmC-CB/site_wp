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
define( 'CB_CONTACT_FORM_MARKUP_VERSION_EN', '1' );
define( 'CB_CONTACT_FORM_PAGE_MARKUP_VERSION_EN', '1' );

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
 * Variantes anglaises des deux formulaires ci-dessus (mêmes noms de champs,
 * pour que les réglages mail — [nom-prenom], [email], etc. — restent valables).
 */
function cb_contact_form_markup_en() {
	return '<div class="cb-form-grid">
<div class="cb-form-cell">[text* nom-prenom placeholder "Full name"]</div>
<div class="cb-form-cell">[text entreprise placeholder "Company"]</div>
<div class="cb-form-cell">[tel telephone placeholder "Phone"]</div>
<div class="cb-form-cell">[email* email placeholder "Email"]</div>
<div class="cb-form-cell cb-form-cell--full">[textarea message placeholder "Message"]</div>
</div>
<div class="cb-form-submit">[submit "Send"]</div>';
}

function cb_contact_form_page_markup_en() {
	return '<label for="cb-np">Full name</label>
[text* nom-prenom id:cb-np placeholder "Full name"]
<label for="cb-ent">Company</label>
[text entreprise id:cb-ent placeholder "Company name"]
<label for="cb-tel">Phone</label>
[tel telephone id:cb-tel placeholder "Phone"]
<label for="cb-mail">Email</label>
[email* email id:cb-mail placeholder "Email"]
<label for="cb-msg">Message</label>
[textarea message id:cb-msg placeholder "Write your message here"]
[submit "Send"]';
}

/**
 * Crée (ou resynchronise le markup d')un formulaire CF7.
 *
 * @param string $lang 'fr' (défaut) ou 'en' — choisit les textes de mail/messages.
 */
function cb_create_or_sync_form( $title, $option_id, $option_version, $version, $markup_callback, $lang = 'fr' ) {
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

	if ( 'en' === $lang ) {
		$properties['mail']['subject']    = 'New message from criticalbuilding.fr: [nom-prenom]';
		$properties['mail']['sender']     = 'Critical Building website <wordpress@criticalbuilding.fr>';
		$properties['mail']['recipient']  = $mail_recipient;
		$properties['mail']['additional_headers'] = 'Reply-To: [email]';
		$properties['mail']['body']       = "Full name: [nom-prenom]\nCompany: [entreprise]\nPhone: [telephone]\nEmail: [email]\n\nMessage:\n[message]";

		$properties['messages']['mail_sent_ok']     = 'Thank you! Your message has been sent.';
		$properties['messages']['mail_sent_ng']     = 'An error occurred while sending. Please try again.';
		$properties['messages']['validation_error'] = 'Please check the highlighted fields below.';
	} else {
		$properties['mail']['subject']    = 'Nouveau message depuis criticalbuilding.fr : [nom-prenom]';
		$properties['mail']['sender']     = 'Site Critical Building <wordpress@criticalbuilding.fr>';
		$properties['mail']['recipient']  = $mail_recipient;
		$properties['mail']['additional_headers'] = 'Reply-To: [email]';
		$properties['mail']['body']       = "Nom Prénom : [nom-prenom]\nEntreprise : [entreprise]\nTéléphone : [telephone]\nEmail : [email]\n\nMessage :\n[message]";

		$properties['messages']['mail_sent_ok']     = 'Merci ! Votre message a bien été envoyé.';
		$properties['messages']['mail_sent_ng']     = "Une erreur s'est produite lors de l'envoi. Merci de réessayer.";
		$properties['messages']['validation_error'] = 'Merci de vérifier les champs surlignés ci-dessous.';
	}

	foreach ( $properties as $key => $value ) {
		$contact_form->set_properties( array( $key => $value ) );
	}

	$contact_form->save();

	update_option( $option_id, $contact_form->id() );
	update_option( $option_version, $version );

	if ( function_exists( 'pll_set_post_language' ) ) {
		pll_set_post_language( $contact_form->id(), $lang );
	}
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

	cb_create_or_sync_form(
		'Contact form (EN)',
		'cb_contact_form_id_en',
		'cb_contact_form_markup_version_en',
		CB_CONTACT_FORM_MARKUP_VERSION_EN,
		'cb_contact_form_markup_en',
		'en'
	);

	cb_create_or_sync_form(
		'Contact form (Contact page, EN)',
		'cb_contact_form_page_id_en',
		'cb_contact_form_page_markup_version_en',
		CB_CONTACT_FORM_PAGE_MARKUP_VERSION_EN,
		'cb_contact_form_page_markup_en',
		'en'
	);
}
add_action( 'after_switch_theme', 'cb_create_contact_form' );
add_action( 'admin_init', 'cb_create_contact_form' );
