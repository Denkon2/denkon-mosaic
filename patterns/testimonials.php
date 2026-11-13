<?php
/**
 * Title: Отзывы клиентов
 * Slug: denkon-mosaic/testimonials
 * Categories: denkon-mosaic
 *
 * @package DenkonMosaic
 */

return array(
	'title'       => __( 'Отзывы клиентов', 'denkon-mosaic' ),
	'description' => __( 'Три карточки отзывов с цитатой, именем клиента и дополнительной информацией.', 'denkon-mosaic' ),
	'content'     => <<<'BLOCKS'
<!-- wp:group {"metadata":{"name":"Отзывы клиентов","categories":["testimonials"],"patternName":"denkon-mosaic/testimonials"},"tagName":"section","className":"mosaic-pattern mosaic-section mosaic-testimonials","layout":{"type":"constrained"}} -->
<section class="wp-block-group mosaic-pattern mosaic-section mosaic-testimonials">
	<!-- wp:group {"className":"container","layout":{"type":"constrained"}} -->
	<div class="wp-block-group container">
	<!-- wp:group {"className":"mosaic-section__heading","layout":{"type":"constrained"}} --><div class="wp-block-group mosaic-section__heading"><!-- wp:paragraph {"className":"mosaic-section__eyebrow"} --><p class="mosaic-section__eyebrow">ОТЗЫВЫ</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Почему удобно запускать проекты на готовой основе</h2><!-- /wp:heading --></div><!-- /wp:group -->
	<!-- wp:columns {"className":"mosaic-card-grid mosaic-card-grid--3"} --><div class="wp-block-columns mosaic-card-grid mosaic-card-grid--3">
		<!-- wp:column --><div class="wp-block-column"><!-- wp:quote {"className":"mosaic-testimonial"} --><blockquote class="wp-block-quote mosaic-testimonial"><p>Страница услуги собирается из готовых секций за часы, а не за дни. После запуска команда может менять контент сама.</p><cite>Максим, веб-студия</cite></blockquote><!-- /wp:quote --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:quote {"className":"mosaic-testimonial"} --><blockquote class="wp-block-quote mosaic-testimonial"><p>Понравилось, что нет ощущения закрытого конструктора: всё остаётся в Gutenberg и легко адаптируется под фирменный стиль.</p><cite>Дарья, маркетолог</cite></blockquote><!-- /wp:quote --></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:quote {"className":"mosaic-testimonial"} --><blockquote class="wp-block-quote mosaic-testimonial"><p>Базовой библиотеки хватает, чтобы последовательно собирать новые страницы и поддерживать сайт без лишней рутины.</p><cite>Алексей, владелец бизнеса</cite></blockquote><!-- /wp:quote --></div><!-- /wp:column -->
	</div><!-- /wp:columns -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
BLOCKS
);
