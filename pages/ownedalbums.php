<?php
	/**
	 * tidypics photo gallery album listing page for a person/group
	 * 
	 * Shows all the albums that belong to that person or group
	 */

	include_once dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php";
	
	// if this page belongs to a closed group, prevent anyone outside group from seeing
	if (is_callable('group_gatekeeper')) group_gatekeeper();
	
	//get the owner of the current page
	$owner = page_owner_entity();
	
	
	//if page owner cannot be found, forward to world album list
	if (is_null($owner->username) || empty($owner->username))  {
		forward('pg/photos/world');
	}

	
	// setup group menu for album index
	if ($owner instanceof ElggGroup) {
				add_submenu_item(	sprintf(elgg_echo('album:group'),$owner->name), 
									$CONFIG->wwwroot . "pg/photos/owned/" . $owner->username);
		if (can_write_to_container(0, $owner->guid)) {
				add_submenu_item(	elgg_echo('album:create'),
									$CONFIG->wwwroot . 'pg/photos/new/' . $owner->username,
									'tidypics');
		}
	}
	
	//set the title
	$title = sprintf(elgg_echo('album:user'), $owner->name);
	$area2 = elgg_view_title($title);
		
	// Get objects
	set_context('search');
	set_input('search_viewtype', 'gallery');
	if ($owner instanceof ElggGroup)
		$content .= tp_list_entities("object", "album", 0, $owner->guid, 12, false);
	else
		$content .= tp_list_entities("object", "album", $owner->guid, $owner->guid, 12, false);
	
	$area2 = elgg_view('tidypics/content_wrapper', array('title' => $title, 'content' => $content,));
	
	set_context('photos');
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);
	
	// Finally draw the page
	page_draw($title, $body);
?>