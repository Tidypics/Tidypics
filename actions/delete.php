<?php

/**
 * Tidypics Delete Action for Images and Albums
 *
 */

// must be logged in
gatekeeper();

$forward_url = 'pg/photos/world'; // by default forward to world photos

$guid = (int) get_input('guid');

$entity = get_entity($guid);
if (!$entity) {
	// unable to get Elgg entity
	register_error(elgg_echo("tidypics:deletefailed"));
	forward($forward_url);
}

if (!$entity->canEdit()) {
	// user doesn't have permissions
	register_error(elgg_echo("tidypics:deletefailed"));
	forward($forward_url);
}

$subtype = $entity->getSubtype();
$container = get_entity($entity->container_guid);

if ($subtype != 'image' && $subtype != 'album') {
	// how did we even get here?
	register_error(elgg_echo("tidypics:deletefailed"));
	forward($forward_url);
}

if ($subtype == 'image') {
	//forward back to album after deleting pictures
	$forward_url = $container->getURL();

	// plugins can register to be told when a Tidypics image has been deleted
	trigger_elgg_event('delete', 'tp_image', $entity);
} else {
	// forward to this person's albums
	$forward_url = 'pg/photos/owned/' . $container->username;

	// plugins can register to be told when a Tidypics album has been deleted
	trigger_elgg_event('delete', 'tp_album', $entity);
}


if ($entity->delete()) {
	system_message(elgg_echo("tidypics:deleted"));
} else {
	register_error(elgg_echo("tidypics:deletefailed"));
}

forward($forward_url);
