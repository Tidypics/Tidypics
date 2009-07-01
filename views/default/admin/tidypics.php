<?php

	global $CONFIG;
	
	$tab = $vars['tab'];
	
	$settingsselect = ''; 
	$statsselect = '';
	switch($tab) {
		case 'settings':
			$settingsselect = 'class="selected"';
			break;
		case 'stats':
			$statsselect = 'class="selected"';
			break;
	}
	
?>
<div class="contentWrapper">
	<div id="elgg_horizontal_tabbed_nav">
		<ul>
			<li <?php echo $settingsselect; ?>><a href="<?php echo $CONFIG->wwwroot . 'mod/tidypics/admin.php?tab=settings'; ?>"><?php echo elgg_echo('tidypics:settings'); ?></a></li>
			<li <?php echo $statsselect; ?>><a href="<?php echo $CONFIG->wwwroot . 'mod/tidypics/admin.php?tab=stats'; ?>"><?php echo elgg_echo('tidypics:stats'); ?></a></li>
		</ul>
	</div>
<?php
	switch($tab) {
		case 'settings':
			echo elgg_view("tidypics/settings");
			break;
		case 'stats':
			echo elgg_view("tidypics/stats");
			break;
	}
?>
</div>
