<?php 
echo '<section class="two_column_content blog-post">';
	echo '<div class="container container__sm block-style-dark button-style-dark text-alignment-left">';
		echo '<div class="container-content">';
			echo '<div class="flexible-content two-column-content normal align-top blog-section blog-single">';
				if(!is_search()) {
					echo '<div class="contain-content">';
						echo '<div class="image no-margin border-radius__md">';
						$permalink = get_permalink();
						$title = get_the_title();
						if(has_post_thumbnail()) {
							echo '<a href="'.$permalink.'" title="Read '.$title.'">';
								the_post_thumbnail('rb-blog');
							echo '</a>';
						} else if(get_post_type() == 'podcasts') {
							echo '<a href="'.$permalink.'" title="Read '.$title.'">';
								echo '<img src="'.get_bloginfo('template_url').'/assets/img/good-faith-podcast.jpg" alt="Good Faith Podcast" />';
							echo '</a>';
						}
						echo '</div>';
					echo '</div>';
				}
				echo '<div class="right contain-content">';
					get_template_part('templates/content-blog-item-text'); 			
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</section>';