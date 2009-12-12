<?php

	$guid = $vars['guid'];
	
	$exif = tp_exif_formatted($guid);
	if ($exif) {
		echo '<div id="tidypics_exif">';
		foreach ($exif as $name => $value) {
			echo $name . ': ' . $value . '<br />';
		}
		echo '</div>';
	}
	
?>