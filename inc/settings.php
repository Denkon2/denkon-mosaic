<?php
/**
 * Theme settings page and settings data helpers.
 *
 * @package DenkonMosaic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gets the option key used by the theme.
 *
 * @return string
 */
function denkon_mosaic_settings_option_key() {
	return 'denkon_mosaic_settings';
}

/**
 * Gets default theme settings.
 *
 * @return array<string, string>
 */
function denkon_mosaic_get_default_settings() {
	return array_merge(
		array(
		'interface_language' => 'en',
		'color_scheme'    => 'light',
		'content_width'   => '1200px',
		'heading_font_family' => '',
		'body_font_family'    => '',
		'header_background' => '#ffffff',
		'header_text_color' => '#282522',
		'header_link_color' => '#282522',
		'header_link_hover_color' => '#9a681d',
		'header_layout'   => 'standard',
		'header_cta_text' => __( 'Начать', 'denkon-mosaic' ),
		'header_cta_url'  => '#mosaic-cta',
		'footer_logo_id'  => '0',
		'footer_background' => '#ffffff',
		'footer_text_color' => '#282522',
		'footer_link_color' => '#282522',
		'footer_link_hover_color' => '#9a681d',
		'footer_text'     => __( 'Премиальный WordPress-шаблон для услуг, компаний и экспертов.', 'denkon-mosaic' ),
		'footer_copyright'=> '',
		),
		denkon_mosaic_get_custom_color_defaults()
	);
}

/**
 * Gets fallback values for the editable custom colour scheme.
 *
 * @return array<string, string>
 */
function denkon_mosaic_get_custom_color_defaults() {
	return array(
		'custom_color_primary'       => '#9a681d',
		'custom_color_primary_hover' => '#754c15',
		'custom_color_text'          => '#282522',
		'custom_color_muted'         => '#6d665d',
		'custom_color_surface'       => '#ffffff',
		'custom_color_background'    => '#f8f6f2',
		'custom_color_border'        => '#e7e0d6',
	);
}

/**
 * Returns validated values for the editable custom colour scheme.
 *
 * @param array<string, string>|null $settings Settings to read. Uses saved settings when omitted.
 * @return array<string, string>
 */
function denkon_mosaic_get_custom_color_values( $settings = null ) {
	$defaults = denkon_mosaic_get_custom_color_defaults();
	$settings = is_array( $settings ) ? $settings : denkon_mosaic_get_settings();
	$values   = array();

	foreach ( $defaults as $key => $fallback ) {
		$values[ $key ] = denkon_mosaic_sanitize_color( isset( $settings[ $key ] ) ? $settings[ $key ] : '', $fallback );
	}

	return $values;
}

/**
 * Gets saved settings merged with safe defaults.
 *
 * @return array<string, string>
 */
function denkon_mosaic_get_settings() {
	$saved = get_option( denkon_mosaic_settings_option_key(), array() );

	return wp_parse_args( is_array( $saved ) ? $saved : array(), denkon_mosaic_get_default_settings() );
}

/**
 * Gets selectable public colour schemes.
 *
 * @return array<string, array<string, string>>
 */
function denkon_mosaic_get_color_schemes() {
	$schemes = array(
		'light' => array(
			'label'       => __( 'По умолчанию', 'denkon-mosaic' ),
			'description' => __( 'Фирменная светлая схема: графитовая основа и золотой акцент.', 'denkon-mosaic' ),
		),
		'warm'  => array(
			'label'       => __( 'Терракота и охра', 'denkon-mosaic' ),
			'description' => __( 'Тёплая контрастная схема с терракотовыми акцентами и охристым фоном.', 'denkon-mosaic' ),
		),
		'dark'  => array(
			'label'       => __( 'Тёмная', 'denkon-mosaic' ),
			'description' => __( 'Контрастная ночная версия для выразительных проектов.', 'denkon-mosaic' ),
		),
		'custom' => array(
			'label'       => __( 'Произвольная', 'denkon-mosaic' ),
			'description' => __( 'Собственная палитра: настройте цвета сайта под бренд.', 'denkon-mosaic' ),
		),
	);

	/**
	 * Filters the public colour schemes available in the theme settings.
	 *
	 * Premium extensions can add their own schemes without replacing the
	 * built-in list. Each scheme needs a label and description.
	 *
	 * @param array<string, array<string, string>> $schemes Colour schemes.
	 */
	return apply_filters( 'denkon_mosaic_color_schemes', $schemes );
}

/**
 * Returns font families available in the active theme and Font Library.
 *
 * The Font Library stores installed families in the user part of theme.json.
 * Reading the merged settings means fonts installed later appear here without
 * an additional registration step in the theme.
 *
 * @return array<string, array{label:string,font_family:string}>
 */
