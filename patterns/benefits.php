<?php
/**
 * Title: Преимущества в карточках
 * Slug: denkon-mosaic/benefits
 * Categories: denkon-mosaic
 *
 * @package DenkonMosaic
 */

return array(
	'title'       => __( 'Преимущества в карточках', 'denkon-mosaic' ),
	'description' => __( 'Секция с карточками преимуществ, в которые можно загрузить SVG-иконки или изображения.', 'denkon-mosaic' ),
	'content'     => <<<'BLOCKS'
<!-- wp:group {"metadata":{"name":"Преимущества в карточках","categories":["benefits"],"patternName":"denkon-mosaic/benefits"},"tagName":"section","anchor":"mosaic-benefits","className":"mosaic-pattern mosaic-section mosaic-benefits","layout":{"type":"constrained"}} -->
<section id="mosaic-benefits" class="wp-block-group mosaic-pattern mosaic-section mosaic-benefits">
	<!-- wp:group {"className":"container","layout":{"type":"constrained"}} -->
	<div class="wp-block-group container">
	<!-- wp:group {"className":"mosaic-section__heading","layout":{"type":"constrained"}} -->
	<div class="wp-block-group mosaic-section__heading"><!-- wp:paragraph {"className":"mosaic-section__eyebrow"} --><p class="mosaic-section__eyebrow">ПОЧЕМУ DENKON MOSAIC</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Готовая система вместо набора разрозненных блоков</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Шаблон помогает быстрее собрать убедительный сайт и оставляет свободу для вашего контента и бренда.</p><!-- /wp:paragraph --></div>
	<!-- /wp:group -->

	<!-- wp:columns {"className":"mosaic-card-grid mosaic-card-grid--3"} -->
	<div class="wp-block-columns mosaic-card-grid mosaic-card-grid--3">
		<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"mosaic-card mosaic-benefit","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-card mosaic-benefit"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--icon"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--icon"><img src="{{mosaic_icon}}" alt="Иконка готовых секций"/></figure><!-- /wp:image --><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Готовые секции</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Собирайте страницы из Hero, карточек, галерей, отзывов, FAQ и формы без ручной вёрстки.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"mosaic-card mosaic-benefit","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-card mosaic-benefit"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--icon"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--icon"><img src="{{mosaic_icon}}" alt="Иконка визуальных настроек"/></figure><!-- /wp:image --><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Единый стиль</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Цветовая схема, ширина контента, шапка и подвал настраиваются из одной панели.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"mosaic-card mosaic-benefit","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-card mosaic-benefit"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--icon"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--icon"><img src="{{mosaic_icon}}" alt="Иконка расширения возможностей"/></figure><!-- /wp:image --><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Запас для роста</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Добавляйте новые страницы и разделы, сохраняя единый стиль и привычный процесс редактирования.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
BLOCKS
);
