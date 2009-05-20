<?php
	/**
	 * Elgg tidypics library of common functions
	 * 
	 */

	/**
	 * Get image directory path
	 *
	 * Each album gets a subdirectory based on its container id
	 *
	 * @return string	path to image directory
	 */
	function tp_get_img_dir()
	{
		$file = new ElggFile();
		return $file->getFilenameOnFilestore() . 'image/';
	}
	
?>