<?php
	/**
	 * Tidypics Image class
	 * 
	 */


	class TidypicsImage extends ElggFile
	{
		protected function initialise_attributes()
		{
			parent::initialise_attributes();
			
			$this->attributes['subtype'] = "image";
		}
		
		public function __construct($guid = null) 
		{
			parent::__construct($guid);
		}
		
		/**
		 * Has the photo been tagged with "in this photo" tags
		 *
		 * @return true/false
		 */
		public function isPhotoTagged()
		{
			$num_tags = count_annotations($this->getGUID(), 'object', 'image', 'phototag');
			if ($num_tags > 0) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		 * Get an array of photo tag information
		 *
		 * @return array of json representations of the tags and the tag link text
		 */
		public function getPhotoTags() 
		{
			global $CONFIG;
			
			// get tags as annotations
			$photo_tags = get_annotations($this->getGUID(), 'object', 'image', 'phototag');
			if (!$photo_tags) 
			{
				// no tags or user doesn't have permission to tags, so return
				return false;
			}
			
			$photo_tags_json = "[";
			foreach ($photo_tags as $p) 
			{
				$photo_tag = unserialize($p->value);
				
				// create link to page with other photos tagged with same tag
				$phototag_text = $photo_tag->value;
				$phototag_link = $CONFIG->wwwroot . 'search/?tag=' . $phototag_text . '&amp;subtype=image&amp;object=object';
				if ($photo_tag->type === 'user') 
				{
					$user = get_entity($photo_tag->value);
					if ($user) {
						$phototag_text = $user->name;
					} else {
						$phototag_text = "unknown user";
					}
					
					$phototag_link = $CONFIG->wwwroot . "pg/photos/tagged/" . $photo_tag->value;
				}
				
				if (isset($photo_tag->x1)) {
					// hack to handle format of Pedro Prez's tags - ugh
					$photo_tag->coords = "\"x1\":\"{$photo_tag->x1}\",\"y1\":\"{$photo_tag->y1}\",\"width\":\"{$photo_tag->width}\",\"height\":\"{$photo_tag->height}\""; 
					$photo_tags_json .= '{' . $photo_tag->coords . ',"text":"' . $phototag_text . '","id":"' . $p->id . '"},';
				} else {
					$photo_tags_json .= '{' . $photo_tag->coords . ',"text":"' . $phototag_text . '","id":"' . $p->id . '"},';
				}
				
				// prepare variable arrays for tagging view
				$photo_tag_links[$p->id] = array('text' => $phototag_text, 'url' => $phototag_link);
			}
			
			$photo_tags_json = rtrim($photo_tags_json,',');
			$photo_tags_json .= ']';
			
			$ret_data = array('json' => $photo_tags_json, 'links' => $photo_tag_links);
			return $ret_data;
		}
		
		/**
		 * Get the view information for this image
		 * 
		 * @param $viewer_guid the guid of the viewer (0 if not logged in)
		 * @return array with number of views, number of unique viewers, and number of views for this viewer
		 */
		public function getViews($viewer_guid)
		{
			$views = get_annotations($this->getGUID(), "object", "image", "tp_view", "", 0, 99999);
			if ($views) 
			{
				$total_views = count($views);
				
				if ($this->owner_guid == $viewer_guid)
				{
					// get unique number of viewers
					foreach ($views as $view)
					{
						$diff_viewers[$view->owner_guid] = 1;
					}
					$unique_viewers = count($diff_viewers);
				} 
				else if ($viewer_guid) 
				{
					// get the number of times this user has viewed the photo
					$my_views = 0;
					foreach ($views as $view)
					{
						if ($view->owner_guid == $viewer_guid) {
							$my_views++;
						}
					}
				}
				
				$view_info = array("total" => $total_views, "unique" => $unique_viewers, "mine" => $my_views);
			}
			else
			{
				$view_info = array("total" => 0, "unique" => 0, "mine" => 0);
			}
			
			return $view_info;
		}
		
		/**
		 * Add a tidypics view annotation to this image
		 * 
		 * @param $viewer_guid
		 * @return none
		 */
		public function addView($viewer_guid)
		{
			if ($viewer_guid != $this->owner_guid && tp_is_person()) {
				create_annotation($this->getGUID(), "tp_view", "1", "integer", $viewer_guid, ACCESS_PUBLIC);
			}
		}
	}
	
	/**
	 * get a list of people that can be tagged in an image
	 * 
	 * @param $viewer entity
	 * @return array of guid->name for tagging
	 */
	function tp_get_tag_list($viewer)
	{
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
		if ($is_group)
		{
			$group_guid = page_owner();
			$viewer_guid = $viewer->guid;
			$members = get_group_members($group_guid, 999);
			if (is_array($members))
			{
				foreach ($members as $member)
				{
					if ($viewer_guid != $member->guid) 
					{
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
?>