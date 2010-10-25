<?php
/**
 * Tidypics Add New Album Action
 *
 */

// Make sure we're logged in 
gatekeeper();

// Get input data
$title = get_input('tidypicstitle');
$body = get_input('tidypicsbody');
$tags = get_input('tidypicstags');
$access = get_input('access_id');
$container_guid = get_input('container_guid', get_loggedin_userid());

// Cache to the session
$_SESSION['tidypicstitle'] = $title;
$_SESSION['tidypicsbody'] = $body;
$_SESSION['tidypicstags'] = $tags;


if (empty($title)) {
	register_error(elgg_echo("album:blank"));
	forward($_SERVER['HTTP_REFERER']);
}

$album = new TidypicsAlbum();

$album->container_guid = $container_guid;
$album->owner_guid = get_loggedin_userid();
$album->access_id = $access;
$album->title = $title;
$album->description = $body;
if ($tags) {
	$album->tags = string_to_tag_array($tags);
}
$album->new_album = TP_NEW_ALBUM;

if (!$album->save()) {
	register_error(elgg_echo("album:error"));
	forward(get_input('forward_url', $_SERVER['HTTP_REFERER']));
}

mkdir(tp_get_img_dir() . $album->guid, 0755, true);

system_message(elgg_echo("album:created"));

// Remove the album post cache
unset($_SESSION['tidypicstitle']);
unset($_SESSION['tidypicsbody']);
unset($_SESSION['tidypicstags']);

// plugins can register to be told when a new Tidypics album has been created
trigger_elgg_event('add', 'tp_album', $album);

forward("pg/photos/upload/" . $album->guid);
