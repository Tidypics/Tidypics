<?php
/**
 * Image album view
 */

$subject = $vars['item']->getSubjectEntity();
$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

$image = $vars['item']->getObjectEntity();
$attachments = elgg_view('output/img', array(
	'src' => $image->getSrcUrl('thumb'),
	'class' => 'elgg-photo',
));
$image_link = elgg_view('output/url', array(
	'href' => $image->getURL(),
	'text' => $image->getTitle(),
	'is_trusted' => true,
));

$album_link = elgg_view('output/url', array(
	'href' => $image->getContainerEntity()->getURL(),
	'text' => $image->getContainerEntity()->getTitle(),
	'is_trusted' => true,
));

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'attachments' => $attachments,
	'summary' => elgg_echo('image:river:created', array($subject_link, $image_link, $album_link)),
));
