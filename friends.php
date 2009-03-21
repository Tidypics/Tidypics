<?php
	/**
	 * Tidypics Friends Albums Listing
	 * 
	 */

	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	//if no friends were requested, see world pictures instead, or redirect to user's friends
	if (is_null(get_input('username')) || get_input('username')=='') {
		if (!isloggedin()) {
			forward('pg/photos/world');
		} else {
			forward('pg/photos/friends/' . $_SESSION['user']->username);
		}
	}

	if (is_null(page_owner_entity()->name) || page_owner_entity()->name == '') {
		$friendname = get_input('username');
	} else {
		$friendname = page_owner_entity()->name;
	};
	
	if(isloggedin() && (page_owner() == $_SESSION['guid'])) {
		$area2 = elgg_view_title($title = elgg_echo('album:yours:friends'));
	} else {
		$area2 = elgg_view_title($title = sprintf(elgg_echo('album:friends'), $friendname));
	}
	
	set_context('search');
	set_input('search_viewtype', 'gallery');
	$area2 .= list_user_friends_objects(page_owner(), 'album', 10, true, false);
	
	set_context('photos');
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);
	
	// Finally draw the page
	page_draw(sprintf(elgg_echo("album:friends"),$_SESSION['user']->name), $body);
?>