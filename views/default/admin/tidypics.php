<?php

	global $CONFIG;
	
	
	echo '<div class="contentWrapper">';
	
	echo elgg_view('output/longtext', array('value' => elgg_echo("tidypics:admin:instructions")));
	
	echo elgg_view("tidypics/forms/admin");
		
	echo "</div>";
?>