<?php
/**
 * Elgg tidypics library of common functions
 *
 * @package TidypicsCommon
 */

/**
 * Get images for display on front page
 *
 * @param int number of images
 * @param int (optional) guid of owner
 * @return string of html for display
 *
 * To use with the custom index plugin, use something like this:
	
 if (is_plugin_enabled('tidypics')) {
 ?>
 <!-- display latest photos -->
 <div class="index_box">
	<h2><a href="<?php echo $vars['url']; ?>pg/photos/world/"><?php echo elgg_echo("tidypics:mostrecent"); ?></a></h2>
	<div class="contentWrapper">
 <?php
 echo tp_get_latest_photos(5);
 ?>
	</div>
 </div>
 <?php
 }
 ?>

 * Good luck
 */
function tp_get_latest_photos($num_images, $owner_guid = 0, $context = 'front') {
	$prev_context = get_context();
	set_context($context);
	$image_html = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'image',
		'owner_guid' => $owner_guid,
		'limit' => $num_images,
		'full_view' => false,
		'pagination' => false,
	));
	set_context($prev_context);
	return $image_html;
}


/**
 * Get image directory path
 *
 * Each album gets a subdirectory based on its container id
 *
 * @return string	path to image directory
 */
function tp_get_img_dir() {
	$file = new ElggFile();
	return $file->getFilenameOnFilestore() . 'image/';
}

