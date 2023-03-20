<?php 
$heading = get_sub_field( 'heading' );
$tag = get_sub_field('tag');
$size = get_sub_field('size');
$font_weight = get_sub_field('font_weight'); 
$tel = get_option('contact_crisis_line_number');
$button_text = get_sub_field('button_text'); ?>
<div class="flexible-content heading call_wise">
    <?php if($heading != '') {
        echo '<'.$tag.' class="'.$size.' font-weight-'.$font_weight.'">'.wise_content_filters($heading).'</'.$tag.'>';
    } ?>
    <a href="tel:<?php echo $tel; ?>" class="btn"><?php echo $button_text; ?></a>
</div>
