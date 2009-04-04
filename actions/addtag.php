<?php
	/**
	 * Tidypics Add Tag
	 * 
	 */

	// Make sure we're logged in (send us to the front page if not)
	if (!isloggedin()) forward();
	
	$coordinates_str = get_input('coordinates');
	error_log($coordinates_str);
	
	$user_id = get_input('user_id');
	//$entity_guid = get_input('entity_guid', null);
	$word = get_input('word');
	
	error_log($word);
	error_log($user_id);


	forward($_SERVER['HTTP_REFERER']);

?>