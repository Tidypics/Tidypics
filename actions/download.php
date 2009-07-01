<?php
	/**
	 * Tidypics Download File Action
	 * 
	 */
	 
	global $CONFIG;

	$file_guid = (int) get_input("file_guid");
	$file = get_entity($file_guid);
	
	$view = get_input("view");
	
	if ($file) {
		$filename = $file->originalfilename;
		$mime = $file->mimetype;
		
		header("Content-type: $mime");
		if ($view == "inline")
			header("Content-Disposition: inline; filename=\"$filename\"");
		else
			header("Content-Disposition: attachment; filename=\"$filename\"");

		
		$readfile = new ElggFile($file_guid);
		$readfile->owner_guid = $file->owner_guid;
		
		$contents = $readfile->grabFile();
		
		if (empty($contents))
			echo file_get_contents(dirname(dirname(__FILE__)) . "/graphics/image_error_large.png" );
		else
			echo $contents;
		
		exit;
	}
	else
		register_error(elgg_echo("image:downloadfailed"));

?>