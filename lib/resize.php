<?php
	/**
	 * Elgg tidypics library of resizing functions
	 * 
	 */

	/**
	 * Create thumbnails using PHP GD Library
	 *
	 * @param ElggFile
	 * @param string
	 * @param string
	 * @return bool 
	 */
	function tp_create_gd_thumbnails($file, $prefix, $filestorename)
	{
		global $CONFIG;
		
		$mime = $file->getMimeType();
		
		// Generate thumbnails
		$thumbnail = get_resized_image_from_existing_file(	$file->getFilenameOnFilestore(),
															$CONFIG->tidypics->image_thumb_width,
															$CONFIG->tidypics->image_thumb_height, 
															true); 

		if ($thumbnail) {
			$thumb = new ElggFile();
			$thumb->setMimeType($mime);
			$thumb->setFilename($prefix."thumb".$filestorename);
			$thumb->open("write");
			if ($thumb->write($thumbnail)) {
				$file->thumbnail = $prefix."thumb".$filestorename;
			} else {
				$thumb->delete();
			}
			$thumb->close();
			unset($thumb);
		}
		unset($thumbnail);
		
		$thumbsmall = get_resized_image_from_existing_file(	$file->getFilenameOnFilestore(),
															$CONFIG->tidypics->image_small_width,
															$CONFIG->tidypics->image_small_height, 
															true); 

		
		if ($thumbsmall) {
			$thumb = new ElggFile();
			$thumb->setMimeType($mime);
			$thumb->setFilename($prefix."smallthumb".$filestorename);
			$thumb->open("write");
			if ($thumb->write($thumbsmall)) {
				$file->smallthumb = $prefix."smallthumb".$filestorename;
			} else {
				$thumb->delete();
			}
			$thumb->close();
			unset($thumb);
		}
		unset($thumbsmall);

		$thumblarge = get_resized_image_from_existing_file(	$file->getFilenameOnFilestore(),
															$CONFIG->tidypics->image_large_width,
															$CONFIG->tidypics->image_large_height, 
															false); 
		
		if ($thumblarge) {
			$thumb = new ElggFile();
			$thumb->setMimeType($mime);
			$thumb->setFilename($prefix."largethumb".$filestorename);
			$thumb->open("write");
			if ($thumb->write($thumblarge)) {
				$file->largethumb = $prefix."largethumb".$filestorename;
			} else {
				$thumb->delete();
			}
			$thumb->close();
			unset($thumb);
		}
		unset($thumblarge);

		return true;
	}

?>