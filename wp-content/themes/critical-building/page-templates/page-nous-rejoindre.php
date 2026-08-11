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

<?php while ( have_posts() ) : the_post(); ?>

<?php cb_page_title_band(); ?>

<article class="cb-section cb-page-content">
	<div class="cb-container cb-container--narrow">
		<?php the_content(); ?>
	</div>
</article>

<?php endwhile; ?>

<section class="cb-section cb-jobs cb-bg-white">
	<div class="cb-container">
		<div class="cb-jobs__grid">
			<?php if ( $offres->have_posts() ) : while ( $offres->have_posts() ) : $offres->the_post();
				$type_contrat = get_field( 'type_contrat' );
				$lieu         = get_field( 'lieu' );
				$experience   = get_field( 'experience' );
			?>
			<a class="cb-job-card" href="<?php the_permalink(); ?>">
				<?php if ( $type_contrat ) : ?><span class="cb-job-card__badge"><?php echo esc_html( $type_contrat ); ?></span><?php endif; ?>
				<h3 class="cb-job-card__title"><?php the_title(); ?></h3>
				<?php if ( $lieu ) : ?><p class="cb-job-card__meta"><?php echo cb_icon( 'pin' ); ?> <?php echo esc_html( $lieu ); ?></p><?php endif; ?>
				<?php if ( $experience ) : ?><p class="cb-job-card__meta"><?php echo cb_icon( 'briefcase' ); ?> <?php echo esc_html( $experience ); ?></p><?php endif; ?>
				<span class="cb-btn-plus"><?php echo cb_icon( 'circle-arrow' ); ?> <span class="cb-btn-plus__label">Voir l’offre</span></span>
			</a>
			<?php endwhile; wp_reset_postdata(); else : ?>
			<p><?php esc_html_e( 'Aucune offre publiée pour le moment.', 'critical-building' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php cb_render_footer_cta(); ?>

<?php get_footer(); ?>
