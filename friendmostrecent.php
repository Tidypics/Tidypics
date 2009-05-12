<?php
	/**
	 * Tidypics Friends Albums Listing
	 * 
	 */

	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	if (is_null(page_owner_entity()->name) || page_owner_entity()->name == '') {
		$friendname = get_input('username');
	} else {
		$friendname = page_owner_entity()->name;
	};
	
	//there has to be a better way to do this
	if(!$friendname) {
		$page = get_input("page");
		list($pagename, $friendname) = split("/", $page);
	}
	$user = get_user_by_username($friendname);
	
	global $CONFIG;
	$prefix = $CONFIG->dbprefix;
	$max = 24;
	//grab the top views (metadata 'tp_views') for $max number of entities 
	//ignores entity subtypes
	
	$sql = "SELECT ent.guid as entity_guid FROM " . $prefix . "entities ent
			INNER JOIN " . $prefix . "entity_subtypes sub ON ent.subtype = sub.id AND sub.subtype = 'image'
			WHERE ent.owner_guid = " . $user->guid . "
			ORDER BY ent.guid DESC
			LIMIT $max";
	$result = get_data($sql);
	$entities = array();
	foreach($result as $entity) {
		$entities[] = get_entity($entity->entity_guid);
	}
	
	$title = sprintf(elgg_echo("tidypics:friendmostrecent"), $friendname);
	$area2 = elgg_view_title($title);
	$area2 .= elgg_view_entity_list($entities, $max, 0, $max);
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);
	page_draw($title, $body);

?>