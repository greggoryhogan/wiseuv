<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action('rb_body_open'); ?>
<div id="page" class="site">
<?php /*if(!in_array('administrator',rb_get_current_user_roles())) {
    echo '<div class="maintenance-bg"></div>';
    echo '<div class="maintenance">';
        echo '<img src="https://redeemingbabel.org/wp-content/themes/rb/assets/img/rb-logo-white-bg.png" />';
        echo '<h2 class="font-bigger font-weight-bold">Under Scheduled Maintenance</h2>';
        echo '<p>Our website is being redesigned and is currently unavailable. We apologize for the inconvenience and any disruption this might cause for those who are going through one of our online courses. Check back tomorrow to see our exciting new design and all of our new offerings!</p>';
    echo '</div>';
}*/ ?>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'lshlss' ); ?></a>
    <header class="header">
        <div class="container container__lg __header">
            
            <div class="site-branding <?php echo get_field('animate_logo','options'); ?>">
                <h1>
                    <a href="<?php echo get_bloginfo('url'); ?>">
                        <?php if ( has_custom_logo() ) {
                            the_custom_logo();
                        } else {
                            echo '<img src="'.WISE_THEME_URI.'/assets/img/wise-logo-no-padding.png" alt="'.get_bloginfo('name').'" />';
                        } ?>
                    </a>
                </h1>
            </div><!-- .site-branding -->
            
            <div class="mobile-nav">
                <button class="nav-toggle">
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
        <?php do_action('before_rb_content'); ?>
        <?php /* if(isset($_GET['login-success'])) {
            echo '<div class="woocommerce-info"><p>You have successfully logged in.</p></div>';
        } */ ?>