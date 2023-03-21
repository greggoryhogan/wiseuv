<?php get_header(); ?>
<?php if(isset($_GET['s'])) {
	$searchterm = sanitize_text_field($_GET['s']);
} else {
	$searchterm = '';
} ?>
<section id="rb-content-band-4" class="wysiwyg section__search_form" style="background-color: #978dbe;padding: 2rem 0;z-index: 10;">
	<div class="container flex-content-container container__xs block-style-dark button-style-orange text-alignment-center">
		<div class="container-content">
			<div class="flexible-content wysiwyg">
				<div class="wysiwyg-content">
					<?php echo get_search_form(); ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php if(isset($_GET['s'])) { 
	if($_GET['s'] != '') { ?>
		<section id="rb-content-band-1" class="heading"  style="padding: 2rem 0;">
			<div class="container flex-content-container container__normal block-style-dark button-style-orange text-alignment-center">
				<div class="container-content">
					<div class="flexible-content heading align-center">
						<h1 class="font-biggest font-weight-bold">Search Results for &ldquo;<?php echo $searchterm; ?>&rdquo;</h1>
					</div>
				</div>
			</div>
		</section>
	<?php } ?>
<?php } ?>
<section id="rb-content-band-4" class="wysiwyg section__search_results" style="padding: 2rem 0;z-index: 10;">
	<div class="container flex-content-container container__sm block-style-dark button-style-orange text-alignment-left">
		<div class="container-content">
			<div class="flexible-content wysiwyg">
				<div class="wysiwyg-content">
					<?php if(get_search_query() != '') { 
						$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
						$args = array(
							'posts_per_page' => -1,
							'paged' => $paged,
							's' => $searchterm,
							'post_type' => array('post','page'),
							'post_status' => 'publish',
							'has_password'   => FALSE
						);
						$blog_posts = new WP_Query( $args );

							if(have_posts()) { 
								
									while ( $blog_posts->have_posts() ) {
										$blog_posts->the_post(); 
											get_template_part('templates/content-blog-item'); 
									} // end while
									if (function_exists('babel_pagination_nav')) {
										babel_pagination_nav($blog_posts);
									}
								
							} else { ?>
								<p style="text-align: center;">
									Sorry, your search term returned 0 results.
								</p><?php 
							}
					} ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>