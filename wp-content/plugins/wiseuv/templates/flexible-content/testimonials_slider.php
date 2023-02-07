<?php 
$testimonials = get_sub_field('testimonials');
if(!empty($testimonials)) {
    echo '<div class="flexible-content testimonials-slider">';
        echo '<div class="slider">';
        foreach($testimonials as $testimonial) {
            $testimonial_content = get_post_meta( $testimonial, 'testimonial_content', true );
            $testimonial_attribution_line_1 = get_post_meta( $testimonial, 'testimonial_attribution_line_1', true );
            $testimonial_attribution_line_2 = get_post_meta( $testimonial, 'testimonial_attribution_line_2', true );
            echo '<div class="testimonial">';
                if($testimonial_content != '') {
                    echo '<div class="testimonial__content">'.wise_content_filters($testimonial_content).'</div>';
                }
                if($testimonial_attribution_line_1 != ''  && $testimonial_attribution_line_2 != '') {
                    echo '<div class="attributions">';
                        if($testimonial_attribution_line_1 != '') {
                            echo '<div>'.$testimonial_attribution_line_1.'</div>';
                        }
                        if($testimonial_attribution_line_2 != '') {
                            echo '<div class="att_line_2">'.$testimonial_attribution_line_2.'</div>';
                        }
                    echo '</div>';
                }
            echo '</div>';
        }
        echo '</div>';
        echo '<div class="slider-nav">';
        foreach($testimonials as $testimonial) {
            echo '<div class="dot"></div>';
        }
        echo '</div>';
    echo '</div>';
}