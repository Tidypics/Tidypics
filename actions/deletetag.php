<?php
	/**
	 * Tidypics Delete Photo Tag
	 * 
	 */

	gatekeeper();
	action_gatekeeper();

	$image_guid = get_input('image_guid');
	$tags = get_input('tags');
	
	
	if ($image_guid == 0) {
		register_error(elgg_echo("tidypics:phototagging:error"));
		forward($_SERVER['HTTP_REFERER']);
	}

	$image = get_entity($image_guid);
	if (!$image)
	{
		register_error(elgg_echo("tidypics:phototagging:error"));
		forward($_SERVER['HTTP_REFERER']);
	}
	
	foreach ($tags as $id => $value) {
		// delete normal tag if it exists
		if (is_array($image->tags)) {
			$index = array_search($value[0], $image->tags);
			if ($index !== false) {
				$tagarray = $image->tags;
				unset($tagarray[$index]);
				$image->clearMetadata('tags');
				$image->tags = $tagarray;
			}
		} else {
			if ($value[0] === $image->tags) {
				$image->clearMetadata('tags');
			}
		}
		
		// delete relationship if this tag is a user
		$annotation = get_annotation($id);
		$photo_tag = unserialize($annotation->value);
		if ($photo_tag->type == 'user') {
			remove_entity_relationship($photo_tag->value, 'phototag', $image_guid);
		}
		
		// delete the photo tag annotation
		delete_annotation($id);
	}
	
	system_message(elgg_echo("tidypics:deletetag:success"));

	forward($_SERVER['HTTP_REFERER']);

?>
