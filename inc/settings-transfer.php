<?php
/**
 * Theme settings import and export.
 *
 * @package DenkonMosaic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_post_denkon_mosaic_export_settings', 'denkon_mosaic_handle_export_settings' );
add_action( 'admin_post_denkon_mosaic_import_settings', 'denkon_mosaic_handle_import_settings' );
add_action( 'admin_post_denkon_mosaic_reset_settings', 'denkon_mosaic_handle_reset_settings' );

/**
 * Gets the per-user transient key used for transfer notices.
 *
 * @return string
 */
function denkon_mosaic_settings_transfer_notice_key() {
	return 'denkon_mosaic_settings_transfer_' . get_current_user_id();
}

/**
 * Stores a short result notice across an admin redirect.
 *
 * @param string $type    Notice type.
 * @param string $message Notice message.
 * @return void
 */
function denkon_mosaic_set_settings_transfer_notice( $type, $message ) {
	set_transient(
		denkon_mosaic_settings_transfer_notice_key(),
		array(
			'type'    => 'error' === $type ? 'error' : 'success',
			'message' => $message,
		),
		MINUTE_IN_SECONDS
	);
}

/**
 * Gets the transfer settings page URL.
 *
 * @return string
 */
function denkon_mosaic_get_settings_transfer_url() {
	return add_query_arg(
		array(
			'page' => 'denkon-mosaic',
			'tab'  => 'transfer',
		),
		admin_url( 'themes.php' )
	);
}

/**
 * Gets a fallback success notice from the redirect URL.
 *
 * The detailed per-user transient remains the primary message. This fallback
 * ensures the user still receives confirmation when a host clears object
 * cache or transients during the redirect.
 *
 * @return array<string, string>
 */
function denkon_mosaic_get_settings_transfer_redirect_notice() {
	$status = isset( $_GET['denkon_mosaic_transfer_status'] ) ? sanitize_key( wp_unslash( $_GET['denkon_mosaic_transfer_status'] ) ) : '';

	if ( 'imported' === $status ) {
		return array(
			'type'    => 'success',
			'message' => __( 'Настройки темы успешно импортированы. Связанные изображения добавлены в Медиатеку, если они были в архиве.', 'denkon-mosaic' ),
		);
	}

	if ( 'reset' === $status ) {
		return array(
			'type'    => 'success',
			'message' => __( 'Настройки темы сброшены к значениям по умолчанию. Страницы, записи, меню и файлы не изменены.', 'denkon-mosaic' ),
		);
	}

	if ( 'migrated' === $status ) {
		return array(
			'type'    => 'success',
			'message' => __( 'Метаданные ранее вставленных секций обновлены. Для каждого изменённого документа создана стандартная ревизия WordPress.', 'denkon-mosaic' ),
		);
	}

	return array();
}

/**
 * Gets metadata and local paths for media referenced by settings.
 *
 * @param array<string, string> $settings Theme settings.
 * @return array<string, array<string, mixed>>
 */
function denkon_mosaic_get_settings_transfer_media( $settings ) {
	$attachment_id = isset( $settings['footer_logo_id'] ) ? absint( $settings['footer_logo_id'] ) : 0;
	$media         = array();

	if ( $attachment_id ) {
		$file_path = get_attached_file( $attachment_id );

		if ( $file_path && is_file( $file_path ) && is_readable( $file_path ) ) {
			$filename = wp_basename( $file_path );
			$media    = array(
				(string) $attachment_id => array(
					'path'     => 'media/' . $attachment_id . '-' . sanitize_file_name( $filename ),
					'filename' => $filename,
					'mime'     => get_post_mime_type( $attachment_id ),
					'title'    => get_the_title( $attachment_id ),
					'alt'      => get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ),
					'url'      => wp_get_attachment_url( $attachment_id ),
					'source'   => $file_path,
				),
			);
		}
	}

	/**
	 * Filters local media included in a settings transfer.
	 *
	 * Extensions can add attachment records using the same manifest structure:
	 * `path`, `filename`, `mime`, `title`, `alt`, `url` and local `source`.
	 *
	 * @param array<string, array<string, mixed>> $media    Transfer media.
	 * @param array<string, string>               $settings Theme settings.
	 */
	return apply_filters( 'denkon_mosaic_settings_transfer_media', $media, $settings );
}

/**
 * Creates a portable transfer manifest.
 *
 * @return array<string, mixed>
 */
