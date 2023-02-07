<?php 
$heading = get_sub_field( 'heading' );
$tag = get_sub_field('tag');
$size = get_sub_field('size');
$alignment = get_sub_field('alignment'); 
$font_weight = get_sub_field('font_weight'); ?>
<div class="flexible-content heading align-<?php echo $alignment; ?>">
    <?php if($heading != '') {
        echo '<'.$tag.' class="'.$size.' font-weight-'.$font_weight.'">'.wise_content_filters($heading).'</'.$tag.'>';
    } ?>
</div>
