<?php

	/**
	 * Tidypics Album View Page
	 */

	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	// get the album entity
	$album_guid = (int) get_input('guid');
	$album = get_entity($album_guid);

	// panic if we can't get it
	if (!$album) forward();

	// container should always be set, but just in case
	if ($album->container_guid)
		set_page_owner($album->container_guid);
	else
		set_page_owner($album->owner_guid);

	// if this page belongs to a closed group, prevent anyone outside group from seeing
	if (is_callable('group_gatekeeper')) group_gatekeeper();

	$owner = page_owner_entity();

	// setup group menu
	if ($owner instanceof ElggGroup) {
		add_submenu_item(	sprintf(elgg_echo('album:group'),$owner->name), 
							$CONFIG->wwwroot . "pg/photos/owned/" . $owner->username);
	}

	if (can_write_to_container(0, $album->container_guid)) {
		if ($owner instanceof ElggGroup) {
			add_submenu_item(	elgg_echo('album:create'),
								$CONFIG->wwwroot . 'pg/photos/new/' . $owner->username,
								'photos');
		}
		add_submenu_item(	elgg_echo('album:addpix'),
							$CONFIG->wwwroot . 'pg/photos/upload/' . $album_guid,
							'photos');
		add_submenu_item(	elgg_echo('album:edit'),
							$CONFIG->wwwroot . 'pg/photos/edit/' . $album_guid,
							'photos');
		add_submenu_item(	elgg_echo('album:delete'),
							$CONFIG->wwwroot . 'pg/photos/delete/' . $album_guid,
							'photos',
							true);
	}

	// create body
	$area2 = elgg_view_entity($album, true);
	$body = elgg_view_layout('two_column_left_sidebar', '', $area2);

	page_draw($album->title, $body);
?>