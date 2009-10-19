<?php

	/**
	 * Setup a users Flickr username
	 * 
	 */

	// Load Elgg engine
	include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php";
	
	$viewer = get_loggedin_user();
	
	$body = elgg_view_title( elgg_echo( 'flickr:setup') );
	$body .= elgg_view("tidypics/forms/setupFlickr", array(), false, true );
//	echo "<pre>"; var_dump($body); echo "</pre>";
	page_draw( elgg_echo( 'flickr:setup'), elgg_view_layout("two_column_left_sidebar", '', $body));
?>