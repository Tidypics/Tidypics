<?php
/**
 * Album RSS view
 *
 * @uses $vars['entity'] TidypicsAlbum
 */


$full_view = elgg_extract('full_view', $vars, false);

if ($full_view) {
	echo elgg_view('object/album/full', $vars);
} else {
	echo elgg_view('object/album/summary', $vars);
}
