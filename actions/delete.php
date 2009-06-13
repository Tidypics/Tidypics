<?php

	/**
	 * Tidypics Delete Action for Images and Albums
	 * 
	 */

	$forward_url = 'pg/photos/world'; // by default forward to world photos

	 //if not logged in, see world pictures instead
	if (!isloggedin()) forward($forward_url);

	$guid = (int) get_input('guid');

	$entity = get_entity($guid);
	if (!$entity) { // unable to get Elgg entity
		register_error(elgg_echo("file:deletefailed"));
		forward($forward_url);
	}
	
	if (!$entity->canEdit()) { // user doesn't have permissions
		register_error(elgg_echo("file:deletefailed"));
		forward($forward_url);
	}

	$subtype = $entity->getSubtype();
	$container = get_entity($entity->container_guid);
	
	if ($subtype != 'image' && $subtype != 'album') { // how did we even get here?
		register_error(elgg_echo("file:deletefailed"));
		forward($forward_url);
	}

	$owner_guid = 0; // group or user
	if ($subtype == 'image') { //deleting an image
		$album = get_entity($entity->container_guid);
		$owner_guid = $album->container_guid;
		$forward_url = $container->getURL(); //forward back to album after deleting pictures
		$images = array($entity);
		// plugins can register to be told when a Tidypics image has been deleted
		trigger_elgg_event('upload', 'tp_album', $entity);
	} else { //deleting an album
		$owner_guid = $entity->container_guid;
		$forward_url = 'pg/photos/owned/' . $container->username;
		//get all the images from this album as long as less than 999 images
		$images = get_entities("object", "image", $guid, '', 999); 
		// plugins can register to be told when a Tidypics album has been deleted
		trigger_elgg_event('upload', 'tp_album', $entity);
	}

	// make sure we decrease the repo size for the size quota
	$image_repo_size_md = get_metadata_byname($owner_guid, "image_repo_size");
	$image_repo_size = (int)$image_repo_size_md->value;

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
			$image_repo_size -= $delfile->size();
			
			if (!$delfile->delete()) {
				if ($subtype=='image') register_error(elgg_echo("file:deletefailed")); //unable to delete object
			} else {
				if ($subtype=='image') system_message(elgg_echo("file:deleted")); //successfully deleted object
			}
		} //end delete actual image file
	} //end looping through each image to delete it
	
	//now that all images have been deleted, delete the album
	if ($subtype == 'album') {
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
		if (!$entity->delete()) {
			register_error(elgg_echo("file:deletefailed")); //unable to delete object
		} else {
			system_message(elgg_echo("file:deleted")); //successfully deleted object
		}
	} //end of delete album

	create_metadata($owner_guid, "image_repo_size", $image_repo_size, 'integer', $owner_guid);

	forward($forward_url);

?>