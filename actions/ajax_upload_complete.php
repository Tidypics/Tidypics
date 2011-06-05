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
	$new_album = true;
} else {
	$new_album = false;
}

if ($album->new_album == TP_NEW_ALBUM) {
	$album->new_album = TP_OLD_ALBUM;

	// we throw the notification manually here so users are not told about the new album until there
	// is at least a few photos in it
	object_notifications('create', 'object', $album);

	add_to_river('river/object/album/create', 'create', $album->owner_guid, $album->guid);
}

$params = array(
	'type'            => 'object',
	'subtype'         => 'image',
	'metadata_names'  => 'batch',
	'metadata_values' => get_input('batch'),
);
$images = elgg_get_entities_from_metadata($params);
if ($images) {
	// Create a new batch object to contain these photos
	$batch = new ElggObject();
	$batch->subtype = "tidypics_batch";
	$batch->access_id = ACCESS_PUBLIC;
	$batch->container_guid = $album->guid;
	if ($batch->save()) {
		foreach ($images as $image) {
			add_entity_relationship($image->guid, "belongs_to_batch", $batch->getGUID());
		}
		if (get_plugin_setting('img_river_view', 'tidypics') == "batch" && $new_album == false) {
			add_to_river('river/object/tidypics_batch/create', 'create', $batch->getObjectOwnerGUID(), $batch->getGUID());
		}
	}
}

// plugins can register to be told when a Tidypics album has had images added
trigger_elgg_event('upload', 'tp_album', $album);

exit;