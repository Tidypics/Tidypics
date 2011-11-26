<?php
/**
 * List photos in an album for RSS
 *
 * @uses $vars['entity'] TidypicsAlbum
 */

$limit = (int)get_input('limit', 20);

echo elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'image',
	'container_guid' => $vars['entity']->getGUID(),
	'limit' => $limit,
	'full_view' => false,
));
