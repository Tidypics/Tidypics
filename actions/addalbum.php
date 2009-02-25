<?php
	/**
	 * Elgg blog: add post action
	 * 
	 * @package ElggBlog
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.org/
	 */

	// Make sure we're logged in (send us to the front page if not)
		if (!isloggedin()) forward();

	// Get input data
		$title = get_input('albumtitle');
		$body = get_input('albumbody');
		$tags = get_input('albumtags');
		$access = get_input('access_id');
		$container_guid = get_input('container_guid', $_SESSION['user']->getGUID());
		$back_url = 'pg/photos/new/' . get_entity($container_guid)->username;
		
	// Cache to the session
		$_SESSION['albumtitle'] = $title;
		$_SESSION['albumbody'] = $body;
		$_SESSION['albumtags'] = $tags;
		
	// Convert string of tags into a preformatted array
		$tagarray = string_to_tag_array($tags);		
	// Make sure the title / description aren't blank
		if (empty($title) || empty($body)) {
			register_error(elgg_echo("album:blank"));	
			forward(get_input('forward_url', $_SERVER['HTTP_REFERER'])); //failed, so forward to previous page
			
	// Otherwise, save the blog post 
		} else {
			
	// Initialise a new ElggObject
			$album = new ElggObject();
	// Tell the system it's an album
			$album->subtype = "album";			
	
	// Set its owner to the current user
			$album->container_guid = $container_guid;
			$album->owner_guid = $_SESSION['user']->getGUID();
	// For now, set its access to public (we'll add an access dropdown shortly)
			$album->access_id = $access;
	// Set its title and description appropriately
			$album->title = $title;
			$album->description = $body;
	// Before we can set metadata, we need to save the blog post
			if (!$album->save()) {
				register_error(elgg_echo("album:error"));
				forward(get_input('forward_url', $_SERVER['HTTP_REFERER'])); //failed, so forward to previous page
			}
	// Now let's add tags. We can pass an array directly to the object property! Easy.
			if (is_array($tagarray)) {
				$album->tags = $tagarray;
			}
	// Success message
			system_message(elgg_echo("album:created"));
	// Remove the blog post cache
			unset($_SESSION['albumtitle']); 
			unset($_SESSION['albumbody']); 
			unset($_SESSION['albumtags']);
	// Forward to the main blog page
			
			forward("pg/photos/upload/" . $album->guid);
 					
		}
		
?>