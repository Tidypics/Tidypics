<?php
	/**
	 * Tidypics Download Photos
	 * 
	 * do not call this directly - call through page handler
	 */
	 
	global $CONFIG;

	$file_guid = (int) get_input("file_guid");
	$file = get_entity($file_guid);
	
	$type = get_input("type");
	
	if ($file) {
		$filename = $file->originalfilename;
		$mime = $file->mimetype;
		
		header("Content-Type: $mime");
		if ($type == "inline")
			header("Content-Disposition: inline; filename=\"$filename\"");
		else
			header("Content-Disposition: attachment; filename=\"$filename\"");

		
		$readfile = new ElggFile($file_guid);
		$readfile->owner_guid = $file->owner_guid;
		
		$contents = $readfile->grabFile();
		
		if (empty($contents)) {
			echo file_get_contents(dirname(dirname(__FILE__)) . "/graphics/image_error_large.png" );
		} else {
			
			// expires every 60 days
			$expires = 60 * 60*60*24;
			
			header("Content-Length: " . strlen($contents));
			header("Cache-Control: public", true);
			header("Pragma: public", true);
			header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT', true);
			
			
			echo $contents;
		}
		
		exit;
	}
	else
		register_error(elgg_echo("image:downloadfailed"));

?>