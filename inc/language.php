<?php
/**
 * Denkon Mosaic interface language and built-in English catalogue.
 *
 * @package DenkonMosaic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gets the language selected in Denkon Mosaic settings.
 *
 * English is the deliberate fallback for every unknown value, including a
 * site locale that is neither Russian nor English.
 *
 * @return string `ru` or `en`.
 */
function denkon_mosaic_get_interface_language() {
	$settings = get_option( denkon_mosaic_settings_option_key(), array() );
	$language = is_array( $settings ) && isset( $settings['interface_language'] ) ? sanitize_key( $settings['interface_language'] ) : 'en';

	return 'ru' === $language ? 'ru' : 'en';
}

/**
 * Returns the catalogue used by the Free theme and its Pro extension.
 *
 * Content is intentionally stored here instead of in an external service:
 * pattern registration also runs on local installations without network
 * access, and the resulting patterns must remain portable.
 *
 * @return array<string, string>
 */
function denkon_mosaic_get_english_catalogue() {
	static $catalogue = null;

	if ( null !== $catalogue ) {
		return $catalogue;
	}

	$catalogue = array(
		// Theme settings and reusable interface labels.
		'Основные настройки' => 'General settings',
		'Шапка' => 'Header',
		'Подвал' => 'Footer',
		'Импорт и экспорт' => 'Import & export',
		'Возможности Pro' => 'Pro features',
		'Настройки сохранены.' => 'Settings saved.',
		'Настройте внешний вид сайта, шапку и подвал в одном месте.' => 'Configure the site appearance, header and footer in one place.',
		'Текущая редакция' => 'Current edition',
		'Настройки темы' => 'Theme settings',
		'Оформление сайта' => 'Site appearance',
		'Выберите базовую цветовую схему и ширину области, в которой размещается содержимое страниц.' => 'Choose the base colour scheme and the width of the page content area.',
		'Язык шаблона' => 'Template language',
		'Определяет язык настроек темы, Pro-инструментов и новых паттернов. Для любых других значений используется English.' => 'Sets the language of theme settings, Pro tools and newly inserted patterns. English is used for all other values.',
		'Русский' => 'Russian',
		'Английский' => 'English',
		'По умолчанию' => 'Default',
		'Фирменная светлая схема: графитовая основа и золотой акцент.' => 'Signature light scheme with a graphite base and golden accent.',
		'Терракота и охра' => 'Terracotta & ochre',
		'Тёплая контрастная схема с терракотовыми акцентами и охристым фоном.' => 'A warm contrasting scheme with terracotta accents and an ochre background.',
		'Тёмная' => 'Dark',
		'Контрастная ночная версия для выразительных проектов.' => 'A high-contrast dark variant for bold projects.',
		'Произвольная' => 'Custom',
		'Собственная палитра: настройте цвета сайта под бренд.' => 'Your own palette: match the site colours to the brand.',
		'Цвета произвольной схемы' => 'Custom scheme colours',
		'Эти цвета применяются ко всем секциям, кнопкам, карточкам и стандартным элементам темы, когда выбрана схема «Произвольная».' => 'These colours apply to all sections, buttons, cards and standard theme elements when the “Custom” scheme is selected.',
		'Основной акцент' => 'Primary accent',
		'Акцент при наведении' => 'Accent hover state',
		'Основной текст' => 'Primary text',
		'Приглушённый текст' => 'Muted text',
		'Фон страницы' => 'Page background',
		'Фон карточек' => 'Card background',
		'Границы' => 'Borders',
		'Ширина области контента' => 'Content area width',
		'Укажите значение в пикселях или процентах, например: 1200px, 1200 или 100%.' => 'Enter a value in pixels or percent, for example: 1200px, 1200 or 100%.',
		'Шрифты по умолчанию' => 'Default fonts',
		'Выберите шрифты, установленные в разделе «Внешний вид → Шрифты». Если оставить системный вариант, сайт сохранит текущую типографику темы.' => 'Choose fonts installed under Appearance → Fonts. Leave the system option selected to keep the current theme typography.',
		'Заголовки' => 'Headings',
		'Применяется ко всем заголовкам в шаблоне и добавленным паттернам.' => 'Applied to every heading in the theme and newly inserted patterns.',
		'Применяется к тексту сайта, навигации и содержимому блоков.' => 'Applied to site text, navigation and block content.',
		'Системный шрифт темы' => 'Theme system font',
		'Шапка сайта' => 'Site header',
		'Здесь можно настроить расположение элементов, цвета и кнопку действия. Логотип задаётся в разделе «Внешний вид → Настроить → Свойства сайта».' => 'Configure element placement, colours and the call-to-action button here. Set the logo under Appearance → Customize → Site Identity.',
		'Внешний вид шапки' => 'Header appearance',
		'Эти настройки действуют только на шапку сайта и не меняют оформление остальных блоков.' => 'These settings apply only to the site header and do not affect other blocks.',
		'Расположение элементов' => 'Element placement',
		'Логотип слева' => 'Logo on the left',
		'Логотип по центру' => 'Centered logo',
		'Фон' => 'Background',
		'Цвет текста' => 'Text colour',
		'Цвет ссылок' => 'Link colour',
		'Цвет ссылок при наведении' => 'Link hover colour',
		'Кнопка в шапке' => 'Header button',
		'Кнопка отображается рядом с главным меню и помогает направить посетителя к важному действию.' => 'The button appears next to the main menu and guides visitors to an important action.',
		'Текст кнопки' => 'Button text',
		'Начать' => 'Get started',
		'Ссылка кнопки' => 'Button link',
		'Можно указать адрес страницы или якорь на этой странице, например #contact.' => 'Enter a page URL or an anchor on this page, for example #contact.',
		'Подвал сайта' => 'Site footer',
		'Настройте логотип, цвета и информацию, которая отображается в нижней части каждой страницы.' => 'Configure the logo, colours and information displayed at the bottom of every page.',
		'Логотип' => 'Logo',
		'При необходимости загрузите отдельный логотип для подвала.' => 'Upload a separate footer logo when needed.',
		'Цвета подвала' => 'Footer colours',
		'Подберите цвета, которые хорошо читаются на выбранном фоне.' => 'Choose colours that remain readable against the selected background.',
		'Текст и копирайт' => 'Text & copyright',
		'Добавьте короткое описание и информацию об авторских правах.' => 'Add a short description and copyright information.',
		'Краткое описание' => 'Short description',
		'Например, чем занимается компания или какую пользу получает клиент.' => 'For example, what the company does or the benefit a client receives.',
		'Копирайт' => 'Copyright',
		'Если оставить поле пустым, будет показано название сайта и текущий год.' => 'Leave this field empty to show the site name and current year.',
		'Сохраните изменения, чтобы применить их на сайте.' => 'Save changes to apply them on the site.',
		'Сохранить изменения' => 'Save changes',
		'Выбрать цвет в палитре' => 'Choose a colour from the palette',
		'Введите HEX: #9A681D или 9A681D. Палитра справа синхронизируется автоматически.' => 'Enter HEX: #9A681D or 9A681D. The palette on the right syncs automatically.',
		'Открыть меню' => 'Open menu',
		'Главная навигация' => 'Primary navigation',
		'Навигация в подвале' => 'Footer navigation',
		'Главное меню' => 'Primary menu',
		'Меню в подвале' => 'Footer menu',
		'Записей пока нет.' => 'No posts yet.',
		'Выбрать версию' => 'Choose a version',
		'Премиальный WordPress-шаблон для услуг, компаний и экспертов.' => 'A premium WordPress theme for services, companies and experts.',

		// Free pattern names, descriptions and content.
		'Первый экран с оффером и изображением' => 'Hero with offer and image',
		'Первый экран с заголовком, описанием, кнопками, преимуществами и необязательным изображением справа.' => 'A first screen with a heading, description, buttons, benefits and an optional image on the right.',
		'Преимущества в карточках' => 'Benefits in cards',
		'Секция с карточками преимуществ, в которые можно загрузить SVG-иконки или изображения.' => 'A benefit-card section where you can upload SVG icons or images.',
		'Секция FAQ с вопросами и раскрывающимися ответами для услуг, продукта или компании.' => 'An FAQ section with questions and expandable answers for a service, product or company.',
		'Преимущества: иконки слева' => 'Benefits: icons on the left',
		'Четыре этапа работы' => 'Four work stages',
		'Этапы: карточки в две колонки' => 'Stages: two-column cards',
		'Ответы на частые вопросы' => 'Frequently asked questions',
		'FAQ с изображением' => 'FAQ with image',
		'Галерея из шести изображений' => 'Six-image gallery',
		'О компании с изображением' => 'About the company with image',
		'Логотипы клиентов и партнёров' => 'Client and partner logos',
		'Отзывы клиентов' => 'Client testimonials',
		'Текст и форма в двух колонках' => 'Text and form in two columns',
		'WordPress-шаблон для быстрого и уверенного старта' => 'A WordPress theme for a fast, confident start',
		'Создавайте страницы услуг, лендинги и корпоративные сайты из готовых Gutenberg-паттернов — без долгой подготовки дизайна и вёрстки.' => 'Create service pages, landing pages and corporate websites with ready-made Gutenberg patterns — without lengthy design and development preparation.',
		'Единый стиль для всех ключевых страниц.' => 'A consistent style for every key page.',
		'Настройки внешнего вида в одном месте.' => 'Appearance settings in one place.',
		'Free для старта и Pro для роста проекта.' => 'Free to start and Pro to grow the project.',
		'Смотреть возможности' => 'Explore features',
		'Готовые паттерны' => 'Ready-made patterns',
		'Настройки темы' => 'Theme settings',
		'Расширение Pro' => 'Pro extension',
		'Замените изображение первого экрана' => 'Replace the hero image',
		'ПОЧЕМУ DENKON MOSAIC' => 'WHY DENKON MOSAIC',
		'Готовая система вместо набора разрозненных блоков' => 'A complete system instead of disconnected blocks',
		'Шаблон помогает быстрее собрать убедительный сайт и оставляет свободу для вашего контента и бренда.' => 'The theme helps you build a convincing site faster while leaving room for your content and brand.',
		'Иконка готовых секций' => 'Ready section icon',
		'Готовые секции' => 'Ready sections',
		'Собирайте страницы из Hero, карточек, галерей, отзывов, FAQ и формы без ручной вёрстки.' => 'Build pages with Hero blocks, cards, galleries, testimonials, FAQ and forms without manual coding.',
		'Иконка визуальных настроек' => 'Appearance settings icon',
		'Единый стиль' => 'Unified style',
		'Цветовая схема, ширина контента, шапка и подвал настраиваются из одной панели.' => 'The colour scheme, content width, header and footer are configured from one panel.',
		'Иконка расширения возможностей' => 'Feature expansion icon',
		'Запас для роста' => 'Room to grow',
		'Начните с Free, а для сложных сценариев подключите Pro-карусели и макеты страниц.' => 'Start with Free and add Pro carousels and page layouts for more advanced scenarios.',
		'Всё важное о Denkon Mosaic' => 'Everything important about Denkon Mosaic',
		'Коротко о запуске, редактировании и развитии сайта на шаблоне.' => 'A quick guide to launching, editing and growing a site with the theme.',
		'Нужно ли знать код, чтобы редактировать сайт?' => 'Do I need to know code to edit the site?',
		'Нет. Паттерны собраны из стандартных Gutenberg-блоков: меняйте тексты, изображения, ссылки, отступы и цвета прямо в редакторе.' => 'No. Patterns use standard Gutenberg blocks: edit text, images, links, spacing and colours directly in the editor.',
		'Можно ли собрать несколько однотипных страниц?' => 'Can I build several similar pages?',
		'Да. В Pro создайте макет содержимого, выберите его при редактировании страницы и скопируйте блоки как независимую основу.' => 'Yes. In Pro, create a content layout, select it while editing a page and copy its blocks as an independent starting point.',
		'Что даёт Pro-версия?' => 'What does Pro include?',
		'Pro добавляет Hero- и отзывы-карусели, расширенные галереи с Fancybox, а также управляемые макеты шапки, подвала и содержимого.' => 'Pro adds Hero and testimonial carousels, enhanced Fancybox galleries, and manageable header, footer and content layouts.',

		// Pro pattern and block-editor interface.
		'Hero-карусель из трёх слайдов' => 'Three-slide Hero carousel',
		'Первый экран с тремя слайдами, настройками анимации, навигации, фона и адаптивной высоты.' => 'A first screen with three slides, animation, navigation, background and responsive-height settings.',
		'Отзывы-карусель' => 'Testimonials carousel',
		'Отзыв в карусели' => 'Carousel testimonial',
		'Отзывы клиентов' => 'Client testimonials',
		'Настройки отзывов' => 'Testimonial settings',
		'Элементов на ПК' => 'Items on desktop',
		'Элементов на планшете' => 'Items on tablet',
		'Элементов на мобильном' => 'Items on mobile',
		'Стрелки' => 'Arrows',
		'Точки' => 'Dots',
		'Зациклить' => 'Loop',
		'Автопрокрутка' => 'Autoplay',
		'Работать было легко: получили понятный процесс и результат, который можно развивать дальше.' => 'Working together was easy: we got a clear process and a result that can grow further.',
		'Основные предложения' => 'Key offers',
		'Ваше направление' => 'YOUR DIRECTION',
		'Ясная история о вашем продукте' => 'A clear story about your product',
		'Расскажите о главной пользе и помогите посетителю сделать следующий шаг.' => 'Explain the core benefit and help the visitor take the next step.',
		'Обсудить проект' => 'Discuss the project',
		'Выберите фоновое изображение' => 'Choose a background image',
		'Использовать изображение' => 'Use image',
		'Настройки карусели' => 'Carousel settings',
		'Задержка автопрокрутки, мс' => 'Autoplay delay, ms',
		'Скорость анимации, мс' => 'Animation speed, ms',
		'Зацикливать слайды' => 'Loop slides',
		'Стрелки навигации' => 'Navigation arrows',
		'Точки навигации' => 'Navigation dots',
		'Останавливать при наведении' => 'Pause on hover',
		'Подстраивать высоту под слайд' => 'Adapt height to slide',
		'Тип перехода' => 'Transition type',
		'Горизонтальный' => 'Horizontal',
		'Растворение (fade)' => 'Fade',
		'Вертикальный переход' => 'Vertical transition',
		'Произвольная Animate.css' => 'Custom Animate.css',
		'Класс появления' => 'Entrance class',
		'Класс исчезновения' => 'Exit class',
		'Например: zoomIn, slideInRight или fadeInUp.' => 'For example: zoomIn, slideInRight or fadeInUp.',
		'Например: zoomOut, slideOutLeft или fadeOutDown.' => 'For example: zoomOut, slideOutLeft or fadeOutDown.',
		'Подпись для скринридера' => 'Screen-reader label',
		'Оформление Hero' => 'Hero appearance',
		'Настройки применяются только к этой Hero-карусели. Очистите цвет или укажите 0, чтобы вернуть стиль шаблона.' => 'These settings apply only to this Hero carousel. Clear the colour or enter 0 to restore the pattern style.',
		'Фон секции' => 'Section background',
		'Фоновое изображение' => 'Background image',
		'Заменить изображение' => 'Replace image',
		'Удалить изображение' => 'Remove image',
		'Градиент поверх фона' => 'Background overlay gradient',
		'Непрозрачность градиента, %' => 'Gradient opacity, %',
		'Чем меньше значение, тем лучше видно фоновое изображение.' => 'The lower the value, the more visible the background image is.',
		'Тип градиента' => 'Gradient type',
		'Линейный' => 'Linear',
		'Радиальный' => 'Radial',
		'Направление градиента' => 'Gradient direction',
		'Сверху вниз' => 'Top to bottom',
		'Слева направо' => 'Left to right',
		'По диагонали вправо' => 'Diagonal to the right',
		'По диагонали влево' => 'Diagonal to the left',
		'Цвет основного текста' => 'Main text colour',
		'Адаптивные размеры' => 'Responsive dimensions',
		'Задайте размеры для ПК. Значение 0 на планшете или мобильном унаследует размер предыдущего экрана.' => 'Set dimensions for desktop. A value of 0 on tablet or mobile inherits the previous breakpoint.',
		'Минимальная высота — ПК, px' => 'Minimum height — desktop, px',
		'Минимальная высота — планшет, px' => 'Minimum height — tablet, px',
		'Минимальная высота — мобильный, px' => 'Minimum height — mobile, px',
		'0 — высота определяется шаблоном и содержимым слайда.' => '0 — height is determined by the pattern and slide content.',
		'Отступ сверху — ПК, px' => 'Top padding — desktop, px',
		'Отступ сверху — планшет, px' => 'Top padding — tablet, px',
		'Отступ сверху — мобильный, px' => 'Top padding — mobile, px',
		'Отступ снизу — ПК, px' => 'Bottom padding — desktop, px',
		'Отступ снизу — планшет, px' => 'Bottom padding — tablet, px',
		'Отступ снизу — мобильный, px' => 'Bottom padding — mobile, px',
		'Hero-карусель Pro. Добавляйте, удаляйте и меняйте местами слайды.' => 'Pro Hero carousel. Add, remove and reorder slides.',

		// Remaining Free pattern content.
		'Две колонки: текст о компании, услуге или продукте и изображение, которое можно заменить в Медиатеке.' => 'Two columns with text about a company, service or product and an image you can replace in the Media Library.',
		'О ШАБЛОНЕ' => 'ABOUT THE THEME',
		'Denkon Mosaic даёт прочную основу, а не ограничивает идею' => 'Denkon Mosaic gives you a strong foundation without limiting your idea',
		'Это светлый WordPress-шаблон для услуг, экспертов, компаний и небольших каталогов.' => 'A light WordPress theme for services, experts, companies and small catalogues.',
		'Продуманная структура, настройки внешнего вида и библиотека паттернов сокращают стартовую рутину. При этом каждый блок остаётся обычным Gutenberg-блоком, который легко изменить под задачу.' => 'A considered structure, appearance settings and a pattern library reduce the startup routine. Every block remains a standard Gutenberg block that is easy to adapt to the task.',
		'Изучить возможности' => 'Explore the possibilities',
		'Замените изображение о компании' => 'Replace the company image',
		'Три карточки преимуществ: иконка слева, текст справа. Подходит для кратких преимуществ услуги или продукта.' => 'Three benefit cards with an icon on the left and text on the right. Ideal for concise service or product benefits.',
		'ПРЕИМУЩЕСТВА' => 'BENEFITS',
		'Всё необходимое для уверенного запуска' => 'Everything you need for a confident launch',
		'Карточки легко адаптировать под услуги, сильные стороны команды или возможности продукта.' => 'The cards are easy to adapt to services, team strengths or product features.',
		'Иконка готовой структуры' => 'Ready structure icon',
		'Готовая структура' => 'Ready structure',
		'Собирайте страницу из понятных секций и не начинайте каждый проект с пустого экрана.' => 'Build a page from clear sections instead of starting every project from a blank screen.',
		'Иконка настроек' => 'Settings icon',
		'Настройки без кода' => 'No-code settings',
		'Меняйте цвета, ширину, шапку и подвал в панели темы, не затрагивая содержимое страниц.' => 'Change colours, width, header and footer in the theme panel without touching page content.',
		'Иконка расширения' => 'Expansion icon',
		'Готовность к росту' => 'Ready to grow',
		'Когда базовых возможностей станет мало, подключите Pro и продолжайте развивать сайт.' => 'When the basics are no longer enough, add Pro and continue developing the site.',
		'Ответы на вопросы в левой колонке и заменяемое изображение в правой. Ширина колонок — 65/35.' => 'Answers in the left column and a replaceable image in the right one. The columns are 65/35 wide.',
		'Отвечаем на важные вопросы до начала работы' => 'Answering key questions before work begins',
		'Замените вопросы и ответы на те, которые чаще всего возникают у ваших клиентов.' => 'Replace the questions and answers with the ones your clients ask most often.',
		'Нужно ли уметь работать с кодом?' => 'Do I need to work with code?',
		'Нет. Каждый элемент секции создан из обычных блоков Gutenberg: редактируйте содержание, цвета, отступы и ссылки визуально.' => 'No. Every section element uses standard Gutenberg blocks: edit content, colours, spacing and links visually.',
		'Можно ли использовать шаблон для услуг и компании?' => 'Can I use the theme for services and a company?',
		'Да. Секции нейтральны по структуре и подходят для презентации услуг, экспертных проектов, агентств и корпоративных сайтов.' => 'Yes. The sections are structurally neutral and suit services, expert projects, agencies and corporate websites.',
		'Что добавляет Pro-версия?' => 'What does the Pro version add?',
		'Pro расширяет библиотеку паттернов, добавляет карусели, галереи, макеты сайта и дополнительные сценарии для страниц.' => 'Pro expands the pattern library with carousels, galleries, site layouts and additional page scenarios.',
		'Замените изображение для раздела вопросов' => 'Replace the FAQ section image',
		'Две колонки: заголовок и аргументы слева, форма из шорткода справа. Подходит для заявки, консультации или обратной связи.' => 'Two columns: a heading and arguments on the left, a shortcode form on the right. Ideal for enquiries, consultations or feedback.',
		'НУЖНА ПОМОЩЬ С ЗАПУСКОМ?' => 'NEED HELP WITH THE LAUNCH?',
		'Подберём конфигурацию Denkon Mosaic для вашего проекта' => 'We will find the right Denkon Mosaic setup for your project',
		'Расскажите о будущем сайте — подскажем, с каких паттернов начать и когда имеет смысл подключить Pro.' => 'Tell us about your future site and we will suggest which patterns to start with and when Pro makes sense.',
		'Замените этот абзац вашими условиями, сроком ответа, контактами или условиями приобретения шаблона.' => 'Replace this paragraph with your terms, response time, contact details or theme purchase conditions.',
		'Получить консультацию' => 'Get a consultation',
		'Подключите форму через шорткод любимого плагина.' => 'Connect a form with the shortcode from your preferred plugin.',
		'Консультация по Denkon Mosaic' => 'Denkon Mosaic consultation',
		'Ровная сетка из шести заменяемых изображений для портфолио, команды, продукта или примеров работ.' => 'An even grid of six replaceable images for a portfolio, team, product or work examples.',
		'ПРИМЕРЫ ЭКРАНОВ' => 'SCREEN EXAMPLES',
		'Один шаблон — разные страницы и сценарии' => 'One theme — different pages and scenarios',
		'Замените изображение галереи' => 'Replace the gallery image',
		'Сетка логотипов клиентов, партнёров или сервисов с возможностью загрузить SVG или изображение в каждую карточку.' => 'A grid of client, partner or service logos with an SVG or image upload for every card.',
		'СОВМЕСТИМО С ВАШИМ СТЕКОМ' => 'COMPATIBLE WITH YOUR STACK',
		'Добавьте логотипы клиентов, партнёров или сервисов' => 'Add client, partner or service logos',
		'Замените логотип партнёра' => 'Replace the partner logo',
		'Четыре этапа в сетке из двух колонок: иконка расположена слева от текста.' => 'Four stages in a two-column grid with an icon to the left of the text.',
		'КАК ЭТО РАБОТАЕТ' => 'HOW IT WORKS',
		'Четыре понятных шага к запуску сайта' => 'Four clear steps to launching a site',
		'Используйте этапы, чтобы показать путь клиента, процесс оказания услуги или порядок работы команды.' => 'Use stages to show the customer journey, service process or your team workflow.',
		'Иконка первого этапа' => 'First stage icon',
		'Определяем задачу' => 'Define the task',
		'Фиксируем цель страницы, аудиторию и главный результат, к которому ведём посетителя.' => 'Define the page goal, audience and the key result you lead the visitor towards.',
		'Иконка второго этапа' => 'Second stage icon',
		'Выбираем основу' => 'Choose the foundation',
		'Подбираем нужные паттерны и собираем из них понятную структуру будущей страницы.' => 'Select the needed patterns and build a clear structure for the future page.',
		'Иконка третьего этапа' => 'Third stage icon',
		'Добавляем контент' => 'Add content',
		'Заменяем демо-текст, изображения и ссылки на свои, расставляем важные акценты.' => 'Replace demo text, images and links with your own and set the important accents.',
		'Иконка четвёртого этапа' => 'Fourth stage icon',
		'Публикуем и развиваем' => 'Publish and grow',
		'Запускаем страницу, получаем обратную связь и дополняем сайт новыми сценариями.' => 'Launch the page, collect feedback and expand the site with new scenarios.',
		'Четыре карточки шагов с заголовками, описаниями и заменяемыми SVG-иконками или изображениями.' => 'Four step cards with headings, descriptions and replaceable SVG icons or images.',
		'КАК НАЧАТЬ' => 'HOW TO START',
		'От идеи до первой страницы — за четыре шага' => 'From idea to first page in four steps',
		'Иконка выбора версии' => 'Version selection icon',
		'Установите Free для быстрого старта или подключите Pro для расширенной библиотеки.' => 'Install Free for a quick start or add Pro for the expanded library.',
		'Иконка настройки' => 'Setup icon',
		'Настройте стиль' => 'Set up the style',
		'Задайте цвета, контейнер, логотип, шапку и подвал в настройках темы.' => 'Set colours, container, logo, header and footer in the theme settings.',
		'Иконка сборки страницы' => 'Page building icon',
		'Соберите страницы' => 'Build the pages',
		'Добавьте паттерны в Gutenberg, замените демо-контент и расставьте акценты.' => 'Add patterns in Gutenberg, replace demo content and set accents.',
		'Иконка публикации' => 'Publishing icon',
		'Опубликуйте и развивайте' => 'Publish and grow',
		'Запускайте сайт сегодня, а новые разделы и сценарии добавляйте по мере роста.' => 'Launch the site today and add new sections and scenarios as you grow.',
		'Три карточки отзывов с цитатой, именем клиента и дополнительной информацией.' => 'Three testimonial cards with a quote, client name and additional information.',
		'ОТЗЫВЫ' => 'TESTIMONIALS',
		'Почему удобно запускать проекты на готовой основе' => 'Why a ready-made foundation makes projects easier to launch',
		'Страница услуги собирается из готовых секций за часы, а не за дни. После запуска команда может менять контент сама.' => 'A service page comes together from ready-made sections in hours, not days. After launch, the team can update content themselves.',
		'Максим, веб-студия' => 'Maxim, web studio',
		'Понравилось, что нет ощущения закрытого конструктора: всё остаётся в Gutenberg и легко адаптируется под фирменный стиль.' => 'I like that it does not feel like a closed builder: everything stays in Gutenberg and adapts easily to the brand style.',
		'Дарья, маркетолог' => 'Daria, marketer',
		'Free уже закрывает базовые задачи, а Pro подключили, когда понадобились сложные витрины и повторяющиеся страницы.' => 'Free already covers the essentials; we added Pro when we needed advanced showcases and recurring pages.',
		'Алексей, владелец бизнеса' => 'Alexey, business owner',

		// Pro pattern names, descriptions and content.
		'Кейс с результатом и изображением' => 'Case study with outcome and image',
		'Две колонки для истории проекта: текст, выделенный результат, кнопка и заменяемое изображение.' => 'Two columns for a project story: text, highlighted outcome, button and a replaceable image.',
		'Кейс' => 'CASE STUDY',
		'Соберите убедительную страницу услуги без отдельной вёрстки' => 'Build a convincing service page without separate development',
		'Используйте этот паттерн для кейса, ключевого предложения или истории продукта: оставьте сильный заголовок, короткое объяснение и визуальное доказательство.' => 'Use this pattern for a case study, key offer or product story: keep a strong heading, a short explanation and visual proof.',
		'Результат: страница выглядит цельно, быстро редактируется в Gutenberg и легко адаптируется под фирменный стиль.' => 'Outcome: the page looks cohesive, is quick to edit in Gutenberg and adapts easily to your brand style.',
		'Посмотреть структуру' => 'View the structure',
		'Замените изображение проекта' => 'Replace the project image',
		'Призыв к действию с изображением' => 'Call to action with image',
		'Контрастная CTA-секция с текстом, кнопкой и заменяемым изображением справа.' => 'A high-contrast CTA section with text, a button and a replaceable image on the right.',
		'ГОТОВЫ К СТАРТУ?' => 'READY TO START?',
		'Соберите сайт, который работает на вашу задачу' => 'Build a website that works for your goal',
		'Выберите подходящие секции, добавьте свой контент и опубликуйте первую версию уже сегодня.' => 'Choose the right sections, add your content and publish the first version today.',
		'Начать проект' => 'Start a project',
		'Замените изображение для призыва к действию' => 'Replace the call-to-action image',
		'Контрастный призыв к действию' => 'High-contrast call to action',
		'Контрастная секция с крупным заголовком, коротким описанием и двумя кнопками действия.' => 'A high-contrast section with a large heading, short description and two action buttons.',
		'Соберите первый сайт на Denkon Mosaic уже сегодня' => 'Build your first Denkon Mosaic site today',
		'Начните с понятной структуры и готовых паттернов. Когда проекту понадобится больше сценариев — подключите Pro без смены основы.' => 'Start with a clear structure and ready-made patterns. When the project needs more scenarios, add Pro without changing the foundation.',
		'Выбрать Denkon Mosaic' => 'Choose Denkon Mosaic',
		'Галерея с вертикальным акцентом' => 'Gallery with a vertical accent',
		'Галерея из пяти изображений: высокая фотография слева, две карточки сверху и три изображения снизу.' => 'A five-image gallery: a tall photo on the left, two cards above and three images below.',
		'СЦЕНАРИИ ПРИМЕНЕНИЯ' => 'USE CASES',
		'Один визуальный язык для разных разделов сайта' => 'One visual language for different site sections',
		'Покажите услуги, продукты, команду или портфолио в сетке, которая не требует ручной настройки каждой карточки.' => 'Show services, products, your team or portfolio in a grid that needs no manual setup for every card.',
		'Галерея с широким изображением' => 'Gallery with a wide image',
		'Галерея из шести изображений с крупной фотографией и асимметричной сеткой для портфолио или кейсов.' => 'A six-image gallery with a large photo and an asymmetric grid for a portfolio or case studies.',
		'ВИТРИНА ВОЗМОЖНОСТЕЙ' => 'FEATURE SHOWCASE',
		'Покажите интерфейс, кейсы и детали проекта выразительно' => 'Present the interface, case studies and project details with impact',
		'Выберите сетку, добавьте изображения из медиатеки — посетитель сможет открыть их в полном размере через Fancybox.' => 'Choose a grid and add images from the Media Library — visitors can open them full size with Fancybox.',
		'Изображение галереи 1' => 'Gallery image 1',
		'Изображение галереи 2' => 'Gallery image 2',
		'Изображение галереи 3' => 'Gallery image 3',
		'Изображение галереи 4' => 'Gallery image 4',
		'Изображение галереи 5' => 'Gallery image 5',
		'Изображение галереи 6' => 'Gallery image 6',
		'Преимущества Denkon Mosaic' => 'Denkon Mosaic benefits',
		'WordPress-шаблон для сайта, который хочется развивать' => 'A WordPress theme for a website you will want to grow',
		'Собирайте лендинги, корпоративные сайты и страницы услуг из готовых Gutenberg-паттернов. Быстро запускайте первую версию и спокойно масштабируйте проект дальше.' => 'Build landing pages, corporate websites and service pages from ready-made Gutenberg patterns. Launch the first version quickly and scale the project with confidence.',
		'Интерфейс WordPress-шаблона Denkon Mosaic' => 'Denkon Mosaic WordPress theme interface',
		'ГОТОВЫЕ СЕКЦИИ' => 'READY-MADE SECTIONS',
		'Не начинайте каждый проект с чистого листа' => 'Do not start every project from a blank page',
		'Hero, преимущества, этапы, галереи, отзывы, FAQ и форма уже собраны в единую дизайн-систему. Меняйте тексты, изображения и цвета прямо в редакторе.' => 'Hero, benefits, stages, galleries, testimonials, FAQ and forms are already combined in one design system. Change text, images and colours directly in the editor.',
		'Посмотреть паттерны' => 'View patterns',
		'Примеры страниц, собранных на Denkon Mosaic' => 'Examples of pages built with Denkon Mosaic',
		'FREE И PRO' => 'FREE & PRO',
		'Начните с Free и открывайте больше в Pro' => 'Start with Free and unlock more in Pro',
		'Базовая библиотека и настройки уже готовы для старта. Pro добавляет карусели, расширенные галереи, макеты сайта и инструменты для повторяющихся страниц.' => 'The basic library and settings are ready to start. Pro adds carousels, enhanced galleries, site layouts and tools for recurring pages.',
		'Настройки и паттерны Denkon Mosaic' => 'Denkon Mosaic settings and patterns',
		'Шапка сайта с навигацией' => 'Site header with navigation',
		'Макет глобальной шапки с логотипом, адаптивной навигацией и кнопкой действия.' => 'A global header layout with a logo, responsive navigation and an action button.',
		'Связаться' => 'Contact us',
		'Подвал сайта с навигацией' => 'Site footer with navigation',
		'Макет глобального подвала с логотипом, навигацией, контактами и копирайтом.' => 'A global footer layout with a logo, navigation, contacts and copyright.',
		'Denkon Mosaic — гибкая основа для WordPress-сайтов, которые удобно запускать и развивать.' => 'Denkon Mosaic is a flexible foundation for WordPress websites that are easy to launch and grow.',
		'Навигация' => 'Navigation',
		'Контакты' => 'Contacts',
		'Показатели и ключевые цифры' => 'Metrics and key figures',
		'Секция с крупными показателями и короткими пояснениями для преимуществ, результатов или фактов о компании.' => 'A section with large metrics and brief explanations for benefits, results or company facts.',
		'ВСЁ ДЛЯ БЫСТРОГО СТАРТА' => 'EVERYTHING FOR A QUICK START',
		'Инструменты, которые экономят время на каждом проекте' => 'Tools that save time on every project',
		'готовых секций для типовых страниц' => 'ready-made sections for standard pages',
		'цветовые схемы уже в базовой версии' => 'colour schemes already in the basic version',
		'уровня возможностей: Free и Pro' => 'capability levels: Free and Pro',
		'редактирование в привычном Gutenberg' => 'editing in familiar Gutenberg',
		'Показатели в круглых счётчиках' => 'Metrics in circular counters',
		'Ключевые цифры в отдельных группах-счётчиках. Для каждого счётчика можно задать круглый фон, границу или собственный цвет.' => 'Key figures in individual counter groups. Each counter can have a circular background, border or custom colour.',
		'В ЦИФРАХ' => 'IN NUMBERS',
		'Основа для сайта, который удобно развивать' => 'A foundation for a website that is easy to grow',
		'Используйте счётчики для достижений, фактов о компании или преимуществ вашего предложения.' => 'Use counters for achievements, company facts or benefits of your offer.',
		'цветовые схемы для быстрого старта' => 'colour schemes for a quick start',
		'визуальное редактирование в Gutenberg' => 'visual editing in Gutenberg',
		'Отзывы в карусели' => 'Testimonials in a carousel',
		'Секция отзывов в карусели с отдельным количеством карточек для ПК, планшета и мобильного.' => 'A testimonial carousel with separate card counts for desktop, tablet and mobile.',
		'ВЫБИРАЮТ ЗА ГИБКОСТЬ' => 'CHOSEN FOR FLEXIBILITY',
		'Готовая основа, которую легко сделать своей' => 'A ready-made foundation that is easy to make your own',
		'Слайдер отзывов доступен в Pro и настраивается отдельно для компьютера, планшета и мобильного.' => 'The testimonial slider is available in Pro and configured separately for desktop, tablet and mobile.',
		'С Denkon Mosaic удалось быстрее перейти от структуры к живой странице: блоки уже выглядят согласованно, а правки делаются без разработчика.' => 'With Denkon Mosaic we moved from structure to a live page faster: the blocks already look cohesive and edits do not need a developer.',

		// Settings actions, migration notices and Pro layout controls.
		'Логотип подвала' => 'Footer logo',
		'Используется логотип из шапки или название сайта.' => 'The header logo or site title is used.',
		'Выбрать логотип' => 'Select logo',
		'Удалить' => 'Remove',
		'Если оставить поле пустым, подвал будет использовать логотип из шапки. Если его нет — название сайта.' => 'Leave this field empty to use the header logo in the footer. If there is no logo, the site title is used.',
		'Выберите логотип подвала' => 'Select footer logo',
		'Использовать логотип' => 'Use logo',
		'Не выбран — будет показано название сайта.' => 'Not selected — the site title will be shown.',
		'Готовим ZIP-архив с настройками. Это может занять несколько секунд.' => 'Preparing a ZIP archive with settings. This may take a few seconds.',
		'Экспорт завершён. ZIP-архив с настройками скачан в папку загрузок браузера.' => 'Export complete. The settings ZIP archive has been downloaded.',
		'Не удалось подготовить ZIP-архив. Обновите страницу и повторите попытку.' => 'Could not prepare the ZIP archive. Reload the page and try again.',
		'Импортируем настройки. Страница обновится после завершения операции.' => 'Importing settings. The page will reload after the operation finishes.',
		'Сбросить все настройки Denkon Mosaic к значениям по умолчанию? Страницы, меню и файлы не будут удалены.' => 'Reset all Denkon Mosaic settings to defaults? Pages, menus and files will not be deleted.',
		'Сбрасываем настройки темы. Страница обновится после завершения операции.' => 'Resetting theme settings. The page will reload after the operation finishes.',
		'Обновить метаданные всех ранее вставленных секций Denkon Mosaic? Содержимое и дизайн не изменятся, а для изменённых страниц будут созданы ревизии WordPress.' => 'Update metadata for all previously inserted Denkon Mosaic sections? Content and design will not change; WordPress revisions will be created for changed pages.',
		'Обновляем метаданные ранее вставленных паттернов. Страница обновится после завершения операции.' => 'Updating metadata for previously inserted patterns. The page will reload after the operation finishes.',
		'Настройки темы успешно импортированы. Связанные изображения добавлены в Медиатеку, если они были в архиве.' => 'Theme settings were imported successfully. Linked images were added to the Media Library when present in the archive.',
		'Настройки темы сброшены к значениям по умолчанию. Страницы, записи, меню и файлы не изменены.' => 'Theme settings were reset to defaults. Pages, posts, menus and files were not changed.',
		'Метаданные ранее вставленных секций обновлены. Для каждого изменённого документа создана стандартная ревизия WordPress.' => 'Metadata for previously inserted sections was updated. A standard WordPress revision was created for every changed document.',
		'Сохраните настройки темы в архив или перенесите их на другой сайт с темой Denkon Mosaic. Логотип подвала также будет добавлен в медиатеку нового сайта.' => 'Save theme settings to an archive or transfer them to another site using Denkon Mosaic. The footer logo will also be added to the new site’s Media Library.',
		'Скачайте ZIP-архив с текущими настройками и логотипом подвала.' => 'Download a ZIP archive with the current settings and footer logo.',
		'Выберите ZIP-архив, созданный в Denkon Mosaic. Текущие настройки темы будут заменены настройками из архива.' => 'Choose a ZIP archive created in Denkon Mosaic. Current theme settings will be replaced by the settings from the archive.',
		'Экспорт' => 'Export',
		'Скачать ZIP-архив' => 'Download ZIP archive',
		'Импорт' => 'Import',
		'Импортировать настройки' => 'Import settings',
		'Сброс настроек' => 'Reset settings',
		'Верните цвета, ширину контента, шапку и подвал к исходным значениям темы. Страницы, паттерны, меню, Custom Logo и файлы в медиатеке не изменятся.' => 'Restore the theme’s original colours, content width, header and footer. Pages, patterns, menus, Custom Logo and Media Library files will not change.',
		'Сбросить настройки темы' => 'Reset theme settings',
		'Обновление ранее вставленных паттернов' => 'Update previously inserted patterns',
		'Добавьте русские названия и описания в редакторе к секциям Denkon Mosaic, вставленным до обновления библиотеки. Текст, стили и изображения не изменятся; для каждого изменённого документа будет создана ревизия.' => 'Update the editor names and descriptions for Denkon Mosaic sections inserted before the library update. Text, styles and images will not change; a revision will be created for every changed document.',
		'Обновить метаданные паттернов' => 'Update pattern metadata',
		'Расширение Pro активно. Дополнительные паттерны уже доступны в редакторе, а новые инструменты будут появляться здесь по мере обновлений.' => 'The Pro extension is active. Additional patterns are already available in the editor, and new tools will appear here with updates.',
		'Паттерны Pro' => 'Pro patterns',
		'В категории «Denkon Mosaic Pro» доступны секция призыва к действию, показатели и шаблон кейса.' => 'The “Denkon Mosaic Pro” category includes a call-to-action section, metrics and a case-study pattern.',
		'Палитра редактора' => 'Editor palette',
		'Pro подставляет цвета выбранной схемы в Gutenberg и запоминает до пяти последних пользовательских цветов после сохранения страницы, записи или макета.' => 'Pro supplies the selected scheme colours to Gutenberg and remembers up to five recent custom colours after a page, post or layout is saved.',
		'Перенос страниц' => 'Page transfer',
		'В этом разделе появится экспорт и импорт выбранных страниц вместе с изображениями и настройкой главной страницы.' => 'This area will provide export and import of selected pages with images and the homepage setting.',
		'Акцент' => 'Accent',
		'Поверхность' => 'Surface',
		'Прозрачный' => 'Transparent',
		'Недавний цвет %d' => 'Recent colour %d',
		'Макеты сайта' => 'Site layouts',
		'Макет сайта' => 'Site layout',
		'Добавить макет' => 'Add layout',
		'Добавить макет сайта' => 'Add site layout',
		'Редактировать макет' => 'Edit layout',
		'Новый макет' => 'New layout',
		'Просмотреть макет' => 'View layout',
		'Найти макет' => 'Find layout',
		'Макеты не найдены.' => 'No layouts found.',
		'В корзине нет макетов.' => 'No layouts in the Trash.',
		'Область вывода' => 'Display area',
		'Выберите назначение макета: шапка и подвал выводятся на сайте, а макет содержимого можно вставлять в страницы и записи как заготовку.' => 'Choose the layout purpose: the header and footer are displayed on the site, while a content layout can be inserted into pages and posts as a starting point.',
		'Контент страницы' => 'Page content',
		'Макеты страницы' => 'Page layouts',
		'Настройка действует только для этой страницы или записи. По умолчанию используются активные макеты из настроек темы.' => 'This setting applies only to this page or post. By default, active layouts from the theme settings are used.',
		'Использовать активную шапку темы' => 'Use the active theme header',
		'Использовать встроенную шапку темы' => 'Use the built-in theme header',
		'Не выводить шапку' => 'Do not display the header',
		'Использовать активный подвал темы' => 'Use the active theme footer',
		'Использовать встроенный подвал темы' => 'Use the built-in theme footer',
		'Не выводить подвал' => 'Do not display the footer',
		'Контент' => 'Content',
		'Выберите макет содержимого' => 'Choose a content layout',
		'Макет будет скопирован в редактор. После вставки его можно менять независимо от исходного макета.' => 'The layout will be copied to the editor. Once inserted, it can be edited independently of the source layout.',
		'Вставить макет в редактор' => 'Insert layout into the editor',
		'Использование' => 'Usage',
		'Шапка и подвал' => 'Header and footer',
		'Выберите опубликованные макеты, которые будут выводиться на всех страницах вместо встроенной шапки или подвала темы.' => 'Choose published layouts to display on all pages instead of the built-in theme header or footer.',
		'Создайте макет в разделе «Внешний вид → Макеты сайта», укажите его назначение, добавьте нужные блоки и опубликуйте. Макеты с назначением «Контент страницы» можно копировать в редактор страниц и записей.' => 'Create a layout in Appearance → Site layouts, choose its purpose, add the required blocks and publish it. Layouts with the “Page content” purpose can be copied into the page and post editor.',
		'Настройки макетов сохранены.' => 'Layout settings saved.',
		'Активная шапка' => 'Active header',
		'Использовать встроенную шапку' => 'Use built-in header',
		'Активный подвал' => 'Active footer',
		'Использовать встроенный подвал' => 'Use built-in footer',
		'Сохранить макеты' => 'Save layouts',
		'Создать шапку' => 'Create header',
		'Создать подвал' => 'Create footer',
		'Создать макет контента' => 'Create content layout',
		'Все макеты' => 'All layouts',
		'Сначала выберите макет контента.' => 'Choose a content layout first.',
		'Текущее содержимое страницы будет заменено блоками выбранного макета. Продолжить?' => 'The current page content will be replaced by blocks from the selected layout. Continue?',
		'В выбранном макете пока нет блоков.' => 'The selected layout does not contain any blocks yet.',
		'Макет скопирован в редактор. Сохраните страницу после изменений.' => 'The layout was copied into the editor. Save the page after making changes.',
		'Не удалось загрузить макет. Обновите страницу и повторите попытку.' => 'Could not load the layout. Reload the page and try again.',
		'Предыдущий слайд' => 'Previous slide',
		'Следующий слайд' => 'Next slide',
		'Предыдущий отзыв' => 'Previous testimonial',
		'Следующий отзыв' => 'Next testimonial',
		'Комментарии' => 'Comments',
		'Оставить комментарий' => 'Leave a comment',
		'Ответить пользователю %s' => 'Reply to %s',
		'Отменить ответ' => 'Cancel reply',
		'Отправить комментарий' => 'Post comment',
		'Закрыть' => 'Close',
		'Следующее' => 'Next',
		'Предыдущее' => 'Previous',
		'Золотой Denkon' => 'Denkon gold',
		'Графит' => 'Graphite',
		'Кремовый' => 'Cream',
		'Белый' => 'White',
		'Тёмно-синий' => 'Navy blue',
		'Hero-карусель' => 'Hero carousel',
		'Настраиваемая карусель ключевых предложений для первого экрана.' => 'A configurable carousel of key offers for the first screen.',
		'Слайд Hero-карусели' => 'Hero carousel slide',
		'Один слайд внутри Hero-карусели.' => 'One slide inside the Hero carousel.',
		'Анна Петрова, руководитель проекта' => 'Anna Petrova, project lead',
		'Определяет язык настроек темы, дополнительных инструментов и новых паттернов. Для любых других значений используется English.' => 'Sets the language of theme settings, additional tools and newly inserted patterns. English is used for all other values.',
		'Добавляйте новые страницы и разделы, сохраняя единый стиль и привычный процесс редактирования.' => 'Add pages and sections while keeping a consistent style and familiar editing workflow.',
		'Добавляйте разделы и развивайте сайт, сохраняя согласованный визуальный язык.' => 'Add sections and grow the site while keeping a consistent visual language.',
		'Гибкая основа для роста проекта.' => 'A flexible foundation for project growth.',
		'Гибкая основа' => 'Flexible foundation',
		'Расскажите о будущем сайте — подскажем, с каких паттернов начать и как собрать понятную структуру.' => 'Tell us about your future site and we will suggest which patterns to start with and how to build a clear structure.',
		'Иконка выбора основы' => 'Foundation selection icon',
		'Определите структуру будущей страницы и выберите подходящие паттерны для первого экрана.' => 'Define the structure of the future page and choose suitable patterns for the first screen.',
		'Базовой библиотеки хватает, чтобы последовательно собирать новые страницы и поддерживать сайт без лишней рутины.' => 'The core library is enough to build new pages consistently and maintain the site without unnecessary routine.',
		'Да. Дублируйте страницу WordPress, заменяйте тексты и изображения, а затем адаптируйте готовые блоки под новый сценарий.' => 'Yes. Duplicate a WordPress page, replace the text and images, then adapt the ready-made blocks to the new scenario.',
		'Подходит ли тема для развития сайта?' => 'Is the theme suitable for a growing website?',
		'Да. Добавляйте страницы и разделы по мере роста, сохраняя единую структуру, цвета и типографику.' => 'Yes. Add pages and sections as you grow while keeping structure, colours and typography consistent.',
	);

	return $catalogue;
}

