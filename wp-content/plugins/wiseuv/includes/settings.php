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

    add_option( 'google_analytics_code', '');
    register_setting( 'wise_settings', 'google_analytics_code' );
    add_option( 'footer_scripts', '');
    register_setting( 'wise_settings', 'footer_scripts' );

    //Social
    //Discussion
    add_option( 'social_media_twitter', '');
    register_setting( 'wise_settings', 'social_media_twitter' );
    add_option( 'social_media_facebook', '');
    register_setting( 'wise_settings', 'social_media_facebook' );
    add_option( 'social_media_instagram', '');
    register_setting( 'wise_settings', 'social_media_instagram' );
    add_option( 'social_media_email', '');
    register_setting( 'wise_settings', 'social_media_email' );
    add_option( 'social_media_youtube', '');
    register_setting( 'wise_settings', 'social_media_youtube' );

    //containers
    add_option( 'default_container_width', 'normal');
    register_setting( 'wise_settings', 'default_container_width' );
    
    //Contact
    add_option( 'contact_program_center', '38 Bank St. Lebanon, NH 03766');
    register_setting( 'wise_settings', 'contact_program_center' );
    add_option( 'contact_fax', '603-448-2799');
    register_setting( 'wise_settings', 'contact_fax' );
    add_option( 'contact_tel', '603-448-5922');
    register_setting( 'wise_settings', 'contact_tel' );
    add_option( 'contact_text', '603-448-5922');
    register_setting( 'wise_settings', 'contact_text' );
    add_option( 'contact_crisis_line_text', '866-348-WISE');
    register_setting( 'wise_settings', 'contact_crisis_line_text' );
    add_option( 'contact_crisis_line_number', '866-348-9473');
    register_setting( 'wise_settings', 'contact_crisis_line_number' );

    //Links
    add_option( 'live_chat_url', 'https://www.resourceconnect.com/wiseuv/chat');
    register_setting( 'wise_settings', 'live_chat_url' );
    add_option( 'exit_site_url', 'https://wisesnacks.com');
    register_setting( 'wise_settings', 'exit_site_url' );
    add_option( 'exit_site_tab_url', 'https://google.com');
    register_setting( 'wise_settings', 'exit_site_tab_url' );

}
add_action( 'admin_init', 'wise_register_settings' );

/*
 *
 * Create admin page
 * 
 */
function wise_core_admin_pages() {
    add_menu_page('WISE UV', 'WISE UV', 'administrator', 'wise-settings', 'wise_settings_content','',2);
    add_submenu_page('wise-settings', 'Redeeming wise Settings', 'Settings', 'administrator', 'wise-settings', 'wise_settings_content' );
    //add_submenu_page('wise-settings', 'Redeeming wise Documentation', 'Documentation', 'administrator', 'wise-documentation', 'wise_documentation_content' );
}
add_action( 'admin_menu', 'wise_core_admin_pages' );    
    
/*
 *
 * Admin page formatting
 * 
 */
