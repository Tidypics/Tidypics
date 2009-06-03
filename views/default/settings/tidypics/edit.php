<?
	global $CONFIG;  
	$system_url = $CONFIG->wwwroot . 'mod/tidypics/system.php';
	$settings_url = $CONFIG->wwwroot . 'mod/tidypics/admin.php';
?>

<p>
<a href="<?php echo $system_url; ?>">Run Server Analysis</a>
</p>
<p>
<a href="<?php echo $settings_url; ?>">Change Tidypics Settings</a>
</p>