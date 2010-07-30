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
	 * Returns an order list of image guids
	 * 
	 * @return array
	 */
	public function getOrderedImageList() {
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
	public function setOrderedImageList($list) {
		$listString = serialize($list);
		$this->orderedImages = $listString;
	}

	/**
	 * Add new images to the front of the image list
	 *
	 * @param array $list An indexed array of image guids
	 */
	public function prependOrderedImageList($list) {
		$currentList = $this->getOrderedImageList();
		$list = array_merge($list, $currentList);
		$this->setOrderedImageList($list);
	}
}
