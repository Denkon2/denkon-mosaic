<?php
/**
 * Safe migration for metadata of previously inserted theme patterns.
 *
 * @package DenkonMosaic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns metadata assigned to known Free-theme pattern root classes.
 *
 * @return array<string, array<string, mixed>>
 */
function denkon_mosaic_get_pattern_metadata_migrations() {
	$migrations = array(
		'mosaic-hero' => array(
			'name'        => __( 'Первый экран с оффером и изображением', 'denkon-mosaic' ),
			'categories'  => array( 'hero' ),
			'patternName' => 'denkon-mosaic/hero-intro',
		),
		'mosaic-steps' => array(
			'name'        => __( 'Четыре этапа работы', 'denkon-mosaic' ),
			'categories'  => array( 'steps' ),
			'patternName' => 'denkon-mosaic/steps',
		),
		'mosaic-benefits' => array(
			'name'        => __( 'Преимущества в карточках', 'denkon-mosaic' ),
			'categories'  => array( 'benefits' ),
			'patternName' => 'denkon-mosaic/benefits',
		),
		'mosaic-faq' => array(
			'name'        => __( 'Ответы на частые вопросы', 'denkon-mosaic' ),
			'categories'  => array( 'faq' ),
			'patternName' => 'denkon-mosaic/faq',
		),
		'mosaic-gallery-section' => array(
			'name'        => __( 'Галерея из шести изображений', 'denkon-mosaic' ),
			'categories'  => array( 'gallery' ),
			'patternName' => 'denkon-mosaic/gallery',
		),
		'mosaic-about' => array(
			'name'        => __( 'О компании с изображением', 'denkon-mosaic' ),
			'categories'  => array( 'about' ),
			'patternName' => 'denkon-mosaic/about',
		),
		'mosaic-partners' => array(
			'name'        => __( 'Логотипы клиентов и партнёров', 'denkon-mosaic' ),
			'categories'  => array( 'partners' ),
			'patternName' => 'denkon-mosaic/partners',
		),
		'mosaic-testimonials' => array(
			'name'        => __( 'Отзывы клиентов', 'denkon-mosaic' ),
			'categories'  => array( 'testimonials' ),
			'patternName' => 'denkon-mosaic/testimonials',
		),
		'mosaic-form' => array(
			'name'        => __( 'Текст и форма в двух колонках', 'denkon-mosaic' ),
			'categories'  => array( 'form' ),
			'patternName' => 'denkon-mosaic/form',
		),
	);

	/**
	 * Lets extensions add root CSS classes for their own patterns.
	 *
	 * @param array<string, array<string, mixed>> $migrations Pattern metadata.
	 */
	return apply_filters( 'denkon_mosaic_pattern_metadata_migrations', $migrations );
}

/**
 * Returns metadata assigned to known custom pattern root blocks.
 *
 * @return array<string, array<string, mixed>>
 */
function denkon_mosaic_get_pattern_block_metadata_migrations() {
	/**
	 * Lets extensions add custom root blocks used by their patterns.
	 *
	 * @param array<string, array<string, mixed>> $migrations Pattern metadata.
	 */
	return apply_filters( 'denkon_mosaic_pattern_block_metadata_migrations', array() );
}

/**
 * Checks whether a space-separated class list has a class token.
 *
 * @param string $classes Class list.
 * @param string $class   Expected class.
 * @return bool
 */
function denkon_mosaic_pattern_migration_has_class( $classes, $class ) {
	return (bool) preg_match( '/(?:^|\s)' . preg_quote( $class, '/' ) . '(?:\s|$)/', $classes );
}

/**
 * Adds metadata to one block and its descendants without altering content.
 *
 * @param array<string, mixed>                    $block             Parsed block.
 * @param array<string, array<string, mixed>>     $class_migrations  Root class metadata.
 * @param array<string, array<string, mixed>>     $block_migrations  Root block metadata.
 * @param int                                     $migrated_patterns Number of updated roots.
 * @return array<string, mixed>
 */
