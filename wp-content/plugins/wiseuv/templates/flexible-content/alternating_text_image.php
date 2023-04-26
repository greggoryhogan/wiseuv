<?php 
$first_row_shows = get_sub_field('first_row_shows'); //image-left or image-right
$heading_tag = get_sub_field('heading_tag');
$heading_size = get_sub_field('heading_size');
$font_weight = get_sub_field('font_weight');
$vertical_align = get_sub_field('vertical_align');
if( have_rows('rows') ):
    echo '<div class="flexible-content alternating-text-image '.$first_row_shows.'">';
        
        while ( have_rows('rows') ) : the_row();
            $image = get_sub_field('image'); //image id
            $heading = get_sub_field('heading');
            $content = get_sub_field('content');
            $link = get_sub_field('link');
            echo '<div class="row '.$vertical_align.'">';
                echo '<div class="image">';
                    if($image) {
                        echo wp_get_attachment_image( $image, 'large' );
                    }
                echo '</div>';
                echo '<div class="row-content">';
                    if($heading != '') {
                        echo '<'.$heading_tag.' class="'.$heading_size.' font-weight-'.$font_weight.'">'.wise_content_filters($heading).'</'.$heading_tag.'>';
                    }
                    if($content != '') {
                        echo wise_content_filters($content);
                    }
                    if( $link ): 
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                        echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.wise_content_filters(esc_html( $link_title )).'</a>';
                    endif;
                echo '</div>';
            echo '</div>';
        endwhile;
    echo '</div>';
endif;