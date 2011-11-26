<?php
/**
 *
 */

$options = array(
	'type' => 'object',
	'subtype' => 'album',
	'container_guid' => elgg_get_page_owner_guid(),
	'limit' => $vars['entity']->num_display,
	'full_view' => false,
	'pagination' => false,
);
echo elgg_list_entities($options);
