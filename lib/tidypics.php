<?php
	/**
	 * Elgg tidypics library of common functions
	 * 
	 */

	/**
	 * Get images for display on front page
	 *
	 * @param int number of images
	 * @param int (optional) guid of owner
	 * @return string of html for display
	 *
	 * To use with the custom index plugin, use something like this:
	
	if (is_plugin_enabled('tidypics')) {
?>
	<!-- display latest photos -->
		<div class="index_box">
			<h2><a href="<?php echo $vars['url']; ?>pg/photos/world/"><?php echo elgg_echo("tidypics:mostrecent"); ?></a></h2>
			<div class="contentWrapper">
			<?php
				echo tp_get_latest_photos(5);
			?>
			</div>
		</div>
<?php
	}
?>

	 * Good luck
	 */
	function tp_get_latest_photos($num_images, $owner_guid = 0)
	{
		$prev_context = set_context('front');
		$image_html = list_entities('object', 'image', $owner_guid, $num_images, false, false, false);  
		set_context($prev_context);
		return $image_html;
	}
	
	
	/**
	 * Get image directory path
	 *
	 * Each album gets a subdirectory based on its container id
	 *
	 * @return string	path to image directory
	 */
	function tp_get_img_dir()
	{
		$file = new ElggFile();
		return $file->getFilenameOnFilestore() . 'image/';
	}
	
?>