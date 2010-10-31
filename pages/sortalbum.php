<?php
/**
 * Tidypics Album Sort Page
 *
 * This displays a listing of all the photos so that they can be sorted
 */

// if this page belongs to a closed group, prevent anyone outside group from seeing
if (is_callable('group_gatekeeper')) {
	group_gatekeeper();
}

// get the album entity
$album_guid = (int) get_input('guid');
$album = get_entity($album_guid);

// panic if we can't get it
if (!$album) {
	forward();
}

// container should always be set, but just in case
if ($album->container_guid) {
	set_page_owner($album->container_guid);
} else {
	set_page_owner($album->owner_guid);
}

$owner = page_owner_entity();

$title = sprintf(elgg_echo('tidypics:sort'), $album->title);

$content = elgg_view_title($title);
$content .= elgg_view('tidypics/sort', array('album' => $album));

$body = elgg_view_layout('two_column_left_sidebar', '', $content);

page_draw($title, $body);
