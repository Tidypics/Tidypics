<?php
	/**
	 * Tidypics Add New Album Action
	 * 
	 */

	// Make sure we're logged in (send us to the front page if not)
	if (!isloggedin()) forward();

	// Get input data
	$title = get_input('tidypicstitle');
	$body = get_input('tidypicsbody');
	$tags = get_input('tidypicstags');
	$access = get_input('access_id');
	$container_guid = get_input('container_guid', $_SESSION['user']->getGUID());

	// Cache to the session
	$_SESSION['tidypicstitle'] = $title;
	$_SESSION['tidypicsbody'] = $body;
	$_SESSION['tidypicstags'] = $tags;

	// Convert string of tags into a preformatted array
	$tagarray = string_to_tag_array($tags);
	// Make sure the title isn't blank
	if (empty($title)) {
		register_error(elgg_echo("album:blank"));
		forward($_SERVER['HTTP_REFERER']); //failed, so forward to previous page
	// Otherwise, save the album 
	} else {
			
		// Initialise a new ElggObject
		$album = new ElggObject();
		// Tell the system it's an album
		$album->subtype = "album";
	
		// Set its owner to the current user
		$album->container_guid = $container_guid;
		$album->owner_guid = $_SESSION['user']->getGUID();
		$album->access_id = $access;
		// Set its title and description appropriately
		$album->title = $title;
		$album->description = $body;
		
		// we catch the adding images to new albums in the upload action and throw a river new album event 
		$album->new_album = TP_NEW_ALBUM;
		
		// Before we can set metadata, we need to save the album
		if (!$album->save()) {
			register_error(elgg_echo("album:error"));
			forward(get_input('forward_url', $_SERVER['HTTP_REFERER'])); //failed, so forward to previous page
		}
		
		// Now let's add tags
		if (is_array($tagarray)) {
			$album->tags = $tagarray;
		}
		
		
		
		// Success message
		system_message(elgg_echo("album:created"));
		
		// Remove the album post cache
		unset($_SESSION['tidypicstitle']); 
		unset($_SESSION['tidypicsbody']); 
		unset($_SESSION['tidypicstags']);

		// plugins can register to be told when a new Tidypics album has been created
		trigger_elgg_event('add', 'tp_album', $album);

		forward("pg/photos/upload/" . $album->guid);
	}

?>