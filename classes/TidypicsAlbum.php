<?php
/**
 * Tidypics Album class
 *
 * @package TidypicsAlbum
 */


class TidypicsAlbum extends ElggObject {
	protected function initialise_attributes() {
		parent::initialise_attributes();

		$this->attributes['subtype'] = "album";
	}

	public function __construct($guid = null) {
		parent::__construct($guid);
	}

	/**
	 * Save an album
	 *
	 * @return bool
	 */
	public function save() {

		if (!isset($this->new_album)) {
			$this->new_album = true;
		}

		if (!parent::save()) {
			return false;
		}
		
		mkdir(tp_get_img_dir() . $this->guid, 0755, true);

		return true;
	}

	/**
	 * Delete album
	 *
	 * @return bool
	 */
	public function delete() {

		$this->deleteImages();
		$this->deleteAlbumDir();
		
		return parent::delete();
	}

	/**
	 * Get the title of the photo album
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Get an array of image objects
	 *
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getImages($limit, $offset=0) {
		$imageList = $this->getImageList();
		if ($offset > count($imageList)) {
			return array();
		}

		$imageList = array_slice($imageList, $offset, $limit);
		
		$images = array();
		foreach ($imageList as $guid) {
			$images[] = get_entity($guid);
		}
		return $images;
	}

	/**
	 * View a list of images
	 *
	 * @param int $limit
	 * @param int $offset
	 * @return string
	 */
	public function viewImages($limit, $offset=0) {
		$images = $this->getImages($limit, $offset);
		if (count($images) == 0) {
			return '';
		}

		$count = $this->getSize();

		return elgg_view_entity_list($images, $count, $offset, $limit, false, false, true);
	}

	public function getCoverImageURL($size = 'small') {
		if ($this->cover) {
			$url = "pg/photos/thumbnail/$this->cover/$size/";
		} else {
			$url = "mod/tidypics/graphics/empty_album.png";
		}
		return elgg_normalize_url($url);
	}

	/**
	 * Get the GUID of the album cover
	 * 
	 * @return int
	 */
	public function getCoverImageGuid() {
		if ($this->getSize() == 0) {
			return 0;
		}

		$guid = $this->cover;
		$imageList = $this->getImageList();
		if (!in_array($guid, $imageList)) {
			// select random photo to be cover
			$index = array_rand($imageList, 1);
			$guid = $imageList[$index];
			$this->cover = $guid;
		}
		return $guid;
	}

	/**
	 * Set the GUID for the album cover
	 *
	 * @param int $guid
	 * @return bool
	 */
	public function setCoverImageGuid($guid) {
		$imageList = $this->getImageList();
		if (!in_array($guid, $imageList)) {
			return false;
		}
		$this->cover = $guid;
		return true;
	}

	/**
	 * Get the number of photos in the album
	 *
	 * @return int
	 */
	public function getSize() {
		return count($this->getImageList());
	}

	/**
	 * Returns an order list of image guids
	 * 
	 * @return array
	 */
	public function getImageList() {
		$listString = $this->orderedImages;
		if (!$listString) {
			return array();
		}
		$list = unserialize($listString);
		return $list;
	}

	/**
	 * Sets the album image order
	 *
	 * @param array $list An indexed array of image guids 
	 */
	public function setImageList($list) {
		$listString = serialize($list);
		$this->orderedImages = $listString;
	}

	/**
	 * Add new images to the front of the image list
	 *
	 * @param array $list An indexed array of image guids
	 */
	public function prependImageList($list) {
		$currentList = $this->getImageList();
		$list = array_merge($list, $currentList);
		$this->setImageList($list);
	}

	/**
	 * Get the GUID of the image before the current one
	 *
	 * @param int $currentGuid
	 * @return int
	 */
	public function getPreviousImageGuid($currentGuid) {
		$imageList = $this->getImageList();
		$key = array_search($currentGuid, $imageList);
		if ($key === FALSE) {
			return 0;
		}
		$key--;
		if ($key < 0) {
			return 0;
		}
		return $imageList[$key];
	}

	/**
	 * Get the GUID of the image after the current one
	 *
	 * @param int $currentGuid
	 * @return int
	 */
	public function getNextImageGuid($currentGuid) {
		$imageList = $this->getImageList();
		$key = array_search($currentGuid, $imageList);
		if ($key === FALSE) {
			return 0;
		}
		$key++;
		if ($key >= count($imageList)) {
			return 0;
		}
		return $imageList[$key];
	}

	/**
	 * Remove an image from the album list
	 *
	 * @param int $imageGuid
	 * @return bool
	 */
	public function removeImage($imageGuid)  {
		$imageList = $this->getImageList();
		$key = array_search($imageGuid, $imageList);
		if ($key === FALSE) {
			return FALSE;
		}
		
		unset($imageList[$key]);
		$this->setImageList($imageList);

		return TRUE;
	}

	protected function deleteImages() {
		// get all the images from this album as long as less than 999 images
		$images = elgg_get_entities(array(
			"type=" => "object",
			"subtype" => "image",
			"container_guid" => $this->guid,
			"limit" => ELGG_ENTITIES_NO_VALUE,
		));
		if ($images) {
			foreach ($images as $image) {
				if ($image) {
					$image->delete();
				}
			}
		}
	}

	protected function deleteAlbumDir() {
		$tmpfile = new ElggFile();
		$tmpfile->setFilename('image/' . $this->guid . '/._tmp_del_tidypics_album_');
		$tmpfile->subtype = 'image';
		$tmpfile->owner_guid = $this->owner_guid;
		$tmpfile->container_guid = $this->guid;
		$tmpfile->open("write");
		$tmpfile->write('');
		$tmpfile->close();
		$tmpfile->save();
		$albumdir = eregi_replace('/._tmp_del_tidypics_album_', '', $tmpfile->getFilenameOnFilestore());
		$tmpfile->delete();
		if (is_dir($albumdir)) {
			rmdir($albumdir);
		}
	}
}
