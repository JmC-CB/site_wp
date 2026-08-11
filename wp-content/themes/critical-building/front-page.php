<?php
/**
 * Template de la page d'accueil : slider hero + qui sommes-nous + nos métiers + nos clients + partenaires
 */
get_header();

// ACF gratuit n'a pas de champ Repeater : les segments clients et logos
// partenaires sont stockés en champs "group" fixes (client_1..3, partenaire_1..6)
// et recomposés ici en tableaux pour garder les mêmes boucles d'affichage.
// Le slider hero utilise le bloc "Galerie" natif de l'éditeur (comme pour les
// galeries de réalisations) : nombre de photos libre, réordonnable au glisser-déposer.
$slides = array_map( function ( $id ) {
	return array( 'image' => $id );
}, cb_get_content_gallery_ids( get_the_ID() ) );

$hero_titre      = get_field( 'hero_titre' );
$qsn_heading     = get_field( 'qsn_heading' ) ?: 'qui sommes-nous ?';
$qsn_texte       = get_field( 'qsn_texte' );
$metiers_heading = get_field( 'metiers_heading' ) ?: 'nos métiers';
$clients_heading = get_field( 'clients_heading' ) ?: 'Nos clients';
$clients_blocks  = array_values( array_filter( array_map( function ( $n ) {
	return get_field( "client_$n" );
}, array( 1, 2, 3 ) ) ) );
$clients_citation = get_field( 'clients_citation' );
$partenaires     = array_values( array_filter( array_map( function ( $n ) {
	return get_field( "partenaire_$n" );
}, array( 1, 2, 3, 4, 5, 6 ) ) ) );
$profil_page     = get_page_by_path( 'profil' );
$realisations_page = get_page_by_path( 'realisations' );

// Les 2 pages métier (template page-metier.php), triées par menu_order
$metier_pages = get_posts( array(
	'post_type'      => 'page',
	'posts_per_page' => 2,
	'meta_key'       => '_wp_page_template',
	'meta_value'     => 'page-templates/page-metier.php',
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
) );
?>

<section class="cb-hero" id="cb-hero">
	<div class="cb-hero__slides">
		<?php if ( $slides ) : foreach ( $slides as $i => $slide ) :
			$img_url = wp_get_attachment_image_url( $slide['image'], 'cb-hero' );
		?>
		<div class="cb-hero__slide<?php echo 0 === $i ? ' is-active' : ''; ?>" style="background-image:url('<?php echo esc_url( $img_url ); ?>');"></div>
		<?php endforeach; endif; ?>
	</div>
	<div class="cb-hero__overlay"></div>
	<div class="cb-hero__content">
		<h1 class="cb-hero__title"><?php echo $hero_titre ? nl2br( esc_html( $hero_titre ) ) : ( ( function_exists( 'pll_current_language' ) && 'en' === pll_current_language() ) ? 'Unique expertise<br>dedicated to<br>sensitive technical<br>infrastructure' : 'Une expertise<br>unique dédiée aux<br>infrastructures<br>techniques sensibles' ); ?></h1>
	</div>
	<?php if ( $slides && count( $slides ) > 1 ) : ?>
	<div class="cb-hero__nav">
		<button class="cb-hero__arrow cb-hero__arrow--prev" aria-label="<?php echo esc_attr( cb_l10n( 'Photo précédente', 'Previous photo' ) ); ?>"><?php echo cb_icon( 'arrow' ); ?></button>
		<button class="cb-hero__arrow cb-hero__arrow--next" aria-label="<?php echo esc_attr( cb_l10n( 'Photo suivante', 'Next photo' ) ); ?>"><?php echo cb_icon( 'arrow' ); ?></button>
	</div>
	<div class="cb-hero__dots">
		<?php foreach ( $slides as $i => $slide ) : ?>
		<button class="cb-hero__dot<?php echo 0 === $i ? ' is-active' : ''; ?>" data-slide="<?php echo esc_attr( $i ); ?>" aria-label="<?php echo esc_attr( cb_l10n( 'Aller à la photo ', 'Go to photo ' ) . ( $i + 1 ) ); ?>"></button>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</section>

