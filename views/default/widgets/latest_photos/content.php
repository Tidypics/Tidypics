<?php
/**
 * Display the latest photos uploaded by an individual
 */

echo elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'image',
	'limit' => $vars['entity']->num_display,
	'owner_guid' => elgg_get_page_owner_guid(),
	'full_view' => false,
	'list_type' => 'gallery',
	'list_type_toggle' => false,
	'gallery_class' => 'tidypics-gallery-widget',
));
