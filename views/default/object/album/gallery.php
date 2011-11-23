<?php
/**
 * Summary of an album for lists/galleries
 *
 * @uses $vars['entity'] TidypicsAlbum
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$album = elgg_extract('entity', $vars);

$album_cover = elgg_view('output/img', array(
	'src' => $album->getCoverImageURL(),
	'alt' => $album->getTitle(),
	'class' => 'elgg-photo',
));

$header = elgg_view('output/url', array(
	'text' => $album->getTitle(),
	'href' => $album->getURL(),
));

$body = elgg_view('output/url', array(
	'text' => $album_cover,
	'href' => $album->getURL(),
	'encode_text' => false,
	'is_trusted' => true,
));

$footer = elgg_view('output/url', array(
	'text' => $album->getContainerEntity()->name,
	'href' => $album->getContainerEntity()->getURL(),
	'is_trusted' => true,
));
$footer .= '<div class="elgg-subtext">' . elgg_echo('album:num', array($album->getSize())) . '</div>';

$params = array(
	'footer' => $footer,
);
echo elgg_view_module('tidypics-album', $header, $body, $params);
