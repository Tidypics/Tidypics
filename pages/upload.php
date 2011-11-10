<?php
/**
 * Tidypics Upload Images Page
 *
 */

include_once dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php";

global $CONFIG;

// must be logged in to upload images
gatekeeper();

$album_guid = (int) get_input('album_guid');
if (!$album_guid) {
	forward();
}

if (get_plugin_setting('uploader', 'tidypics') != "disabled") {
	$uploader = get_input('uploader', 'ajax');
} else {
	$uploader = 'basic';
}


$album = get_entity($album_guid);

//if album does not exist or user does not have access
if (!$album || !$album->canEdit()) {
	// throw warning and forward to previous page
	forward($_SERVER['HTTP_REFERER']);
}

// set page owner based on container (user or group)
set_page_owner($album->container_guid);

$page_owner = page_owner_entity();
if ($page_owner instanceof ElggGroup) {
	add_submenu_item(	sprintf(elgg_echo('album:group'),$page_owner->name),
			$CONFIG->wwwroot . "pg/photos/owned/" . $page_owner->username);
}

set_context('photos');
$title = elgg_echo('album:addpix') . ': ' . $album->title;
$area2 .= elgg_view_title($title);

if ($uploader == 'basic') {
	$area2 .= elgg_view('input/form', array(
		'action' => "{$CONFIG->wwwroot}action/tidypics/upload",
		'body' => elgg_view('forms/tidypics/basic_upload', array('album' => $album)),
		'internalid' => 'tidypicsUpload',
		'enctype' => 'multipart/form-data',
		'method' => 'post',
	));

} else {
	$area2 .= elgg_view("forms/tidypics/ajax_upload", array('album' => $album));
}

$body = elgg_view_layout('two_column_left_sidebar', '', $area2);

page_draw($title, $body);
