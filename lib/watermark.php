<?php

function tp_watermark($thumbs) {
	global $CONFIG;
	
	$user = get_user_entity_as_row($album->owner_guid);
	$username = $user->username;

	$im_path = get_plugin_setting('convert_command', 'tidypics');
	if(!$im_path) {
		$im_path = "/usr/bin/";
	}
	if(substr($im_path, strlen($im_path)-1, 1) != "/") $im_path .= "/";
	
	$viewer = get_loggedin_user();
	$watermark_text = get_plugin_setting('watermark_text', 'tidypics');
	$watermark_text = str_replace("%username%", $viewer->username, $watermark_text);
	$watermark_text = str_replace("%sitename%", $CONFIG->sitename, $watermark_text);

	if( $watermark_text ) { //get this value from the plugin settings
		if( $thumbs["thumblarge"] ) {
			$ext = ".png";
			
			$watermark_filename = strtolower($watermark_text);
			$watermark_filename = preg_replace("/[^\w-]+/", "-", $watermark_filename);
			$watermark_filename = trim($watermark_filename, '-');
			
			$user_stamp_base = strtolower(dirname(__FILE__) . "/" . $viewer->name . "_" . $watermark_filename . "_stamp");
			$user_stamp_base = preg_replace("/[^\w-]+/", "-", $user_stamp_base);
			$user_stamp_base = trim($user_stamp_base, '-');
			
			if( !file_exists( $user_stamp_base . $ext )) { //create the watermark if it doesn't exist
				$commands = array();
				$commands[] = $im_path . 'convert -size 300x50 xc:grey30 -pointsize 20 -gravity center -draw "fill grey70  text 0,0  \''. $watermark_text . '\'" "'. $user_stamp_base . '_fgnd' . $ext . '"';
				$commands[] = $im_path . 'convert -size 300x50 xc:black -pointsize 20 -gravity center -draw "fill white  text  1,1  \''. $watermark_text . '\' text  0,0  \''. $watermark_text . '\' fill black  text -1,-1 \''. $watermark_text . '\'" +matte ' . $user_stamp_base . '_mask' . $ext;
				$commands[] = $im_path . 'composite -compose CopyOpacity  "' . $user_stamp_base . "_mask" . $ext . '" "' . $user_stamp_base . '_fgnd' . $ext . '" "' . $user_stamp_base . $ext . '"';
				$commands[] = $im_path . 'mogrify -trim +repage "' . $user_stamp_base . $ext . '"';
				$commands[] = 'rm "' . $user_stamp_base . '_mask' . $ext . '"';
				$commands[] = 'rm "' . $user_stamp_fgnd . '_mask' . $ext . '"';
				
				foreach( $commands as $command ) {
					exec( $command );
				}
			}
			//apply the watermark
			$commands = array();
			$commands[] = $im_path . 'composite -gravity south -geometry +0+10 "' . $user_stamp_base . $ext . '" "' . $thumbs["thumblarge"] . '" "' . $thumbs["thumblarge"] . '_watermarked"';
			$commands[] = "mv \"$thumbs[thumblarge]" . "_watermarked\" \"$thumbs[thumblarge]\"";
			foreach( $commands as $command ) {
				exec( $command );
			}
		}
	}
}
?>