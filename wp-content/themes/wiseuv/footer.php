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
		<div class="container container__xs __footer">
			<div class="footer line">
				<?php $address = get_option('contact_program_center');
				if($address != '') { ?>
					<div><span>Program Center:</span><?php echo '<a href="https://www.google.com/maps/dir//'.urlencode($address).'" target="_blank">'.$address.'</a>'; ?></div>
				<?php } ?>
				<?php 
				$fax = get_option('contact_fax');
				if($fax != '') { ?>
					<div><span>Fax:</span><?php echo '<a href="fax:+1'.$fax.'">'.$fax.'</a>'; ?></div>
				<?php } ?>
				<?php 
				$tel = get_option('contact_tel');
				if($tel != '') { ?>
					<div><span>Tel:</span><?php echo '<a href="tel:'.$tel.'">'.$tel.'</a>'; ?></div>
				<?php } ?>
			</div>
			<div class="footer line">
				<?php 
				$tel = get_option('contact_crisis_line_number');
				if($tel != '') { 
					$teltext = get_option('contact_crisis_line_text'); ?>
					<div><span>WISE Crisis Line:</span><?php echo '<a href="tel:'.$tel.'">'.$teltext.'</a>'; ?></div>
				<?php } ?>
				<?php 
				$text = get_option('contact_text');
				if($text != '') { ?>
					<div><span>Text:</span><?php echo '<a href="sms:'.$text.'">'.$text.'</a>'; ?></div>
				<?php } ?>
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
					$email = get_option('social_media_instagram');
					if($email != '') {
						echo '<a href="'.$instagram.'" title="Follow us on Instagram" target="_blank" class="instagram">Follow us on Instagram</a>';
					}
					?>
				</div>
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
				<div class="contact">
					<div>Wise Crisis Line: <a href="tel:<?php echo $crisis_number; ?>"><?php echo get_option('contact_crisis_line_text'); ?></a></div>
					<div>Text: <a href="sms:<?php echo $text; ?>"><?php echo get_option('contact_text'); ?></a></div>
				</div>
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
