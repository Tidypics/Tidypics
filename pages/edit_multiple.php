<?php
/**
 * Tidypics: Edit the properties of multiple images
 *
 * Called after upload only
 */

include_once dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php";

gatekeeper();
set_context('photos');

set_page_owner(get_loggedin_userid());


$batch = get_input('batch');
if ($batch) {
	$images = elgg_get_entities_from_metadata(array(
		'metadata_name' => 'batch',
		'metadata_value' => $batch,
		'type' => 'object',
		'subtype' => 'image',
		'owner_guid' => get_loggedin_userid(),
		'limit' => ELGG_ENTITIES_NO_VALUE,
	));
} else {
	// parse out photo guids
	$file_string = get_input('files');
	$file_array_sent = explode('-', $file_string);

	$images = array();
	foreach ($file_array_sent as $file_guid) {
		if ($entity = get_entity($file_guid)) {
			if ($entity->canEdit()) {
				array_push($images, $entity);
			}
		}
	}
}

if (!$images) {
	forward($_SERVER['HTTP_REFERER']);
}


$title = elgg_echo('tidypics:editprops');

$content .= elgg_view_title($title);
$content .= elgg_view("tidypics/forms/edit_multi", array('images' => $images));

$body = elgg_view_layout('two_column_left_sidebar', '', $content);
page_draw($title, $body);
