<?php
/**
 * Block pattern library registration.
 *
 * @package DenkonMosaic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the Denkon Mosaic pattern category and pattern library.
 *
 * @return void
 */
function denkon_mosaic_register_patterns() {
	register_block_pattern_category(
		'denkon-mosaic',
		array( 'label' => __( 'Denkon Mosaic', 'denkon-mosaic' ) )
	);

	/**
	 * Fires after the Free pattern category has been registered.
	 *
	 * Extensions can register their own pattern categories and patterns here.
	 */
	do_action( 'denkon_mosaic_register_patterns' );

	$pattern_files = array(
		'hero-intro',
		'steps',
		'benefits',
		'benefits-horizontal',
		'faq',
		'faq-with-image',
		'gallery',
		'about',
		'partners',
		'testimonials',
		'form',
		'steps-two-columns',
	);

	foreach ( $pattern_files as $pattern_file ) {
		$path = get_template_directory() . '/patterns/' . $pattern_file . '.php';

		if ( ! file_exists( $path ) ) {
			continue;
		}

		$pattern = require $path;

		if ( ! is_array( $pattern ) || empty( $pattern['title'] ) || empty( $pattern['content'] ) ) {
			continue;
		}

		$pattern['categories'] = array( 'denkon-mosaic' );
		$pattern['content']    = denkon_mosaic_translate_pattern_content( $pattern['content'] );
		$pattern['content']    = str_replace(
			array( '{{mosaic_icon}}', '{{mosaic_image}}' ),
			array(
				esc_url( get_template_directory_uri() . '/assets/images/mosaic-icon-placeholder.svg' ),
				esc_url( get_template_directory_uri() . '/assets/images/mosaic-image-placeholder.svg' ),
			),
			$pattern['content']
		);

		register_block_pattern( 'denkon-mosaic/' . $pattern_file, $pattern );
	}
}
add_action( 'init', 'denkon_mosaic_register_patterns' );
