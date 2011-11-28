<?php
/**
 * Album sort page
 *
 * This displays a listing of all the photos so that they can be sorted
 */

gatekeeper();
group_gatekeeper();

// get the album entity
$album_guid = (int) get_input('guid');
$album = get_entity($album_guid);

// panic if we can't get it
if (!$album) {
	forward();
}

// container should always be set, but just in case
$owner = $album->getContainerEntity();
elgg_set_page_owner_guid($owner->getGUID());

$title = elgg_echo('tidypics:sort', array($album->getTitle()));

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('photos'), 'photos/all');
if (elgg_instanceof($owner, 'group')) {
	elgg_push_breadcrumb($owner->name, "photos/group/$owner->guid/all");
} else {
	elgg_push_breadcrumb($owner->name, "photos/owner/$owner->username");
}
elgg_push_breadcrumb($album->title, $album->getURL());
elgg_push_breadcrumb($title);


$content = elgg_view_form('photos/album/sort', array(), array('album' => $album));

$body = elgg_view_layout('content', array(
	'filter' => false,
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('tidypics/sidebar', array('page' => 'album')),
));

echo elgg_view_page($title, $body);
