<?php

if ($vars['entity']->photos_enable != 'no') {

	//the number of files to display
	$number = (int) $vars['entity']->num_display;
	//if no number has been set, default to 5
	if (!$number)
		$number = 5;
	
	$owner = page_owner_entity();	
	$owner_albums = get_entities("object", "album", page_owner(), "", $number, 0, false);

	echo '<div id="group_albums_widget">';
	echo '<h2>' . elgg_echo('albums') . '</h2>';
			
	if ($owner_albums) {        	 
  echo '<div id="tidypics_album_widget_container">';
		foreach($owner_albums as $album){
	
			//get album cover if one was set 
			if($album->cover)
				$album_cover = '<img src="'.$vars['url'].'/mod/tidypics/thumbnail.php?file_guid='.$album->cover.'&size=small" border="0" class="tidypics_album_cover"  alt="album cover"/>';
			else
				$album_cover = '<img src="'.$vars['url'].'/mod/tidypics/graphics/img_error.jpg" class="tidypics_album_cover" alt="new album">';

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
		} //end of loop
        	      	
        //get a link to the group's album, or world if unavailable
        if (is_null($owner->username) || empty($owner->username)) {
					echo '<a href="' . $vars['url'] . 'pg/photos/world">' . elgg_echo('album:all') . '</a>';
				} else {
					echo '<a href="' . $vars['url'] . 'pg/photos/owned/' . $owner->username . '">' . elgg_echo('album:more') . '</a>';
				}

				//close album_widget_container div
				echo "</div>";
	} else {
		
		//echo '<div id="no_album_found">';
		//echo '<p class="pages_add_title">'.elgg_echo("album:none").'</p>';
    if ($owner && ($owner->canWriteToContainer($_SESSION['user']))){
      //echo '<a class="add_topic_button" href='.$CONFIG->url .'pg/photos/new/'.$owner->username.'>'.elgg_echo("album:add").'</a>';
			//echo '</div>';
    }
		
	}
	//close group_albums_widget div
	echo "</div>";
}
?>