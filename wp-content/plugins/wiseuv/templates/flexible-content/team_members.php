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
$team_members_style = get_sub_field('team_members_style'); //traditional, highlighted
?>
<div class="flexible-content team-members style-<?php echo $team_members_style; ?>"><?php
    if( have_rows('team_members')) {
        while(have_rows('team_members')) {
            the_row();
            $image = get_sub_field('image'); 
            $heading = get_sub_field( 'heading' );
            $position = get_sub_field( 'position' );
            $team_member_content = get_sub_field('content');
            echo '<div class="team-member">';
                echo '<div class="image">';
                    if($image) {
                        echo wp_get_attachment_image( $image, 'full' );
                    }
                echo '</div>';
                echo '<div class="member-details">';
                    if($heading != '') {
                        echo '<h3>'.wise_content_filters($heading).'</h3>';
                    }
                    if($position != '') {
                        echo '<div class="position">'.wise_content_filters($position).'</div>';
                    }
                    if($team_member_content != '') {
                        echo '<div class="description';
                        if($heading == '' && $position == '') {
                            echo ' no-heading';
                        }
                        echo '">';
                            echo wise_content_filters($team_member_content);
                        echo '</div>';
                    }
                echo '</div>';
            echo '</div>';  
        }
    }
    ?>
</div>
