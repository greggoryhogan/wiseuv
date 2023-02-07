<?php 
$image = get_sub_field('image');
$image_size = get_sub_field('image_size');
$force_images_full_width = get_sub_field('force_images_full_width');
$image_alignment = get_sub_field('image_alignment'); 
$image_style = get_sub_field('image_style');
$image_drop_shadow = get_sub_field('image_drop_shadow');
?>
<div class="flexible-content image-module <?php echo $force_images_full_width; ?> align-<?php echo $image_alignment; ?>">
    <?php echo '<div class="image '.$force_images_full_width.' '.$image_style .' box-shadow-'.$image_drop_shadow.'">';
        echo wp_get_attachment_image( $image, $image_size );
    echo '</div>'; ?>
</div>
