		<!--subscribe banner -->
		<?php
		$is_account_pg = false;
		if(function_exists('is_account_page')) {
			if(is_account_page() || is_cart() || is_checkout()) {
				$is_account_pg = true;
			}
		} ?>
		<?php if($is_account_pg || is_page(array('login','subscribe'))) { ?>
			<section class="padding__xs"></section>
		<?php } ?>
		<!--/subscribe banner -->
	</main><!-- #main -->
	<footer id="colophon" class="footer">
		<div class="container __footer">
			<div class="rb-logo">
				<a href="<?php echo WISE_THEME_URL; ?>" title="<?php echo get_bloginfo('name'); ?>">
					<img src="<?php echo WISE_THEME_URI; ?>/assets/img/logo-white.png" alt="rb logo" />
				</a>
			</div>
			<div class="footer-right">
				<?php if ( has_nav_menu( 'footer' ) ) : ?>
					<nav aria-label="<?php esc_attr_e( 'Footer menu', 'babel' ); ?>" class="footer-navigation">
						<ul class="footer-navigation-wrapper">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'footer',
									'items_wrap'     => '%3$s',
									'container'      => false,
									'depth'          => 1,
									'link_before'    => '',
									'link_after'     => '<span>|</span>',
									'fallback_cb'    => false,
								)
							);
							?>
						</ul>
						<ul class="footer-navigation-wrapper">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'footer-2',
									'items_wrap'     => '%3$s',
									'container'      => false,
									'depth'          => 1,
									'link_before'    => '',
									'link_after'     => '<span>|</span>',
									'fallback_cb'    => false,
								)
							);
							?>
						</ul>
						<div class="site-info">
							<div class="social">
								<?php 
								$twitter = get_option('social_media_twitter');
								if($twitter != '') {
									echo '<a href="'.$twitter.'" title="Follow us on Twitter" target="_blank" class="twitter">Twitter</a>';
								}
								$facebook = get_option('social_media_facebook');
								if($facebook != '') {
									echo '<a href="'.$facebook.'" title="Follow us on Facebook" target="_blank" class="facebook">Follow us on Facebook</a>';
								}
								$instagram = get_option('social_media_instagram');
								if($instagram != '') {
									echo '<a href="'.$instagram.'" title="Follow us on Instagram" target="_blank" class="instagram">Follow us on Instagram</a>';
								}
								?>
							</div>
							<div class="site-name">
								<?php 
								echo '&copy; '.date('Y') .' '.get_bloginfo('name'); ?>
							</div>
						</div>
					</nav>
					
				<?php endif; ?>
				
			</div>

		</div>
	</footer>
	<nav id="sticky-nav">
		<div class="toggle text">See how we can help</div>
		<!--<div class="toggle close"><?php echo featherIcon('x','','20'); ?></div>-->
		<div class="toggle"><?php echo featherIcon('chevron-up','','40'); ?></div>
		<div class="expanded-content">
			<div class="content-container">
				<div class="sticky-heading">See How We Can Help</div>
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'menu_class'      => 'menu-wrapper',
						'container_class' => 'sticky-menu',
						'items_wrap'      => '<ul id="sticky-menu" class="%2$s">%3$s</ul>',
						'fallback_cb'     => false,
					)
				);
				?>
					
			</div>
		</div>
		<div class="sticky-content">
			<?php 
			$chat_url = get_option('live_chat_url');
			$close_location = get_option('exit_site_url');
			$crisis_number = '+1'.str_replace('-','',get_option('contact_crisis_line_number'));
			$text = '+1'.str_replace('-','',get_option('contact_text')); 
			?>
			<div class="contact">
				<div>Wise Crisis Line: <a href="tel:<?php echo $crisis_number; ?>"><?php echo get_option('contact_crisis_line_text'); ?></a></div>
				<div>Text: <a href="sms:<?php echo $text; ?>"><?php echo get_option('contact_text'); ?></a></div>
			</div>
			<div class="actions">
				<a href="<?php echo $chat_url; ?>" target="_blank" class="openchat">Live Chat</a>
				<a href="<?php echo $close_location; ?>" class="exitsite">Exit Site Now</a>
			</div>

		</div>
	</nav>
</div>
<?php wp_footer(); ?>
</body>
</html>
