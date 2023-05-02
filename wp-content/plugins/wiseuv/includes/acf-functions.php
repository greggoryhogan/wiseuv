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

/**
 * Add hook to add shortcodes to the content during save. This is a hack to make the has_shortcode($post->content) work with other plugins
 */
add_action('save_post','append_to_wise_post_content');
function append_to_wise_post_content($post_id){
    global $post; 
    if(function_exists('get_field')) {
        $field_name = 'flexible_content';
        //iterate each flexible section
        if ( have_rows( $field_name, $post_id ) ) {
            $content = '';
            //$rowct = 0;
            while(have_rows( $field_name, $post_id )) {
                the_row();	
                //++$rowct;
                $row_layout = get_row_layout();
                if($row_layout == 'heading') { // && $rowct > 1
                    $heading = get_sub_field('heading');
                    $tag = get_sub_field('tag');
                    $content .= '<'.$tag.'>'.$heading.'</'.$tag.'>';
                }
                if($row_layout == 'list') {
                    $list_ordering = get_sub_field('list_ordering');
                    if( have_rows('list_items') ):
                        $content .= '<'.$list_ordering.'>';
                            while ( have_rows('list_items') ) : the_row();
                                $content .= '<li>';
                                    $label = get_sub_field('label');
                                    $text = get_sub_field('text');
                                    if($label != '') {
                                        $content .= $label.' ';
                                    }
                                    if($text != '') {
                                        $content .= $text;
                                    }
                                $content .= '</li>';
                            endwhile;
                        $content .= '</'.$list_ordering.'>';
                    
                    endif;
                }
                if($row_layout == 'two_column_content' || $row_layout == 'three_column_content') {
                    $heading_type = get_sub_field('heading_type');
                    $content .= '<'.$heading_type.'>'.get_sub_field( 'heading' ).'</'.$heading_type.'>';
                    $content .= get_sub_field('content');
                    $content .= '<'.$heading_type.'>'.get_sub_field( 'heading_2' ).'</'.$heading_type.'>';
                    $content .= get_sub_field('content_2');
                    if($row_layout == 'three_column_content') {
                        $content .= '<'.$heading_type.'>'.get_sub_field( 'heading_3' ).'</'.$heading_type.'>';
                        $content .= get_sub_field('content_3');
                    }
                }
                if($row_layout == 'wysiwyg') {
                    $content .= get_sub_field('content');
                }
                if($row_layout == 'shortcode') {
                    $content .= get_sub_field('shortcode');
                }
            }
            if($content == '') {
                $content = '<!--'.print_r(get_post_meta($post_id),true).'-->';
            }
            $post = get_post( $post_id );
            $post->post_content = $content;
            //Add excerpt if it isn't set
            /*if(!has_excerpt($post_id)) {
                $post->post_excerpt = substr(strip_tags($content), 0, 100);
            }*/
            remove_action('save_post','append_to_wise_post_content');
            wp_update_post( $post );
            add_action('save_post','append_to_wise_post_content');
        }
    }    
}

