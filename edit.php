<?php
	/**
	 * Elgg file saver
	 * 
	 * @package ElggFile
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.com/
	 */

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	gatekeeper();
	set_context('photos');		
	$file = (int) get_input('file_guid');

		if (!$file = get_entity($file)) 
			forward();

		if(!$file->canEdit()) 
			forward();

		$subtype = $file->getSubtype();
		
		if($subtype == 'album'){
			if($container = $file->container_guid)
				set_page_owner($container);
			
			$area2 .= elgg_view_title($title = elgg_echo('album:edit'));	
		}
		elseif($subtype == 'image'){
			if($container = get_entity($file->container_guid)->container_guid)
				set_page_owner($container);	
		
			$area2 .= elgg_view_title($title = elgg_echo('image:edit'));	
		}
		else{
			forward();
		}
			
    	$area2 .= elgg_view("tidypics/forms/edit",array('entity' => $file, 'subtype' => $subtype));
		$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
		page_draw(elgg_echo("edit"), $body);

	
?>