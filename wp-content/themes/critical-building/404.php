<?php
/**
 * Page 404
 */
get_header();
?>
<section class="cb-section cb-404">
	<div class="cb-container cb-container--narrow" style="text-align:center;">
		<h1 class="cb-page-band__title">Page introuvable</h1>
		<p>La page que vous recherchez n’existe pas ou a été déplacée.</p>
		<a class="cb-btn cb-btn--mt" href="<?php echo esc_url( home_url( '/' ) ); ?>">Retour à l’accueil</a>
	</div>
</section>
<?php get_footer(); ?>
