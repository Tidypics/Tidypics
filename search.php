<?php

	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	
	// Set context
	set_context('search');
	
	// Get user guid
	$guid = get_input('guid');
	
	$user = get_entity($guid);
//	if ($user)
//		$user->name;
		
	$title = $user->name;
	
	
	$body = elgg_view_title($title); 
	$body .= list_entities_from_relationship('phototag', $guid, false, 'object', 'image'); 
	$body = elgg_view_layout('two_column_left_sidebar','',$body);

	page_draw($title,$body);

?>