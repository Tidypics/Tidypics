<?php
	/**
	 * Elgg multi-image uploader action
	* 
	* This will upload up to 10 images at at time to an album
	 */

	global $CONFIG;
	include dirname(dirname(__FILE__)) . "/lib/resize.php";
	include dirname(dirname(__FILE__)) . "/lib/watermark.php";
	include dirname(dirname(__FILE__)) . "/lib/exif.php";

	// Get common variables
	$access_id = (int) get_input("access_id");
	$container_guid = (int) get_input('container_guid', 0);
	if (!$container_guid)
		$container_guid == $_SESSION['user']->getGUID();

	$maxfilesize = get_plugin_setting('maxfilesize','tidypics'); 
	if (!$maxfilesize)
		$maxfilesize = 5; // default to 5 MB if not set 
	$maxfilesize = 1024 * 1024 * $maxfilesize; // convert to bytes from MBs

	$image_lib = get_plugin_setting('image_lib', 'tidypics');
	if (!$image_lib)
		$image_lib = 'GD';

	// post limit exceeded
	if (count($_FILES) == 0) {
		trigger_error('Tidypics warning: user exceeded post limit on image upload', E_USER_WARNING);
		register_error(elgg_echo('tidypics:exceedpostlimit'));
		forward(get_input('forward_url', $_SERVER['HTTP_REFERER']));
	}

	// test to make sure at least 1 image was selected by user
	$num_images = 0;
	foreach($_FILES as $key => $sent_file) {
		if (!empty($sent_file['name']))
			$num_images++;
	}
	if ($num_images == 0) {
		// have user try again
		register_error(elgg_echo('tidypics:noimages'));
		forward(get_input('forward_url', $_SERVER['HTTP_REFERER']));
	}

	$uploaded_images = array();
	$not_uploaded = array();
	$error_msgs = array();
	
	$river_view = get_plugin_setting('river_view', 'tidypics');
	
	$accepted_formats = array(
								'image/jpeg',
								'image/png',
								'image/gif',
								'image/pjpeg',
								'image/x-png',
								);


	foreach($_FILES as $key => $sent_file) {
		
		// skip empty entries 
		if (empty($sent_file['name']))
			continue;
		
		$name = $sent_file['name'];
		$mime = $sent_file['type'];

		if ($sent_file['error']) {
			array_push($not_uploaded, $sent_file['name']);
			if ($sent_file['error'] == 1) {
				trigger_error('Tidypics warning: image exceed server php upload limit', E_USER_WARNING);
				array_push($error_msgs, elgg_echo('tidypics:image_mem'));
			}
			else {
				array_push($error_msgs, elgg_echo('tidypics:unk_error'));
			}
			continue;
		}
		
		//make sure file is an image
		if (!in_array($mime, $accepted_formats)) {
			array_push($not_uploaded, $sent_file['name']);
			array_push($error_msgs, elgg_echo('tidypics:not_image'));
			continue;
		}

		// make sure file does not exceed memory limit
		if ($sent_file['size'] > $maxfilesize) {
			array_push($not_uploaded, $sent_file['name']);
			array_push($error_msgs, elgg_echo('tidypics:image_mem'));
			continue;
		}
		
		// make sure the in memory image size does not exceed memory available - GD only
		$imginfo = getimagesize($sent_file['tmp_name']);
		$mem_avail = ini_get('memory_limit');
		$mem_avail = rtrim($mem_avail, 'M');
		$mem_avail = $mem_avail * 1024 * 1024;
		if ($image_lib === 'GD') {
			$mem_required = 5 * $imginfo[0] * $imginfo[1];
			$mem_avail = $mem_avail - memory_get_peak_usage() - 4194304; // 4 MB buffer
			if ($mem_required > $mem_avail) {
				array_push($not_uploaded, $sent_file['name']);
				array_push($error_msgs, elgg_echo('tidypics:image_pixels'));
				trigger_error('Tidypics warning: image memory size too large for resizing so rejecting', E_USER_WARNING);
				continue;
			}
		} else if ($image_lib === 'ImageMagickPHP') {  
			$mem_required = 5 * $imginfo[0] * $imginfo[1];
			$mem_avail = $mem_avail - memory_get_peak_usage() - 4194304; // 4 MB buffer
			if ($mem_required > $mem_avail) {
				array_push($not_uploaded, $sent_file['name']);
				array_push($error_msgs, elgg_echo('tidypics:image_pixels'));
				trigger_error('Tidypics warning: image memory size too large for resizing so rejecting', E_USER_WARNING);
				continue;
			}
		}

		//this will save to users folder in /image/ and organize by photo album
		$prefix = "image/" . $container_guid . "/";
		$file = new ElggFile();
		$filestorename = strtolower(time().$name);
		$file->setFilename($prefix.$filestorename);
		$file->setMimeType($mime);
		$file->originalfilename = $name;
		$file->subtype="image";
		$file->simpletype="image";
		$file->access_id = $access_id;
		if ($container_guid) {
			$file->container_guid = $container_guid;
		}
		$file->open("write");
		$file->write(get_uploaded_file($key));
		$file->close();
		$result = $file->save();

		if (!$result) {
			array_push($not_uploaded, $sent_file['name']);
			array_push($error_msgs, elgg_echo('tidypics:save_error'));
			continue;
		}
		

		if ($image_lib === 'GD') {

			if (tp_create_gd_thumbnails($file, $prefix, $filestorename) != true) {
				trigger_error('Tidypics warning: failed to create thumbnails', E_USER_WARNING);
			}
			
		} else if ($image_lib === 'ImageMagickPHP') {  // ImageMagick PHP 

			if (tp_create_imagick_thumbnails($file, $prefix, $filestorename) != true) {
				trigger_error('Tidypics warning: failed to create thumbnails', E_USER_WARNING);
			}

		} else { // ImageMagick command line

			$thumbs = tp_create_imagick_cmdline_thumbnails($file, $prefix, $filestorename);
			if(!count($thumbs)) {
				trigger_error('Tidypics warning: failed to create thumbnails', E_USER_WARNING);
			}

			$album = get_entity($container_guid);
			
			tp_watermark($thumbs);
			
		} // end of image library selector

		//keep one file handy so we can add a notice to the river if single image option selected
		if(!$file_for_river) {
			$file_for_river = $file;
		}

		//get and store the exif data
		td_get_exif($file);
		array_push($uploaded_images, $file->guid);

		if($river_view == "all") {
			add_to_river('river/object/image/create', 'create', $file->getObjectOwnerGUID(), $file->getGUID());
		}
		unset($file);  // may not be needed but there seems to be a memory leak

	} //end of for loop
				
	if (count($not_uploaded) > 0) {
		if (count($uploaded_images) > 0)
			$error = sprintf(elgg_echo("tidypics:partialuploadfailure"), count($not_uploaded), count($not_uploaded) + count($uploaded_images))  . '<br />';
		else
			$error = elgg_echo("tidypics:completeuploadfailure") . '<br />';

		$num_failures = count($not_uploaded);
		for ($i = 0; $i < $num_failures; $i++) {
			$error .= "{$not_uploaded[$i]}: {$error_msgs[$i]} <br />";
		}
		register_error($error);
		
		if (count($uploaded_images) == 0)
			forward(get_input('forward_url', $_SERVER['HTTP_REFERER'])); //upload failed, so forward to previous page
		else {
			// some images did upload so we fall through
		}
	} else {
			system_message(elgg_echo('tidypics:upl_success'));
	}

	// successful upload so check if this is a new album and throw river event if so
	$album = get_entity($container_guid);
	if ($album->new_album == TP_NEW_ALBUM) {
		if (function_exists('add_to_river'))
			add_to_river('river/object/album/create', 'create', $album->owner_guid, $album->guid);
		$album->new_album = TP_OLD_ALBUM;
	}
	
	if(count($uploaded_images) && $river_view == "1") {
		if (function_exists('add_to_river')) {
			add_to_river('river/object/image/create', 'create', $file_for_river->getObjectOwnerGUID(), $file_for_river->getGUID());
		}
	}
			
	// plugins can register to be told when a Tidypics album has had images added
	trigger_elgg_event('upload', 'tp_album', $album);
	
	
	//forward to multi-image edit page
	forward($CONFIG->wwwroot . 'mod/tidypics/edit_multi.php?files=' . implode('-', $uploaded_images)); 

?>
