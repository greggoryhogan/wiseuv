<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add flexible content band paddings to css in header
 */
add_action('wp_head','rb_acf_header_css');
function rb_acf_header_css() {
	$flexible_post_types = array('post','page','product','podcasts','sfwd-courses','sfwd-lesson','sfwd-topic');
	$post_type = get_post_type();
	if(in_array($post_type,$flexible_post_types) && function_exists('get_field')) {
		$acf_field_name = 'flexible_content';
		$acf_post_id = get_the_ID();
		//iterate each flexible section
		if ( have_rows( $acf_field_name, $acf_post_id ) ) :			
			$band = 0;
			$desktop_padding = '';
			$tablet_padding = '';
			$mobile_padding = '';
			$globals = '';
			while ( have_rows( $acf_field_name, $acf_post_id ) ) : the_row();	
				++$band;
				if($band == 1) {
					$desktop_padding .= '#rb-content-band-1.two_column_content p {font-size:1.078rem;line-height:1.734rem;}';
				}
				$acf_row_layout = get_row_layout();
				$heading_color = get_sub_field('heading_color');
				if($heading_color != '#333333') {
					$globals .= '#rb-content-band-'.$band.' h1, #rb-content-band-'.$band.' h2, #rb-content-band-'.$band.' h3, #rb-content-band-'.$band.' h4, #rb-content-band-'.$band.' h5, #rb-content-band-'.$band.' h6 {color: '.$heading_color.';}';
				}
				$text_color = get_sub_field('text_color');
				if($text_color != '#333333') {
					$globals .= '#rb-content-band-'.$band.' .contain-content > *:not(h1,h2,h3,h4,h5,h6) {color: '.$text_color.';}';
				}

				$background_color = strtolower(get_sub_field('background_color'));
				if(substr($background_color,0,4) != '#fff') {
					$globals .= '#rb-content-band-'.$band.' {background-color:'.$background_color.';}';
				}
				$desktop_padding .= '#rb-content-band-'.$band.'{margin:'.get_sub_field('desktop_margin').';}';
				$tablet_padding .= '#rb-content-band-'.$band.'{margin:'.get_sub_field('tablet_margin').';}';
				$mobile_padding .= '#rb-content-band-'.$band.'{margin:'.get_sub_field('mobile_margin').';}';
				
				$desktop_padding .= '#rb-content-band-'.$band.'{padding:'.get_sub_field('desktop_padding').';}';
				$tablet_padding .= '#rb-content-band-'.$band.'{padding:'.get_sub_field('tablet_padding').';}';
				$mobile_padding .= '#rb-content-band-'.$band.'{padding:'.get_sub_field('mobile_padding').';}';
				if($acf_row_layout == 'testimonials_slider') {
					wp_enqueue_style( 'slick-css' );
					wp_enqueue_script( 'slick-js' );
				}
				if($acf_row_layout == 'testimonials') {
					$layout = get_sub_field('layout');
					if($layout == 'slider') {
						wp_enqueue_style( 'slick-css' );
						wp_enqueue_script( 'slick-js' );
					}
				}
				if($acf_row_layout == 'data_and_statistics') {
					wp_enqueue_script('countup');
				}
				if($acf_row_layout == 'two_column_content') {
					if(get_sub_field('limit_text_width') == 'yes') {
						$desktop_padding .= '#rb-content-band-'.$band.' .contain-content > *:not(.image) {max-width:'.get_sub_field('desktop_width').'%;}';
						$tablet_padding .= '#rb-content-band-'.$band.' .contain-content > *:not(.image) {max-width:'.get_sub_field('tablet_width').'%;}';
					}
					if(get_sub_field('limit_image_width') == 'yes') {
						$desktop_padding .= '#rb-content-band-'.$band.' .contain-content > .image {max-width:'.get_sub_field('image_desktop_width').'%;}';
						$tablet_padding .= '#rb-content-band-'.$band.' .contain-content > .image {max-width:'.get_sub_field('image_tablet_width').'%;}';
					}
				}
			endwhile;
			?>
			<style type="text/css">
				<?php echo $globals; ?>
				@media all and (min-width: 73rem) {<?php echo $desktop_padding; ?>}
				@media all and (max-width: 73rem) and (min-width: 48rem) { <?php echo $tablet_padding; ?> } 
				@media all and (max-width: 48rem) { <?php echo $mobile_padding; ?> }
			</style><?php 
		endif;
	}
}