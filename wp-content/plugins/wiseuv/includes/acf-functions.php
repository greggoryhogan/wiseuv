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
    if ( post_password_required( $post )) {
        echo get_the_password_form();
    } else {
        if(function_exists('get_field')) {
            $field_name = 'flexible_content';
            $flexible_post_id = get_the_ID();
            //iterate each flexible section
            if ( have_rows( $field_name, $flexible_post_id ) ) {			
                $band = 0;
                while ( have_rows( $field_name, $flexible_post_id ) ) : the_row();	
                    ++$band;
                    
                    $row_layout = get_row_layout();
                    
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
                                echo ' <div class="custom-shape-divider-top-1677785256" id="clippy">
                                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                                    <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
                                </svg>
                            </div>';
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
    }
    $content = str_replace("\r\n",'',trim(ob_get_clean()));
    return $content;
}

/**
 * Add flexible content band paddings to css in header
 */
add_action('wp_head','wise_acf_header_css');
function wise_acf_header_css() {
	$flexible_post_types = array('post','page','product');
	$post_type = get_post_type();
	if(in_array($post_type,$flexible_post_types) && function_exists('get_field')) {
		$acf_field_name = 'flexible_content';
		$acf_post_id = get_the_ID();
		//iterate each flexible section
		if ( have_rows( $acf_field_name, $acf_post_id ) ) :			
			$band = 0;
			$desktop_padding = '';
			$tablet_padding = '';
			$mobile_padding = '';
			$globals = '';
			while ( have_rows( $acf_field_name, $acf_post_id ) ) : the_row();	
				++$band;
				$acf_row_layout = get_row_layout();
				$heading_color = get_sub_field('heading_color');
				if($heading_color != '#333333') {
					$globals .= '#wise-content-band-'.$band.' h1, #wise-content-band-'.$band.' h2, #wise-content-band-'.$band.' h3, #wise-content-band-'.$band.' h4, #wise-content-band-'.$band.' h5, #wise-content-band-'.$band.' h6 {color: '.$heading_color.';}';
				}
				$text_color = get_sub_field('text_color');
				if($text_color != '#333333') {
					$globals .= '#wise-content-band-'.$band.' .contain-content > *:not(h1,h2,h3,h4,h5,h6) {color: '.$text_color.';}';
				}

				$background_color = strtolower(get_sub_field('background_color'));
                $globals .= '.custom-shape-divider-top-1677785256 {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    overflow: hidden;
                    line-height: 0;
                }
                
                .custom-shape-divider-top-1677785256 svg {
                    position: relative;
                    display: block;
                    width: calc(300% + 1.3px);
                    height: 144px;
                }
                
                .custom-shape-divider-top-1677785256 .shape-fill {
                    fill: #FFFFFF;
                }';
				if(substr($background_color,0,4) != '#fff') {
                    $globals .= '#wise-content-band-'.$band.' {clip-path:url(#clippy); background-color:'.$background_color.';}';
				}
				$desktop_padding .= '#wise-content-band-'.$band.'{margin:'.get_sub_field('desktop_margin').';}';
				$tablet_padding .= '#wise-content-band-'.$band.'{margin:'.get_sub_field('tablet_margin').';}';
				$mobile_padding .= '#wise-content-band-'.$band.'{margin:'.get_sub_field('mobile_margin').';}';
				
				$desktop_padding .= '#wise-content-band-'.$band.'{padding:'.get_sub_field('desktop_padding').';}';
				$tablet_padding .= '#wise-content-band-'.$band.'{padding:'.get_sub_field('tablet_padding').';}';
				$mobile_padding .= '#wise-content-band-'.$band.'{padding:'.get_sub_field('mobile_padding').';}';
				if($acf_row_layout == 'testimonials_slider') {
					//wp_enqueue_style( 'slick-css' );
					//wp_enqueue_script( 'slick-js' );
				}
				if($acf_row_layout == 'data_and_statistics') {
					wp_enqueue_script('countup');
				}
				if($acf_row_layout == 'two_column_content') {
					if(get_sub_field('limit_text_width') == 'yes') {
						$desktop_padding .= '#wise-content-band-'.$band.' .contain-content > *:not(.image) {max-width:'.get_sub_field('desktop_width').'%;}';
						$tablet_padding .= '#wise-content-band-'.$band.' .contain-content > *:not(.image) {max-width:'.get_sub_field('tablet_width').'%;}';
					}
					if(get_sub_field('limit_image_width') == 'yes') {
						$desktop_padding .= '#wise-content-band-'.$band.' .contain-content > .image {max-width:'.get_sub_field('image_desktop_width').'%;}';
						$tablet_padding .= '#wise-content-band-'.$band.' .contain-content > .image {max-width:'.get_sub_field('image_tablet_width').'%;}';
					}
				}
			endwhile;
			?>
			<style type="text/css">
				<?php echo $globals; ?>
				@media all and (min-width: 73rem) {<?php echo $desktop_padding; ?>}
				@media all and (max-width: 73rem) and (min-width: 48rem) { <?php echo $tablet_padding; ?> } 
				@media all and (max-width: 48rem) { <?php echo $mobile_padding; ?> }
			</style><?php 
		endif;
	}
}