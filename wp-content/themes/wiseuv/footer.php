	</main><!-- #main -->
	<footer id="colophon" class="footer">
		<div class="container container__xs __footer">
			<div class="footer line">
				<?php $address = get_option('contact_program_center');
				if($address != '') { ?>
					<div><span>Program Center:</span><?php echo '<a href="https://www.google.com/maps/dir//'.urlencode($address).'" target="_blank" title="View in Google Maps">'.$address.'</a>'; ?></div>
				<?php } ?>
				<?php 
				$fax = get_option('contact_fax');
				if($fax != '') { ?>
					<div><span>Fax:</span><?php echo '<a href="fax:+1'.$fax.'" title="Fax '.$fax.'">'.$fax.'</a>'; ?></div>
				<?php } ?>
				<?php 
				$tel = get_option('contact_tel');
				if($tel != '') { ?>
					<div><span>Tel:</span><?php echo '<a href="tel:'.$tel.'" title="Call '.$tel.'">'.$tel.'</a>'; ?></div>
				<?php } ?>
			</div>
			<div class="footer line">
				<?php 
				$tel = get_option('contact_crisis_line_number');
				if($tel != '') { 
					$teltext = get_option('contact_crisis_line_text'); ?>
					<div><span>WISE Crisis Line:</span><?php echo '<a href="tel:'.$tel.'" title="Call '.$teltext.'">'.$teltext.'</a>'; ?></div>
				<?php } ?>
				<?php 
				$text = get_option('contact_text');
				if($text != '') { ?>
					<div><span>Text:</span><?php echo '<a href="sms:'.$text.'" title="Text '.$text.'">'.$text.'</a>'; ?></div>
				<?php } ?>
				<div class="social">
					<?php 
					$facebook = get_option('social_media_facebook');
					if($facebook != '') {
						echo '<a href="'.$facebook.'" title="Follow us on Facebook" target="_blank" class="facebook">Follow us on Facebook</a>';
					}
					$twitter = get_option('social_media_twitter');
					if($twitter != '') {
						echo '<a href="'.$twitter.'" title="Follow us on Twitter" target="_blank" class="twitter">Twitter</a>';
					}
					$instagram = get_option('social_media_instagram');
					if($instagram != '') {
						echo '<a href="'.$instagram.'" title="Follow us on Instagram" target="_blank" class="instagram">Follow us on Instagram</a>';
					}
					$youtube = get_option('social_media_youtube');
					if($youtube != '') {
						echo '<a href="'.$youtube.'" title="Follow us on YouTube" target="_blank" class="youtube">Follow us on YouTube</a>';
					}
					$email = get_option('social_media_email');
					if($email != '') {
						echo '<a href="mailto:'.$email.'" title="Email us!" target="_blank" class="email">Email us!</a>';
					}
					?>
				</div>
			</div>
		</div>
	</footer>
	<nav id="sticky-nav">
		<?php 
			$chat_url = get_option('live_chat_url');
			$close_location = get_option('exit_site_url');
			$crisis_number = '+1'.str_replace('-','',get_option('contact_crisis_line_number'));
			$text = '+1'.str_replace('-','',get_option('contact_text')); 
			$exit_tooltip = get_option('exit_tooltip');
		?>
		<div class="toggle text">See how we can help</div>
		<!--<div class="toggle close"><?php echo featherIcon('x','','20'); ?></div>-->
		<div class="toggle"><?php echo featherIcon('chevron-up','','40'); ?></div>
		<div class="expanded-content">
			<div class="content-container">
				<div class="sticky-heading">See How We Can Help</div>
				<?php
				/*wp_nav_menu(
					array(
						'theme_location'  => 'sticky',
						'menu_class'      => 'menu-wrapper',
						'container_class' => 'sticky-menu',
						'items_wrap'      => '<ul id="sticky-menu" class="%2$s">%3$s</ul>',
						'fallback_cb'     => false,
					)
				);*/
				$sticky_footer_content = get_option('sticky_footer');
				if($sticky_footer_content != '') {
					echo '<div class="sticky-menu">';
						echo '<ul id="sticky-menu" class="menu-wrapper">';
						//$simple = nl2br($sticky_footer_content);
						$explode = explode(PHP_EOL,$sticky_footer_content);
						foreach($explode as $ex) {
							echo '<li>'.$ex.'</li>';
						}
						echo '</ul>';
					echo '</div>';
				}
				?>
				<div class="contact">
					<div>WISE Crisis Line: <a href="tel:<?php echo $crisis_number; ?>" title="<?php echo get_option('contact_crisis_line_text'); ?>"><?php echo get_option('contact_crisis_line_text'); ?></a></div>
					<div>Text: <a href="sms:<?php echo $text; ?>"><?php echo get_option('contact_text'); ?></a></div>
				</div>
			</div>
		</div>
		<div class="sticky-content">
			<div class="contact">
				<div>WISE Crisis Line: <a href="tel:<?php echo $crisis_number; ?>" title="Call <?php echo get_option('contact_crisis_line_text'); ?>"><?php echo get_option('contact_crisis_line_text'); ?></a></div>
				<div>Text: <a href="sms:<?php echo $text; ?>" title="Text <?php echo get_option('contact_text'); ?>"><?php echo get_option('contact_text'); ?></a></div>
				<?php edit_post_link(featherIcon('edit-2').'Edit Page','<div class="sticky-edit">','</div>'); ?>
			</div>
			<div class="actions">
				<a href="<?php echo $chat_url; ?>" target="_blank" class="openchat" title="Open Live Chat">Live Chat</a>
				<a href="<?php echo $close_location; ?>" class="exitsite" title="Exit Site Now" <?php if($exit_tooltip != '') { echo 'data-tooltip="'.$exit_tooltip.'" data-tooltip-position="above"'; } ?>>Exit Site Now</a>
			</div>
		</div>
	</nav>
</div>
<?php wp_footer(); ?>
</body>
</html>