/**
 * Translates a Denkon Mosaic string to a requested interface language.
 *
 * @param string $text     Source string.
 * @param string $language Target language.
 * @return string
 */
function denkon_mosaic_translate_to_language( $text, $language ) {
	if ( 'ru' === $language ) {
		$catalogue = denkon_mosaic_get_english_catalogue();
		$source    = array_search( $text, $catalogue, true );

		return false !== $source ? $source : $text;
	}

	$catalogue = denkon_mosaic_get_english_catalogue();

	return isset( $catalogue[ $text ] ) ? $catalogue[ $text ] : $text;
}

/**
 * Translates one registered pattern content string without altering markup.
 *
 * @param string $content Block markup.
 * @return string
 */
function denkon_mosaic_translate_pattern_content( $content ) {
	if ( 'ru' === denkon_mosaic_get_interface_language() ) {
		return $content;
	}

	return strtr( $content, denkon_mosaic_get_english_catalogue() );
}

/**
 * Translates Free and Pro PHP interface strings through one setting.
 *
 * @param string $translation Existing WordPress translation.
 * @param string $text        Source string.
 * @param string $domain      Translation domain.
 * @return string
 */
function denkon_mosaic_filter_interface_gettext( $translation, $text, $domain ) {
	if ( ! in_array( $domain, array( 'denkon-mosaic', 'denkon-mosaic-pro' ), true ) || 'ru' === denkon_mosaic_get_interface_language() ) {
		return $translation;
	}

	return denkon_mosaic_translate_to_language( $text, 'en' );
}
add_filter( 'gettext', 'denkon_mosaic_filter_interface_gettext', 20, 3 );

