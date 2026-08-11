<?php
/**
 * Fiche détaillée d'une réalisation
 */
get_header();

while ( have_posts() ) : the_post();
	$nom_client  = get_field( 'nom_client' );
	$profil      = get_field( 'profil_client' );
	$surface     = get_field( 'surface_it' );
	$application = get_field( 'application' );
	$livraison   = get_field( 'livraison' );
	$realisations_page = get_page_by_path( 'realisations' );
?>

<header class="cb-page-band">
	<div class="cb-container">
		<?php if ( $realisations_page ) : ?>
		<a class="cb-back-link" href="<?php echo esc_url( get_permalink( $realisations_page ) ); ?>">&larr; Toutes les réalisations</a>
		<?php endif; ?>
		<h1 class="cb-page-band__title"><?php the_title(); ?></h1>
		<?php if ( $nom_client ) : ?><p class="cb-page-band__subtitle"><?php echo esc_html( $nom_client ); ?></p><?php endif; ?>
	</div>
</header>

<article class="cb-section cb-page-content cb-realisation-single">
	<div class="cb-container cb-container--narrow">

		<dl class="cb-real-meta">
			<?php if ( $profil ) : ?><div><dt>Profil client</dt><dd><?php echo esc_html( $profil ); ?></dd></div><?php endif; ?>
			<?php if ( $surface ) : ?><div><dt>Surface IT</dt><dd><?php echo esc_html( $surface ); ?></dd></div><?php endif; ?>
			<?php if ( $application ) : ?><div><dt>Application</dt><dd><?php echo esc_html( $application ); ?></dd></div><?php endif; ?>
			<?php if ( $livraison ) : ?><div><dt>Livraison</dt><dd><?php echo esc_html( $livraison ); ?></dd></div><?php endif; ?>
		</dl>

		<?php // La galerie photo est gérée via le bloc "Galerie" natif de l'éditeur, rendu ci-dessous avec le reste du contenu. ?>
		<?php the_content(); ?>

	</div>
</article>

<?php cb_render_footer_cta(); ?>

<?php endwhile; ?>

<?php get_footer(); ?>