function denkon_mosaic_get_font_family_choices() {
	$choices = array(
		'' => array(
			'label'       => __( 'Системный шрифт темы', 'denkon-mosaic' ),
			'font_family' => '',
		),
	);

	if ( ! function_exists( 'wp_get_global_settings' ) ) {
		return $choices;
	}

	$font_families = wp_get_global_settings( array( 'typography', 'fontFamilies' ) );

	if ( ! is_array( $font_families ) ) {
		return $choices;
	}

	foreach ( $font_families as $origin => $families ) {
		if ( ! is_array( $families ) ) {
			continue;
		}

		foreach ( $families as $family ) {
			if ( ! is_array( $family ) || empty( $family['slug'] ) || empty( $family['fontFamily'] ) ) {
				continue;
			}

			// The first option already represents the theme's built-in system stack.
			if ( 'theme' === $origin && 'system' === $family['slug'] ) {
				continue;
			}

			$choice_id   = sanitize_key( (string) $origin ) . ':' . sanitize_title( (string) $family['slug'] );
			$font_family = denkon_mosaic_sanitize_font_family_value( $family['fontFamily'] );

			if ( '' === $font_family || isset( $choices[ $choice_id ] ) ) {
				continue;
			}

			$choices[ $choice_id ] = array(
				'label'       => ! empty( $family['name'] ) ? sanitize_text_field( $family['name'] ) : sanitize_text_field( $family['slug'] ),
				'font_family' => $font_family,
			);
		}
	}

	return $choices;
}

/**
 * Sanitizes a CSS font-family value provided by WordPress Font Library data.
 *
 * @param mixed $value Font family value.
 * @return string
 */
function denkon_mosaic_sanitize_font_family_value( $value ) {
	$value = is_string( $value ) ? $value : '';

	if ( class_exists( 'WP_Font_Utils' ) && is_callable( array( 'WP_Font_Utils', 'sanitize_font_family' ) ) ) {
		return WP_Font_Utils::sanitize_font_family( $value );
	}

	return sanitize_text_field( $value );
}

/**
 * Sanitizes a selected Font Library choice identifier.
 *
 * @param mixed $value Posted choice identifier.
 * @return string
 */
function denkon_mosaic_sanitize_font_family_choice( $value ) {
	$value   = is_string( $value ) ? sanitize_text_field( $value ) : '';
	$choices = denkon_mosaic_get_font_family_choices();

	return array_key_exists( $value, $choices ) ? $value : '';
}

/**
 * Resolves a selected choice identifier to a safe CSS font-family value.
 *
 * @param mixed $choice Selected font family choice.
 * @return string
 */
function denkon_mosaic_get_selected_font_family( $choice ) {
	$choice  = denkon_mosaic_sanitize_font_family_choice( $choice );
	$choices = denkon_mosaic_get_font_family_choices();

	return isset( $choices[ $choice ] ) ? $choices[ $choice ]['font_family'] : '';
}

/**
 * Sanitizes a CSS width value used for the public content container.
 *
 * Plain numeric values from older settings are treated as pixels. Percentages
 * are limited to a practical range, while pixel values stay within a safe
 * desktop layout range.
 *
 * @param mixed $value Raw width value.
 * @return string
 */
function denkon_mosaic_sanitize_content_width( $value ) {
	$value = is_string( $value ) || is_numeric( $value ) ? strtolower( trim( (string) $value ) ) : '';
	$value = str_replace( ' ', '', $value );

	if ( preg_match( '/^([1-9][0-9]?)%$/', $value, $matches ) ) {
		return (string) min( 100, max( 1, absint( $matches[1] ) ) ) . '%';
	}

	if ( preg_match( '/^([0-9]{2,4})(px)?$/', $value, $matches ) ) {
		return (string) min( 2400, max( 320, absint( $matches[1] ) ) ) . 'px';
	}

	return denkon_mosaic_get_default_settings()['content_width'];
}

/**
 * Sanitizes a colour setting and returns a stable fallback when invalid.
 *
 * @param mixed  $value    Raw colour value.
 * @param string $fallback Safe fallback colour.
 * @return string
 */
function denkon_mosaic_sanitize_color( $value, $fallback ) {
	$value = is_string( $value ) ? trim( $value ) : '';

	if ( preg_match( '/^[0-9a-f]{3}(?:[0-9a-f]{3})?$/i', $value ) ) {
		$value = '#' . $value;
	}

	$color = sanitize_hex_color( $value );

	return $color ? $color : $fallback;
}

/**
 * Returns a six-character hexadecimal colour for the native colour swatch.
 *
 * HTML `input[type="color"]` accepts only #RRGGBB, while WordPress correctly
 * permits the shorter #RGB notation in saved settings.
 *
 * @param mixed  $value    Raw colour value.
 * @param string $fallback Safe fallback colour.
 * @return string
 */
function denkon_mosaic_get_color_field_value( $value, $fallback = '#ffffff' ) {
	$color = strtolower( denkon_mosaic_sanitize_color( $value, $fallback ) );

	if ( preg_match( '/^#([0-9a-f]{3})$/', $color, $matches ) ) {
		return '#' . $matches[1][0] . $matches[1][0] . $matches[1][1] . $matches[1][1] . $matches[1][2] . $matches[1][2];
	}

	return $color;
}

/**
 * Adds the theme page under Appearance.
 *
 * @return void
 */
function denkon_mosaic_add_settings_page() {
	add_theme_page(
		__( 'Denkon Mosaic', 'denkon-mosaic' ),
		__( 'Denkon Mosaic', 'denkon-mosaic' ),
		'edit_theme_options',
		'denkon-mosaic',
		'denkon_mosaic_render_settings_page'
	);
}
add_action( 'admin_menu', 'denkon_mosaic_add_settings_page' );

/**
 * Loads settings-page-specific styles only on the theme page.
 *
 * @param string $hook Current admin page hook.
 * @return void
 */
