<?php
/**
 * Single post template.
 *
 * @package DenkonMosaic
 */

get_header();
?>
<div class="mosaic-container mosaic-content">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'mosaic-page' ); ?>>
			<?php the_title( '<h1 class="mosaic-page__title">', '</h1>' ); ?>
			<div class="mosaic-entry__meta"><?php echo esc_html( get_the_date() ); ?></div>
			<div class="mosaic-page__content"><?php the_content(); ?></div>
		</article>
		<?php the_post_navigation(); ?>
		<?php if ( comments_open() || get_comments_number() ) : ?>
			<?php comments_template(); ?>
		<?php endif; ?>
	<?php endwhile; ?>
</div>
<?php get_footer(); ?>
