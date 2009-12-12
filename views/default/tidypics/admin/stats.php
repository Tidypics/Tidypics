<?php

	$img_type = get_subtype_id('object', 'image');
	$query = "SELECT count(guid) as total from {$CONFIG->dbprefix}entities where subtype={$img_type}";
	$total = get_data_row($query);
	$num_images = $total->total;
	
	$img_type = get_subtype_id('object', 'album');
	$query = "SELECT count(guid) as total from {$CONFIG->dbprefix}entities where subtype={$img_type}";
	$total = get_data_row($query);
	$num_albums = $total->total;

	$num_comments_photos = count_annotations(0, 'object', 'image', 'generic_comment');
	$num_comments_albums = count_annotations(0, 'object', 'album', 'generic_comment');
	
	$num_views = count_annotations(0, 'object', 'image', 'tp_view');
	
	if (get_plugin_setting('tagging', 'tidypics') != "disabled")
		$num_tags = count_annotations(0, 'object', 'image', 'phototag');
?>
<p>
<br />
Photos: <?php echo $num_images; ?><br />
Albums: <?php echo $num_albums; ?><br />
Comments on photos: <?php echo $num_comments_photos; ?><br />
Comments on albums: <?php echo $num_comments_albums; ?><br />
Total views: <?php echo $num_views; ?><br />
<?php 
	if ($num_tags) {
?>
Photo tags: <?php echo $num_tags; ?><br />
<?php
	}
?>
</p>