function wise_settings_content() { ?> 
    <div class="wrap">
        <h1 class="wp-heading-inline">WISE UV Site Options</h1>
        <?php settings_errors(); ?>
        <div class="metabox-holder wrap" id="dashboard-widgets">
            <form method="post" action="options.php" class="wise-settings">
                <?php settings_fields( 'wise_settings' ); ?>

                <div class="tabset">
                    <input type="radio" name="tabset" id="tab1" aria-controls="defaults" checked>
                    <label for="tab1">General</label>

                    <input type="radio" name="tabset" id="tab2" aria-controls="defaults">
                    <label for="tab2">Defaults</label>

                    <input type="radio" name="tabset" id="tab3" aria-controls="scripts">
                    <label for="tab3">Scripts</label>

                    <div class="wise-tab-panels">
                        <section id="about" class="wise-tab-panel">
                            <div class="wise-settings-panel">
                                <!--labels-->
                                <div class="postbox">
                                    <div class="postbox-header"><h2 class="post-box-heading">Contact</h2></div>
                                    <div class="inside">
                                        <div class="input-text-wrap">
                                            <label>Program Center</label>
                                            <input type="text" name="contact_program_center" value="<?php echo get_option('contact_program_center'); ?>" />
                                        </div>    
                                        <div class="input-text-wrap">
                                            <label>Fax</label>
                                            <input type="text" name="contact_fax" value="<?php echo get_option('contact_fax'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Telephone</label>
                                            <input type="text" name="contact_tel" value="<?php echo get_option('contact_tel'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Text</label>
                                            <input type="text" name="contact_text" value="<?php echo get_option('contact_text'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Crisis Line (Display)</label>
                                            <input type="text" name="contact_crisis_line_text" value="<?php echo get_option('contact_crisis_line_text'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Crisis Line (Number)</label>
                                            <input type="text" name="contact_crisis_line_number" value="<?php echo get_option('contact_crisis_line_number'); ?>" />
                                        </div>
                                    </div>
                                    <p><em>Note: Sticky Footer menu is managed under <a href="<?php echo get_bloginfo('url'); ?>/wp-admin/nav-menus.php">Appearance &gt; Menus</a> </em></p>    
                                </div>
                                <div class="postbox">
                                    <div class="postbox-header"><h2 class="post-box-heading">Links</h2></div>
                                    <div class="inside">
                                        <div class="input-text-wrap">
                                            <label>Live Chat URL</label>
                                            <input type="text" name="live_chat_url" value="<?php echo get_option('live_chat_url'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Exit Site URL</label>
                                            <input type="text" name="exit_site_url" value="<?php echo get_option('exit_site_url'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Exit Site New Tab URL</label>
                                            <input type="text" name="exit_site_tab_url" value="<?php echo get_option('exit_site_tab_url'); ?>" />
                                        </div>
                                    </div>
                                    <div class="postbox-header"><h2 class="post-box-heading">Social</h2></div>
                                    <div class="inside">
                                        <div class="input-text-wrap">
                                            <label>Facebook URL</label>
                                            <input type="text" name="social_media_facebook" value="<?php echo get_option('social_media_facebook'); ?>" />
                                        </div>    
                                        <div class="input-text-wrap">
                                            <label>Twitter URL</label>
                                            <input type="text" name="social_media_twitter" value="<?php echo get_option('social_media_twitter'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Instagram URL</label>
                                            <input type="text" name="social_media_instagram" value="<?php echo get_option('social_media_instagram'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>YouTube URL</label>
                                            <input type="text" name="social_media_youtube" value="<?php echo get_option('social_media_youtube'); ?>" />
                                        </div>
                                        <div class="input-text-wrap">
                                            <label>Email</label>
                                            <input type="text" name="social_media_email" value="<?php echo get_option('social_media_email'); ?>" />
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="clear"></div>
                        </section>
                        <section id="defaults" class="wise-tab-panel">
                            <div class="wise-settings-panel">
                                <!--labels-->
                                <div class="postbox">
                                    <div class="postbox-header"><h2 class="post-box-heading">Container Widths</h2></div>
                                    <div class="inside">
                                        <?php $containers = array(
                                            'default'
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
                        <section id="scripts" class="wise-tab-panel">
                            <div class="wise-settings-panel">
                                <!--analytics-->
                                <div class="postbox">
                                    <div class="postbox-header"><h2 class="post-box-heading">Header Scripts (Google Analytics, Facebook Pixel, Etc)</h2></div>
                                    <div class="inside">
                                        <div class="input-text-wrap">
                                            <textarea name="google_analytics_code" rows="10"><?php echo get_option('google_analytics_code'); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                           
                                <div class="postbox">
                                        <div class="postbox-header"><h2 class="post-box-heading">Footer Scripts (Trackers, External Scripts)</h2></div>
                                        <div class="inside">
                                            <div class="input-text-wrap">
                                                <textarea name="footer_scripts" rows="10"><?php echo get_option('footer_scripts'); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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