<?php
/**
 * Album river view
 */

$album = $vars['item']->getObjectEntity();

$album_river_view = elgg_get_plugin_setting('album_river_view', 'tidypics');
if ($album_river_view == "cover") {
	$image = $album->getCoverImage();
	if ($image) {
		$attachments = elgg_view('output/img', array(
			'src' => $image->getSrcUrl('thumb'),
		));
	}
} else {
	$images = $album->getImages(7);

	if (count($images)) {
		$attachments = '<ul>';
		foreach($images as $image) {
			$attachments .= '<li>';
			$attachments .= elgg_view('output/img', array(
				'src' => $image->getSrcUrl('thumb'),
			));
			$attachments .= '</li>';
		}
		$attachments .= '</ul>';
	}
}

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'attachments' => $attachments,
));
