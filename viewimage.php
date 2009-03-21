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
			
		$title = $entity->title;
		$area2 = elgg_view_title($title);
		$area2 .= elgg_view_entity($entity, true);

	} else {			
		$body = elgg_echo('notfound');
	}
		
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);

	// Display the page
	page_draw($title, $body);
?>