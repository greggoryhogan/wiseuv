<?php 
if(have_rows('sections')) {
    echo '<div class="flexible-content heading-wysiwyg-repeater">';
        while(have_rows('sections')) {
            the_row();
            $heading = get_sub_field( 'heading' );
            $tag = get_sub_field('tag');
            $size = get_sub_field('size');
            $font_weight = get_sub_field('font_weight');
            $content = get_sub_field('content'); ?>
            <div class="heading-w-content">
                <?php if($heading != '') {
                    echo '<'.$tag.' class="'.$size.' font-weight-'.$font_weight.'">'.wise_content_filters($heading).'</'.$tag.'>';
                }
                if($content != '') {
                    echo $content;
                }
                echo '<div class="flexible-content cta-buttons columns-auto">';
                    $link = get_sub_field('button');
                    if( $link ): 
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                        echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.wise_content_filters(esc_html( $link_title )).'</a>';
                    endif;
                echo '</div>';
                ?>
            </div><?php 
        }
    echo '</div>';
}