<?php
/**
 * Pied de page du site
 */
?>
</main><!-- .cb-main -->

<footer class="cb-footer">
	<div class="cb-container cb-footer__grid">

		<div class="cb-footer__col">
			<h2 class="footer-heading">critical building</h2>
			<ul class="cb-footer__infos">
				<li>
					<?php echo cb_icon( 'phone' ); ?>
					<span class="cb-footer__phone"><?php echo esc_html( cb_option( 'telephone', '+33 1 78 16 54 16' ) ); ?></span>
				</li>
				<li>
					<?php echo cb_icon( 'email' ); ?>
					<a href="mailto:<?php echo esc_attr( cb_option( 'email', 'info@criticalbuilding.fr' ) ); ?>"><?php echo esc_html( cb_option( 'email', 'info@criticalbuilding.fr' ) ); ?></a>
				</li>
				<li>
					<?php echo cb_icon( 'pin' ); ?>
					<a href="https://www.google.com/maps/search/?api=1&query=<?php echo rawurlencode( cb_option( 'siege_adresse', '3Bis rue du Docteur Soubise, 92260 Fontenay-aux-Roses' ) ); ?>" target="_blank" rel="noopener"><?php echo nl2br( esc_html( cb_option( 'siege_adresse', "3Bis rue du Docteur Soubise\n92260 Fontenay-aux-Roses" ) ) ); ?></a>
				</li>
				<?php $linkedin = cb_option( 'linkedin_url' ); ?>
				<?php if ( $linkedin ) : ?>
				<li>
					<a class="cb-footer__linkedin" href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener">
						<?php echo cb_icon( 'linkedin' ); ?> <span>Suivez nous</span>
					</a>
				</li>
				<?php endif; ?>
			</ul>
		</div>

		<div class="cb-footer__col">
			<h2 class="footer-heading">plan du site</h2>
			<nav aria-label="Plan du site">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'cb-footer__list',
					'fallback_cb'    => false,
				) );
				?>
			</nav>
		</div>

	</div>

	<div class="cb-footer__bottom">
		<div class="cb-container cb-footer__bottom-inner">
			<span><?php echo esc_html( cb_option( 'copyright_text', '© ' . date( 'Y' ) . ' Critical Building. Tous droits réservés.' ) ); ?></span>
			<a href="<?php echo esc_url( home_url( '/mentions-legales/' ) ); ?>">Mentions légales</a>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
