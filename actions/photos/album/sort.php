<?php
/**
 * Sorting album action - takes a comma separated list of image guids
 */

$album_guid = get_input('album_guid');
$album = get_entity($album_guid);
if (!$album) {
	
}

$guids = get_input('guids');
$guids = explode(',', $guids);

$album->setImageList($guids);

system_message(elgg_echo('tidypics:album:sorted', array($album->getTitle())));
forward($album->getURL());