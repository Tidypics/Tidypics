<?php

	/**
	 * Tidypics full view of an image
	 * Given a GUID, this page will try and display any entity
	 * 
	 */

	// Load Elgg engine
	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	$max = 8;
	$images = list_entities("object", "image", 0, $max, false, false, true);
	
	$title = "Most recent images";
	$area2 = elgg_view_title($title);
	
//	include_once(dirname(__FILE__) . "/notice.php");
//	$notice = tp_notice(); 
//	$area2 .= $notice->text;
	
	$area2 .= $images;
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);
	page_draw($title, $body);
	if($notice->showMessage == true) system_message($notice->text);
	
?>