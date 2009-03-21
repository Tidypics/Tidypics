<?php

if (function_exists('add_to_river')) { // Elgg 1.5
	$performed_by = get_entity($vars['item']->subject_guid);
	$album = get_entity($vars['item']->object_guid);
	
	$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$string = sprintf(elgg_echo("album:river:created"),$url) . " ";
	$string .= "<a href=\"" . $album->getURL() . "\">" . $album->title . "</a>";
} else {  // Elgg 1.2
	$statement = $vars['statement'];
	$performed_by = $statement->getSubject();
	$object = $statement->getObject();
        
	$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$string = sprintf(elgg_echo("album:river:created"),$url) . " ";
	$string .= "<a href=\"" . $object->getURL() . "\">" . $object->title . "</a>";
}

echo $string;
	
?>