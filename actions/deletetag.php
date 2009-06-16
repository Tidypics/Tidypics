<?php
	/**
	 * Tidypics Delete Photo Tag
	 * 
	 */

	gatekeeper();
	action_gatekeeper();

	//$user_id = get_input('user_id');
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
		
		// delete the photo tag annotation
		delete_annotation($id);
	}
	
	system_message(elgg_echo("tidypics:deletetag:success"));

	forward($_SERVER['HTTP_REFERER']);

?>
