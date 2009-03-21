<?php

	/**
	 * Tidypics Thumbnail
	 * 
	 */

	// Get engine
	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		
	// Get file GUID
	$file_guid = (int) get_input('file_guid',0);
		
	// Get file thumbnail size
	$size = get_input('size','small');
	if ($size != 'small') {
		$size = 'large';
	}
		
	// Get file entity
	if ($file = get_entity($file_guid)) {
		if ($file->getSubtype() == "image") {					
			// Get file thumbnail
			if ($size == "small") {
				$thumbfile = $file->smallthumb;
			} else {
				$thumbfile = $file->largethumb;
			}
						
			// Grab the file
			if ($thumbfile && !empty($thumbfile)) {
				$readfile = new ElggFile();
				$readfile->owner_guid = $file->owner_guid;
				$readfile->setFilename($thumbfile);
				//$mime = $file->getMimeType();
				$contents = $readfile->grabFile();
			}
		} //end subtype comparison
	} //end get_entity

	// Open error image if file was not found
	if (!isset($contents) || is_null($contents) || $file->getSubtype()!='image') {
		//$vars['url'].'mod/tidypics/graphics/img_error.jpg
		forward('mod/tidypics/graphics/img_error.jpg');
	} //end of default error image

	// Return the thumbnail and exit
	header("Content-type: image");
	echo $contents;
	exit;
?>