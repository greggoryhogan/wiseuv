
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