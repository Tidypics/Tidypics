<?php
	/**
	* Tidypics admin settings form
	*/

	
	
	$action = $vars['url'] . 'action/tidypics/settings';
	
	$plugin = find_plugin_settings('tidypics');
	
	
	// bootstrap the plugin version here for now
	if (!$plugin->version) {
		set_plugin_setting('version', 1.62, 'tidypics');
	}
	
	if (extension_loaded('imagick'))
		$img_lib_options['ImageMagickPHP'] = 'imagick PHP extension';
		
	$disablefunc = explode(',', ini_get('disable_functions'));
	if (is_callable('exec') && !in_array('exec',$disablefunc))
		$img_lib_options['ImageMagick'] = 'ImageMagick Cmdline';

	$img_lib_options['GD'] = 'GD';


	// Image Library
	$image_lib = $plugin->image_lib;
	if (!$image_lib) $image_lib = 'GD';
	$form_body = '<p>' . elgg_echo('tidypics:settings:image_lib') . ': ';
	$form_body .= elgg_view('input/pulldown', array(
					'internalname' => 'params[image_lib]',
					'options_values' => $img_lib_options,
					'value' => $image_lib
	));
	$form_body .= '<br/>Note: If you want to select ImageMagick Command Line, first confirm that it is installed on your server.</p>';

	if (is_callable('exec') && !in_array('exec',$disablefunc)) {
		// Image Magick Path
		$im_path = $plugin->im_path;
		if(!$im_path) $im_path = "/usr/bin/";
		$form_body .= "<p>" . elgg_echo('tidypics:settings:im_path') . "<br />";
		$form_body .= elgg_view("input/text",array('internalname' => 'params[im_path]', 'value' => $im_path)) . "</p>";
	}

	// Tagging
	$tagging = $plugin->tagging;
	if(!$tagging) $tagging = "enabled";
	$form_body .= '<p class="admin_debug">' . elgg_view("input/checkboxes", array('options' => array(elgg_echo('tidypics:settings:tagging') => 'enabled'), 'internalname' => 'tagging', 'value' => $tagging )) . "</p>";

	// Download Link
	$download_link = $plugin->download_link;
	if(!$download_link) $download_link = "enabled";
	$form_body .= '<p class="admin_debug">' . elgg_view("input/checkboxes", array('options' => array(elgg_echo('tidypics:settings:download_link') => 'enabled'), 'internalname' => 'download_link', 'value' => $download_link )) . "</p>";

	// Ratings
	$photo_ratings = $plugin->photo_ratings;
	if(!$photo_ratings) $photo_ratings = "disabled";
	$form_body .= '<p class="admin_debug">' . elgg_view("input/checkboxes", array('options' => array(elgg_echo('tidypics:settings:photo_ratings') => 'enabled'), 'internalname' => 'photo_ratings', 'value' => $photo_ratings )) . "</p>";

	// Show EXIF
	$exif = $plugin->exif;
	if(!$exif) $exif = "disabled";
	$form_body .= '<p class="admin_debug">' . elgg_view("input/checkboxes", array('options' => array(elgg_echo('tidypics:settings:exif') => 'enabled'), 'internalname' => 'exif', 'value' => $exif )) . "</p>";

	// Show View count
	$view_count = $plugin->view_count;
	if(!$view_count) $view_count = "enabled";
	$form_body .= '<p class="admin_debug">' . elgg_view("input/checkboxes", array('options' => array(elgg_echo('tidypics:settings:view_count') => 'enabled'), 'internalname' => 'view_count', 'value' => $view_count )) . "</p>";

	// Watermark Text
	$form_body .= "<p>" . elgg_echo('tidypics:settings:watermark') . "<br />";
	$form_body .= elgg_view("input/text",array('internalname' => 'params[watermark_text]', 'value' => $plugin->watermark_text)) . "</p>";

	// Max Image Size
	$maxfilesize = $plugin->maxfilesize;
	if (!$maxfilesize) $maxfilesize = (int)5; // 5 MB
	$form_body .= "<p>" . elgg_echo('tidypics:settings:maxfilesize') . "<br />";
	$form_body .= elgg_view("input/text",array('internalname' => 'params[maxfilesize]', 'value' => $maxfilesize)) . "</p>";

	// Quota Size
	$quota = $plugin->quota;
	if (!$quota) $quota = 0;
	$form_body .= "<p>" . elgg_echo('tidypics:settings:quota') . "<br />";
	$form_body .= elgg_view("input/text",array('internalname' => 'params[quota]', 'value' => $quota)) . "</p>";

	// River Image options
	$img_river_view = $plugin->img_river_view;
	if (!$img_river_view) $img_river_view = '1';
	$form_body .= '<p>' . elgg_echo('tidypics:settings:img_river_view');
	$form_body .= elgg_view('input/pulldown', array(
					'internalname' => 'params[img_river_view]',
					'options_values' => array(
						'all' => 'all',
						'1' => '1',
						'none' => 'none',
					),
					'value' => $img_river_view
	));
	$form_body .= '</p>';

	// River Album options
	$album_river_view = $plugin->album_river_view;
	if (!$album_river_view) $album_river_view = 'set';
	$form_body .= '<p>' . elgg_echo('tidypics:settings:album_river_view');
	$form_body .= elgg_view('input/pulldown', array(
					'internalname' => 'params[album_river_view]',
					'options_values' => array(
						'cover' => 'cover',
						'set' => 'set',
					),
					'value' => $album_river_view
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


	// Group permission override
	$grp_perm_override = $plugin->grp_perm_override;
	if(!$grp_perm_override) $grp_perm_override = "enabled";
	$form_body .= '<p class="admin_debug">' . elgg_view("input/checkboxes", array('options' => array(elgg_echo('tidypics:settings:grp_perm_override') => 'enabled'), 'internalname' => 'grp_perm_override', 'value' => $grp_perm_override )) . "</p>";

	$form_body .= elgg_view('input/submit', array('value' => elgg_echo("save")));
	
	echo elgg_view('input/form', array('action' => $action, 'body' => $form_body));
