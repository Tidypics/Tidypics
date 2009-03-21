<?php
	/**
	 * Tidypics View All Albums on Site
	 * 
	 */

	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	
	$limit = get_input("limit", 10);
	$offset = get_input("offset", 0);
	$tag = get_input("tag");
	
	// Get the current page's owner
	$page_owner = page_owner_entity();
	if ($page_owner === false || is_null($page_owner)) {
		$page_owner = $_SESSION['user'];
		set_page_owner($_SESSION['guid']);
	}
	
	// Get objects
	$area2 = elgg_view_title($title = elgg_echo('album:all'));
	
	set_context('search');
	set_input('search_viewtype', 'gallery');
	$area2 .= list_entities('object','album', 0, 28);		

	set_context('photos');
		
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);

	// Finally draw the page
	page_draw(sprintf(elgg_echo("album:all"),$_SESSION['user']->name), $body);
?>