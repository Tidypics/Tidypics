<?php
/**
 * Photo Gallery plugin
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

elgg_register_event_handler('init', 'system', 'tidypics_init');

/**
 * Tidypics plugin initialization
 */
function tidypics_init() {

	// Include core libraries
	require dirname(__FILE__) . "/lib/tidypics.php";
	
	// Set up site menu
	elgg_register_menu_item('site', array(
		'name' => 'photos',
		'href' => 'photos/all',
		'text' => elgg_echo('photos'),
	));

	// Extend CSS
	elgg_extend_view('css/elgg', 'tidypics/css');

	// Add photos link to owner block/hover menus
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'tidypics_owner_block_menu');

	// Add admin menu item
	elgg_register_admin_menu_item('configure', 'tidypics', 'settings');

/*
	// Extend hover-over and profile menu
	elgg_extend_view('profile/menu/links','tidypics/hover_menu');

	//group view  ** psuedo widget view for group pages**
	elgg_extend_view('groups/right_column','tidypics/groupprofile_albums');

	// rss extensions
	elgg_extend_view('extensions/xmlns', 'extensions/tidypics/xmlns');
	elgg_extend_view('extensions/channel', 'extensions/tidypics/channel');

	// Register a page handler so we can have nice URLs
	elgg_register_page_handler('photos', 'tidypics_page_handler');

	// register for menus
	//register_elgg_event_handler('pagesetup', 'system', 'tidypics_submenus');
	register_elgg_event_handler('pagesetup', 'system', 'tidypics_adminmenu');

	// Add a new tidypics widget
	add_widget_type('album_view', elgg_echo("tidypics:widget:albums"), elgg_echo("tidypics:widget:album_descr"), 'profile');
	add_widget_type('latest_photos', elgg_echo("tidypics:widget:latest"), elgg_echo("tidypics:widget:latest_descr"), 'profile');

	// Register a URL handler for files
	register_entity_url_handler('tidypics_image_url', 'object', 'image');
	register_entity_url_handler('tidypics_album_url', 'object', 'album');

	// add the class files for image and album
	add_subtype("object", "image", "TidypicsImage");
	add_subtype("object", "album", "TidypicsAlbum");

	// Register entity type
	register_entity_type('object','image');
	register_entity_type('object','album');

	add_group_tool_option('photos', elgg_echo('tidypics:enablephotos'), true);

	if (get_plugin_setting('grp_perm_override', 'tidypics') != "disabled") {
		register_plugin_hook('permissions_check', 'object', 'tidypics_permission_override');
	}

	// Register for notifications
	register_notification_object('object', 'album', elgg_echo('tidypics:newalbum'));
	register_plugin_hook('notify:entity:message', 'object', 'tidypics_notify_message');

	// slideshow plugin hook
	register_plugin_hook('tp_slideshow', 'album', 'tidypics_slideshow');

	// ajax handler for uploads when use_only_cookies is set
	register_plugin_hook('forward', 'system', 'tidypics_ajax_session_handler');
*/
	// Register actions
	$base_dir = elgg_get_plugins_path() . 'tidypics/actions/photos';
	elgg_register_action("photos/album/save", "$base_dir/album/save.php");
	elgg_register_action("photos/delete", "$base_dir/delete.php");
	elgg_register_action("photos/image/upload", "$base_dir/image/upload.php");
	elgg_register_action("photos/batch/edit", "$base_dir/batch/edit.php");
	register_action("tidypics/ajax_upload", true, "$base_dir/ajax_upload.php");
	register_action("tidypics/ajax_upload_complete", true, "$base_dir/ajax_upload_complete.php");
	register_action("tidypics/sortalbum", false, "$base_dir/sortalbum.php");
	register_action("tidypics/edit", false, "$base_dir/edit.php");
	register_action("tidypics/addtag", false, "$base_dir/addtag.php");
	register_action("tidypics/deletetag", false, "$base_dir/deletetag.php");

	elgg_register_action("photos/admin/settings", "$base_dir/admin/settings.php", 'admin');
	register_action("tidypics/admin/upgrade", false, "$base_dir/admin/upgrade.php", true);

	// Register libraries
	$base_dir = elgg_get_plugins_path() . 'tidypics/lib';
	elgg_register_library('tidypics:upload', "$base/upload.php");
	elgg_register_library('tidypics:resize', "$base/resize.php");
}

