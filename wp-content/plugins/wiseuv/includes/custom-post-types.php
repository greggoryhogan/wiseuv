<?php
/*
 *
 * Create custom post types for theme
 *
 */    
function create_wise_custom_post_types() {
    //add tags to post
    //register_taxonomy_for_object_type( 'post_tag', 'post' );

    //church cpt for user relationship
    /*register_post_type( 'church',
        array(
            'labels' => array(
                'name' => __( 'Churches' ),
                'singular_name' => __( 'Church' )
            ),
            'public' => true,
            'hierarchical'        => false,
            'show_in_menu'        => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'church'),
            'show_in_rest' => true,
            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'custom-fields' ),
        )
    );*/
    
    /*$labels = array(
		'name' => __( 'Categories', 'wise' ),
		'singular_name' => __( 'Category', 'wise' ),
        'add_new_item' => __( 'Add New Category', 'wise' ),
        'parent_item' => __( 'Parent Category', 'wise' ),
        'not_found' => __( 'No Categories found', 'wise' ),
	);

	$args = array(
		'label' => __( 'Categories', 'wise' ),
		'labels' => $labels,
		'public' => true,
		'label' => 'Categories',
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'page-category', 'with_front' => false, ),
		'show_admin_column' => 0,
		'show_in_rest' => false,
		'rest_base' => '',
		'show_in_quick_edit' => true,
        'hierarchical'    => true,
	);
	register_taxonomy( 'page-category', array( 'page' ), $args );*/

    /**
	 * Taxonomy: Page Tags
	 */
	register_taxonomy('page_tags', 'page', array(
        'hierarchical' => false,
        'public' => true, //hide from back end
        'labels' => array(
            'name' => _x( 'Page Tags', 'taxonomy general name' ),
            'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Tags' ),
            'all_items' => __( 'All Tags' ),
            'edit_item' => __( 'Edit Tag' ),
            'update_item' => __( 'Update Tag' ),
            'add_new_item' => __( 'Add New Tag' ),
            'new_item_name' => __( 'New Tag' ),
            'menu_name' => __( 'Page Tags' ),
        ),
        'rewrite' => array(
            'slug' => 'page_tags', // This controls the base slug that will display before each term
            'with_front' => false, // Don't display the category base before "/locations/"
            'hierarchical' => false // This will allow URL's like "/locations/boston/cambridge/"
        ),
    ));

    add_post_type_support( 'page', 'excerpt' );

}
add_action( 'init', 'create_wise_custom_post_types', 10 );

/*
 *
 *  Add meta boxes for Church CPT
 *
 */
function wise_add_meta_boxes() {
    //churches
    add_meta_box(
        'wise_church_meta',
        'Church Location',
        'wise_church_meta_callback',
        'church',
        'side',
        'low',
            //not even sure that this array is necessary
            array(
            '__block_editor_compatible_meta_box' => true,
            '__back_compat_meta_box'             => false,
        )
    );
    
}
//add_action( 'add_meta_boxes', 'wise_add_meta_boxes' );

/*
 *
 * Church Metaboxes Display Function
 * 
 */
function wise_church_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'church_cpt_meta_nonce' );
    $church_city = get_post_meta( $post->ID, 'church_city', true );
    $church_state = get_post_meta( $post->ID, 'church_state', true );
    echo '<p>';
        echo '<label for="church_city" class="css-pezhm9-StyledLabel">City</label>';
        echo '<input type="text" name="church_city" value="'.$church_city.'" class="components-text-control__input" />';
    echo '</p>';
    echo '<p>';
        echo '<label for="church_state" class="css-pezhm9-StyledLabel">State</label>';
        echo '<select name="church_state" class="components-custom-select-control__item">';
        echo wise_get_us_states_options($church_state);
        echo '</select>'; 
    echo '</p>';
}

/*
 *
 * Saving Church Meta
 * 
 */
function wise_save_meta_box_post_meta( $post_id ) {
    //churches
    if( isset( $_POST['church_cpt_meta_nonce'] ) ) {
        update_post_meta( $post_id, 'church_city', sanitize_text_field($_POST['church_city']) );
        update_post_meta( $post_id, 'church_state', sanitize_text_field($_POST['church_state']) );
    }
    //testimonials
    if( isset( $_POST['testimonial_cpt_meta_nonce'] ) ) {
        update_post_meta( $post_id, 'testimonial_content', sanitize_text_field($_POST['testimonial_content']) );
        update_post_meta( $post_id, 'testimonial_attribution_line_1', sanitize_text_field($_POST['testimonial_attribution_line_1']) );
        update_post_meta( $post_id, 'testimonial_attribution_line_2', sanitize_text_field($_POST['testimonial_attribution_line_2']) );
    }
}
//add_action( 'save_post', 'wise_save_meta_box_post_meta' );

/*
 *
 * Add church meta to all churches page
 * 
 */
//add_filter('manage_edit-church_columns', 'extra_church_columns');
function extra_church_columns($columns) {
    $new_columns = array(
        'title' => 'Title',
        'church_city' => 'City',
        'church_state' => 'State',
        'date' => 'Published',
    );
    $columns['church_city'] =__('City','henry');
	$columns['church_state'] =__('State','henry');
    $columns['date'] =__('Date','henry');

    return $new_columns;
}

/*
 *
 * Fill out data for custom columns
 * 
 */
//add_action( 'manage_church_posts_custom_column', 'church_column_content', 10, 2 );
function church_column_content( $column_name, $post_id ) {
    if ( 'church_city' != $column_name && 'church_state' != $column_name )
        return;
	//Get number of slices from post meta
	if($column_name == 'church_city') {
		echo get_post_meta( $post_id, 'church_city', true);
	}
	if($column_name == 'church_state') {
		echo get_post_meta( $post_id, 'church_state', true);
	}
    
  
}

/*
 *
 * Allow custom columns to be sortable
 * 
 */
//add_filter( 'manage_edit-church_sortable_columns', 'sortable_church_column' );
function sortable_church_column( $columns ) {
	$columns['church_city'] = 'church_city';
    $columns['church_state'] = 'church_state';
    return $columns;
} 

/*
 *
 * Sort column logic
 * 
 */
function wpse_208315_sort_by_status( $query ) {
    if ( $query->is_main_query() && $query->get( 'ordewisey' ) === 'church_city' ) {
         $query->set( 'meta_key', 'church_city' );
         $query->set( 'ordewisey', 'meta_value' );
    }
    elseif ( $query->is_main_query() && $query->get( 'ordewisey' ) === 'church_state' ) {
        $query->set( 'meta_key', 'church_state' );
        $query->set( 'ordewisey', 'meta_value' );
    } else if ( $query->is_main_query() && $query->get( 'ordewisey' ) === 'post_id' ) {
        $query->set( 'meta_key', 'testimonial_post_id' );
        $query->set( 'ordewisey', 'meta_value' );
    }
}
//add_action( 'pre_get_posts', 'wpse_208315_sort_by_status' );