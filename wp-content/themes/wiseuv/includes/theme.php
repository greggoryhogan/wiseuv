<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*if(is_shop() || is_account_page()) {
    add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
}*/

add_action('before_wise_content','before_wise_content');
function before_wise_content() {
    global $post,$current_user;
    $user_id = $current_user->ID;
    if( is_object( $post )) {
        $post_id = $post->ID;
        $post_type = get_post_type($post_id);
        if($post_type == 'workbook') {
            echo '<div class="workbook-nav">';
                echo '<div class="fullwidth secondary-bg pt-md-1 pb-md-1 pt-2 pb-2 text-center">';
                    echo '<div class="container">';
                        echo '<div class="d-flex justify-content-between">';
                            
                                echo babel_workbook_navigation($post_id); 
                        
                        echo '</div>';
                    echo '</div>';  
                echo '</div>';
            echo '</div>';
        }
    }

    if(function_exists('is_shop')) { //check to see if woo is active
        /*if (is_shop()) {
            echo '<div class="before-woocommerce-shop">';
                echo '<div class="container">';
                    if ( is_active_sidebar( 'woocommerce_widgets' ) ) : 
                        dynamic_sidebar( 'woocommerce_widgets' ); 
                    endif;
                    $searchterm = '';
                    if(isset($_GET['course-name'])) {
                        $searchterm = $_GET['course-name'];
                    }
                    echo '<div class="woo-filters">';
                        if($searchterm == '') {
                            echo do_shortcode('[wpf-filters id=1]');
                        } else {
                            echo '<h2 class="d-inline-block mr-4">Showing Results for &lsquo;'.$searchterm.'&rsquo;</h2>';
                            echo '<a href="'.get_permalink().'" class="clear-results"><span>x</span>Clear</a>';
                        }
                    echo '</div>';
                       
                    echo '<form action="" method="get" class="course-search">';
                        echo '<input value="'.$searchterm.'" class="course-search-input grey-border" name="course-name" placeholder="Find a Series" type="text" />';
                        echo '<label class="svg-submit submit-label cursor-pointer grey-border secondary-bg has-hover white-text">';
                            echo '<input type="submit" value="submit" />';
                            echo '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="20" height="20" viewBox="0 0 24 24" stroke-width="3" stroke="#333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="10" cy="10" r="7" />
                            <line x1="21" y1="21" x2="15" y2="15" />
                        </svg>';
                        echo '</label>';
                    echo '</form>';
                echo '</div>';
            echo '</div>';
        }*/
        if(is_checkout()) {
            if(isset($_GET['key'])) {
                echo '<div class="woocommerce-message">';
                    echo '<a href="'.get_bloginfo('url').'/my-account" class="button wc-forward">Get Started</a>';
                    echo 'Checkout Successful! Thank you for your purchase.';
                echo '</div>';
            }
        }
    }

    //redirected notice after purchasing free product
    if(isset($_GET['checkout-status'])) {
        if($_GET['checkout-status'] == 'success') {
            echo '<div class="woocommerce-message">';
                echo '<a href="#getstarted" class="button wc-forward">Get Started</a>';
                echo 'Checkout Successful! Thank you for purchasing &ldquo;'.get_the_title().'&rdquo;.';
            echo '</div>';
        }
    }
}

add_filter('babel_content','babel_filter_content');
function babel_filter_content($content) {
    return str_replace('^','<span class="line-break"></span>',$content);
}

/**
 * Add notice if our custom plugin isn't active
 * Adapted from https://theaveragedev.com/generating-a-wordpress-plugin-activation-link-url/
 */
function wise_core_plugin_check() {
    if(!in_array('wiseuv/wiseuv.php', apply_filters('active_plugins', get_option('active_plugins')))){ 
        $plugin = 'wiseuv/wiseuv.php';
        $activation_url = sprintf(admin_url('plugins.php?action=activate&plugin=%s&plugin_status=all&paged=1&s'), $plugin);
        // change the plugin request to the plugin to pass the nonce check
        $_REQUEST['plugin'] = $plugin;
        $activation_url = wp_nonce_url($activation_url, 'activate-plugin_' . $plugin);
        echo '<div class="notice notice-warning">';
            echo '<p>Please <a href="'.$activation_url.'">activate WISE Core</a> to enable critical functionality to this website.</p>';
        echo '</div>'; 
    }
}
add_action( 'admin_notices', 'wise_core_plugin_check' );

/**
 * Register Menus
 */
function wise_navs(){
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'wise' ),
        'footer'  => __( 'Footer Menu', 'wise' ),
        'footer-2'  => __( 'Footer Secondary Menu', 'wise' ),
        'sticky'  => __( 'Sticky Footer Menu', 'wise' ),
    ) );
}
add_action( 'after_setup_theme', 'wise_navs', 0 );

/**
 * Theme Supports
 */
function wise_theme_support() {
    $defaults = array(
		'height'      => 126,
		'width'       => 579,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	   	'unlink-homepage-logo' => true, 
	);
	add_theme_support( 'custom-logo', $defaults );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'lazy-load' );
    //add_image_size( 'rb-hero', 1818, 816, true );
    //add_image_size( 'rb-portfolio', 894, 552, true );
    add_image_size( 'rb-blog', 557, 384, true );
}
add_action( 'after_setup_theme', 'wise_theme_support' );

/**
 * Favicon and Header Scripts
 */