/**
 * Sets up sidebar menus for tidypics.  Triggered on pagesetup.
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

		// owner gets "your albumn", "your friends albums", "your most recent", "your most viewed"
		if (get_loggedin_userid() && get_loggedin_userid() == $page_owner->guid) {

			add_submenu_item(	elgg_echo('album:create'),
					$CONFIG->wwwroot . "pg/photos/new/{$page_owner->username}/",
					'tidypics-a' );

			add_submenu_item(	elgg_echo("album:yours"),
					$CONFIG->wwwroot . "pg/photos/owned/{$page_owner->username}/",
					'tidypics-a' );

			add_submenu_item( 	elgg_echo('album:yours:friends'),
					$CONFIG->wwwroot . "pg/photos/friends/{$page_owner->username}/",
					'tidypics-a');

			add_submenu_item(	elgg_echo('tidypics:yourmostrecent'),
					$CONFIG->wwwroot . "pg/photos/mostrecent/{$page_owner->username}/",
					'tidypics-a');

			if ($view_count != 'disabled') {
				add_submenu_item(	elgg_echo('tidypics:yourmostviewed'),
						$CONFIG->wwwroot . "pg/photos/mostviewed/{$page_owner->username}/",
						'tidypics-a');
			}

		} else if (isloggedin()) {

			$user = get_loggedin_user();

			// logged in not owner gets "page owners albums", "page owner's friends albums", "page owner's most viewed", "page owner's most recent"
			// and then "your albums", "your most recent", "your most viewed"
			add_submenu_item(	elgg_echo("album:yours"),
					$CONFIG->wwwroot . "pg/photos/owned/{$user->username}/",
					'tidypics-b' );

			add_submenu_item(	elgg_echo('tidypics:yourmostrecent'),
					$CONFIG->wwwroot . "pg/photos/mostrecent/{$user->username}/",
					'tidypics-b');

			if ($view_count != 'disabled') {
				add_submenu_item(	elgg_echo('tidypics:yourmostviewed'),
						$CONFIG->wwwroot . "pg/photos/mostviewed/{$user->username}/",
						'tidypics-b');
			}

			if ($page_owner->name) { // check to make sure the owner set their display name
				add_submenu_item(	sprintf(elgg_echo("album:user"), $page_owner->name),
						$CONFIG->wwwroot . "pg/photos/owned/{$page_owner->username}/",
						'tidypics-a' );
				add_submenu_item( 	sprintf(elgg_echo('album:friends'),$page_owner->name),
						$CONFIG->wwwroot . "pg/photos/friends/{$page_owner->username}/",
						'tidypics-a');

				if ($view_count != 'disabled') {
					add_submenu_item( 	sprintf(elgg_echo('tidypics:friendmostviewed'),$page_owner->name),
							$CONFIG->wwwroot . "pg/photos/mostviewed/{$page_owner->username}/",
							'tidypics-a');
				}

				add_submenu_item( 	sprintf(elgg_echo('tidypics:friendmostrecent'),$page_owner->name),
						$CONFIG->wwwroot . "pg/photos/mostrecent/{$page_owner->username}/",
						'tidypics-a');
			}
		} else if ($page_owner->guid) {
			// non logged in user gets "page owners albums", "page owner's friends albums"
			add_submenu_item(	sprintf(elgg_echo("album:user"), $page_owner->name),
					$CONFIG->wwwroot . "pg/photos/owned/{$page_owner->username}/",
					'tidypics-a' );
			add_submenu_item( 	sprintf(elgg_echo('album:friends'),$page_owner->name),
					$CONFIG->wwwroot . "pg/photos/friends/{$page_owner->username}/",
					'tidypics-a');
		}

		// everyone gets world albums, most recent, most viewed, most recently viewed, recently commented
		add_submenu_item(	elgg_echo('album:all'),
				$CONFIG->wwwroot . "pg/photos/world/",
				'tidypics-z');
		add_submenu_item(	elgg_echo('tidypics:mostrecent'),
				$CONFIG->wwwroot . 'pg/photos/mostrecent/',
				'tidypics-z');

		if ($view_count != 'disabled') {
			add_submenu_item(	elgg_echo('tidypics:mostviewed'),
					$CONFIG->wwwroot . 'pg/photos/mostviewed/',
					'tidypics-z');
			add_submenu_item(	elgg_echo('tidypics:recentlyviewed'),
					$CONFIG->wwwroot . 'pg/photos/recentlyviewed/',
					'tidypics-z');
		}
		add_submenu_item(	elgg_echo('tidypics:recentlycommented'),
				$CONFIG->wwwroot . 'pg/photos/recentlycommented/',
				'tidypics-z');
	}

}

/**
 * Sets up tidypics admin menu. Triggered on pagesetup.
 */
