<?php
/**
 * Template générique de page (Profil, Mentions légales, index Métiers, etc.)
 */
get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<?php cb_page_title_band(); ?>

<article class="cb-section cb-page-content">
	<div class="cb-container cb-container--narrow">
		<?php the_content(); ?>

		<?php $children = get_pages( array( 'child_of' => get_the_ID(), 'sort_column' => 'menu_order', 'parent' => get_the_ID() ) ); ?>
		<?php if ( ! empty( $children ) ) : ?>
		<div class="cb-metiers__grid cb-page-content__children">
			<?php
			foreach ( $children as $child ) :
				$card_image = get_field( 'card_image', $child->ID );
				$teaser     = get_field( 'card_teaser', $child->ID );
			?>
			<a class="cb-metier-card" href="<?php echo esc_url( get_permalink( $child ) ); ?>">
				<?php if ( $card_image ) : ?>
				<?php echo wp_get_attachment_image( $card_image, 'cb-card', false, array( 'class' => 'cb-metier-card__img' ) ); ?>
				<?php endif; ?>
				<div class="cb-metier-card__overlay">
					<h3><?php echo esc_html( get_the_title( $child ) ); ?></h3>
					<?php if ( $teaser ) : ?><p><?php echo esc_html( $teaser ); ?></p><?php endif; ?>
					<span class="cb-btn-plus"><?php echo cb_icon( 'circle-arrow' ); ?> <span class="cb-btn-plus__label"><?php cb_l10n_e( 'En savoir plus', 'Learn more' ); ?></span></span>
				</div>
			</a>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
</article>

<?php endwhile; ?>

<?php get_footer(); ?>
