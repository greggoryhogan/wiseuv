<?php get_header(); ?>
<?php 
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		if(function_exists('wise_content')) {
			wise_content();
		} else {
			$the_content = apply_filters('the_content',get_the_content());
			echo $the_content;
		}
	} // end while
} // end if
?>
<?php get_footer(); ?>