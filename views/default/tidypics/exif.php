<?php

	$guid = $vars['guid'];
	
	$exif = tp_exif_formatted($guid);
	if($exif) echo $exif;
	
?>