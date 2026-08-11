<?php
/**
 * Template Name: Page métier
 * Description: Utilisé pour les pages "Expertise et conseils" / "Études et suivi de réalisations"
 */
get_header();

while ( have_posts() ) : the_post();
	$hero_image     = get_field( 'hero_image' );
	$hero_url       = $hero_image ? wp_get_attachment_image_url( $hero_image, 'cb-hero' ) : '';

	$intro_heading  = get_field( 'intro_heading' );
	$intro_texte    = get_field( 'intro_texte' );
	$intro_image    = get_field( 'intro_image' );

	$champs_heading = get_field( 'champs_heading' ) ?: 'Champs d’intervention';
	$champs_texte   = get_field( 'champs_texte' );
	$champs_image   = get_field( 'champs_image' );
?>

<header class="cb-metier-hero" <?php if ( $hero_url ) : ?>style="background-image:url('<?php echo esc_url( $hero_url ); ?>');"<?php endif; ?>>
	<div class="cb-container">
		<h1 class="cb-metier-hero__title"><?php the_title(); ?></h1>
	</div>
</header>

<article class="cb-section cb-metier-body">
	<div class="cb-container">

		<?php if ( $intro_heading || $intro_texte ) : ?>
		<div class="cb-metier-block cb-metier-block--side">
			<div class="cb-metier-block__text">
				<?php if ( $intro_heading ) : ?><h2 class="cb-metier-block__heading"><?php echo esc_html( $intro_heading ); ?></h2><?php endif; ?>
				<?php echo apply_filters( 'the_content', $intro_texte ); ?>
			</div>
			<?php if ( $intro_image ) : ?>
			<div class="cb-metier-block__image">
				<?php echo wp_get_attachment_image( $intro_image, 'large', false, array( 'loading' => 'lazy' ) ); ?>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<?php if ( $champs_heading || $champs_texte ) : ?>
		<div class="cb-metier-block cb-metier-block--side">
			<?php if ( $champs_image ) : ?>
			<div class="cb-metier-block__image">
				<?php echo wp_get_attachment_image( $champs_image, 'large', false, array( 'loading' => 'lazy' ) ); ?>
			</div>
			<?php endif; ?>
			<div class="cb-metier-block__text">
				<?php if ( $champs_heading ) : ?><h2 class="cb-metier-block__heading"><?php echo esc_html( $champs_heading ); ?></h2><?php endif; ?>
				<?php echo apply_filters( 'the_content', $champs_texte ); ?>
			</div>
		</div>
		<?php endif; ?>

	</div>
</article>

<?php cb_render_footer_cta(); ?>

<?php endwhile; ?>

<?php get_footer(); ?>
