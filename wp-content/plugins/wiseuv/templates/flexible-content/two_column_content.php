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
$image_drop_shadow = get_sub_field('image_drop_shadow');
$column_width = get_sub_field('column_width');
?>
<!--<svg width="0" height="0" style="">
      <defs>
        <clipPath id="myCurve"><!-- clipPathUnits="objectBoundingBox"-->
    <!--    <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
        </clipPath>
      </defs>
    </svg>-->
   
<div class="flexible-content two-column-content <?php echo $row_order; ?> <?php echo $vertical_align; ?> column-width-<?php echo $column_width; ?>"><?php
    //if($link || $heading != '' || $column_content != '' || $image) {
        echo '<div class="contain-content"';
        if($column_1_animation != 'none') {
            echo ' data-aos="'.$column_1_animation.'" data-aos-easing="'.$column_animation_easing.'" data-aos-anchor-placement="'.$column_animation_anchor_placement.'" data-aos-duration="'.$column_animation_easinganimation_speed.'"';
        }
        echo '>';
            if($image) {
                echo '<div class="image '.$force_images_full_width.' '.$image_style .' box-shadow-'.$image_drop_shadow;
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
                echo '<'.$heading_type.' class="font-'.$font_size.' font-weight-'.$font_weight.'">'.wise_content_filters($heading).'</'.$heading_type.'>';
            }
            if($subheading != '') {
                echo '<p class="subheading">'.wise_content_filters($subheading).'</p>';
            }
            if($column_content != '') {
                echo '<div class="font-size__'.$font_size.'">';
                    echo wise_content_filters($column_content);
                echo '</div>';
            }
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
                echo '<div class="image '.$force_images_full_width.' '.$image_style .' box-shadow-'.$image_drop_shadow;
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
                echo '<'.$heading_type.' class="font-'.$font_size.'" font-weight-'.$font_weight.'>'.wise_content_filters($heading2).'</'.$heading_type.'>';
            }
            if($subheading2 != '') {
                echo '<p class="subheading">'.wise_content_filters($subheading2).'</p>';
            }
            if($column_content2 != '') {
                echo wise_content_filters($column_content2);
            }
            if( $link2 ): 
                $link_url = $link2['url'];
                $link_title = $link2['title'];
                $link_target = $link2['target'] ? $link2['target'] : '_self';
                echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.wise_content_filters(esc_html( $link_title )).'</a>';
            endif;
        echo '</div>';  
   // } ?>
</div>
