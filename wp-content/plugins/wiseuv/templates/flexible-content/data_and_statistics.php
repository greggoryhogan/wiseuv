<?php 
$attribution_image = get_sub_field('attribution_image');
$rand = rand(0,1000);
if( have_rows('data__statistics') ):
    $rows = 0;
    echo '<div class="flexible-content data-statistics">';
        echo '<div class="data-container">';
            while ( have_rows('data__statistics') ) : the_row();
                ++$rows;
                $title = get_sub_field('title');
                $prepend = get_sub_field('prepend');
                $number = get_sub_field('number');
                $append = get_sub_field('append');
                $data_options = get_sub_field('data_options'); //red-circle, align-left, use-counter
                echo '<div class="data';
                if(!empty($data_options)) {
                    foreach($data_options as $option) {
                        echo ' '.$option;
                    }
                }
                echo '">';
                    if($title != '') {
                        echo '<div class="title">'.$title.'</div>';
                    }
                    echo '<div class="stat">';
                        if($prepend != '') {
                            echo '<div class="prepend">'.$prepend.'</div>';
                        }
                        if($number != '') {
                            echo '<div id="data-'.$rand.'-'.$rows.'" class="number">'.$number.'</div>';
                        }
                        if($append != '') {
                            echo '<div class="append">'.$append.'</div>';
                        }
                    echo '</div>';
                echo '</div>';
            endwhile;
        echo '</div>';
        if($attribution_image) {
            echo wp_get_attachment_image( $attribution_image, 'medium', false, array('class' => 'attribution-image') );
        }
    echo '</div>';
endif;