<?php
	/**
	 * Tidypics View All Albums on Site
	 * 
	 */

	include_once dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php";
	
	// set page owner to logged in user
	if (isloggedin()) {
		set_page_owner(get_loggedin_userid());
	}
	
	$num_albums = 16;
	
	$title = elgg_echo('album:all');
	$area2 = elgg_view_title($title);
	
	set_context('search');
	set_input('search_viewtype', 'gallery');
	$content .= tp_list_entities('object','album', 0, null, $num_albums, false);
	set_context('photos');

	$area2 = elgg_view('tidypics/content_wrapper', array('title' => $title, 'content' => $content,));
	
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);

	page_draw($title, $body);
?>