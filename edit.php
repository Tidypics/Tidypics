<?php
	/**
	 * Tidypics Edit for Albums and Single Photos 
	 * 
	 */

	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	gatekeeper(); // make sure the user is logged_in
	
	set_context('photos');
	$guid = (int) get_input('guid');

	if (!$entity = get_entity($guid)) 
		forward();

	if (!$entity->canEdit()) 
		forward();

	$subtype = $entity->getSubtype();
		
	if ($subtype == 'album') {
		$title = elgg_echo('album:edit');

		if ($container = $entity->container_guid)
			set_page_owner($container);

	} else if ($subtype == 'image') {
		$title = elgg_echo('image:edit');

		if ($container = get_entity($entity->container_guid)->container_guid)
			set_page_owner($container);	

	} else {
		forward();
	}
	
	$page_owner = page_owner_entity();
	if ($page_owner instanceof ElggGroup) {
		add_submenu_item(	sprintf(elgg_echo('album:group'),$page_owner->name), 
							$CONFIG->wwwroot . "pg/photos/owned/" . $page_owner->username);
	}

	
	$area2 .= elgg_view_title($title);
	$area2 .= elgg_view('tidypics/forms/edit', array('entity' => $entity, 'subtype' => $subtype));
	$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);

	page_draw($title, $body);
?>