<?php

	echo elgg_view('output/longtext', array('value' => elgg_echo("tidypics:admin:instructions")));
	
	global $CONFIG;  
	$system_url = $CONFIG->wwwroot . 'mod/tidypics/system.php';
	$upgrade_url = $CONFIG->wwwroot . 'mod/tidypics/upgrade.php';
	
	$upgrade = false;
	if (!get_subtype_class('object', 'image') || !get_subtype_class('object', 'album'))
		$upgrade = true;
?>
<p>
<?php
	if ($upgrade) {
?>
<a href="<?php echo $upgrade_url; ?>">Upgrade</a><br />
<?php
	}
?>
<a href="<?php echo $system_url; ?>">Run Server Analysis</a>
</p>
<?php
	echo elgg_view("tidypics/forms/admin");
?>