<?php

	$guid = $vars['guid'];
	
	$exif = tp_exif_formatted($guid);
	if ($exif) {
		echo '<div id="tidypics_breadcrumbs">';
		echo $exif;
		echo '</div>';
	}
	
?>