function denkon_mosaic_enqueue_admin_assets( $hook ) {
	if ( 'appearance_page_denkon-mosaic' !== $hook ) {
		return;
	}

	wp_enqueue_style(
		'denkon-mosaic-settings',
		get_template_directory_uri() . '/assets/css/admin-settings.css',
		array(),
		denkon_mosaic_get_asset_version( get_template_directory() . '/assets/css/admin-settings.css', wp_get_theme()->get( 'Version' ) )
	);
	wp_enqueue_media();
	wp_enqueue_script(
		'denkon-mosaic-settings',
		get_template_directory_uri() . '/assets/js/admin-settings.js',
		array( 'jquery' ),
		denkon_mosaic_get_asset_version( get_template_directory() . '/assets/js/admin-settings.js', wp_get_theme()->get( 'Version' ) ),
		true
	);
	wp_localize_script(
		'denkon-mosaic-settings',
		'denkonMosaicSettingsL10n',
		array(
			'mediaTitle'          => __( 'Выберите логотип подвала', 'denkon-mosaic' ),
			'mediaButton'         => __( 'Использовать логотип', 'denkon-mosaic' ),
			'emptyLogo'           => __( 'Не выбран — будет показано название сайта.', 'denkon-mosaic' ),
			'exportPreparing'     => __( 'Готовим ZIP-архив с настройками. Это может занять несколько секунд.', 'denkon-mosaic' ),
			'exportComplete'      => __( 'Экспорт завершён. ZIP-архив с настройками скачан в папку загрузок браузера.', 'denkon-mosaic' ),
			'exportError'         => __( 'Не удалось подготовить ZIP-архив. Обновите страницу и повторите попытку.', 'denkon-mosaic' ),
			'importPreparing'     => __( 'Импортируем настройки. Страница обновится после завершения операции.', 'denkon-mosaic' ),
			'resetConfirm'        => __( 'Сбросить все настройки Denkon Mosaic к значениям по умолчанию? Страницы, меню и файлы не будут удалены.', 'denkon-mosaic' ),
			'resetPreparing'      => __( 'Сбрасываем настройки темы. Страница обновится после завершения операции.', 'denkon-mosaic' ),
			'migrationConfirm'    => __( 'Обновить метаданные всех ранее вставленных секций Denkon Mosaic? Содержимое и дизайн не изменятся, а для изменённых страниц будут созданы ревизии WordPress.', 'denkon-mosaic' ),
			'migrationPreparing'  => __( 'Обновляем метаданные ранее вставленных паттернов. Страница обновится после завершения операции.', 'denkon-mosaic' ),
		)
	);

	/**
	 * Fires after Free-theme assets have been enqueued on its settings screen.
	 *
	 * @param string $hook Current admin page hook.
	 */
	do_action( 'denkon_mosaic_enqueue_settings_assets', $hook );
}
add_action( 'admin_enqueue_scripts', 'denkon_mosaic_enqueue_admin_assets' );

/**
 * Renders an individual settings form field.
 *
 * @param string $name    Setting name.
 * @param string $value   Current value.
 * @param string $label   Human-friendly label.
 * @param string $type    Input type.
 * @param string $help    Supporting text.
 * @return void
 */
function denkon_mosaic_render_setting_field( $name, $value, $label, $type = 'text', $help = '' ) {
	?>
	<label class="denkon-mosaic-admin__field">
		<span class="denkon-mosaic-admin__label"><?php echo esc_html( $label ); ?></span>
		<?php if ( 'textarea' === $type ) : ?>
			<textarea name="settings[<?php echo esc_attr( $name ); ?>]" rows="4"><?php echo esc_textarea( $value ); ?></textarea>
		<?php else : ?>
			<input type="<?php echo esc_attr( $type ); ?>" name="settings[<?php echo esc_attr( $name ); ?>]" value="<?php echo esc_attr( $value ); ?>">
		<?php endif; ?>
		<?php if ( $help ) : ?>
			<span class="denkon-mosaic-admin__help"><?php echo esc_html( $help ); ?></span>
		<?php endif; ?>
	</label>
	<?php
}

/**
 * Renders a HEX field with a supporting native colour swatch.
 *
 * The text field is intentionally the primary control. This gives users a
 * reliable way to paste a HEX value independently from the colour-dialogue
 * implementation of the browser and operating system.
 *
 * @param string $name  Setting name.
 * @param string $value Current colour value.
 * @param string $label Field label.
 * @return void
 */
function denkon_mosaic_render_color_field( $name, $value, $label ) {
	$color_value = denkon_mosaic_get_color_field_value( $value );
	$input_id    = 'denkon-mosaic-color-' . sanitize_html_class( $name );
	?>
	<label class="denkon-mosaic-admin__field denkon-mosaic-admin__field--color">
		<span class="denkon-mosaic-admin__label"><?php echo esc_html( $label ); ?></span>
		<span class="denkon-mosaic-admin__color-control">
			<input id="<?php echo esc_attr( $input_id ); ?>" class="denkon-mosaic-admin__color-hex" type="text" name="settings[<?php echo esc_attr( $name ); ?>]" value="<?php echo esc_attr( $color_value ); ?>" inputmode="text" autocomplete="off" spellcheck="false" maxlength="7" pattern="^#?(?:[A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$" aria-describedby="<?php echo esc_attr( $input_id ); ?>-help" data-denkon-color-hex>
			<input class="denkon-mosaic-admin__color-picker" type="color" value="<?php echo esc_attr( $color_value ); ?>" aria-label="<?php esc_attr_e( 'Выбрать цвет в палитре', 'denkon-mosaic' ); ?>" data-denkon-color-picker>
		</span>
		<span id="<?php echo esc_attr( $input_id ); ?>-help" class="denkon-mosaic-admin__help"><?php esc_html_e( 'Введите HEX: #9A681D или 9A681D. Палитра справа синхронизируется автоматически.', 'denkon-mosaic' ); ?></span>
	</label>
	<?php
}

