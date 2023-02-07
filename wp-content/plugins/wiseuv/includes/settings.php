<?php 
/*
Functions related to overall plugin functionality
*/

/*
 *
 * Plugin Options for Admin Pages
 * 
 */
function wise_register_settings() {

    //Thank you page
    add_option( 'wise_group_leader_invite_content', '<p>Hello,</p><p>You have been assigned as a group leader on Redeeming wise. To join the group, please click the url below, or enter it in your web browser.</p><p>[invite_link]</p>');
    register_setting( 'wise_settings', 'wise_group_leader_invite_content' );

    //Thank you page
    add_option( 'wise_thankyou_content', 'Thank you. Your order has been received.');
    register_setting( 'wise_settings', 'wise_thankyou_content' );

    //labels
    add_option( 'wise_label_my-products', '');
    register_setting( 'wise_settings', 'wise_label_my-products' );
    add_option( 'wise_label_my-groups', '');
    register_setting( 'wise_settings', 'wise_label_my-groups' );

    //Misc
    add_option( 'wise_new_user_text', 'Welcome to Redeeming wise. Please take a minute to familiarize yourself with our new look.');
    register_setting( 'wise_settings', 'wise_new_user_text' );

    //Mailchimp
    add_option( 'mailchimp_heading_text', 'Join Our Mailing List');
    register_setting( 'wise_settings', 'mailchimp_heading_text' );
    add_option( 'mailchimp_body_text', '');
    register_setting( 'wise_settings', 'mailchimp_body_text' );
    add_option( 'mailchimp_success', 'Thank you for joining our mailing list!');
    register_setting( 'wise_settings', 'mailchimp_success' );
    add_option( 'mailchimp_api_key', '');
    register_setting( 'wise_settings', 'mailchimp_api_key' );
    add_option( 'mailchimp_list_id', '');
    register_setting( 'wise_settings', 'mailchimp_list_id' );

    add_option( 'google_analytics_code', '');
    register_setting( 'wise_settings', 'google_analytics_code' );
    add_option( 'footer_scripts', '');
    register_setting( 'wise_settings', 'footer_scripts' );

    //Discussion
    add_option( 'globally_disable_comments', '');
    register_setting( 'wise_settings', 'globally_disable_comments' );

    //Social
    //Discussion
    add_option( 'social_media_twitter', '');
    register_setting( 'wise_settings', 'social_media_twitter' );
    add_option( 'social_media_facebook', '');
    register_setting( 'wise_settings', 'social_media_facebook' );
    add_option( 'social_media_instagram', '');
    register_setting( 'wise_settings', 'social_media_instagram' );

    //Podcasts
    add_option( 'podcast_apple', '');
    register_setting( 'wise_settings', 'podcast_apple' );
    add_option( 'podcast_spotify', '');
    register_setting( 'wise_settings', 'podcast_spotify' );
    add_option( 'podcast_youtube', '');
    register_setting( 'wise_settings', 'podcast_youtube' );
    add_option( 'podcast_stitcher', '');
    register_setting( 'wise_settings', 'podcast_stitcher' );
    add_option( 'podcast_dispatch', '');
    register_setting( 'wise_settings', 'podcast_dispatch' );

    //woo container width
    add_option( 'woo_container_width', 'xs');
    register_setting( 'wise_settings', 'woo_container_width' );
    //post container width
    add_option( 'post_container_width', 'xs');
    register_setting( 'wise_settings', 'post_container_width' );
    //course container width
    add_option( 'course_container_width', 'xs');
    register_setting( 'wise_settings', 'course_container_width' );
    
    //subscribe modal
    add_option( 'subscribe_modal_heading', 'Subscribe to Redeeming wise');
    register_setting( 'wise_settings', 'subscribe_modal_heading' );
    add_option( 'subscribe_modal_text', '');
    register_setting( 'wise_settings', 'subscribe_modal_text' );
    
}
//add_action( 'admin_init', 'wise_register_settings' );

/*
 *
 * Create admin page
 * 
 */
function wise_core_admin_pages() {
    add_menu_page('Redeeming wise', 'Redeeming wise', 'administrator', 'redeeming-wise-settings', 'wise_settings_content','',2);
    add_submenu_page('redeeming-wise-settings', 'Redeeming wise Settings', 'Settings', 'administrator', 'redeeming-wise-settings', 'wise_settings_content' );
    //add_submenu_page('redeeming-wise-settings', 'Redeeming wise Documentation', 'Documentation', 'administrator', 'redeeming-wise-documentation', 'wise_documentation_content' );
}
//add_action( 'admin_menu', 'wise_core_admin_pages' );    
    
