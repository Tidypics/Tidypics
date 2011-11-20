<?php
/**
 * Upload images
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

gatekeeper();

$album_guid = (int) get_input('guid');
if (!$album_guid) {
	// @todo
	forward();
}

if (elgg_get_plugin_setting('uploader', 'tidypics') != "disabled") {
	$uploader = get_input('uploader', 'ajax');
} else {
	$uploader = 'basic';
}

$album = get_entity($album_guid);
if (!$album || !$album->canEdit()) {
	// @todo
	// throw warning and forward to previous page
	forward(REFERER);
}

if (!$album->canEdit()) {
	// @todo have to be able to edit album to upload photos
}

// set page owner based on container (user or group)
elgg_set_page_owner_guid($album->getContainerGUID());
$owner = elgg_get_page_owner_entity();

$title = elgg_echo('album:addpix');

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('photos'), "photos/all");
elgg_push_breadcrumb($owner->name, "photos/owner/$owner->username");
elgg_push_breadcrumb($album->getTitle(), $album->getURL());
elgg_push_breadcrumb(elgg_echo('album:addpix'));


if ($uploader == 'basic') {
	$content = elgg_view('forms/photos/basic_upload', array('entity' => $album));
} else {
	$content = elgg_view('forms/photos/ajax_upload', array('entity' => $album));
}

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
