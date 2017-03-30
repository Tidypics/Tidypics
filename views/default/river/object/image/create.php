<?php
/**
 * Image album view
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$subject = $vars['item']->getSubjectEntity();
$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

$image = $vars['item']->getObjectEntity();
$attachments = elgg_view_entity_icon($image, 'tiny');

$image_link = elgg_view('output/url', array(
	'href' => $image->getURL(),
	'text' => $image->getTitle(),
	'is_trusted' => true,
));

if ($image->getContainerEntity() instanceof TidypicsAlbum) {
	$album_link = elgg_view('output/url', array(
		'href' => $image->getContainerEntity()->getURL(),
		'text' => $image->getContainerEntity()->getTitle(),
		'is_trusted' => true,
	));
} else {
	$album_link = $image_link;
}

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'attachments' => $attachments,
	'summary' => elgg_echo('image:river:created', array($subject_link, $image_link, $album_link)),
));
