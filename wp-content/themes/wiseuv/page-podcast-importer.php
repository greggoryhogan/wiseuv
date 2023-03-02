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
				update_option('captured_podcasts',array());
				/*$captured = maybe_unserialize(get_option('captured_podcasts'));
				if (empty($captured)) {
					$captured = array();
				}
				// Get a SimplePie feed object from the specified feed source.
				$url = 'https://feeds.libsyn.com/460248/';
				
				$invalidurl = false;
				if(@simplexml_load_file($url)){
					$feeds = simplexml_load_file($url,"SimpleXMLElement", LIBXML_NOCDATA);
				}else{
					$invalidurl = true;
					echo "<h2>Invalid RSS feed URL.</h2>";
				}


				$i=0;
				if(!empty($feeds)){

					$site = $feeds->channel->title;
					$sitelink = $feeds->channel->link;
					$default_container_width = get_option('post_container_width');
					echo "<h2>".$site."</h2>";
					$i = 1;
					foreach ($feeds->channel->item as $item) {
						++$i;
						$guid = (string) $item->guid;
						//echo '<pre>'.print_r($item,true).'</pre>';
						if(!in_array($guid,$captured)) {
							$captured[] = $guid;

							$title = (string) $item->title;
							$pubDate = (string) $item->pubDate; //Sat, 18 Feb 2023 17:26:00 +0000
							$published = date("Y-m-d H:i:s", strtotime($pubDate));
							$link = (string) $item->link; //dont need
							$description = (string) $item->description;
							$excerpt_arr = explode('</p>',$description);
							$excerpt = $excerpt_arr[0];
							$enclosure = $item->enclosure;
							$atts = $enclosure->attributes();
							$length = (string) $atts['length'];
							$type = (string) $atts['type'];
							$url = (string) $atts['url'];
							$my_post = array(
								'post_title'    => wp_strip_all_tags( $title ),
								'post_status'   => 'publish',
								'post_type' => 'podcasts',
								'post_date' => $published,
								'post_excerpt' => $excerpt,
								'post_author' => 11
							);
							
							// Insert the post into the database
							$post_id = wp_insert_post( $my_post );
							if(!is_wp_error($post_id)){
								//the post is valid
								//Add guid for safety
								add_post_meta($post_id,'podcast_guid',$guid);

								//now add flexible content
								$field_name = 'flexible_content';
								add_row($field_name, 
									array( 
										'acf_fc_layout'=>'audio_file',
										'url' => $url,
										'type' => $type,
										'container_width' => $default_container_width,
										'desktop_padding' => '5rem 0 1rem 0',
										'tablet_padding' => '3rem 0 1rem',
										'mobile_padding' => '3rem 0 1rem',
									), $post_id
								);

								add_row($field_name, 
									array( 
										'acf_fc_layout'=>'podcast_links',
										'container_width' => $default_container_width,
										'desktop_padding' => '1rem 0',
										'tablet_padding' => '1rem 0',
										'mobile_padding' => '1rem 0',
									), $post_id
								);

								add_row($field_name, 
									array( 
										'acf_fc_layout'=>'hr',
										'container_width' => $default_container_width,
										'desktop_padding' => '4rem 0rem 0rem',
										'tablet_padding' => '3rem 0rem 0rem',
										'mobile_padding' => '3rem 0rem 0rem',
									), $post_id
								);

								add_row($field_name, 
									array( 
										'acf_fc_layout'=>'wysiwyg',
										'content' => $description,
										'container_width' => $default_container_width,
										'desktop_padding' => '1rem 0',
										'tablet_padding' => '1rem 0',
										'mobile_padding' => '1rem 0',
									), $post_id
								);
								echo 'Added '.$title.'<br>';
							} else {
								//there was an error in the post insertion, 
								echo $post_id->get_error_message();
							}

							
						}
						
						
					}
					update_option('captured_podcasts',$captured);
				} */
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</section>'; ?>
<?php get_footer(); ?>