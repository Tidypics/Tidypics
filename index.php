<?php
	/**
	 * Elgg tidypics photo gallery main page
	 * 
	 * 
	 */

	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	
	//get the owner of the current page
	$owner = page_owner_entity();
	
	//if page owner cannot be found, forward to user's pictures instead (or world if not logged in)
	if (is_null($owner->username) || empty($owner->username))  {
		//if not logged in, see world pictures instead
		if (!isloggedin()) forward('pg/photos/world');
		forward('pg/photos/owned/' . $_SESSION['user']->username);
	}
	
	//set the title
	$area2 = elgg_view_title($title = sprintf(elgg_echo('album:user'), "$owner->name"));
		
	// Get objects
	set_context('search');
	set_input('search_viewtype', 'gallery');
	$area2 .= list_entities("object","album",page_owner(),10);
		
	set_context('photos');
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);
	
	// Finally draw the page
	page_draw(sprintf(elgg_echo("album:user"),page_owner_entity()->name), $body);
?>