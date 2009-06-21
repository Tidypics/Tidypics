<?php

	$performed_by = get_entity($vars['item']->subject_guid);
	$image = get_entity($vars['item']->object_guid);
	if($image->title) {
		$title = $image->title;
	} else {
		$title = "untitled";
	}

	$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$album = get_entity($image->container_guid);

	$album_link = "<a href='". $album->getURL() . "'>" . $album->title . "</a>";
	$image_link = "<a href=\"" . $image->getURL() . "\">" . $title . "</a>";
	
	$string = sprintf(elgg_echo("image:river:created"),$performed_by->name, $image_link, $album_link);
		
	$string .= "<div class=\"river_content\">";

/*	// this adds the album cover to the river display 
	$string .= "<a href=\"" . $album->getURL() . "\"> <img src=\"" . $CONFIG->wwwroot . 'mod/tidypics/thumbnail.php?file_guid=' . $album->cover . '&size=thumb" class="tidypics_album_cover"  alt="thumbnail"/> </a>';
*/
	$string .= "<a href=\"" . $image->getURL() . "\"> <img src=\"" . $CONFIG->wwwroot . 'mod/tidypics/thumbnail.php?file_guid=' . $image->guid . '&size=thumb" class="tidypics_album_cover"  alt="thumbnail"/> </a>';
	$string .= "</div>";
	
	echo $string;

?>