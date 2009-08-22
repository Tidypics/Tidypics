<?php

	/**
	 * Most recently uploaded images
	 * 
	 */

	// Load Elgg engine
	include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php";

	// how many do we display
	$max = 12;
	
	// grab the html to display the images
	$images = list_entities("object", "image", 0, $max, false, false, true);
	
	$title = elgg_echo('tidypics:mostrecent');
	
	// this view takes care of the title on the main column and the content wrapper
	$area2 = elgg_view('tidypics/content_wrapper', array('title' => $title, 'content' => $images,));
	
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);
	
	page_draw($title, $body);
?>