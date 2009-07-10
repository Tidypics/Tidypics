<?php

	/**
	 * Most recent uploaded images
	 * 
	 */

	// Load Elgg engine
	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	$max = 8;
	$images = list_entities("object", "image", 0, $max, false, false, true);
	
	$title = elgg_echo('tidypics:mostrecent');
	$area2 = elgg_view_title($title);
	$area2 .= '<div class="contentWrapper">'; 
	$area2 .= $images;
	$area2 .= '</div>';
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);
	page_draw($title, $body);
?>