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
			if ($num_tags > 0)
				return true;
			else
				return false;
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
					if ($user)
						$phototag_text = $user->name;
					else
						$phototag_text = "unknown user";
					
					$phototag_link = $CONFIG->wwwroot . "pg/photos/tagged/" . $photo_tag->value;
				}
				
				if (isset($photo_tag->x1)) {
					// hack to handle format of Pedro Prez's tags - ugh
					$photo_tag->coords = "\"x1\":\"{$photo_tag->x1}\",\"y1\":\"{$photo_tag->y1}\",\"width\":\"{$photo_tag->width}\",\"height\":\"{$photo_tag->height}\""; 
					$photo_tags_json .= '{' . $photo_tag->coords . ',"text":"' . $phototag_text . '","id":"' . $p->id . '"},';
				} else
					$photo_tags_json .= '{' . $photo_tag->coords . ',"text":"' . $phototag_text . '","id":"' . $p->id . '"},';
				
				// prepare variable arrays for tagging view
				$photo_tag_links[$p->id] = array('text' => $phototag_text, 'url' => $phototag_link);
			}
			
			$photo_tags_json = rtrim($photo_tags_json,',');
			$photo_tags_json .= ']';
			
			$ret_data = array('json' => $photo_tags_json, 'links' => $photo_tag_links);
			return $ret_data;
		}
		
		/**
		 * 
		 */
		public function getViews($viewer_guid)
		{
			$views_a = get_annotations($this->getGUID(), "object", "image", "tp_view", "", 0, 9999);
			$total_views = count($views_a);
			
			if ($this->owner_guid == $viewer_guid)
			{
				// get unique number of viewers
				foreach ($views_a as $view)
				{
					$diff_viewers[$view->owner_guid] = 1;
				}
				$unique_viewers = count($diff_viewers);
			} 
			else if ($viewer_guid) 
			{
				// get the number of times this user has viewed the photo
				$my_views = 0;
				foreach ($views_a as $view)
				{
					if ($view->owner_guid == $viewer_guid)
						$my_views++;
				}
			}
			
			$view_info = array("total" => $total_views, "unique" => $unique_viewers, "mine" => $my_views);
			
			return $view_info;
		}
		
		public function addView($viewer_guid)
		{
			if ($viewer_guid != $this->owner_guid)
				create_annotation($this->getGUID(), "tp_view", "1", "integer", $viewer_guid, ACCESS_PUBLIC);
		}
	}
	
?>