<?php
	/**
	 * Tidypics Upload Images Page
	 * 
	 */

	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	gatekeeper();
	global $CONFIG;
	
	$album_guid = (int) get_input('container_guid');
	if (!$album_guid)
		forward();

	$album = get_entity($album_guid);
	
	//if album does not exist or user does not have access
	if (!$album || !$album->canEdit()) {
		// throw warning and forward to previous page
		forward($_SERVER['HTTP_REFERER']);
	}

	// set page owner based on container (user or group) 
	$container = $album->container_guid;
	set_page_owner($container);

	$page_owner = page_owner_entity();
	if ($page_owner instanceof ElggGroup) {
		add_submenu_item(	sprintf(elgg_echo('album:group'),$page_owner->name), 
							$CONFIG->wwwroot . "pg/photos/owned/" . $page_owner->username);
	}

	set_context('photos');
	$title = elgg_echo('album:addpix') . ': ' . $album->title;
	$area2 .= elgg_view_title($title);
	
	$area2 .= elgg_view("tidypics/forms/upload", array('album' => $album_guid ) );
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);
	
	page_draw($title, $body);
?>