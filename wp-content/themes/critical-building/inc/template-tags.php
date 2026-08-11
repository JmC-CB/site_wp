<?php
/**
 * Fonctions utilitaires pour les templates.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Valeur d'un champ ACF des réglages globaux, avec repli si ACF/valeur absent.
 */
function cb_option( $field, $fallback = '' ) {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $field, 'option' );
		if ( ! empty( $value ) ) {
			return $value;
		}
	}
	return $fallback;
}

/**
 * Icônes SVG inline (currentColor) utilisées dans le thème.
 */
function cb_icon( $name ) {
	$icons = array(
		'phone' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
		'email' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/><path d="m22 6-10 7L2 6"/></svg>',
		'pin' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>',
		'arrow' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>',
		'circle-arrow' => '<svg viewBox="0 0 31 31" fill="none"><circle cx="15.5" cy="15.5" r="15" stroke="currentColor" stroke-width="1"/><path d="M8.5 15.5h13M17 11l4.5 4.5L17 20" stroke="currentColor" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'linkedin' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.03-1.85-3.03-1.85 0-2.14 1.45-2.14 2.94v5.66H9.34V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.38-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.07 2.07 0 1 1 0-4.13 2.07 2.07 0 0 1 0 4.13zM7.12 20.45H3.56V9h3.56v11.45z"/></svg>',
		'briefcase' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>',
		'close' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>',
		'file' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>',
	);
	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/**
 * Bandeau de titre pour les pages "simples" (Profil, Mentions légales, etc).
 */
function cb_page_title_band( $title = null ) {
	$title = $title ?: get_the_title();
	echo '<header class="cb-page-band"><div class="cb-container"><h1 class="cb-page-band__title">' . esc_html( $title ) . '</h1></div></header>';
}

/**
 * Formatte un numéro de téléphone français en lien tel: (retire espaces).
 */
function cb_tel_href( $phone ) {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', $phone );
}

/**
 * Récupère les IDs d'images du (premier) bloc Galerie natif WordPress présent
 * dans le contenu d'un post — remplace le champ ACF "gallery" (réservé à ACF PRO)
 * par le bloc Galerie natif de l'éditeur, administrable sans dépendance PRO.
 */
function cb_get_content_gallery_ids( $post_id ) {
	$post = get_post( $post_id );
	if ( ! $post || ! has_blocks( $post->post_content ) ) {
		return array();
	}

	$ids = array();
	$walk = function ( $blocks ) use ( &$walk, &$ids ) {
		foreach ( $blocks as $block ) {
			if ( 'core/gallery' === $block['blockName'] && ! empty( $block['innerBlocks'] ) ) {
				foreach ( $block['innerBlocks'] as $image_block ) {
					if ( 'core/image' === $image_block['blockName'] && ! empty( $image_block['attrs']['id'] ) ) {
						$ids[] = (int) $image_block['attrs']['id'];
					}
				}
			} elseif ( ! empty( $block['innerBlocks'] ) ) {
				$walk( $block['innerBlocks'] );
			}
		}
	};
	$walk( parse_blocks( $post->post_content ) );

	return $ids;
}

/**
 * Récupère les points de la carte configurés dans les réglages globaux
 * (Réglages du site > champs group marqueur_1..4), en ne gardant que ceux
 * dont le nom et les coordonnées sont renseignés.
 */
function cb_get_map_markers() {
	$markers = array();
	foreach ( array( 1, 2, 3, 4 ) as $n ) {
		$m = get_field( "marqueur_$n", 'option' );
		if ( empty( $m['nom'] ) || $m['latitude'] === '' || $m['longitude'] === '' ) {
			continue;
		}
		$markers[] = array(
			'lat'   => (float) $m['latitude'],
			'lng'   => (float) $m['longitude'],
			'popup' => trim( $m['nom'] . ( $m['adresse'] ? "\n" . $m['adresse'] : '' ) ),
		);
	}
	return $markers;
}

/**
 * Affiche une carte Leaflet. Une page peut en afficher plusieurs : chaque appel
 * génère un id unique, main.js (map.js) initialise indépendamment tous les
 * éléments .cb-map trouvés sur la page.
 *
 * @param array|null $markers Liste de ['lat'=>,'lng'=>,'popup'=>]. Par défaut,
 *                             les points définis dans les réglages du site.
 */
function cb_render_map( $markers = null, $label = 'Carte' ) {
	if ( null === $markers ) {
		$markers = cb_get_map_markers();
	}
	if ( empty( $markers ) ) {
		return;
	}
	static $i = 0;
	$i++;
	printf(
		'<div class="cb-map" id="cb-map-%d" data-markers=\'%s\' aria-label="%s"></div>',
		$i,
		esc_attr( wp_json_encode( array_values( $markers ) ) ),
		esc_attr( $label )
	);
}

/**
 * Affiche le formulaire Contact Form 7 du site (shortcode).
 */
function cb_render_contact_form() {
	$form_id = get_option( 'cb_contact_form_id' );
	if ( $form_id && function_exists( 'wpcf7_contact_form' ) && wpcf7_contact_form( $form_id ) ) {
		echo do_shortcode( '[contact-form-7 id="' . intval( $form_id ) . '" title="Formulaire de contact"]' );
	} else {
		echo do_shortcode( '[contact-form-7 title="Formulaire de contact"]' );
	}
}

/**
 * Affiche la variante du formulaire propre à la page Contact (labels visibles, inputs soulignés).
 */
function cb_render_contact_form_page() {
	$form_id = get_option( 'cb_contact_form_page_id' );
	if ( $form_id && function_exists( 'wpcf7_contact_form' ) && wpcf7_contact_form( $form_id ) ) {
		echo do_shortcode( '[contact-form-7 id="' . intval( $form_id ) . '" title="Formulaire de contact (page Contact)"]' );
	} else {
		echo do_shortcode( '[contact-form-7 title="Formulaire de contact (page Contact)"]' );
	}
}

/**
 * Section "Nous contacter" reprise en bas de la plupart des pages du site
 * (accueil, réalisations, nous rejoindre, pages métier) : titre + accroche + formulaire complet.
 */
function cb_render_footer_cta() {
	?>
	<section class="cb-section cb-cta" id="contact-form">
		<div class="cb-container">
			<h2 class="cb-heading-numbered"><span>Nous contacter</span></h2>
			<p class="cb-cta__intro">Envoyez-nous un message, notre équipe vous répondra au plus vite.</p>
			<?php cb_render_contact_form(); ?>
		</div>
	</section>
	<?php
}
