<?php
/**
 * Theme footer.
 *
 * @package DenkonMosaic
 */

?>
</main>
<?php if ( ! apply_filters( 'denkon_mosaic_has_custom_layout_part', false, 'footer' ) ) : ?>
	<?php
	$denkon_mosaic_settings    = denkon_mosaic_get_settings();
	$denkon_mosaic_copyright   = $denkon_mosaic_settings['footer_copyright'];
	$denkon_mosaic_footer_logo = absint( $denkon_mosaic_settings['footer_logo_id'] );

	if ( ! $denkon_mosaic_footer_logo ) {
		$denkon_mosaic_footer_logo = absint( get_theme_mod( 'custom_logo' ) );
	}

	if ( '' === $denkon_mosaic_copyright ) {
		$denkon_mosaic_copyright = sprintf( '© %s %s', gmdate( 'Y' ), get_bloginfo( 'name' ) );
	}
	?>
<footer class="site-footer">
	<div class="mosaic-container site-footer__inner">
		<div>
			<a class="site-footer__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php if ( $denkon_mosaic_footer_logo ) : ?>
					<?php echo wp_get_attachment_image( $denkon_mosaic_footer_logo, 'full', false, array( 'class' => 'site-footer__logo', 'alt' => get_bloginfo( 'name' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php else : ?>
					<?php bloginfo( 'name' ); ?>
				<?php endif; ?>
			</a>
			<?php if ( $denkon_mosaic_settings['footer_text'] ) : ?>
				<p><?php echo esc_html( $denkon_mosaic_settings['footer_text'] ); ?></p>
			<?php endif; ?>
		</div>
		<nav class="site-footer__nav" aria-label="<?php esc_attr_e( 'Навигация в подвале', 'denkon-mosaic' ); ?>">
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'fallback_cb' => false ) ); ?>
		</nav>
		<div class="site-footer__meta">
			<p class="site-footer__copyright"><?php echo esc_html( $denkon_mosaic_copyright ); ?></p>
			<a class="site-footer__development" href="https://denkon.ru" target="_blank" rel="noopener noreferrer">Denkon — development</a>
		</div>
	</div>
</footer>
<?php else : ?>
	<?php do_action( 'denkon_mosaic_render_layout_part', 'footer' ); ?>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
