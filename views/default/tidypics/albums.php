<?php

	//the number of albums to display
	$number = (int)$vars['num_albums'];
	if (!$number)
		$number = 5;

	$owner = page_owner_entity();
	$owner_albums = get_entities("object", "album", page_owner(), "", $number, 0, false);

	if ($owner_albums) { 
		echo '<div id="tidypics_album_widget_container">';
		foreach($owner_albums as $album) {

			if($album->cover)
				$album_cover = '<img src="'.$vars['url'].'mod/tidypics/thumbnail.php?file_guid='.$album->cover.'&size=small" border="0" class="tidypics_album_cover"  alt="' . $album->title . '"/>';
			else
				$album_cover = '<img src="'.$vars['url'].'mod/tidypics/graphics/img_error.jpg" border="0" class="tidypics_album_cover" alt="' . $album->title . '">';
?>
		<div class="tidypics_album_widget_single_item">
			<div class="tidypics_album_widget_title"><a href="<?php echo $album->getURL();?>"><?php echo $album->title;?></a></div>
			<div class="tidypics_album_widget_timestamp"> <?php echo elgg_echo("album:created:on") . ' ' . friendly_time($album->time_created);?></div>
<?php
			//get the number of comments
			$numcomments = elgg_count_comments($album);
			if ($numcomments)
				echo "<a href=\"{$album->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a><br>";
?>
			<a href="<?php echo $album->getURL();?>"><?php echo $album_cover;?></a>
		</div>
<?php
		} //end of foreach loop

		// bottom link to all group/user albums
		if (is_null($owner->username) || empty($owner->username)) {
			echo '<a href="' . $vars['url'] . 'pg/photos/world">' . elgg_echo('album:all') . '</a>';
		} else {
			echo '<a href="' . $vars['url'] . 'pg/photos/owned/' . $owner->username . '">' . elgg_echo('album:more') . '</a>';
		}

		//close album_widget_container div
		echo "</div>";

	}
?>