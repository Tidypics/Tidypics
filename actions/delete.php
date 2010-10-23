<?php

/**
 * Tidypics Delete Action for Images and Albums
 *
 */

// must be logged in
gatekeeper();

$forward_url = 'pg/photos/world'; // by default forward to world photos

$guid = (int) get_input('guid');

$entity = get_entity($guid);
if (!$entity) { // unable to get Elgg entity
	register_error(elgg_echo("tidypics:deletefailed"));
	forward($forward_url);
}

if (!$entity->canEdit()) { // user doesn't have permissions
	register_error(elgg_echo("tidypics:deletefailed"));
	forward($forward_url);
}

$subtype = $entity->getSubtype();
$container = get_entity($entity->container_guid);

if ($subtype != 'image' && $subtype != 'album') { // how did we even get here?
	register_error(elgg_echo("tidypics:deletefailed"));
	forward($forward_url);
}

$owner_guid = 0; // group or user
if ($subtype == 'image') {
	//forward back to album after deleting pictures
	$forward_url = $container->getURL();

	// plugins can register to be told when a Tidypics image has been deleted
	trigger_elgg_event('delete', 'tp_image', $entity);

	if ($entity->delete()) {
		system_message(elgg_echo("tidypics:deleted"));
	} else {
		register_error(elgg_echo("tidypics:deletefailed"));
	}
} else {
	//deleting an album
	$owner_guid = $entity->container_guid;
	$forward_url = 'pg/photos/owned/' . $container->username;
	//get all the images from this album as long as less than 999 images
	$images = get_entities("object", "image", $guid, '', 999);
	// plugins can register to be told when a Tidypics album has been deleted
	trigger_elgg_event('delete', 'tp_album', $entity);
	//loop through all images and delete them
	foreach ($images as $im) {
		if ($im) {


			if (!$im->delete()) {
				register_error(elgg_echo("tidypics:deletefailed")); //unable to delete object
			} else {
				if ($subtype=='image') {
					system_message(elgg_echo("tidypics:deleted")); //successfully deleted object
				}
			}
		} //end delete actual image file
	} //end looping through each image to delete it
}

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
	if (is_dir($albumdir)) {
		rmdir($albumdir);
	}

	//delete album object from database
	if (!$entity->delete()) {
		register_error(elgg_echo("tidypics:deletefailed")); //unable to delete object
	} else {
		system_message(elgg_echo("tidypics:deleted")); //successfully deleted object
	}
} //end of delete album

forward($forward_url);
