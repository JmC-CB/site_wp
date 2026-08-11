<?php
/**
 * Template Name: Page nous rejoindre
 */
get_header();

$offres = new WP_Query( array(
	'post_type'      => 'offre_emploi',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order date',
	'order'          => 'ASC',
) );

?>

<?php while ( have_posts() ) : the_post();
	$hero_url = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'cb-hero' ) : '';
?>

<header class="cb-rejoindre-hero" <?php if ( $hero_url ) : ?>style="background-image:url('<?php echo esc_url( $hero_url ); ?>');"<?php endif; ?>>
	<div class="cb-rejoindre-hero__tint"></div>
</header>

<div class="cb-rejoindre-title">
	<div class="cb-container">
		<h1 class="cb-rejoindre-title__text"><?php the_title(); ?></h1>
	</div>
</div>

<?php if ( trim( get_the_content() ) ) : ?>
<article class="cb-section cb-page-content" style="padding-top:0;">
	<div class="cb-container cb-container--narrow">
		<?php the_content(); ?>
	</div>
</article>
<?php endif; ?>

<?php endwhile; ?>

<section class="cb-section cb-jobs">
	<div class="cb-container">
		<div class="cb-jobs__grid">
			<?php if ( $offres->have_posts() ) : while ( $offres->have_posts() ) : $offres->the_post();
				$type_contrat = get_field( 'type_contrat' );
				$lieu         = get_field( 'lieu' );
				$experience   = get_field( 'experience' );
			?>
			<a class="cb-job-card" href="<?php the_permalink(); ?>">
				<div class="cb-job-card__media">
					<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'cb-card', array( 'class' => 'cb-job-card__img' ) ); endif; ?>
				</div>
				<div class="cb-job-card__body">
					<h3 class="cb-job-card__title"><?php the_title(); ?></h3>
					<div class="cb-job-card__infos">
						<?php if ( $type_contrat ) : ?><span class="cb-job-card__chip"><?php echo cb_icon( 'file' ); ?><?php echo esc_html( $type_contrat ); ?></span><?php endif; ?>
						<?php if ( $lieu ) : ?><span class="cb-job-card__chip"><?php echo cb_icon( 'pin' ); ?><?php echo esc_html( $lieu ); ?></span><?php endif; ?>
						<?php if ( $experience ) : ?><span class="cb-job-card__chip"><?php echo cb_icon( 'briefcase' ); ?><?php echo esc_html( $experience ); ?></span><?php endif; ?>
					</div>
				</div>
			</a>
			<?php endwhile; wp_reset_postdata(); else : ?>
			<p><?php esc_html_e( 'Aucune offre publiée pour le moment.', 'critical-building' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php cb_render_footer_cta(); ?>

<?php get_footer(); ?>
