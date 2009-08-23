<?php
	/**
	 * Tidypics View All Albums on Site
	 * 
	 */

	include_once dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php";
	
	$num_albums = 16;
	
	$title = elgg_echo('album:all');
	
	set_context('photos');
	$area2 = elgg_view_title($title);
	
	set_context('search');
	set_input('search_viewtype', 'gallery');
	$albums_html .= list_entities('object','album', 0, $num_albums);

	
	$area2 .= $albums_html;
	
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);

	page_draw($title, $body);
?>