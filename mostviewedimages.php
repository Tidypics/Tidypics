<?php

	/**
	 * Tidypics full view of an image
	 * Given a GUID, this page will try and display any entity
	 * 
	 */

	// Load Elgg engine
	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	global $CONFIG;
	$prefix = $CONFIG->dbprefix;
	$max = 24;
	//grab the top views (metadata 'tp_views') for $max number of entities 
	//ignores entity subtypes
	$sql = "select md.entity_guid, md.owner_guid, md.enabled, ms.string as views from " . $prefix . "metadata md
			inner join " . $prefix . "metastrings ms on md.value_id = ms.id
			inner join " . $prefix . "metastrings ms2 on md.name_id = ms2.id and ms2.string = 'tp_views'
			order by views desc LIMIT $max";
	
	$result = get_data($sql);

	$entities = array();
	foreach($result as $entity) {
		$entities[] = get_entity($entity->entity_guid);
	}
	
	$title = "Most viewed images";
	$area2 = elgg_view_title($title);
	$area2 .= elgg_view_entity_list($entities, $max, 0, $max);
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);
	page_draw($title, $body);
?>