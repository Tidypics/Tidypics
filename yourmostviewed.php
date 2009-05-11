<?php

	/**
	 * Tidypics full view of an image
	 * Given a GUID, this page will try and display any entity
	 * 
	 */

	// Load Elgg engine
	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	$viewer = get_loggedin_user();
	
	$prefix = "my_elgg"; //how do you get the global default?
	$max = 24;
	//grab the top views (metadata 'tp_views') for $max number of entities 
	//ignores entity subtypes
	$sql = "SELECT md.entity_guid, md.owner_guid, md.enabled, ms.string AS views from " . $prefix . "entities ent
			INNER JOIN " . $prefix . "metadata md ON md.entity_guid = ent.guid 
			INNER JOIN " . $prefix . "metastrings ms ON md.value_id = ms.id
			INNER JOIN " . $prefix . "metastrings ms2 ON md.name_id = ms2.id AND ms2.string = 'tp_views'
			WHERE ent.owner_guid = " . $viewer->guid . "
			ORDER BY views DESC LIMIT $max";
	
	$result = get_data($sql);

	$entities = array();
	foreach($result as $entity) {
		$entities[] = get_entity($entity->entity_guid);
	}
	
	$title = elgg_echo("tidypics:yourmostviewed");
	$area2 = elgg_view_title($title);
	$area2 .= elgg_view_entity_list($entities, $max, 0, $max);
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);
	page_draw($title, $body);
?>