<section class="cb-section cb-qsn">
	<div class="cb-container cb-qsn__grid">
		<div class="cb-section-head cb-qsn__head">
			<div class="cb-section-head__number">01</div>
			<h2 class="cb-section-head__title"><?php echo esc_html( $qsn_heading ); ?></h2>
		</div>
		<div class="cb-qsn__body">
			<?php echo apply_filters( 'the_content', $qsn_texte ); ?>
			<?php if ( $profil_page ) : ?>
			<a class="cb-btn cb-btn--mt" href="<?php echo esc_url( get_permalink( $profil_page ) ); ?>"><?php cb_l10n_e( 'En savoir plus', 'Learn more' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="cb-section cb-metiers cb-bg-white">
	<div class="cb-container">
		<div class="cb-section-head cb-section-head--muted">
			<div class="cb-section-head__number">02</div>
			<h2 class="cb-section-head__title"><?php echo esc_html( $metiers_heading ); ?></h2>
		</div>
		<div class="cb-metiers__grid">
			<?php foreach ( $metier_pages as $mp ) :
				$card_image = get_field( 'card_image', $mp->ID );
				$teaser     = get_field( 'card_teaser', $mp->ID );
			?>
			<a class="cb-metier-card" href="<?php echo esc_url( get_permalink( $mp ) ); ?>">
				<?php if ( $card_image ) : ?>
				<?php echo wp_get_attachment_image( $card_image, 'cb-card', false, array( 'class' => 'cb-metier-card__img' ) ); ?>
				<?php endif; ?>
				<div class="cb-metier-card__overlay">
					<h3><?php echo esc_html( get_the_title( $mp ) ); ?></h3>
					<p><?php echo esc_html( $teaser ); ?></p>
					<span class="cb-btn-plus"><?php echo cb_icon( 'circle-arrow' ); ?> <span class="cb-btn-plus__label"><?php cb_l10n_e( 'En savoir plus', 'Learn more' ); ?></span></span>
				</div>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="cb-section cb-clients cb-bg-dark">
	<div class="cb-container">
		<div class="cb-section-head cb-section-head--dark">
			<div class="cb-section-head__number">03</div>
			<h2 class="cb-section-head__title"><?php echo esc_html( $clients_heading ); ?></h2>
		</div>
		<div class="cb-clients__grid">
			<?php if ( $clients_blocks ) : foreach ( $clients_blocks as $block ) : ?>
			<a class="cb-client-card" href="<?php echo esc_url( $realisations_page ? get_permalink( $realisations_page ) : home_url( '/realisations/' ) ); ?>">
				<?php echo wp_get_attachment_image( $block['image'], 'cb-card', false, array( 'class' => 'cb-client-card__img' ) ); ?>
				<div class="cb-client-card__body">
					<h3><?php echo esc_html( $block['titre'] ); ?></h3>
					<p><?php echo esc_html( $block['texte'] ); ?></p>
					<span class="cb-btn-plus"><?php echo cb_icon( 'circle-arrow' ); ?> <span class="cb-btn-plus__label"><?php cb_l10n_e( 'En savoir plus', 'Learn more' ); ?></span></span>
				</div>
			</a>
			<?php endforeach; endif; ?>
		</div>

		<?php if ( $clients_citation ) : ?>
		<blockquote class="cb-quote"><?php echo esc_html( $clients_citation ); ?></blockquote>
		<?php endif; ?>

		<div class="cb-clients__cta">
			<a class="cb-btn cb-btn--inverse" href="<?php echo esc_url( $realisations_page ? get_permalink( $realisations_page ) : home_url( '/realisations/' ) ); ?>"><?php cb_l10n_e( 'Nos réalisations', 'Our projects' ); ?></a>
		</div>
	</div>
</section>

<?php if ( $partenaires ) : ?>
<section class="cb-section cb-partenaires">
	<div class="cb-container cb-partenaires__grid">
		<?php foreach ( $partenaires as $p ) :
			$logo = $p['logo'];
			$lien = $p['lien'];
		?>
		<div class="cb-partenaires__item">
			<?php if ( $lien ) : ?><a href="<?php echo esc_url( $lien ); ?>" target="_blank" rel="noopener"><?php endif; ?>
				<?php echo wp_get_attachment_image( $logo, 'medium', false, array( 'class' => 'cb-partenaires__logo' ) ); ?>
			<?php if ( $lien ) : ?></a><?php endif; ?>
		</div>
		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>

<?php cb_render_footer_cta(); ?>

<?php get_footer(); ?>
