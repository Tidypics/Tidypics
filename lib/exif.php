<?php
include_once dirname(__FILE__) . "/tidypics.php";

function td_get_exif(Elggfile $file) {
	$my_file = str_replace("image", "", tp_get_img_dir()) . $file->getFilename();
	$exif = exif_read_data($my_file);
	create_metadata($file->getGUID(), "tp_exif", serialize($exif), "string", $file->getObjectOwnerGUID(), 2);
}

function tp_exif_formatted($file_guid) {
	$metadata_exif = get_metadata_byname($file_guid, "tp_exif");
	if($metadata_exif) {
		$exif = unserialize($metadata_exif["value"]);
		
		//got the code snippet below from http://www.zenphoto.org/support/topic.php?id=17
		//convert the raw values to understandible values
		$Fnumber = explode("/", $exif['FNumber']);
		$Fnumber = $Fnumber[0] / $Fnumber[1];
		$Focal = explode("/", $exif['FocalLength']);
		$Focal = $Focal[0] / $Focal[1];
		
		//prepare the text for return
		$exif_text = "Model: ".$exif['Model']."<br>";
		$exif_text .= "Shutter: ".$exif['ExposureTime']."<br>";
		$exif_text .= "Aperture: f/".$Fnumber."<br>";
		$exif_text .= "ISO Speed: ".$exif['ISOSpeedRatings']."<br>";
		$exif_text .= "Focal Length: ".round($Focal)."mm<br>";
		$exif_text .= "Captured: ". $exif['DateTime'];
	
		return "<tr><td>$exif_text</td></tr>";
	} else {
		return false;
	}
}
?>