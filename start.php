<?php
	/**
	 * Elgg tidypics
	 * 
	 */

	/**
	 * tidypics plugin initialisation functions.
	 */
	function tidypics_init() 
	{
		// Get config
		global $CONFIG;
				
		// Set up menu for logged in users
		if (isloggedin()) 
		{
			add_menu(elgg_echo('photos'), $CONFIG->wwwroot . "pg/photos/owned/" . $_SESSION['user']->username);
		}
				
		// Extend CSS
		extend_view('css', 'tidypics/css');
		
		// Extend hover-over and profile menu	
		extend_view('profile/menu/links','tidypics/menu');
		
		//group view  ** psuedo widget view for group pages**
		extend_view('groups/right_column','tidypics/groupprofile_albums');
		
		// Register a page handler, so we can have nice URLs
		register_page_handler('photos','tidypics_page_handler');
			
		// Add a new tidypics widget
		add_widget_type('album_view', elgg_echo("album:widget"), elgg_echo("album:widget:description"), 'profile');
		
		// Register a URL handler for files
		register_entity_url_handler('image_url','object','image');
		register_entity_url_handler('album_url','object','album');

		// Register entity type
		register_entity_type('object','image');
		register_entity_type('object','album');
		
	}
	
	/**
	 * Sets up submenus for tidypics.  Triggered on pagesetup.
	 */
	function tidypics_submenus() {
		
		global $CONFIG;
		
		$page_owner = page_owner_entity();
		
		// context is only set to photos on individual pages, not on group pages		
		if (get_context() == "photos") {
			
			// owner gets "your albumn", "your friends albums"
			if (get_loggedin_userid() == $page_owner->guid) {
				add_submenu_item(	elgg_echo("album:yours"), 
									$CONFIG->wwwroot . "pg/photos/owned/" . $_SESSION['user']->username, 
									'1view' );

				add_submenu_item( 	elgg_echo('album:yours:friends'), 
									$CONFIG->wwwroot . "pg/photos/friends/". $page_owner->username, 
									'1view');						
			} else if (isloggedin()) {
				// logged nut not owner gets "your albums", "page owners albums", "page owner's friends albums"
				add_submenu_item(	elgg_echo("album:yours"), 
									$CONFIG->wwwroot . "pg/photos/owned/" . $_SESSION['user']->username, 
									'1view' );
				add_submenu_item(	sprintf(elgg_echo("album:user"), $page_owner->name), 
									$CONFIG->wwwroot . "pg/photos/owned/" . $page_owner->username, 
									'1view' );				
				add_submenu_item( 	sprintf(elgg_echo('album:friends'),$page_owner->name), 
									$CONFIG->wwwroot . "pg/photos/friends/". $page_owner->username, 
									'1view');			
			} else {
				// non logged in user gets "page owners albums", "page owner's friends albums" 
				add_submenu_item(	sprintf(elgg_echo("album:user"), $page_owner->name), 
									$CONFIG->wwwroot . "pg/photos/owned/" . $page_owner->username, 
									'1view' );				
				add_submenu_item( 	sprintf(elgg_echo('album:friends'),$page_owner->name), 
									$CONFIG->wwwroot . "pg/photos/friends/". $page_owner->username, 
									'1view');			
			}
			
			add_submenu_item(	sprintf(elgg_echo('album:all'),$page_owner->name), 
								$CONFIG->wwwroot . "pg/photos/world/", 
								'1view');			
		}
		
		if (isloggedin() && ($page_owner instanceof ElggGroup)) {
			add_submenu_item(sprintf(elgg_echo("album:user"),$page_owner->name), 
							$CONFIG->wwwroot . "pg/photos/owned/" . $page_owner->username, 
							'photo_albums');
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

				/* if you want to put new album action in the submenu, just do it like this --------->				
					if(can_write_to_container($_SESSION['guid'], page_owner())){
						add_submenu_item(elgg_echo('album:create'), $CONFIG->wwwroot . "pg/photos/new/". page_owner_entity()->username, 'pagesactions');	
					}
				*/
					include($CONFIG->pluginspath . "tidypics/index.php");					
				break;	
				
    			case "view": //view an image individually					
    				set_input('guid',$page[1]);
					include($CONFIG->pluginspath . "tidypics/view.php");	
				break;

				case "album": //view an album individually	
    				set_input('guid',$page[1]);
					@include(dirname(dirname(dirname(__FILE__))) . "/entities/index.php");
				break;

				case "new":  //create new album					
					if (isset($page[1])) set_input('username',$page[1]); 
    				include($CONFIG->pluginspath . "tidypics/newalbum.php");
          		break;
				
    			case "upload": //upload images to album				
					if (isset($page[1])) set_input('container_guid',$page[1]);
    				include($CONFIG->pluginspath . "tidypics/upload.php");
          		break;
				
    			case "friends": 
					if (isset($page[1])) set_input('username',$page[1]);
    				include($CONFIG->pluginspath . "tidypics/friends.php");
          		break;
				
   				case "world":  
   					include($CONFIG->pluginspath . "tidypics/world.php");
          		break;
				
    		}
		}
		else
		{
			// Include the standard profile index
			if (isset($page[1])) set_input('username',$page[1]); 
			include($CONFIG->pluginspath . "tidypics/index.php");
		}
		
	}
		
	/**
	 * Populates the ->getUrl() method for file objects
	 *
	 * @param ElggEntity $entity album/image entity
	 * @return string File URL
	 */
		function image_url($entity) {		
			global $CONFIG;
			$title = $entity->title;
			$title = friendly_title($title);
			return $CONFIG->url . "pg/photos/view/" . $entity->getGUID() . "/" . $title;
			
		}
		
		function album_url($entity) {			
			global $CONFIG;
			$title = $entity->title;
			$title = friendly_title($title);
			return $CONFIG->url . "pg/photos/album/" . $entity->getGUID() . "/" . $title;
			
		}
	
	// Make sure tidypics_init is called on initialisation
	register_elgg_event_handler('init','system','tidypics_init');
	register_elgg_event_handler('pagesetup','system','tidypics_submenus');
	
	// Register actions
	register_action("tidypics/upload", false, $CONFIG->pluginspath . "tidypics/actions/upload.php");
	register_action("tidypics/addalbum", false, $CONFIG->pluginspath. "tidypics/actions/addalbum.php");
	register_action("tidypics/editalbum", false, $CONFIG->pluginspath. "tidypics/actions/editalbum.php");
	register_action("tidypics/delete", false, $CONFIG->pluginspath. "tidypics/actions/delete.php");
	register_action("tidypics/icon", true, $CONFIG->pluginspath. "tidypics/actions/icon.php");
	register_action("tidypics/edit_multi", false, $CONFIG->pluginspath. "tidypics/actions/edit_multi.php");
	register_action("tidypics/download", true, $CONFIG->pluginspath . "tidypics/actions/download.php");

?>