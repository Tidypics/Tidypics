<?php
/**
 * Tidypics plugin settings view
 *
 * Set reasonable defaults if no settings saved
 */

if (!get_plugin_setting('image_lib', 'tidypics')) {
	set_plugin_setting('image_lib', 'GD', 'tidypics');
	set_plugin_setting('download_link', 'enabled', 'tidypics');
	set_plugin_setting('tagging', 'enabled', 'tidypics');
	set_plugin_setting('photo_ratings', 'disabled', 'tidypics');
	set_plugin_setting('exif', 'disabled', 'tidypics');
	set_plugin_setting('view_count', 'disabled', 'tidypics');
	set_plugin_setting('maxfilesize', '5', 'tidypics');
	set_plugin_setting('quota', '0', 'tidypics');
	set_plugin_setting('img_river_view', 'batch', 'tidypics');
	set_plugin_setting('album_river_view', 'set', 'tidypics');

	$image_sizes = array();
	$image_sizes['large_image_width'] = 600;
	$image_sizes['large_image_height'] = 600;
	$image_sizes['small_image_width'] = 153;
	$image_sizes['small_image_height'] = 153;
	$image_sizes['thumb_image_width'] = 60;
	$image_sizes['thumb_image_height'] = 60;
	set_plugin_setting('image_sizes', serialize($image_sizes), 'tidypics');
}

global $CONFIG;  
$system_url = $CONFIG->wwwroot . 'mod/tidypics/pages/server_analysis.php';
$settings_url = $CONFIG->wwwroot . 'mod/tidypics/pages/admin.php';
?>

<p>
<a href="<?php echo $system_url; ?>">Run Server Analysis</a>
</p>
<p>
<a href="<?php echo $settings_url; ?>">Change Tidypics Settings</a>
</p>