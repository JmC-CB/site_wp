<?php
/**
 * Template Name: Page réalisations
 */
get_header();

$realisations = new WP_Query( array(
	'post_type'      => 'realisation',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order date',
	'order'          => 'ASC',
) );
?>

<?php while ( have_posts() ) : the_post();
	$hero_url = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'cb-hero' ) : '';
?>

<header class="cb-real-hero" <?php if ( $hero_url ) : ?>style="background-image:url('<?php echo esc_url( $hero_url ); ?>');"<?php endif; ?>></header>

<div class="cb-rejoindre-title">
	<div class="cb-container">
		<h1 class="cb-rejoindre-title__text"><?php the_title(); ?></h1>
	</div>
</div>

<?php endwhile; ?>

<section class="cb-section cb-realisations">
	<div class="cb-container">
		<div class="cb-realisations__grid">
			<?php if ( $realisations->have_posts() ) : while ( $realisations->have_posts() ) : $realisations->the_post();
				$nom_client  = get_field( 'nom_client' );
				$profil      = get_field( 'profil_client' );
				$surface     = get_field( 'surface_it' );
				$application = get_field( 'application' );
				$livraison   = get_field( 'livraison' );
				$galerie     = cb_get_content_gallery_ids( get_the_ID() );
				if ( empty( $galerie ) && has_post_thumbnail() ) {
					$galerie = array( get_post_thumbnail_id() );
				}
			?>
			<div class="cb-real-card">
				<div class="cb-real-card__media">
					<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'cb-card', array( 'class' => 'cb-real-card__img' ) ); endif; ?>
					<div class="cb-real-card__overlay">
						<button type="button" class="cb-real-card__gallery-btn cb-btn-plus" data-gallery="real-<?php the_ID(); ?>">
							<?php echo cb_icon( 'circle-arrow' ); ?> <span class="cb-btn-plus__label"><?php cb_l10n_e( 'Voir les photos', 'View photos' ); ?></span>
						</button>
						<div class="cb-real-card__infos">
							<?php if ( $profil ) : ?><?php cb_l10n_e( 'Profil client', 'Client profile' ); ?> : <?php echo esc_html( $profil ); ?><br><?php endif; ?>
							<?php if ( $surface ) : ?><?php cb_l10n_e( 'Surface IT', 'IT floor area' ); ?> : <?php echo esc_html( $surface ); ?><br><?php endif; ?>
							<?php if ( $application ) : ?>Application : <?php echo esc_html( $application ); ?><br><?php endif; ?>
							<?php if ( $livraison ) : ?><?php cb_l10n_e( 'Livraison', 'Delivery' ); ?> : <?php echo esc_html( $livraison ); ?><?php endif; ?>
						</div>
					</div>
				</div>
				<h5 class="cb-real-card__title"><?php the_title(); ?></h5>
				<div class="cb-real-card__subtitle"><?php echo esc_html( $nom_client ); ?></div>
			</div>

			<?php if ( $galerie ) : ?>
			<!-- Rendue en dehors de .cb-real-card (qui a overflow:hidden) pour que la modale plein écran ne soit pas rognée -->
			<div class="cb-lightbox" id="real-<?php the_ID(); ?>" hidden>
				<?php foreach ( $galerie as $img_id ) :
					$caption = wp_get_attachment_caption( $img_id );
				?>
				<div class="cb-lightbox__slide">
					<img src="<?php echo esc_url( wp_get_attachment_image_url( $img_id, 'large' ) ); ?>" alt="">
					<?php if ( $caption ) : ?><p class="cb-lightbox__caption"><?php echo esc_html( $caption ); ?></p><?php endif; ?>
				</div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
			<?php endwhile; wp_reset_postdata(); else : ?>
			<p><?php cb_l10n_e( 'Aucune réalisation publiée pour le moment.', 'No projects published yet.' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php cb_render_footer_cta(); ?>

<?php get_footer(); ?>
