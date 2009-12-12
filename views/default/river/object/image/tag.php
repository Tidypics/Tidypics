<?php

	$image = get_entity($vars['item']->subject_guid);
	$person_tagged = get_entity($vars['item']->object_guid);
	if($image->title) {
		$title = $image->title;
	} else {
		$title = "untitled";
	}
	
	// viewer may not have permission to view image
	if (!$image)
		return;
	
	
	$image_url = "<a href=\"{$image->getURL()}\">{$title}</a>";
	$person_url = "<a href=\"{$person_tagged->getURL()}\">{$person_tagged->name}</a>";
	
	$string = $person_url . ' ' . elgg_echo('image:river:tagged') . ' ' . $image_url;
	
	echo $string;

?>