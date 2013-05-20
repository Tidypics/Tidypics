<?php

$tagger = $vars['item']->getSubjectEntity();
$tagger_link = elgg_view('output/url', array(
	'href' => $tagger->getURL(),
	'text' => $tagger->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

$annotation = elgg_get_annotation_from_id($vars['item']->annotation_id);
if ($annotation) {
	$image = get_entity($annotation->entity_guid);

	// viewer may not have permission to view image
	if (!$image) {
		return;
	}
}

$tag = unserialize($annotation->value);
if ($tag->type != 'user') {
	return;
}
$tagged = get_entity($tag->value);
if (!elgg_instanceof($tagged,'user')) {
	return;
}

$image_link = elgg_view('output/url', array(
	'href' => $image->getURL(),
	'text' => $image->getTitle(),
	'is_trusted' => true,
));

$attachments = elgg_view_entity_icon($image, 'tiny');

$tagged_link = elgg_view('output/url', array(
	'href' => $tagged->getURL(),
	'text' => $tagged->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'attachments' => $attachments,
	'summary' => elgg_echo('image:river:tagged', array($tagger_link, $tagged_link, $image_link)),
));
