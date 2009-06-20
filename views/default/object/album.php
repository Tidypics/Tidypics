<?php
	/**
	 * Tidypics Album Gallery View
	 */

	global $CONFIG;
	
	$file = $vars['entity'];
	$file_guid = $file->getGUID();
	$tags = $file->tags;
	$title = $file->title;
	$desc = $file->description;
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = friendly_time($vars['entity']->time_created);
	$mime = $file->mimetype;

	if (get_context() == "search") {

		if (get_input('search_viewtype') == "gallery") {
		
/******************************************************************************
 *
 *  Gallery view of an album object
 * 
 *  This is called when looking at page of albums (index.php).
 *
 *
 *****************************************************************************/

			//get album cover if one was set 
			if ($file->cover)
				$album_cover = '<img src="'.$vars['url'].'mod/tidypics/thumbnail.php?file_guid='.$file->cover.'&size=small" class="tidypics_album_cover"  alt="thumbnail"/>';
			else
				$album_cover = '<img src="'.$vars['url'].'mod/tidypics/graphics/empty_album.png" class="tidypics_album_cover" alt="new album">';

?>
<div class="tidypics_album_gallery_item">
	<a href="<?php echo $file->getURL();?>"><?php echo $title;?></a><br>
	<a href="<?php echo $file->getURL();?>"><?php echo $album_cover;?></a><br>
	<small><a href="<?php echo $vars['url'];?>pg/profile/<?php echo $owner->username;?>"><?php echo $owner->name;?></a> <?php echo $friendlytime;?><br>
<?php
			//get the number of comments
			$numcomments = elgg_count_comments($file);
			if ($numcomments)
				echo "<a href=\"{$file->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a>";
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

			$info = '<p><a href="' .$file->getURL(). '">'.$title.'</a></p>';
			$info .= "<p class=\"owner_timestamp\"><a href=\"{$vars['url']}pg/file/{$owner->username}\">{$owner->name}</a> {$friendlytime}";
			$numcomments = elgg_count_comments($file);
			if ($numcomments)
				$info .= ", <a href=\"{$file->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a>";
			$info .= "</p>";
			
			$icon = "<a href=\"{$file->getURL()}\">" . elgg_view("tidypics/icon", array('album' => true, 'size' => 'small')) . "</a>";
			
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
?>
<div class="contentWrapper">
	<div id="tidypics_breadcrumbs">
		<?php echo elgg_view('tidypics/breadcrumbs', array() ); ?>
	</div>
<?php 
		echo '<div id="tidypics_desc">'.autop($desc).'</div>';
	
		// display the simple image views. Uses: via 'object/image.php'
		$count = get_entities("object","image", $file_guid, '', 999);

		//build array for back | next links 
		$_SESSION['image_sort'] = array();
	
		if(count($count) > 0) {
			foreach($count as $image){
				array_push($_SESSION['image_sort'], $image->guid);
			}
		
			echo list_entities("object","image", $file_guid, 24, false);
		} else {
			echo elgg_echo('image:none');
		}
	
?>
	<div class="clearfloat"></div>
	<div id="tidypics_info">
<?php if (!is_null($tags)) { ?>
			<div class="object_tag_string"><?php echo elgg_view('output/tags',array('value' => $tags));?></div>
<?php } ?>
		<?php echo elgg_echo('album:by');?> <b><a href="<?php echo $vars['url'] ;?>pg/profile/<?php echo $owner->username; ?>"><?php echo $owner->name; ?></a></b>  <?php echo $friendlytime; ?><br>
		<?php echo elgg_echo('image:total');?> <b><?php echo count($count);?></b><br>
	</div>

<?php
		if ($vars['full']) {
			echo elgg_view_comments($file);
		}
	
		echo '</div>';
	} // end of individual album view
?>
