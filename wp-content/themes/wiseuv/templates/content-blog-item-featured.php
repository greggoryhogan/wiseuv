<?php 
$permalink = get_permalink();
$title = get_the_title();
echo '<section class="two_column_content fill-space-image blog-feature">';
	if(has_post_thumbnail()) {
		$img = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
		echo '<div class="fill-space-image right" style="background-image: url('.$img[0].')">';
			echo '<a href="'.$permalink.'" title="Read '.$title.'"></a>';
		echo '</div>';
	}
	echo '<div class="container container__normal block-style-dark button-style-dark text-alignment-left">';
		echo '<div class="container-content">';
			echo '<div class="flexible-content two-column-content normal align-top column-width-50-50 blog-section blog-featured">';
				echo '<div class="contain-content">';
					echo '<div class="eyebrow">Featured Article</div>';
					get_template_part('templates/content-blog-item-text'); 
				echo '</div>';
				echo '<div class="right contain-content">';
					echo '<div class="image auto-width fill-space">';
						if(has_post_thumbnail()) {
							echo '<a href="'.$permalink.'" title="Read '.$title.'">';
								the_post_thumbnail();
							echo '</a>';
						}
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</section>';