<?php
	/**
	 * Tidypics Album Gallery View
	 */

	global $CONFIG;
	
	$album = $vars['entity'];
	$album_guid = $album->getGUID();
	$owner = $album->getOwnerEntity();
	$tags = $album->tags;
	$title = $album->title;
	$desc = $album->description;
	$friendlytime = friendly_time($album->time_created);
	$mime = $album->mimetype;

	if (get_context() == "search") {

		if (get_input('search_viewtype') == "gallery") {

/******************************************************************************
 *
 *  Gallery view of an album object
 * 
 *  This is called when looking at page of albums
 *
 *
 *****************************************************************************/

			//get album cover if one was set 
			if ($album->cover)
				$album_cover = '<img src="' . $vars['url'] . 'pg/photos/thumbnail/' . $album->cover . '/small/" class="tidypics_album_cover" alt="' . $title . '"/>';
			else
				$album_cover = '<img src="' . $vars['url'] . 'mod/tidypics/graphics/empty_album.png" class="tidypics_album_cover" alt="new album">';

?>
<div class="tidypics_album_gallery_item">
	<div class="tidypics_gallery_title">
		<a href="<?php echo $album->getURL();?>"><?php echo $title;?></a>
	</div>
	<a href="<?php echo $album->getURL();?>"><?php echo $album_cover;?></a><br>
	<small><a href="<?php echo $vars['url'];?>pg/profile/<?php echo $owner->username;?>"><?php echo $owner->name;?></a> <?php echo $friendlytime;?><br>
<?php
			//get the number of comments
			$numcomments = elgg_count_comments($album);
			if ($numcomments)
				echo "<a href=\"{$album->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a>";
?>
	</small>
</div>
<?php
		} else {
/******************************************************************************
 *
 *  List view of an album object
 * 
 *  This is called when an album object is returned in a search.
 *
 *
 *****************************************************************************/

			$info = '<p><a href="' . $album->getURL() . '">' . $title . '</a></p>';
			$info .= "<p class=\"owner_timestamp\"><a href=\"{$vars['url']}pg/profile/{$owner->username}\">{$owner->name}</a> {$friendlytime}";
			$numcomments = elgg_count_comments($album);
			if ($numcomments)
				$info .= ", <a href=\"{$album->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a>";
			$info .= "</p>";
			
			//get album cover if one was set 
			if ($album->cover)
				$icon = "<a href=\"{$album->getURL()}\">" . '<img src="' . $vars['url'] . 'mod/tidypics/thumbnail.php?file_guid=' . $album->cover . '&size=thumb" alt="thumbnail" /></a>';
			else
				$icon = "<a href=\"{$album->getURL()}\">" . '<img src="' . $vars['url'] . 'mod/tidypics/graphics/image_error_thumb.png" alt="new album"></a>';
			
			echo elgg_view_listing($icon, $info);
		}
	} else {

/******************************************************************************
 *
 *  Individual view of an album object
 * 
 *  This is called when getting a listing of the photos in an album
 *
 *
 *****************************************************************************/

		$page = get_input("page");
		list($album_placeholder, $album_id, $album_title) = split("/", $page);
		
		$photo_ratings = get_plugin_setting('photo_ratings', 'tidypics');
		if ($photo_ratings == "enabled")
			add_submenu_item(	elgg_echo("tidypics:highestrated"),
								$CONFIG->wwwroot . "pg/photos/highestrated/group:" . $album_id,
								'photos');
								
		echo elgg_view_title($title);
?>
<div class="contentWrapper">
	<div id="tidypics_breadcrumbs">
		<?php echo elgg_view('tidypics/breadcrumbs', array() ); ?>
	</div>
<?php 
		echo '<div id="tidypics_desc">' . autop($desc) . '</div>';
		
		$images = get_entities("object", "image", $album_guid, '', 999);
		
		//build array for back | next links 
		$_SESSION['image_sort'] = array();
		
		if (is_array($images)) {
			foreach ($images as $image) {
				array_push($_SESSION['image_sort'], $image->guid);
			}
			
			// display the simple image views. Uses 'object/image' view
			echo list_entities("object", "image", $album_guid, 24, false);
			
			$num_images = count($images);
		} else {
			echo '<div class="tidypics_info">' . elgg_echo('image:none') . '</div>';
			$num_images = 0;
		}
	
?>
	<div class="clearfloat"></div>
	<div class="tidypics_info">
<?php 

	if (!is_null($tags)) { 
?>
		<div class="object_tag_string"><?php echo elgg_view('output/tags',array('value' => $tags));?></div>
<?php 
	} 
?>
		<?php echo elgg_echo('album:by');?> <b><a href="<?php echo $vars['url'] ;?>pg/profile/<?php echo $owner->username; ?>"><?php echo $owner->name; ?></a></b>  <?php echo $friendlytime; ?><br>
		<?php echo elgg_echo('image:total');?> <b><?php echo $num_images; ?></b><br>
	</div>

<?php
		if ($vars['full']) {
			echo elgg_view_comments($album);
		}
	
		echo '</div>';
	} // end of individual album view
?>
