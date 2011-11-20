<?php
/**
 * Save Tidypics plugin settings
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$plugin = elgg_get_plugin_from_id('tidypics');

$params = get_input('params');
foreach ($params as $k => $v) {
	if (!$plugin->setSetting($k, $v)) {
		register_error(elgg_echo('plugins:settings:save:fail', array('tidypics')));
		forward(REFERER);
	}
}

system_message(elgg_echo('tidypics:settings:save:ok'));
forward(REFERER);

// check boxes
if (is_array(get_input('download_link'))) { // this can be done due to way Elgg uses checkboxes
	set_plugin_setting('download_link', 'enabled', 'tidypics');
} else {
	set_plugin_setting('download_link', 'disabled', 'tidypics');
}

if (is_array(get_input('tagging'))) {
	set_plugin_setting('tagging', 'enabled', 'tidypics');
} else {
	set_plugin_setting('tagging', 'disabled', 'tidypics');
}

if (is_array(get_input('photo_ratings'))) {
	set_plugin_setting('photo_ratings', 'enabled', 'tidypics');
} else {
	set_plugin_setting('photo_ratings', 'disabled', 'tidypics');
}

if (is_array(get_input('exif'))) {
	set_plugin_setting('exif', 'enabled', 'tidypics');
} else {
	set_plugin_setting('exif', 'disabled', 'tidypics');
}

if (is_array(get_input('view_count'))) {
	set_plugin_setting('view_count', 'enabled', 'tidypics');
} else {
	set_plugin_setting('view_count', 'disabled', 'tidypics');
}

if (is_array(get_input('uploader'))) {
	set_plugin_setting('uploader', 'enabled', 'tidypics');
} else {
	set_plugin_setting('uploader', 'disabled', 'tidypics');
}

if (is_array(get_input('grp_perm_override'))) {
	set_plugin_setting('grp_perm_override', 'enabled', 'tidypics');
} else {
	set_plugin_setting('grp_perm_override', 'disabled', 'tidypics');
}


// image sizes
$image_sizes = array();
$image_sizes['large_image_width'] = get_input('large_thumb_width');
$image_sizes['large_image_height'] = get_input('large_thumb_height');
$image_sizes['small_image_width'] = get_input('small_thumb_width');
//$image_sizes['small_image_height'] = get_input('small_thumb_height');
$image_sizes['small_image_height'] = get_input('small_thumb_width');
$image_sizes['thumb_image_width'] = get_input('thumb_width');
//$image_sizes['thumb_image_height'] = get_input('thumb_height');
$image_sizes['thumb_image_height'] = get_input('thumb_width');
set_plugin_setting('image_sizes', serialize($image_sizes), 'tidypics');

