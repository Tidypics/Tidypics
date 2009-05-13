<?php
	/**
	 * Tidypics Friends Albums Listing
	 * 
	 */

	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	//if no friends were requested, see world pictures instead, or redirect to user's friends
/*	if (is_null(get_input('username')) || get_input('username')=='') {
		if (!isloggedin()) {
			forward('pg/photos/world');
		} else {
			forward('pg/photos/friends/' . $_SESSION['user']->username);
		}
	}*/

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
	$sql = "SELECT md.entity_guid, md.owner_guid, md.enabled, ms.string AS views from " . $prefix . "entities ent
			INNER JOIN " . $prefix . "metadata md ON md.entity_guid = ent.guid 
			INNER JOIN " . $prefix . "metastrings ms ON md.value_id = ms.id
			INNER JOIN " . $prefix . "metastrings ms2 ON md.name_id = ms2.id AND ms2.string = 'tp_views'
			WHERE ent.owner_guid = " . $user->guid . "
			ORDER BY (views+0) DESC LIMIT $max";
	
	$result = get_data($sql);

	$entities = array();
	foreach($result as $entity) {
		$entities[] = get_entity($entity->entity_guid);
	}
	
	$title = sprintf(elgg_echo("tidypics:friendmostviewed"), $friendname);
	$area2 = elgg_view_title($title);
	$area2 .= elgg_view_entity_list($entities, $max, 0, $max);
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);
	page_draw($title, $body);

?>