function tidypics_prepare_form_vars($entity = null) {
	// input names => defaults
	$values = array(
		'title' => '',
		'description' => '',
		'access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'entity' => $entity,
	);

	if ($entity) {
		foreach (array_keys($values) as $field) {
			if (isset($entity->$field)) {
				$values[$field] = $entity->$field;
			}
		}
	}

	if (elgg_is_sticky_form('tidypics')) {
		$sticky_values = elgg_get_sticky_values('tidypics');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('tidypics');

	return $values;
}

function tidypics_get_image_libraries() {
	$options = array();
	if (extension_loaded('gd')) {
		$options['GD'] = 'GD';
	}

	if (extension_loaded('imagick')) {
		$options['ImageMagickPHP'] = 'imagick PHP extension';
	}

	$disablefunc = explode(',', ini_get('disable_functions'));
	if (is_callable('exec') && !in_array('exec', $disablefunc)) {
		$options['ImageMagick'] = 'ImageMagick executable';
	}

	return $options;
}

/*********************************************************************
 * the functions below replace broken core functions or add functions 
 * that could/should exist in the core
 */

function tp_view_entity_list($entities, $count, $offset, $limit, $fullview = true, $viewtypetoggle = false, $pagination = true) {
	$context = get_context();

	$html = elgg_view('tidypics/gallery',array(
			'entities' => $entities,
			'count' => $count,
			'offset' => $offset,
			'limit' => $limit,
			'baseurl' => $_SERVER['REQUEST_URI'],
			'fullview' => $fullview,
			'context' => $context,
			'viewtypetoggle' => $viewtypetoggle,
			'viewtype' => get_input('search_viewtype','list'),
			'pagination' => $pagination
	));

	return $html;
}

function tp_get_entities_from_annotations_calculate_x($sum = "sum", $entity_type = "", $entity_subtype = "", $name = "", $mdname = '', $mdvalue = '', $owner_guid = 0, $limit = 10, $offset = 0, $orderdir = 'desc', $count = false) {
	global $CONFIG;

	$sum = sanitise_string($sum);
	$entity_type = sanitise_string($entity_type);
	$entity_subtype = get_subtype_id($entity_type, $entity_subtype);
	$name = get_metastring_id($name);
	$limit = (int) $limit;
	$offset = (int) $offset;
	$owner_guid = (int) $owner_guid;
	if (!empty($mdname) && !empty($mdvalue)) {
		$meta_n = get_metastring_id($mdname);
		$meta_v = get_metastring_id($mdvalue);
	}

	if (empty($name)) return 0;

	$where = array();

	if ($entity_type!="")
		$where[] = "e.type='$entity_type'";
	if ($owner_guid > 0)
		$where[] = "e.owner_guid = $owner_guid";
	if ($entity_subtype)
		$where[] = "e.subtype=$entity_subtype";
	if ($name!="")
		$where[] = "a.name_id='$name'";

	if (!empty($mdname) && !empty($mdvalue)) {
		if ($mdname!="")
			$where[] = "m.name_id='$meta_n'";
		if ($mdvalue!="")
			$where[] = "m.value_id='$meta_v'";
	}

	if ($sum != "count")
		$where[] = "a.value_type='integer'"; // Limit on integer types

	if (!$count) {
		$query = "SELECT distinct e.*, $sum(ms.string) as sum ";
	} else {
		$query = "SELECT count(distinct e.guid) as num, $sum(ms.string) as sum ";
	}
	$query .= " from {$CONFIG->dbprefix}entities e JOIN {$CONFIG->dbprefix}annotations a on a.entity_guid = e.guid JOIN {$CONFIG->dbprefix}metastrings ms on a.value_id=ms.id ";

	if (!empty($mdname) && !empty($mdvalue)) {
		$query .= " JOIN {$CONFIG->dbprefix}metadata m on m.entity_guid = e.guid ";
	}

	$query .= " WHERE ";
	foreach ($where as $w)
		$query .= " $w and ";
	$query .= get_access_sql_suffix("a"); // now add access
	$query .= ' and ' . get_access_sql_suffix("e"); // now add access
	if (!$count) $query .= ' group by e.guid';

	if (!$count) {
		$query .= ' order by sum ' . $orderdir;
		$query .= ' limit ' . $offset . ' , ' . $limit;
		return get_data($query, "entity_row_to_elggstar");
	} else {
		if ($row = get_data_row($query)) {
			return $row->num;
		}
	}
	return false;
}

/**
 * Is page owner a group - convenience function
 *
 * @return true/false
 */
function tp_is_group_page() {

	if ($group = page_owner_entity()) {
		if ($group instanceof ElggGroup)
			return true;
	}

	return false;
}


/**
 * Is the request from a known browser
 *
 * @return true/false
 */
function tp_is_person() {
	$known = array('msie', 'mozilla', 'firefox', 'safari', 'webkit', 'opera', 'netscape', 'konqueror', 'gecko');

	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);

	foreach ($known as $browser) {
		if (strpos($agent, $browser) !== false) {
			return true;
		}
	}

	return false;
}

/**
 * get a list of people that can be tagged in an image
 *
 * @param $viewer entity
 * @return array of guid->name for tagging
 */
function tp_get_tag_list($viewer) {
	$friends = get_user_friends($viewer->getGUID(), '', 999, 0);
	$friend_list = array();
	if ($friends) {
		foreach($friends as $friend) {
			//error_log("friend $friend->name");
			$friend_list[$friend->guid] = $friend->name;
		}
	}

	// is this a group
	$is_group = tp_is_group_page();
	if ($is_group) {
		$group_guid = page_owner();
		$viewer_guid = $viewer->guid;
		$members = get_group_members($group_guid, 999);
		if (is_array($members)) {
			foreach ($members as $member) {
				if ($viewer_guid != $member->guid) {
					$group_list[$member->guid] = $member->name;
					//error_log("group $member->name");
				}
			}

			// combine group and friends list
			$intersect = array_intersect_key($friend_list, $group_list);
			$unique_friends = array_diff_key($friend_list, $group_list);
			$unique_members = array_diff_key($group_list, $friend_list);
			//$friend_list = array_merge($friend_list, $group_list);
			//$friend_list = array_unique($friend_list);
			$friend_list = $intersect + $unique_friends + $unique_members;
		}
	}

	asort($friend_list);

	return $friend_list;
}
