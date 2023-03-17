
/*
 *
 * Color picker colors for acf swatches
 * 
 */
acf.add_filter('color_picker_args', function( args, $field ){
	//add our colros to acf pallette
    args.palettes = ['#333333', '#14181B', '#f16f22', '#72AA9D', '#FDCD06', '#f7f7f7', '#EAEAEA', '#fff'];
	return args;
});

/**
 * Change default font size selector in wysiwyg
 */
acf.add_action('wysiwyg_tinymce_init', function( ed, id, mceInit, $field ){
    // ed (object) tinymce object returned by the init function
    // id (string) identifier for the tinymce instance
    // mceInit (object) args given to the tinymce function
    // $field (jQuery) field element 
    ed.on('init', function() 
    {
		console.log('init');
        this.getBody().style.fontSize = '1rem'; 
    });
});