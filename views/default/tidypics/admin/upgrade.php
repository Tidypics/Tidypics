<?php

require_once "{$CONFIG->pluginspath}tidypics/version.php";

$upgrade_url = "{$vars['url']}action/tidypics/admin/upgrade";
//$upgrade_url = elgg_add_action_tokens_to_url($upgrade_url);

// determine whether an upgrade is required
$local_version = get_plugin_setting('version', 'tidypics');
if ($local_version === FALSE) {
	// no version set so either new install or really old one
	if (!get_subtype_class('object', 'image') || !get_subtype_class('object', 'album')) {
		$local_version = 0;
	} else {
		set_plugin_setting('version', $local_version, 'tidypics');
		$local_version = $version;
	}
} elseif ($local_version == '1.62') {
	$local_version = 2010010101;
	set_plugin_setting('version', $local_version, 'tidypics');
}
if ($local_version == $version) {
	// no upgrade required
	return TRUE;
}

echo elgg_view('output/url', array(	'text' => 'Upgrade',
									'href' => $upgrade_url,
									'is_action' => TRUE));
echo '<br />';