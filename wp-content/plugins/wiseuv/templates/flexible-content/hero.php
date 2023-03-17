<?php 
$heading = get_sub_field('heading');
$content = get_sub_field('content');
$style = get_sub_field('style');
$link = get_sub_field('link');
$background_image = get_sub_field('background_image');
?>
<div class="flexible-content hero style-<?php echo $style; ?>">
    <?php if($heading != '') { 
        $tag = get_sub_field('tag');
        $heading_size = get_sub_field('heading_size');
        $font_weight = get_sub_field('font_weight');
        echo '<'.$tag.' class="'.$heading_size.' '.$font_weight.'">'.wise_content_filters($heading).'</'.$tag.'>';
    } ?>
    <?php if($content != '') {
        $text_size = get_sub_field('text_size');
        echo '<div class="content-wrapper '.$text_size.'">'.do_shortcode($content).'</div>';
    } ?>
    <?php if( $link ): 
        $link_url = $link['url'];
        $link_title = $link['title'];
        $link_target = $link['target'] ? $link['target'] : '_self';
        echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.wise_content_filters(esc_html( $link_title )).'</a>';
    endif; ?>
</div>
