<?php
/**
 * Theme bootstrap file.
 *
 * @package DenkonMosaic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$denkon_mosaic_includes = array(
	'/inc/setup.php',
	'/inc/assets.php',
	'/inc/patterns.php',
	'/inc/pattern-migration.php',
	'/inc/settings.php',
	'/inc/language.php',
	'/inc/settings-transfer.php',
	'/inc/child-theme.php',
);

foreach ( $denkon_mosaic_includes as $denkon_mosaic_file ) {
	$denkon_mosaic_path = get_template_directory() . $denkon_mosaic_file;

	if ( file_exists( $denkon_mosaic_path ) ) {
		require_once $denkon_mosaic_path;
	}
}

/**
 * Registers a small native block-style variation used by the theme.
 *
 * @return void
 */
function denkon_mosaic_register_block_styles() {
	register_block_style(
		'core/button',
		array(
			'name'  => 'mosaic-outline',
			'label' => __( 'Mosaic outline', 'denkon-mosaic' ),
		)
	);
}
add_action( 'init', 'denkon_mosaic_register_block_styles' );
