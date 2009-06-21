<?php

/********************************************
 *
 * Upgrade from Tidypics 1.5 to 1.6
 *
 *********************************************/

	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
 
	$result = true;
	
	// add image class
	$id = get_subtype_id("object", "image"); 
	if ($id != 0) {
		$table = $CONFIG->dbprefix . 'entity_subtypes';
		$result = update_data("UPDATE {$table} set class='TidypicsImage' where id={$id}");
		if (!result) {
			register_error(elgg_echo('tidypics:upgrade:failed'));
			forward($_SERVER['HTTP_REFERER']);
		}
	}

	// add album class
	$id = get_subtype_id("object", "album"); 
	if ($id != 0) {
		$table = $CONFIG->dbprefix . 'entity_subtypes';
		$result = update_data("UPDATE {$table} set class='TidypicsAlbum' where id={$id}");
		if (!result) {
			register_error(elgg_echo('tidypics:upgrade:failed'));
			forward($_SERVER['HTTP_REFERER']);
		}
	}

	system_message(elgg_echo('tidypics:upgrade:success'));
	
	forward($_SERVER['HTTP_REFERER']);
?>