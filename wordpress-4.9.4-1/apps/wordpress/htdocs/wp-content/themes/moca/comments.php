<?php
if ( post_password_required() ) { return; }
?>
	<?php
	if ( have_comments() ) : ?>
		<h2 class="comments_title">
			<?php
			if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
			$comments_number = get_comments_number();
			if ( '1' < $comments_number ) {
				echo __( 'Comments
				', 'moca' ).number_format_i18n( $comments_number );
			}
			?>
		</h2>
		<ul class="comment_list">
			<?php
				wp_list_comments( array(
					'avatar_size' => 50,
					'style'       => 'ul',
					'short_ping' => true,
				) );
			?>
		</ul>
		<?php the_comments_pagination();
	endif; // Check for have_comments().
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no_comments"><?php _e( 'Comments are closed.', 'moca' ); ?></p>
	<?php
	endif;
	comment_form();
