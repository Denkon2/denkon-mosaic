<?php
/**
 * Child theme generator for Appearance > Themes.
 *
 * @package DenkonMosaic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_post_denkon_mosaic_create_child_theme', 'denkon_mosaic_handle_create_child_theme' );
add_action( 'admin_notices', 'denkon_mosaic_render_child_theme_notice' );
add_filter( 'theme_action_links_denkon-mosaic', 'denkon_mosaic_filter_theme_card_actions', 10, 3 );
add_filter( 'wp_prepare_themes_for_js', 'denkon_mosaic_filter_prepared_themes_for_js' );

/**
 * Gets the stylesheet folder name reserved for the generated child theme.
 *
 * @return string
 */
function denkon_mosaic_get_child_theme_stylesheet() {
	return 'denkon-mosaic-child';
}

/**
 * Gets the expected absolute child theme directory.
 *
 * @return string
 */
function denkon_mosaic_get_child_theme_directory() {
	return trailingslashit( dirname( get_template_directory() ) ) . denkon_mosaic_get_child_theme_stylesheet();
}

/**
 * Gets the availability state of the generated child theme.
 *
 * @return array<string, mixed>
 */
function denkon_mosaic_get_child_theme_state() {
	$stylesheet  = denkon_mosaic_get_child_theme_stylesheet();
	$directory   = denkon_mosaic_get_child_theme_directory();
	$theme_root  = dirname( get_template_directory() );
	$theme       = wp_get_theme( $stylesheet );
	$is_active   = get_stylesheet() === $stylesheet;
	$is_existing = $theme instanceof WP_Theme && $theme->exists();

	if ( $is_existing ) {
		if ( 'denkon-mosaic' !== $theme->get_template() ) {
			return array(
				'status' => 'conflict',
				'label'  => __( 'Папка дочерней темы уже занята', 'denkon-mosaic' ),
			);
		}

		return array(
			'status' => $is_active ? 'active' : 'exists',
			'label'  => $is_active
				? __( 'Дочерняя тема активна', 'denkon-mosaic' )
				: __( 'Дочерняя тема уже создана', 'denkon-mosaic' ),
		);
	}

	if ( file_exists( $directory ) ) {
		return array(
			'status' => 'conflict',
			'label'  => __( 'Папка дочерней темы уже существует', 'denkon-mosaic' ),
		);
	}

	if ( ! is_dir( $theme_root ) || ! wp_is_writable( $theme_root ) ) {
		return array(
			'status' => 'readonly',
			'label'  => __( 'Каталог тем недоступен для записи', 'denkon-mosaic' ),
		);
	}

	return array(
		'status' => 'ready',
		'label'  => __( 'Можно создать дочернюю тему', 'denkon-mosaic' ),
	);
}

/**
 * Gets protected action URLs for child theme management.
 *
 * @return array<string, string>
 */
function denkon_mosaic_get_child_theme_action_urls() {
	$stylesheet = denkon_mosaic_get_child_theme_stylesheet();

	return array(
		'create'   => wp_nonce_url(
			admin_url( 'admin-post.php?action=denkon_mosaic_create_child_theme' ),
			'denkon_mosaic_create_child_theme'
		),
		'activate' => wp_nonce_url(
			admin_url( 'themes.php?action=activate&stylesheet=' . rawurlencode( $stylesheet ) ),
			'switch-theme_' . $stylesheet
		),
	);
}

/**
 * Renders the child-theme helper below the parent theme description.
 *
 * @return string
 */
function denkon_mosaic_get_child_theme_prompt_html() {
	if ( ! current_user_can( 'switch_themes' ) ) {
		return '';
	}

	$state   = denkon_mosaic_get_child_theme_state();
	$urls    = denkon_mosaic_get_child_theme_action_urls();
	$message = __( 'Для безопасных доработок создайте дочернюю тему: обновления родительской темы не затронут ваши изменения.', 'denkon-mosaic' );
	$html    = '<div class="denkon-mosaic-child-prompt">';
	$html   .= '<p>' . esc_html( $message ) . '</p>';

	if ( 'ready' === $state['status'] ) {
		$html .= '<p><a class="button button-primary" href="' . esc_url( $urls['create'] ) . '">' . esc_html__( 'Создать дочернюю тему', 'denkon-mosaic' ) . '</a></p>';
	} elseif ( 'exists' === $state['status'] ) {
		$html .= '<p>' . esc_html__( 'Дочерняя тема создана и готова к активации.', 'denkon-mosaic' ) . '</p>';
		$html .= '<p><a class="button button-primary" href="' . esc_url( $urls['activate'] ) . '">' . esc_html__( 'Активировать дочернюю тему', 'denkon-mosaic' ) . '</a></p>';
	} elseif ( 'active' === $state['status'] ) {
		$html .= '<p>' . esc_html__( 'Сейчас активна дочерняя тема.', 'denkon-mosaic' ) . '</p>';
	} else {
		$html .= '<p>' . esc_html( $state['label'] ) . '</p>';
	}

	$html .= '</div>';

	return $html;
}

