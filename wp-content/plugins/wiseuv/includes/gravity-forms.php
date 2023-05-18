<?php 
/**
 * Load our custom field types
 */
require_once( WISE_PLUGIN_DIR . 'includes/gravity-forms-field-types/field_references.php' );
require_once( WISE_PLUGIN_DIR . 'includes/gravity-forms-field-types/field_message.php' );

/**
 * Add anchor to all forms
 */
add_filter( 'gform_confirmation_anchor', '__return_true' );