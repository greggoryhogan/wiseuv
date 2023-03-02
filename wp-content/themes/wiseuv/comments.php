<?php
/**
 * The template for displaying Comments.
 */
$post_id = get_the_ID();
$container_width = get_option('post_container_width');
echo '<section class="blog-footer">';
	echo '<div class="container container__'.$container_width.' block-style-dark text-alignment-left">';
		echo '<div class="container-content">';
			echo '<div class="flexible-content comments">';
				if ( post_password_required() ) : ?>
					<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'henry' ); ?></p>
					</div>
					<?php return;
				endif;

				
				if ( have_comments() ) : ?>
	
					<div class="comments-count">
						<span>
						<?php
							printf( esc_html(_nx( '1 Comment', '%1$s Comments', get_comments_number(), 'comments title', 'novablog' )),
							number_format_i18n( get_comments_number() ), get_the_title() );
						?>
						</span>
				</div>
					<ul class="commentlist">
						<?php wp_list_comments(	array(
								'type'       => 'comment',
								'callback'   => 'babel_comment',
							)); ?>
					</ul>
			
					<div class="pagination">
					<?php paginate_comments_links(); ?> 
					</div>
				
				<?php else : ?>
			
				<?php if ( comments_open() ) : ?>
				<?php echo '<p class="nocomments">No comments yet.</p>'; ?>
					<?php else : ?>
			
					<?php endif; ?>
				
				<?php endif;

				if(is_user_logged_in()) {
					$args = array(
						'logged_in_as' => sprintf(
							'<p class="logged-in-as">%s %s</p>',
							sprintf(
								__( 'Logged in as %1$s. <a href="%2$s">Log out?</a>' ),
								$user_identity,
								wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ), $post_id ) )
							),
							'Required fields are marked *'
						),
					);
					comment_form($args);
				} else {
					$post_id = get_the_ID();
					echo '<h3 class="comment-reply-title">Leave a Reply</h3>';
					echo '<p class="text-center comments-logged-in-notification"><em>You must be logged in to comment. Please <a href="'.get_bloginfo('url').'/login/?page-redirect='.$post_id.'">log in</a> or <a href="'.get_bloginfo('url').'/subscribe/?page-redirect='.$post_id.'" data-type="page" data-id="'.get_the_ID().'">subscribe</a>.</em></p>';
				}
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</section>';
?>