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
	
	system_message(elgg_echo('tidypics:settings:save:ok'));
	
	forward($_SERVER['HTTP_REFERER']);
?>
