<?php

	global $CONFIG;
	
	$tab = $vars['tab'];
	
	$settingsselect = ''; 
	$statsselect = '';
	$imagelibselect = '';
	$thumbnailselect = '';
	$helpselect = '';
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
		case 'thumbnail':
			$thumbnailselect = 'class="selected"';
			break;
		case 'help':
			$helpselect = 'class="selected"';
			break;
	}
	
?>
<div class="contentWrapper">
	<div id="elgg_horizontal_tabbed_nav">
		<ul>
			<li <?php echo $settingsselect; ?>><a href="<?php echo $CONFIG->wwwroot . 'mod/tidypics/pages/admin.php?tab=settings'; ?>"><?php echo elgg_echo('tidypics:settings'); ?></a></li>
			<li <?php echo $statsselect; ?>><a href="<?php echo $CONFIG->wwwroot . 'mod/tidypics/pages/admin.php?tab=stats'; ?>"><?php echo elgg_echo('tidypics:stats'); ?></a></li>
			<li <?php echo $imagelibselect; ?>><a href="<?php echo $CONFIG->wwwroot . 'mod/tidypics/pages/admin.php?tab=imagelib'; ?>"><?php echo elgg_echo('tidypics:settings:image_lib'); ?></a></li>
			<li <?php echo $thumbnailselect; ?>><a href="<?php echo $CONFIG->wwwroot . 'mod/tidypics/pages/admin.php?tab=thumbnail'; ?>"><?php echo elgg_echo('tidypics:settings:thumbnail'); ?></a></li>
			<li <?php echo $helpselect; ?>><a href="<?php echo $CONFIG->wwwroot . 'mod/tidypics/pages/admin.php?tab=help'; ?>"><?php echo elgg_echo('tidypics:settings:help'); ?></a></li>
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
		case 'thumbnail':
			echo elgg_view("tidypics/admin/thumbnails");
			break;
		case 'help':
			echo elgg_view("tidypics/admin/help");
			break;
	}
?>
</div>
