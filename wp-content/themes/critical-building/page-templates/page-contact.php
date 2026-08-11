<?php
/**
 * Template Name: Page contact
 */
get_header();

while ( have_posts() ) : the_post();
	$hero_url = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'cb-hero' ) : '';
	$lyon     = cb_option( 'lyon_adresse' );
?>

<header class="cb-contact-hero" <?php if ( $hero_url ) : ?>style="background-image:url('<?php echo esc_url( $hero_url ); ?>');"<?php endif; ?>></header>

<section class="cb-contact-formulaire">
	<div class="cb-container">
		<div class="cb-contact-grid">

			<div class="cb-contact-coords">
				<div class="cb-contact-coords__item">
					<div class="cb-contact-coords__label">Siège Paris</div>
					<div class="cb-contact-coords__value"><?php echo nl2br( esc_html( cb_option( 'siege_adresse', "3Bis rue du Docteur Soubise\n92260 Fontenay-aux-Roses" ) ) ); ?></div>
				</div>
				<?php if ( $lyon ) : ?>
				<div class="cb-contact-coords__item">
					<div class="cb-contact-coords__label">Agence Lyon</div>
					<div class="cb-contact-coords__value"><?php echo nl2br( esc_html( $lyon ) ); ?></div>
				</div>
				<?php endif; ?>
				<div class="cb-contact-coords__item">
					<div class="cb-contact-coords__label">Téléphone</div>
					<div class="cb-contact-coords__value"><a href="<?php echo esc_url( cb_tel_href( cb_option( 'telephone', '+33 1 78 16 54 16' ) ) ); ?>"><?php echo esc_html( cb_option( 'telephone', '+33 1 78 16 54 16' ) ); ?></a></div>
				</div>
				<div class="cb-contact-coords__item">
					<div class="cb-contact-coords__label">Email</div>
					<div class="cb-contact-coords__value"><a href="mailto:<?php echo esc_attr( cb_option( 'email', 'info@criticalbuilding.fr' ) ); ?>"><?php echo esc_html( cb_option( 'email', 'info@criticalbuilding.fr' ) ); ?></a></div>
				</div>

				<?php $linkedin = cb_option( 'linkedin_url' ); ?>
				<?php if ( $linkedin ) : ?>
				<a class="cb-contact-coords__social" href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener"><?php echo cb_icon( 'linkedin' ); ?></a>
				<?php endif; ?>
			</div>

			<div class="cb-contact-form-panel">
				<?php cb_render_contact_form_page(); ?>
			</div>

		</div>

		<?php if ( trim( get_the_content() ) ) : ?>
		<div class="cb-contact-statement"><?php the_content(); ?></div>
		<?php else : ?>
		<div class="cb-contact-statement">
			<p>Notre expertise vous intéresse ?<br>Nous serons heureux d’échanger et partager ensemble.</p>
			<p>Ingénieurs, Chefs de Projets, vous souhaitez rejoindre notre Équipe ?<br>Soyez les bienvenus !</p>
		</div>
		<?php endif; ?>
	</div>
</section>

<section class="cb-contact-map-section">
	<div class="cb-container">
		<?php cb_render_map( null, 'Carte des bureaux Critical Building' ); ?>
	</div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>
