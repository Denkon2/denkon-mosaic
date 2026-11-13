<?php
/**
 * Main query template.
 *
 * @package DenkonMosaic
 */

get_header();
?>
<div class="mosaic-container mosaic-content">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'mosaic-entry' ); ?>>
				<h2 class="mosaic-entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="mosaic-entry__content"><?php the_excerpt(); ?></div>
			</article>
		<?php endwhile; ?>
		<?php the_posts_navigation(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Записей пока нет.', 'denkon-mosaic' ); ?></p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
