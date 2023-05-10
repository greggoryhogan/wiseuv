<?php
/*
 *
 * Set login logo
 * 
 */ 
function wise_login_logo() { ?>
    <style type="text/css">
        body {background: #fff!important;}
        #login h1 a, .login h1 a {
            background-image: url(<?php echo WISE_URL; ?>includes/img/wise-logo.png);
            height:100px;
            width:250px;
            background-size: contain;
            background-repeat: no-repeat;
        }
       .button {background: #00b0d8!important; border: none!important; color: #fff!important; transition: .2s background;}
       .button:hover {background: #92278f!important; }
       .login #login_error, .login .message, .login .success { border-left-color: #00b0d8!important; }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'wise_login_logo' );
/*
 *
 * Change login logo url
 * 
 */
add_filter( 'login_headerurl', 'wise_loginlogo_url' );
function wise_loginlogo_url($url) {
     return get_bloginfo('url');
} 

// ************* Remove default Posts type since no blog *************

// Remove side menu
add_action( 'admin_menu', 'remove_default_post_type' );

function remove_default_post_type() {
    remove_menu_page( 'edit.php' );
}

// Remove +New post in top Admin Menu Bar
add_action( 'admin_bar_menu', 'remove_default_post_type_menu_bar', 999 );

function remove_default_post_type_menu_bar( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'new-post' );
}

// Remove Quick Draft Dashboard Widget
add_action( 'wp_dashboard_setup', 'remove_draft_widget', 999 );

function remove_draft_widget(){
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
}

// End remove post type

// ********* Disable Comments ************

add_action('admin_init', function () {
  // Redirect any user trying to access comments page
  global $pagenow;
   
  if ($pagenow === 'edit-comments.php') {
      wp_safe_redirect(admin_url());
      exit;
  }

  // Remove comments metabox from dashboard
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

  // Disable support for comments and trackbacks in post types
  foreach (get_post_types() as $post_type) {
      if (post_type_supports($post_type, 'comments')) {
          remove_post_type_support($post_type, 'comments');
          remove_post_type_support($post_type, 'trackbacks');
      }
  }
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
  remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
  if (is_admin_bar_showing()) {
      remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
  }
});

// End disable comments
/*
 *
 * Add TINY MCE Table Option
 * 
 */
function add_the_table_button( $buttons ) {
  array_push( $buttons, 'separator', 'table' );
  return $buttons;
}
add_filter( 'mce_buttons', 'add_the_table_button' );

/*
 *
 * Add TINY MCE Table plugin
 * 
 */
function add_the_table_plugin( $plugins ) {
    $plugins['table'] = get_template_directory_uri() .'/includes/tinymce-plugins/table/plugin.min.js';
    return $plugins;
}
//add_filter( 'mce_external_plugins', 'add_the_table_plugin' );
/*
 *
 * Extend WP login duration
 * 
 */
add_filter('auth_cookie_expiration', 'auth_cookie_expiration_filter_5587', 99, 3);
function auth_cookie_expiration_filter_5587($length) {
    return MONTH_IN_SECONDS;
}

/**
 * GUTERNBERG REMOVAL
 */

/**
 * Remove Gutenberg from Backend
 */
add_filter( 'use_block_editor_for_post', 'wise_post_uses_gutenberg');
function wise_post_uses_gutenberg() {
  if(!in_array(get_post_type(),array('post','page'))) {
    return;
  }
  return false;
}

/**
 * Disable Gutenberg for widgets.
 */ 
add_filter( 'use_widgets_blog_editor', '__return_false' );

/**
 * Remove Gutenberg Frontend Scripts
 */
function wpcu_disable_gutenberg() {
    // Remove CSS on the front end.
    wp_dequeue_style( 'wp-block-library' );
    // Remove Gutenberg theme.
    wp_dequeue_style( 'wp-block-library-theme' );
    // Remove inline global CSS on the front end.
    wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_enqueue_scripts', 'wpcu_disable_gutenberg', 20 );

/**
 * Remove Gutenberg Block Library from Frontend
 */
function wpcu_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS if it exists
} 
add_action( 'wp_enqueue_scripts', 'wpcu_remove_wp_block_library_css', 100 );

/**
 * Remove Gutenberg default css
 */
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

/** Make edit post open in new window */
add_filter( 'edit_post_link', 'wise_edit_link', 10, 3);
function wise_edit_link( $link, $post_id, $text ) {
    // Add the target attribute 
    if( false === strpos( $link, 'target=' ) )
        $link = str_replace( '<a ', '<a target="_blank" ', $link );

    return $link;
}