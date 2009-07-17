<?php

	$img_type = get_subtype_id('object', 'image');
	$query = "SELECT count(guid) as total from {$CONFIG->dbprefix}entities where subtype={$img_type}";
	$total = get_data_row($query);
	$num_images = $total->total;
	
	$img_type = get_subtype_id('object', 'album');
	$query = "SELECT count(guid) as total from {$CONFIG->dbprefix}entities where subtype={$img_type}";
	$total = get_data_row($query);
	$num_albums = $total->total;

	echo  $num_images . " Photos in " . $num_albums . " Albums";
?>