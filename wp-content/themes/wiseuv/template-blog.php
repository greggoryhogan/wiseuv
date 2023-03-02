<?php 
/**
* Template Name: Blog
*/ ?>

<?php get_header();
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$exclude = array();
$args = array(
    'posts_per_page' => 1,
    'category' => 'featured',
    'ignore_sticky_posts' => 1 
);
$blog_featured_post = new WP_Query( $args );
if ( $blog_featured_post->have_posts() ) {
    while ( $blog_featured_post->have_posts() ) {
        $blog_featured_post->the_post(); 
        $exclude[] = get_the_ID();
        if($paged == 1) {
            get_template_part('templates/content-blog-item-featured'); 
        }
    } // end while
} // end if

$args = array(
  'posts_per_page' => get_option( 'posts_per_page' ),
  'post__not_in' => $exclude,
  'paged' => $paged
);
$blog_posts = new WP_Query( $args );
?>
<?php 
echo '<section class="blog-posts">';
    if ( $blog_posts->have_posts() ) {
        while ( $blog_posts->have_posts() ) {
            $blog_posts->the_post(); 
                get_template_part('templates/content-blog-item'); 
        } // end while
        if (function_exists('babel_pagination_nav')) {
            echo '<section class="blog-navigation">';
                echo '<div class="container container__sm text-alignment-left">';
                    echo '<div class="container-content">';
                        babel_pagination_nav($blog_posts);
                    echo '</div>';
                echo '</div>';
            echo '</section>';
        }
    } // end if
echo '</section>';
?>
<?php get_footer(); ?>