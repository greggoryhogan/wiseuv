<?php 
$image_size = get_sub_field('image_size');
$force_images_full_width = get_sub_field('force_images_full_width');
$row_order = get_sub_field('row_order');
$heading_type = get_sub_field('heading_type');
$font_size = get_sub_field('font_size');
$font_weight = get_sub_field('font_weight');
$column_animation_anchor_placement = get_sub_field('column_animation_anchor_placement');
$column_animation_easing = get_sub_field('column_animation_easing');
$column_animation_easinganimation_speed = get_sub_field('column_animation_easinganimation_speed');
$image_style = get_sub_field('image_style');
$image_drop_shadow = get_sub_field('image_drop_shadow');
$columns = get_sub_field('columns');
$grid_options = get_sub_field('grid_options'); //block-links, text-center
?>
<div class="flexible-content grid-content columns__<?php echo $columns; ?> has-btn-sm"><?php
    if( have_rows('grid_items')) {
        while(have_rows('grid_items')) {
            the_row();
            $image = get_sub_field('image'); 
            $heading = get_sub_field( 'heading' );
            $subheading = get_sub_field( 'subheading' );
            $eyebrow = get_sub_field('eyebrow');
            $grid_content = get_sub_field('content');
            $link = get_sub_field('cta');
            if( $link) {
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
            }
            echo '<div class="grid-item';
            if($link) {
                if(in_array('block-links',$grid_options)) {
                    echo ' has-block-link';
                }
            }
            if(in_array('text-center',$grid_options)) {
                echo ' text-center';
            }
            echo '">';
                if($image) {
                    echo '<div class="image '.$force_images_full_width.' '.$image_style .' box-shadow-'.$image_drop_shadow.'">';
                        if($link && !in_array('block-links',$grid_options)) {
                            echo '<a href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">';
                        }
                        echo wp_get_attachment_image( $image, $image_size );
                        if($link && !in_array('block-links',$grid_options)) {
                            echo '</a>';
                        }
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
                if($grid_content != '') {
                    echo '<div class="font-size__'.$font_size.'">';
                        echo wise_content_filters($grid_content);
                    echo '</div>';
                }
                if( $link) {
                    if(!in_array('block-links',$grid_options)) {
                        echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.wise_content_filters(esc_html( $link_title )).'</a>';
                    } else {
                        echo '<a class="block-link" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'"></a>';
                    }   
                }
            echo '</div>';  
        }
    }
    ?>
</div>
