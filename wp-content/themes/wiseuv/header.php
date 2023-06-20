<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php 
if(isset($_GET['check_mail'])) {
    if ( function_exists( 'mail' ) ) {
        echo 'mail() is available';
    } else {
        echo 'mail() does not exist.';
    }
 } ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'lshlss' ); ?></a>
    <header class="header">
        <div class="container container__lg __header">
            
            <div class="site-branding <?php echo get_field('animate_logo','options'); ?>">
                <h1>
                    <a href="<?php echo get_bloginfo('url'); ?>" title="Go to Homepage">
                        <?php if ( has_custom_logo() ) {
                            the_custom_logo();
                        } else {
                            echo '<img src="'.WISE_THEME_URI.'/assets/img/wise-logo-no-padding.png" alt="'.get_bloginfo('name').'" />';
                        } ?>
                    </a>
                </h1>
            </div><!-- .site-branding -->
            <?php $close_location = get_option('exit_site_url'); ?>
            <!--<a href="<?php echo $close_location; ?>" class="exitsite btn header-exit">Exit Site Now</a>-->
            <a href="<?php echo get_bloginfo('url'); ?>/?s=" class="header-search" title="Open Website Search"><?php echo featherIcon('search'); ?></a>
            <div class="mobile-nav">
                <button class="nav-toggle" aria-label="Toggle Navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button><!-- #primary-mobile-menu -->
            </div>
           
            <?php if ( has_nav_menu( 'primary' ) ) : ?>
                <nav id="site-navigation" class="primary-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'rb' ); ?>">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'primary',
                            'menu_class'      => 'menu-wrapper',
                            'container_class' => 'header-menu primary-menu-container',
                            'items_wrap'      => '<ul id="primary-menu" class="%2$s">%3$s</ul>',
                            'fallback_cb'     => false,
                            'depth'           => 3,
                        )
                    );
                    ?>
                </nav><!-- #site-navigation -->
            <?php endif; ?>
        </div>
    </header><!-- #masthead -->
    <?php 
    $content_classes = '';
    $is_account_pg = false;
    if(function_exists('is_account_page')) {
        if(is_account_page()) {
            $is_account_pg = true;
        }
    } 
    if($is_account_pg) {
        $content_classes .= ' woocommerce-account';
    } 
    if(function_exists('is_shop')) {
        if(is_shop()) {
            $content_classes .= ' woocommerce-shop';
        }
    } ?>
    <main class="content <?php echo $content_classes; ?>" id="content">
        <?php do_action('before_wise_content'); ?>
        <?php /* if(isset($_GET['login-success'])) {
            echo '<div class="woocommerce-info"><p>You have successfully logged in.</p></div>';
        } */ ?>