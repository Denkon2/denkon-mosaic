<?php
/**
 * Title: Галерея из шести изображений
 * Slug: denkon-mosaic/gallery
 * Categories: denkon-mosaic
 *
 * @package DenkonMosaic
 */

return array(
	'title'       => __( 'Галерея из шести изображений', 'denkon-mosaic' ),
	'description' => __( 'Ровная сетка из шести заменяемых изображений для портфолио, команды, продукта или примеров работ.', 'denkon-mosaic' ),
	'content'     => <<<'BLOCKS'
<!-- wp:group {"metadata":{"name":"Галерея из шести изображений","categories":["gallery"],"patternName":"denkon-mosaic/gallery"},"tagName":"section","className":"mosaic-pattern mosaic-section mosaic-gallery-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group mosaic-pattern mosaic-section mosaic-gallery-section">
	<!-- wp:group {"className":"container","layout":{"type":"constrained"}} -->
	<div class="wp-block-group container">
	<!-- wp:group {"className":"mosaic-section__heading","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-section__heading"><!-- wp:paragraph {"className":"mosaic-section__eyebrow"} --><p class="mosaic-section__eyebrow">ПРИМЕРЫ ЭКРАНОВ</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Один шаблон — разные страницы и сценарии</h2><!-- /wp:heading --></div><!-- /wp:group -->
	<!-- wp:columns {"className":"mosaic-gallery"} --><div class="wp-block-columns mosaic-gallery">
		<!-- wp:column --><div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--gallery"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--gallery"><img src="{{mosaic_image}}" alt="Замените изображение галереи"/></figure><!-- /wp:image --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--gallery"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--gallery"><img src="{{mosaic_image}}" alt="Замените изображение галереи"/></figure><!-- /wp:image --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--gallery"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--gallery"><img src="{{mosaic_image}}" alt="Замените изображение галереи"/></figure><!-- /wp:image --></div><!-- /wp:column -->
	</div><!-- /wp:columns -->
	<!-- wp:columns {"className":"mosaic-gallery"} --><div class="wp-block-columns mosaic-gallery">
		<!-- wp:column --><div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--gallery"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--gallery"><img src="{{mosaic_image}}" alt="Замените изображение галереи"/></figure><!-- /wp:image --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--gallery"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--gallery"><img src="{{mosaic_image}}" alt="Замените изображение галереи"/></figure><!-- /wp:image --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-media--gallery"} --><figure class="wp-block-image size-full mosaic-media mosaic-media--gallery"><img src="{{mosaic_image}}" alt="Замените изображение галереи"/></figure><!-- /wp:image --></div><!-- /wp:column -->
	</div><!-- /wp:columns -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
BLOCKS
);
