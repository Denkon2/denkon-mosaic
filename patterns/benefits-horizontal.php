<?php
/**
 * Title: Преимущества: иконки слева
 * Slug: denkon-mosaic/benefits-horizontal
 * Categories: denkon-mosaic
 *
 * @package DenkonMosaic
 */

return array(
	'title'       => __( 'Преимущества: иконки слева', 'denkon-mosaic' ),
	'description' => __( 'Три карточки преимуществ: иконка слева, текст справа. Подходит для кратких преимуществ услуги или продукта.', 'denkon-mosaic' ),
	'content'     => <<<'BLOCKS'
<!-- wp:group {"metadata":{"name":"Преимущества: иконки слева","categories":["benefits"],"patternName":"denkon-mosaic/benefits-horizontal"},"tagName":"section","className":"mosaic-pattern mosaic-section mosaic-benefits mosaic-benefits--horizontal","layout":{"type":"constrained"}} -->
<section class="wp-block-group mosaic-pattern mosaic-section mosaic-benefits mosaic-benefits--horizontal"><!-- wp:group {"className":"container","layout":{"type":"constrained"}} -->
<div class="wp-block-group container"><!-- wp:group {"className":"mosaic-section__heading","layout":{"type":"constrained"}} -->
<div class="wp-block-group mosaic-section__heading"><!-- wp:paragraph {"className":"mosaic-section__eyebrow"} --><p class="mosaic-section__eyebrow">ПРЕИМУЩЕСТВА</p><!-- /wp:paragraph -->
<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Всё необходимое для уверенного запуска</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Карточки легко адаптировать под услуги, сильные стороны команды или возможности продукта.</p><!-- /wp:paragraph --></div>
<!-- /wp:group -->
<!-- wp:columns {"className":"mosaic-card-grid mosaic-card-grid--3 mosaic-benefits__grid"} -->
<div class="wp-block-columns mosaic-card-grid mosaic-card-grid--3 mosaic-benefits__grid"><!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"mosaic-card mosaic-benefit mosaic-benefit--horizontal","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} --><div class="wp-block-group mosaic-card mosaic-benefit mosaic-benefit--horizontal"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--icon"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--icon"><img src="{{mosaic_icon}}" alt="Иконка готовой структуры"/></figure><!-- /wp:image --><!-- wp:group {"className":"mosaic-benefit__content","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-benefit__content"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Готовая структура</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Собирайте страницу из понятных секций и не начинайте каждый проект с пустого экрана.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:group --></div><!-- /wp:column -->
<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"mosaic-card mosaic-benefit mosaic-benefit--horizontal","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} --><div class="wp-block-group mosaic-card mosaic-benefit mosaic-benefit--horizontal"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--icon"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--icon"><img src="{{mosaic_icon}}" alt="Иконка настроек"/></figure><!-- /wp:image --><!-- wp:group {"className":"mosaic-benefit__content","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-benefit__content"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Настройки без кода</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Меняйте цвета, ширину, шапку и подвал в панели темы, не затрагивая содержимое страниц.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:group --></div><!-- /wp:column -->
<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"mosaic-card mosaic-benefit mosaic-benefit--horizontal","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} --><div class="wp-block-group mosaic-card mosaic-benefit mosaic-benefit--horizontal"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--icon"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--icon"><img src="{{mosaic_icon}}" alt="Иконка расширения"/></figure><!-- /wp:image --><!-- wp:group {"className":"mosaic-benefit__content","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-benefit__content"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Готовность к росту</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Добавляйте разделы и развивайте сайт, сохраняя согласованный визуальный язык.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:group --></div><!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
BLOCKS
);
