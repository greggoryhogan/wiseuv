<?php 
/*
 *
 * Add acf json folder for saving
 *
 */    
add_filter('acf/settings/save_json', 'wise_acf_json_save_point');
function wise_acf_json_save_point( $path ) {
    // update path
    $path = WISE_PLUGIN_DIR . '/includes/acf-json';
    // return
    return $path; 
}
/*
 *
 * Add acf json folder for loading
 *
 */
add_filter('acf/settings/load_json', 'wise_acf_json_load_point');
function wise_acf_json_load_point( $paths ) {
    // remove original path (optional)
    unset($paths[0]);
    // append path
    $paths[] = WISE_PLUGIN_DIR . '/includes/acf-json';
    // return
    return $paths;
}

/*
 *
 * Add Custom Block Category for Sacred theme
 * 
 */
add_filter( 'block_categories_all', 'wise_block_categories', 10, 2 );
function wise_block_categories( $categories, $post ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'redeeming-wise',
                'title' => __( 'Redeeming wise', 'sacred' ),
                'icon'  => '',
            ),
        )
    );
}

/**
 * Filter link popup to only include specific post type
 */
add_filter( 'wp_link_query_args', 'wise_wp_link_query_args' ); 
function wise_wp_link_query_args( $query ) {
    // check to make sure we are not in the admin
    if ( is_admin() ) {
        $flexible_post_types = array('post','page','product','sfwd-courses','sfwd-lesson','sfwd-topic');
        $query['post_type'] = $flexible_post_types;
    }

    return $query;
}

// Enqueue scripts & styles if frontend
function testimonial_assets() {
    wp_enqueue_style( 'slick-css' );
    wp_enqueue_script('slick-js');
}

