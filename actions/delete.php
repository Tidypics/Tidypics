<?php

	/**
	 * Tidypics Delete Action
	 * 
	 */

	//if not logged in, see world pictures instead
	if (!isloggedin()) forward('pg/photos/world');

	$guid = (int) get_input('guid');
	$forward_url = 'pg/photos/world'; //forward to world pictures if there is an unknown error

	if ($photoObject = get_entity($guid)) {
		if ($photoObject->canEdit()) {
			$subtype = $photoObject->getSubtype();
			$container = get_entity($photoObject->container_guid);
			
			if ($subtype!='image' && $subtype!='album') 
				forward(get_input('forward_url', $_SERVER['HTTP_REFERER'])); //back off if not an album or image
			
			if ($subtype == 'image') { //deleting an image
				$forward_url = $container->getURL(); //forward back to album after deleting pictures
				$images = array($photoObject);
			} else { //deleting an album
				$forward_url = 'pg/photos/owned/' . $container->username;
				$images = get_entities("object","image", $guid, '', 999); //get all the images from this album, or the image requested
			} //end of subtype comparison

			//loop through all images and delete them
			foreach($images as $im) {
				$thumbnail = $im->thumbnail;
				$smallthumb = $im->smallthumb;
				$largethumb = $im->largethumb;

				if ($thumbnail) { //delete standard thumbnail image
					$delfile = new ElggFile();
					$delfile->owner_guid = $im->getOwner();
					$delfile->setFilename($thumbnail);
					$delfile->delete();
				}
				if ($smallthumb) { //delete small thumbnail image
					$delfile = new ElggFile();
					$delfile->owner_guid = $im->getOwner();
					$delfile->setFilename($smallthumb);
					$delfile->delete();
				}
				if ($largethumb) { //delete large thumbnail image
					$delfile = new ElggFile();
					$delfile->owner_guid = $im->getOwner();
					$delfile->setFilename($largethumb);
					$delfile->delete();
				}
				if ($im) { //delete actual image file
					$delfile = new ElggFile($im->getGUID());
					$delfile->owner_guid = $im->getOwner();
					//$delfile->setFilename($im->originalfilename);
					if (!$delfile->delete()) {
						if ($subtype=='image') register_error(elgg_echo("file:deletefailed")); //unable to delete object
					} else {
						if ($subtype=='image') system_message(elgg_echo("file:deleted")); //successfully deleted object
					}
				} //end delete actual image file
			} //end looping through each image to delete it
			
			//now that all images have been deleted, delete the album
			if ($subtype=='album') {
				//delete the album's directory manually; first create a temp file to get the directory path
				$tmpfile = new ElggFile();
				$tmpfile->setFilename('image/' . $guid . '/._tmp_del_tidypics_album_');
				$tmpfile->subtype = 'image';
				$tmpfile->container_guid = $guid;
				$tmpfile->open("write");
				$tmpfile->write('');
				$tmpfile->close();
				$tmpfile->save();
				$albumdir = eregi_replace('/._tmp_del_tidypics_album_', '', $tmpfile->getFilenameOnFilestore());
				$tmpfile->delete();
				if (is_dir($albumdir))
					rmdir($albumdir);
				
				//delete object from database
				if (!$photoObject->delete()) {
					register_error(elgg_echo("file:deletefailed")); //unable to delete object
				} else {
					system_message(elgg_echo("file:deleted")); //successfully deleted object
				}
			} //end of delete album


		} else { //user does not have permissions to delete this image or album
			$container = $_SESSION['user'];
			register_error(elgg_echo("file:deletefailed"));
		} //end of canEdit() comparison

	} else { // unable to get Elgg entity
		register_error(elgg_echo("file:deletefailed"));
	} //end of get_entitty()
		
	forward($forward_url);

?>