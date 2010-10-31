<?php

$performed_by = get_entity($vars['item']->subject_guid);
$batch = get_entity($vars['item']->object_guid);
$album = get_entity($batch->container_guid);

if (!$batch || !$album) {
	return true;
}

// Get images related to this batch
$images = elgg_get_entities_from_relationship(array(
			'relationship' => 'belongs_to_batch',
			'relationship_guid' => $batch->getGUID(),
			'inverse_relationship' => true,
			'types' => array('object'),
			'subtypes' => array('image'),
			'offset' => 0,
		));

// nothing to show
if (!$images) {
	return true;
}

$user_link = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
$album_link = "<a href='" . $album->getURL() . "'>" . $album->title . "</a>";
if (count($images) > 1) {
	$image_text = elgg_echo("image:river:created:multiple");
	$string = sprintf($image_text, $user_link, count($images), $album_link);
} else {
	$image_text = elgg_echo("image:river:created");
	$title = $images[0]->title;
	if (!$title) {
		$title = elgg_echo("untitled");
	}
	$image_link = "<a href=\"" . $images[0]->getURL() . "\">" . $title . "</a>";
	$string = sprintf($image_text, $user_link, $image_link, $album_link);
}

$string .= "<div class=\"river_content\">";

if (count($images)) {
	foreach($images as $image) {
		$string .= "<a href=\"" . $image->getURL() . "\"> <img src=\"" . $CONFIG->wwwroot . 'mod/tidypics/thumbnail.php?file_guid=' . $image->guid . '&size=thumb" class="tidypics_album_cover"  alt="thumbnail"/> </a>';
	}
}

$string .= "</div>";

echo $string;
