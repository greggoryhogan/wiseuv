<?php

/**
 * Add single view through plugin instead of theme
 */
//add_filter('template_include', 'wisec_plugin_templates', 99);
function wisec_plugin_templates( $template ) {
    if (is_page('login')) {
        $template = WISE_PLUGIN_DIR . 'templates/page-login.php';
    } else if (is_page('subscribe')) {
        $template = WISE_PLUGIN_DIR . 'templates/page-subscribe.php';
    }

    return $template;
}

/** Get user roles */
function wise_get_current_user_roles() {
    if( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $roles = ( array ) $user->roles;
        return $roles; // This will returns an array
    } else {
        return array();   
    }
   
}

/*
 *
 * Show our own icon
 * 
 */
function featherIcon($icon,$classes = NULL, $size = NULL, $color = NULL, $background = NULL) {
    $extras = '';
    if($color != null) {
        $extras .= 'color: '.$color.';';
    }
    if($background != null) {
        $extras .= 'background-color: '.$background.';';
    }
    ob_start(); 
    include('feather/'.$icon.'.svg');
    $icon_url = ob_get_clean();
    $icon_html = '<span class="feather-icon '.$classes.'"';
    if($size) {
        $icon_html .= ' style="width:'.$size.'px;height:'.$size.'px;padding-bottom:0;font-size:'.$size.'px;'.$extras.'"';
    }
    $icon_html .= ' role="presentation">'.$icon_url.'</span>';
    return $icon_html;
} 

/*
 *
 * Add body classes for conditional css display
 * 
 */
//add_filter( 'body_class','wise_woo_body_classes' );
function wise_woo_body_classes( $classes ) {
    global $current_user;
    $user_id = $current_user->ID;
    if(!is_front_page()) {
        if(is_page('login') || is_page('register')) {
            $classes[] = 'wise-registration-page';
        }
    }
    if($user_id > 0) {
        $classes[] = 'is-logged-in';
    } else {
        $classes[] = 'is-logged-out';
    }
    if(is_page() || is_singular()) {
        if(function_exists('get_field')) {
            $header_setting = get_field('header_setting');
            $classes[] = $header_setting;
        
            $global_display = get_field('global_display');
            $classes[] = $global_display;
        }
    }
    return $classes;  
} 

/*
 *
 * Add Header scripts to page
 * 
 */ 
add_action('wp_head','add_header_scripts_to_header');
function add_header_scripts_to_header() {
    $ga = get_option('google_analytics_code');
    if($ga != '') {
        echo $ga;
    }
}

/*
 *
 * Add save button to footer of site
 * 
 */ 
add_action('wp_footer','add_scripts_to_footer');
function add_scripts_to_footer() {
    $scripts = get_option('footer_scripts');
    if($scripts != '') {
        echo $scripts;
    }
}


add_filter( 'wp_get_nav_menu_items', 'babel_update_my_account_menu_item', null, 3 ); 
function babel_update_my_account_menu_item( $items, $menu, $args ) {
    if(is_admin()) {
        return $items;
    }
    global $wp;
    // Iterate over the items to search and destroy
    foreach ( $items as $key => $item ) {
      //  print_r($item);
        if(isset($item->classes)) {
            $classes = $item->classes;
        }
        if(is_array($classes)) {
            if(in_array('search',$classes)) {
                $old_title = $item->title;
                $item->title = featherIcon('search').'<span class="text">'.$old_title.'</span>';
            }
        }
    }
     return $items;
}

/** Add dropdown actions to menu */
add_filter( 'wp_nav_menu_objects', 'menu_set_dropdown', 10, 2 );
function menu_set_dropdown( $menu_items, $args ) {
    $last_top = 0;
    foreach ( $menu_items as $key => $obj ) {
        // it is a top lv item?
        if ( 0 == $obj->menu_item_parent ) {
            // set the key of the parent
            $last_top = $key;
        } else {
            if(strpos($menu_items[$last_top]->title,'menu-toggle') == false) {
                $menu_items[$last_top]->classes['submenu'] = 'submenu';
                $menu_items[$last_top]->title .= '<span class="menu-toggle"></span>';
            }
        }
    }
    return $menu_items;
}

//add_filter( 'nav_menu_css_class', 'add_current_menu_item_to_menu_items', 10, 2 );
function add_current_menu_item_to_menu_items( $classes = array(), $menu_item = false ) {

    //Check if already have the class
    if (! in_array( 'current-menu-item', $classes ) ) {

        //Check if it's a category
        if ( in_array( 'blog', $classes ) ) {

            //Check if the post is in the category
            if ( (is_single() && 'post' == get_post_type()) || is_author()  || is_category() || is_tag()) {

                $classes[] = 'current-menu-item';

            }

        }

    }

    return $classes;
}

