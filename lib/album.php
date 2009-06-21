<?php
	/**
	 * Tidypics Album class
	 * 
	 */


	class TidypicsAlbum extends ElggObject
	{
		protected function initialise_attributes()
		{
			parent::initialise_attributes();
			
			$this->attributes['subtype'] = "album";
		}
		
		public function __construct($guid = null) 
		{
			parent::__construct($guid);
		}
	}
	
?>