<?php 
$embed_url = get_sub_field('embed_url');
if(strpos($embed_url,'&amp') !== false) {
    $embed_url = str_replace('&amp;','&',$embed_url);
}
$aspect_ratio= get_sub_field('aspect_ratio');
echo '<div class="flexible-content video">';
    echo '<div class="responsive-video" style="padding-bottom: '.$aspect_ratio.'%;">';
        echo '<iframe src="'.$embed_url.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope allowfullscreen"></iframe>';
    echo '</div>';    
echo '</div>';