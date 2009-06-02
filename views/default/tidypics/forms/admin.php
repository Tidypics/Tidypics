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


	// Image Library
	$image_lib = $plugin->image_lib;
	if (!$image_lib) $image_lib = 'GD';
	$form_body = 'Not functional!!!!!!!  <p>' . elgg_echo('tidypics:settings:image_lib');
	$form_body .= elgg_view('input/pulldown', array(
					'internalname' => 'params[image_lib]',
					'options_values' => array(
						'GD' => 'GD',
						'ImageMagick' => 'ImageMagick',
						'ImageMagick Cmdline' => 'ImageMagick Cmdline',
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
	$tagging = $tagging;
	if(!$tagging) $tagging = "enabled";
	$form_body .= '<p class="admin_debug">' . elgg_view("input/checkboxes", array('options' => array(elgg_echo('tidypics:settings:tagging') => true), 'internalname' => 'tagging', 'value' => ($tagging=='enabled' ? true : false) )) . "</p>";

	// Download Link
	$download_link = $download_link;
	if(!$download_link) $download_link = "enabled";
	$form_body .= '<p class="admin_debug">' . elgg_view("input/checkboxes", array('options' => array(elgg_echo('tidypics:settings:download_link') => true), 'internalname' => 'download_link', 'value' => ($download_link=='enabled' ? true : false) )) . "</p>";

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



	$form_body .= elgg_view('input/submit', array('value' => elgg_echo("save")));
	
	echo elgg_view('input/form', array('action' => $action, 'body' => $form_body));