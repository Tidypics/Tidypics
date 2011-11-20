<?php
/**
 * Full view of an image
 *
 * @uses $vars['entity'] TidypicsImage
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$image = $photo = $vars['entity'];

$img = elgg_view('output/img', array(
	'src' => $image->getSrcURL('large'),
	'alt' => $image->getTitle(),
	'class' => 'elgg-photo',
));

$content = elgg_view('output/url', array(
	'text' => $img,
	'href' => $image->getURL(),
));

$owner_link = elgg_view('output/url', array(
	'href' => "photos/owner/" . $photo->getOwnerEntity()->username,
	'text' => $photo->getOwnerEntity()->name,
));
$author_text = elgg_echo('byline', array($owner_link));

$owner_icon = elgg_view_entity_icon($photo->getOwnerEntity(), 'tiny');

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'photos',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $categories $comments_link";

$params = array(
	'entity' => $photo,
	'title' => false,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
	'tags' => $tags,
);
$list_body = elgg_view('object/elements/summary', $params);

$params = array('class' => 'mbl');
$summary = elgg_view_image_block($owner_icon, $list_body, $params);

echo $summary;

if ($photo->description) {
	echo elgg_view('output/longtext', array(
		'value' => $photo->description,
		'class' => 'mbl',
	));
}

echo '<div class="tidypics-wrapper-photo">';
echo elgg_view('tidypics/tagging/help');
echo elgg_view('tidypics/tagging/select', array('photo' => $photo));
echo $content;
echo '</div>';

	echo elgg_view_comments($photo);