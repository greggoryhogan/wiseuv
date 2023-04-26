<?php 
$post_id = get_the_ID();
$permalink = get_permalink();
$title = get_the_title();
echo '<a href="'.$permalink.'" title="Read '.$title.'">';
    echo '<h2>'.$title.'</h2>';
echo '</a>';
babel_post_details($post_id);
echo '<div class="excerpt">'.get_the_excerpt().'</div>';
echo '<div class="read-more">';
    $button_text = 'Read More';
    echo '<a href="'.$permalink.'" title="Read '.$title.'" class="btn">'.$button_text.'</a>';
echo '</div>';