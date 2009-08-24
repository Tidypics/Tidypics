<?php
	/**
	 *
	 * Tidypics image object views
	 */

	global $CONFIG;
	include_once dirname(dirname(dirname(dirname(__FILE__)))) . "/lib/exif.php";

	$file = $vars['entity'];
	$file_guid = $file->getGUID();
	$tags = $file->tags;
	$title = $file->title;
	$desc = $file->description;
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = friendly_time($vars['entity']->time_created);

	$mime = $file->mimetype;


/////////////////////////////////////////////////////
// get photo tags from database
	$photo_tags_json = "\"\"";
	
	$tag_info = $file->getPhotoTags();
	if ($tag_info) {
		$photo_tags = $tag_info['raw'];
		$photo_tags_json = $tag_info['json'];
		$photo_tag_links = $tag_info['links'];
	}

/********************************************************************
 *
 * search view of an image
 *
 ********************************************************************/
	if (get_context() == "search") { 

		if (get_input('search_viewtype') == "gallery") {
			?>
			<div class="tidypics_album_images">
				<a href="<?php echo $file->getURL();?>"><img src="<?php echo $vars['url'];?>mod/tidypics/thumbnail.php?file_guid=<?php echo $file_guid;?>&size=small" alt="thumbnail"/></a>
			</div>
			<?php
		}
		else{
			//image list-entity view
			$info = '<p><a href="' .$file->getURL(). '">'.$title.'</a></p>';
			$info .= "<p class=\"owner_timestamp\"><a href=\"{$vars['url']}pg/photos/owned/{$owner->username}\">{$owner->name}</a> {$friendlytime}";
			$numcomments = elgg_count_comments($file);
			if ($numcomments)
				$info .= ", <a href=\"{$file->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a>";
			$info .= "</p>";
			$icon = "<a href=\"{$file->getURL()}\">" . '<img src="' . $vars['url'] . 'mod/tidypics/thumbnail.php?file_guid=' . $file_guid . '&size=thumb" alt="' . $title . '" /></a>';

			echo elgg_view_listing($icon, $info);
		}
/***************************************************************
 *
 * front page view 
 *
 ****************************************************************/
	} else if (get_context() == "front") {
?>
		<a href="<?php echo $file->getURL();?>"><img src="<?php echo $vars['url'];?>mod/tidypics/thumbnail.php?file_guid=<?php echo $file_guid;?>&amp;size=thumb" class="tidypics_album_cover" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" /></a>
<?php
	} else {

/********************************************************************
 *
 *  simple gallery view - when is this called?
 *
 *********************************************************************/
		if (!$vars['full']) {
?>
	<div class="tidypics_album_images">
		<a href="<?php echo $file->getURL();?>"><img src="<?php echo $vars['url'];?>mod/tidypics/thumbnail.php?file_guid=<?php echo $file_guid;?>&size=small" alt="thumbnail"/></a>
	</div>
<?php
		} else {

/********************************************************************
 *
 *  tidypics individual image display
 *
 *********************************************************************/

			$view_count = get_plugin_setting('view_count', 'tidypics');
			
			$viewer = get_loggedin_user();

			if ($view_count != 'disabled') {
				// Get view information
				
				//who is viewing?
				if($viewer->guid) {
					$the_viewer = $viewer->guid;
				} else {
					$the_viewer = 0;
				}
				
				// only non-owner views count
				if ($owner->guid != $view->owner_guid)
					create_annotation($file_guid, "tp_view", "1", "integer", $the_viewer, ACCESS_PUBLIC);
				$views_a = get_annotations($file_guid, "object", "image", "tp_view", "", 0, 9999);
				$views = count($views_a);
			
				$my_views = 0;
				$owner_views = 0;
				$diff_viewers = array();
	//			echo "<pre>"; var_dump($owner); echo "</pre>";
				foreach($views_a as $view) {
					if($view->owner_guid == $the_viewer && $the_viewer != 0) $my_views++;
					if($owner->guid == $view->owner_guid) $owner_views++;
					//count how many different people have viewed it
					if($owner->guid != $view->owner_guid) $diff_viewers[$view->owner_guid] = 1;
				}
				//remove the owner's views from the total count (prevents artificially inflated view counts)
				$views = $views - $owner_views;
			}
			
			// Build back and next links
			$back = '';
			$next = '';

			$album = get_entity($file->container_guid);

			$current = array_search($file_guid, $_SESSION['image_sort']);

			if (!$current) {  // means we are no longer using the correct album array

				//rebuild the array
				$count = get_entities("object","image", $album->guid, '', 999);
				$_SESSION['image_sort'] = array();

				foreach ($count as $image) {
					array_push($_SESSION['image_sort'], $image->guid);
				}

				if ($_SESSION['image_sort'])
					$current = array_search($file_guid, $_SESSION['image_sort']);
			}

			if ($current != 0)
				$back = '<a href="' .$vars['url'] . 'pg/photos/view/' . $_SESSION['image_sort'][$current-1] . '">&laquo; ' . elgg_echo('image:back') . '</a>';

			if (sizeof($_SESSION['image_sort']) > $current + 1)
				$next = '<a href="' . $vars['url'] . 'pg/photos/view/' . $_SESSION['image_sort'][$current+1] . '">' . elgg_echo('image:next') . ' &raquo;</a>';


?>
<div class="contentWrapper">
	<div id="tidypics_wrapper">

		<div id="tidypics_breadcrumbs">
			<?php echo elgg_view('tidypics/breadcrumbs', array('album' => $album,) ); ?> <br />
			<?php
				if ($view_count != 'disabled') {
					if ($owner->guid == $the_viewer) {
						echo sprintf(elgg_echo("tidypics:viewsbyowner"), $views, count($diff_viewers));
					} else {
						echo sprintf(elgg_echo("tidypics:viewsbyothers"), $views, $my_views);
					}
				}
			?>
		</div>

		<div id="tidypics_desc">
			<?php echo autop($desc); ?>
		</div>
		<div id="tidypics_image_nav">
			<ul>
				<li><?php echo $back; ?></li>
				<li><?php echo $next; ?></li>
			</ul>
		</div>
		<div id="tidypics_image_wrapper">
			<?php
				if (get_plugin_setting('download_link', 'tidypics') != "disabled") {  
					echo "<a href=\"{$vars['url']}action/tidypics/download?file_guid={$file_guid}&amp;view=inline\" title=\"{$title}\"><img id=\"tidypics_image\"  src=\"{$vars['url']}mod/tidypics/thumbnail.php?file_guid={$file_guid}&amp;size=large\" alt=\"{$title}\" /></a>";
				} else {
					echo "<img id=\"tidypics_image\"  src=\"{$vars['url']}mod/tidypics/thumbnail.php?file_guid={$file_guid}&amp;size=large\" alt=\"{$title}\" />";
				}
			?>
			<div class="clearfloat"></div>
		</div>
<?php
			// image menu (start tagging, download, etc.)
			
			echo '<div id="tidypics_controls"><ul>';
			echo elgg_view('tidypics/image_menu', array('file_guid' => $file_guid, 
														'viewer' => $viewer,
														'owner' => $owner,
														'anytags' => $photo_tags != '',
														'album' => $album, ) );
			echo '</ul></div>'; 
			
			// tagging code
			if (get_plugin_setting('tagging', 'tidypics') != "disabled") {
				echo elgg_view('tidypics/tagging', array(	'photo_tags' => $photo_tags, 
															'links' => $photo_tag_links,
															'photo_tags_json' => $photo_tags_json,
															'file_guid' => $file_guid,
															'viewer' => $viewer,
															'owner' => $owner, ) );
			}
			
			
			if (get_plugin_setting('exif', 'tidypics') == "enabled") {
?>
				<?php echo elgg_view('tidypics/exif', array('guid'=> $file_guid)); ?>
<?php		} ?>
		<div class="tidypics_info">
<?php if (!is_null($tags)) { ?>
			<div class="object_tag_string"><?php echo elgg_view('output/tags',array('value' => $tags));?></div>
<?php } 
			if (get_plugin_setting('photo_ratings', 'tidypics') == "enabled") {
?>
			<div id="rate_container">
	<?php echo elgg_view('rate/rate', array('entity'=> $vars['entity'])); ?>
</div>
<?php
			}
			
			echo elgg_echo('image:by');?> <b><a href="<?php echo $vars['url']; ?>pg/profile/<?php echo $owner->username; ?>"><?php echo $owner->name; ?></a></b>  <?php echo $friendlytime;
?>
		</div>
	</div> <!-- tidypics wrapper-->
<?php

			echo elgg_view_comments($file);

			echo '</div>';  // content wrapper

		} // end of individual image display

	}

?>


