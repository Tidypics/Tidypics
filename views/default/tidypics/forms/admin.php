<?php
	/**
	* Tidypics admin settings form
	*/

	// to do
	// 1. set action and code it
	// 2. add language strings
	// 3. clean up and organize
	
	
	$action = $vars['url'] . 'action/tidypics/settings';
	
	$plugin = find_plugin_settings('tidypics');


	// Image Library - need to update values!
	$image_lib = $plugin->image_lib;
	if (!$image_lib) $image_lib = 'GD';
	$form_body = '<p>' . elgg_echo('tidypics:settings:image_lib');
	$form_body .= elgg_view('input/pulldown', array(
					'internalname' => 'params[image_lib]',
					'options_values' => array(
						'GD' => 'GD',
						'ImageMagickPHP' => 'ImageMagick',
						'ImageMagick' => 'ImageMagick Cmdline',
					),
					'value' => $image_lib
	));
	$form_body .= '</p>';

	// Image Magick Path
	$im_path = $plugin->im_path;
	if(!$im_path) $im_path = "/usr/bin/";
	$form_body .= "<p>" . elgg_echo('tidypics:settings:im_path') . "<br />";
	$form_body .= elgg_view("input/text",array('internalname' => 'params[im_path]', 'value' => $im_path)) . "</p>";

	// Tagging
	$tagging = $plugin->tagging;
	if(!$tagging) $tagging = "enabled";
	$form_body .= '<p class="admin_debug">' . elgg_view("input/checkboxes", array('options' => array(elgg_echo('tidypics:settings:tagging') => 'enabled'), 'internalname' => 'tagging', 'value' => $tagging )) . "</p>";

	// Download Link
	$download_link = $plugin->download_link;
	if(!$download_link) $download_link = "enabled";
	$form_body .= '<p class="admin_debug">' . elgg_view("input/checkboxes", array('options' => array(elgg_echo('tidypics:settings:download_link') => 'enabled'), 'internalname' => 'download_link', 'value' => $download_link )) . "</p>";

	// Show EXIF
	$exif = $plugin->exif;
	if(!$exif) $exif = "disabled";
	$form_body .= '<p class="admin_debug">' . elgg_view("input/checkboxes", array('options' => array(elgg_echo('tidypics:settings:exif') => 'enabled'), 'internalname' => 'exif', 'value' => $exif )) . "</p>";

	// Watermark Text
	$form_body .= "<p>" . elgg_echo('tidypics:settings:watermark') . "<br />";
	$form_body .= elgg_view("input/text",array('internalname' => 'params[watermark_text]', 'value' => $plugin->watermark_text)) . "</p>";

	// Max Image Size
	$maxfilesize = $plugin->maxfilesize;
	if (!$maxfilesize) $maxfilesize = (int)5; // 5 MB
	$form_body .= "<p>" . elgg_echo('tidypics:settings:maxfilesize') . "<br />";
	$form_body .= elgg_view("input/text",array('internalname' => 'params[maxfilesize]', 'value' => $maxfilesize)) . "</p>";

	// River options
	$river_view = $plugin->river_view;
	if (!$river_view) $river_view = '1';
	$form_body .= '<p>' . elgg_echo('tidypics:settings:river_view');
	$form_body .= elgg_view('input/pulldown', array(
					'internalname' => 'params[river_view]',
					'options_values' => array(
						'all' => 'all',
						'1' => '1',
						'none' => 'none',
					),
					'value' => $river_view
	));
	$form_body .= '</p>';

	// Thumbnail sizes
	$image_sizes = $plugin->image_sizes;
	if(!$image_sizes) {
		$image_sizes = array(); // set default values 
		$image_sizes['large_image_width'] = $image_sizes['large_image_height'] = 600;
		$image_sizes['small_image_width'] = $image_sizes['small_image_height'] = 153;
		$image_sizes['thumb_image_width'] = $image_sizes['thumb_image_height'] = 60;
	} else {
		$image_sizes = unserialize($image_sizes);
	}
	$form_body .= "<p>" . elgg_echo('tidypics:settings:largesize') . "<br />";
	$form_body .= 'width: <input style="width: 20%;" type="text" name="large_thumb_width" value=' . "\"{$image_sizes['large_image_width']}\"" . ' class="input-text" />&nbsp;&nbsp;&nbsp;';
	$form_body .= 'height: <input style="width: 20%;" type="text" name="large_thumb_height" value=' . "\"{$image_sizes['large_image_height']}\"" . ' class="input-text" /></p>';
	$form_body .= "<p>" . elgg_echo('tidypics:settings:smallsize') . "<br />";
	$form_body .= 'width: <input style="width: 20%;" type="text" name="small_thumb_width" value=' . "\"{$image_sizes['small_image_width']}\"" . ' class="input-text" />&nbsp;&nbsp;&nbsp;';
	$form_body .= 'height: <input style="width: 20%;" type="text" name="small_thumb_height" value=' . "\"{$image_sizes['small_image_height']}\"" . ' class="input-text" /></p>';
	$form_body .= "<p>" . elgg_echo('tidypics:settings:thumbsize') . "<br />";
	$form_body .= 'width: <input style="width: 20%;" type="text" name="thumb_width" value=' . "\"{$image_sizes['thumb_image_width']}\"" . ' class="input-text" />&nbsp;&nbsp;&nbsp;';
	$form_body .= 'height: <input style="width: 20%;" type="text" name="thumb_height" value=' . "\"{$image_sizes['thumb_image_height']}\"" . ' class="input-text" /></p>';


	$form_body .= elgg_view('input/submit', array('value' => elgg_echo("save")));
	
	echo elgg_view('input/form', array('action' => $action, 'body' => $form_body));