<?php

	/**
	 * Tidypics full view of an image
	 * Given a GUID, this page will try and display any entity
	 * 
	 */

	// Load Elgg engine
	include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php";
	
	$viewer = get_loggedin_user();
	
	global $CONFIG;
	$prefix = $CONFIG->dbprefix;
	$max = 24;

	$sql = "SELECT ent.guid, count( * ) AS views
			FROM " . $prefix . "entities ent
			INNER JOIN " . $prefix . "entity_subtypes sub ON ent.subtype = sub.id
			AND sub.subtype = 'image'
			INNER JOIN " . $prefix . "annotations ann1 ON ann1.entity_guid = ent.guid
			INNER JOIN " . $prefix . "metastrings ms ON ms.id = ann1.name_id
			AND ms.string = 'tp_view'
			WHERE ent.owner_guid = " . $viewer->guid . "
			GROUP BY ent.guid
			ORDER BY views DESC
			LIMIT $max";
		
	$result = get_data($sql);

	$entities = array();
	foreach($result as $entity) {
		$entities[] = get_entity($entity->guid);
	}
	
	$title = elgg_echo("tidypics:yourmostviewed");
	$area2 = elgg_view_title($title);
	
	// grab the html to display the images
	$images = tp_view_entity_list($entities, $max, 0, $max, false);
	
	// this view takes care of the title on the main column and the content wrapper
	$area2 = elgg_view('tidypics/content_wrapper', array('title' => $title, 'content' => $images,));
	if( empty( $area2 )) $area2 = $images;
		
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);
	page_draw($title, $body);
?>