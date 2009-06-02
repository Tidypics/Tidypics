<?php
	/**
	 * Save settings of Tidypics
	 * 
	 */

	global $CONFIG;

	gatekeeper();
	action_gatekeeper();
	
	$params = get_input('params');

	foreach ($params as $k => $v) {
		
		error_log("$k : $v");
		
	}
	
	if (get_input('download_link') == true)
		error_log('download link is on');
	if (get_input('tagging') == true)
		error_log('tagging is on');
	
	system_message(elgg_echo('tidypics:settings:save:ok'));
	
	forward($_SERVER['HTTP_REFERER']);
?>
