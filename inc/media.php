<?php
/**
 * Media helpers, including safe SVG upload support for administrators.
 *
 * @package DenkonMosaic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Allows administrators to upload SVG files for pattern icons and logos.
 *
 * @param array<string, string> $mimes Allowed MIME types.
 * @return array<string, string>
 */
function denkon_mosaic_allow_svg_uploads( $mimes ) {
	if ( current_user_can( 'manage_options' ) ) {
		$mimes['svg'] = 'image/svg+xml';
	}

	return $mimes;
}
add_filter( 'upload_mimes', 'denkon_mosaic_allow_svg_uploads' );

/**
 * Removes executable and externally loaded content from uploaded SVG files.
 *
 * SVG is intentionally available only to administrators; this additional
 * pass prevents common script and foreign-object vectors before WordPress
 * stores the file in the media library.
 *
 * @param array<string, mixed> $file Uploaded file descriptor.
 * @return array<string, mixed>
 */
function denkon_mosaic_sanitize_svg_upload( $file ) {
	$filename = isset( $file['name'] ) ? (string) $file['name'] : '';
	$tmp_name = isset( $file['tmp_name'] ) ? (string) $file['tmp_name'] : '';

	if ( 'svg' !== strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) ) ) {
		return $file;
	}

	if ( ! current_user_can( 'manage_options' ) || ! $tmp_name || ! file_exists( $tmp_name ) ) {
		$file['error'] = __( 'Загрузка SVG доступна только администраторам.', 'denkon-mosaic' );
		return $file;
	}

	$svg = file_get_contents( $tmp_name );

	if ( false === $svg || strlen( $svg ) > 1048576 || preg_match( '/<!DOCTYPE|<!ENTITY/i', $svg ) ) {
		$file['error'] = __( 'SVG-файл содержит недопустимую разметку.', 'denkon-mosaic' );
		return $file;
	}

	$dom = new DOMDocument();
	libxml_use_internal_errors( true );
	$loaded = $dom->loadXML( $svg, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING );
	libxml_clear_errors();

	if ( ! $loaded || 'svg' !== strtolower( $dom->documentElement->localName ) ) {
		$file['error'] = __( 'Не удалось проверить SVG-файл.', 'denkon-mosaic' );
		return $file;
	}

	$xpath = new DOMXPath( $dom );
	$dangerous_nodes = $xpath->query( '//*[local-name() = "script" or local-name() = "foreignObject" or local-name() = "iframe" or local-name() = "object" or local-name() = "embed"]' );

	if ( $dangerous_nodes ) {
		foreach ( $dangerous_nodes as $node ) {
			$node->parentNode->removeChild( $node );
		}
	}

	$nodes = $xpath->query( '//*' );

	if ( $nodes ) {
		foreach ( $nodes as $node ) {
			$attributes = array();

			foreach ( $node->attributes as $attribute ) {
				$attributes[] = $attribute;
			}

			foreach ( $attributes as $attribute ) {
				$name  = strtolower( $attribute->nodeName );
				$value = strtolower( trim( $attribute->nodeValue ) );

				if ( 0 === strpos( $name, 'on' ) || 0 === strpos( $value, 'javascript:' ) || ( 'style' === $name && false !== strpos( $value, 'url(' ) ) || ( in_array( $name, array( 'href', 'xlink:href' ), true ) && 0 !== strpos( $value, '#' ) ) ) {
					$node->removeAttributeNode( $attribute );
				}
			}
		}
	}

	$sanitized = $dom->saveXML();

	if ( false === $sanitized || false === file_put_contents( $tmp_name, $sanitized ) ) {
		$file['error'] = __( 'Не удалось сохранить очищенный SVG-файл.', 'denkon-mosaic' );
	}

	return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'denkon_mosaic_sanitize_svg_upload' );
