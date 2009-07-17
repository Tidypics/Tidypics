<?php

function tp_process_watermark_text($text, $owner) {
	global $CONFIG;

	$text = str_replace("%username%", $owner->username, $text);
	$text = str_replace("%sitename%", $CONFIG->sitename, $text);
	
	return $text;
}

function tp_get_watermark_filename($text, $owner) {
	global $CONFIG;

	$base = strtolower($text);
	$base = preg_replace("/[^\w-]+/", "-", $base);
	$base = trim($base, '-');
	
	$filename = tp_get_img_dir();
	$filename .= strtolower($owner->username . "_" . $base . "_stamp");
	
	return $filename;
}

function tp_gd_watermark($image) {
	$watermark_text = get_plugin_setting('watermark_text', 'tidypics');
	if (!$watermark_text)
		return;
	
	
	$owner = get_loggedin_user();

	$watermark_text = tp_process_watermark_text($watermark_text, $owner);
	
	
	
	$font = 5;
	$line_width = strlen($watermark_text) * imagefontwidth($font);
	$line_height = imagefontheight($font);
	
	$image_width = 600;
	$image_height = 450;
	
	// matching -gravity south -geometry +0+10
	$top = $image_height - $line_height - 10;
	$left = round(($image_width - $line_width) / 2);
	
	$textcolor = imagecolorallocate($image, 0, 0, 255);
	imagestring($image, $font, $left, $top, $watermark_text, $textcolor);
}

function tp_imagick_watermark($filename) {
	$watermark_text = get_plugin_setting('watermark_text', 'tidypics');
	if (!$watermark_text)
		return;
	

	
	$owner = get_loggedin_user();

	$watermark_text = tp_process_watermark_text($watermark_text, $owner);
	
	$ext = ".png";
	
	$user_stamp_base = tp_get_watermark_filename($watermark_text, $owner);
	
	
	if ( !file_exists( $user_stamp_base . $ext )) { //create the watermark if it doesn't exist
/*
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
*/
	}

	try {
		$img = new Imagick($filename);
	} catch (ImagickException $e) {
		return false;
	}
	
	try {
		$mask = new Imagick($user_stamp_base . $ext);
	} catch (ImagickException $e) {
		return false;
	}
	
	$image_width = $img->getImageWidth();
	$image_height = $img->getImageHeight();
	$mask_width = $mask->getImageWidth();
	$mask_height = $mask->getImageHeight();
	
	// matching -gravity south -geometry +0+10
	$top = $image_height - $mask_height - 10;
	$left = round(($image_width - $mask_width) / 2);
	
	$img->compositeImage($mask, Imagick::COMPOSITE_DEFAULT, $left, $top);
	
	$mask->destroy();
	
	if ($img->writeImage($filename) != true) {
		$img->destroy();
		return false;
	}
	
	$img->destroy();
	
	return true;
}

function tp_imagick_cmdline_watermark($filename) {
	
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

	$watermark_text = tp_process_watermark_text($watermark_text, $owner);
	
	$ext = ".png";
	
	$user_stamp_base = tp_get_watermark_filename($watermark_text, $owner);
	
	
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