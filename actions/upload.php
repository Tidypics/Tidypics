<?php
	/**
	 * Elgg multi-image uploader action
	* 
	* This will upload up to 10 images at at time to an album
	 */

	global $CONFIG;
	include dirname(__FILE__) . "/resize.php";
	include dirname(dirname(__FILE__)) . "/lib/resize.php";

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
		register_error('Too many large images - try to upload fewer or smaller images');
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
		register_error('No images were selected. Please try again');
		forward(get_input('forward_url', $_SERVER['HTTP_REFERER']));
	}

	$not_uploaded = array();
	$uploaded_images = array();
	foreach($_FILES as $key => $sent_file) {
		
		// skip empty entries 
		if (empty($sent_file['name']))
			continue;
		
		$name = $sent_file['name'];
		$mime = $sent_file['type'];
		
		if ($sent_file['error']) {
			array_push($not_uploaded, $sent_file['name']);
			if ($sent_file['error'] == 1)
				trigger_error('Tidypics warning: image exceed server php upload limit', E_USER_WARNING);
			continue;
		}
		
		//make sure file is an image
		if ($mime != 'image/jpeg' && $mime != 'image/gif' && $mime != 'image/png' && $mime != 'image/pjpeg') {
			array_push($not_uploaded, $sent_file['name']);
			continue;
		}

		// make sure file does not exceed memory limit
		if ($sent_file['size'] > $maxfilesize) {
			array_push($not_uploaded, $sent_file['name']);
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
				trigger_error('Tidypics warning: image memory size too large for resizing so rejecting', E_USER_WARNING);
				continue;
			}
		} else if ($image_lib === 'ImageMagick') {  // this will be for PHP ImageMagick
/*
			$mem_required = 5 * $imginfo[0] * $imginfo[1];
			$mem_avail = $mem_avail - memory_get_peak_usage() - 4194304; // 4 MB buffer
			if ($mem_required > $mem_avail) {
				array_push($not_uploaded, $sent_file['name']);
				trigger_error('Tidypics warning: image memory size too large for resizing so rejecting', E_USER_WARNING);
				continue;
			}
*/
		}

		//this will save to users folder in /image/ and organize by photo album
		$prefix = "image/" . $container_guid . "/";
		$file = new ElggFile();
		$filestorename = strtolower(time().$name);
		$file->setFilename($prefix.$filestorename);
		$file->setMimeType($mime);
		$file->originalfilename = $name;
		$file->subtype="image";
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
			continue;
		}
		
		// successfully saved image
		array_push($uploaded_images, $file->guid);


		if ($image_lib === 'GD') {

			if (tp_create_gd_thumbnails($file, $prefix, $filestorename) != true) {
				trigger_error('Tidypics warning: failed to create thumbnails', E_USER_WARNING);
			}
			
		} else if ($image_lib === 'ToDo:ImageMagick') {  // ImageMagick PHP 
/*
			if (tp_create_imagick_thumbnails($file, $prefix, $filestorename) != true) {
				trigger_error('Tidypics warning: failed to create thumbnails', E_USER_WARNING);
			}
*/
		} else { // ImageMagick command line

/*
			if (tp_create_imagick_cmdline_thumbnails($file, $prefix, $filestorename) != true) {
				trigger_error('Tidypics warning: failed to create thumbnails', E_USER_WARNING);
			}
*/

			//gfroese: build the actual thumbnails now
			$album = get_entity($container_guid);
			$user = get_user_entity_as_row($album->owner_guid);
			$username = $user->username;
			
			try {
				$thumblarge = tp_resize($file->getFilenameOnFilestore(), 
										"largethumb", 
										$CONFIG->tidypics->image_large_width, 
										$CONFIG->tidypics->image_large_height, 
										false); 
			} catch (Exception $e) { $thumblarge = false; }
			try {
				$thumbsmall = tp_resize($file->getFilenameOnFilestore(), 
										"smallthumb", 
										$CONFIG->tidypics->image_small_width, 
										$CONFIG->tidypics->image_small_height, 
										true); 
			} catch (Exception $e) { $thumbsmall = false; }
			try {
				$thumbnail = tp_resize($file->getFilenameOnFilestore(), 
										"thumb", 
										$CONFIG->tidypics->image_thumb_width, 
										$CONFIG->tidypics->image_thumb_height, 
										true);
			} catch (Exception $e) { $thumbnail = false; }
			
			if ($thumbnail) {
				$thumb = new ElggFile();
				$thumb->setMimeType($mime);
				$thumb->setFilename($prefix."thumb".$filestorename);
				$file->thumbnail = $prefix."thumb".$filestorename;
			}
			
			if ($thumbsmall) {
				$thumb = new ElggFile();
				$thumb->setMimeType($mime);
				$thumb->setFilename($prefix."smallthumb".$filestorename);
				$file->smallthumb = $prefix."smallthumb".$filestorename;
			}
			
			if ($thumblarge) {
				$thumb = new ElggFile();
				$thumb->setMimeType($mime);
				$thumb->setFilename($prefix."largethumb".$filestorename);
				$file->largethumb = $prefix."largethumb".$filestorename;
			}
			
			$im_path = get_plugin_setting('convert_command', 'tidypics');
			if(!$im_path) {
				$im_path = "/usr/bin/";
			}
			if(substr($im_path, strlen($im_path)-1, 1) != "/") $im_path .= "/";
			
			$viewer = get_loggedin_user();
			$watermark_text = get_plugin_setting('watermark_text', 'tidypics');
			$watermark_text = str_replace("%username%", $viewer->username, $watermark_text);
			if( $watermark_text ) { //get this value from the plugin settings
				if( $thumblarge ) {
					$ext = ".png";
					
					$watermark_filename = strtolower($watermark_text);
					$watermark_filename = preg_replace("/[^\w-]+/", "-", $watermark_filename);
					$watermark_filename = trim($watermark_filename, '-');
					
					$user_stamp_base = dirname(__FILE__) . "/" . $viewer->name . "_" . $watermark_filename . "_stamp";
					if( !file_exists( $user_stamp_base . $ext )) { //create the watermark if it doesn't exist
						$commands = array();
						$commands[] = $im_path . 'convert -size 300x50 xc:grey30 -pointsize 20 -gravity center -draw "fill grey70  text 0,0  \''. $watermark_text . '\'" '. $user_stamp_base . '_fgnd' . $ext;
						$commands[] = $im_path . 'convert -size 300x50 xc:black -pointsize 20 -gravity center -draw "fill white  text  1,1  \''. $watermark_text . '\' text  0,0  \''. $watermark_text . '\' fill black  text -1,-1 \''. $watermark_text . '\'" +matte ' . $user_stamp_base . '_mask' . $ext;
						$commands[] = $im_path . 'composite -compose CopyOpacity  ' . $user_stamp_base . "_mask" . $ext . ' ' . $user_stamp_base . '_fgnd' . $ext . ' ' . $user_stamp_base . $ext;
						$commands[] = $im_path . 'mogrify -trim +repage ' . $user_stamp_base . $ext;
						$commands[] = 'rm ' . $user_stamp_base . '_mask' . $ext;
						$commands[] = 'rm ' . $user_stamp_fgnd . '_mask' . $ext;
						
						foreach( $commands as $command ) {
							exec( $command );
						}
					}
					//apply the watermark
					$commands = array();
					$commands[] = $im_path . 'composite -gravity south -geometry +0+10 ' . $user_stamp_base . $ext . ' ' . $thumblarge . ' ' . $thumblarge . '_watermarked';
					$commands[] = "mv $thumblarge" . "_watermarked $thumblarge";
					foreach( $commands as $command ) {
						exec( $command );
					}
				}
			}
		} // end of image library selector
					
		unset($file);  // may not be needed but there seems to be a memory leak

	} //end of for loop
	

	if (count($not_uploaded) == 0) {
		system_message(elgg_echo("images:saved"));
	} else {
		$error = elgg_echo("image:uploadfailed") . '<br />';
		foreach($not_uploaded as $im_name){
			$error .= ' [' . $im_name . ']  ';
		}
		$error .= '  ' . elgg_echo("image:notimage");
		register_error($error);
	} //end of upload check
	
	if (count($uploaded_images)>0) {
		// successful upload so check if this is a new album and throw river event if so
		$album = get_entity($container_guid);
		if ($album->new_album == 1) {
			if (function_exists('add_to_river'))
				add_to_river('river/object/album/create', 'create', $album->owner_guid, $album->guid);
			$album->new_album = 0;
		}
	
		forward($CONFIG->wwwroot . 'mod/tidypics/edit_multi.php?files=' . implode('-', $uploaded_images)); //forward to multi-image edit page
	} else {
		forward(get_input('forward_url', $_SERVER['HTTP_REFERER'])); //upload failed, so forward to previous page
	}

?>
