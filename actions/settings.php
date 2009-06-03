<?php
	/**
	 * Save settings of Tidypics
	 * 
	 */

	global $CONFIG;

	gatekeeper();
	action_gatekeeper();


	// Params array (text boxes and drop downs)
	$params = get_input('params');
	$result = false;
	foreach ($params as $k => $v) {
		if (!set_plugin_setting($k, $v, 'tidypics')) {
			register_error(sprintf(elgg_echo('plugins:settings:save:fail'), 'tidypics'));
			forward($_SERVER['HTTP_REFERER']);
		}
	}

	// check boxes
	if (is_array(get_input('download_link'))) // this can be done due to way Elgg uses checkboxes
		set_plugin_setting('download_link', 'enabled', 'tidypics');
	else
		set_plugin_setting('download_link', 'disabled', 'tidypics');
	
	if (is_array(get_input('tagging')))
		set_plugin_setting('tagging', 'enabled', 'tidypics');
	else
		set_plugin_setting('tagging', 'disabled', 'tidypics');
	
	system_message(elgg_echo('tidypics:settings:save:ok'));
	
	forward($_SERVER['HTTP_REFERER']);
?>
