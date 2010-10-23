<?php
/**
 * Tidypics upgrade action
 */
require_once "{$CONFIG->pluginspath}tidypics/version.php";

$local_version = get_plugin_setting('version', 'tidypics');

if ($version <= $local_version) {
	register_error('No upgrade required');
	forward($_SERVER['HTTP_REFERER']);
}

set_time_limit(0);

$base_dir = $CONFIG->pluginspath . 'tidypics/upgrades';

// taken from engine/lib/version.php
if ($handle = opendir($base_dir)) {
	$upgrades = array();

	while ($updatefile = readdir($handle)) {
		// Look for upgrades and add to upgrades list
		if (!is_dir("$base_dir/$updatefile")) {
			if (preg_match('/^([0-9]{10})\.(php)$/', $updatefile, $matches)) {
				$plugin_version = (int) $matches[1];
				if ($plugin_version > $local_version) {
					$upgrades[] = "$base_dir/$updatefile";
				}
			}
		}
	}

	// Sort and execute
	asort($upgrades);

	if (sizeof($upgrades) > 0) {
		foreach ($upgrades as $upgrade) {
			include($upgrade);
		}
	}
}

set_plugin_setting('version', $version, 'tidypics');

system_message("Tidypics has been upgraded");

forward($_SERVER['HTTP_REFERER']);
