<?php
	/**
	 * Tidypics Thumbnail Creation Test
	 *
	 *  Called through ajax
	 */
	 
	include_once dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php";
	include dirname(dirname(__FILE__)) . "/lib/resize.php";
	
	global $CONFIG;
	
	$guid = $_GET['guid'];

	$image = get_entity($guid);
	if (!$image || !($image instanceof TidypicsImage)) {
		echo "Unable to get original image";
		return;	
	}
	
	$filename = $image->getFilename();
	$container_guid = $image->container_guid;
	if (!$filename || !$container_guid) {
		echo "Error retrieving information about the image";
		return;
	}
	
	$title = $image->title;
	$prefix = "image/" . $container_guid . "/";
	$filestorename = substr($filename, strlen($prefix));
	
	$image_lib = get_plugin_setting('image_lib', 'tidypics');
	if (!$image_lib)
		$image_lib = "GD";
	
	if ($image_lib == 'ImageMagick') { // ImageMagick command line
		
		if (tp_create_im_cmdline_thumbnails($image, $prefix, $filestorename) != true) {
			trigger_error('Tidypics warning: failed to create thumbnails - ImageMagick command line', E_USER_WARNING);
			echo "Failed to create thumbnails";
		}
		
	} else if ($image_lib == 'ImageMagickPHP') {  // imagick PHP extension 
		
		if (tp_create_imagick_thumbnails($image, $prefix, $filestorename) != true) {
			trigger_error('Tidypics warning: failed to create thumbnails - ImageMagick PHP', E_USER_WARNING);
			echo "Failed to create thumbnails";
		}
	
	} else { 
		
		if (tp_create_gd_thumbnails($image, $prefix, $filestorename) != true) {
			trigger_error('Tidypics warning: failed to create thumbnails - GD', E_USER_WARNING);
			echo "Failed to create thumbnails";
		}
		
	} // end of image library selector
	
	echo "<img id=\"tidypics_image\"  src=\"{$CONFIG->wwwroot}mod/tidypics/thumbnail.php?file_guid={$guid}&amp;size=large\" alt=\"{$title}\" />";
				
?>