/**
 * Provides the catalogue to custom Gutenberg blocks written in JavaScript.
 *
 * @return void
 */
function denkon_mosaic_add_editor_interface_translations() {
	if ( 'ru' === denkon_mosaic_get_interface_language() ) {
		return;
	}

	$data = array(
		'' => array(
			'domain'       => 'denkon-mosaic-pro',
			'lang'         => 'en_US',
			'plural-forms' => 'nplurals=2; plural=(n != 1);',
		),
	);

	foreach ( denkon_mosaic_get_english_catalogue() as $source => $translation ) {
		$data[ $source ] = array( $translation );
	}

	$script = 'wp.i18n.setLocaleData(' . wp_json_encode( $data ) . ', "denkon-mosaic-pro");';

	foreach ( array( 'denkon-mosaic-pro-hero-carousel-editor', 'denkon-mosaic-pro-testimonials-carousel-editor' ) as $handle ) {
		if ( wp_script_is( $handle, 'registered' ) ) {
			wp_add_inline_script( $handle, $script, 'before' );
		}
	}
}
add_action( 'enqueue_block_editor_assets', 'denkon_mosaic_add_editor_interface_translations', 30 );

/**
 * Keeps the document language aligned with the theme interface language.
 *
 * @param string $attributes Existing language attributes.
 * @return string
 */
function denkon_mosaic_filter_language_attributes( $attributes ) {
	if ( is_admin() ) {
		return $attributes;
	}

	$language = 'ru' === denkon_mosaic_get_interface_language() ? 'ru-RU' : 'en-US';

	if ( false !== strpos( $attributes, 'lang=' ) ) {
		return preg_replace( '/lang=("|\')[^"\']*("|\')/', 'lang="' . $language . '"', $attributes, 1 );
	}

	return trim( $attributes . ' lang="' . $language . '"' );
}
add_filter( 'language_attributes', 'denkon_mosaic_filter_language_attributes' );
