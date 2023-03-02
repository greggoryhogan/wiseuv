
/*
 *
 * Color picker colors for acf swatches
 * 
 */
console.log('hger!');
acf.add_filter('color_picker_args', function( args, $field ){
	//add our colros to acf pallette
    args.palettes = ['#c85f42', '#004f5a', '#102a21'];
	return args;
});