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

		return elgg_view_entity_list($images, $count, $offset, $limit, FALSE, FALSE, TRUE);
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
}
