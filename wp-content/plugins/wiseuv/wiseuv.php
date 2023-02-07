<?php
/*
Plugin Name:  WISE Core
Plugin URI:	  https://wise.org/
Description:  This plugin separates core functionality for the website from the theme to a plugin.
Version:	  1.0.1
Author:		  Gregg Hogan
Author URI:   https://mynameisgregg.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wise
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WISE_PLUGIN_DIR', dirname(__FILE__).'/' );
if(!defined('WISE_URL')) {
    define('WISE_URL',plugins_url() . '/wiseuv/');
}

/**
 * Add option to check for flushing permalinks on activation
 */
register_activation_hook( __FILE__, 'wise_activate' );
function wise_activate() {
    if ( ! get_option( 'wise_flush_rewrite_rules_flag' ) ) {
        add_option( 'wise_flush_rewrite_rules_flag', true );
    }
}

/**
 * Flush rewrite rules if the previously added flag exists and then remove the flag.
 */
add_action( 'init', 'wise_flush_rewrite_rules_maybe', 20 );
function wise_flush_rewrite_rules_maybe() {
    if ( get_option( 'wise_flush_rewrite_rules_flag' ) ) {
        flush_rewrite_rules();
        delete_option( 'wise_flush_rewrite_rules_flag' );
    }
}

/**
 * Required files for plugin
 */
add_action( 'plugins_loaded', 'wise_required_files' );
function wise_required_files() {
    //customizing functions for WP
	require_once( WISE_PLUGIN_DIR . 'includes/wp-customizations.php' );
    //general functionality for theme
    require_once( WISE_PLUGIN_DIR . 'includes/plugin-functions.php' );
    //theme settings and documentation
	require_once( WISE_PLUGIN_DIR . 'includes/settings.php' );
	//custom post types
    require_once( WISE_PLUGIN_DIR . 'includes/custom-post-types.php' );
    //custom acf functionality
    if(function_exists('get_field')) {
        require_once( WISE_PLUGIN_DIR . 'includes/acf-functions.php' );
    }
}

/**
 * Scripts / CSS for plugin
 */
function enqueue_wise_scripts() {
    $plugin_data = get_plugin_data( __FILE__ );
    $plugin_version = $plugin_data['Version'];

    //CSS for Plugin
    //wp_register_style( 'wise-styles', WISE_URL .'includes/css/wise.css', array(), $plugin_version);
    //wp_enqueue_style( 'wise-styles' );

    //lozad
	wp_register_script('lozad-js', WISE_URL .'/includes/js/lozad.min.js', array('jquery'),$plugin_version, true);
	wp_enqueue_script('lozad-js');

	//theme
	wp_register_script('wise-plugin', WISE_URL .'/includes/js/wiseuv.js', array('jquery'),$plugin_version, true);
	wp_enqueue_script('wise-plugin');

    //AOS
    wp_enqueue_style( 'aos-css', WISE_URL . '/assets/aos-master/dist/aos.css',null,'3.0.0' );
    wp_enqueue_script( 'aos-js', WISE_URL. '/assets/aos-master/dist/aos.js', array('jquery'),'3.0.0', true );
    
	
	/*Add church affiliations dropdown available in site.js*/
	wp_localize_script(
		'wise-plugin',
		'plugin_js',
		array(
		   'ajax_url' => admin_url( 'admin-ajax.php' ),
		   'ajax_url' => admin_url( 'admin-ajax.php' ),
		   'theme_dir' => get_bloginfo('template_url'),
		   'current_user_id' => get_current_user_ID(),
		   'page_title' => get_the_title(),
		)
	); //had 'affiliation_optons' => get_available_church_affiliations(),

} 
add_action( 'wp_enqueue_scripts', 'enqueue_wise_scripts' );

/*
 *
 * Admin CSS for settings page
 * 
 */ 
function wise_admin_scripts() {
	$version = wp_get_theme()->get('Version');
	wp_register_style( 'wise-admin-css', WISE_URL . '/includes/css/admin.css' );
    wp_enqueue_style( 'wise-admin-css' );	
}
add_action('admin_init', 'wise_admin_scripts');

function wise_acf_styles() {
	wp_enqueue_script( 'wise-acf-admin-js', WISE_URL . '/includes/js/acf-admin.js', array(), '1.0.0', true );
}
add_action('acf/input/admin_enqueue_scripts', 'wise_acf_styles');

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