<?php
	/**
	 * Tidypics Friends Albums Listing
	 * 
	 */

	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	global $CONFIG;
	$viewer = get_loggedin_user();
	$prefix = $CONFIG->dbprefix;
	$max = 24;
	//grab the top views (metadata 'tp_views') for $max number of entities 
	//ignores entity subtypes
	
	$sql = "SELECT ent.guid as entity_guid FROM " . $prefix . "entities ent
			INNER JOIN " . $prefix . "entity_subtypes sub ON ent.subtype = sub.id AND sub.subtype = 'image'
			WHERE ent.owner_guid = " . $viewer->guid . "
			ORDER BY ent.guid DESC
			LIMIT $max";
	
	$result = get_data($sql);
	$entities = array();
	foreach($result as $entity) {
		$entities[] = get_entity($entity->entity_guid);
	}
	
	$title = elgg_echo("tidypics:yourmostrecent");
	$area2 = elgg_view_title($title);
	$area2 .= elgg_view_entity_list($entities, $max, 0, $max);
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);
	page_draw($title, $body);

?>