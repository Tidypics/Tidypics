<?php
	/**
	 * Elgg album: multi image edit action
	 * 
	 */
	 
	// Make sure we're logged in (send us to the front page if not)
	if (!isloggedin()) forward();

	// Get input data
	$title_array = get_input('title');
	$caption_array = get_input('caption');
	$tags_array = get_input('tags');
	$image_guid_array = get_input('image_guid');
	$container_guid = get_input('container_guid');
	$album_entity = get_entity($container_guid);
	$cover = get_input('cover');
	$not_updated = array();

	foreach($image_guid_array as $key => $im) {
		$image = get_entity($im);
		
		if ($image->canEdit()) {
			
			// Convert string of tags into a preformatted array
			$tagarray = string_to_tag_array($tags_array[$key]);

			//set description appropriately
			$image->title = $title_array[$key];
			
			//set description appropriately
			$image->description = $caption_array[$key];

			// Before we can set metadata, we need to save the image
			if (!$image->save()) {
				array_push($not_updated, $image->guid);
			}

			// Now let's add tags. We can pass an array directly to the object property! Easy.
			$image->clearMetadata('tags');
			if (is_array($tagarray)) {
				$image->tags = $tagarray;
			}
				
			//if cover meta is sent from image save as metadata
			if ($cover == $im) {
				$album_entity->cover = $im;
			}
		}
	}
	
	// Success message
	if (count($not_updated) > 0) {
		register_error(elgg_echo("images:notedited"));
	} else {
		system_message(elgg_echo("images:edited"));
	}
			
	// Forward to the main album page
	forward($album_entity->getURL());

?>