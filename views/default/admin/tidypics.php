<?php

	global $CONFIG;
	
	
	echo '<div class="contentWrapper">';
	
	echo elgg_view('output/longtext', array('value' => elgg_echo("tidypics:admin:instructions")));
	
	global $CONFIG;  
	$system_url = $CONFIG->wwwroot . 'mod/tidypics/system.php';
?>
<p>
<a href="<?php echo $system_url; ?>">Run Server Analysis</a>
</p>
<?php
	echo elgg_view("tidypics/forms/admin");
		
	echo "</div>";
?>