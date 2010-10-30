<?php
/**
 * A batch is complete so check if this is first upload to album
 *
 */

$album_guid = (int) get_input('album_guid');

$album = get_entity($album_guid);
if (!$album) {
	exit;
}

if ($album->new_album == TP_NEW_ALBUM) {
	$album->new_album = TP_OLD_ALBUM;

	// we throw the notification manually here so users are not told about the new album until there
	// is at least a few photos in it
	object_notifications('create', 'object', $album);

	add_to_river('river/object/album/create', 'create', $album->owner_guid, $album->guid);
}

// plugins can register to be told when a Tidypics album has had images added
trigger_elgg_event('upload', 'tp_album', $album);

exit;