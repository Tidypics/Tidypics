<?php

	/**
	 * Tidypics full view of an image
	 * Given a GUID, this page will try and display any entity
	 * 
	 */

	// Load Elgg engine
	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	// Get the GUID of the entity we want to view
	$guid = (int) get_input('guid');
	$shell = get_input('shell');
	if ($shell == "no") {
		$shell = false;
	} else {
		$shell = true;
	}
		
	$context = get_input('context');
	if ($context) set_context($context);
		
	// Get the entity, if possible
	if ($entity = get_entity($guid)) {

		//set  "real" container - image container is the album , group/user is the album container
		$top_container = get_entity($entity->container_guid)->container_guid;
	
		if ($top_container) {
			set_page_owner($top_container);
		} else {
			set_page_owner($entity->owner_guid);
		}
			
		// Set the body to be the full view of the entity, and the title to be its title
		$area2 = elgg_view_entity($entity,true);
		if ($shell) {
			$body = elgg_view_layout('two_column_left_sidebar', '', $area1 . $area2);
		} else {
			$body = $area2;
		}

	} else {			
		$body = elgg_echo('notfound');
	}
		
	// Display the page
	if ($shell) {
		page_draw("", $body);
	} else {
		header("Content-type: text/html; charset=UTF-8");
		echo $body;
	}

?>