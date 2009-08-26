<?php

	global $CONFIG;
	
	$tab = $vars['tab'];
	
	$settingsselect = ''; 
	$statsselect = '';
	$imagelibselect = '';
	switch($tab) {
		case 'settings':
			$settingsselect = 'class="selected"';
			break;
		case 'stats':
			$statsselect = 'class="selected"';
			break;
		case 'imagelib':
			$imagelibselect = 'class="selected"';
			break;
	}
	
?>
<div class="contentWrapper">
	<div id="elgg_horizontal_tabbed_nav">
		<ul>
			<li <?php echo $settingsselect; ?>><a href="<?php echo $CONFIG->wwwroot . 'mod/tidypics/pages/admin.php?tab=settings'; ?>"><?php echo elgg_echo('tidypics:settings'); ?></a></li>
			<li <?php echo $statsselect; ?>><a href="<?php echo $CONFIG->wwwroot . 'mod/tidypics/pages/admin.php?tab=stats'; ?>"><?php echo elgg_echo('tidypics:stats'); ?></a></li>
			<li <?php echo $imagelibselect; ?>><a href="<?php echo $CONFIG->wwwroot . 'mod/tidypics/pages/admin.php?tab=imagelib'; ?>"><?php echo elgg_echo('tidypics:settings:image_lib'); ?></a></li>
		</ul>
	</div>
<?php
	switch($tab) {
		case 'settings':
			echo elgg_view("tidypics/admin/settings");
			break;
		case 'stats':
			echo elgg_view("tidypics/admin/stats");
			break;
		case 'imagelib':
			echo elgg_view("tidypics/admin/imagelib");
			break;
	}
?>
</div>
