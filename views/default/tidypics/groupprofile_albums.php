<?php

/***********************************************
 *
 *  This is used on the group profile page
 *
 ***********************************************/

if ($vars['entity']->photos_enable != 'no') {
	echo '<div id="tidypics_group_profile">';
	echo '<h2>' . elgg_echo('album:group') . '</h2>';
	echo elgg_view('tidypics/albums', array('num_albums' => 5));
	echo '</div>';
}
?>