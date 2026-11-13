<?php
/**
 * Page template.
 *
 * @package DenkonMosaic
 */

get_header();

$denkon_mosaic_has_pattern = denkon_mosaic_page_has_theme_pattern();
?>
<div class="<?php echo $denkon_mosaic_has_pattern ? 'mosaic-content mosaic-content--with-pattern' : 'mosaic-container mosaic-content'; ?>">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'mosaic-page' ); ?>>
			<?php if ( ! $denkon_mosaic_has_pattern ) : ?>
				<h1 class="mosaic-page__title"><?php the_title(); ?></h1>
			<?php endif; ?>
			<div class="mosaic-page__content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>
		</article>
		<?php if ( comments_open() || get_comments_number() ) : ?>
			<?php comments_template(); ?>
		<?php endif; ?>
	<?php endwhile; ?>
</div>
<?php get_footer(); ?>
