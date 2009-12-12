<?php
	/**
	 * Tidypics Add Photo Tag
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

	// test for empty tag
	if ($user_id == 0 && empty($word)) {
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

	// create string for javascript tag object
	$tag->coords = $coordinates_str;
	$tag->type   = $relationships_type;
	$tag->value  = $value;

	$access_id = $image->getAccessID();
	$owner_id = get_loggedin_userid();
	$tagger = get_loggedin_user();

	//Save annotation
	if ($image->annotate('phototag', serialize($tag), $access_id, $owner_id)) {
		// if tag is a user id, add relationship for searching (find all images with user x)
		if ($relationships_type === 'user') {
			if (!check_entity_relationship($user_id, 'phototag', $image_guid)) {
				add_entity_relationship($user_id, 'phototag', $image_guid);
				
				// also add this to the river - subject is image, object is the tagged user
				if (function_exists('add_to_river'))
					add_to_river('river/object/image/tag', 'tag', $image_guid, $user_id, $access_id);
				
				// notify user of tagging as long as not self
				if ($owner_id != $user_id)
					notify_user($user_id, $owner_id, elgg_echo('tidypics:tag:subject'), 
						sprintf(
									elgg_echo('tidypics:tag:body'),
									$image->title,
									$tagger->name,
									$image->getURL()
								)
					);
			}
		}
	
		system_message(elgg_echo("tidypics:phototagging:success"));
	}


	forward($_SERVER['HTTP_REFERER']);

?>
