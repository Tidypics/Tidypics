<?php
/**
 * View an image
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

group_gatekeeper();

// get the photo entity
$photo_guid = (int) get_input('guid');
$photo = get_entity($photo_guid);
if (!$photo) {

}

$photo->addView();

// set page owner based on owner of photo album
$album = $photo->getContainerEntity();
if ($album) {
	elgg_set_page_owner_guid($album->getContainerGUID());
}
$owner = elgg_get_page_owner_entity();

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('photos'), 'photos/all');
if (elgg_instanceof($owner, 'group')) {
	elgg_push_breadcrumb($owner->name, "photos/group/$owner->guid/all");
} else {
	elgg_push_breadcrumb($owner->name, "photos/owner/$owner->username");
}
elgg_push_breadcrumb($album->title, $album->getURL());
elgg_push_breadcrumb($photo->title);

// add download button to title menu
if (get_plugin_setting('download_link', 'tidypics') != "disabled") {
elgg_register_menu_item('title', array(
	'name' => 'download',
	'href' => "photos/download/$photo_guid",
	'text' => elgg_echo('image:download'),
	'link_class' => 'elgg-button elgg-button-action',
));
} 


$content = elgg_view_entity($photo, array('full_view' => true));

$body = elgg_view_layout('content', array(
	'filter' => false,
	'content' => $content,
	'title' => $photo->title,
	'sidebar' => elgg_view('tidypics/sidebar', array(
		'page' => 'view',
		'image' => $photo,
	)),
));

echo elgg_view_page($photo->title, $body);
