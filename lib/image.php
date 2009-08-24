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
		
		public function getPhotoTags() 
		{
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
				$phototag_link = $vars['url'] . 'search/?tag=' . $phototag_text . '&amp;subtype=image&amp;object=object';
				if ($photo_tag->type === 'user') 
				{
					$user = get_entity($photo_tag->value);
					if ($user)
						$phototag_text = $user->name;
					else
						$phototag_text = "unknown user";
					
					$phototag_link = $vars['url'] . "pg/photos/tagged/" . $photo_tag->value;
				}
				
				if (isset($photo_tag->x1)) {
					// hack to handle format of Pedro Prez's tags - ugh
					$photo_tag->coords = "\"x1\":\"{$photo_tag->x1}\",\"y1\":\"{$photo_tag->y1}\",\"width\":\"{$photo_tag->width}\",\"height\":\"{$photo_tag->height}\""; 
					$photo_tags_json .= '{' . $photo_tag->coords . ',"text":"' . $phototag_text . '","id":"' . $p->id . '"},';
				} else
					$photo_tags_json .= '{' . $photo_tag->coords . ',"text":"' . $phototag_text . '","id":"' . $p->id . '"},';
				
				// prepare variable arrays for tagging view
				$photo_tag_links[$p->id] = array($phototag_text, $phototag_link);
			}
			
			$photo_tags_json = rtrim($photo_tags_json,',');
			$photo_tags_json .= ']';
			
			$rt = array('raw' => $photo_tags, 'json' => $photo_tags_json, 'links' => $photo_tag_links);
			return $rt;
		}
	}
	
?>