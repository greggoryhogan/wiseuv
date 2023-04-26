<?php 
$image = get_sub_field('image'); 
$heading = get_sub_field( 'heading' );
$subheading = get_sub_field( 'subheading' );
$eyebrow = get_sub_field('eyebrow');
$column_content = get_sub_field('content');
$link = get_sub_field('cta');
$link_second = get_sub_field('cta_second');
$image2 = get_sub_field('image_2'); 
$heading2 = get_sub_field( 'heading_2' );
$eyebrow2 = get_sub_field('eyebrow_2');
$subheading2 = get_sub_field( 'subheading_2' );
$column_content2 = get_sub_field('content_2');
$link2 = get_sub_field('cta_2');
$link2_second = get_sub_field('cta_2_second');
$image3 = get_sub_field('image_3'); 
$heading3 = get_sub_field( 'heading_3' );
$eyebrow3 = get_sub_field('eyebrow_3');
$subheading3 = get_sub_field( 'subheading_3' );
$column_content3 = get_sub_field('content_3');
$link3 = get_sub_field('cta_3');
$link3_second = get_sub_field('cta_3_second');
$image_size = get_sub_field('image_size');
$force_images_full_width = get_sub_field('force_images_full_width');
$row_order = get_sub_field('row_order');
$vertical_align = get_sub_field('vertical_align');
$heading_type = get_sub_field('heading_type');
$font_size = get_sub_field('font_size');
$font_weight = get_sub_field('font_weight');
$image_style = get_sub_field('image_style');
$column_width = get_sub_field('column_width');
$column_height = get_sub_field('column_height');
$remove_column_gap_on_mobile = get_sub_field('remove_column_gap_on_mobile');
?>
<div class="flexible-content three-column-content column-height-<?php echo $column_height; ?> <?php echo $remove_column_gap_on_mobile; ?>"><?php
    
    echo '<div class="contain-content">';
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
            echo '<'.$heading_type.' class="font-'.$font_size.' font-weight-'.$font_weight.'">'.wise_content_filters($heading).'</'.$heading_type.'>';
        }
        if($subheading != '') {
            echo '<p class="subheading bodoni">'.wise_content_filters($subheading).'</p>';
        }
        echo '<div class="column-content">';
            if($column_content != '') {
                echo $column_content;
            }
        echo '</div>';
        echo '<div class="buttons">';
            if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.wise_content_filters(esc_html( $link_title )).'</a>';
            endif;
            if( $link_second ): 
                $link_url = $link_second['url'];
                $link_title = $link_second['title'];
                $link_target = $link_second['target'] ? $link_second['target'] : '_self';
                echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.wise_content_filters(esc_html( $link_title )).'</a>';
            endif;
        echo '</div>';
    echo '</div>';  

    echo '<div class="contain-content">';
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
            echo '<'.$heading_type.' class="font-'.$font_size.'" font-weight-'.$font_weight.'>'.wise_content_filters($heading2).'</'.$heading_type.'>';
        }
        if($subheading2 != '') {
            echo '<p class="subheading bodoni">'.wise_content_filters($subheading2).'</p>';
        }
        echo '<div class="column-content">';
            if($column_content2 != '') {
                echo $column_content2;
            }
        echo '</div>';
        echo '<div class="buttons">';
            if( $link2 ): 
                $link_url = $link2['url'];
                $link_title = $link2['title'];
                $link_target = $link2['target'] ? $link2['target'] : '_self';
                echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.wise_content_filters(esc_html( $link_title )).'</a>';
            endif;
            if( $link2_second ): 
                $link_url = $link2_second['url'];
                $link_title = $link2_second['title'];
                $link_target = $link2_second['target'] ? $link2_second['target'] : '_self';
                echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.wise_content_filters(esc_html( $link_title )).'</a>';
            endif;
        echo '</div>';
    echo '</div>';  

    echo '<div class="contain-content">';
        if($image3 && $image_style) {
            echo '<div class="image '.$force_images_full_width.' '.$image_style;
            if(!$link3 && $heading3 == '' && $column_content3 == '') {
                echo ' no-margin';
            }
            echo '">';
                echo wp_get_attachment_image( $image3, $image_size );
            echo '</div>';
        }
        if($eyebrow3 != '') {
            echo '<p class="eyebrow">'.wise_content_filters($eyebrow3).'</p>';
        }
        if($heading3 != '') {
            echo '<'.$heading_type.' class="font-'.$font_size.'" font-weight-'.$font_weight.'>'.wise_content_filters($heading3).'</'.$heading_type.'>';
        }
        if($subheading3 != '') {
            echo '<p class="subheading bodoni">'.wise_content_filters($subheading3).'</p>';
        }
        echo '<div class="column-content">';
            if($column_content3 != '') {
                echo $column_content3;
            }
        echo '</div>';
        echo '<div class="buttons">';
            if( $link3 ): 
                $link_url = $link3['url'];
                $link_title = $link3['title'];
                $link_target = $link3['target'] ? $link3['target'] : '_self';
                echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.wise_content_filters(esc_html( $link_title )).'</a>';
            endif;
            if( $link3_second ): 
                $link_url = $link3_second['url'];
                $link_title = $link3_second['title'];
                $link_target = $link3_second['target'] ? $link3_second['target'] : '_self';
                echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.wise_content_filters(esc_html( $link_title )).'</a>';
            endif;
        echo '</div>';
    echo '</div>';  
    ?>
</div>