function tidypics_adminmenu() {
	global $CONFIG;

	if (get_context() == 'admin' && isadminloggedin()) {
		add_submenu_item(elgg_echo('tidypics:administration'), $CONFIG->url . "pg/photos/admin/");
	}
}

/**
 * Sets up submenus for tidypics most viewed pages
 */
function tidypics_mostviewed_submenus() {

	global $CONFIG;

	add_submenu_item(elgg_echo('tidypics:mostvieweddashboard'), $CONFIG->url . "mod/tidypics/mostvieweddashboard.php");
	add_submenu_item(elgg_echo('tidypics:mostviewedthisyear'), $CONFIG->url . "mod/tidypics/pages/lists/mostviewedimagesthisyear.php");
	add_submenu_item(elgg_echo('tidypics:mostviewedthismonth'), $CONFIG->url . "mod/tidypics/pages/lists/mostviewedimagesthismonth.php");
	add_submenu_item(elgg_echo('tidypics:mostviewedlastmonth'), $CONFIG->url . "mod/tidypics/pages/lists/mostviewedimageslastmonth.php");
	add_submenu_item(elgg_echo('tidypics:mostviewedtoday'), $CONFIG->url . "mod/tidypics/pages/lists/mostviewedimagestoday.php");
	add_submenu_item(elgg_echo('tidypics:mostcommented'), $CONFIG->url . "mod/tidypics/pages/lists/mostcommentedimages.php");
	add_submenu_item(elgg_echo('tidypics:mostcommentedthismonth'), $CONFIG->url . "mod/tidypics/pages/lists/mostcommentedimagesthismonth.php");
	add_submenu_item(elgg_echo('tidypics:mostcommentedtoday'), $CONFIG->url . "mod/tidypics/pages/lists/mostcommentedimagestoday.php");
	add_submenu_item(elgg_echo('tidypics:recentlycommented'), $CONFIG->wwwroot . 'pg/photos/recentlycommented/');
}

/**
 * Tidypics page handler
 *
 * @param array $page Array of url segments
 */
function tidypics_page_handler($page) {

	if (!isset($page[0])) {
		return false;
	}

	$base = elgg_get_plugins_path() . 'tidypics/pages/photos';
	switch($page[0]) {
		case "all": // all site albums
		case "world":
			require "$base/all.php";
			break;

		case "owned":  // albums owned by container entity
		case "owner":
			require "$base/owner.php";
			break;

		case "friends": // albums of friends
			require "$base/friends.php";
			break;

		case "group": // albums of a group
			require "$base/owner.php";
			break;

		case "album": // view an album individually
			set_input('guid', $page[1]);
			require "$base/album/view.php";
			break;

		case "new":  // create new album
		case "add":
			set_input('guid', $page[1]);
			require "$base/album/add.php";
			break;

		case "edit": //edit image or album
			set_input('guid', $page[1]);
			$entity = get_entity($page[1]);
			switch ($entity->getSubtype()) {
				case 'album':
					require "$base/album/edit.php";
					break;
				case 'tidypics_batch':
					require "$base/batch/edit.php";
					break;
				default:
					return false;
			}
			break;

		case "sort": //sort a photo album
			if (isset($page[1])) {
				set_input('guid', $page[1]);
			}
			include($CONFIG->pluginspath . "tidypics/pages/sortalbum.php");
			break;

		case "image": //view an image
		case "view":
			set_input('guid', $page[1]);
			require "$base/image/view.php";
			break;

		case "thumbnail": // tidypics thumbnail
			set_input('guid', $page[1]);
			set_input('size', elgg_extract(2, $page, 'small'));
			require "$base/image/thumbnail.php";
			break;

		case "upload": // upload images to album
			set_input('guid', $page[1]);
			set_input('uploader', elgg_extract(2, $page, 'basic'));
			require "$base/image/upload.php";
			break;

		case "batch": //update titles and descriptions
			if (isset($page[1])) {
				set_input('batch', $page[1]);
			}
			include($CONFIG->pluginspath . "tidypics/pages/edit_multiple.php");
			break;

		case "download": // download an image
			if (isset($page[1])) {
				set_input('file_guid', $page[1]);
			}
			if (isset($page[2])) {
				set_input('type', $page[2]);
			}
			include($CONFIG->pluginspath . "tidypics/pages/download.php");
			break;

		case "tagged": // all photos tagged with user
			if (isset($page[1])) {
				set_input('guid', $page[1]);
			}
			include($CONFIG->pluginspath . "tidypics/pages/tagged.php");
			break;

		case "mostviewed": // images with the most views
			if (isset($page[1])) {
				set_input('username', $page[1]);
			}
			include($CONFIG->pluginspath . "tidypics/pages/lists/mostviewedimages.php");
			break;

		case "mostrecent": // images uploaded most recently
			if (isset($page[1])) {
				set_input('username', $page[1]);
			}
			include($CONFIG->pluginspath . "tidypics/pages/lists/mostrecentimages.php");
			break;

		case "recentlyviewed": // images most recently viewed
			include($CONFIG->pluginspath . "tidypics/pages/lists/recentlyviewed.php");
			break;

		case "recentlycommented": // images with the most recent comments
			include($CONFIG->pluginspath . "tidypics/pages/lists/recentlycommented.php");
			break;

		case "highestrated": // images with the highest average rating
			include($CONFIG->pluginspath . "tidypics/pages/lists/highestrated.php");
			break;

		case "admin":
			include ($CONFIG->pluginspath . "tidypics/pages/admin.php");
			break;

		default:
			return false;
	}
	
	return true;
}