/**
 * Adds a contextual action to the parent theme card.
 *
 * @param array<string, string> $actions Theme action links.
 * @param WP_Theme              $theme   Theme object.
 * @param string                $context Current rendering context.
 * @return array<string, string>
 */
function denkon_mosaic_filter_theme_card_actions( $actions, $theme, $context ) {
	if ( ! current_user_can( 'switch_themes' ) ) {
		return $actions;
	}

	$state = denkon_mosaic_get_child_theme_state();
	$urls  = denkon_mosaic_get_child_theme_action_urls();

	if ( 'ready' === $state['status'] ) {
		$actions['denkon-mosaic-child'] = '<a href="' . esc_url( $urls['create'] ) . '">' . esc_html__( 'Создать дочернюю тему', 'denkon-mosaic' ) . '</a>';
	} elseif ( 'exists' === $state['status'] ) {
		$actions['denkon-mosaic-child'] = '<a href="' . esc_url( $urls['activate'] ) . '">' . esc_html__( 'Активировать дочернюю тему', 'denkon-mosaic' ) . '</a>';
	} elseif ( 'active' === $state['status'] ) {
		$actions['denkon-mosaic-child'] = '<span>' . esc_html__( 'Дочерняя тема активна', 'denkon-mosaic' ) . '</span>';
	}

	return $actions;
}

/**
 * Adds the same helper to the JavaScript-rendered theme details modal.
 *
 * @param array<string, array<string, mixed>> $themes Prepared theme data.
 * @return array<string, array<string, mixed>>
 */
function denkon_mosaic_filter_prepared_themes_for_js( $themes ) {
	if ( ! is_array( $themes ) || ! isset( $themes['denkon-mosaic'] ) ) {
		return $themes;
	}

	$themes['denkon-mosaic']['description'] .= denkon_mosaic_get_child_theme_prompt_html();

	return $themes;
}

/**
 * Gets the parent preview image intended for the generated child theme.
 *
 * @return string
 */
function denkon_mosaic_get_child_theme_screenshot_source() {
	$preferred = trailingslashit( get_template_directory() ) . 'screenshot-shild.png';

	if ( file_exists( $preferred ) ) {
		return $preferred;
	}

	$fallback = trailingslashit( get_template_directory() ) . 'screenshot.png';

	return file_exists( $fallback ) ? $fallback : '';
}

/**
 * Creates the child theme scaffold without activating it.
 *
 * @return string|WP_Error Child stylesheet or an error.
 */