function denkon_mosaic_get_settings_transfer_manifest() {
	$settings = denkon_mosaic_get_settings();
	$media    = denkon_mosaic_get_settings_transfer_media( $settings );

	foreach ( $media as $attachment_id => $item ) {
		unset( $media[ $attachment_id ]['source'] );
	}

	$manifest = array(
		'format'      => 'denkon-mosaic-settings',
		'version'     => 1,
		'theme'       => 'denkon-mosaic',
		'exported_at' => gmdate( 'c' ),
		'site_url'    => home_url( '/' ),
		'settings'    => $settings,
		'media'       => $media,
	);

	/**
	 * Filters the portable settings transfer manifest.
	 *
	 * Pro modules may attach their own serializable data, provided that linked
	 * local media is also supplied through the media filter below.
	 *
	 * @param array<string, mixed>  $manifest Transfer manifest.
	 * @param array<string, string> $settings Theme settings.
	 */
	return apply_filters( 'denkon_mosaic_settings_transfer_manifest', $manifest, $settings );
}

/**
 * Downloads settings and linked media as a ZIP archive.
 *
 * @return void
 */
function denkon_mosaic_handle_export_settings() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Недостаточно прав для экспорта настроек темы.', 'denkon-mosaic' ) );
	}

	check_admin_referer( 'denkon_mosaic_export_settings' );

	if ( ! class_exists( 'ZipArchive' ) ) {
		denkon_mosaic_set_settings_transfer_notice( 'error', __( 'На сервере нельзя создать ZIP-архив. Обратитесь к администратору хостинга.', 'denkon-mosaic' ) );
		wp_safe_redirect( denkon_mosaic_get_settings_transfer_url() );
		exit;
	}

	$temp_file = wp_tempnam( 'denkon-mosaic-settings.zip' );

	if ( ! $temp_file ) {
		denkon_mosaic_set_settings_transfer_notice( 'error', __( 'Не удалось подготовить файл для скачивания. Попробуйте ещё раз.', 'denkon-mosaic' ) );
		wp_safe_redirect( denkon_mosaic_get_settings_transfer_url() );
		exit;
	}

	$manifest = denkon_mosaic_get_settings_transfer_manifest();
	$media    = denkon_mosaic_get_settings_transfer_media( $manifest['settings'] );
	$zip      = new ZipArchive();

	if ( true !== $zip->open( $temp_file, ZipArchive::OVERWRITE ) ) {
		wp_delete_file( $temp_file );
		denkon_mosaic_set_settings_transfer_notice( 'error', __( 'Не удалось подготовить архив с настройками. Попробуйте ещё раз.', 'denkon-mosaic' ) );
		wp_safe_redirect( denkon_mosaic_get_settings_transfer_url() );
		exit;
	}

	$zip->addFromString( 'settings.json', wp_json_encode( $manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) );

	foreach ( $media as $item ) {
		if ( ! empty( $item['source'] ) && ! empty( $item['path'] ) ) {
			$zip->addFile( $item['source'], $item['path'] );
		}
	}

	$zip->close();

	if ( ! file_exists( $temp_file ) ) {
		denkon_mosaic_set_settings_transfer_notice( 'error', __( 'Не удалось создать файл с настройками. Попробуйте ещё раз.', 'denkon-mosaic' ) );
		wp_safe_redirect( denkon_mosaic_get_settings_transfer_url() );
		exit;
	}

	nocache_headers();
	header( 'Content-Type: application/zip' );
	header( 'Content-Disposition: attachment; filename="denkon-mosaic-settings-' . gmdate( 'Y-m-d-His' ) . '.zip"' );
	header( 'Content-Length: ' . filesize( $temp_file ) );
	readfile( $temp_file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_readfile
	wp_delete_file( $temp_file );
	exit;
}

/**
 * Imports one archived media item and returns its new attachment ID.
 *
 * @param ZipArchive           $zip        Open archive.
 * @param array<string, mixed> $media_item Media manifest item.
 * @return int
 */
