<div class="contentWrapper"> 
<?php

	//the number of files to display
	$number = (int) $vars['entity']->num_display;
	//if no number has been set, default to 5
	if (!$number)
		$number = 5;

	echo elgg_view('tidypics/albums', array('num_albums' => $number));

?>
</div>