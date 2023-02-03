<?php
/**
 * Header file for the Twenty Twenty WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */

?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZKBW675C1B"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZKBW675C1B');
</script>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >

		<link rel="profile" href="https://gmpg.org/xfn/11">

		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ddf3ff1993b7ef9"></script>

		<link href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap" rel="stylesheet">

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<?php
		wp_body_open();
		?>

		<header id="site-header" class="header-footer-group" role="banner">

			<div class="header-inner section-inner">

				<div class="header-titles-wrapper">

					<?php

					// Check whether the header search is activated in the customizer.
					$enable_header_search = get_theme_mod( 'enable_header_search', true );

					if ( true === $enable_header_search ) {

						?>

						<button class="toggle search-toggle mobile-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
							<span class="toggle-inner">
								<span class="toggle-icon">
									<?php twentytwenty_the_theme_svg( 'search' ); ?>
								</span>
								<span class="toggle-text"><?php _e( 'Search', 'twentytwenty' ); ?></span>
							</span>
						</button><!-- .search-toggle -->

					<?php } ?>

					<div class="header-titles">

						<?php
							// Site title or logo.
							// twentytwenty_site_logo();

							// Site description.
							// twentytwenty_site_description();
						?>

						<div class="share-text"><a href="#"><img src="/wp-content/uploads/2019/11/share-icon.png"></a></div>

						<div class="share-popup"><div class="addthis_inline_share_toolbox"></div></div>

						<div class="socialicons">
							<a href="https://facebook.com/WISEuv"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/fv-icon.png" alt=""></a>
							<a href="https://www.youtube.com/channel/UCZudYBh63flKjb8LZHqga6Q"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ty-icon.png" alt=""></a>
							<a href="https://www.instagram.com/WISEuv/"><img src="https://wiseuv.org/wp-content/uploads/2020/06/ig-icon.png" alt=""></a>
						</div>
						<div class="donatearea"><div class="size_fixed shared_content" id="u168597" data-sizepolicy="fixed" data-pintopage="topright" data-content-guid="u168597_content"><!-- custom html -->
				
							<a href="https://www.paypal.com/donate?hosted_button_id=Q5UPG8DAYGW32" target="_blank"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif"></a>

     </div></div>

					</div><!-- .header-titles -->

				</div><!-- .header-titles-wrapper -->

		<div class="header-navigation-wrapper">
			<div class="livechat">
				<a href="https://www.resourceconnect.com/wiseuv/chat" target="blank">Live Chat</a>
			</div>
			<div class="phonearea"><a href="tel:5122154488"><img class="phoneicon" src="/wp-content/uploads/2019/11/phone-73-48.png"><span>603-448-5922</span></a></div>
		</div><!-- .header-navigation-wrapper -->

			</div><!-- .header-inner -->

			<?php
			// Output the search modal (if it is activated in the customizer).
			if ( true === $enable_header_search ) {
				get_template_part( 'template-parts/modal-search' );
			}
			?>

		<div class="header-logos">
				<a href="/"><img class="leftlogo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/wiselogofinallogo.png" alt=""></a>
				<a href="/"><img class="rightlogo" src="https://wiseuv.org/wp-content/uploads/2019/12/everyhourblack-1.png" alt=""></a>

				<div class="header-logos-right">
					<div class="exit-site-top" id="get-away"><a href="javascript:getaway();">EXIT SITE IMMEDIATELY</a></div>
				</div>
			</div>
<?php wp_nav_menu( array( 'theme_location' => 'max_mega_menu_1' ) ); ?>
		<style>
			.menu {display:none!important}
		</style>	
		<?php
		// Output the menu modal.
		get_template_part( 'template-parts/modal-menu' );

		wp_nav_menu( array( 
			'theme_location' => 'wise-menu-main-top', 
			'container_class' => 'wise-menu-top' ) );
		?>

		</header><!-- #site-header -->