function denkon_mosaic_migrate_pattern_metadata_block( $block, $class_migrations, $block_migrations, &$migrated_patterns ) {
	$metadata = isset( $block['attrs']['metadata'] ) && is_array( $block['attrs']['metadata'] ) ? $block['attrs']['metadata'] : array();
	$match    = array();

	if ( empty( $metadata['patternName'] ) ) {
		$block_name = isset( $block['blockName'] ) ? $block['blockName'] : '';

		if ( isset( $block_migrations[ $block_name ] ) ) {
			$match = $block_migrations[ $block_name ];
		} elseif ( 'core/group' === $block_name ) {
			$classes = isset( $block['attrs']['className'] ) ? (string) $block['attrs']['className'] : '';

			foreach ( $class_migrations as $class => $migration ) {
				if ( denkon_mosaic_pattern_migration_has_class( $classes, $class ) ) {
					$match = $migration;
					break;
				}
			}
		}

		if ( $match ) {
			$block['attrs']             = isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : array();
			$block['attrs']['metadata'] = array_merge( $metadata, $match );
			++$migrated_patterns;
		}
	}

	if ( ! empty( $block['innerBlocks'] ) && is_array( $block['innerBlocks'] ) ) {
		foreach ( $block['innerBlocks'] as $index => $inner_block ) {
			$block['innerBlocks'][ $index ] = denkon_mosaic_migrate_pattern_metadata_block( $inner_block, $class_migrations, $block_migrations, $migrated_patterns );
		}
	}

	return $block;
}

/**
 * Safely migrates existing pages, posts and site layouts in batches.
 *
 * Only blocks with known Denkon Mosaic root classes or custom root blocks are
 * changed. A block that already has patternName metadata remains untouched.
 * wp_update_post creates a normal WordPress revision for each changed item.
 *
 * @return array<string, mixed> Migration result.
 */
function denkon_mosaic_migrate_existing_pattern_metadata() {
	$class_migrations = denkon_mosaic_get_pattern_metadata_migrations();
	$block_migrations = denkon_mosaic_get_pattern_block_metadata_migrations();
	$result           = array(
		'scanned'  => 0,
		'updated'  => 0,
		'patterns' => 0,
		'posts'    => array(),
	);
	$paged            = 1;

	do {
		$query = new WP_Query(
			array(
				'post_type'      => array( 'page', 'post', 'denkon_mosaic_layout' ),
				'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'future' ),
				'posts_per_page' => 50,
				'paged'          => $paged,
				'orderby'        => 'ID',
				'order'          => 'ASC',
				'no_found_rows'  => false,
			)
		);

		foreach ( $query->posts as $post ) {
			$content = (string) $post->post_content;

			if ( false === strpos( $content, 'mosaic-' ) && false === strpos( $content, 'denkon-mosaic-pro/' ) ) {
				continue;
			}

			++$result['scanned'];
			$blocks            = parse_blocks( $content );
			$migrated_patterns = 0;

			foreach ( $blocks as $index => $block ) {
				$blocks[ $index ] = denkon_mosaic_migrate_pattern_metadata_block( $block, $class_migrations, $block_migrations, $migrated_patterns );
			}

			if ( ! $migrated_patterns ) {
				continue;
			}

			$updated_content = serialize_blocks( $blocks );

			if ( $updated_content === $content || is_wp_error( wp_update_post( wp_slash( array( 'ID' => $post->ID, 'post_content' => $updated_content ) ), true ) ) ) {
				continue;
			}

			++$result['updated'];
			$result['patterns'] += $migrated_patterns;
			$result['posts'][] = array(
				'id'    => $post->ID,
				'title' => get_the_title( $post ),
				'type'  => $post->post_type,
			);
		}

		++$paged;
	} while ( $paged <= $query->max_num_pages );

	wp_reset_postdata();

	return $result;
}

/**
 * Handles migration from Appearance > Mosaic > Import and export.
 *
 * @return void
 */
function denkon_mosaic_handle_pattern_metadata_migration() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'Недостаточно прав для обновления метаданных паттернов.', 'denkon-mosaic' ) );
	}

	check_admin_referer( 'denkon_mosaic_migrate_pattern_metadata' );

	$result  = denkon_mosaic_migrate_existing_pattern_metadata();
	$updated = absint( $result['updated'] );
	$message = sprintf(
		_n( 'Метаданные обновлены в %1$d документе: распознана %2$d секция.', 'Метаданные обновлены в %1$d документах: распознано %2$d секций.', $updated, 'denkon-mosaic' ),
		$updated,
		$result['patterns']
	);

	if ( ! $result['updated'] ) {
		$message = __( 'Подходящих ранее вставленных секций не найдено. Новые паттерны уже содержат метаданные автоматически.', 'denkon-mosaic' );
	}

	denkon_mosaic_set_settings_transfer_notice( 'success', $message );
	wp_safe_redirect( add_query_arg( 'denkon_mosaic_transfer_status', 'migrated', denkon_mosaic_get_settings_transfer_url() ) );
	exit;
}
add_action( 'admin_post_denkon_mosaic_migrate_pattern_metadata', 'denkon_mosaic_handle_pattern_metadata_migration' );
