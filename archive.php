<?php
/**
 * Archive template.
 *
 * @package DenkonMosaic
 */

get_header();
?>
<div class="mosaic-container mosaic-content">
	<header class="mosaic-archive-header"><h1><?php the_archive_title(); ?></h1><?php the_archive_description( '<div>', '</div>' ); ?></header>
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'mosaic-entry' ); ?>><h2 class="mosaic-entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php the_excerpt(); ?></article>
		<?php endwhile; ?>
		<?php the_posts_navigation(); ?>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
