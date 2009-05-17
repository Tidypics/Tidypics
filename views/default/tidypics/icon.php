<?php
	/**
	 * Elgg tidypic icon
	 * Optionally you can specify a size.
	 * 
	 */

	global $CONFIG;
		
if($vars['album']){
	echo "<img src=\"{$CONFIG->wwwroot}mod/tidypics/graphics/icons/album.gif\" border=\"0\" />";
}
else{
	
	$mime = $vars['mimetype'];
	if (isset($vars['thumbnail'])) {
		$thumbnail = $vars['thumbnail'];
	} else {
		$thumbnail = false;
	}
	
	$size = $vars['size'];
	if ($size != 'large') {
		$size = 'small';
	}

	if ($thumbnail && strpos($mime, "image/")!==false)
		echo "<img src=\"{$vars['url']}action/tidypics/icon?file_guid={$vars['file_guid']}\" border=\"0\" />";
	else 
	{
		if ($size == 'large')
			echo "<img src=\"{$CONFIG->wwwroot}mod/tidypics/graphics/icons/general_lrg.gif\" border=\"0\" />";
		else
			echo "<img src=\"{$CONFIG->wwwroot}mod/tidypics/graphics/icons/general.gif\" border=\"0\" />";
	}
}
?>