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

add_filter( 'gettext', 'change_wise_excerpt_description' );
function change_wise_excerpt_description( $translation, $original ) {
    $pos = strpos($original, 'Excerpts are optional hand-crafted summaries of your');
    if ($pos !== false) {
        return  'Exerpts are optional summaries of your content. For the WISE theme, they are used primarily as page summaries in search results.';
    }
    return $translation;
}