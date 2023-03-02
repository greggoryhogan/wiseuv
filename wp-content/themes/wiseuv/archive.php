<?php get_header(); ?>
<?php 
global $wp_query;
//print_r($wp_query);
echo '<section class="archive">';
	echo '<div class="container container__normal block-style-dark button-style-dark text-alignment-left">';
		echo '<div class="container-content">';
			echo '<div class="flexible-content heading">';
				echo '<h1>'.get_the_archive_title().'</h1>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</section>';

if ( have_posts() ) {
	echo '<section class="blog-posts">';
		while ( have_posts() ) {
			the_post(); 
			get_template_part('templates/content-blog-item'); 
		} // end while
		if (function_exists('babel_pagination_nav')) {
			echo '<section class="blog-navigation">';
				echo '<div class="container container__sm text-alignment-left">';
					echo '<div class="container-content">';
						babel_pagination_nav($wp_query);
					echo '</div>';
				echo '</div>';
			echo '</section>';
		}
	echo '</section>';
} // end if
?>
<?php get_footer(); ?>