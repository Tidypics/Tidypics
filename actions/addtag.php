<?php
	/**
	 * Tidypics Add Tag
	 * 
	 */

	gatekeeper();
	action_gatekeeper();

	$coordinates_str = get_input('coordinates');

	$user_id = get_input('user_id');
	$image_guid = get_input('image_guid');
	$word = get_input('word');

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

	$new_word_tag = false;
	if ($user_id != 0) {
		$relationships_type = 'user';
		$value = $user_id;
	} else {
		$relationships_type = 'word';
		$value = $word;
		
		// check to see if the photo has this tag and add if not
		if (!is_array($image->tags)) {
			if ($image->tags != $word) {
				$new_word_tag = true;
				$tagarray = $image->tags . ',' . $word;
				$tagarray = string_to_tag_array($tagarray);
			}
		} else {
			if (!in_array($word, $image->tags)) {
				$new_word_tag = true;
				$tagarray = $image->tags;
				$tagarray[] = $word;
			}
		}
	}
	
	// add new tag now so it is available in search
	if ($new_word_tag) {
		$image->clearMetadata('tags');
		$image->tags = $tagarray;
	}

	// test for empty tag

	// create string for javascript tag object
	$tag->coords = $coordinates_str;
	$tag->type   = $relationships_type;
	$tag->value  = $value;

	$access_id = $image->getAccessID();
	$owner_id = get_loggedin_userid();

	//Save annotation
	if ($image->annotate('phototag', serialize($tag), $access_id, $owner_id)) {
		system_message(elgg_echo("tidypics:phototagging:success"));
	}


	forward($_SERVER['HTTP_REFERER']);

?>