function denkon_mosaic_import_settings_transfer_media( $zip, $media_item ) {
	$path = isset( $media_item['path'] ) ? (string) $media_item['path'] : '';

	if ( 0 !== strpos( $path, 'media/' ) || false !== strpos( $path, '..' ) ) {
		return 0;
	}

	$stat = $zip->statName( $path );

	if ( ! is_array( $stat ) || empty( $stat['size'] ) || 10485760 < (int) $stat['size'] ) {
		return 0;
	}

	$contents = $zip->getFromName( $path );

	if ( false === $contents ) {
		return 0;
	}

	$filename = ! empty( $media_item['filename'] ) ? sanitize_file_name( $media_item['filename'] ) : wp_basename( $path );
	$temp     = wp_tempnam( $filename );

	if ( ! $temp || false === file_put_contents( $temp, $contents ) ) {
		return 0;
	}

	$file = array(
		'name'     => $filename,
		'tmp_name' => $temp,
		'error'    => 0,
		'size'     => strlen( $contents ),
	);

	if ( 'svg' === strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) ) ) {
		$file = denkon_mosaic_sanitize_svg_upload( $file );

		if ( ! empty( $file['error'] ) ) {
			wp_delete_file( $temp );
			return 0;
		}
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$handled = wp_handle_sideload( $file, array( 'test_form' => false ) );

	if ( ! empty( $handled['error'] ) || empty( $handled['file'] ) ) {
		if ( file_exists( $temp ) ) {
			wp_delete_file( $temp );
		}
		return 0;
	}

	$attachment_id = wp_insert_attachment(
		array(
			'post_mime_type' => ! empty( $handled['type'] ) ? $handled['type'] : '',
			'post_title'     => ! empty( $media_item['title'] ) ? sanitize_text_field( $media_item['title'] ) : preg_replace( '/\.[^.]+$/', '', $filename ),
			'post_status'    => 'inherit',
		),
		$handled['file']
	);

	if ( is_wp_error( $attachment_id ) || ! $attachment_id ) {
		wp_delete_file( $handled['file'] );
		return 0;
	}

	$metadata = wp_generate_attachment_metadata( $attachment_id, $handled['file'] );

	if ( ! is_wp_error( $metadata ) && $metadata ) {
		wp_update_attachment_metadata( $attachment_id, $metadata );
	}

	if ( ! empty( $media_item['alt'] ) ) {
		update_post_meta( $attachment_id, '_wp_attachment_image_alt', sanitize_text_field( $media_item['alt'] ) );
	}

	return absint( $attachment_id );
}

/**
 * Validates imported settings and remaps transferred attachment IDs.
 *
 * @param array<string, mixed> $raw_settings Raw manifest settings.
 * @param array<string, int>   $media_id_map Original to new media IDs.
 * @return array<string, string>
 */