function add_search_form($items, $args) {
    if( $args->theme_location == 'primary' ){
    $items .= '<li class="menu-item">'
            . '<form role="search" method="get" class="search-form" action="'.home_url( '/' ).'">'
            . '<label>'
            . '<span class="screen-reader-text">' . _x( 'Search for:', 'label' ) . '</span>'
            . '<input type="search" class="search-field" placeholder="' . esc_attr_x( 'Search …', 'placeholder' ) . '" value="' . get_search_query() . '" name="s" title="' . esc_attr_x( 'Search for:', 'label' ) . '" />'
            . '</label>'
            . '<input type="submit" class="search-submit" value="'. esc_attr_x('Search', 'submit button') .'" />'
            . '</form>'
            . '</li>';
    }
  return $items;
}
//add_filter('wp_nav_menu_items', 'add_search_form', 10, 2);

/*
 *
 * Helper function to get the post id while in gutenberg block editor
 * 
 */ 
function wise_get_gutenberg_post_id() {
	if ( is_admin() && function_exists( 'acf_maybe_get_POST' ) ) :
		return intval( acf_maybe_get_POST( 'post_id' ) );
	else :
		global $post;
		return $post->ID;
	endif;
}

function wise_pagination_nav($blog_posts) {
    
    /** Stop execution if there's only 1 page */
    if( $blog_posts->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $blog_posts->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
    
    echo '<ul>';
        echo '<li class="previous">'.get_previous_posts_link('Previous Page', $blog_posts->max_num_pages).'</li>';
        $current = 1;
        while($current <= $max) {
            $class = $current == $paged ? ' class="active"' : ' class=""';
            printf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( $current ) ), $current );
            ++$current;
        }
        echo '<li class="next">'.get_next_posts_link('Next Page', $blog_posts->max_num_pages).'</li>';
   
    echo '</ul>';
}

/**
 * Check if our custom setting to globally disable comments in active
 */
function wise_comments_active() {
    if(get_option('globally_disable_comments') == 'on') {
        return false;
    } else {
        return true;
    }
}

/*
 *
 * Helper for if we are on staging 
 * 
 */
function is_staging() {
	//we shouldn't make it past the first condition but keeping as fallback
	if (defined('IS_STAGING')) {
		return IS_STAGING;
	} else {
        return false; //default, allow all functionalit
    }
}

/*
 *
 * Helper for if we are in local env
 * 
 */
function is_local_env() {
	//we shouldn't make it past the first condition but keeping as fallback
	if (defined('IS_LOCAL')) {
		return IS_STAGING;
	} else {
        return false; //default, allow all functionalit
    }
}

/** Change passwoird protected message */
function wise_custom_password_form() {
    global $post;
    $post   = get_post( $post );
	$label  = 'pwbox-' . ( empty( $post->ID ) ? wp_rand() : $post->ID );
	$output = '<section class="section post-pw-protected padding__xl"><div class="container flex-content-container container__xs"><div class="container-content"><div class="flexible-content wysiwyg"><p class="post-password-message">' . esc_html__( 'Please enter the password to view this content.', 'wiseuv' ) . '</p>
	<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">
	<p class="pw-inputs"><input class="post-password-form__input" name="post_password" id="' . esc_attr( $label ) . '" type="password" size="20" placeholder="Password" /><input type="submit" class="post-password-form__submit btn mt-2" name="' . esc_attr_x( 'Submit', 'Post password form', 'twentytwentyone' ) . '" value="' . esc_attr_x( 'Enter', 'Post password form', 'twentytwentyone' ) . '" /></p></form></div></div></div></section>
	';
	return $output;
}
add_filter('the_password_form', 'wise_custom_password_form', 99);

/** Filter input content */
function wise_content_filters($content,$span = true) {
    if(!$span) {
        return do_shortcode(str_replace('^',' ',$content));
    } else {
        return do_shortcode('<span class="br">'.str_replace('^','</span><span class="br">',$content) .'</span>');
    }
}
add_filter('wise_content','wise_content_filters');

/**
 * Simple shortcode to add spacing to inputs / text areas
 */
add_shortcode('space','space_shortcode');
function space_shortcode($atts) {
    $atts = shortcode_atts( array(
        'height' => '1rem',
        'display' => '',
    ), $atts );
    return '<span class="wise-spacer '.$atts['display'].'" style="height:'.$atts['height'].'"></span>';
}