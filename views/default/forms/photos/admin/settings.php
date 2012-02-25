<?php
/**
 * Tidypics admin settings form body
 *
 * @todo watermark, quota, remove original image, group only upload not delete
 */

$plugin = elgg_get_plugin_from_id('tidypics');

// main settings
$checkboxes = array('tagging', 'view_count', 'uploader', 'exif', 'download_link');
foreach ($checkboxes as $checkbox) {
	echo '<div>';
	$checked = $plugin->$checkbox ? 'checked' : false;
	echo elgg_view('input/checkbox', array(
		'name' => "params[$checkbox]",
		'value' => true,
		'checked' => (bool)$plugin->$checkbox,
	));
	echo ' ' . elgg_echo("tidypics:settings:$checkbox");
	echo '</div>';
}

// max image size
echo '<div>';
echo elgg_echo('tidypics:settings:maxfilesize');
echo elgg_view('input/text', array(
	'name' => 'params[maxfilesize]',
	'value' => $plugin->maxfilesize,
));
echo '</div>';

// image library
echo '<h3>' . elgg_echo('tidypics:settings:heading:img_lib') . '</h3>';
echo'<div>';
echo elgg_echo('tidypics:settings:image_lib') . ': ';
echo elgg_view('input/dropdown', array(
	'name' => 'params[image_lib]',
	'options_values' => tidypics_get_image_libraries(),
	'value' => $plugin->image_lib,
));
echo '</div>';
echo '<div>';
echo elgg_echo('tidypics:settings:im_path') . ' ';
echo elgg_view("input/text", array('name' => 'params[im_path]', 'value' => $plugin->im_path));
echo '</div>';


// river integration
echo '<h3>' . elgg_echo('tidypics:settings:heading:river') . '</h3>';
echo '<div>';
echo elgg_echo('tidypics:settings:img_river_view') . ': ';
echo elgg_view('input/dropdown', array(
	'name' => 'params[img_river_view]',
	'options_values' => array(
		'all' => elgg_echo('tidypics:option:all'),
		'batch' => '1',
		'none' => elgg_echo('tidypics:option:none'),
	),
	'value' => $plugin->img_river_view,
));
echo '</div>';
echo '<div>';
echo elgg_echo('tidypics:settings:album_river_view') . ': ';
echo elgg_view('input/dropdown', array(
	'name' => 'params[album_river_view]',
	'options_values' => array(
		'cover' => elgg_echo('tidypics:option:cover'),
		'set' => elgg_echo('tidypics:option:set'),
	),
	'value' => $plugin->album_river_view,
));
echo '</div>';


// thumbnail sizes
echo '<div>';
echo '<h3>' . elgg_echo('tidypics:settings:heading:sizes') . '</h3>';
echo '<h6>' . elgg_echo('tidypics:settings:sizes:instructs') . '</h6>';
$image_sizes = unserialize($plugin->image_sizes);
echo '<table>';
$sizes = array('large', 'small', 'tiny');
foreach ($sizes as $size) {
	echo '<tr>';
	echo '<td class="pas">';
	echo elgg_echo("tidypics:settings:{$size}size");
	echo '</td><td class="pas">';
	echo 'width: ';
	echo elgg_view('input/text', array(
		'name' => "{$size}_image_width",
		'value' => $image_sizes["{$size}_image_width"],
		'class' => 'tidypics-input-thin',
	));
	echo '</td><td class="pas">';
	echo 'height: ';
	echo elgg_view('input/text', array(
		'name' => "{$size}_image_height",
		'value' => $image_sizes["{$size}_image_height"],
		'class' => 'tidypics-input-thin',
	));
	echo '</td>';
	echo '</tr>';
}
echo '</table>';
echo '</div>';



echo elgg_view('input/submit', array('value' => elgg_echo("save")));

return true;


// Watermark Text
$form_body .= "<p>" . elgg_echo('tidypics:settings:watermark') . "<br />";
$form_body .= elgg_view("input/text",array('internalname' => 'params[watermark_text]', 'value' => $plugin->watermark_text)) . "</p>";

// Quota Size
$quota = $plugin->quota;
if (!$quota) {
	$quota = 0;
}
$form_body .= "<p>" . elgg_echo('tidypics:settings:quota') . "<br />";
$form_body .= elgg_view("input/text",array('internalname' => 'params[quota]', 'value' => $quota)) . "</p>";