function denkon_mosaic_sanitize_imported_settings( $raw_settings, $media_id_map ) {
	$defaults = denkon_mosaic_get_default_settings();
	$raw      = is_array( $raw_settings ) ? $raw_settings : array();
	$schemes  = denkon_mosaic_get_color_schemes();
	$scheme   = isset( $raw['color_scheme'] ) ? sanitize_key( $raw['color_scheme'] ) : $defaults['color_scheme'];
	$layout   = isset( $raw['header_layout'] ) ? sanitize_key( $raw['header_layout'] ) : $defaults['header_layout'];
	$old_logo = isset( $raw['footer_logo_id'] ) ? (string) absint( $raw['footer_logo_id'] ) : '0';

	$settings = array(
		'color_scheme'            => array_key_exists( $scheme, $schemes ) ? $scheme : $defaults['color_scheme'],
		'content_width'           => isset( $raw['content_width'] ) ? denkon_mosaic_sanitize_content_width( $raw['content_width'] ) : $defaults['content_width'],
		'heading_font_family'     => isset( $raw['heading_font_family'] ) ? denkon_mosaic_sanitize_font_family_choice( $raw['heading_font_family'] ) : '',
		'body_font_family'        => isset( $raw['body_font_family'] ) ? denkon_mosaic_sanitize_font_family_choice( $raw['body_font_family'] ) : '',
		'header_background'       => denkon_mosaic_sanitize_color( isset( $raw['header_background'] ) ? $raw['header_background'] : '', $defaults['header_background'] ),
		'header_text_color'       => denkon_mosaic_sanitize_color( isset( $raw['header_text_color'] ) ? $raw['header_text_color'] : '', $defaults['header_text_color'] ),
		'header_link_color'       => denkon_mosaic_sanitize_color( isset( $raw['header_link_color'] ) ? $raw['header_link_color'] : '', $defaults['header_link_color'] ),
		'header_link_hover_color' => denkon_mosaic_sanitize_color( isset( $raw['header_link_hover_color'] ) ? $raw['header_link_hover_color'] : '', $defaults['header_link_hover_color'] ),
		'header_layout'           => in_array( $layout, array( 'standard', 'centered' ), true ) ? $layout : $defaults['header_layout'],
		'header_cta_text'         => isset( $raw['header_cta_text'] ) ? sanitize_text_field( $raw['header_cta_text'] ) : $defaults['header_cta_text'],
		'header_cta_url'          => isset( $raw['header_cta_url'] ) ? denkon_mosaic_sanitize_link( $raw['header_cta_url'] ) : $defaults['header_cta_url'],
		'footer_logo_id'          => isset( $media_id_map[ $old_logo ] ) ? (string) absint( $media_id_map[ $old_logo ] ) : '0',
		'footer_background'       => denkon_mosaic_sanitize_color( isset( $raw['footer_background'] ) ? $raw['footer_background'] : '', $defaults['footer_background'] ),
		'footer_text_color'       => denkon_mosaic_sanitize_color( isset( $raw['footer_text_color'] ) ? $raw['footer_text_color'] : '', $defaults['footer_text_color'] ),
		'footer_link_color'       => denkon_mosaic_sanitize_color( isset( $raw['footer_link_color'] ) ? $raw['footer_link_color'] : '', $defaults['footer_link_color'] ),
		'footer_link_hover_color' => denkon_mosaic_sanitize_color( isset( $raw['footer_link_hover_color'] ) ? $raw['footer_link_hover_color'] : '', $defaults['footer_link_hover_color'] ),
		'footer_text'             => isset( $raw['footer_text'] ) ? sanitize_textarea_field( $raw['footer_text'] ) : $defaults['footer_text'],
		'footer_copyright'        => isset( $raw['footer_copyright'] ) ? sanitize_text_field( $raw['footer_copyright'] ) : $defaults['footer_copyright'],
	);

	foreach ( denkon_mosaic_get_custom_color_defaults() as $color_key => $fallback ) {
		$settings[ $color_key ] = denkon_mosaic_sanitize_color( isset( $raw[ $color_key ] ) ? $raw[ $color_key ] : '', $fallback );
	}

	return $settings;
}

/**
 * Imports a validated transfer archive.
 *
 * @return void
 */
