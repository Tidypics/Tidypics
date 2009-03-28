<div class="contentWrapper"> 
<?php
	//the number of files to display
	$number = (int) $vars['entity']->num_display;
	//if no number has been set, default to 5
	if (!$number)
		$number = 5;
	
	$owner = page_owner_entity();	
	$owner_albums = get_entities("object", "album", page_owner(), "", $number, 0, false);

	if ($owner_albums) {
		echo '<div id="tidypics_album_widget_container">';
 
		foreach($owner_albums as $album){
	
			//get album cover if one was set 
			if($album->cover)
				$album_cover = '<img src="'.$vars['url'].'mod/tidypics/thumbnail.php?file_guid='.$album->cover.'&size=small" border="0" class="tidypics_album_cover"  alt="' . $album->title . '"/>';
			else
				$album_cover = '<img src="'.$vars['url'].'mod/tidypics/graphics/img_error.jpg" border="0" class="tidypics_album_cover" alt="' . $album->title . '">';
			?>
			<div class="tidypics_album_widget_single_item">			
				<div class="tidypics_album_widget_title"><a href="<?php echo $album->getURL();?>"><?php echo $album->title;?></a></div>
				<div class="tidypics_album_widget_timestamp"> <?php echo elgg_echo("album:created:on") . ' '. friendly_time($album->time_created);?></div>
				<?php
				//get the number of comments
				$numcomments = elgg_count_comments($album);
				if ($numcomments)
					echo "<a href=\"{$album->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a><br>";
				?>
				<a href="<?php echo $album->getURL();?>"><?php echo $album_cover;?></a>
			</div>
		<?php
		}
        	      	
        //get a link to the users album
        $users_album_url = $vars['url'] . "pg/photos/owned/" . $owner->username;
        echo "<a href=\"{$users_album_url}\">" . elgg_echo('album:more') . "</a>";
		echo "</div>";
        		
	} else {
		
		echo '<p class="pages_add_title">' . elgg_echo("album:none") . '</p>';

		if (get_loggedin_userid() == page_owner()) {
            echo '<p class="pages_add"><a class="pages add" href='.$CONFIG->url .'pg/photos/new/'.$owner->username.'>'.elgg_echo("album:create").'</a></p>';
        }
		
	}
?>
</div>