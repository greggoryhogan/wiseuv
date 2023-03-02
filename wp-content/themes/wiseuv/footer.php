		<!--subscribe banner -->
		<?php
		$is_account_pg = false;
		if(function_exists('is_account_page')) {
			if(is_account_page() || is_cart() || is_checkout()) {
				$is_account_pg = true;
			}
		} ?>
		<?php if(!$is_account_pg &&!is_page(array('login','subscribe')) && !is_user_logged_in()) { ?>
		<section class="section__subscribe bg__green padding__lg text__light has-bg-image" id="subscribe_footer">
			<div class="bg-image-container container container__sm subscribe"></div>
			<div class="container container__xs text__left">
				<?php 
				//$mailchimp_heading_text = apply_filters('babel_content',get_option('mailchimp_heading_text'));
				$mailchimp_body_text = apply_filters('babel_content', get_option('mailchimp_body_text'));
				/*if($mailchimp_heading_text != '') {
					echo '<h2>'.$mailchimp_heading_text.'</h2>';
				}*/
				echo '<div class="subscribe-actions">';
					echo '<div class="cta-action">';
						echo '<a href="'.get_bloginfo('url').'/subscribe" title="Subscribe" class="btn subscribe">Subscribe Now</a>';
					echo '</div>';	
					if($mailchimp_body_text != '') {
						echo '<div class="cta">';
							echo '<p>'.$mailchimp_body_text.'</p>';
						echo '</div>';
					}
				echo '</div>';
				?>
			</div>
		</section>
		<?php } ?>
		<?php if($is_account_pg || is_page(array('login','subscribe'))) { ?>
			<section class="padding__xs"></section>
		<?php } ?>
		<!--/subscribe banner -->
	</main><!-- #main -->
	<footer id="colophon" class="footer">
		<div class="container __footer">
			<div class="rb-logo">
				<a href="<?php echo RB_THEME_URL; ?>" title="<?php echo get_bloginfo('name'); ?>">
					<img src="<?php echo RB_THEME_URI; ?>/assets/img/logo-white.png" alt="rb logo" />
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

	<!-- Signup Modal -->

	<div id="subscribemodal" class="register modal-register" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="subscribe-content">
			<div class="heading">
				<h2><?php echo get_option('subscribe_modal_heading'); ?></h2>
				<?php echo get_option('subscribe_modal_text'); ?>
			</div>
			<a href="<?php echo get_bloginfo('url');?>/subscribe" title="Subscribe" class="btn subscribe">Subscribe</a>
			<div class="close-subscribe-modal">No thank you</div>
		</div>
	</div>
	<div id="subscribemodalbg" class="modal-register__bg"></div>
</div>
<?php wp_footer(); ?>
</body>
</html>
