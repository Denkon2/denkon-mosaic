<?php
/**
 * Comments template.
 *
 * @package DenkonMosaic
 */

if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="mosaic-comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="mosaic-comments__title">
			<?php esc_html_e( 'Комментарии', 'denkon-mosaic' ); ?>
		</h2>

		<ol class="mosaic-comments__list comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply'          => __( 'Оставить комментарий', 'denkon-mosaic' ),
			'title_reply_to'       => __( 'Ответить пользователю %s', 'denkon-mosaic' ),
			'cancel_reply_link'    => __( 'Отменить ответ', 'denkon-mosaic' ),
			'label_submit'         => __( 'Отправить комментарий', 'denkon-mosaic' ),
			'comment_notes_before' => '',
		)
	);
	?>
</section>
