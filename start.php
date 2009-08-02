<?php
	/**
	 * Elgg tidypics
	 * 
	 */

	// set some simple defines
	define('TP_OLD_ALBUM', 0);
	define('TP_NEW_ALBUM', 1);

	// include core libraries
	include dirname(__FILE__) . "/lib/tidypics.php";
	include dirname(__FILE__) . "/lib/image.php";
	include dirname(__FILE__) . "/lib/album.php";
	
	/**
	 * tidypics plugin initialisation functions.
	 */
	function tidypics_init() 
	{
		global $CONFIG;
				
		// Set up menu for logged in users
		if (isloggedin()) 
		{
			add_menu(elgg_echo('photos'), $CONFIG->wwwroot . "pg/photos/owned/" . $_SESSION['user']->username);
		}
				
		// Extend CSS
		extend_view('css', 'tidypics/css');
		
		// Extend hover-over and profile menu
		extend_view('profile/menu/links','tidypics/hover_menu');
		
		//group view  ** psuedo widget view for group pages**
		extend_view('groups/right_column','tidypics/groupprofile_albums');
		
		// rss extensions
		extend_view('extensions/xmlns', 'extensions/tidypics/xmlns');
		extend_view('extensions/channel', 'extensions/tidypics/channel');
		
		// Register a page handler, so we can have nice URLs
		register_page_handler('photos','tidypics_page_handler');
			
		// Add a new tidypics widget
		add_widget_type('album_view', elgg_echo("album:widget"), elgg_echo("album:widget:description"), 'profile');
		
		// Register a URL handler for files
		register_entity_url_handler('tidypics_image_url', 'object', 'image');
		register_entity_url_handler('tidypics_album_url', 'object', 'album');

		// add the class files for image and album
		add_subtype("object", "image", "TidypicsImage");
		add_subtype("object", "album", "TidypicsAlbum");

		// Register entity type
		register_entity_type('object','image');
		register_entity_type('object','album');
		
		if (function_exists('add_group_tool_option'))
			add_group_tool_option('photos',elgg_echo('tidypics:enablephotos'),true);
		
		if (get_plugin_setting('grp_perm_override', 'tidypics') != "disabled")
			register_plugin_hook('permissions_check', 'object', 'tidypics_permission_override');
		
		// Register for notifications 
		if (is_callable('register_notification_object')) {
			register_notification_object('object', 'album', elgg_echo('tidypics:newalbum'));
			
			register_plugin_hook('notify:entity:message', 'object', 'tidypics_notify_message');
		}
	}
	
	/**
	 * Sets up submenus for tidypics.  Triggered on pagesetup.
	 */
	function tidypics_submenus() {
		
		global $CONFIG;
		
		$page_owner = page_owner_entity();
		
		if ($page_owner instanceof ElggGroup) {
			if (get_context() == "groups") {
				if ($page_owner->photos_enable != "no") {
					add_submenu_item(	sprintf(elgg_echo('album:group'),$page_owner->name), 
										$CONFIG->wwwroot . "pg/photos/owned/" . $page_owner->username);
				}
			}
		}
		// context is only set to photos on individual pages, not on group pages
		else if (get_context() == "photos") {
			
			$view_count = get_plugin_setting('view_count', 'tidypics');
			
			// owner gets "your albumn", "your friends albums", "your most viewed", "your most recent"
			if (get_loggedin_userid() == $page_owner->guid && get_loggedin_userid()) {
				add_submenu_item(	elgg_echo('album:create'), 
									$CONFIG->wwwroot . "pg/photos/new/". $page_owner->username, 
									'tidypics-a' );

				add_submenu_item(	elgg_echo("album:yours"), 
									$CONFIG->wwwroot . "pg/photos/owned/" . $_SESSION['user']->username, 
									'tidypics-a' );

				add_submenu_item( 	elgg_echo('album:yours:friends'), 
									$CONFIG->wwwroot . "pg/photos/friends/". $page_owner->username, 
									'tidypics-a');
				
				if ($view_count != 'disabled') {
					add_submenu_item(	elgg_echo('tidypics:yourmostviewed'),
										$CONFIG->wwwroot . 'pg/photos/yourmostviewed',
										'tidypics-a');
				}
				
				add_submenu_item(	elgg_echo('tidypics:yourmostrecent'),
									$CONFIG->wwwroot . 'pg/photos/yourmostrecent',
									'tidypics-a');
			} else if (isloggedin()) {
				// logged in not owner gets "your albums", "page owners albums", "page owner's friends albums", "page owner's most viewed", "page owner's most recent"
				add_submenu_item(	elgg_echo("album:yours"), 
									$CONFIG->wwwroot . "pg/photos/owned/" . $_SESSION['user']->username, 
									'tidypics-b' );
				
				if ($view_count != 'disabled') {
					add_submenu_item(	elgg_echo('tidypics:yourmostviewed'),
										$CONFIG->wwwroot . 'pg/photos/yourmostviewed',
										'tidypics-b');
				}
				
				add_submenu_item(	elgg_echo('tidypics:yourmostrecent'),
									$CONFIG->wwwroot . 'pg/photos/yourmostrecent',
									'tidypics-b');
									
				if($page_owner->name) { // check to make sure the owner set their display name
					add_submenu_item(	sprintf(elgg_echo("album:user"), $page_owner->name), 
										$CONFIG->wwwroot . "pg/photos/owned/" . $page_owner->username, 
										'tidypics-a' );
					add_submenu_item( 	sprintf(elgg_echo('album:friends'),$page_owner->name), 
										$CONFIG->wwwroot . "pg/photos/friends/". $page_owner->username, 
										'tidypics-a');
					
					if ($view_count != 'disabled') {
						add_submenu_item( 	sprintf(elgg_echo('tidypics:friendmostviewed'),$page_owner->name), 
											$CONFIG->wwwroot . "pg/photos/friendmostviewed/". $page_owner->username, 
											'tidypics-a');
					}
					
					add_submenu_item( 	sprintf(elgg_echo('tidypics:friendmostrecent'),$page_owner->name), 
										$CONFIG->wwwroot . "pg/photos/friendmostrecent/". $page_owner->username, 
										'tidypics-a');
				}
			} else if ($page_owner->guid) {
				// non logged in user gets "page owners albums", "page owner's friends albums" 
				add_submenu_item(	sprintf(elgg_echo("album:user"), $page_owner->name), 
									$CONFIG->wwwroot . "pg/photos/owned/" . $page_owner->username, 
									'tidypics' );
				add_submenu_item( 	sprintf(elgg_echo('album:friends'),$page_owner->name), 
									$CONFIG->wwwroot . "pg/photos/friends/". $page_owner->username, 
									'tidypics');
			}
			
			add_submenu_item(	elgg_echo('album:all'), 
								$CONFIG->wwwroot . "pg/photos/world/", 
								'tidypics-z');
			add_submenu_item(	elgg_echo('tidypics:mostrecent'),
								$CONFIG->wwwroot . 'pg/photos/mostrecent',
								'tidypics-z');
			
			if ($view_count != 'disabled') {
				add_submenu_item(	elgg_echo('tidypics:mostviewed'),
									$CONFIG->wwwroot . 'pg/photos/mostviewed',
									'tidypics-z');
				add_submenu_item(	elgg_echo('tidypics:recentlyviewed'),
									$CONFIG->wwwroot . 'pg/photos/recentlyviewed',
									'tidypics-z');
			}

		}
		
	}
	
	/**
	 * Sets up submenus for tidypics most viewed pages
	 */
	function tidypics_mostviewed_submenus() {
		
		global $CONFIG;
		
		add_submenu_item(elgg_echo('tidypics:mostvieweddashboard'), $CONFIG->url . "mod/tidypics/mostvieweddashboard.php");
		add_submenu_item(elgg_echo('tidypics:mostviewedthisyear'), $CONFIG->url . "mod/tidypics/mostviewedimagesthisyear.php");
		add_submenu_item(elgg_echo('tidypics:mostviewedthismonth'), $CONFIG->url . "mod/tidypics/mostviewedimagesthismonth.php");
		add_submenu_item(elgg_echo('tidypics:mostviewedlastmonth'), $CONFIG->url . "mod/tidypics/mostviewedimageslastmonth.php");
		add_submenu_item(elgg_echo('tidypics:mostviewedtoday'), $CONFIG->url . "mod/tidypics/mostviewedimagestoday.php");
		add_submenu_item(elgg_echo('tidypics:mostcommented'), $CONFIG->url . "mod/tidypics/mostcommentedimages.php");
		add_submenu_item(elgg_echo('tidypics:mostcommentedthismonth'), $CONFIG->url . "mod/tidypics/mostcommentedimagesthismonth.php");
		add_submenu_item(elgg_echo('tidypics:mostcommentedtoday'), $CONFIG->url . "mod/tidypics/mostcommentedimagestoday.php");
	}
	/**
	 * Sets up tidypics admin menu. Triggered on pagesetup.
	 */
	function tidypics_adminmenu()
	{
		global $CONFIG;
		if (get_context() == 'admin' && isadminloggedin()) {
			add_submenu_item(elgg_echo('tidypics:administration'), $CONFIG->url . "mod/tidypics/admin.php");
		}
	}

	/**
	 * tidypics page handler
	 *
	 * @param array $page Array of page elements, forwarded by the page handling mechanism
	 */
	function tidypics_page_handler($page) {
		
		global $CONFIG;
		
		if (isset($page[0])) 
		{
			switch($page[0]) 
			{
				case "owned":  //view list of albums owned by container
					if (isset($page[1])) set_input('username',$page[1]);
					include($CONFIG->pluginspath . "tidypics/index.php");
				break;

				case "view": //view an image individually
					if (isset($page[1])) set_input('guid',$page[1]);
					include($CONFIG->pluginspath . "tidypics/viewimage.php");
				break;

				case "album": //view an album individually
					if (isset($page[1])) set_input('guid',$page[1]);
					include($CONFIG->pluginspath . "tidypics/viewalbum.php");
				break;

				case "new":  //create new album
					if (isset($page[1])) set_input('username',$page[1]); 
					include($CONFIG->pluginspath . "tidypics/newalbum.php");
				break;

				case "upload": //upload images to album
					if (isset($page[1])) set_input('container_guid',$page[1]);
					include($CONFIG->pluginspath . "tidypics/upload.php");
				break;

				case "edit": //edit image or album
					if (isset($page[1])) set_input('guid',$page[1]);
					include($CONFIG->pluginspath . "tidypics/edit.php");
				break;

				case "delete": //edit image or album
					if (isset($page[1])) set_input('guid',$page[1]);
					include($CONFIG->pluginspath . "tidypics/actions/delete.php");
				break;

				case "friends": 
					if (isset($page[1])) set_input('username',$page[1]);
					include($CONFIG->pluginspath . "tidypics/friends.php");
				break;

				case "world":  
					include($CONFIG->pluginspath . "tidypics/world.php");
				break;
				
				case "search": //view an image individually
					if (isset($page[1])) set_input('guid',$page[1]);
					include($CONFIG->pluginspath . "tidypics/search.php");
				break;

				case "rate": //rate image
					if (isset($page[1])) set_input('guid',$page[1]);
					include($CONFIG->pluginspath . "tidypics/actions/rate.php");
				break;

				case "mostviewed":
					if (isset($page[1])) set_input('guid',$page[1]);
					include($CONFIG->pluginspath . "tidypics/mostviewedimages.php");
				break;
				
				case "mostrecent":
					if (isset($page[1])) set_input('guid',$page[1]);
					include($CONFIG->pluginspath . "tidypics/mostrecentimages.php");
				break;
				
				case "yourmostviewed":
					if (isset($page[1])) set_input('guid',$page[1]);
					include($CONFIG->pluginspath . "tidypics/yourmostviewed.php");
				break;
				
				case "yourmostrecent":
					if (isset($page[1])) set_input('guid',$page[1]);
					include($CONFIG->pluginspath . "tidypics/yourmostrecent.php");
				break;
				
				case "friendmostviewed":
					if (isset($page[1])) set_input('guid',$page[1]);
					include($CONFIG->pluginspath . "tidypics/friendmostviewed.php");
				break;
				
				case "friendmostrecent":
					if (isset($page[1])) set_input('guid',$page[1]);
					include($CONFIG->pluginspath . "tidypics/friendmostrecent.php");
				break;
				
				case "recentlyviewed":
					if (isset($page[1])) set_input('guid',$page[1]);
					include($CONFIG->pluginspath . "tidypics/recentlyviewed.php");
				break;
				
				case "highestrated":
					if (isset($page[1])) set_input('guid',$page[1]);
					include($CONFIG->pluginspath . "tidypics/highestrated.php");
				break;
			}
		}
		else
		{
			// going to the index because something is wrong with the page handler 
			include($CONFIG->pluginspath . "tidypics/index.php");
		}
		
	}

	/**
	 * Override permissions for group albums and images
	 *
	 */
	function tidypics_permission_override($hook, $entity_type, $returnvalue, $params)
	{
		$entity = $params['entity'];
		$user   = $params['user'];
		
		if ($entity->subtype == get_subtype_id('object', 'album')) {
			// test that the user can edit the container
			return can_write_to_container(0, $entity->container_guid);
		}

		if ($entity->subtype == get_subtype_id('object', 'image')) {
			// test that the user can edit the container
			return can_write_to_container(0, $entity->container_guid);
		}
	}
	
	
	/**
	 * Notification message handler
	 */
	function tidypics_notify_message($hook, $entity_type, $returnvalue, $params)
	{
		$entity = $params['entity'];
		$to_entity = $params['to_entity'];
		$method = $params['method'];
		if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'album'))
		{
			// block notification message when the album doesn't have any photos
			if ($entity->new_album == TP_NEW_ALBUM)
				return false;
				
			$descr = $entity->description;
			$title = $entity->title;
			$owner = $entity->getOwnerEntity();
			return sprintf(elgg_echo('album:river:created'), $owner->name) . ': ' . $title . "\n\n" . $descr . "\n\n" . $entity->getURL();
		}
		return null;
	}
	
	/**
	 * Populates the ->getUrl() method for file objects
	 * Registered in the init function
	 *
	 * @param ElggEntity $entity album/image entity
	 * @return string File URL
	 */
	function tidypics_image_url($entity) {
		global $CONFIG;
		$title = $entity->title;
		$title = friendly_title($title);
		return $CONFIG->url . "pg/photos/view/" . $entity->getGUID() . "/" . $title;
	}

	function tidypics_album_url($entity) {
		global $CONFIG;
		$title = $entity->title;
		$title = friendly_title($title);
		return $CONFIG->url . "pg/photos/album/" . $entity->getGUID() . "/" . $title;
	}


	// Make sure tidypics_init is called on initialisation
	register_elgg_event_handler('init','system','tidypics_init');
	register_elgg_event_handler('pagesetup','system','tidypics_submenus');
	register_elgg_event_handler('pagesetup','system','tidypics_adminmenu');
	
	// Register actions
	register_action("tidypics/settings", false, $CONFIG->pluginspath . "tidypics/actions/settings.php");
	register_action("tidypics/upload", false, $CONFIG->pluginspath . "tidypics/actions/upload.php");
	register_action("tidypics/addalbum", false, $CONFIG->pluginspath. "tidypics/actions/addalbum.php");
	register_action("tidypics/edit", false, $CONFIG->pluginspath. "tidypics/actions/edit.php");
	register_action("tidypics/delete", false, $CONFIG->pluginspath. "tidypics/actions/delete.php");
	register_action("tidypics/edit_multi", false, $CONFIG->pluginspath. "tidypics/actions/edit_multi.php");
	register_action("tidypics/download", true, $CONFIG->pluginspath . "tidypics/actions/download.php");
	register_action("tidypics/addtag", true, $CONFIG->pluginspath . "tidypics/actions/addtag.php");
	register_action("tidypics/deletetag", true, $CONFIG->pluginspath . "tidypics/actions/deletetag.php");

?>