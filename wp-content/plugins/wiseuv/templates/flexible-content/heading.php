<?php 
$heading = get_sub_field( 'heading' );
$tag = get_sub_field('tag');
$size = get_sub_field('size');
$font_weight = get_sub_field('font_weight');
$color = get_sub_field('color'); ?>
<div class="flexible-content heading">
    <?php if($heading != '') {
        echo '<'.$tag.' class="'.$size.' font-weight-'.$font_weight.' color-'.$color.'">'.wise_content_filters($heading).'</'.$tag.'>';
    } ?>
</div>