/**
 * Renders a select field backed by the WordPress Font Library.
 *
 * @param string $name  Setting name.
 * @param string $value Selected choice identifier.
 * @param string $label Field label.
 * @param string $help  Supporting text.
 * @return void
 */
function denkon_mosaic_render_font_family_field( $name, $value, $label, $help = '' ) {
	$choices = denkon_mosaic_get_font_family_choices();
	$value   = denkon_mosaic_sanitize_font_family_choice( $value );
	?>
	<label class="denkon-mosaic-admin__field">
		<span class="denkon-mosaic-admin__label"><?php echo esc_html( $label ); ?></span>
		<select name="settings[<?php echo esc_attr( $name ); ?>]">
			<?php foreach ( $choices as $choice_id => $choice ) : ?>
				<option value="<?php echo esc_attr( $choice_id ); ?>" <?php selected( $value, $choice_id ); ?> style="font-family: <?php echo esc_attr( $choice['font_family'] ); ?>;"><?php echo esc_html( $choice['label'] ); ?></option>
			<?php endforeach; ?>
		</select>
		<?php if ( $help ) : ?>
			<span class="denkon-mosaic-admin__help"><?php echo esc_html( $help ); ?></span>
		<?php endif; ?>
	</label>
	<?php
}

/**
 * Renders the media-library control for the footer logo.
 *
 * @param string $attachment_id Current attachment ID.
 * @return void
 */
function denkon_mosaic_render_footer_logo_field( $attachment_id ) {
	$image_url = $attachment_id ? wp_get_attachment_image_url( absint( $attachment_id ), 'medium' ) : '';
	?>
	<div class="denkon-mosaic-admin__field denkon-mosaic-admin__media-field" data-media-field>
		<span class="denkon-mosaic-admin__label"><?php esc_html_e( 'Логотип подвала', 'denkon-mosaic' ); ?></span>
		<input type="hidden" name="settings[footer_logo_id]" value="<?php echo esc_attr( absint( $attachment_id ) ); ?>">
		<div class="denkon-mosaic-admin__media-preview" data-media-preview>
			<?php if ( $image_url ) : ?>
				<img src="<?php echo esc_url( $image_url ); ?>" alt="">
			<?php else : ?>
				<span><?php esc_html_e( 'Используется логотип из шапки или название сайта.', 'denkon-mosaic' ); ?></span>
			<?php endif; ?>
		</div>
		<p class="denkon-mosaic-admin__media-actions">
			<button type="button" class="button denkon-mosaic-admin__media-select"><?php esc_html_e( 'Выбрать логотип', 'denkon-mosaic' ); ?></button>
			<button type="button" class="button-link-delete denkon-mosaic-admin__media-remove" <?php disabled( ! $image_url ); ?>><?php esc_html_e( 'Удалить', 'denkon-mosaic' ); ?></button>
		</p>
		<span class="denkon-mosaic-admin__help"><?php esc_html_e( 'Если оставить поле пустым, подвал будет использовать логотип из шапки. Если его нет — название сайта.', 'denkon-mosaic' ); ?></span>
	</div>
	<?php
}

/**
 * Displays the settings screen.
 *
 * @return void
 */
