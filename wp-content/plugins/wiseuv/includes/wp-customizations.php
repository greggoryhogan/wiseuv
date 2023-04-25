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
 * Keep non-admins out of wp-admin
 * 
 */
function my_login_redirect( $url, $request, $user ){ 
    if( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
        if( $user->has_cap( 'administrator') ) {
            $url = admin_url();
        } else {
            $url = home_url();
        }
    }
    return $url;
}
add_filter('login_redirect', 'my_login_redirect', 10, 3 );

/*
 *
 * set email type to html
 * 
 */
function wpse27856_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );
add_filter( 'wp_mail_charset', 'change_mail_charset' );
 
function change_mail_charset( $charset ) {
    return 'iso-8859-1';
}
/*
 * 
 * Add header and footer to html emails
 * 
 */ 
add_filter('wp_mail', 'my_wp_mail');
function my_wp_mail($atts) {
    $atts['message'] = wise_html_email_header() . $atts['message'] . wise_html_email_footer();
    return $atts;
}

/*
 *
 * Email opening
 * 
 */
 function wise_html_email_header() {
     $header = '<!doctype html>
    <html>
      <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,400;0&display=swap" type="text/css">
        <style>
          /* -------------------------------------
              GLOBAL RESETS
          ------------------------------------- */
          
          /*All the styling goes here*/
          
          img {
            border: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%; 
            display: block;
          }
    
          body {
            background-color: #f5f5f8;
           font-family: "Nunito Sans", Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%; 
          }
    
          table {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            width: 100%; }
            table td {
              font-size: 16px;
              vertical-align: top; 
              color: #4d5154;
          }
    
          /* -------------------------------------
              BODY & CONTAINER
          ------------------------------------- */
    
          .body {
            background-color: #f5f5f8;
            width: 100%; 
          }
    
          /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
          .container {
            display: block;
            margin: 0 auto !important;
            /* makes it centered */
            max-width: 600px;
            padding: 10px;
            width: 600px; 
          }
    
          /* This should also be a block element, so that it will fill 100% of the .container */
          .content {
            box-sizing: border-box;
            display: block;
            margin: 0 auto;
            max-width: 600px;
            padding: 10px; 
          }
    
          /* -------------------------------------
              HEADER, FOOTER, MAIN
          ------------------------------------- */
          .header {
            width: 100%; 
            background: #ffffff;
          }

          .main {
            background: #ffffff;
            width: 100%; 
            font-size: 16px;
          }
    
          .wrapper {
            box-sizing: border-box;
            padding: 20px; 
          }
    
          .content-block {
            padding-bottom: 10px;
            padding-top: 10px;
          }
    
          .footer {
            clear: both;
            text-align: center;
            width: 100%; 
            background: #c85f42;
            color: #fff;
          }
          .extrapadding {
              padding: 20px 40px 20px 40px;
          }
            .footer td,
            .footer p,
            .footer span,
            .footer a {
              color: #fff;
              font-size: 12px;
              text-align: center; 
          }
          .footer h3 {
            font-size: 16px;
            color: #fff;
            text-align: center;
          }
    
          /* -------------------------------------
              TYPOGRAPHY
          ------------------------------------- */
          h1,
          h2,
          h3,
          h4 {
            color: #000000;
            font-family:Arial, sans-serif;
            line-height: 1.4;
            margin: 0; 
          }
    
          h1 {
            font-size: 30px;
            font-weight: 100;
            text-align: center;
            text-transform: capitalize; 
            color: #c85f42!important;
          }
          h1 strong {
            font-weight: 600;
          .footer h3 {
            color: #fff;
            font-size: 16px; 
            margin-bottom: 15px;
        }
          p,
          ul,
          ol {
            font-family:Arial, sans-serif;
            font-size: 16px;
            font-weight: normal;
            margin: 0;
            margin-bottom: 15px; 
          }
            p li,
            ul li,
            ol li {
              list-style-position: inside;
              margin-left: 5px; 
          }
    
          a {
            color: #c85f42!important;
            text-decoration: underline; 
          }
          .img-responsive {
            height: auto !important;
            max-width: 100% !important;
            width: auto !important; 
            display: block;
          }
          /* -------------------------------------
              BUTTONS
          ------------------------------------- */
          .btn {
            box-sizing: border-box;
            width: 100%; }
            .btn > tbody > tr > td {
              padding-bottom: 15px; }
            .btn table {
              width: auto; 
          }
            .btn table td {
              background-color: #ffffff;
              border-radius: 5px;
              text-align: center; 
          }
            .btn a {
              background-color: #ffffff;
              border: solid 1px #3498db;
              border-radius: 5px;
              box-sizing: border-box;
              color: #3498db;
              cursor: pointer;
              display: inline-block;
              font-size: 14px;
              font-weight: bold;
              margin: 0;
              padding: 12px 25px;
              text-decoration: none;
              text-transform: capitalize; 
          }
    
          .btn-primary table td {
            background-color: #3498db; 
          }
    
          .btn-primary a {
            background-color: #3498db;
            border-color: #3498db;
            color: #ffffff; 
          }
    
          /* -------------------------------------
              OTHER STYLES THAT MIGHT BE USEFUL
          ------------------------------------- */
          .last {
            margin-bottom: 0; 
          }
    
          .first {
            margin-top: 0; 
          }
    
          .align-center {
            text-align: center; 
          }
    
          .align-right {
            text-align: right; 
          }
    
          .align-left {
            text-align: left; 
          }
    
          .clear {
            clear: both; 
          }
    
          .mt0 {
            margin-top: 0; 
          }
    
          .mb0 {
            margin-bottom: 0; 
          }
    
          .preheader {
            color: transparent;
            display: none;
            height: 0;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            mso-hide: all;
            visibility: hidden;
            width: 0; 
          }
    
          .powered-by a {
            text-decoration: none; 
          }
    
          hr {
            border: 0;
            border-bottom: 1px solid #f5f5f8;
            margin: 20px 0; 
          }
    
          /* -------------------------------------
              RESPONSIVE AND MOBILE FRIENDLY STYLES
          ------------------------------------- */
          @media only screen and (max-width: 600px) {
            .container {
              max-width: 600px;
              width: 600px; 
            }
            
            table[class=body] h1 {
              font-size: 28px !important;
              margin-bottom: 10px !important; 
            }
            table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a,
            .footer td,
            .footer p,
            .footer span,
            .footer a,
            .footer h3 {
              font-size: 14px !important; 
            }
            table[class=body] .wrapper,
            table[class=body] .article {
              padding: 10px !important; 
            }
            table[class=body] .content {
              padding: 0 !important; 
            }
            table[class=body] .container {
              padding: 0 !important;
              width: 100% !important; 
            }
            table[class=body] .main {
              border-left-width: 0 !important;
              border-radius: 0 !important;
              border-right-width: 0 !important; 
            }
            table[class=body] .btn table {
              width: 100% !important; 
            }
            table[class=body] .btn a {
              width: 100% !important; 
            }
          }
    
          /* -------------------------------------
              PRESERVE THESE STYLES IN THE HEAD
          ------------------------------------- */
          @media all {
            .ExternalClass {
              width: 100%; 
            }
            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
              line-height: 100%; 
            }
            .apple-link a {
              color: inherit !important;
              font-family: inherit !important;
              font-size: inherit !important;
              font-weight: inherit !important;
              line-height: inherit !important;
              text-decoration: none !important; 
            }
            #MessageViewBody a {
              color: inherit;
              text-decoration: none;
              font-size: inherit;
              font-family: inherit;
              font-weight: inherit;
              line-height: inherit;
            }
            .btn-primary table td:hover {
              background-color: #34495e !important; 
            }
            .btn-primary a:hover {
              background-color: #34495e !important;
              border-color: #34495e !important; 
            } 
          }
    
        </style>
      </head>
      <body class="" style="background-color: #f5f5f8;font-family: \'Nunito Sans\', Arial, sans-serif;-webkit-font-smoothing: antialiased;font-size: 14px;line-height: 1.4;margin: 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
        <!--<span class="preheader">This is preheader text. Some clients will show this text as a preview.</span>-->
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;background-color: #f5f5f8;">
          <tr>
            <td style="font-family: \'Nunito Sans\', Arial, sans-serif;font-size: 16px;vertical-align: top;color: #4d5154;">&nbsp;</td>
            <td width="600" style="font-family: \'Nunito Sans\', Arial, sans-serif;font-size: 16px;vertical-align: top;color: #4d5154;">
              <div class="content" style="box-sizing: border-box;display: block;margin: 0 auto;max-width: 600px;padding: 10px;">
                <!-- HEADER -->
                <table role="presentation" class="header" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;background: #ffffff;padding: 0px;margin: 0px;">
    
                  <!-- START MAIN CONTENT AREA -->
                  <tr>
                    <td style="font-family: \'Nunito Sans\', Arial, sans-serif;font-size: 16px;vertical-align: top;color: #4d5154;padding: 0px;">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;">
                      <tr>
                          <td style="font-family: \'Nunito Sans\', Arial, sans-serif;font-size: 16px;vertical-align: top;color: #4d5154;"><a href="'.get_bloginfo('url').'" style="text-decoration: underline;color: #c85f42!important;"><img src="'.get_bloginfo('template_url').'/assets/img/redeeming-wise-logo.jpg" width="255" height="60" align="top" class="img-responsive" style="float: left; line-height:1px;font-size:2px;-ms-interpolation-mode: bicubic;max-width: 100% !important;display: block;margin: 0;padding:10px 0 0 10px;"></a></td>
                        </tr>
                    </table>
                    </td>
                     </tr>
                     </table>
                        
                <!-- START CENTERED WHITE CONTAINER -->
                <table role="presentation" class="main" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;background: #ffffff;font-size: 16px;">
    
                  <!-- START MAIN CONTENT AREA -->
                  <tr>
                    <td style="font-family: \'Nunito Sans\', Arial, sans-serif;font-size: 16px;vertical-align: top;color: #4d5154;">
                    
                    </td><td class="wrapper" style="font-family: \'Nunito Sans\', Arial, sans-serif;font-size: 16px;vertical-align: top;color: #4d5154;box-sizing: border-box;padding: 20px;">
                      <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;">
                        <tr>
                          <td style="font-family: \'Nunito Sans\', Arial, sans-serif;font-size: 16px;vertical-align: top;color: #4d5154;">';

               return $header;           
                         
}
 
 /*
  *
  *
  * Email Closing
  *
  */
