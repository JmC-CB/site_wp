<?php
/**
 * Template Name: Page métier
 * Description: Utilisé pour les pages "Expertise et conseils" / "Études et suivi de réalisations"
 */
get_header();

while ( have_posts() ) : the_post();
	$card_image   = get_field( 'card_image' );
	$intro_heading = get_field( 'intro_heading' );
	$img_url = $card_image ? wp_get_attachment_image_url( $card_image, 'cb-hero' ) : '';
?>

<header class="cb-page-band cb-page-band--metier" <?php if ( $img_url ) : ?>style="background-image:url('<?php echo esc_url( $img_url ); ?>');"<?php endif; ?>>
	<div class="cb-container">
		<h1 class="cb-page-band__title"><?php the_title(); ?></h1>
	</div>
</header>

<article class="cb-section cb-page-content">
	<div class="cb-container cb-container--narrow">
		<?php if ( $intro_heading ) : ?>
		<h2 class="cb-heading-numbered"><span><?php echo esc_html( $intro_heading ); ?></span></h2>
		<?php endif; ?>
		<?php the_content(); ?>
	</div>
</article>

<?php cb_render_footer_cta(); ?>

<?php endwhile; ?>

<?php get_footer(); ?>