function denkon_mosaic_render_settings_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$settings = denkon_mosaic_get_settings();
	$tabs     = array(
		'general' => __( 'Основные настройки', 'denkon-mosaic' ),
		'header'  => __( 'Шапка', 'denkon-mosaic' ),
		'footer'  => __( 'Подвал', 'denkon-mosaic' ),
		'transfer'=> __( 'Импорт и экспорт', 'denkon-mosaic' ),
	);
	/**
	 * Filters tabs on the Denkon Mosaic settings screen.
	 *
	 * External tabs render their own forms through
	 * `denkon_mosaic_render_settings_tab` and must save their own values.
	 *
	 * @param array<string, string> $tabs Settings tabs.
	 */
	$tabs     = apply_filters( 'denkon_mosaic_settings_tabs', $tabs );
	$tab      = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'general';
	$tab      = array_key_exists( $tab, $tabs ) ? $tab : 'general';
	$form_tabs = array( 'general', 'header', 'footer' );
	$edition  = apply_filters( 'denkon_mosaic_settings_edition', __( 'Free', 'denkon-mosaic' ) );
	?>
	<div class="wrap denkon-mosaic-admin">
		<header class="denkon-mosaic-admin__hero">
			<div>
				<span class="denkon-mosaic-admin__eyebrow">Denkon</span>
				<h1><?php esc_html_e( 'Mosaic', 'denkon-mosaic' ); ?></h1>
				<p><?php esc_html_e( 'Настройте внешний вид сайта, шапку и подвал в одном месте.', 'denkon-mosaic' ); ?></p>
			</div>
			<div class="denkon-mosaic-admin__edition">
				<span><?php esc_html_e( 'Текущая редакция', 'denkon-mosaic' ); ?></span>
				<strong><?php echo esc_html( $edition ); ?></strong>
			</div>
		</header>

		<nav class="denkon-mosaic-admin__tabs" aria-label="<?php esc_attr_e( 'Настройки темы', 'denkon-mosaic' ); ?>">
			<?php foreach ( $tabs as $tab_id => $tab_label ) : ?>
				<a class="<?php echo 'general' === $tab_id ? 'is-general ' : ''; ?><?php echo $tab === $tab_id ? 'is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'page' => 'denkon-mosaic', 'tab' => $tab_id ), admin_url( 'themes.php' ) ) ); ?>">
					<?php echo esc_html( $tab_label ); ?>
				</a>
			<?php endforeach; ?>
		</nav>

		<?php if ( isset( $_GET['updated'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Настройки сохранены.', 'denkon-mosaic' ); ?></p></div>
		<?php endif; ?>

		<?php if ( in_array( $tab, $form_tabs, true ) ) : ?>
		<form class="denkon-mosaic-admin__form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
			<input type="hidden" name="action" value="denkon_mosaic_save_settings">
			<input type="hidden" name="tab" value="<?php echo esc_attr( $tab ); ?>">
			<?php wp_nonce_field( 'denkon_mosaic_save_settings' ); ?>
		<?php endif; ?>

			<section class="denkon-mosaic-admin__panel">
				<?php if ( 'general' === $tab ) : ?>
					<div class="denkon-mosaic-admin__panel-heading">
						<h2><?php esc_html_e( 'Оформление сайта', 'denkon-mosaic' ); ?></h2>
						<p><?php esc_html_e( 'Выберите базовую цветовую схему и ширину области, в которой размещается содержимое страниц.', 'denkon-mosaic' ); ?></p>
					</div>
					<section class="denkon-mosaic-admin__setting-group">
						<div class="denkon-mosaic-admin__setting-group-heading">
							<h3><?php esc_html_e( 'Язык шаблона', 'denkon-mosaic' ); ?></h3>
							<p><?php esc_html_e( 'Определяет язык настроек темы, дополнительных инструментов и новых паттернов. Для любых других значений используется English.', 'denkon-mosaic' ); ?></p>
						</div>
						<div class="denkon-mosaic-admin__fields denkon-mosaic-admin__fields--single">
							<label class="denkon-mosaic-admin__field">
								<span class="denkon-mosaic-admin__label"><?php esc_html_e( 'Язык шаблона', 'denkon-mosaic' ); ?></span>
								<select name="settings[interface_language]">
									<option value="en" <?php selected( $settings['interface_language'], 'en' ); ?>><?php esc_html_e( 'Английский', 'denkon-mosaic' ); ?></option>
									<option value="ru" <?php selected( $settings['interface_language'], 'ru' ); ?>><?php esc_html_e( 'Русский', 'denkon-mosaic' ); ?></option>
								</select>
							</label>
						</div>
					</section>
					<div class="denkon-mosaic-admin__schemes">
						<?php foreach ( denkon_mosaic_get_color_schemes() as $scheme_id => $scheme ) : ?>
							<label class="denkon-mosaic-admin__scheme">
								<input type="radio" name="settings[color_scheme]" value="<?php echo esc_attr( $scheme_id ); ?>" <?php checked( $settings['color_scheme'], $scheme_id ); ?>>
								<span class="denkon-mosaic-admin__scheme-preview denkon-mosaic-admin__scheme-preview--<?php echo esc_attr( $scheme_id ); ?>"<?php echo 'custom' === $scheme_id ? ' data-denkon-custom-preview' : ''; ?>></span>
								<strong><?php echo esc_html( $scheme['label'] ); ?></strong>
								<small><?php echo esc_html( $scheme['description'] ); ?></small>
							</label>
						<?php endforeach; ?>
					</div>
					<section class="denkon-mosaic-admin__setting-group denkon-mosaic-admin__custom-scheme" data-denkon-custom-scheme<?php echo 'custom' !== $settings['color_scheme'] ? ' hidden' : ''; ?>>
						<div class="denkon-mosaic-admin__setting-group-heading">
							<h3><?php esc_html_e( 'Цвета произвольной схемы', 'denkon-mosaic' ); ?></h3>
							<p><?php esc_html_e( 'Эти цвета применяются ко всем секциям, кнопкам, карточкам и стандартным элементам темы, когда выбрана схема «Произвольная».', 'denkon-mosaic' ); ?></p>
						</div>
						<div class="denkon-mosaic-admin__fields denkon-mosaic-admin__fields--theme-colors">
							<?php
							$custom_color_labels = array(
								'custom_color_primary'       => __( 'Основной акцент', 'denkon-mosaic' ),
								'custom_color_primary_hover' => __( 'Акцент при наведении', 'denkon-mosaic' ),
								'custom_color_text'          => __( 'Основной текст', 'denkon-mosaic' ),
								'custom_color_muted'         => __( 'Приглушённый текст', 'denkon-mosaic' ),
								'custom_color_background'    => __( 'Фон страницы', 'denkon-mosaic' ),
								'custom_color_surface'       => __( 'Фон карточек', 'denkon-mosaic' ),
								'custom_color_border'        => __( 'Границы', 'denkon-mosaic' ),
							);

							foreach ( denkon_mosaic_get_custom_color_values( $settings ) as $color_key => $color_value ) {
								denkon_mosaic_render_color_field( $color_key, $color_value, $custom_color_labels[ $color_key ] );
							}
							?>
						</div>
					</section>
					<div class="denkon-mosaic-admin__fields denkon-mosaic-admin__fields--single">
						<?php denkon_mosaic_render_setting_field( 'content_width', $settings['content_width'], __( 'Ширина области контента', 'denkon-mosaic' ), 'text', __( 'Укажите значение в пикселях или процентах, например: 1200px, 1200 или 100%.', 'denkon-mosaic' ) ); ?>
					</div>
					<section class="denkon-mosaic-admin__setting-group">
						<div class="denkon-mosaic-admin__setting-group-heading">
							<h3><?php esc_html_e( 'Шрифты по умолчанию', 'denkon-mosaic' ); ?></h3>
							<p><?php esc_html_e( 'Выберите шрифты, установленные в разделе «Внешний вид → Шрифты». Если оставить системный вариант, сайт сохранит текущую типографику темы.', 'denkon-mosaic' ); ?></p>
						</div>
						<div class="denkon-mosaic-admin__fields">
							<?php denkon_mosaic_render_font_family_field( 'heading_font_family', $settings['heading_font_family'], __( 'Заголовки', 'denkon-mosaic' ), __( 'Применяется ко всем заголовкам в шаблоне и добавленным паттернам.', 'denkon-mosaic' ) ); ?>
							<?php denkon_mosaic_render_font_family_field( 'body_font_family', $settings['body_font_family'], __( 'Основной текст', 'denkon-mosaic' ), __( 'Применяется к тексту сайта, навигации и содержимому блоков.', 'denkon-mosaic' ) ); ?>
						</div>
					</section>
				<?php elseif ( 'header' === $tab ) : ?>
					<div class="denkon-mosaic-admin__panel-heading">
						<h2><?php esc_html_e( 'Шапка сайта', 'denkon-mosaic' ); ?></h2>
						<p><?php esc_html_e( 'Здесь можно настроить расположение элементов, цвета и кнопку действия. Логотип задаётся в разделе «Внешний вид → Настроить → Свойства сайта».', 'denkon-mosaic' ); ?></p>
					</div>
					<section class="denkon-mosaic-admin__setting-group">
						<div class="denkon-mosaic-admin__setting-group-heading"><h3><?php esc_html_e( 'Внешний вид шапки', 'denkon-mosaic' ); ?></h3><p><?php esc_html_e( 'Эти настройки действуют только на шапку сайта и не меняют оформление остальных блоков.', 'denkon-mosaic' ); ?></p></div>
						<div class="denkon-mosaic-admin__fields denkon-mosaic-admin__fields--colors">
							<label class="denkon-mosaic-admin__field"><span class="denkon-mosaic-admin__label"><?php esc_html_e( 'Расположение элементов', 'denkon-mosaic' ); ?></span><select name="settings[header_layout]"><option value="standard" <?php selected( $settings['header_layout'], 'standard' ); ?>><?php esc_html_e( 'Логотип слева', 'denkon-mosaic' ); ?></option><option value="centered" <?php selected( $settings['header_layout'], 'centered' ); ?>><?php esc_html_e( 'Логотип по центру', 'denkon-mosaic' ); ?></option></select></label>
							<?php denkon_mosaic_render_color_field( 'header_background', $settings['header_background'], __( 'Фон', 'denkon-mosaic' ) ); ?>
							<?php denkon_mosaic_render_color_field( 'header_text_color', $settings['header_text_color'], __( 'Цвет текста', 'denkon-mosaic' ) ); ?>
							<?php denkon_mosaic_render_color_field( 'header_link_color', $settings['header_link_color'], __( 'Цвет ссылок', 'denkon-mosaic' ) ); ?>
							<?php denkon_mosaic_render_color_field( 'header_link_hover_color', $settings['header_link_hover_color'], __( 'Цвет ссылок при наведении', 'denkon-mosaic' ) ); ?>
						</div>
					</section>
					<section class="denkon-mosaic-admin__setting-group">
						<div class="denkon-mosaic-admin__setting-group-heading"><h3><?php esc_html_e( 'Кнопка в шапке', 'denkon-mosaic' ); ?></h3><p><?php esc_html_e( 'Кнопка отображается рядом с главным меню и помогает направить посетителя к важному действию.', 'denkon-mosaic' ); ?></p></div>
						<div class="denkon-mosaic-admin__fields">
							<?php denkon_mosaic_render_setting_field( 'header_cta_text', $settings['header_cta_text'], __( 'Текст кнопки', 'denkon-mosaic' ) ); ?>
						<?php denkon_mosaic_render_setting_field( 'header_cta_url', $settings['header_cta_url'], __( 'Ссылка кнопки', 'denkon-mosaic' ), 'text', __( 'Можно указать адрес страницы или якорь на этой странице, например #contact.', 'denkon-mosaic' ) ); ?>
						</div>
					</section>
				<?php elseif ( 'footer' === $tab ) : ?>
					<div class="denkon-mosaic-admin__panel-heading">
						<h2><?php esc_html_e( 'Подвал сайта', 'denkon-mosaic' ); ?></h2>
						<p><?php esc_html_e( 'Настройте логотип, цвета и информацию, которая отображается в нижней части каждой страницы.', 'denkon-mosaic' ); ?></p>
					</div>
					<section class="denkon-mosaic-admin__setting-group">
						<div class="denkon-mosaic-admin__setting-group-heading"><h3><?php esc_html_e( 'Логотип', 'denkon-mosaic' ); ?></h3><p><?php esc_html_e( 'При необходимости загрузите отдельный логотип для подвала.', 'denkon-mosaic' ); ?></p></div>
						<?php denkon_mosaic_render_footer_logo_field( $settings['footer_logo_id'] ); ?>
					</section>
					<section class="denkon-mosaic-admin__setting-group">
						<div class="denkon-mosaic-admin__setting-group-heading"><h3><?php esc_html_e( 'Цвета подвала', 'denkon-mosaic' ); ?></h3><p><?php esc_html_e( 'Подберите цвета, которые хорошо читаются на выбранном фоне.', 'denkon-mosaic' ); ?></p></div>
						<div class="denkon-mosaic-admin__fields denkon-mosaic-admin__fields--colors">
							<?php denkon_mosaic_render_color_field( 'footer_background', $settings['footer_background'], __( 'Фон', 'denkon-mosaic' ) ); ?>
							<?php denkon_mosaic_render_color_field( 'footer_text_color', $settings['footer_text_color'], __( 'Цвет текста', 'denkon-mosaic' ) ); ?>
							<?php denkon_mosaic_render_color_field( 'footer_link_color', $settings['footer_link_color'], __( 'Цвет ссылок', 'denkon-mosaic' ) ); ?>
							<?php denkon_mosaic_render_color_field( 'footer_link_hover_color', $settings['footer_link_hover_color'], __( 'Цвет ссылок при наведении', 'denkon-mosaic' ) ); ?>
						</div>
					</section>
					<section class="denkon-mosaic-admin__setting-group">
						<div class="denkon-mosaic-admin__setting-group-heading"><h3><?php esc_html_e( 'Текст и копирайт', 'denkon-mosaic' ); ?></h3><p><?php esc_html_e( 'Добавьте короткое описание и информацию об авторских правах.', 'denkon-mosaic' ); ?></p></div>
						<div class="denkon-mosaic-admin__fields">
						<?php denkon_mosaic_render_setting_field( 'footer_text', $settings['footer_text'], __( 'Краткое описание', 'denkon-mosaic' ), 'textarea', __( 'Например, чем занимается компания или какую пользу получает клиент.', 'denkon-mosaic' ) ); ?>
						<?php denkon_mosaic_render_setting_field( 'footer_copyright', $settings['footer_copyright'], __( 'Копирайт', 'denkon-mosaic' ), 'text', __( 'Если оставить поле пустым, будет показано название сайта и текущий год.', 'denkon-mosaic' ) ); ?>
						</div>
					</section>
				<?php elseif ( 'transfer' === $tab ) : ?>
					<?php denkon_mosaic_render_settings_transfer_panel(); ?>
				<?php else : ?>
					<?php
					/**
					 * Renders an extension-provided settings tab.
					 *
					 * @param string                $tab      Active tab ID.
					 * @param array<string, string> $settings Saved Free-theme settings.
					 */
					do_action( 'denkon_mosaic_render_settings_tab', $tab, $settings );
					?>
				<?php endif; ?>
			</section>

			<?php if ( in_array( $tab, $form_tabs, true ) ) : ?>
			<footer class="denkon-mosaic-admin__form-footer">
				<span><?php esc_html_e( 'Сохраните изменения, чтобы применить их на сайте.', 'denkon-mosaic' ); ?></span>
				<button type="submit" class="button button-primary"><?php esc_html_e( 'Сохранить изменения', 'denkon-mosaic' ); ?></button>
			</footer>
		</form>
			<?php endif; ?>
	</div>
	<?php
}

/**
 * Sanitizes an anchor, relative URL or standard URL for a theme setting.
 *
 * @param mixed $value Raw value.
 * @return string
 */
function denkon_mosaic_sanitize_link( $value ) {
	$value = is_string( $value ) ? trim( wp_unslash( $value ) ) : '';

	if ( '' === $value ) {
		return '';
	}

	if ( 0 === strpos( $value, '#' ) ) {
		return '#' . sanitize_html_class( ltrim( $value, '#' ) );
	}

	if ( 0 === strpos( $value, '/' ) ) {
		return '/' . ltrim( sanitize_text_field( $value ), '/' );
	}

	return esc_url_raw( $value, array( 'http', 'https', 'mailto', 'tel' ) );
}

/**
 * Persists values posted from the theme settings page.
 *
 * @return void
 */
function denkon_mosaic_save_settings() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'Недостаточно прав для изменения настроек темы.', 'denkon-mosaic' ) );
	}

	check_admin_referer( 'denkon_mosaic_save_settings' );

	$posted   = isset( $_POST['settings'] ) && is_array( $_POST['settings'] ) ? wp_unslash( $_POST['settings'] ) : array();
	$defaults = denkon_mosaic_get_default_settings();
	$settings = denkon_mosaic_get_settings();
	$tabs     = array( 'general', 'header', 'footer' );
	$tab      = isset( $_POST['tab'] ) ? sanitize_key( wp_unslash( $_POST['tab'] ) ) : 'general';
	$tab      = in_array( $tab, $tabs, true ) ? $tab : 'general';

	/*
	 * The form on each tab deliberately sends only its own fields. Preserve
	 * saved values from all other tabs instead of filling missing fields with
	 * defaults and overwriting them.
	 */
	if ( 'general' === $tab ) {
		$schemes = denkon_mosaic_get_color_schemes();
		$scheme  = isset( $posted['color_scheme'] ) ? sanitize_key( $posted['color_scheme'] ) : $settings['color_scheme'];
		$language = isset( $posted['interface_language'] ) && 'ru' === sanitize_key( $posted['interface_language'] ) ? 'ru' : 'en';

		$settings['interface_language'] = $language;
		$settings['color_scheme']  = array_key_exists( $scheme, $schemes ) ? $scheme : $defaults['color_scheme'];
		$settings['content_width'] = isset( $posted['content_width'] ) ? denkon_mosaic_sanitize_content_width( $posted['content_width'] ) : $settings['content_width'];
		$settings['heading_font_family'] = isset( $posted['heading_font_family'] ) ? denkon_mosaic_sanitize_font_family_choice( $posted['heading_font_family'] ) : '';
		$settings['body_font_family']    = isset( $posted['body_font_family'] ) ? denkon_mosaic_sanitize_font_family_choice( $posted['body_font_family'] ) : '';

		foreach ( array( 'header_cta_text', 'footer_text' ) as $default_text_key ) {
			$settings[ $default_text_key ] = denkon_mosaic_translate_to_language( $settings[ $default_text_key ], $language );
		}

		foreach ( denkon_mosaic_get_custom_color_defaults() as $color_key => $fallback ) {
			$settings[ $color_key ] = isset( $posted[ $color_key ] )
				? denkon_mosaic_sanitize_color( $posted[ $color_key ], $fallback )
				: denkon_mosaic_sanitize_color( isset( $settings[ $color_key ] ) ? $settings[ $color_key ] : '', $fallback );
		}
	}

	if ( 'header' === $tab ) {
		$layout = isset( $posted['header_layout'] ) ? sanitize_key( $posted['header_layout'] ) : $settings['header_layout'];

		$settings['header_layout']   = in_array( $layout, array( 'standard', 'centered' ), true ) ? $layout : $defaults['header_layout'];
		$settings['header_cta_text'] = isset( $posted['header_cta_text'] ) ? sanitize_text_field( $posted['header_cta_text'] ) : $settings['header_cta_text'];
		$settings['header_cta_url']  = isset( $posted['header_cta_url'] ) ? denkon_mosaic_sanitize_link( $posted['header_cta_url'] ) : $settings['header_cta_url'];
		$settings['header_background']      = isset( $posted['header_background'] ) ? denkon_mosaic_sanitize_color( $posted['header_background'], $defaults['header_background'] ) : $settings['header_background'];
		$settings['header_text_color']      = isset( $posted['header_text_color'] ) ? denkon_mosaic_sanitize_color( $posted['header_text_color'], $defaults['header_text_color'] ) : $settings['header_text_color'];
		$settings['header_link_color']      = isset( $posted['header_link_color'] ) ? denkon_mosaic_sanitize_color( $posted['header_link_color'], $defaults['header_link_color'] ) : $settings['header_link_color'];
		$settings['header_link_hover_color'] = isset( $posted['header_link_hover_color'] ) ? denkon_mosaic_sanitize_color( $posted['header_link_hover_color'], $defaults['header_link_hover_color'] ) : $settings['header_link_hover_color'];
	}

	if ( 'footer' === $tab ) {
		$settings['footer_text']      = isset( $posted['footer_text'] ) ? sanitize_textarea_field( $posted['footer_text'] ) : $settings['footer_text'];
		$settings['footer_copyright'] = isset( $posted['footer_copyright'] ) ? sanitize_text_field( $posted['footer_copyright'] ) : $settings['footer_copyright'];
		$settings['footer_logo_id']          = isset( $posted['footer_logo_id'] ) ? (string) absint( $posted['footer_logo_id'] ) : $settings['footer_logo_id'];
		$settings['footer_background']       = isset( $posted['footer_background'] ) ? denkon_mosaic_sanitize_color( $posted['footer_background'], $defaults['footer_background'] ) : $settings['footer_background'];
		$settings['footer_text_color']       = isset( $posted['footer_text_color'] ) ? denkon_mosaic_sanitize_color( $posted['footer_text_color'], $defaults['footer_text_color'] ) : $settings['footer_text_color'];
		$settings['footer_link_color']       = isset( $posted['footer_link_color'] ) ? denkon_mosaic_sanitize_color( $posted['footer_link_color'], $defaults['footer_link_color'] ) : $settings['footer_link_color'];
		$settings['footer_link_hover_color'] = isset( $posted['footer_link_hover_color'] ) ? denkon_mosaic_sanitize_color( $posted['footer_link_hover_color'], $defaults['footer_link_hover_color'] ) : $settings['footer_link_hover_color'];
	}

	update_option( denkon_mosaic_settings_option_key(), $settings );

	wp_safe_redirect( add_query_arg( array( 'page' => 'denkon-mosaic', 'tab' => $tab, 'updated' => '1' ), admin_url( 'themes.php' ) ) );
	exit;
}
add_action( 'admin_post_denkon_mosaic_save_settings', 'denkon_mosaic_save_settings' );
