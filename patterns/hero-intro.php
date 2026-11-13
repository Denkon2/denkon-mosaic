<?php
/**
 * Title: Первый экран с оффером и изображением
 * Slug: denkon-mosaic/hero-intro
 * Categories: denkon-mosaic
 *
 * @package DenkonMosaic
 */

return array(
	'title'       => __( 'Первый экран с оффером и изображением', 'denkon-mosaic' ),
	'description' => __( 'Первый экран с заголовком, описанием, кнопками, преимуществами и необязательным изображением справа.', 'denkon-mosaic' ),
	'content'     => <<<'BLOCKS'
<!-- wp:group {"metadata":{"name":"Первый экран с оффером и изображением","categories":["hero"],"patternName":"denkon-mosaic/hero-intro"},"tagName":"section","className":"mosaic-pattern mosaic-hero","layout":{"type":"constrained"}} -->
<section class="wp-block-group mosaic-pattern mosaic-hero">
	<!-- wp:group {"className":"container mosaic-hero__container","layout":{"type":"constrained"}} -->
	<div class="wp-block-group container mosaic-hero__container">
		<!-- wp:columns {"verticalAlignment":"center","className":"mosaic-hero__columns"} -->
		<div class="wp-block-columns are-vertically-aligned-center mosaic-hero__columns">
			<!-- wp:column {"verticalAlignment":"center"} -->
			<div class="wp-block-column is-vertically-aligned-center">
				<!-- wp:group {"className":"mosaic-hero__content","layout":{"type":"constrained"}} -->
				<div class="wp-block-group mosaic-hero__content">
					<!-- wp:paragraph {"className":"mosaic-hero__eyebrow"} -->
					<p class="mosaic-hero__eyebrow">DENKON MOSAIC</p>
					<!-- /wp:paragraph -->

					<!-- wp:heading {"level":1} -->
					<h1 class="wp-block-heading">WordPress-шаблон для быстрого и уверенного старта</h1>
					<!-- /wp:heading -->

					<!-- wp:paragraph {"fontSize":"medium"} -->
					<p class="has-medium-font-size">Создавайте страницы услуг, лендинги и корпоративные сайты из готовых Gutenberg-паттернов — без долгой подготовки дизайна и вёрстки.</p>
					<!-- /wp:paragraph -->

					<!-- wp:list {"className":"mosaic-hero__list"} -->
					<ul class="wp-block-list mosaic-hero__list"><li>Единый стиль для всех ключевых страниц.</li><li>Настройки внешнего вида в одном месте.</li><li>Гибкая основа для роста проекта.</li></ul>
					<!-- /wp:list -->

					<!-- wp:buttons -->
					<div class="wp-block-buttons">
						<!-- wp:button -->
						<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Смотреть возможности</a></div>
						<!-- /wp:button -->

						<!-- wp:button {"className":"is-style-outline"} -->
						<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">Выбрать версию</a></div>
						<!-- /wp:button -->
					</div>
					<!-- /wp:buttons -->

					<!-- wp:columns {"className":"mosaic-hero__features"} -->
					<div class="wp-block-columns mosaic-hero__features">
						<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"mosaic-hero__feature","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-hero__feature"><!-- wp:paragraph --><p>Готовые паттерны</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column -->
						<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"mosaic-hero__feature","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-hero__feature"><!-- wp:paragraph --><p>Настройки темы</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column -->
						<!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"mosaic-hero__feature","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-hero__feature"><!-- wp:paragraph --><p>Гибкая основа</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column -->
					</div>
					<!-- /wp:columns -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center","className":"mosaic-hero__visual-column"} -->
			<div class="wp-block-column is-vertically-aligned-center mosaic-hero__visual-column">
				<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"mosaic-media mosaic-hero__visual"} -->
				<figure class="wp-block-image size-full mosaic-media mosaic-hero__visual"><img src="{{mosaic_image}}" alt="Замените изображение первого экрана"/></figure>
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
