<?php
/**
 * Tidypics Image class
 *
 * @package TidypicsImage
 */


class TidypicsImage extends ElggFile {
	protected function initialise_attributes() {
		parent::initialise_attributes();

		$this->attributes['subtype'] = "image";
	}

	public function __construct($guid = null) {
		parent::__construct($guid);
	}

	/**
	 * delete image
	 *
	 * @return bool
	 */
	public function delete() {

		$album = get_entity($this->container_guid);
		if ($album) {
			$album->removeImage($this->guid);
		}

		$this->removeThumbnails();

		// update quota
		$owner = $this->getOwnerEntity();
		$owner->image_repo_size = (int)$owner->image_repo_size - $this->size();

		return parent::delete();
	}

	/**
	 * Set the internal filenames
	 * 
	 * @warning container needs to be set first
	 */
	public function setOriginalFilename($originalName) {
		$prefix = "image/" . $this->container_guid . "/";
		$filestorename = elgg_strtolower(time() . $originalName);
		$this->setFilename($prefix . $filestorename);
		$this->originalfilename = $originalName;
	}

	/**
	 * Save the uploaded image
	 *
	 * @warning filename needs to be set first
	 * 
	 * @param string $uploadedFilename name of the uploaded file
	 * @param int $size
	 */
	public function saveImageFile($uploadedFilename, $size) {

		// we need to make sure the directory for the album exists
		// @note for group albums, the photos are distributed among the users
		$dir = tp_get_img_dir() . $this->getContainer();
		if (!file_exists($dir)) {
			mkdir($dir, 0755, true);
		}

		$filename = $this->getFilenameOnFilestore();

		$result = move_uploaded_file($uploadedFilename, $filename);
		if (!$result) {
			return false;
		}

		$owner = $this->getOwnerEntity();
		$owner->image_repo_size = (int)$owner->image_repo_size + $size;

		return true;
	}

	/**
	 * Save the image thumbnails
	 *
	 * @warning container guid and filename must be set
	 * 
	 * @param string $imageLib
	 */
	public function saveThumbnails($imageLib) {
		include_once dirname(__FILE__) . "/resize.php";
		
		$prefix = "image/" . $this->container_guid . "/";
		$filename = $this->getFilename();
		$filename = substr($filename, strrpos($filename, '/') + 1);
		
		if ($imageLib == 'ImageMagick') {
			// ImageMagick command line
			if (tp_create_im_cmdline_thumbnails($this, $prefix, $filename) != true) {
				trigger_error('Tidypics warning: failed to create thumbnails - ImageMagick command line', E_USER_WARNING);
			}
		} else if ($imageLib == 'ImageMagickPHP') {
			// imagick php extension
			if (tp_create_imagick_thumbnails($this, $prefix, $filename) != true) {
				trigger_error('Tidypics warning: failed to create thumbnails - ImageMagick PHP', E_USER_WARNING);
			}
		} else {
			if (tp_create_gd_thumbnails($this, $prefix, $filename) != true) {
				trigger_error('Tidypics warning: failed to create thumbnails - GD', E_USER_WARNING);
			}
		}
	}

	/**
	 * Extract EXIF Data from image
	 *
	 * @warning image file must be saved first
	 */
	public function extractExifData() {
		include_once dirname(__FILE__) . "/exif.php";
		td_get_exif($this);
	}
	
	/**
	 * Has the photo been tagged with "in this photo" tags
	 *
	 * @return true/false
	 */
	public function isPhotoTagged() {
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
	public function getPhotoTags() {
		global $CONFIG;

		// get tags as annotations
		$photo_tags = get_annotations($this->getGUID(), 'object', 'image', 'phototag');
		if (!$photo_tags) {
			// no tags or user doesn't have permission to tags, so return
			return false;
		}

		$photo_tags_json = "[";
		foreach ($photo_tags as $p) {
			$photo_tag = unserialize($p->value);

			// create link to page with other photos tagged with same tag
			$phototag_text = $photo_tag->value;
			$phototag_link = $CONFIG->wwwroot . 'search/?tag=' . $phototag_text . '&amp;subtype=image&amp;object=object';
			if ($photo_tag->type === 'user') {
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
	public function getViews($viewer_guid) {
		$views = get_annotations($this->getGUID(), "object", "image", "tp_view", "", 0, 99999);
		if ($views) {
			$total_views = count($views);

			if ($this->owner_guid == $viewer_guid) {
				// get unique number of viewers
				foreach ($views as $view) {
					$diff_viewers[$view->owner_guid] = 1;
				}
				$unique_viewers = count($diff_viewers);
			}
			else if ($viewer_guid) {
				// get the number of times this user has viewed the photo
				$my_views = 0;
				foreach ($views as $view) {
					if ($view->owner_guid == $viewer_guid) {
						$my_views++;
					}
				}
			}

			$view_info = array("total" => $total_views, "unique" => $unique_viewers, "mine" => $my_views);
		}
		else {
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
	public function addView($viewer_guid) {
		if ($viewer_guid != $this->owner_guid && tp_is_person()) {
			create_annotation($this->getGUID(), "tp_view", "1", "integer", $viewer_guid, ACCESS_PUBLIC);
		}
	}

	/**
	 * Remove thumbnails - usually in preparation for deletion
	 *
	 * The thumbnails are not actually ElggObjects so we create
	 * temporary objects to delete them.
	 */
	protected function removeThumbnails() {
		$thumbnail = $this->thumbnail;
		$smallthumb = $this->smallthumb;
		$largethumb = $this->largethumb;

		//delete standard thumbnail image
		if ($thumbnail) {
			$delfile = new ElggFile();
			$delfile->owner_guid = $this->getOwner();
			$delfile->setFilename($thumbnail);
			$delfile->delete();
		}
		//delete small thumbnail image
		if ($smallthumb) {
			$delfile = new ElggFile();
			$delfile->owner_guid = $this->getOwner();
			$delfile->setFilename($smallthumb);
			$delfile->delete();
		}
		//delete large thumbnail image
		if ($largethumb) {
			$delfile = new ElggFile();
			$delfile->owner_guid = $this->getOwner();
			$delfile->setFilename($largethumb);
			$delfile->delete();
		}
	}
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
