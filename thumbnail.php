<?php

	/**
	 * Tidypics Thumbnail
	 * 
	 */

	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	
	// Get file GUID
	$file_guid = (int) get_input('file_guid');
	
	// Get file thumbnail size
	$size = get_input('size');
	// only 3 possibilities
	if ($size != 'small' && $size != 'thumb') {
		$size = 'large';
	}
	error_log('size is ' . $size);
	
	// Get file entity
	$file = get_entity($file_guid);
	if (!$file)
		forward('mod/tidypics/graphics/img_error.jpg');
	
	if ($file->getSubtype() != "image")
		forward('mod/tidypics/graphics/img_error.jpg');
	
	// Get filename
	if ($size == "thumb") {
		$thumbfile = $file->thumbnail;
	} else if ($size == "small") {
		$thumbfile = $file->smallthumb;
	} else {
		$thumbfile = $file->largethumb;
	}
	error_log('filename is ' . $thumbfile);
	
	if (!$thumbfile)
		forward('mod/tidypics/graphics/img_error.jpg');
	
	// create Elgg File object
	$readfile = new ElggFile();
	$readfile->owner_guid = $file->owner_guid;
	$readfile->setFilename($thumbfile);
	$contents = $readfile->grabFile();

	// send error image if file could not be read
	if (!$contents) {
		forward('mod/tidypics/graphics/img_error.jpg');
	}

	// Return the thumbnail and exit
	header("Content-type: image");
	echo $contents;
	exit;
?>