/*
 *
 * Admin page formatting
 * 
 */
function wise_settings_content() { ?> 
    <div class="wrap">
        <h1 class="wp-heading-inline">Redeeming wise Settings</h1>
        <?php settings_errors(); ?>
        <div class="metabox-holder wrap" id="dashboard-widgets">
            <form method="post" action="options.php" class="wise-settings">
                <?php settings_fields( 'wise_settings' ); ?>

                <div class="tabset">
                    <input type="radio" name="tabset" id="tab1" aria-controls="defaults" checked>
                    <label for="tab1">Defaults</label>

                    <input type="radio" name="tabset" id="tab2" aria-controls="learndash">
                    <label for="tab2">Learndash</label>

                    <input type="radio" name="tabset" id="tab3" aria-controls="woocommerce">
                    <label for="tab3">Woocommerce</label>

                    <div class="wise-tab-panels">
                        <section id="defaults" class="wise-tab-panel">
                            <div class="wise-settings-panel">
                                <!--labels-->
                                <div class="postbox">
                                    <div class="postbox-header"><h2 class="post-box-heading">General</h2></div>
                                    <div class="inside">
                                        <div class="input-text-wrap">
                                            <label>Twitter URL</label>
                                            <input type="text" name="social_media_twitter" value="<?php echo get_option('social_media_twitter'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Facebook URL</label>
                                            <input type="text" name="social_media_facebook" value="<?php echo get_option('social_media_facebook'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Instagram URL</label>
                                            <input type="text" name="social_media_instagram" value="<?php echo get_option('social_media_instagram'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Imported User Welcome Text</label>
                                            <input type="text" name="wise_new_user_text" value="<?php echo get_option('wise_new_user_text'); ?>" />
                                        </div>
                                    </div>
                                    <div class="inside">
                                        <div class="input-text-wrap">
                                            <label>Apple Podcasts URL</label>
                                            <input type="text" name="podcast_apple" value="<?php echo get_option('podcast_apple'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Spotify Podcast URL</label>
                                            <input type="text" name="podcast_spotify" value="<?php echo get_option('podcast_spotify'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>YouTube Podcast URL</label>
                                            <input type="text" name="podcast_youtube" value="<?php echo get_option('podcast_youtube'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Stitcher Podcast URL</label>
                                            <input type="text" name="podcast_stitcher" value="<?php echo get_option('podcast_stitcher'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Dispatch Podcast URL</label>
                                            <input type="text" name="podcast_dispatch" value="<?php echo get_option('podcast_dispatch'); ?>" />
                                        </div>
                                    </div>
                                    
                                    <div class="postbox-header"><h2 class="post-box-heading">Mailchimp</h2></div>
                                    <div class="inside">
                                        <div class="input-text-wrap">
                                            <label>Heading Text</label>
                                            <input type="text" name="mailchimp_heading_text" value="<?php echo get_option('mailchimp_heading_text'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Body</label>
                                            <input type="text" name="mailchimp_body_text" value="<?php echo get_option('mailchimp_body_text'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Success Message</label>
                                            <input type="text" name="mailchimp_success" value="<?php echo get_option('mailchimp_success'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Mailchimp API Key</label>
                                            <input type="text" name="mailchimp_api_key" value="<?php echo get_option('mailchimp_api_key'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Mailchimp Audience ID (Found in Audience > Settings > Unique ID)</label>
                                            <input type="text" name="mailchimp_list_id" value="<?php echo get_option('mailchimp_list_id'); ?>" />
                                        </div>
                                    </div>

                                    <div class="postbox-header"><h2 class="post-box-heading">Subscribe Modal</h2></div>
                                    <div class="inside">
                                        <div class="input-text-wrap">
                                            <label>Heading Text</label>
                                            <input type="text" name="subscribe_modal_heading" value="<?php echo get_option('subscribe_modal_heading'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Body</label>
                                            <textarea name="subscribe_modal_text" rows="10"><?php echo get_option('subscribe_modal_text'); ?></textarea>
                                        </div>
                                    </div>

                                    
                                    
                                </div>
                                <!--analytics-->
                                <div class="postbox">
                                    <div class="postbox-header"><h2 class="post-box-heading">Discussion</h2></div>
                                    <div class="inside">
                                        <div class="input-checkbox-wrap">
                                            <?php $checked = '';
                                            if(get_option('globally_disable_comments') == 'on') {
                                                $checked = ' checked';
                                            } ?>
                                            <input type="checkbox" name="globally_disable_comments" id="globally_disable_comments"<?php echo $checked; ?> />
                                            <label for="globally_disable_comments">Globally Disable Comments</label>
                                        </div>
                                    </div>
                                    <div class="postbox-header"><h2 class="post-box-heading">Scripts</h2></div>
                                    <div class="inside">
                                        <div class="input-text-wrap">
                                            <label>Header Scripts</label>
                                            <textarea name="google_analytics_code" rows="10"><?php echo get_option('google_analytics_code'); ?></textarea>
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Footer Scripts</label>
                                            <textarea name="footer_scripts" rows="10"><?php echo get_option('footer_scripts'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="postbox-header"><h2 class="post-box-heading">Default Container Widths</h2></div>
                                    <div class="inside">
                                        <?php $containers = array(
                                            'woo',
                                            'post',
                                            'course'
                                        );
                                        $widths = array(
                                            array('xxs','Narrowest'),
                                            array('xs','Extra Narrow'),
                                            array('sm','Narrow'),
                                            array('normal','Normal'),
                                            array('lg','Wide'),
                                            array('xl','Extra Wide'),
                                            array('xxl','Widest'),
                                        );
                                        foreach($containers as $container) { ?>
                                            <div class="input-text-wrap">
                                                <label><?php echo ucwords($container); ?> Container Width</label><br>
                                                <select name="<?php echo $container; ?>_container_width" rows="10" style="width: 100%;max-width: 100%;">
                                                    <?php foreach($widths as $width) {
                                                        echo '<option value="'.$width[0].'"';
                                                        if(get_option($container.'_container_width') == $width[0]) {
                                                            echo ' selected';
                                                        }
                                                        echo '>'.$width[1].'</option>';
                                                    } ?>
                                                </select>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </section>
                        <!--learndash-->
                        <section id="learndash" class="wise-tab-panel">
                            <div class="wise-settings-panel">
                                <!--Custom CSS-->
                                <div class="postbox">
                                    <div class="postbox-header"><h2 class="post-box-heading">Group leader invitation</h2></div>
                                    <div class="inside">
                                        <?php 
                                        $settings = array(
                                            'teeny' => false,
                                            'editor_height' => 425,
                                            'textarea_rows' => 20
                                        );
                                        wp_editor(wpautop(get_option('wise_group_leader_invite_content', 'wise')), 'wise_group_leader_invite_content', $settings); ?>
                                        <p><strong>Placeholders:</strong><br>
                                        [invite_link] shows the invitation URL</p>
                                        <p><strong>Notes:</strong><br>All emails are appended with:<em>God bless, Redeeming wise</em></p>
                                    </div>
                                </div>

                                <div class="postbox">
                                    
                                </div>
                            </div>
                            <div class="clear"></div>
                        </section>
                        <!--Woo-->
                        <section id="woocommerce" class="wise-tab-panel">
                            <div class="wise-settings-panel">
                                <!--Custom CSS-->
                                <div class="postbox">
                                    <div class="postbox-header"><h2 class="post-box-heading">Thank you page content</h2></div>
                                    <div class="inside">
                                        <?php 
                                        $settings = array(
                                            'teeny' => false,
                                            'editor_height' => 425,
                                            'textarea_rows' => 20
                                        );
                                        wp_editor(wpautop(get_option('wise_thankyou_content', 'wise')), 'wise_thankyou_content', $settings); ?>
                                    </div>
                                </div>

                                <div class="postbox">
                                    <div class="postbox-header"><h2 class="post-box-heading">Tooltips</h2></div>
                                    <div class="inside">
                                        <div class="input-text-wrap">
                                            <label>My Products</label>
                                            <input type="text" name="wise_label_my-products" value="<?php echo get_option('wise_label_my-products'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>My Groups</label>
                                            <input type="text" name="wise_label_my-groups" value="<?php echo get_option('wise_label_my-groups'); ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </section>
                    </div><!--close tab panels-->
                </div><!--close tabset-->
                
                <?php submit_button(); ?>
            </form>    
        </div>
    </div>
<?php
}
?>