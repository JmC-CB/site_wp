<?php
/**
 * Template de secours générique (obligatoire pour un thème WordPress valide)
 */
get_header();
?>
<section class="cb-section cb-page-content">
	<div class="cb-container cb-container--narrow">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		<?php endwhile; else : ?>
			<p><?php esc_html_e( 'Aucun contenu trouvé.', 'critical-building' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
