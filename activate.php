<?php
/**
 * Activate Tidypics
 * 
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

// register classes
if (get_subtype_id('object', 'album')) {
	update_subtype('object', 'album', 'TidypicsAlbum');
} else {
	add_subtype('object', 'album', 'TidypicsAlbum');
}
if (get_subtype_id('object', 'image')) {
	update_subtype('object', 'image', 'TidypicsImage');
} else {
	add_subtype('object', 'image', 'TidypicsImage');
}

// set default settings
$plugin = elgg_get_plugin_from_id('tidypics');

$defaults = array(
	'tagging' => true,
);

foreach ($defaults as $name => $value) {
	if ($plugin->getSetting($name) === null) {
		$plugin->setSetting($name, $value);
	}
}
