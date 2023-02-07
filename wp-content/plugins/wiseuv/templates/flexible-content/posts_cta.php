<?php 
$eyebrow = get_sub_field('eyebrow');
$heading = get_sub_field('heading');
$text = get_sub_field('text');
$cta = get_sub_field('cta');
$post_type = get_sub_field('post_type'); //post page or work
$query_type = get_sub_field('query_type'); //all, featured or exclude-featured
$category_slug = get_sub_field('category_slug');
$max_posts = get_sub_field('max_posts'); //default 3
$column_1_animation = get_sub_field('column_1_animation');
$column_2_animation = get_sub_field('column_2_animation');
$column_animation_anchor_placement = get_sub_field('column_animation_anchor_placement');
$column_animation_easing = get_sub_field('column_animation_easing');
$column_animation_easinganimation_speed = get_sub_field('column_animation_easinganimation_speed');
$container_id = bin2hex(random_bytes(5));
switch ($post_type) {
    case 'post':
        $taxonomy = 'category';
        break;
    case 'page';
        $taxonomy = 'page-category';
        break;
    case 'product':
        $taxonomy = 'product_cat'; //or services?
        break;
    default: 
        $taxonomy = 'category';
        break;
}
switch ($query_type) {
    case 'all':
        $tax_query = array();
        break;
    case 'featured';
        $tax_query = array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => array( 'featured' ),
                'operator' => 'IN',
            ),
        );
        break;
    case 'exclude-featured':
        $tax_query = array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => array( 'featured' ),
                'operator' => 'NOT IN',
            ),
        );
        break;
    case 'category':
        $tax_query = array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => array( $category_slug ),
                'operator' => 'IN',
            ),
        );
        break;
    default: 

}

echo '<div class="flexible-content posts-cta" id="posts-'.$container_id.'">';
    if($eyebrow != '') {
        echo '<div class="eyebrow">'.wise_content_filters($eyebrow).'</div>';
    }
    echo '<div class="cta-content">';
        echo '<div class="cta-posts';
        if($column_1_animation != 'none') {
            echo ' has-aos" data-aos="'.$column_1_animation.'" data-aos-easing="'.$column_animation_easing.'" data-aos-anchor-placement="'.$column_animation_anchor_placement.'" data-aos-duration="'.$column_animation_easinganimation_speed.'"';
        } else {
            echo '"';
        }
        echo '>';
            //query posts
            $cta_args = array(
                'post_type' => $post_type,
                'tax_query' => $tax_query,
                'posts_per_page' => $max_posts
            );
            $cta_query = new WP_Query( $cta_args );
            if ( $cta_query->have_posts() ) : 
                while( $cta_query->have_posts() ) : $cta_query->the_post();
                    $cta_post_id = get_the_ID();
                    $post_heading = get_the_title($cta_post_id);
                    $post_content = get_the_excerpt(); 
                    $post_link = get_the_permalink();
                    
                    
                
                    echo '<div class="cta-post">';
                        echo '<a class="block-link" href="'.esc_url( $post_link ).'" title="View '.$post_heading.'"></a>';
                        echo '<div class="feature-image">';
                            if(has_post_thumbnail()) {
                                echo '<div class="image-container" style="background-image:url('.get_the_post_thumbnail_url($cta_post_id,'wise-hero').');"></div>';
                            }
                            echo '<div class="post-meta">';
                                $author_id = get_the_author_meta('ID');
                                echo '<div class="author">Posted by <span>'.get_the_author_meta('display_name', $author_id).'</span></div>';
                                echo get_avatar($author_id);
                            echo '</div>';
                        echo '</div>';
                    
                        echo '<div class="cta-post__details">';
                            if($post_heading != '') {
                                echo '<h3 class="font-blog">';
                                    echo wise_content_filters($post_heading);
                                echo '</h3>';
                            }
                            if($post_content != '') {
                                echo '<div class="excerpt">'.wise_content_filters($post_content).'</div>';
                            }
                            echo '<div class="date">'.get_the_date().'</div>';
                        echo '</div>';
                        
                        
                    echo '</div>';
                        
                endwhile;
            else:
                echo '<p>Sorry, there are no '.$post_type.'s to show.</p>';
            endif;
            wp_reset_query();
        echo '</div>';

        //right column details
        echo '<div class="cta';
        if($column_2_animation != 'none') {
            echo ' has-aos" data-aos="'.$column_2_animation.'" data-aos-easing="'.$column_animation_easing.'" data-aos-anchor-placement="'.$column_animation_anchor_placement.'" data-aos-duration="'.$column_animation_easinganimation_speed.'"';
        } else {
            echo '"';
        }
        echo '>';
        if($heading != '') {
            echo '<h2 class="font-bigger">'.$heading.'</h2>';
        }
        if($text != '') {
            echo '<p>'.$text.'</p>';
        }
        if($cta) {
            $link_url = $cta['url'];
            $link_title = $cta['title'];
            $link_target = $cta['target'] ? $cta['target'] : '_self';
            echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.wise_content_filters(esc_html( $link_title )).'</a>';
        }
     echo '</div>';
    echo '</div>';
echo '</div>';