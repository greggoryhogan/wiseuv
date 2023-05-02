<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WISE_THEME_DIR', get_template_directory() );
define( 'WISE_THEME_URI', get_template_directory_uri() );
define( 'WISE_THEME_URL', get_bloginfo('url') );
//Includes for theme
require_once( WISE_THEME_DIR . '/includes/theme.php' ); //Theme alterations like nav menus
require_once( WISE_THEME_DIR . '/includes/simplify-wp.php' ); //Clean up WP
//require_once( WISE_THEME_DIR . '/includes/acf.php' ); //ACF Specific
require_once( WISE_THEME_DIR . '/includes/ajax.php' ); //Ajax functions

/* 
 * Load Style/Scripts
 */
function load_WISE_THEME_scripts() {
	$version = wp_get_theme()->get('Version');
    wp_enqueue_style( 'rb-theme', WISE_THEME_URI . '/assets/css/main.css',null,$version );
    wp_register_style( 'rb-flexible-content', WISE_THEME_URI . '/assets/css/flexible-content.css',null,$version );
    if(is_404() || is_search() || is_single() || is_page() || is_front_page() || is_home() || is_tag() || is_archive() || in_array(get_post_type(),array('product','podcasts','sfwd-topic','workbook','sfwd-courses','sfwd-lessons'))) {
        wp_enqueue_style( 'rb-flexible-content');
    }
    wp_register_style( 'rb-learndash', WISE_THEME_URI . '/assets/css/learndash.css',null,$version );
    if(is_singular(array('sfwd-topic','workbook','sfwd-courses','sfwd-lessons'))) {
        wp_enqueue_style( 'rb-learndash');
    }
    $supported_comments = get_option('babel_supported_comments');
    if(is_array($supported_comments)) {
        if(is_singular($supported_comments)) {
            wp_enqueue_script( 'comment-reply' );    
        }
    }
    
    //wp_enqueue_style( 'aos-css', WISE_THEME_URI . '/assets/aos-master/dist/aos.css',null,'3.0.0' );
    //wp_enqueue_style('google-fonts','https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700&display=swap');
    wp_enqueue_style('adobe-fonts','https://use.typekit.net/lmo5yiv.css');
    wp_enqueue_script( 'hoverIntent' ); //wp version of hoverintent
    //wp_enqueue_script( 'aos-js', WISE_THEME_URI. '/assets/aos-master/dist/aos.js', array('jquery'),'3.0.0', true );
    wp_enqueue_script( 'theme-js', WISE_THEME_URI. '/assets/js/site.js', array('jquery'),$version, true );
    $close_url = get_option('exit_site_url');
    $chat_url = get_option('live_chat_url');
    wp_localize_script(
		'theme-js',
		'theme_js',
		array(
		   'ajax_url' => admin_url( 'admin-ajax.php' ),
           'exit_url' => $close_url,
           'chat_url' => $chat_url
		)
	);
    //javascript cookie
    //wp_enqueue_script( 'rb-cookie', WISE_THEME_URI. '/assets/js/js.cookie.min.js', array('jquery'),'1.0', false );
    //disable cart fragments
    //wp_dequeue_script('wc-cart-fragments'); 
    //testimonials
	//wp_register_style( 'slick-css', WISE_THEME_URI .'/assets/slick-slider/slick.css', array(), '1.0');
	//wp_register_script('slick-js', WISE_THEME_URI .'/assets/slick-slider/slick.min.js', array('jquery'),'1.0', true);
    //countUp
    //wp_register_script('countup', WISE_THEME_URI .'/assets/js/countUp.umd.js', array('jquery'),'1.0', true);
    
}
add_action( 'wp_enqueue_scripts', 'load_WISE_THEME_scripts' );

function rb_admin_enqueue_scripts() {
	wp_enqueue_script( 'babel-acf-admin-js', WISE_THEME_DIR . '/assets/js/acf-admin.js', array(), '1.0.0', true );
}
//add_action('acf/input/admin_enqueue_scripts', 'rb_admin_enqueue_scripts');

add_filter('script_loader_tag', 'add_type_attribute' , 10, 3);
function add_type_attribute($tag, $handle, $src) {
    // if not your script, do nothing and return original $tag
    if ( 'countup' !== $handle ) {
        return $tag;
    }
    // change the script tag by adding type="module" and return it.
    $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
    return $tag;
}
