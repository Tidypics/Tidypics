<div class="contentWrapper"> 
<?php

	//the number of files to display
	$number = (int) $vars['entity']->num_display;
	//if no number has been set, default to 6
	if (!$number)
		$number = 6;

	echo '<div class="tidypics_widget_latest">';
	echo tp_get_latest_photos($number, page_owner());
	echo '</div>';

?>
</div>