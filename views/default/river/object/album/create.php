<?php

	$performed_by = get_entity($vars['item']->subject_guid);
	$album = get_entity($vars['item']->object_guid);
	
	$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$string = sprintf(elgg_echo("album:river:created"),$url) . " ";
	$string .= "<a href=\"" . $album->getURL() . "\">" . $album->title . "</a>";

	$album_river_view = get_plugin_setting('album_river_view', 'tidypics');
	
	if ($album_river_view == "cover") {
		if ($album->cover) {
			$string .= "<div class=\"river_content\"> <img src=\"" . $CONFIG->wwwroot . 'mod/tidypics/thumbnail.php?file_guid=' . $album->cover . '&size=thumb" border="0" class="tidypics_album_cover"  alt="thumbnail"/>' . "</div>";
		}
	} else {

		$string .= "<div class=\"river_content\">";
		
		$images = get_entities("object", "image", $album->guid, 'time_created desc', 7);

		if (count($images)) {
			foreach($images as $image){
				$string .= "<a href=\"" . $image->getURL() . "\"> <img src=\"" . $CONFIG->wwwroot . 'mod/tidypics/thumbnail.php?file_guid=' . $image->guid . '&size=thumb" border="0" class="tidypics_album_cover"  alt="thumbnail"/> </a>';
			}
		}

		$string .= "</div>";
	}

echo $string;

?>