function denkon_mosaic_handle_import_settings() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Недостаточно прав для импорта настроек темы.', 'denkon-mosaic' ) );
	}

	check_admin_referer( 'denkon_mosaic_import_settings' );

	if ( ! class_exists( 'ZipArchive' ) ) {
		denkon_mosaic_set_settings_transfer_notice( 'error', __( 'На сервере нельзя открыть ZIP-архив. Обратитесь к администратору хостинга.', 'denkon-mosaic' ) );
		wp_safe_redirect( denkon_mosaic_get_settings_transfer_url() );
		exit;
	}

	if ( empty( $_FILES['denkon_mosaic_settings_file']['tmp_name'] ) || ! empty( $_FILES['denkon_mosaic_settings_file']['error'] ) ) {
		denkon_mosaic_set_settings_transfer_notice( 'error', __( 'Выберите ZIP-архив с настройками темы.', 'denkon-mosaic' ) );
		wp_safe_redirect( denkon_mosaic_get_settings_transfer_url() );
		exit;
	}

	$uploaded = $_FILES['denkon_mosaic_settings_file'];

	$max_archive_size = max( 1048576, absint( apply_filters( 'denkon_mosaic_settings_transfer_max_archive_size', 20971520 ) ) );

	if ( $max_archive_size < absint( $uploaded['size'] ) ) {
		denkon_mosaic_set_settings_transfer_notice( 'error', __( 'Размер архива не должен превышать 20 МБ.', 'denkon-mosaic' ) );
		wp_safe_redirect( denkon_mosaic_get_settings_transfer_url() );
		exit;
	}

	$zip = new ZipArchive();

	if ( true !== $zip->open( $uploaded['tmp_name'] ) ) {
		denkon_mosaic_set_settings_transfer_notice( 'error', __( 'Не удалось открыть архив. Убедитесь, что выбран корректный ZIP-файл.', 'denkon-mosaic' ) );
		wp_safe_redirect( denkon_mosaic_get_settings_transfer_url() );
		exit;
	}

	$json = $zip->getFromName( 'settings.json' );
	$manifest = false !== $json ? json_decode( $json, true ) : null;

	if ( ! is_array( $manifest ) || 'denkon-mosaic-settings' !== ( $manifest['format'] ?? '' ) || empty( $manifest['settings'] ) || ! is_array( $manifest['settings'] ) ) {
		$zip->close();
		denkon_mosaic_set_settings_transfer_notice( 'error', __( 'Этот архив не содержит настройки темы Denkon Mosaic.', 'denkon-mosaic' ) );
		wp_safe_redirect( denkon_mosaic_get_settings_transfer_url() );
		exit;
	}

	$media_id_map = array();
	$media_items  = ! empty( $manifest['media'] ) && is_array( $manifest['media'] ) ? $manifest['media'] : array();

	$media_limit = max( 1, absint( apply_filters( 'denkon_mosaic_settings_transfer_media_limit', 5 ) ) );

	if ( $media_limit < count( $media_items ) ) {
		$zip->close();
		denkon_mosaic_set_settings_transfer_notice( 'error', __( 'В архиве слишком много файлов для переноса настроек.', 'denkon-mosaic' ) );
		wp_safe_redirect( denkon_mosaic_get_settings_transfer_url() );
		exit;
	}

	foreach ( $media_items as $old_id => $media_item ) {
		$new_id = denkon_mosaic_import_settings_transfer_media( $zip, is_array( $media_item ) ? $media_item : array() );

		if ( $new_id ) {
			$media_id_map[ (string) absint( $old_id ) ] = $new_id;
		}
	}

	$zip->close();
	$settings = denkon_mosaic_sanitize_imported_settings( $manifest['settings'], $media_id_map );

	update_option( denkon_mosaic_settings_option_key(), $settings );

	/**
	 * Fires after the theme settings and archived media have been imported.
	 *
	 * Extensions can restore their data while both the original manifest and
	 * source-to-target attachment ID map are available.
	 *
	 * @param array<string, mixed> $manifest     Imported manifest.
	 * @param array<string, int>   $media_id_map Imported attachment ID map.
	 */
	do_action( 'denkon_mosaic_after_import_settings_transfer', $manifest, $media_id_map );

	$notice = apply_filters(
		'denkon_mosaic_settings_transfer_import_success_message',
		__( 'Настройки темы успешно импортированы. Связанные изображения добавлены в Медиатеку, если они были в архиве.', 'denkon-mosaic' ),
		$manifest,
		$media_id_map
	);
	denkon_mosaic_set_settings_transfer_notice( 'success', $notice );
	wp_safe_redirect( add_query_arg( 'denkon_mosaic_transfer_status', 'imported', denkon_mosaic_get_settings_transfer_url() ) );
	exit;
}

/**
 * Resets saved theme settings without changing site content or media files.
 *
 * @return void
 */
function denkon_mosaic_handle_reset_settings() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'Недостаточно прав для сброса настроек темы.', 'denkon-mosaic' ) );
	}

	check_admin_referer( 'denkon_mosaic_reset_settings' );

	update_option( denkon_mosaic_settings_option_key(), denkon_mosaic_get_default_settings() );

	/**
	 * Fires after Denkon Mosaic settings have been reset to defaults.
	 *
	 * Extensions may reset only their own settings here. Site content, media,
	 * navigation and WordPress Customizer values must remain untouched.
	 */
	do_action( 'denkon_mosaic_reset_settings' );

	denkon_mosaic_set_settings_transfer_notice( 'success', __( 'Настройки темы сброшены к значениям по умолчанию. Страницы, записи, меню и файлы не изменены.', 'denkon-mosaic' ) );
	wp_safe_redirect( add_query_arg( 'denkon_mosaic_transfer_status', 'reset', denkon_mosaic_get_settings_transfer_url() ) );
	exit;
}

/**
 * Renders the transfer tools in the theme settings screen.
 *
 * @return void
 */
