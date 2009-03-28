<?php
	/**
	 * Tidypics: Edit the properties of multiple images 
	 * 
	 */

	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	gatekeeper();
	set_context('photos');

	// parse out photo guids
	$file_string = get_input('files');
	$file_array_sent = explode('-', $file_string);
	$new_file_array = array();

	// set owner of page based on first photo guid
	$photo_guid = (int)$file_array_sent[0];
	$photo = get_entity($photo_guid);

	// set page owner based on owner of photo album
	set_page_owner($photo->owner_guid);
	$album = get_entity($photo->container_guid);
	if ($album) {
		$owner_guid = $album->container_guid;
		if ($owner_guid)
			set_page_owner($owner_guid);
	}

	foreach ($file_array_sent as $file_guid) {
		if ($entity = get_entity($file_guid)) {
			if ($entity->canEdit()){
				array_push($new_file_array, $file_guid);
			}
			if (!$album_guid) 
				$album_guid = $entity->container_guid;
			
		}
	}

	$title = elgg_echo('tidypics:editprops');
	$area2 .= elgg_view_title($title);
	$area2 .= elgg_view("tidypics/forms/edit_multi", array('file_array' => $new_file_array, 'album_guid' => $album_guid));
	$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
	page_draw($title, $body);
?>
