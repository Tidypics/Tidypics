<?php
	/**
	 * Elgg multi-image uploader action
	* 
	* This will upload up to 10 images at at time to an album
	 */

	global $CONFIG;
		
	// Get common variables
	$access_id = (int) get_input("access_id");
	$container_guid = (int) get_input('container_guid', 0);
	if (!$container_guid)
		$container_guid == $_SESSION['user']->getGUID();
			
	$not_uploaded = array();
	$uploaded_images = array();	

	foreach($_FILES as $key => $sent_file) {
		if (!empty($sent_file['name'])) {
			$name = $_FILES[$key]['name'];
			$mime = $_FILES[$key]['type'];
			
			//make sure file is an image
			if ($mime == 'image/jpeg' || $mime == 'image/gif' || $mime == 'image/png' || $mime == 'image/pjpeg') {
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

				if ($result) { //file was saved; now create some thumbnails
					//get maximum file size from plugin settings
					if (get_plugin_setting('maxfilesize','tidypics')) {
						if (((int) get_plugin_setting('maxfilesize','tidypics')) < 1 || ((int) get_plugin_setting('maxfilesize','tidypics')) > 1048576) {
							$maxfilesize = 10240; //if file size is less than 1KB or greater than 1GB, default to 10MB
						} else {
							$maxfilesize = (int) get_plugin_setting('maxfilesize','tidypics');
						}
					} else {
						$maxfilesize = 10240; //if the file size limit is not set, default to 10MB
					}
					$maxfilesize = 1024 * $maxfilesize; //convert to bytes
						
					//check file size and remove picture if it exceeds the maximum
					if (filesize($file->getFilenameOnFilestore())<= $maxfilesize) {
						array_push($uploaded_images, $file->guid);
		
						// Generate thumbnail
						//TODO: REMOVE THE BELOW IF STATEMENT ONCE get_resized_image_from_existing_file() ACCEPTS IMAGES OVER 0.9MB IN SIZE
						if (filesize($file->getFilenameOnFilestore())<= 943718) { //create thumbnails if file size < 0.9MB
							try {
								$thumblarge = get_resized_image_from_existing_file($file->getFilenameOnFilestore(),600,600, false); 
							} catch (Exception $e) { $thumblarge = false; }
							
							try {
								$thumbsmall = get_resized_image_from_existing_file($file->getFilenameOnFilestore(),153,153, true); 
							} catch (Exception $e) { $thumbsmall = false; }
							
							try {
								$thumbnail = get_resized_image_from_existing_file($file->getFilenameOnFilestore(),60,60, true); 
							} catch (Exception $e) { $thumbnail = false; }
						}
						
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
						}
						
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
						}
						
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
						}
					} else { //file exceeds file size limit, so delete it
						$file->delete();
						array_push($not_uploaded, $name);
					} //end of file size check
				} else { //file was not saved for some unknown reason
					array_push($not_uploaded, $name);
				} //end of file saved check and thumbnail creation
			} else { // file is not a supported image type 
				array_push($not_uploaded, $name);
			} //end of mimetype block
		} //end of file name empty check
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