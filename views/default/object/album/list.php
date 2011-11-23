<?php
/**
 * Display an album as an item in a list
 *
 * @uses $vars['entity'] TidypicsAlbum
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$album = elgg_extract('entity', $vars);
$owner = $album->getOwnerEntity();

$owner_link = elgg_view('output/url', array(
	'href' => "photos/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($album->time_created);
$categories = elgg_view('output/categories', $vars);

$subtitle = "$author_text $date $categories";

$title = elgg_view('output/url', array(
	'text' => $album->getTitle(),
	'href' => $album->getURL(),
));

$params = array(
	'entity' => $album,
	'title' => $title,
	'metadata' => null,
	'subtitle' => $subtitle,
	'tags' => elgg_view('output/tags', array('tags' => $album->tags)),
);
$params = $params + $vars;
$summary = elgg_view('object/elements/summary', $params);

$cover = elgg_view('output/img', array(
	'src' => $album->getCoverImageURL('thumb'),
	'alt' => $album->getTitle(),
	'class' => 'elgg-photo',
));
$icon = elgg_view('output/url', array(
	'text' => $cover,
	'href' => $album->getURL(),
	'encode_text' => false,
	'is_trusted' => true,
));

echo $header = elgg_view_image_block($icon, $summary);