add_filter('the_content','wise_content_filter',99,1);
function wise_content_filter($content) {
    global $post;
    $acf_post_types = array(
        'post',
        'page',
        'product',
    );
    if(!in_array(get_post_type(),$acf_post_types)) {
        //return $content;
    }
    ob_start();
    if(function_exists('get_field')) {
        $field_name = 'flexible_content';
        $flexible_post_id = get_the_ID();
        //iterate each flexible section
        if ( have_rows( $field_name, $flexible_post_id ) ) {			
            $band = 0;
            while ( have_rows( $field_name, $flexible_post_id ) ) : the_row();	
                ++$band;
                $continue = true;
                $row_layout = get_row_layout();
                if($row_layout == 'workbook_content') {
                    $workbook_question = get_sub_field('workbook_question');
                    if($workbook_question == 0) {
                        $continue = false; //skip it since there was no question defined
                    }
                }
                if($continue) {
                    $row_classes = '';
                    if($row_layout == 'two_column_content') {
                        $image_style = get_sub_field('image_style');
                        if($image_style == 'fill-space') {
                            $row_classes .= ' fill-space-image';
                        }
                    }
                    echo '<section id="wise-content-band-'.$band.'" class="'.$row_layout.$row_classes;
                        $background_style = get_sub_field('background_style');
                        $container_size = 'container__'. get_sub_field('container_width');
                        $block_color_scheme = get_sub_field('block_color_scheme');
                        $button_style = get_sub_field('button_style');
                        $text_alignment = get_sub_field('text_alignment');
                        $full_width_bgs = array(
                            'fill-space-image',
                            'green-gradient',
                            'green-blue-gradient'
                        );
                        if($background_style != 'none') {
                            echo ' has-bg-image';
                            if(in_array($background_style,$full_width_bgs)) {
                                echo ' '.$background_style;
                            }
                        } 
                        echo '">';
                            if($background_style != 'none' && !in_array($background_style,$full_width_bgs)) {
                                $background_position = get_sub_field('background_position');
                                echo '<div class="bg-image-container container '.$container_size.' '.$background_style.' background-position-'.$background_position.'"></div>';
                            }
                            if($row_layout == 'two_column_content') {
                                //add 'fill space' image for two column content
                                if($image_style == 'fill-space') {
                                    $image_size = get_sub_field('image_size');
                                    $image = get_sub_field('image'); 
                                    if($image) {
                                        $img_arr = wp_get_attachment_image_src( $image, $image_size );
                                        echo '<div class="fill-space-image left" style="background-image: url('.$img_arr[0].');"></div>'; // had <img src="'.$img_arr[0].'" /> inside
                                    }
                                    $image2 = get_sub_field('image_2'); 
                                    if($image2) {
                                        $img_arr2 = wp_get_attachment_image_src( $image2, $image_size );
                                        echo '<div class="fill-space-image right" style="background-image: url('.$img_arr2[0].');"><img src="'.$img_arr2[0].'" /></div>';
                                    }
                                }
                            }
                            echo '<div class="container flex-content-container '.$container_size.' block-style-'.$block_color_scheme.' button-style-'.$button_style.' text-alignment-'.$text_alignment.'"';
                                $aos_animation = get_sub_field('animation');
                                if($aos_animation != 'none') {
                                    $easing = get_sub_field('easing');
                                    $anchor_placement = get_sub_field('anchor_placement');
                                    $speed = get_sub_field('animation_speed');
                                    echo ' data-aos="'.$aos_animation.'" data-aos-easing="'.$easing.'" data-aos-anchor-placement="'.$anchor_placement.'" data-aos-duration="'.$speed.'"';
                                }
                            echo '>';
                                echo '<div class="container-content">';
                                    $filename = WISE_PLUGIN_DIR.'templates/flexible-content/' . get_row_layout().'.php';
                                    if(file_exists($filename)) {
                                        include($filename);
                                    }
                                echo '</div>';
                            echo '</div>';
                            
                    echo '</section>';
                }
            endwhile;
            //wp_reset_postdata();
            $post_type = get_post_type();
            if($post_type == 'product') {
                $container_width = get_option('woo_container_width');
                global $product;
                $product_id = $product->get_id();
                $buy_now_page = get_field('buy_now_page',$product_id);

                $course_id = get_post_meta($product_id,'_related_course',true);
                if(!$course_id) {
                    $product = new WC_Product_Variable($product_id);
                    $variations = $product->get_available_variations();
                    foreach ($variations as $variation) {
                        $course_id = get_post_meta($variation['variation_id'],'_related_course', true);
                        if(is_array($course_id)) {
                            $course_id = $course_id[0];
                        }
                    }
                } else if(is_array($course_id)) {
                    $course_id = $course_id[0];
                }
                $price = wise_get_woo_product_lowest_price($product_id);
                $buttontext = 'Buy This Course';
                if($price == 0) {
                    $buttontext = 'Check Out This Course for Free';
                }
                echo '<section class="product">';
                    echo '<div class="container container__'.$container_width.' block-style-dark text-alignment-left">';
                        echo '<div class="container-content">';
                            echo '<div class="flexible-content course-content pb-5 text-center"><a class="btn btn-primary" href="'.$buy_now_page.'">'.$buttontext.'</a></div>';
                        echo '</div>';
                    echo '</div>';
                echo '</section>';
                
            } 
            
        } elseif (basename(get_page_template()) == 'template-blog.php') {
            echo $content;
        } else {
            $post_type = get_post_type();
            switch($post_type) {
                case 'product':
                    $container_width = get_option('woo_container_width');
                    break;
                case 'post':
                    $container_width = get_option('post_container_width');
                    break;
                case 'sfwd-courses':
                    $container_width = get_option('course_container_width');
                    break;
                default:
                    $container_width = 'normal';
                    break;
            }
            echo '<section class="'.$post_type.'">';
                echo '<div class="container container__'.$container_width.' block-style-dark text-alignment-left">';
                    echo '<div class="container-content">';
                        echo $content;
                    echo '</div>';
                echo '</div>';
            echo '</section>';
        }
    } else {
        echo '<section class="default">';
            echo '<div class="container container__normal block-style-dark text-alignment-left">';
                echo '<div class="container-content">';
                    echo $content;
                echo '</div>';
            echo '</div>';
        echo '</section>';
    }
    $content = str_replace("\r\n",'',trim(ob_get_clean()));
    return $content;
}