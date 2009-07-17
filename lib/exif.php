<?php

function td_get_exif($file) {
	
	// catch for those who don't have exif module loaded
	if (!is_callable('exif_read_data'))
		return;
		
	$mime = $file->mimetype;
	if ($mime != 'image/jpeg' && $mime != 'image/pjpeg')
		return;

	$filename = $file->getFilenameOnFilestore();
	$exif = exif_read_data($filename);
	create_metadata($file->getGUID(), "tp_exif", serialize($exif), "text", $file->getObjectOwnerGUID(), ACCESS_PUBLIC);
}

function tp_exif_formatted($file_guid) {

	$metadata_exif = get_metadata_byname($file_guid, "tp_exif");
	if (!$metadata_exif) { //try to load it from the file if its not in the database
		$file = new ElggFile($file_guid);
		td_get_exif($file);
		unset($file);
		$metadata_exif = get_metadata_byname($file_guid, "tp_exif");
	}
	
	if (!$metadata_exif) {
		return false;
	}

	$exif = unserialize($metadata_exif["value"]);
	
	$model = $exif['Model'];
	if(!$model) $model = "N/A";
	$exif_data['Model'] = $model;

	$exposure = $exif['ExposureTime'];
	if (!$exposure) $exposure = "N/A";
	$exif_data['Shutter'] = $exposure;

	//got the code snippet below from http://www.zenphoto.org/support/topic.php?id=17
	//convert the raw values to understandible values
	$Fnumber = explode("/", $exif['FNumber']);
	if ($Fnumber[1] != 0)
		$Fnumber = $Fnumber[0] / $Fnumber[1];
	else
		$Fnumber = 0;
	if (!$Fnumber) {
		$Fnumber = "N/A";
	} else {
		$Fnumber = "f/$Fnumber";
	}
	$exif_data['Aperture'] = $Fnumber;

	$iso = $exif['ISOSpeedRatings'];
	if (!$iso) $iso = "N/A";
	$exif_data['ISO Speed'] = $iso;

	$Focal = explode("/", $exif['FocalLength']);
	if ($Focal[1] != 0)
		$Focal = $Focal[0] / $Focal[1];
	else
		$Focal = 0;
	if (!$Focal || round($Focal) == "0") $Focal = 0;
	if (round($Focal) == 0) {
		$Focal = "N/A";
	} else {
		$Focal = round($Focal) . "mm";
	}
	$exif_data['Focal Length'] = $Focal;

	$captured = $exif['DateTime'];
	if (!$captured) $captured = "N/A";
	$exif_data['Captured'] = $captured;

	return $exif_data;
}
?>