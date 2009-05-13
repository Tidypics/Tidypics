<?php
	/**
	 * Elgg tidypics_settings plugin
	 *
	 * Only uncomment and change settings that you want to change.
	 * 
	 */

	// setup tidypics settings object
	global $CONFIG;
	if (!isset($CONFIG->tidypics)) {
		error_log('tidypics_settings: error - not loaded after tidypics plugin!!!');
	}


/////////////////////////////////////////////////////////////////////
// Image sizes - Tidypics makes 3 views of an image:
// Large - displayed when viewing the image alone
// Small - displayed on an album page
// Thumb - used for the activity log
// There is also the original image that is available for download
//	$CONFIG->tidypics->image_large_width = 600;
//	$CONFIG->tidypics->image_large_height = 600;

//	$CONFIG->tidypics->image_small_width = 153;
//	$CONFIG->tidypics->image_small_height = 153;

//	$CONFIG->tidypics->image_thumb_width = 60;
//	$CONFIG->tidypics->image_thumb_height = 60;





?>