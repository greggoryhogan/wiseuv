<?php get_header(); ?>
<?php 
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		$post_id = get_the_ID();
		if(get_post_type() != 'podcasts') {
			echo '<section class="blog-hero';
				$alternate_featured_image = get_field('alternate_featured_image');
				if($alternate_featured_image) {
					echo ' has-bg-image" style="background-image: url('.$alternate_featured_image['url'].')">';
				} else if(has_post_thumbnail()) {
					$img = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
					echo ' has-bg-image" style="background-image: url('.$img[0].')">';
				} else {
					//just close
					echo '">';
				}
				echo '<div class="container container__normal block-style-light text-alignment-left">';
					echo '<div class="container-content">';
						echo '<div class="flexible-content blog-section single-post">';
							echo '<div class="post-details">';
								echo '<h1>'.get_the_title().'</h1>';
								babel_post_details($post_id);
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</section>';
		} else {
			//simple podcast heading
			echo '<section class="heading">';
				echo '<div class="container flex-content-container container__normal block-style-dark button-style-orange text-alignment-left">';
					echo '<div class="container-content">';
						echo '<div class="flexible-content heading podcast-heading align-left">';
							echo '<div class="podcast-logo">';
								echo '<img src="'.get_bloginfo('template_url').'/assets/img/GoodFaithPodcast.jpg" alt="Good Faith Podcast" />';
							echo '</div>';
							echo '<div class="podcast-heading">';
								echo '<h1 class="font-biggest font-weight-normal">'.get_the_title().'</h1>';
								babel_post_details($post_id);
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</section>';
		}
		//output content
		if(function_exists('wise_content')) {
			wise_content();
		} else {
			$the_content = apply_filters('the_content',get_the_content());
			echo $the_content;
		}
		//blog footer
		if(get_post_type() == 'post') {
			$container_width = get_option('post_container_width');
			echo '<section class="blog-footer">';
				echo '<div class="container container__'.$container_width.' block-style-dark text-alignment-left">';
					echo '<div class="container-content">';
						echo '<div class="flexible-content blog-section post-footer">';
							echo '<div class="col">';
								$hosts = get_field('hosts');
								if($hosts) {
									echo '<p class="flex"><span class="highlight">Hosts: </span> ';
									$count = 0;
									echo '<span>';
									foreach($hosts as $host) {
										++$count;
										//print_r($host);
										if($count > 1) {
											echo ' and ';
										}
										echo $host['display_name'];
									}
									echo '</span>';
									echo '<span>';
									foreach($hosts as $host) {
										echo get_avatar($host['ID']);
									}
									echo '</span>';
									echo '</p>';
								}
								$producer = get_field('producer');
								if($producer) {
									echo '<p class="mb-4 flex"><span class="highlight">Producer: </span> '.$producer.'</p>';
								}
								$post_footer = get_field('post_footer');
								echo '<div class="post-credits">'.$post_footer.'</div>';
							echo '</div>';
							echo '<div class="col">';
								$tags = get_the_tags();
								if(!empty($tags)) {
									echo '<p class="tagged';
									if(!$hosts) {
										echo ' less-margin';
									} else {
										echo ' has-content-left';
									}
									echo '">Tagged as ';
									foreach($tags as $tag) {
										//print_r($tag);
										echo '<a href="'.get_bloginfo('url').'/tag/'.$tag->slug.'">'.$tag->name.'</a>';
									}
									echo '</p>';
								}
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</section>';
		}

		if(babel_comments_active()) {
			if ( comments_open() ) {
				comments_template();
			}
		}
        
	} // end while
} // end if
?>
<?php get_footer(); ?>