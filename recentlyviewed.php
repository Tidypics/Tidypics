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
	$max_limit = 200; //get extra because you'll have multiple views per image in the result set
	$max = 16; //controls how many actually show on screen
	
	//this works but is wildly inefficient
	//$annotations = get_annotations(0, "object", "image", "tp_view", "", "", 5000);
	
	$sql = "SELECT distinct ent.guid, ann1.time_created
			FROM " . $prefix . "entities ent
			INNER JOIN " . $prefix . "entity_subtypes sub ON ent.subtype = sub.id
			AND sub.subtype = 'image'
			INNER JOIN " . $prefix . "annotations ann1 ON ann1.entity_guid = ent.guid
			INNER JOIN " . $prefix . "metastrings ms ON ms.id = ann1.name_id
			AND ms.string = 'tp_view'
			ORDER BY ann1.id DESC
			LIMIT $max_limit";
	
	$result = get_data($sql);

	$entities = array();
	foreach($result as $entity) {
		if(!$entities[$entity->guid]) {
			$entities[$entity->guid] = get_entity($entity->guid);	
		}
		if(count($entities) >= $max) break;
	}
	
	$title = elgg_echo("tidypics:recentlyviewed");
	$area2 = elgg_view_title($title);
	$area2 .= elgg_view_entity_list($entities, $max, 0, $max);
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);
	page_draw($title, $body);
?>