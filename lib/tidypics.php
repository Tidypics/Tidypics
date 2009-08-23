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
		$image_html = tp_list_entities('object', 'image', $owner_guid, $num_images, false, false, false);  
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
	
	
	/**** these functions replace broken core functions ****/
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

	function tp_list_entities($type= "", $subtype = "", $owner_guid = 0, $limit = 10, $fullview = true, $viewtypetoggle = false, $pagination = true) {
		
		$offset = (int) get_input('offset');
		$count = tp_get_entities($type, $subtype, $owner_guid, "", $limit, $offset, true);
		$entities = tp_get_entities($type, $subtype, $owner_guid, "", $limit, $offset);

		return elgg_view_entity_list($entities, $count, $offset, $limit, $fullview, $viewtypetoggle, $pagination);
		
	}
?>