<?php
/**
 * Title: Четыре этапа работы
 * Slug: denkon-mosaic/steps
 * Categories: denkon-mosaic
 *
 * @package DenkonMosaic
 */

return array(
	'title'       => __( 'Четыре этапа работы', 'denkon-mosaic' ),
	'description' => __( 'Четыре карточки шагов с заголовками, описаниями и заменяемыми SVG-иконками или изображениями.', 'denkon-mosaic' ),
	'content'     => <<<'BLOCKS'
<!-- wp:group {"metadata":{"name":"Четыре этапа работы","categories":["steps"],"patternName":"denkon-mosaic/steps"},"tagName":"section","className":"mosaic-pattern mosaic-section mosaic-steps","layout":{"type":"constrained"}} -->
<section class="wp-block-group mosaic-pattern mosaic-section mosaic-steps">
	<!-- wp:group {"className":"container","layout":{"type":"constrained"}} -->
	<div class="wp-block-group container">
	<!-- wp:group {"className":"mosaic-section__heading","layout":{"type":"constrained"}} -->
	<div class="wp-block-group mosaic-section__heading">
		<!-- wp:paragraph {"className":"mosaic-section__eyebrow"} -->
		<p class="mosaic-section__eyebrow">КАК НАЧАТЬ</p>
		<!-- /wp:paragraph -->
		<!-- wp:heading -->
		<h2 class="wp-block-heading">От идеи до первой страницы — за четыре шага</h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"className":"mosaic-card-grid mosaic-card-grid--4"} -->
	<div class="wp-block-columns mosaic-card-grid mosaic-card-grid--4">
		<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"mosaic-card mosaic-step","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-card mosaic-step"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--icon"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--icon"><img src="{{mosaic_icon}}" alt="Иконка выбора основы"/></figure><!-- /wp:image --><!-- wp:paragraph {"className":"mosaic-step__number"} --><p class="mosaic-step__number">01</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Выберите основу</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Определите структуру будущей страницы и выберите подходящие паттерны для первого экрана.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"mosaic-card mosaic-step","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-card mosaic-step"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--icon"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--icon"><img src="{{mosaic_icon}}" alt="Иконка настройки"/></figure><!-- /wp:image --><!-- wp:paragraph {"className":"mosaic-step__number"} --><p class="mosaic-step__number">02</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Настройте стиль</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Задайте цвета, контейнер, логотип, шапку и подвал в настройках темы.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"mosaic-card mosaic-step","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-card mosaic-step"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--icon"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--icon"><img src="{{mosaic_icon}}" alt="Иконка сборки страницы"/></figure><!-- /wp:image --><!-- wp:paragraph {"className":"mosaic-step__number"} --><p class="mosaic-step__number">03</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Соберите страницы</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Добавьте паттерны в Gutenberg, замените демо-контент и расставьте акценты.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"mosaic-card mosaic-step","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-card mosaic-step"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--icon"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--icon"><img src="{{mosaic_icon}}" alt="Иконка публикации"/></figure><!-- /wp:image --><!-- wp:paragraph {"className":"mosaic-step__number"} --><p class="mosaic-step__number">04</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Опубликуйте и развивайте</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Запускайте сайт сегодня, а новые разделы и сценарии добавляйте по мере роста.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
BLOCKS
);
