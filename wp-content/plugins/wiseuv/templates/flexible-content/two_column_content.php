<?php 
$image = get_sub_field('image'); 
$heading = get_sub_field( 'heading' );
$subheading = get_sub_field( 'subheading' );
$eyebrow = get_sub_field('eyebrow');
$column_content = get_sub_field('content');
$link = get_sub_field('cta');
$image2 = get_sub_field('image_2'); 
$heading2 = get_sub_field( 'heading_2' );
$eyebrow2 = get_sub_field('eyebrow_2');
$subheading2 = get_sub_field( 'subheading_2' );
$column_content2 = get_sub_field('content_2');
$link2 = get_sub_field('cta_2');
$image_size = get_sub_field('image_size');
$force_images_full_width = get_sub_field('force_images_full_width');
$row_order = get_sub_field('row_order');
$vertical_align = get_sub_field('vertical_align');
$heading_type = get_sub_field('heading_type');
$font_size = get_sub_field('font_size');
$font_weight = get_sub_field('font_weight');
$column_1_animation = get_sub_field('column_1_animation');
$column_2_animation = get_sub_field('column_2_animation');
$column_animation_anchor_placement = get_sub_field('column_animation_anchor_placement');
$column_animation_easing = get_sub_field('column_animation_easing');
$column_animation_easinganimation_speed = get_sub_field('column_animation_easinganimation_speed');
$image_style = get_sub_field('image_style');
$column_width = get_sub_field('column_width');
$column_height = get_sub_field('column_height');
?>
<div class="flexible-content two-column-content <?php echo $row_order; ?> <?php echo $vertical_align; ?> column-width-<?php echo $column_width; ?>  column-height-<?php echo $column_height; ?>"><?php
    //if($link || $heading != '' || $column_content != '' || $image) {
        echo '<div class="contain-content"';
        if($column_1_animation != 'none') {
            echo ' data-aos="'.$column_1_animation.'" data-aos-easing="'.$column_animation_easing.'" data-aos-anchor-placement="'.$column_animation_anchor_placement.'" data-aos-duration="'.$column_animation_easinganimation_speed.'"';
        }
        echo '>';
            if($image) {
                echo '<div class="image '.$force_images_full_width.' '.$image_style;
                if(!$link && $heading == '' && $column_content == '') {
                    echo ' no-margin';
                }
                echo '">';
                    echo wp_get_attachment_image( $image, $image_size );
                echo '</div>';
            }
            if($eyebrow != '') {
                echo '<p class="eyebrow">'.wise_content_filters($eyebrow).'</p>';
            }
            if($heading != '') {
                echo '<'.$heading_type.' class="'.$font_size.' font-weight-'.$font_weight.'">'.wise_content_filters($heading).'</'.$heading_type.'>';
            }
            if($subheading != '') {
                echo '<p class="subheading bodoni">'.wise_content_filters($subheading).'</p>';
            }
            echo '<div class="column-content">';
                if($column_content != '') {
                    echo wise_content_filters($column_content);
                }
            echo '</div>';
            if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.wise_content_filters(esc_html( $link_title )).'</a>';
            endif;
        echo '</div>';  
    //}
    //if($link2 || $heading2 != '' || $column_content2 != '' || $image2) {
        echo '<div class="right contain-content"';
        if($column_2_animation != 'none') {
            echo ' data-aos="'.$column_2_animation.'" data-aos-easing="'.$column_animation_easing.'" data-aos-anchor-placement="'.$column_animation_anchor_placement.'" data-aos-duration="'.$column_animation_easinganimation_speed.'"';
        }
        echo '>';
            if($image2 && $image_style) {
                echo '<div class="image '.$force_images_full_width.' '.$image_style;
                if(!$link2 && $heading2 == '' && $column_content2 == '') {
                    echo ' no-margin';
                }
                echo '">';
                    echo wp_get_attachment_image( $image2, $image_size );
                echo '</div>';
            }
            if($eyebrow2 != '') {
                echo '<p class="eyebrow">'.wise_content_filters($eyebrow2).'</p>';
            }
            if($heading2 != '') {
                echo '<'.$heading_type.' class="'.$font_size.'" font-weight-'.$font_weight.'>'.wise_content_filters($heading2).'</'.$heading_type.'>';
            }
            if($subheading2 != '') {
                echo '<p class="subheading bodoni">'.wise_content_filters($subheading2).'</p>';
            }
            echo '<div class="column-content">';
                if($column_content2 != '') {
                    echo wise_content_filters($column_content2);
                }
            echo '</div>';
            if( $link2 ): 
                $link_url = $link2['url'];
                $link_title = $link2['title'];
                $link_target = $link2['target'] ? $link2['target'] : '_self';
                echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.wise_content_filters(esc_html( $link_title )).'</a>';
            endif;
        echo '</div>';  
   // } ?>
</div>