function denkon_mosaic_create_child_theme_files() {
	$state = denkon_mosaic_get_child_theme_state();

	if ( in_array( $state['status'], array( 'active', 'exists' ), true ) ) {
		return denkon_mosaic_get_child_theme_stylesheet();
	}

	if ( 'ready' !== $state['status'] ) {
		return new WP_Error( 'denkon_mosaic_child_theme_unavailable', __( 'Не удалось создать дочернюю тему. Проверьте доступ к каталогу themes и имя папки.', 'denkon-mosaic' ) );
	}

	$stylesheet   = denkon_mosaic_get_child_theme_stylesheet();
	$child_dir    = denkon_mosaic_get_child_theme_directory();
	$assets_dir   = trailingslashit( $child_dir ) . 'assets';
	$less_dir     = trailingslashit( $assets_dir ) . 'less';
	$less_global  = trailingslashit( $less_dir ) . 'global';
	$css_dir      = trailingslashit( $assets_dir ) . 'css';
	$parent_theme = wp_get_theme( get_template() );
	$author       = $parent_theme instanceof WP_Theme ? $parent_theme->get( 'Author' ) : '';

	foreach ( array( $child_dir, $assets_dir, $less_dir, $less_global, $css_dir ) as $directory ) {
		if ( ! wp_mkdir_p( $directory ) ) {
			return new WP_Error( 'denkon_mosaic_child_theme_dir_failed', __( 'Не удалось создать структуру папок дочерней темы.', 'denkon-mosaic' ) );
		}
	}

	$style_header  = "/*\n";
	$style_header .= "Theme Name: Denkon Mosaic Child\n";
	$style_header .= "Template: denkon-mosaic\n";
	$style_header .= "Text Domain: denkon-mosaic-child\n";
	$style_header .= "Version: 1.0.0\n";
	$style_header .= "Description: Дочерняя тема для безопасной кастомизации Denkon Mosaic.\n";
	$style_header .= "Requires at least: 6.4\n";
	$style_header .= "Requires PHP: 7.4\n";

	if ( $author ) {
		$style_header .= 'Author: ' . wp_strip_all_tags( $author ) . "\n";
	}

	$style_header .= "*/\n\n";
	$style_header .= "/* Добавляйте здесь небольшие CSS-переопределения дочерней темы. */\n";

	$style_less  = "// out: \"../css/style.css\", compress: true, sourceMap: false\n\n";
	$style_less .= "@import \"./global/variables.less\";\n";
	$style_less .= "@import \"./global/base.less\";\n";
	$variables   = "// main: \"../style.less\"\n\n";
	$variables  .= "// Переопределения переменных дочерней темы.\n";
	$base        = "// main: \"../style.less\"\n\n";
	$base       .= "// Локальные стили дочерней темы.\n";
	$functions   = "<?php\n";
	$functions  .= "/**\n * Bootstrap for Denkon Mosaic Child.\n */\n\n";
	$functions  .= "if ( ! defined( 'ABSPATH' ) ) {\n\texit;\n}\n";

	$files = array(
		trailingslashit( $child_dir ) . 'style.css'        => $style_header,
		trailingslashit( $child_dir ) . 'functions.php'    => $functions,
		trailingslashit( $less_dir ) . 'style.less'        => $style_less,
		trailingslashit( $less_global ) . 'variables.less' => $variables,
		trailingslashit( $less_global ) . 'base.less'      => $base,
		trailingslashit( $css_dir ) . 'style.css'          => "/* Скомпилированные стили дочерней темы. */\n",
	);

	foreach ( $files as $path => $contents ) {
		if ( false === file_put_contents( $path, $contents ) ) {
			return new WP_Error( 'denkon_mosaic_child_theme_file_failed', __( 'Не удалось записать файлы дочерней темы.', 'denkon-mosaic' ) );
		}
	}

	$screenshot_source = denkon_mosaic_get_child_theme_screenshot_source();

	if ( $screenshot_source && ! copy( $screenshot_source, trailingslashit( $child_dir ) . 'screenshot.png' ) ) {
		return new WP_Error( 'denkon_mosaic_child_theme_screenshot_failed', __( 'Не удалось скопировать превью дочерней темы.', 'denkon-mosaic' ) );
	}

	wp_clean_themes_cache( true );

	return $stylesheet;
}

/**
 * Handles a protected child theme creation request.
 *
 * @return void
 */
function denkon_mosaic_handle_create_child_theme() {
	if ( ! current_user_can( 'switch_themes' ) ) {
		wp_die( esc_html__( 'Недостаточно прав для создания дочерней темы.', 'denkon-mosaic' ) );
	}

	check_admin_referer( 'denkon_mosaic_create_child_theme' );

	$result   = denkon_mosaic_create_child_theme_files();
	$redirect = admin_url( 'themes.php' );

	if ( is_wp_error( $result ) ) {
		$redirect = add_query_arg(
			array(
				'denkon_mosaic_child_notice'  => 'error',
				'denkon_mosaic_child_message' => $result->get_error_message(),
			),
			$redirect
		);
	} else {
		$redirect = add_query_arg( 'denkon_mosaic_child_notice', 'created', $redirect );
	}

	wp_safe_redirect( $redirect );
	exit;
}

/**
 * Shows result notices on Appearance > Themes.
 *
 * @return void
 */
function denkon_mosaic_render_child_theme_notice() {
	global $pagenow;

	if ( 'themes.php' !== $pagenow || empty( $_GET['denkon_mosaic_child_notice'] ) ) {
		return;
	}

	$notice = sanitize_key( wp_unslash( $_GET['denkon_mosaic_child_notice'] ) );
	$urls   = denkon_mosaic_get_child_theme_action_urls();

	if ( 'created' === $notice ) {
		?>
		<div class="notice notice-success is-dismissible">
			<p><?php esc_html_e( 'Дочерняя тема создана. Активируйте её перед дальнейшими доработками.', 'denkon-mosaic' ); ?></p>
			<p><a class="button button-primary" href="<?php echo esc_url( $urls['activate'] ); ?>"><?php esc_html_e( 'Активировать дочернюю тему', 'denkon-mosaic' ); ?></a></p>
		</div>
		<?php
		return;
	}

	if ( 'error' === $notice ) {
		$message = ! empty( $_GET['denkon_mosaic_child_message'] ) ? sanitize_text_field( wp_unslash( $_GET['denkon_mosaic_child_message'] ) ) : __( 'Не удалось создать дочернюю тему.', 'denkon-mosaic' );
		?>
		<div class="notice notice-error is-dismissible"><p><?php echo esc_html( $message ); ?></p></div>
		<?php
	}
}
