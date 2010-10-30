<?php
/**
 * Elgg single upload action for flash/ajax uploaders
 *
 */

include_once dirname(dirname(__FILE__)) . "/lib/upload.php";

$album_guid = (int) get_input('album_guid');
$file_var_name = get_input('file_var_name', 'Image');

$album = get_entity($album_guid);
if (!$album) {
	exit;
}

// probably POST limit exceeded
if (empty($_FILES)) {
	echo 'Image was too large';
	exit;
}

$image_lib = get_plugin_setting('image_lib', 'tidypics');
if (!$image_lib) {
	$image_lib = "GD";
}

$temp_file = $_FILES['Image']['tmp_name'];
$name = $_FILES['Image']['name'];
$file_size = $_FILES['Image']['size'];

$mime = tp_upload_get_mimetype($name);
if ($mime == 'unknown') {
	echo 'Not an image';
	exit;
}

$image = new TidypicsImage();
$image->container_guid = $album_guid;
$image->setMimeType($mime);
$image->simpletype = "image";
$image->access_id = $album->access_id;
$image->title = substr($name, 0, strrpos($name, '.'));
$image->batch = get_input('batch');
$result = $image->save();

$image->setOriginalFilename($name);
$image->saveImageFile($temp_file, $file_size);

$image->extractExifData();
$image->saveThumbnails($image_lib);

$album->prependImageList(array($image->guid));


if (get_plugin_setting('img_river_view', 'tidypics') === "all") {
	add_to_river('river/object/image/create', 'create', $image->owner_guid, $image->guid);
}

echo "success";
exit;