<?php
/**
 * Fiche détaillée d'une offre d'emploi
 */
get_header();

while ( have_posts() ) : the_post();
	$type_contrat = get_field( 'type_contrat' );
	$lieu         = get_field( 'lieu' );
	$experience   = get_field( 'experience' );
	$nr_page      = get_page_by_path( 'nous-rejoindre' );
	$contact_page = get_page_by_path( 'contact' );
?>

<header class="cb-page-band">
	<div class="cb-container">
		<?php if ( $nr_page ) : ?>
		<a class="cb-back-link" href="<?php echo esc_url( get_permalink( $nr_page ) ); ?>">&larr; Toutes les offres</a>
		<?php endif; ?>
		<h1 class="cb-page-band__title"><?php the_title(); ?></h1>
	</div>
</header>

<article class="cb-section cb-page-content cb-job-single">
	<div class="cb-container cb-container--narrow">

		<dl class="cb-real-meta">
			<?php if ( $type_contrat ) : ?><div><dt>Contrat</dt><dd><?php echo esc_html( $type_contrat ); ?></dd></div><?php endif; ?>
			<?php if ( $lieu ) : ?><div><dt>Lieu</dt><dd><?php echo esc_html( $lieu ); ?></dd></div><?php endif; ?>
			<?php if ( $experience ) : ?><div><dt>Expérience</dt><dd><?php echo esc_html( $experience ); ?></dd></div><?php endif; ?>
		</dl>

		<?php the_content(); ?>

		<?php if ( $contact_page ) : ?>
		<a class="cb-btn cb-btn--mt" href="<?php echo esc_url( get_permalink( $contact_page ) ); ?>">Postuler / nous écrire</a>
		<?php endif; ?>
	</div>
</article>

<?php endwhile; ?>

<?php get_footer(); ?>
