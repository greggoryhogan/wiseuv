<?php get_header(); ?>
<?php 
/**
 * 
 * 
 * 
 * 
 * MAKE THE BUY NOW PAGES BEFORE RUNNING THIS IMPORTER!!!
 * 
 * 
 * 
 * 
 * 
 */
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
echo '<section class="blog-footer">';
	echo '<div class="container container__xs block-style-dark text-alignment-left">';
		echo '<div class="container-content">';
			echo '<div class="flexible-content wysiwyg">';
				$flexible_post_types = array('post','page','product','sfwd-courses','sfwd-lessons','sfwd-topic');
				$post_type = 'sfwd-topic';
				switch($post_type) {
					case 'product':
						$default_container_width = get_option('woo_container_width');
						break;
					case 'sfwd-courses':
						$default_container_width = get_option('course_container_width');
						break;
					case 'sfwd-topic':
						$default_container_width = get_option('course_container_width');
						break;
					case 'sfwd-lesson':
						$default_container_width = get_option('course_container_width');
						break;
					case 'post':
						$default_container_width = get_option('post_container_width');
						break;
					default:
						$default_container_width = 'normal';
						break;
				}
				$cta_args = array(
					'post_type' => $flexible_post_types,
					'posts_per_page' => 1,
					'post_status' => 'publish',
					'paged' => $paged,
				); //'offset' => 4, 'p' => 105, 

				$ignore_pages = array(
					'my-account',
					'blog',
					'cart',
					'shop',
					'checkout'
				);
				$ignore_title = array(
					'post',
					'product',
					'single-sfwd-courses'
				);
				$nonflex_posts = new WP_Query( $cta_args ); 
					if ( $nonflex_posts->have_posts() ) {
						$filename = RB_THEME_DIR . '/gutenberg-to-acf-converter.txt';
						$fp = fopen($filename, 'a') or die();//opens file in append mode  
						$notfound = array();
						while( $nonflex_posts->have_posts() ) { 
							$nonflex_posts->the_post();
							$flexible_post_id = get_the_ID();
							$field_name = 'flexible_content';
							$post_type = get_post_type();
							$title = get_the_title();
							$permalink = get_permalink();
							echo '<h2 class="font-normal">'.$post_type .': '.$title.'</h2>';
							edit_post_link('Edit and confirm','','','','');
							$edit = get_edit_post_link($flexible_post_id);
							//iterate each flexible section
							if ( !have_rows( $field_name, $flexible_post_id )) {
								$nonflex_post = get_post();
								if ( has_blocks( $nonflex_post->post_content ) ) {
									
									fwrite($fp, "Processing $title. - $permalink \n");  
									//add title as heading
									if(!in_array($post_type,$ignore_title) && !in_array($title,$ignore_pages) && !is_checkout() && !is_account_page()) {
										add_row($field_name, 
											array( 
												'acf_fc_layout'=>'heading',
												'heading' => $title,
												'tag' => 'h1',
												'size' => 'font-normal',
												'font-weight' => 'bold',
												'desktop_padding' => '0',
												'tablet_padding' => '0',
												'mobile_padding' => '0',
											), $flexible_post_id
										);
									}
									$blocks = parse_blocks( $nonflex_post->post_content );
									foreach($blocks as $block) {
										fwrite($fp, "\tProcessing block {$block['blockName']}.\n"); 
										switch($block['blockName']) {
											case 'core/embed':
												$url = $block['attrs']['url'];
												if(strpos($url,'youtube') !== false) {
													//youtube
													$params = explode('?v=',$url);
													$iframe_src = 'https://www.youtube.com/embed/'.$params[1];
													add_row($field_name, 
														array( 
															'acf_fc_layout'=>'video',
															'embed_url' => $iframe_src,
															'container_width' => $default_container_width,
															'desktop_padding' => '2rem 0',
															'tablet_padding' => '1rem 0',
															'mobile_padding' => '1rem 0',
														), $flexible_post_id
													);
												} else {
													//vimeo
													$remote = wp_remote_get('https://vimeo.com/api/oembed.json?url='.$url);
													//$remote = wp_remote_get('https://api.vimeo.com/videos/'.$url.'?access_token='.$access_token);
													///https://player.vimeo.com/video/745452769?h=66ef1726db&dnt=1&app_id=122963
													$json = json_decode(wp_remote_retrieve_body($remote));
													if($json) {
														$html = $json->html;
														//echo $html;
														preg_match('/src="([^"]+)"/', $html, $match);
														$iframe_src = $match[1];
														//echo 'Found '. $iframe_src;
														add_row($field_name, 
															array( 
																'acf_fc_layout'=>'video',
																'embed_url' => $iframe_src,
																'tag' => 'h1',
																'size' => 'normal',
																'container_width' => $default_container_width,
																'desktop_padding' => '2rem 0',
																'tablet_padding' => '1rem 0',
																'mobile_padding' => '1rem 0',
															), $flexible_post_id
														);
													}
												}
												
												break;
											case 'core/paragraph': 
												$innerHTML = $block['innerHTML'];
												if($post_type != 'post') {
													add_row($field_name, 
														array( 
															'acf_fc_layout'=>'wysiwyg',
															'content' => $innerHTML,
															'container_width' => $default_container_width,
															'desktop_padding' => '1rem 0',
															'tablet_padding' => '1rem 0',
															'mobile_padding' => '1rem 0',
														), $flexible_post_id
													);
												} else {
													add_row($field_name, 
														array( 
															'acf_fc_layout'=>'wysiwyg',
															'content' => $innerHTML,
															'container_width' => $default_container_width,
															'desktop_padding' => '0',
															'tablet_padding' => '0',
															'mobile_padding' => '0',
														), $flexible_post_id
													);
												}
												break;
											case 'core/buttons':
												$buttonHtml = $block['innerBlocks'];
												if(is_array($buttonHtml)) {
													$buttons = array();
													foreach($buttonHtml as $button) {
														preg_match_all('/<a\s[^>]*href=\"([^\"]*)\"[^>]*>(.*)<\/a>/siU', $button['innerHTML'], $hrefmatch);
														if(!empty($hrefmatch[1])) {
															$buttons[] = array('button' => array( 
																'url' => $hrefmatch[1][0], 
																'title' => $hrefmatch[2][0],
																'target' => '_blank',
															));
														}
													}
												}
												add_row($field_name, 
													array( 
														'acf_fc_layout'=>'cta_buttons',
														'buttons' => $buttons,
														'alignment' => 'center',
														'container_width' => $default_container_width,
														'desktop_padding' => '1rem 0',
														'tablet_padding' => '1rem 0',
														'mobile_padding' => '1rem 0',
													), $flexible_post_id
												);
												break;
											case 'acf/workbook-question':
												$questionId = $block['attrs']['data']['workbook_question'];
												add_row($field_name, 
													array( 
														'acf_fc_layout'=>'workbook_content',
														'workbook_question' => $questionId,
														'container_width' => $default_container_width,
														'desktop_padding' => '1rem 0',
														'tablet_padding' => '1rem 0',
														'mobile_padding' => '1rem 0',
													), $flexible_post_id
												);
												break;
											case 'core/html': //a podcast embed
												$html = $block['innerHTML'];
												add_row($field_name, 
													array( 
														'acf_fc_layout'=>'podcast_embed',
														'embed_code' => $html,
														'align' => 'center',
														'container_width' => $default_container_width,
														'desktop_padding' => '2rem 0',
														'tablet_padding' => '1rem 0',
														'mobile_padding' => '1rem 0',
													), $flexible_post_id
												);
												break;
											case 'core/list':
												$listitems = $block['innerBlocks'];
												if(empty($listitems)) {
													//it is stored in the html
													$list = $block['innerHTML'];
												} else {
													$list = '<ul>';
													foreach($listitems as $listitem) {
														$list .= $listitem['innerHTML'];
													}
													$list .= '</ul>';
												}
												add_row($field_name, 
													array( 
														'acf_fc_layout'=>'wysiwyg',
														'content' => $list,
														'container_width' => $default_container_width,
														'desktop_padding' => '1rem 0',
														'tablet_padding' => '1rem 0',
														'mobile_padding' => '1rem 0',
													), $flexible_post_id
												);
												break;
											case 'core/group':
												$groupitems = $block['innerBlocks'];
												$wysiwyg = '';
												foreach($groupitems as $group_item) {
													$wysiwyg .= $group_item['innerHTML'];
												}
												add_row($field_name, 
													array( 
														'acf_fc_layout'=>'wysiwyg',
														'content' => $wysiwyg,
														'container_width' => $default_container_width,
														'desktop_padding' => '1rem 0',
														'tablet_padding' => '1rem 0',
														'mobile_padding' => '1rem 0',
													), $flexible_post_id
												);
												break;
											case 'core/heading':
												$type = '2';
												if(array_key_exists('level',$block['attrs'])) {
													$type = $block['attrs']['level'];
												}
												if($type == '1' || $type == '2') {
													$size = 'font-bigger';
													$weight = 'bold';
												} else if($type == '3' || $type == '4') {
													$size = 'font-small';
													$weight = 'light';
												} else if($type == '5' || $type == '6') {
													$size = 'font-smaller';
													$weight = 'light';
												}
												$align = 'center';
												if(array_key_exists('textAlign',$block['attrs'])) {
													$align = $block['attrs']['textAlign'];
												}

												$headingHtml = $block['innerHTML'];
												preg_match('/<h'.$type.' class="(.*)">(.*?)<\/h'.$type.'>/s', $headingHtml, $matches);
												if (array_key_exists(2,$matches)) {
													$heading = $matches[2];
													if($heading != '') {
														add_row($field_name, 
															array( 
																'acf_fc_layout'=>'heading',
																'heading' => $heading,
																'tag' => 'h'.$type,
																'size' => $size,
																'alignment' => $align,
																'font-weight' => $weight,
																'desktop_padding' => '0',
																'tablet_padding' => '0',
																'mobile_padding' => '0',
															), $flexible_post_id
														);
													}
												}
												
												break;
											case 'learndash/ld-course-content':
												$course_id = $block['attrs']['course_id'];
												add_row($field_name, 
													array( 
														'acf_fc_layout'=>'course_content',
														'course' => $course_id,
														'container_width' => $default_container_width,
														'desktop_padding' => '1rem 0',
														'tablet_padding' => '1rem 0',
														'mobile_padding' => '1rem 0',
													), $flexible_post_id
												);
												break;
											case 'core/image':
												$attrs = $block['attrs'];
												$id = $attrs['id'];
												add_row($field_name, 
													array( 
														'acf_fc_layout'=>'image-module',
														'image' => $id,
														'image_size' => 'full',
														'force_images_full_width' => 'auto-width',
														'container_width' => $default_container_width,
														'desktop_padding' => '1rem 0',
														'tablet_padding' => '1rem 0',
														'mobile_padding' => '1rem 0',
													), $flexible_post_id
												);
												break;
											case 'core/spacer':
												$height = $block['attrs']['height'];
												$rem = str_replace('px','',$height) / 16;
												add_row($field_name, 
													array( 
														'acf_fc_layout'=>'empty_space',
														'container_width' => $default_container_width,
														'desktop_padding' => $rem.'rem 0 0 0',
														'tablet_padding' => $rem.'rem 0 0 0',
														'mobile_padding' => $rem.'rem 0 0 0',
													), $flexible_post_id
												);
												break;
											case 'core/separator':
												add_row($field_name, 
													array( 
														'acf_fc_layout'=>'hr',
														'container_width' => $default_container_width,
														'color' => '#14181B',
														'desktop_padding' => '1rem 0',
														'tablet_padding' => '1rem 0',
														'mobile_padding' => '1rem 0',
													), $flexible_post_id
												);
												break;
											case 'core/quote':
												$html = $block['innerHTML'];
												add_row($field_name, 
													array( 
														'acf_fc_layout'=>'wysiwyg',
														'content' => $html,
														'container_width' => $default_container_width,
														'desktop_padding' => '0',
														'tablet_padding' => '0',
														'mobile_padding' => '0',
													), $flexible_post_id
												);
												break;
											case 'core/block':
												//skip, it's nothing
												break;
											case 'formidable/simple-form':
												$shortcode = '[formidable id="'.$block['attrs']['formId'].'"]';
												add_row($field_name, 
													array( 
														'acf_fc_layout'=>'shortcode',
														'shortcode' => $shortcode,
														'container_width' => $default_container_width,
														'desktop_padding' => '1rem 0',
														'tablet_padding' => '1rem 0',
														'mobile_padding' => '1rem 0',
													), $flexible_post_id
												);
												break;
											case 'acf/babel-testimonial':
												$testimonials = $block['attrs']['data']['testimonials']; //array
												if(is_array($testimonials)) {
													$testimonial_array = array();
													$testimonial_posts = get_posts(array('post_type' => 'testimonial','include' => array($tesimonials)));
													if(is_array($testimonial_posts)) {
														foreach($testimonial_posts as $testimonial_post) {
															$testimonial_array[] =  array(
																'testimonial' => get_post_meta($testimonial_post->ID, 'testimonial_content', true ),
																'testimonial_line_1' => get_post_meta( $testimonial_post->ID, 'testimonial_attribution_line_1', true ),
																'testimonial_line_2' => get_post_meta( $testimonial_post->ID, 'testimonial_attribution_line_2', true ),
															);
														}
													}
												}
												add_row($field_name, 
													array( 
														'acf_fc_layout'=>'testimonials',
														'layout' => 'slider',
														'testimonials' => $testimonial_array,
														'container_width' => $default_container_width,
														'desktop_padding' => '1rem 0',
														'tablet_padding' => '1rem 0',
														'mobile_padding' => '1rem 0',
													), $flexible_post_id
												);
												break;
											case 'core/shortcode':
												$shortcode = str_replace('<div>','',str_replace('</div>','',$block['innerHTML']));
												add_row($field_name, 
													array( 
														'acf_fc_layout'=>'shortcode',
														'shortcode' => $shortcode,
														'container_width' => $default_container_width,
														'desktop_padding' => '1rem 0',
														'tablet_padding' => '1rem 0',
														'mobile_padding' => '1rem 0',
													), $flexible_post_id
												);
												break;
											default:
												if(!in_array($block['blockName'],$notfound) && $block['blockName'] != '') {
													$notfound[] = $block['blockName'] .' - '.$permalink;
												}
												break;
												//echo '<pre>'.print_r($block,true).'</pre>';
										}
											
									}
									fwrite($fp, "\tBlock processing complete. - $edit \n"); 
								}
							} else {
								fwrite($fp, "------SKIPPED $title --------- $edit \n"); 
							}
							echo '<hr />';
					} // end while
					if(!empty($notfound)) {
						fwrite($fp, "\nCould not find the following blocks to process.\n"); 
						foreach($notfound as $not) {
							fwrite($fp, "\t$not\n");  
						}
						fwrite($fp, "\n--------------------------------------------------------------------------\n"); 
					}
					fclose($fp);  //close file
					echo '<section class="blog-posts" style="background: #fff; margin-top: 30px;">';
						echo '<div class="blog-navigation acf-converter-pagination">';
							babel_pagination_nav($nonflex_posts);
						echo '</div>';
					echo '</section>';
				} // end if
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</section>'; ?>
<?php get_footer(); ?>