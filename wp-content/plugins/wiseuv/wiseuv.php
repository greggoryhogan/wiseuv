<?php
/*
Plugin Name:  WISE Core
Plugin URI:	  https://wise.org/
Description:  This plugin separates core functionality for the website from the theme to a plugin.
Version:	  1.0.10
Author:		  Gregg Hogan
Author URI:   https://mynameisgregg.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wise
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'bhfe_PLUGIN_DIR', dirname(__FILE__).'/' );
if(!defined('bhfe_URL')) {
    define('bhfe_URL',plugins_url() . '/wiseuv/');
}

/**
 * Add option to check for flushing permalinks on activation
 */
register_activation_hook( __FILE__, 'bhfe_activate' );
function bhfe_activate() {
    if ( ! get_option( 'bhfe_flush_rewrite_rules_flag' ) ) {
        add_option( 'bhfe_flush_rewrite_rules_flag', true );
    }
}

/**
 * Flush rewrite rules if the previously added flag exists and then remove the flag.
 */
add_action( 'init', 'bhfe_flush_rewrite_rules_maybe', 20 );
function bhfe_flush_rewrite_rules_maybe() {
    if ( get_option( 'bhfe_flush_rewrite_rules_flag' ) ) {
        flush_rewrite_rules();
        delete_option( 'bhfe_flush_rewrite_rules_flag' );
    }
}

/**
 * Required files for plugin
 */
add_action( 'plugins_loaded', 'bhfe_required_files' );
function bhfe_required_files() {
    //customizing functions for WP
	require_once( bhfe_PLUGIN_DIR . 'includes/wp-customizations.php' );
    //general functionality for theme
    require_once( bhfe_PLUGIN_DIR . 'includes/plugin-functions.php' );
    //theme settings and documentation
	require_once( bhfe_PLUGIN_DIR . 'includes/settings.php' );
	//custom post types
    require_once( bhfe_PLUGIN_DIR . 'includes/custom-post-types.php' );
    //custom acf functionality
    if(function_exists('get_field')) {
        require_once( bhfe_PLUGIN_DIR . 'includes/acf-functions.php' );
    }
    if(function_exists('get_field')) {
        require_once( bhfe_PLUGIN_DIR . 'includes/acf-functions.php' );
    }
    if ( class_exists( 'GFCommon' ) ) {
        require_once( bhfe_PLUGIN_DIR . 'includes/gravity-forms.php' );
    }
}

/**
 * Scripts / CSS for plugin
 */
function enqueue_bhfe_scripts() {
    $plugin_data = get_plugin_data( __FILE__ );
    $plugin_version = $plugin_data['Version'];

    //CSS for Plugin
    wp_register_style( 'wise-plugin-flexible-content', bhfe_URL .'includes/css/flexible-content.css', array(), $plugin_version);
    wp_enqueue_style( 'wise-plugin-flexible-content' );

    //lozad
	//wp_register_script('lozad-js', bhfe_URL .'/includes/js/lozad.min.js', array('jquery'),$plugin_version, true);
	//wp_enqueue_script('lozad-js');

	//plugin
	wp_register_script('wise-plugin', bhfe_URL .'/includes/js/wiseuv.js', array('jquery'),$plugin_version, true);
	wp_enqueue_script('wise-plugin');
    $call_tooltip = get_option('call_tooltip');
    wp_localize_script(
		'wise-plugin',
		'plugin_js',
		array(
		   'call_tip' => $call_tooltip,
		)
	);

    //AOS
    wp_register_script('wise-aos', bhfe_URL .'/includes/js/aos.js', array('jquery'),$plugin_version, true);
    wp_register_style( 'aos-css', bhfe_URL . '/includes/lib/aos-master/dist/aos.css',null,'3.0.0' );
    wp_register_script( 'aos-js', bhfe_URL. '/includes/lib/aos-master/dist/aos.js', array('jquery'),'3.0.0', true );
	//wp_enqueue_script('wise-plugin');
    //wp_enqueue_style( 'aos-css', bhfe_URL . '/includes/lib/aos-master/dist/aos.css',null,'3.0.0' );
    //wp_enqueue_script( 'aos-js', bhfe_URL. '/includes/lib/aos-master/dist/aos.js', array('jquery'),'3.0.0', true );
    
	
	/*Add church affiliations dropdown available in site.js*/
	/*wp_localize_script(
		'wise-plugin',
		'plugin_js',
		array(
		   'ajax_url' => admin_url( 'admin-ajax.php' ),
		   'theme_dir' => get_bloginfo('template_url'),
		   'current_user_id' => get_current_user_ID(),
		   'page_title' => get_the_title(),
		)
	); //had 'affiliation_optons' => get_available_church_affiliations(),*/
    wp_register_script('flexible-accordion', bhfe_URL .'/includes/js/accordion.js', array('jquery'),$plugin_version, true);

    wp_dequeue_style( 'classic-theme-styles' );

} 
add_action( 'wp_enqueue_scripts', 'enqueue_bhfe_scripts' );

/*
 *
 * Admin CSS for settings page
 * 
 */ 
function bhfe_admin_scripts() {
	$version = wp_get_theme()->get('Version');
	wp_register_style( 'wise-admin-css', bhfe_URL . '/includes/css/admin.css' );
    wp_enqueue_style( 'wise-admin-css' );	
    /*$classic_editor_styles = array(
		bhfe_URL . '/includes/css/editor.css',
	);
	add_editor_style( $classic_editor_styles );*/
}
add_action('admin_init', 'bhfe_admin_scripts');

/**
 * Filter colors and font sizes for acf wysiwyg
 */
function bhfe_acf_styles() {
	wp_enqueue_script( 'wise-acf-admin-js', bhfe_URL . '/includes/js/acf-admin.js', array(), '1.0.1', true );
}
add_action('acf/input/admin_enqueue_scripts', 'bhfe_acf_styles');

/**
 * Admin bar
 */
add_filter( 'show_admin_bar', 'conditional_hide_admin_bar' );
function conditional_hide_admin_bar() {
    global $post;
    if(get_current_user_id() != 1) {
        return false;
    }
    if(get_post_type() == 'sfwd-topic') {
        return false;
    }
    return true;
}