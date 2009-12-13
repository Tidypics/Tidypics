<?php
	/**
	 * Elgg tidypics library of common functions
	 * 
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
	function tp_get_latest_photos($num_images, $owner_guid = 0)
	{
		$prev_context = set_context('front');
		$image_html = tp_list_entities('object', 'image', $owner_guid, null, $num_images, false, false, false);  
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
	function tp_get_img_dir()
	{
		$file = new ElggFile();
		return $file->getFilenameOnFilestore() . 'image/';
	}
	
	
	
	/*********************************************************************
	 * the functions below replace broken core functions or add functions 
	 * that could/should exist in the core
	 */
	 
	/**
	 *
	 */
	function tp_get_entities($type = "", $subtype = "", $owner_guid = 0, $order_by = "", $limit = 10, $offset = 0, $count = false, $site_guid = 0, $container_guid = null, $timelower = 0, $timeupper = 0)
	{
		global $CONFIG;
		
		if ($subtype === false || $subtype === null || $subtype === 0)
			return false;
		
		if ($order_by == "") $order_by = "time_created desc";
		$order_by = sanitise_string($order_by);
		$limit = (int)$limit;
		$offset = (int)$offset;
		$site_guid = (int) $site_guid;
		$timelower = (int) $timelower;
		$timeupper = (int) $timeupper;
		if ($site_guid == 0)
			$site_guid = $CONFIG->site_guid;
				
		$where = array();
		
		if (is_array($subtype)) {
			$tempwhere = "";
			if (sizeof($subtype))
			foreach($subtype as $typekey => $subtypearray) {
				foreach($subtypearray as $subtypeval) {
					$typekey = sanitise_string($typekey);
					if (!empty($subtypeval)) {
						if (!$subtypeval = (int) get_subtype_id($typekey, $subtypeval))
							return false;
					} else {
						// @todo: Setting subtype to 0 when $subtype = '' returns entities with
						// no subtype.  This is different to the non-array behavior
						// but may be required in some cases.
						$subtypeval = 0;
					}
					if (!empty($tempwhere)) $tempwhere .= " or ";
					$tempwhere .= "(type = '{$typekey}' and subtype = {$subtypeval})";
				}
			}
			if (!empty($tempwhere)) $where[] = "({$tempwhere})";
			
		} else {
		
			$type = sanitise_string($type);
			if ($subtype !== "" AND !$subtype = get_subtype_id($type, $subtype))
				return false;
			
			if ($type != "")
				$where[] = "type='$type'";
			if ($subtype!=="")
				$where[] = "subtype=$subtype";
		}

		if ($owner_guid != "") {
			if (!is_array($owner_guid)) {
				$owner_array = array($owner_guid);
				$owner_guid = (int) $owner_guid;
				$where[] = "owner_guid = '$owner_guid'";
			} else if (sizeof($owner_guid) > 0) {
				$owner_array = array_map('sanitise_int', $owner_guid);
				// Cast every element to the owner_guid array to int
				$owner_guid = array_map("sanitise_int", $owner_guid);
				$owner_guid = implode(",",$owner_guid);
				$where[] = "owner_guid in ({$owner_guid})";
			}
		}
		if ($site_guid > 0)
			$where[] = "site_guid = {$site_guid}";

		if (!is_null($container_guid)) {
			if (is_array($container_guid)) {
				foreach($container_guid as $key => $val) $container_guid[$key] = (int) $val;
				$where[] = "container_guid in (" . implode(",",$container_guid) . ")";
			} else {
				$container_guid = (int) $container_guid;
				$where[] = "container_guid = {$container_guid}";
			}
		}
		if ($timelower)
			$where[] = "time_created >= {$timelower}";
		if ($timeupper)
			$where[] = "time_created <= {$timeupper}";
			
		if (!$count) {
			$query = "SELECT * from {$CONFIG->dbprefix}entities where ";
		} else {
			$query = "SELECT count(guid) as total from {$CONFIG->dbprefix}entities where ";
		}
		foreach ($where as $w)
			$query .= " $w and ";
		$query .= get_access_sql_suffix(); // Add access controls

		if (!$count) {
			$query .= " order by $order_by";
			if ($limit) $query .= " limit $offset, $limit"; // Add order and limit
			$dt = get_data($query, "entity_row_to_elggstar");
			return $dt;
		} else {
			$total = get_data_row($query);
			return $total->total;
		}
	}

	function tp_list_entities($type= "", $subtype = "", $owner_guid = 0, $container_guid = null, $limit = 10, $fullview = true, $viewtypetoggle = false, $pagination = true) {
		
		$offset = (int) get_input('offset');
		$count = tp_get_entities($type, $subtype, $owner_guid, "", $limit, $offset, true, 0, $container_guid);
		
		$entities = tp_get_entities($type, $subtype, $owner_guid, "", $limit, $offset, false, 0, $container_guid);

		return tp_view_entity_list($entities, $count, $offset, $limit, $fullview, $viewtypetoggle, $pagination);
	}
	
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
	
	function tp_get_entities_from_annotations_calculate_x($sum = "sum", $entity_type = "", $entity_subtype = "", $name = "", $mdname = '', $mdvalue = '', $owner_guid = 0, $limit = 10, $offset = 0, $orderdir = 'desc', $count = false)
	{
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
	function tp_is_person()
	{
		$known = array('msie', 'mozilla', 'firefox', 'safari', 'webkit', 'opera', 'netscape', 'konqueror', 'gecko');
		
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		
		foreach ($known as $browser)
		{
			if (strpos($agent, $browser) !== false) {
				return true;
			}
		}
		
		return false;
	}
?>