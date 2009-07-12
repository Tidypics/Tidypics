<?php

function tp_gd_watermark($filename) {
}

function tp_imagick_watermark($filename) {
}

function tp_imagick_cmdline_watermark($filename) {
	global $CONFIG;
	
	$watermark_text = get_plugin_setting('watermark_text', 'tidypics');
	if (!$watermark_text)
		return;
	

	$im_path = get_plugin_setting('im_path', 'tidypics');
	if (!$im_path) {
		$im_path = "/usr/bin/";
	}
	
	// make sure end of path is /
	if (substr($im_path, strlen($im_path)-1, 1) != "/") $im_path .= "/";

	
	$owner = get_loggedin_user();

	
	$watermark_text = str_replace("%username%", $owner->username, $watermark_text);
	$watermark_text = str_replace("%sitename%", $CONFIG->sitename, $watermark_text);

	$ext = ".png";
	
	$watermark_filename = strtolower($watermark_text);
	$watermark_filename = preg_replace("/[^\w-]+/", "-", $watermark_filename);
	$watermark_filename = trim($watermark_filename, '-');
	
	$user_stamp_base = tp_get_img_dir();
	$user_stamp_base .= strtolower($owner->username . "_" . $watermark_filename . "_stamp");
	
	if ( !file_exists( $user_stamp_base . $ext )) { //create the watermark if it doesn't exist
		$commands = array();
		$commands[] = $im_path . 'convert -size 300x50 xc:grey30 -pointsize 20 -gravity center -draw "fill grey70  text 0,0  \''. $watermark_text . '\'" "'. $user_stamp_base . '_fgnd' . $ext . '"';
		$commands[] = $im_path . 'convert -size 300x50 xc:black -pointsize 20 -gravity center -draw "fill white  text  1,1  \''. $watermark_text . '\' text  0,0  \''. $watermark_text . '\' fill black  text -1,-1 \''. $watermark_text . '\'" +matte ' . $user_stamp_base . '_mask' . $ext;
		$commands[] = $im_path . 'composite -compose CopyOpacity  "' . $user_stamp_base . "_mask" . $ext . '" "' . $user_stamp_base . '_fgnd' . $ext . '" "' . $user_stamp_base . $ext . '"';
		$commands[] = $im_path . 'mogrify -trim +repage "' . $user_stamp_base . $ext . '"';
		$commands[] = 'rm "' . $user_stamp_base . '_mask' . $ext . '"';
		$commands[] = 'rm "' . $user_stamp_base . '_fgnd' . $ext . '"';
		
		foreach( $commands as $command ) {
			exec( $command );
		}
	}
	
	//apply the watermark
	$commands = array();
	$commands[] = $im_path . 'composite -gravity south -geometry +0+10 "' . $user_stamp_base . $ext . '" "' . $filename . '" "' . $filename . '_watermarked"';
	$commands[] = "mv \"$filename" . "_watermarked\" \"$filename\"";
	foreach( $commands as $command ) {
		exec( $command );
	}
}
?>