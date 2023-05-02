<?php if(get_search_query() == '') {							
	$s = '';
} else {
	$s = $_GET['s'];
}
?>
<form id="searchform" method="get" action="<?php echo bloginfo('url'); ?>">
	<input type="text" id="s" name="s" value="<?php echo $s; ?>" placeholder="What are you looking for?" />
	<input type="submit" value="Search" />
</form>