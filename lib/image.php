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
	}
	
?>