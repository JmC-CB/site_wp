<?php
/**
 * Template Name: Page contact
 */
get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
<?php cb_page_title_band(); ?>

<article class="cb-section cb-page-content">
	<div class="cb-container cb-container--narrow">
		<?php the_content(); ?>
	</div>
</article>
<?php endwhile; ?>

<section class="cb-section cb-contact">
	<div class="cb-container cb-contact__grid">

		<div class="cb-contact__form">
			<h2 class="cb-heading-numbered"><span>Nous contacter</span></h2>
			<?php cb_render_contact_form(); ?>
		</div>

		<div class="cb-contact__infos">
			<h3>Siège</h3>
			<p><?php echo cb_icon( 'pin' ); ?> <?php echo nl2br( esc_html( cb_option( 'siege_adresse', "3Bis rue du Docteur Soubise\n92260 Fontenay-aux-Roses" ) ) ); ?></p>
			<p><?php echo cb_icon( 'phone' ); ?> <a href="<?php echo esc_url( cb_tel_href( cb_option( 'telephone', '+33 1 78 16 54 16' ) ) ); ?>"><?php echo esc_html( cb_option( 'telephone', '+33 1 78 16 54 16' ) ); ?></a></p>
			<p><?php echo cb_icon( 'email' ); ?> <a href="mailto:<?php echo esc_attr( cb_option( 'email', 'info@criticalbuilding.fr' ) ); ?>"><?php echo esc_html( cb_option( 'email', 'info@criticalbuilding.fr' ) ); ?></a></p>

			<?php $lyon = cb_option( 'lyon_adresse' ); if ( $lyon ) : ?>
			<h3>Bureau de Lyon</h3>
			<p><?php echo cb_icon( 'pin' ); ?> <?php echo nl2br( esc_html( $lyon ) ); ?></p>
			<?php endif; ?>

			<div id="cb-map" class="cb-map" aria-label="Carte du siège de Critical Building"></div>
		</div>

	</div>
</section>

<?php get_footer(); ?>
