<?php
	/**
	 * Elgg Photos
	 * 
	 * @package ElggPages
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.com/
	 */

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	gatekeeper();
	global $CONFIG;
	
	
	// Get the current page's owner
		if ($album = (int) get_input('container_guid')) 
		{
			$album_entity = get_entity($album);
			
			//if album does not exist or user does not have access
			if(!$album_entity || !$album_entity->canEdit())
				forward('pg/photos/owned/');
			
			//set group to "real" container
			$container = $album_entity->container_guid;				
			set_page_owner($container);
		}
		else
			forward('pg/photos/owned/');
				
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($page_owner->getGUID());
		}
		
	set_context('photos');
	$title = elgg_echo('album:addpix');
	$area2 .= elgg_view_title($title);

	$area2 .= '<h2><a href="' . $album_entity->getURL() . '">'. $album_entity->title. '</a></h2>';
	
	$area2 .= elgg_view("tidypics/forms/upload", array('album' => $album ) );	
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2, $area3);
	
	page_draw($title, $body);
?>