/**
 * Add a menu item to an ownerblock
 */
function tidypics_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "photos/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('photos', elgg_echo('photos'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->blog_enable != "no") {
			$url = "photos/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('photos', elgg_echo('photos:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Override permissions for group albums and images
 *
 * @param string $hook
 * @param string $type
 * @param bool   $result
 * @param array  $params
 * @return mixed
 */
function tidypics_permission_override($hook, $type, $result, $params) {
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
 * @param string $hook
 * @param string $type
 * @param bool   $result
 * @param array  $params
 * @return mixed
 */
function tidypics_notify_message($hook, $type, $result, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'album')) {
		
		// block notification message when the album doesn't have any photos
		if ($entity->new_album == TP_NEW_ALBUM) {
			return false;
		}

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


/**
 * Catch the plugin hook and add the default album slideshow
 *
 * @param $hook - 'tidypics:slideshow'
 * @param $entity_type - 'album'
 * @param $returnvalue - if set, return because another plugin has used the hook
 * @param $params - arry containing album entity
 * @return unknown_type
 */
function tidypics_slideshow($hook, $entity_type, $returnvalue, $params) {

	if ($returnvalue !== null) {
		// someone has already added a slideshow or requested that the slideshow is not used
		return $returnvalue;
	}

	$url = current_page_url();
	if (strpos($url, '?')) {
		$url = substr($url, 0, strpos($url, '?'));
	}
	$url = "$url?limit=50&amp;view=rss";
	$slideshow_link = "javascript:PicLensLite.start({maxScale:0,feedUrl:'$url'})";

	// add the slideshow javascript to the header
	elgg_extend_view('metatags', 'tidypics/js/slideshow');

	return $slideshow_link;
}

/**
 * Convenience function for listing recent images
 * 
 * @param int $max
 * @param bool $pagination
 * @return string
 */
function tp_mostrecentimages($max = 8, $pagination = true) {
	return list_entities("object", "image", 0, $max, false, false, $pagination);
}

/**
 * Work around for Flash/session issues
 *
 * @param string $hook
 * @param string $entity_type
 * @param string $returnvalue
 * @param array  $params
 */
function tidypics_ajax_session_handler($hook, $entity_type, $returnvalue, $params) {
    global $CONFIG;

    $url = current_page_url();
    if ($url !== "{$CONFIG->wwwroot}action/tidypics/ajax_upload/") {
        return;
    }

    if (get_loggedin_userid() != 0) {
        return;
    }

    // action_gatekeeper rejected ajax call from Flash due to session issue
    
	// Validate token
    $token = get_input('__elgg_token');
    $ts = get_input('__elgg_ts');
    $session_id = get_input('Elgg');
	$tidypics_token = get_input('tidypics_token');
	$user_guid = get_input('user_guid');

	$user = get_user($user_guid);
	if (!$user) {
		return;
	}

	if (!$token || !$ts || !$session_id || !$tidypics_token) {
		return;
	}

	$hour = 60*60;
	$now = time();
	if ($ts < $now-$hour || $ts > $now+$hour) {
		return;
	}

	$generated_token = md5($session_id . get_site_secret() . $ts . $user->salt);

	if ($tidypics_token !== $generated_token) {
		return;
	}

	// passed token test, so login and process action
	login($user);
	include $CONFIG->actions['tidypics/ajax_upload']['file'];

	exit;
}
