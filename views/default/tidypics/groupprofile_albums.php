<?php

if ($vars['entity']->photos_enable != 'no') {
	echo '<div id="group_albums_widget">';
	echo '<h2>' . elgg_echo('album:group') . '</h2>';
	echo elgg_view('tidypics/albums', array('num_albums' => 5));
	echo '</div>';
}
?>