function wise_html_email_footer() {
    $footer = '<p style="font-family: \'Nunito Sans\', Arial, sans-serif;font-size: 16px;font-weight: normal;margin: 0;padding-top: 10px;margin-bottom: 10px;color: #4d5154;">God bless,<br>Redeeming wise</p></td>
    </tr>
    </table>
    </td><!--wrapper-->
    </tr>
    <!-- END MAIN CONTENT AREA -->
    </table>
    <!-- END CENTERED WHITE CONTAINER -->
    <table role="presentation" class="footer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;clear: both;text-align: center;background: #c85f42;color: #fff;">
    <!-- START MAIN CONTENT AREA -->
    <tr>
    <td style="font-family: \'Nunito Sans\', Arial, sans-serif;font-size: 12px;vertical-align: top;color: #fff;text-align: center;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;">
    <tr>
    <td class="extrapadding" style="font-family: \'Nunito Sans\', Arial, sans-serif;font-size: 12px;vertical-align: top;color: #fff;padding: 20px 40px 20px 40px;text-align: center;">
    <h3 style="color: #fff;font-family: \'Nunito Sans\', Arial, sans-serif;line-height: 1.4;margin: 0 0 10px 0;font-size: 16px;text-align: center;"><a href="'.get_bloginfo('url').'" style="text-decoration: none;color: #ffffff!important;font-size: 16px;text-align: center;">'.get_bloginfo('name').'</a></h3>
    <p style="font-family: \'Nunito Sans\', Arial, sans-serif;font-size: 12px;font-weight: normal;margin: 0;margin-bottom: 15px;color: #fff;text-align: center;"><a href="'.get_bloginfo('url').'/courses/" style="text-decoration: underline;color: #ffffff!important;font-size: 12px;text-align: center;">Courses</a> | <a href="'.get_bloginfo('url').'/terms/" style="text-decoration: underline;color: #ffffff!important;font-size: 12px;text-align: center;">Terms of Use</a> | <a href="'.get_bloginfo('url').'/privacy-policy/" style="text-decoration: underline;color: #ffffff!important;font-size: 12px;text-align: center;">Privacy Policy</a></p>
    <p style="font-family: \'Nunito Sans\', Arial, sans-serif;font-size: 12px;font-weight: normal;margin: 0;margin-bottom: 0px;color: #fff;text-align: center;"></p><p style="font-family: \'Nunito Sans\', Arial, sans-serif;font-size: 12px;font-weight: normal;margin: 0;margin-bottom: 0px;color: #fff;text-align: center;">&copy; '.date('Y').'</p>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    </div>
    </td>
    <td style="font-family: \'Nunito Sans\', Arial, sans-serif;font-size: 16px;vertical-align: top;color: #4d5154;">&nbsp;</td>
    </tr>
    </table>
    </body>
    </html>';
    return $footer;
}

/*
 *
 * Extend WP login duration
 * 
 */
add_filter('auth_cookie_expiration', 'auth_cookie_expiration_filter_5587', 99, 3);
function auth_cookie_expiration_filter_5587($length) {
    return MONTH_IN_SECONDS;
}

/*
 *
 * Hide protected posts from queries
 * 
 */
function wise_password_post_filter( $where = '' ) {
  $where .= " AND post_password = ''";
  return $where;
}
add_action( 'plugins_loaded', 'wisec_hide_posts' );
function wisec_hide_posts() {
  if (!is_single() && !is_admin() && !is_page('my-account')) {
    add_filter( 'posts_where', 'wise_password_post_filter' ); 
  }
}

/**
 * GUTERNBERG REMOVAL
 */

/**
 * Remove Gutenberg from Backend
 */
//add_filter( 'use_block_editor_for_post', 'wise_post_uses_gutenberg');
function wise_post_uses_gutenberg() {
  if(get_post_type() != 'page') {
    return;
  }
  global $post;
  $template = basename(get_page_template());
  if($template == 'template-blog.php') {
    return false;
  }
  return true;
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