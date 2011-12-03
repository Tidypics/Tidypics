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
		$attachments = '<ul class="tidypics-river-list">';
		foreach($images as $image) {
			$attachments .= '<li class="tidypics-photo-item">';
			$attachments .= elgg_view('output/img', array(
				'src' => $image->getSrcUrl('thumb'),
				'class' => 'elgg-photo',
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