//add_filter('the_content','wise_content_filter',99,1);
function wise_content() {
    global $post;
    $acf_post_types = array(
        'post',
        'page',
    );
    if(!in_array(get_post_type(),$acf_post_types)) {
        //return $content;
    }
    
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
                    $block_color_scheme = get_sub_field('color_scheme');
                    $button_style = get_sub_field('button_style');
                    $first_button_color = get_sub_field('first_button_color');
                    $text_alignment = get_sub_field('text_alignment');
                    echo '<section id="wise-content-band-'.$band.'" class="'.$row_layout.' block-style-'.$block_color_scheme.' button-style-'.$button_style.' button-alternating-'.$first_button_color.' text-alignment-'.$text_alignment;
                        if($row_layout == 'hero') {
                            $style = get_sub_field('style');
                            $background_image = get_sub_field('background_image');
                            echo ' style-'.$style;
                            if($background_image != '') {
                                echo ' has-bg-img';
                            } else {
                                echo ' no-img';
                            }
                        }
                        echo '">';
                        $container_size = 'container__'. get_sub_field('container_width');
                        $container_alignment = 'container__align-'. get_sub_field('container_alignment');
                            if($row_layout == 'hero') {
                                if($background_image != '') {
                                    echo '<div class="background-image">';
                                        $overlay = get_sub_field('overlay');
                                        if($overlay != 'none') {
                                            $overlay_color = get_sub_field('overlay_color');
                                            echo '<div class="overlay '.$overlay.'" style="background: '.$overlay_color.';"></div>';
                                        }
                                    echo '</div>';
                                }
                                if($style == 'cropped-wave') {
                                    echo '<img src="'.WISE_URL.'includes/img/wave-1-clippath-top.svg" class="clippingPath -top" />';
                                    echo '<img src="'.WISE_URL.'includes/img/wave-1-clippath-bottom.svg" class="clippingPath -bottom" />';
                                    if($background_image != '') {
                                        echo '<div class="hero-image">';
                                            echo '<img src="'.WISE_URL.'includes/img/wave-1-clippath-top-mobile-'.$block_color_scheme.'.png" class="clippingPath -middle" />';
                                            echo wp_get_attachment_image( $background_image, 'full' );
                                        echo '</div>';
                                    } else {
                                        echo '<img src="'.WISE_URL.'includes/img/wave-1-clippath-top-mobile-'.$block_color_scheme.'.png" class="clippingPath -middle" />';
                                    }
                                }
                            }
                            if($row_layout == 'banner_content') {
                                echo '<div class="top"></div>';
                                echo '<div class="middle">';
                            }
                            echo '<div class="container flex-content-container '.$container_size.' '.$container_alignment.'"';
                                $aos_animation = get_sub_field('animation');
                                if($aos_animation) {
                                    if($aos_animation != 'none') {
                                        $easing = get_sub_field('easing');
                                        $anchor_placement = get_sub_field('anchor_placement');
                                        $speed = get_sub_field('animation_speed');
                                        wp_enqueue_script('wise-aos');
                                        wp_enqueue_style('aos-css');
                                        wp_enqueue_script('aos-js');
                                        echo ' data-aos="'.$aos_animation.'" data-aos-easing="'.$easing.'" data-aos-anchor-placement="'.$anchor_placement.'" data-aos-duration="'.$speed.'"';
                                    }
                                }
                            echo '>';
                                
                                $filename = WISE_PLUGIN_DIR.'templates/flexible-content/' . get_row_layout().'.php';
                                if(file_exists($filename)) {
                                    include($filename);
                                }
                            
                            echo '</div>';
                            if($row_layout == 'banner_content') {
                                echo '</div>'; //middle
                                echo '<div class="bottom"></div>';
                            }
                            
                    echo '</section>';
                endwhile;                
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
                            echo apply_filters('the_content',get_the_content());
                        echo '</div>';
                    echo '</div>';
                echo '</section>';
            }
        } else {
            echo '<section class="default">';
                echo '<div class="container container__normal block-style-dark text-alignment-left">';
                    echo '<div class="container-content">';
                        echo apply_filters('the_content',get_the_content());
                    echo '</div>';
                echo '</div>';
            echo '</section>';
        }
    }
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
			$desktop_css = '';
			$tablet_css = '';
			$mobile_css = '';
			$globals = '';
			while ( have_rows( $acf_field_name, $acf_post_id ) ) : the_row();	
				++$band;
				$row_layout = get_row_layout();
                if($row_layout == 'accordion') {
                    wp_enqueue_script('flexible-accordion');
                }
				if($row_layout == 'hero') {
                    $style = get_sub_field('style');
                    $background_image = get_sub_field('background_image');
                    if($background_image != '') {
                        $image = wp_get_attachment_image_src( $background_image, 'full' );
                        $globals .= '#wise-content-band-'.$band.' .background-image { background-image: url("'.$image[0].'"); }';
                    }
                    $desktop_padding = get_sub_field('desktop_padding');
                    $tablet_padding = get_sub_field('tablet_padding');
                    $mobile_padding = get_sub_field('mobile_padding');
                    if($desktop_padding != '1rem 0rem') {
                        $desktop_css .= '#wise-content-band-'.$band.'{padding:'.$desktop_padding.';}';
                    }
                    if($tablet_padding != '1rem 0rem') {
                        $tablet_css .= '#wise-content-band-'.$band.'{padding:'.$tablet_padding.';}';
                    }
                    if($mobile_padding != '1rem 0rem') {
                        $mobile_css .= '#wise-content-band-'.$band.'{padding:'.$mobile_padding.';}';
                    } 
                } else if($row_layout == 'banner_content' || $row_layout == 'call_wise') {
                    $desktop_padding = get_sub_field('desktop_padding');
                    $tablet_padding = get_sub_field('tablet_padding');
                    $mobile_padding = get_sub_field('mobile_padding');
                    if($desktop_padding != '1rem 0rem') {
                        $desktop_css .= '#wise-content-band-'.$band.'{padding:'.$desktop_padding.';}';
                    }
                    if($tablet_padding != '1rem 0rem') {
                        $tablet_css .= '#wise-content-band-'.$band.'{padding:'.$tablet_padding.';}';
                    }
                    if($mobile_padding != '1rem 0rem') {
                        $mobile_css .= '#wise-content-band-'.$band.'{padding:'.$mobile_padding.';}';
                    } 
                } else {
                    //Padding
                    $desktop_css .= '#wise-content-band-'.$band.'{padding:'.get_sub_field('desktop_padding').';}';
                    $tablet_css .= '#wise-content-band-'.$band.'{padding:'.get_sub_field('tablet_padding').';}';
                    $mobile_css .= '#wise-content-band-'.$band.'{padding:'.get_sub_field('mobile_padding').';}';
                }
                //Margins
				$desktop_css .= '#wise-content-band-'.$band.'{margin:'.get_sub_field('desktop_margin').';}';
                $tablet_css .= '#wise-content-band-'.$band.'{margin:'.get_sub_field('tablet_margin').';}';
                $mobile_css .= '#wise-content-band-'.$band.'{margin:'.get_sub_field('mobile_margin').';}';
			endwhile;
			?>
			<style type="text/css">
				<?php echo $globals; ?>
				@media all and (min-width: 73rem) {<?php echo $desktop_css; ?>}
				@media all and (max-width: 73rem) and (min-width: 48rem) { <?php echo $tablet_css; ?> } 
				@media all and (max-width: 48rem) { <?php echo $mobile_css; ?> }
			</style><?php 
		endif;
	}
}

