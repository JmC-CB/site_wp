<?php
/**
 * Template Name: Page Profil
 */
get_header();

while ( have_posts() ) : the_post();

	$intro_lignes  = get_field( 'intro_lignes' );
	$vision_titre  = get_field( 'vision_titre' ) ?: 'Notre vision';
	$vision_image  = get_field( 'vision_image' );
	$vision_texte  = get_field( 'vision_texte' );
	$mission_titre = get_field( 'mission_titre' ) ?: 'Notre mission';
	$mission_image = get_field( 'mission_image' );
	$mission_texte = get_field( 'mission_texte' );

	$hero_url = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'cb-hero' ) : '';
?>

<header class="cb-profil-hero" <?php if ( $hero_url ) : ?>style="background-image:url('<?php echo esc_url( $hero_url ); ?>');"<?php endif; ?>>
	<div class="cb-container">
		<h1 class="cb-profil-hero__title"><?php the_title(); ?></h1>
	</div>
</header>

<?php if ( $intro_lignes ) : ?>
<section class="cb-profil-intro">
	<div class="cb-container">
		<?php foreach ( $intro_lignes as $ligne ) : ?>
		<div class="cb-profil-intro__row">
			<div class="cb-profil-intro__txt"><?php echo esc_html( $ligne['texte'] ); ?></div>
			<div class="cb-profil-intro__txt cb-profil-intro__txt--blue"><?php echo esc_html( $ligne['texte_bleu'] ); ?></div>
		</div>
		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>

<section class="cb-profil-vm">
	<div class="cb-container">
		<div class="cb-profil-vm__grid">

			<div class="cb-profil-vm__card">
				<?php if ( $vision_image ) : ?>
				<?php echo wp_get_attachment_image( $vision_image, 'cb-card', false, array( 'class' => 'cb-profil-vm__img' ) ); ?>
				<?php endif; ?>
				<div class="cb-profil-vm__overlay">
					<h2 class="cb-profil-vm__title"><?php echo esc_html( $vision_titre ); ?></h2>
					<div class="cb-profil-vm__text">
						<h2 class="cb-profil-vm__title cb-profil-vm__title--inline"><?php echo esc_html( $vision_titre ); ?></h2>
						<?php echo apply_filters( 'the_content', $vision_texte ); ?>
					</div>
				</div>
			</div>

			<div class="cb-profil-vm__card">
				<?php if ( $mission_image ) : ?>
				<?php echo wp_get_attachment_image( $mission_image, 'cb-card', false, array( 'class' => 'cb-profil-vm__img' ) ); ?>
				<?php endif; ?>
				<div class="cb-profil-vm__overlay">
					<h2 class="cb-profil-vm__title"><?php echo esc_html( $mission_titre ); ?></h2>
					<div class="cb-profil-vm__text">
						<h2 class="cb-profil-vm__title cb-profil-vm__title--inline"><?php echo esc_html( $mission_titre ); ?></h2>
						<?php echo apply_filters( 'the_content', $mission_texte ); ?>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<?php cb_render_footer_cta(); ?>

<?php endwhile; ?>

<?php get_footer(); ?>
