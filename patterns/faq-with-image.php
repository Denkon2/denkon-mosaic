<?php
/**
 * Title: FAQ с изображением
 * Slug: denkon-mosaic/faq-with-image
 * Categories: denkon-mosaic
 *
 * @package DenkonMosaic
 */

return array(
	'title'       => __( 'FAQ с изображением', 'denkon-mosaic' ),
	'description' => __( 'Ответы на вопросы в левой колонке и заменяемое изображение в правой. Ширина колонок — 65/35.', 'denkon-mosaic' ),
	'content'     => <<<'BLOCKS'
<!-- wp:group {"metadata":{"name":"FAQ с изображением","categories":["faq"],"patternName":"denkon-mosaic/faq-with-image"},"tagName":"section","className":"mosaic-pattern mosaic-section mosaic-faq mosaic-faq--with-image","layout":{"type":"constrained"}} -->
<section class="wp-block-group mosaic-pattern mosaic-section mosaic-faq mosaic-faq--with-image"><!-- wp:group {"className":"container","layout":{"type":"constrained"}} --><div class="wp-block-group container"><!-- wp:group {"className":"mosaic-section__heading","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-section__heading"><!-- wp:paragraph {"className":"mosaic-section__eyebrow"} --><p class="mosaic-section__eyebrow">FAQ</p><!-- /wp:paragraph --><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Отвечаем на важные вопросы до начала работы</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Замените вопросы и ответы на те, которые чаще всего возникают у ваших клиентов.</p><!-- /wp:paragraph --></div><!-- /wp:group -->
<!-- wp:columns {"verticalAlignment":"top","className":"mosaic-faq__columns"} --><div class="wp-block-columns are-vertically-aligned-top mosaic-faq__columns"><!-- wp:column {"verticalAlignment":"top","width":"65%"} --><div class="wp-block-column is-vertically-aligned-top" style="flex-basis:65%"><!-- wp:details {"className":"mosaic-faq__item"} --><details class="wp-block-details mosaic-faq__item"><summary>Нужно ли уметь работать с кодом?</summary><!-- wp:paragraph --><p>Нет. Каждый элемент секции создан из обычных блоков Gutenberg: редактируйте содержание, цвета, отступы и ссылки визуально.</p><!-- /wp:paragraph --></details><!-- /wp:details --><!-- wp:details {"className":"mosaic-faq__item"} --><details class="wp-block-details mosaic-faq__item"><summary>Можно ли использовать шаблон для услуг и компании?</summary><!-- wp:paragraph --><p>Да. Секции нейтральны по структуре и подходят для презентации услуг, экспертных проектов, агентств и корпоративных сайтов.</p><!-- /wp:paragraph --></details><!-- /wp:details --><!-- wp:details {"className":"mosaic-faq__item"} --><details class="wp-block-details mosaic-faq__item"><summary>Подходит ли тема для развития сайта?</summary><!-- wp:paragraph --><p>Да. Добавляйте страницы и разделы по мере роста, сохраняя единую структуру, цвета и типографику.</p><!-- /wp:paragraph --></details><!-- /wp:details --></div><!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"top","width":"35%"} --><div class="wp-block-column is-vertically-aligned-top" style="flex-basis:35%"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--faq"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--faq"><img src="{{mosaic_image}}" alt="Замените изображение для раздела вопросов"/></figure><!-- /wp:image --></div><!-- /wp:column --></div><!-- /wp:columns --></div><!-- /wp:group --></section>
<!-- /wp:group -->
BLOCKS
);