/**
 * Add font size to wysiwyg
 */
add_filter( 'tiny_mce_before_init', 'wise_acf_text_sizes' );
function wise_acf_text_sizes( $tiny_config ){
    $tiny_config['fontsize_formats'] = ".85rem .9rem .95rem 1rem 1.05rem 1.1rem 1.125rem";

    $custom_colours = '
        "101010", "Body Font",
        "8E2C91", "Dark Blue",
        "00B6DE", "Dark Blue",
    ';

    // build colour grid default+custom colors
    $tiny_config['textcolor_map'] = '['.$custom_colours.']';

    return $tiny_config;
}

/**
 * Remove unneccessary buttons, add our font sizes to acf wysiwyg
 */
function wise_wysiyg_buttons( $buttons ) {
    //$teeny_mce_buttons = array( 'bold', 'italic', 'underline', 'blockquote', 'strikethrough', 'bullist', 'numlist', 'alignleft', 'aligncenter', 'alignright', 'undo', 'redo', 'link', 'fullscreen' );
    $block_key = array_search('blockquote', $buttons);
    unset($buttons[$block_key]);
    $fullscreen_key = array_search('fullscreen', $buttons);
    unset($buttons[$fullscreen_key]);
    $undo_key = array_search('undo', $buttons);
    unset($buttons[$undo_key]);
    $redo_key = array_search('redo', $buttons);
    unset($buttons[$redo_key]);
    $alignleft_key = array_search('alignleft', $buttons);
    unset($buttons[$alignleft_key]);
    $alignright_key = array_search('alignright', $buttons);
    unset($buttons[$alignright_key]);
    $new_buttons = array('fontsizeselect','forecolor');
    $extra_buttons = array('sup');
    $buttons = array_merge($new_buttons,$buttons,$extra_buttons);
    return $buttons;
}
add_filter( 'teeny_mce_buttons', 'wise_wysiyg_buttons',99,1 ); //Basic
add_filter( 'mce_buttons', 'wise_wysiyg_buttons',99,1 ); //Full

/**
 * Change acf wysiwyg height to something less robust
 */
add_action('acf/input/admin_head', 'wise_acf_modify_wysiwyg_height');
function wise_acf_modify_wysiwyg_height() { ?>
    <style type="text/css">
        .mce-edit-area iframe{
            height: 150px !important;
            min-height: 150px!important;
        }
    </style><?php    
}