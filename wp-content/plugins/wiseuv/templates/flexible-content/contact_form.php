<?php 
$before_form = get_sub_field('before_form');
$form_shortcode = get_sub_field('form_shortcode');
$width = get_sub_field('width'); //left, right, full
?>
<div class="flexible-content contact-form position-<?php echo $width; ?>"><?php
    if($before_form != '') {
        echo '<div class="intro">';
            echo $before_form;
        echo '</div>';
    }  
    if($form_shortcode != '') {
        echo do_shortcode($form_shortcode);
    }
?>    
</div>
