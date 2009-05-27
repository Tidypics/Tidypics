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
	
	$image_lib = $plugin->image_lib;
	if (!$image_lib) $image_lib = 'GD';

	// Image Library
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

	// Tagging
	$form_body .= '<p class="admin_debug">' . elgg_view("input/checkboxes", array('options' => array(elgg_echo('tidypics:settings:tagging') => true), 'internalname' => 'tagging', 'value' => ($plugin->tagging ? true : false) )) . "</p>";

	// Download Link
	$form_body .= '<p class="admin_debug">' . elgg_view("input/checkboxes", array('options' => array(elgg_echo('tidypics:settings:download') => true), 'internalname' => 'download_link', 'value' => ($plugin->download_link ? true : false) )) . "</p>";

	// Watermark Text
	$form_body .= "<p>" . elgg_echo('tidypics:settings:watermark') . "<br />";
	$form_body .= elgg_view("input/text",array('internalname' => 'params[watermark_text]', 'value' => $plugin->$watermark_text)) . "</p>";

	// Max Image Size
	$form_body .= "<p>" . elgg_echo('tidypics:settings:img_size') . "<br />";
	$form_body .= elgg_view("input/text",array('internalname' => 'params[maxfilesize]', 'value' => $plugin->$maxfilesize)) . "</p>";

	// Thumbnail sizes



	$form_body .= elgg_view('input/submit', array('value' => elgg_echo("save")));
	
	echo elgg_view('input/form', array('action' => $action, 'body' => $form_body));