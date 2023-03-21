
/*
 *
 * Color picker colors for acf swatches
 * 
 */
acf.add_filter('color_picker_args', function( args, $field ){
	//add our colros to acf pallette
    args.palettes = ['#ffffff', '#00B0D8', '#14181B', '#822D84', '#812d83', '#92278f', '#01693D', '#398a68'];
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