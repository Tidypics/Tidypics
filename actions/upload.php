<?php
/**
 * Elgg multi-image uploader action
 *
 * This will upload up to 10 images at at time to an album
 */

include_once dirname(dirname(__FILE__)) . "/lib/upload.php";

// Get common variables
$access_id = (int) get_input("access_id");
$container_guid = (int) get_input('container_guid', 0);
$album = get_entity($container_guid);
if (!$album) {
	register_error(elgg_echo('tidypics:baduploadform'));
	forward($_SERVER['HTTP_REFERER']);
}

$maxfilesize = (float) get_plugin_setting('maxfilesize','tidypics'); 
if (!$maxfilesize) {
	$maxfilesize = 5; // default to 5 MB if not set
}
$maxfilesize = 1024 * 1024 * $maxfilesize; // convert to bytes from MBs

$quota = get_plugin_setting('quota','tidypics');
$quota = 1024 * 1024 * $quota;
$image_repo_size_md = get_metadata_byname($album->container_guid, "image_repo_size");
$image_repo_size = (int)$image_repo_size_md->value;

$image_lib = get_plugin_setting('image_lib', 'tidypics');
if (!$image_lib) {
	$image_lib = "GD";
}

$img_river_view = get_plugin_setting('img_river_view', 'tidypics');


// post limit exceeded
if (count($_FILES) == 0) {
	trigger_error('Tidypics warning: user exceeded post limit on image upload', E_USER_WARNING);
	register_error(elgg_echo('tidypics:exceedpostlimit'));
	forward($_SERVER['HTTP_REFERER']);
}

// test to make sure at least 1 image was selected by user
$num_images = 0;
foreach($_FILES as $key => $sent_file) {
	if (!empty($sent_file['name'])) {
		$num_images++;
	}
}
if ($num_images == 0) {
	// have user try again
	register_error(elgg_echo('tidypics:noimages'));
	forward($_SERVER['HTTP_REFERER']);
}

$uploaded_images = array();
$not_uploaded = array();
$error_msgs = array();

foreach($_FILES as $key => $sent_file) {

	// skip empty entries
	if (empty($sent_file['name'])) {
		continue;
	}

	$name = $sent_file['name'];
	$mime = $sent_file['type'];

	if ($sent_file['error']) {
		array_push($not_uploaded, $sent_file['name']);
		if ($sent_file['error'] == 1) {
			trigger_error('Tidypics warning: image exceeded server php upload limit', E_USER_WARNING);
			array_push($error_msgs, elgg_echo('tidypics:image_mem'));
		} else {
			array_push($error_msgs, elgg_echo('tidypics:unk_error'));
		}
		continue;
	}

	// must be an image
	if (!tp_upload_check_format($mime)) {
		array_push($not_uploaded, $sent_file['name']);
		array_push($error_msgs, elgg_echo('tidypics:not_image'));
		continue;
	}

	// check quota
	if ($quota) {
		if ($image_repo_size + $sent_file['size'] > $quota) {
			array_push($not_uploaded, $sent_file['name']);
			array_push($error_msgs, elgg_echo('tidypics:exceed_quota'));
			continue;
		}
	}

	// make sure file does not exceed memory limit
	if ($sent_file['size'] > $maxfilesize) {
		array_push($not_uploaded, $sent_file['name']);
		array_push($error_msgs, elgg_echo('tidypics:image_mem'));
		continue;
	}

	// make sure the in memory image size does not exceed memory available
	$imginfo = getimagesize($sent_file['tmp_name']);
	if (!tp_upload_memory_check($image_lib, $imginfo[0] * $imginfo[1])) {
		array_push($not_uploaded, $sent_file['name']);
		array_push($error_msgs, elgg_echo('tidypics:image_pixels'));
		trigger_error('Tidypics warning: image memory size too large for resizing so rejecting', E_USER_WARNING);
		continue;
	}

	//this will save to users folder in /image/ and organize by photo album
	$file = new TidypicsImage();
	$file->container_guid = $container_guid;
	$file->setMimeType($mime);
	$file->simpletype="image";
	$file->access_id = $access_id;
	//$file->title = substr($name, 0, strrpos($name, '.'));

	$file->setOriginalFilename($name);
	$file->saveImageFile(get_uploaded_file($key));
	$result = $file->save();

	if (!$result) {
		array_push($not_uploaded, $sent_file['name']);
		array_push($error_msgs, elgg_echo('tidypics:save_error'));
		continue;
	}

	$file->extractExifData();
	$file->saveThumbnails($image_lib);

	//keep one file handy so we can add a notice to the river if single image option selected
	if (!$file_for_river) {
		$file_for_river = $file;
	}

	array_push($uploaded_images, $file->guid);

	// update user/group size for checking quota
	$image_repo_size += $sent_file['size'];

	// plugins can register to be told when a new image has been uploaded
	trigger_elgg_event('upload', 'tp_image', $file);

	// successful upload so check if this is a new album and throw river event/notification if so
	if ($album->new_album == TP_NEW_ALBUM) {
		$album->new_album = TP_OLD_ALBUM;

		// we throw the notification manually here so users are not told about the new album until there
		// is at least a few photos in it
		object_notifications('create', 'object', $album);

		add_to_river('river/object/album/create', 'create', $album->owner_guid, $album->guid);
	}

	if ($img_river_view == "all") {
		add_to_river('river/object/image/create', 'create', $file->getObjectOwnerGUID(), $file->getGUID());
	}
	unset($file);  // may not be needed but there seems to be a memory leak

} //end of for loop

if (count($not_uploaded) > 0) {
	if (count($uploaded_images) > 0) {
		$error = sprintf(elgg_echo("tidypics:partialuploadfailure"), count($not_uploaded), count($not_uploaded) + count($uploaded_images))  . '<br />';
	} else {
		$error = elgg_echo("tidypics:completeuploadfailure") . '<br />';
	}

	$num_failures = count($not_uploaded);
	for ($i = 0; $i < $num_failures; $i++) {
		$error .= "{$not_uploaded[$i]}: {$error_msgs[$i]} <br />";
	}
	register_error($error);

	if (count($uploaded_images) == 0) {
		//upload failed, so forward to previous page
		forward($_SERVER['HTTP_REFERER']);
	} else {
		// some images did upload so we fall through
	}
} else {
	system_message(elgg_echo('tidypics:upl_success'));
}


if (count($uploaded_images) && $img_river_view == "1") {
	add_to_river('river/object/image/create', 'create', $file_for_river->getObjectOwnerGUID(), $file_for_river->getGUID());
}

// update image repo size
create_metadata($album->container_guid, "image_repo_size", $image_repo_size, 'integer', $album->container_guid);

if (count($uploaded_images) > 0) {
	$album->prependImageList($uploaded_images);
}

// plugins can register to be told when a Tidypics album has had images added
trigger_elgg_event('upload', 'tp_album', $album);


//forward to multi-image edit page
forward($CONFIG->wwwroot . 'mod/tidypics/pages/edit_multiple.php?files=' . implode('-', $uploaded_images)); 
