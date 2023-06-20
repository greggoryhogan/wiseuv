<?php 
$heading = get_sub_field( 'heading' );
$tag = get_sub_field('tag');
$size = get_sub_field('size');
$font_weight = get_sub_field('font_weight');
$heading_links_to = get_sub_field('heading_links_to'); ?>
<div class="flexible-content heading">
    <?php if($heading != '') {
        if($heading_links_to != '') {
            echo '<a href="'.$heading_links_to.'">';
        }
        echo '<'.$tag.' class="'.$size.' font-weight-'.$font_weight.'">'.wise_content_filters($heading).'</'.$tag.'>';
        if($heading_links_to != '') {
            echo '</a>';
        }
    } ?>
</div>
