<?php
/**
 * Core theme setup.
 *
 * @package DenkonMosaic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers WordPress features used by the theme.
 *
 * @return void
 */
function denkon_mosaic_setup() {
	load_theme_textdomain( 'denkon-mosaic', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/main.css' );
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f8f6f2',
		)
	);
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 320,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'script',
		'style',
	) );

	register_nav_menus( array(
		'primary' => __( 'Главное меню', 'denkon-mosaic' ),
		'footer'  => __( 'Меню в подвале', 'denkon-mosaic' ),
	) );
}
add_action( 'after_setup_theme', 'denkon_mosaic_setup' );

/**
 * Adds the chosen visual scheme as a stable hook for public styles.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function denkon_mosaic_body_classes( $classes ) {
	$settings  = denkon_mosaic_get_settings();
	$classes[] = 'denkon-mosaic--scheme-' . sanitize_html_class( $settings['color_scheme'] );

	return $classes;
}
add_filter( 'body_class', 'denkon_mosaic_body_classes' );

/**
 * Checks whether a page contains a pattern from this theme.
 *
 * A pattern is copied into post content by Gutenberg, so its identifying
 * CSS class is the stable signal available after insertion.
 *
 * @param int|null $post_id Post ID. Uses the current post when omitted.
 * @return bool
 */
function denkon_mosaic_page_has_theme_pattern( $post_id = null ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	$content = $post_id ? (string) get_post_field( 'post_content', $post_id ) : '';

	return false !== strpos( $content, 'mosaic-pattern' )
		|| false !== strpos( $content, 'mosaic-hero' )
		|| false !== strpos( $content, 'denkon-mosaic-pro/hero-carousel' );
}
