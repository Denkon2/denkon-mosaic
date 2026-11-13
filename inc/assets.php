<?php
/**
 * Front-end and editor asset registration.
 *
 * @package DenkonMosaic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Loads the compiled public assets.
 *
 * LESS sources live in assets/less and are compiled by the theme workflow.
 *
 * @return void
 */
function denkon_mosaic_enqueue_assets() {
	$theme      = wp_get_theme( get_template() );
	$uri        = get_template_directory_uri();
	$parent_dir = get_template_directory();

	wp_enqueue_style( 'denkon-mosaic-style', $uri . '/style.css', array(), denkon_mosaic_get_asset_version( $parent_dir . '/style.css', $theme->get( 'Version' ) ) );
	wp_enqueue_style( 'denkon-mosaic-main', $uri . '/assets/css/main.css', array( 'denkon-mosaic-style' ), $theme->get( 'Version' ) );

	$settings      = denkon_mosaic_get_settings();
	$defaults      = denkon_mosaic_get_default_settings();
	$content_width = denkon_mosaic_sanitize_content_width( $settings['content_width'] );
	$header_background = denkon_mosaic_sanitize_color( $settings['header_background'], $defaults['header_background'] );
	$header_text       = denkon_mosaic_sanitize_color( $settings['header_text_color'], $defaults['header_text_color'] );
	$header_link       = denkon_mosaic_sanitize_color( $settings['header_link_color'], $defaults['header_link_color'] );
	$header_link_hover = denkon_mosaic_sanitize_color( $settings['header_link_hover_color'], $defaults['header_link_hover_color'] );
	$footer_background = denkon_mosaic_sanitize_color( $settings['footer_background'], $defaults['footer_background'] );
	$footer_text       = denkon_mosaic_sanitize_color( $settings['footer_text_color'], $defaults['footer_text_color'] );
	$footer_link       = denkon_mosaic_sanitize_color( $settings['footer_link_color'], $defaults['footer_link_color'] );
	$footer_link_hover = denkon_mosaic_sanitize_color( $settings['footer_link_hover_color'], $defaults['footer_link_hover_color'] );
	$heading_font      = denkon_mosaic_get_selected_font_family( $settings['heading_font_family'] );
	$body_font         = denkon_mosaic_get_selected_font_family( $settings['body_font_family'] );
	$font_css          = '';
	$custom_colors     = denkon_mosaic_get_custom_color_values( $settings );
	$custom_scheme_css = '';

	if ( '' !== $body_font ) {
		$font_css .= '--mosaic-font-sans:' . esc_html( $body_font ) . ';';
	}

	if ( '' !== $heading_font ) {
		$font_css .= '--mosaic-font-heading:' . esc_html( $heading_font ) . ';';
	}

	if ( 'custom' === $settings['color_scheme'] ) {
		$custom_scheme_css = 'body.denkon-mosaic--scheme-custom{'
			. '--mosaic-color-primary:' . esc_html( $custom_colors['custom_color_primary'] ) . ';'
			. '--mosaic-color-primary-hover:' . esc_html( $custom_colors['custom_color_primary_hover'] ) . ';'
			. '--mosaic-color-text:' . esc_html( $custom_colors['custom_color_text'] ) . ';'
			. '--mosaic-color-muted:' . esc_html( $custom_colors['custom_color_muted'] ) . ';'
			. '--mosaic-color-surface:' . esc_html( $custom_colors['custom_color_surface'] ) . ';'
			. '--mosaic-color-background:' . esc_html( $custom_colors['custom_color_background'] ) . ';'
			. '--mosaic-color-border:' . esc_html( $custom_colors['custom_color_border'] ) . ';'
			. '--wp--preset--color--primary:' . esc_html( $custom_colors['custom_color_primary'] ) . ';'
			. '--wp--preset--color--ink:' . esc_html( $custom_colors['custom_color_text'] ) . ';'
			. '--wp--preset--color--muted:' . esc_html( $custom_colors['custom_color_muted'] ) . ';'
			. '--wp--preset--color--surface:' . esc_html( $custom_colors['custom_color_surface'] ) . ';'
			. '--wp--preset--color--canvas:' . esc_html( $custom_colors['custom_color_background'] ) . ';'
			. '}';
	}
	wp_add_inline_style(
		'denkon-mosaic-main',
		':root{--wp--preset--color--surface:#ffffff;}'
		. ':where(h1,h2,h3,h4,h5,h6,.wp-block-heading){font-family:var(--mosaic-font-heading,var(--mosaic-font-sans));}'
		. 'body {'
		. '--mosaic-content-width:' . esc_html( $content_width ) . ';'
		. '--mosaic-header-background:' . esc_html( $header_background ) . ';'
		. '--mosaic-header-text:' . esc_html( $header_text ) . ';'
		. '--mosaic-header-link:' . esc_html( $header_link ) . ';'
		. '--mosaic-header-link-hover:' . esc_html( $header_link_hover ) . ';'
		. '--mosaic-footer-background:' . esc_html( $footer_background ) . ';'
		. '--mosaic-footer-text:' . esc_html( $footer_text ) . ';'
		. '--mosaic-footer-link:' . esc_html( $footer_link ) . ';'
		. '--mosaic-footer-link-hover:' . esc_html( $footer_link_hover ) . ';'
		. $font_css
		. '}'
		. $custom_scheme_css
	);

	if ( is_child_theme() ) {
		$child_dir = get_stylesheet_directory();
		$child_uri = get_stylesheet_directory_uri();
		$depends   = 'denkon-mosaic-main';

		if ( file_exists( $child_dir . '/assets/css/style.css' ) ) {
			wp_enqueue_style(
				'denkon-mosaic-child-assets',
				$child_uri . '/assets/css/style.css',
				array( $depends ),
				denkon_mosaic_get_asset_version( $child_dir . '/assets/css/style.css', $theme->get( 'Version' ) )
			);
			$depends = 'denkon-mosaic-child-assets';
		}

		if ( file_exists( $child_dir . '/style.css' ) ) {
			wp_enqueue_style(
				'denkon-mosaic-child-style',
				get_stylesheet_uri(),
				array( $depends ),
				denkon_mosaic_get_asset_version( $child_dir . '/style.css', $theme->get( 'Version' ) )
			);
		}
	}

	wp_enqueue_script( 'denkon-mosaic-main', $uri . '/assets/js/main.js', array(), $theme->get( 'Version' ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/**
	 * Fires after the Free theme assets have been enqueued on the front end.
	 */
	do_action( 'denkon_mosaic_after_enqueue_assets' );
}
add_action( 'wp_enqueue_scripts', 'denkon_mosaic_enqueue_assets' );

/**
 * Returns a cache-busting version for an asset when it exists.
 *
 * @param string $path     Absolute file path.
 * @param string $fallback Fallback theme version.
 * @return string
 */
function denkon_mosaic_get_asset_version( $path, $fallback ) {
	return file_exists( $path ) ? (string) filemtime( $path ) : $fallback;
}

/**
 * Loads the same design tokens in the block editor.
 *
 * @return void
 */
function denkon_mosaic_enqueue_editor_assets() {
	wp_enqueue_style(
		'denkon-mosaic-editor',
		get_template_directory_uri() . '/assets/css/main.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);

	$settings     = denkon_mosaic_get_settings();
	$heading_font = denkon_mosaic_get_selected_font_family( $settings['heading_font_family'] );
	$body_font    = denkon_mosaic_get_selected_font_family( $settings['body_font_family'] );
	$editor_css   = '';

	if ( '' !== $body_font ) {
		$editor_css .= '--mosaic-font-sans:' . esc_html( $body_font ) . ';';
	}

	if ( '' !== $heading_font ) {
		$editor_css .= '--mosaic-font-heading:' . esc_html( $heading_font ) . ';';
	}

	if ( 'custom' === $settings['color_scheme'] ) {
		$custom_colors = denkon_mosaic_get_custom_color_values( $settings );
		$editor_css .= '--mosaic-color-primary:' . esc_html( $custom_colors['custom_color_primary'] ) . ';'
			. '--mosaic-color-primary-hover:' . esc_html( $custom_colors['custom_color_primary_hover'] ) . ';'
			. '--mosaic-color-text:' . esc_html( $custom_colors['custom_color_text'] ) . ';'
			. '--mosaic-color-muted:' . esc_html( $custom_colors['custom_color_muted'] ) . ';'
			. '--mosaic-color-surface:' . esc_html( $custom_colors['custom_color_surface'] ) . ';'
			. '--mosaic-color-background:' . esc_html( $custom_colors['custom_color_background'] ) . ';'
			. '--mosaic-color-border:' . esc_html( $custom_colors['custom_color_border'] ) . ';'
			. '--wp--preset--color--primary:' . esc_html( $custom_colors['custom_color_primary'] ) . ';'
			. '--wp--preset--color--ink:' . esc_html( $custom_colors['custom_color_text'] ) . ';'
			. '--wp--preset--color--muted:' . esc_html( $custom_colors['custom_color_muted'] ) . ';'
			. '--wp--preset--color--surface:' . esc_html( $custom_colors['custom_color_surface'] ) . ';'
			. '--wp--preset--color--canvas:' . esc_html( $custom_colors['custom_color_background'] ) . ';';
	}

	wp_add_inline_style(
		'denkon-mosaic-editor',
		'.editor-styles-wrapper :where(h1,h2,h3,h4,h5,h6,.wp-block-heading){font-family:var(--mosaic-font-heading,var(--mosaic-font-sans));}'
		. ( '' !== $editor_css ? '.editor-styles-wrapper{' . $editor_css . '}' : '' )
	);

	if ( is_child_theme() && file_exists( get_stylesheet_directory() . '/assets/css/style.css' ) ) {
		wp_enqueue_style(
			'denkon-mosaic-child-editor',
			get_stylesheet_directory_uri() . '/assets/css/style.css',
			array( 'denkon-mosaic-editor' ),
			denkon_mosaic_get_asset_version( get_stylesheet_directory() . '/assets/css/style.css', wp_get_theme()->get( 'Version' ) )
		);
	}

	/**
	 * Fires after the Free theme styles have been enqueued in the block editor.
	 */
	do_action( 'denkon_mosaic_after_enqueue_editor_assets' );
}
add_action( 'enqueue_block_editor_assets', 'denkon_mosaic_enqueue_editor_assets' );
