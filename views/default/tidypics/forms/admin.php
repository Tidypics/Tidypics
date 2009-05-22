<?php
	/**
	* Tidypics admin settings form
	*/

	// to do
	// 1. set action and code it
	// 2. figure out how to load all values since they won't be available in $vars[] by default
	
	
	$action = $vars['url'];// . "action/";
	
	$image_lib = $vars['entity']->image_lib;
	if (!$image_lib) $image_lib = 'GD';

	$form_body = 'Not functional!!!!!!!  <p>' . elgg_echo('tidypics:image_lib');
	
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
	
	
	$form_body .= "<p>" . elgg_view("input/checkboxes", array('options' => array('Enable Tagging' => true), 'internalname' => 'tagging', 'value' => ($vars['config']->tagging ? true : false) )) . "</p>";
	
	$form_body .= "<p>" . elgg_view("input/checkboxes", array('options' => array('Enable Download Link' => true), 'internalname' => 'download', 'value' => ($vars['config']->download ? true : false) )) . "</p>";
	

	$form_body .= "<p>" . elgg_echo('watermark') . "<br />";
	$form_body .= elgg_view("input/text",array('internalname' => 'watermark', 'value' => $watermark)) . "</p>";


	$form_body .= elgg_view('input/submit', array('value' => elgg_echo("save")));
	
	echo elgg_view('input/form', array('action' => $action, 'body' => $form_body));