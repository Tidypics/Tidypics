<?php
	/**
	 * Tidypics Add Tag
	 * 
	 */

	gatekeeper();
	action_gatekeeper();

	$coordinates_str = get_input('coordinates');
	error_log($coordinates_str);

	$user_id = get_input('user_id');
	$image_guid = get_input('image_guid');
	$word = get_input('word');

	error_log($word);
	error_log($user_id);

	if ($image_guid == 0) {
		register_error("error");
		forward($_SERVER['HTTP_REFERER']);
	}

	$image = get_entity($image_guid);
	if (!$image)
	{
		register_error(elgg_echo("image:phototagging:notexists"));
		forward($_SERVER['HTTP_REFERER']);
	}

	if ($user_id != 0) {
		$relationships_type = 'user';
		$value = $user_id;
	} else {
		$relationships_type = 'word';
		$value = $word;
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
		system_message(elgg_echo("image:tagged"));
	}


	forward($_SERVER['HTTP_REFERER']);

?>