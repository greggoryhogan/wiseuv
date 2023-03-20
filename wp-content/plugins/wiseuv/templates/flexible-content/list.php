<?php 
$list_ordering = get_sub_field('list_ordering');
$list_style = get_sub_field('list_style');
if( have_rows('list_items') ):
    echo '<div class="flexible-content list">';
        echo '<'.$list_ordering.' class="'.$list_style.'">';
            while ( have_rows('list_items') ) : the_row();
                echo '<li>';
                    $label = get_sub_field('label');
                    $text = get_sub_field('text');
                    if($label != '') {
                        echo '<span class="list-label">'.$label.'</span>';
                    }
                    if($text != '') {
                        echo '<span class="list-item">'.$text.'</span>';
                    }
                echo '<li>';
            endwhile;
        echo '</'.$list_ordering.'>';
    echo '</div>';
endif;