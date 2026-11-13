<?php
/**
 * Title: О компании с изображением
 * Slug: denkon-mosaic/about
 * Categories: denkon-mosaic
 *
 * @package DenkonMosaic
 */

return array(
	'title'       => __( 'О компании с изображением', 'denkon-mosaic' ),
	'description' => __( 'Две колонки: текст о компании, услуге или продукте и изображение, которое можно заменить в Медиатеке.', 'denkon-mosaic' ),
	'content'     => <<<'BLOCKS'
<!-- wp:group {"metadata":{"name":"О компании с изображением","categories":["about"],"patternName":"denkon-mosaic/about"},"tagName":"section","className":"mosaic-pattern mosaic-section mosaic-about","layout":{"type":"constrained"}} -->
<section class="wp-block-group mosaic-pattern mosaic-section mosaic-about">
	<!-- wp:group {"className":"container","layout":{"type":"constrained"}} -->
	<div class="wp-block-group container">
	<!-- wp:columns {"verticalAlignment":"center","className":"mosaic-about__columns"} -->
	<div class="wp-block-columns are-vertically-aligned-center mosaic-about__columns">
		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:paragraph {"className":"mosaic-section__eyebrow"} --><p class="mosaic-section__eyebrow">О ШАБЛОНЕ</p><!-- /wp:paragraph -->
			<!-- wp:heading --><h2 class="wp-block-heading">Denkon Mosaic даёт прочную основу, а не ограничивает идею</h2><!-- /wp:heading -->
			<!-- wp:paragraph {"fontSize":"medium"} --><p class="has-medium-font-size">Это светлый WordPress-шаблон для услуг, экспертов, компаний и небольших каталогов.</p><!-- /wp:paragraph -->
			<!-- wp:paragraph --><p>Продуманная структура, настройки внешнего вида и библиотека паттернов сокращают стартовую рутину. При этом каждый блок остаётся обычным Gutenberg-блоком, который легко изменить под задачу.</p><!-- /wp:paragraph -->
			<!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#mosaic-benefits">Изучить возможности</a></div><!-- /wp:button --></div><!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--about"} -->
			<figure class="wp-block-image size-full mosaic-media mosaic-media--about"><img src="{{mosaic_image}}" alt="Замените изображение о компании"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
BLOCKS
);
