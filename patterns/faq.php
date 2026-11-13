<?php
/**
 * Title: Ответы на частые вопросы
 * Slug: denkon-mosaic/faq
 * Categories: denkon-mosaic
 *
 * @package DenkonMosaic
 */

return array(
	'title'       => __( 'Ответы на частые вопросы', 'denkon-mosaic' ),
	'description' => __( 'Секция FAQ с вопросами и раскрывающимися ответами для услуг, продукта или компании.', 'denkon-mosaic' ),
	'content'     => <<<'BLOCKS'
<!-- wp:group {"metadata":{"name":"Ответы на частые вопросы","categories":["faq"],"patternName":"denkon-mosaic/faq"},"tagName":"section","className":"mosaic-pattern mosaic-section mosaic-faq","layout":{"type":"constrained"}} -->
<section class="wp-block-group mosaic-pattern mosaic-section mosaic-faq">
	<!-- wp:group {"className":"container","layout":{"type":"constrained"}} -->
	<div class="wp-block-group container">
	<!-- wp:group {"className":"mosaic-section__heading","layout":{"type":"constrained"}} -->
	<div class="wp-block-group mosaic-section__heading"><!-- wp:paragraph {"className":"mosaic-section__eyebrow"} --><p class="mosaic-section__eyebrow">FAQ</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Всё важное о Denkon Mosaic</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Коротко о запуске, редактировании и развитии сайта на шаблоне.</p><!-- /wp:paragraph --></div>
	<!-- /wp:group -->

	<!-- wp:details {"className":"mosaic-faq__item"} --><details class="wp-block-details mosaic-faq__item"><summary>Нужно ли знать код, чтобы редактировать сайт?</summary><!-- wp:paragraph --><p>Нет. Паттерны собраны из стандартных Gutenberg-блоков: меняйте тексты, изображения, ссылки, отступы и цвета прямо в редакторе.</p><!-- /wp:paragraph --></details><!-- /wp:details -->
	<!-- wp:details {"className":"mosaic-faq__item"} --><details class="wp-block-details mosaic-faq__item"><summary>Можно ли собрать несколько однотипных страниц?</summary><!-- wp:paragraph --><p>Да. Дублируйте страницу WordPress, заменяйте тексты и изображения, а затем адаптируйте готовые блоки под новый сценарий.</p><!-- /wp:paragraph --></details><!-- /wp:details -->
	<!-- wp:details {"className":"mosaic-faq__item"} --><details class="wp-block-details mosaic-faq__item"><summary>Подходит ли тема для развития сайта?</summary><!-- wp:paragraph --><p>Да. Добавляйте страницы и разделы по мере роста, сохраняя единую структуру, цвета и типографику.</p><!-- /wp:paragraph --></details><!-- /wp:details -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
BLOCKS
);
