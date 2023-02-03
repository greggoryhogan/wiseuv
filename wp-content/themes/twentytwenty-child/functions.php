<?php

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

function wise_menu_main() {
  register_nav_menu('wise-menu-main-top',__( 'Wise Main Menu Top' ));
	register_nav_menu('wise-menu-main-top-dartmouth',__( 'Wise Main Menu Top Dartmouth' ));
}
add_action( 'init', 'wise_menu_main' );

wp_enqueue_script( 'script', get_stylesheet_directory_uri() . '/js/custom.js', array ( 'jquery' ), 1.1, true);

update_option( 'su_option_do_nested_shortcodes_alt', true, false );