function wise_header_scripts() {
    //echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.wise_THEME_URI.'/assets/img/fav.png" />';
    /*Google Fonts*/
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    //echo '<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">';
    /*End Google Fonts*/
    if(function_exists('get_field')) {
        $header_scripts = get_field('header_scripts','option');
        if($header_scripts != '') {
            echo $header_scripts;
        }
    }
}
add_action('wp_head', 'wise_header_scripts');

/**
 * Footer Scripts
 */
function wise_footer_scripts() {
    if(function_exists('get_field')) {
        $footer_scripts = get_field('footer_scripts','option');
        if($footer_scripts != '') {
            echo $footer_scripts;
        }
    }
}
add_action('wp_footer', 'wise_footer_scripts');

/**
 * Add Secondary Nav Items to Primary for Mobile View
 */
function add_wise_secondary_items_to_primary($items, $args) {
	if( $args->theme_location == 'primary' ){
		if(function_exists('get_field')) {
            $behance = get_field('behance_url','options');
            $linkedin = get_field('linkedin_url','options');
            if($behance !='' || $linkedin != '') {
                $items .= '<li class="menu-item mobile-only social">';
                    if($behance != '') {
                        $items .= '<a href="'.$behance.'" target="_blank" title="Visit us on Behance" class="behance">Visit us on Behance</a>';
                    }
                    if($linkedin != '') {
                        $items .= '<a href="'.$linkedin.'" target="_blank" title="Find us on Linkedin" class="linkedin">Find us on Linkedine</a>';
                    }
                $items .= '</li>';
            }
        }
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_wise_secondary_items_to_primary', 10, 2);

/**
 * Change login header link url
 */
add_filter('login_headerurl', 'update_wise_login_image_url');
function update_wise_login_image_url($url) {
     return wise_THEME_URL;
}

/**
 * Add custom admin color scheme and remove excerpt metabox if acf is active
 */
function wise_custom_admin() {
    //set custom color scheme for theme
    wp_admin_css_color( 'wise', __( 'wise' ), WISE_THEME_URI . '/assets/css/admin.css', [ '#000', '#000', '#fff', '#fff' ]);
}
add_action( 'admin_init', 'wise_custom_admin' );

/**
 * Use ACF to define post excerpt
 */
function wise_excerpt_filter( $excerpt, $post = null ) {
    if ( $post ) {
        $post_id = $post->ID;
    } else {
        $post_id = get_the_ID();
    }
    if(function_exists('get_field')) {
        $custom_excerpt = get_field('excerpt',$post_id);
        if($custom_excerpt != '') {
            $excerpt = $custom_excerpt;
        }
    } 
    return $excerpt;
}
add_filter( 'get_the_excerpt', 'wise_excerpt_filter' );

/**
 * Check for maintenance mode and add notice if needed
 */
add_action('wise_body_open','wise_maintenance_notice',1);
function wise_maintenance_notice() {
    if(get_current_user_id() <= 0) {
        if(function_exists('get_field')) {
            $maintenance_notice_active = get_field('maintenance_notice_active','option');
            if($maintenance_notice_active == 'yes') {
                echo '<div class="rb-maintenance-mode">';
                    echo '<div class="container"><img src="'.WISE_THEME_URI.'/assets/img/rb-logo.png" /></div>';
                    echo '<div class="container">'.get_field('maintenance_notice','option').'</div>';
                echo '</div>';
            }
        }
    }
}

/**
 * Add maintenance class to body if needed
 */
add_filter( 'body_class', 'wise_maintenance_class');
function wise_maintenance_class( $classes ) {
    if(get_current_user_id() <= 0) {
        if(function_exists('get_field')) {
            $maintenance_notice_active = get_field('maintenance_notice_active','option');
            if($maintenance_notice_active == 'yes') {
                $classes[] = 'maintenance-mode';
            }
        }
    }
    return $classes;
}

/**
 * Post Details
 */
function babel_post_details($post_id) {
    if(get_post_type() != 'post' && get_post_type() != 'podcasts') {
        return;
    }
    echo '<div class="post-meta">';
        echo '<span>'.get_the_date().'</span>';
        if(get_post_type() == 'post') {
            echo '<span class="sep"></span>';
            echo '<span> Posted by ';
            //if(is_single()) {
                $author_id = get_the_author_meta('ID');
                echo '<a href="'.get_author_posts_url($author_id).'" title="View all posts by this author">'.get_the_author_meta('display_name',$author_id).'</a>';
            //} 
            echo '&nbsp;';
            $cats = wp_get_post_categories(get_the_ID(),array( 'fields' => 'all' ));
            //print_r($cats);
            if(is_array($cats)) {
                echo 'in&nbsp;';
                foreach($cats as $cat) {
                    if($cat->slug != 'featured') {
                        echo '<a href="'.get_bloginfo('url').'/category/'.$cat->slug.'" title="View '.$cat->name.'">'.$cat->name.'</a>';
                        if($cat !== end( $cats )) {
                            echo ', ';
                        }
                    }
                }  
                //echo '</span>';
                
            }
            echo '</span>';  
            if(is_single()) {
                $author_id = get_the_author_meta('ID');
                echo '<a href="'.get_author_posts_url($author_id).'" title="View all posts by this author">'.get_avatar($author_id).'</a>';
            }
        }
        
        
    echo '</div>';
}