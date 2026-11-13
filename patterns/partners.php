<?php
/**
 * Title: Логотипы клиентов и партнёров
 * Slug: denkon-mosaic/partners
 * Categories: denkon-mosaic
 *
 * @package DenkonMosaic
 */

return array(
	'title'       => __( 'Логотипы клиентов и партнёров', 'denkon-mosaic' ),
	'description' => __( 'Сетка логотипов клиентов, партнёров или сервисов с возможностью загрузить SVG или изображение в каждую карточку.', 'denkon-mosaic' ),
	'content'     => <<<'BLOCKS'
<!-- wp:group {"metadata":{"name":"Логотипы клиентов и партнёров","categories":["partners"],"patternName":"denkon-mosaic/partners"},"tagName":"section","className":"mosaic-pattern mosaic-section mosaic-partners","layout":{"type":"constrained"}} -->
<section class="wp-block-group mosaic-pattern mosaic-section mosaic-partners">
	<!-- wp:group {"className":"container","layout":{"type":"constrained"}} -->
	<div class="wp-block-group container">
	<!-- wp:group {"className":"mosaic-section__heading mosaic-section__heading--center","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-section__heading mosaic-section__heading--center"><!-- wp:paragraph {"className":"mosaic-section__eyebrow"} --><p class="mosaic-section__eyebrow">СОВМЕСТИМО С ВАШИМ СТЕКОМ</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Добавьте логотипы клиентов, партнёров или сервисов</h2><!-- /wp:heading --></div><!-- /wp:group -->
	<!-- wp:columns {"className":"mosaic-partners__grid"} --><div class="wp-block-columns mosaic-partners__grid">
		<!-- wp:column --><div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--partner"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--partner"><img src="{{mosaic_icon}}" alt="Замените логотип партнёра"/></figure><!-- /wp:image --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--partner"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--partner"><img src="{{mosaic_icon}}" alt="Замените логотип партнёра"/></figure><!-- /wp:image --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--partner"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--partner"><img src="{{mosaic_icon}}" alt="Замените логотип партнёра"/></figure><!-- /wp:image --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--partner"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--partner"><img src="{{mosaic_icon}}" alt="Замените логотип партнёра"/></figure><!-- /wp:image --></div><!-- /wp:column -->
	</div><!-- /wp:columns -->
	<!-- wp:columns {"className":"mosaic-partners__grid"} --><div class="wp-block-columns mosaic-partners__grid">
		<!-- wp:column --><div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--partner"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--partner"><img src="{{mosaic_icon}}" alt="Замените логотип партнёра"/></figure><!-- /wp:image --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--partner"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--partner"><img src="{{mosaic_icon}}" alt="Замените логотип партнёра"/></figure><!-- /wp:image --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--partner"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--partner"><img src="{{mosaic_icon}}" alt="Замените логотип партнёра"/></figure><!-- /wp:image --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--partner"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--partner"><img src="{{mosaic_icon}}" alt="Замените логотип партнёра"/></figure><!-- /wp:image --></div><!-- /wp:column -->
	</div><!-- /wp:columns -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
BLOCKS
);
