<?php
/**
 * View the tags for this image
 *
 * @uses $vars['entity']
 */

$tags = $vars['entity']->getPhotoTags();
foreach ($tags as $tag) {
	echo elgg_view('photos/tagging/tag', array('tag' => $tag));
}
