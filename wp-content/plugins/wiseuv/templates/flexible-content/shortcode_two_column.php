<?php 
$shortcode = get_sub_field('shortcode');
$shortcode2 = get_sub_field('shortcode_2');
?>
<div class="flexible-content two-column-content two-column-shortcode column-width-50-50">
    <div class="contain-content">
        <?php echo do_shortcode($shortcode); ?>
    </div>
    <div class="contain-content">
        <?php echo do_shortcode($shortcode2); ?>
    </div>
</div>