function denkon_mosaic_render_settings_transfer_panel() {
	$notice = get_transient( denkon_mosaic_settings_transfer_notice_key() );

	if ( is_array( $notice ) && ! empty( $notice['message'] ) ) {
		delete_transient( denkon_mosaic_settings_transfer_notice_key() );
	} else {
		$notice = denkon_mosaic_get_settings_transfer_redirect_notice();
	}

	if ( is_array( $notice ) && ! empty( $notice['message'] ) ) {
		?>
		<div class="notice notice-<?php echo 'error' === $notice['type'] ? 'error' : 'success'; ?> is-dismissible"><p><?php echo esc_html( $notice['message'] ); ?></p></div>
		<?php
	}

	$export_url = wp_nonce_url( admin_url( 'admin-post.php?action=denkon_mosaic_export_settings' ), 'denkon_mosaic_export_settings' );
	$intro      = apply_filters( 'denkon_mosaic_settings_transfer_panel_intro', __( 'Сохраните настройки темы в архив или перенесите их на другой сайт с темой Denkon Mosaic. Логотип подвала также будет добавлен в медиатеку нового сайта.', 'denkon-mosaic' ) );
	$export_text = apply_filters( 'denkon_mosaic_settings_transfer_export_text', __( 'Скачайте ZIP-архив с текущими настройками и логотипом подвала.', 'denkon-mosaic' ) );
	$import_text = apply_filters( 'denkon_mosaic_settings_transfer_import_text', __( 'Выберите ZIP-архив, созданный в Denkon Mosaic. Текущие настройки темы будут заменены настройками из архива.', 'denkon-mosaic' ) );
	?>
	<div class="denkon-mosaic-admin__panel-heading">
		<h2><?php esc_html_e( 'Импорт и экспорт', 'denkon-mosaic' ); ?></h2>
		<p><?php echo esc_html( $intro ); ?></p>
	</div>
	<div class="notice notice-info is-dismissible" data-denkon-transfer-feedback role="status" aria-live="polite" hidden><p></p></div>
	<div class="denkon-mosaic-admin__transfer-grid">
		<section class="denkon-mosaic-admin__transfer-card">
			<h3><?php esc_html_e( 'Экспорт', 'denkon-mosaic' ); ?></h3>
			<p><?php echo esc_html( $export_text ); ?></p>
			<a class="button button-primary" data-denkon-export-settings href="<?php echo esc_url( $export_url ); ?>"><?php esc_html_e( 'Скачать ZIP-архив', 'denkon-mosaic' ); ?></a>
		</section>
		<section class="denkon-mosaic-admin__transfer-card">
			<h3><?php esc_html_e( 'Импорт', 'denkon-mosaic' ); ?></h3>
			<p><?php echo esc_html( $import_text ); ?></p>
			<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" enctype="multipart/form-data" data-denkon-import-settings>
				<input type="hidden" name="action" value="denkon_mosaic_import_settings">
				<?php wp_nonce_field( 'denkon_mosaic_import_settings' ); ?>
				<input type="file" name="denkon_mosaic_settings_file" accept=".zip,application/zip" required>
				<button type="submit" class="button button-secondary"><?php esc_html_e( 'Импортировать настройки', 'denkon-mosaic' ); ?></button>
			</form>
		</section>
		<section class="denkon-mosaic-admin__transfer-card denkon-mosaic-admin__transfer-card--danger">
			<h3><?php esc_html_e( 'Сброс настроек', 'denkon-mosaic' ); ?></h3>
			<p><?php esc_html_e( 'Верните цвета, ширину контента, шапку и подвал к исходным значениям темы. Страницы, паттерны, меню, Custom Logo и файлы в медиатеке не изменятся.', 'denkon-mosaic' ); ?></p>
			<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" data-denkon-reset-settings>
				<input type="hidden" name="action" value="denkon_mosaic_reset_settings">
				<?php wp_nonce_field( 'denkon_mosaic_reset_settings' ); ?>
				<button type="submit" class="button button-link-delete"><?php esc_html_e( 'Сбросить настройки темы', 'denkon-mosaic' ); ?></button>
			</form>
		</section>
		<section class="denkon-mosaic-admin__transfer-card">
			<h3><?php esc_html_e( 'Обновление ранее вставленных паттернов', 'denkon-mosaic' ); ?></h3>
			<p><?php esc_html_e( 'Добавьте русские названия и описания в редакторе к секциям Denkon Mosaic, вставленным до обновления библиотеки. Текст, стили и изображения не изменятся; для каждого изменённого документа будет создана ревизия.', 'denkon-mosaic' ); ?></p>
			<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" data-denkon-migrate-pattern-metadata>
				<input type="hidden" name="action" value="denkon_mosaic_migrate_pattern_metadata">
				<?php wp_nonce_field( 'denkon_mosaic_migrate_pattern_metadata' ); ?>
				<button type="submit" class="button button-secondary"><?php esc_html_e( 'Обновить метаданные паттернов', 'denkon-mosaic' ); ?></button>
			</form>
		</section>
	</div>
	<?php
}
