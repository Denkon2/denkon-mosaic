<?php
/**
 * Title: Текст и форма в двух колонках
 * Slug: denkon-mosaic/form
 * Categories: denkon-mosaic
 *
 * @package DenkonMosaic
 */

return array(
	'title'       => __( 'Текст и форма в двух колонках', 'denkon-mosaic' ),
	'description' => __( 'Две колонки: заголовок и аргументы слева, форма из шорткода справа. Подходит для заявки, консультации или обратной связи.', 'denkon-mosaic' ),
	'content'     => <<<'BLOCKS'
<!-- wp:group {"metadata":{"name":"Текст и форма в двух колонках","categories":["form"],"patternName":"denkon-mosaic/form"},"tagName":"section","className":"mosaic-pattern mosaic-section mosaic-form","layout":{"type":"constrained"}} -->
<section class="wp-block-group mosaic-pattern mosaic-section mosaic-form"><!-- wp:group {"className":"container","layout":{"type":"constrained"}} -->
<div class="wp-block-group container"><!-- wp:columns {"verticalAlignment":"center","className":"mosaic-form__columns"} -->
<div class="wp-block-columns are-vertically-aligned-center mosaic-form__columns"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph {"className":"mosaic-section__eyebrow"} -->
<p class="mosaic-section__eyebrow">НУЖНА ПОМОЩЬ С ЗАПУСКОМ?</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Подберём конфигурацию Denkon Mosaic для вашего проекта</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size">Расскажите о будущем сайте — подскажем, с каких паттернов начать и как собрать понятную структуру.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Замените этот абзац вашими условиями, сроком ответа, контактами или условиями приобретения шаблона.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>+7 (000) 000-00-00</strong><br>hello@example.com</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"mosaic-form__card","layout":{"type":"constrained"}} -->
<div class="wp-block-group mosaic-form__card"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Получить консультацию</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Подключите форму через шорткод любимого плагина.</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[contact-form-7 id="123" title="Консультация по Denkon Mosaic"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
BLOCKS
);
