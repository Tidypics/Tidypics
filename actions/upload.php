<?php
	/**
	 * Elgg multi-image uploader action
	* 
	* This will upload up to 10 images at at time to an album
	 */

	global $CONFIG;
	require_once(dirname(__FILE__)."/resize.php");
		
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


						$image_lib = get_plugin_setting('image_lib', 'tidypics');

						if ($image_lib === 'GD') {
						
							// Generate thumbnail
							//TODO: This code needs a complete rewrite - hardcoded to ~2.5 MB
							if (filesize($file->getFilenameOnFilestore())<= 2500000) { 
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
						
						} else {

							//gfroese: build the actual thumbnails now
							$album = get_entity($container_guid);
							$user = get_user_entity_as_row($album->owner_guid);
							$username = $user->username;
							
							try {
								$thumblarge = tp_resize($file->getFilenameOnFilestore(), "largethumb", 600, 600, false); 
							} catch (Exception $e) { $thumblarge = false; }
							try {
								$thumbsmall = tp_resize($file->getFilenameOnFilestore(), "smallthumb", 153, 153, false); 
							} catch (Exception $e) { $thumbsmall = false; }
							try {
								$thumbnail = tp_resize($file->getFilenameOnFilestore(), "thumb", 60, 60, true);
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
							
							$watermark_text = get_plugin_setting('watermark_text', 'tidypics');
							if( $watermark_text ) { //get this value from the plugin settings
								if( $thumblarge ) {
									$ext = ".png";
									$user_stamp_base = dirname(__FILE__) . "/" . $username . "_stamp";
									if( !file_exists( $user_stamp_base . $ext )) { //create the watermark if it doesn't exist
										$commands = array();
										$commands[] = 'convert -size 300x50 xc:grey30 -pointsize 20 -gravity center -draw "fill grey70  text 0,0  \''. $watermark_text . '\'" '. $user_stamp_base . '_fgnd' . $ext;
										$commands[] = 'convert -size 300x50 xc:black -pointsize 20 -gravity center -draw "fill white  text  1,1  \''. $watermark_text . '\' text  0,0  \''. $watermark_text . '\' fill black  text -1,-1 \''. $watermark_text . '\'" +matte ' . $user_stamp_base . '_mask' . $ext;
										$commands[] = 'composite -compose CopyOpacity  ' . $user_stamp_base . "_mask" . $ext . ' ' . $user_stamp_base . '_fgnd' . $ext . ' ' . $user_stamp_base . $ext;
										$commands[] = 'mogrify -trim +repage ' . $user_stamp_base . $ext;
										$commands[] = 'rm ' . $user_stamp_base . '_mask' . $ext;
										$commands[] = 'rm ' . $user_stamp_fgnd . '_mask' . $ext;
										
										foreach( $commands as $command ) {
											file_put_contents("/home/gfroese/debug.txt", $command . "\n", FILE_APPEND);
											exec( $command );
										}
									}
									//apply the watermark
									$commands = array();
									$commands[] = 'composite -gravity south -geometry +0+10 ' . $user_stamp_base . $ext . ' ' . $thumblarge . ' ' . $thumblarge . '_watermarked';
									$commands[] = "mv $thumblarge" . "_watermarked $thumblarge";
									foreach( $commands as $command ) {
										file_put_contents("/home/gfroese/debug.txt", $command . "\n", FILE_APPEND);
										exec( $command );
									}
								}
							}
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
