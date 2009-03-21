<?php

	/**
	 * Tidypics Album View Page
	 */

	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	// Get the GUID of the entity we want to view
	$guid = (int) get_input('guid');
		
	$context = get_input('context');
	if ($context) set_context($context);
		
	// Get the entity, if possible
	if ($entity = get_entity($guid)) {

		if ($entity->container_guid) {
			set_page_owner($entity->container_guid);
		} else {
			set_page_owner($entity->owner_guid);
		}
			
		// Set the body to be the full view of the entity, and the title to be its title
		if ($entity instanceof ElggObject) {
			$title = $entity->title;
		} else if ($entity instanceof ElggEntity) {
			$title = $entity->name;
		}
		
		$area2 = elgg_view_title($title);

		$area2 .= elgg_view_entity($entity, true);
			
	// Otherwise?
	} else {	
	}
		
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);

	// Display the page
	page_draw($title, $body);
?>