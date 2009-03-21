<?php

	/**
	 * Tidypics edit album action
	 * 
	 */
	 
	// Make sure we're logged in (send us to the front page if not)
	if (!isloggedin()) forward();

	// Get input data
	$guid = (int) get_input('albumpost');
	$title = get_input('albumtitle');
	$body = get_input('albumbody');
	$access = get_input('access_id');
	$tags = get_input('albumtags');
	$back_url = 'mod/tidypics/edit.php?file_guid=' . $guid;
		
	// Make sure we actually have permission to edit
	$album = get_entity($guid);
	if ($album->canEdit()) 
	{
	
		// Cache to the session
		$_SESSION['albumtitle'] = $title;
		$_SESSION['albumbody'] = $body;
		$_SESSION['albumtags'] = $tags;
			
		// Convert string of tags into a preformatted array
		$tagarray = string_to_tag_array($tags);
							
		// Get owning user
		$owner = get_entity($album->getOwner());
				
		// edit access only if access is different from current
		if ($album->access_id != $access)
		{
			$album->access_id = $access;
	
			//get images from album and update access on image entities
			$images = get_entities("object","image", $guid, '', 999, '', false);
			foreach ($images as $im) {
				$im->access_id = $access;
				$im->save();
				//new core updates all metadata access as well!
			}
		}


		// Set its title and description appropriately
		$album->title = $title;
		$album->description = $body;

		// Before we can set metadata, we need to save the image
		if (!$album->save()) {
			register_error(elgg_echo("album:error"));
			$album->delete();
			forward(get_input('forward_url', $_SERVER['HTTP_REFERER'])); //failed, so forward to previous page
		}

		// Now let's add tags. We can pass an array directly to the object property! Easy.
		$album->clearMetadata('tags');
		if (is_array($tagarray)) {
			$album->tags = $tagarray;
		}
				
		//if cover meta is sent from image save as metadata
		if (get_input('cover') == elgg_echo('album:cover:yes')) {
			$container = get_entity($album->container_guid);	
			$container->cover = $album->guid;
		}
				
		// Success message
		system_message(elgg_echo("album:edited"));
		
		// Remove the image cache
		unset($_SESSION['albumtitle']); 
		unset($_SESSION['albumbody']); 
		unset($_SESSION['albumtags']);	
		
		// Forward to the main blog page
		forward($album->getURL());

	}		
?>