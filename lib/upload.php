<?php
/**
 * Helper library for working with uploads
 */

function tp_upload_check_format($mime) {
	$accepted_formats = array(
		'image/jpeg',
		'image/png',
		'image/gif',
		'image/pjpeg',
		'image/x-png',
	);

	if (!in_array($mime, $accepted_formats)) {
		return false;
	}
	return true;
}

function tp_upload_memory_check($image_lib, $num_pixels) {
	if ($image_lib !== 'GD') {
		return true;
	}

	$mem_avail = ini_get('memory_limit');
	$mem_avail = rtrim($mem_avail, 'M');
	$mem_avail = $mem_avail * 1024 * 1024;
	$mem_used = memory_get_usage();
	$mem_required = ceil(5.35 * $num_pixels);

	$mem_avail = $mem_avail - $mem_used - 2097152; // 2 MB buffer
	if ($mem_required > $mem_avail) {
		return false;
	}

	return true;
}