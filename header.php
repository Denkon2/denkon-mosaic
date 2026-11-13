<?php
/**
 * Theme header.
 *
 * @package DenkonMosaic
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php if ( ! apply_filters( 'denkon_mosaic_has_custom_layout_part', false, 'header' ) ) : ?>
<?php $denkon_mosaic_settings = denkon_mosaic_get_settings(); ?>
<header class="site-header site-header--<?php echo esc_attr( $denkon_mosaic_settings['header_layout'] ); ?>">
	<div class="mosaic-container site-header__inner">
		<div class="site-header__brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			<?php endif; ?>
		</div>
		<button class="site-header__menu-toggle" type="button" aria-controls="site-navigation" aria-expanded="false">
			<span class="screen-reader-text"><?php esc_html_e( 'Открыть меню', 'denkon-mosaic' ); ?></span>
			<svg aria-hidden="true" viewBox="0 0 24 24" focusable="false"><path d="M3 6.75h18M3 12h18M3 17.25h18" /></svg>
		</button>
		<nav id="site-navigation" class="site-header__nav" aria-label="<?php esc_attr_e( 'Главная навигация', 'denkon-mosaic' ); ?>">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'fallback_cb' => 'wp_page_menu' ) ); ?>
		</nav>
		<?php if ( $denkon_mosaic_settings['header_cta_text'] ) : ?>
			<a class="mosaic-button mosaic-button--primary" href="<?php echo esc_url( $denkon_mosaic_settings['header_cta_url'] ); ?>"><?php echo esc_html( $denkon_mosaic_settings['header_cta_text'] ); ?></a>
		<?php endif; ?>
	</div>
</header>
<?php else : ?>
	<?php do_action( 'denkon_mosaic_render_layout_part', 'header' ); ?>
<?php endif; ?>
<main id="main" class="site-main">
