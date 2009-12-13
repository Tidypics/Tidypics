<?php
	/**
	 *
	 * Tidypics image object views
	 */

	global $CONFIG;
	include_once dirname(dirname(dirname(dirname(__FILE__)))) . "/lib/exif.php";

	$image = $vars['entity'];
	$image_guid = $image->getGUID();
	$tags = $image->tags;
	$title = $image->title;
	$desc = $image->description;
	$owner = $image->getOwnerEntity();
	$friendlytime = friendly_time($image->time_created);


/********************************************************************
 *
 * search view of an image
 *
 ********************************************************************/
	if (get_context() == "search") { 

		// gallery view is a matrix view showing just the image - size: small
		if (get_input('search_viewtype') == "gallery") {
			?>
			<div class="tidypics_album_images">
				<a href="<?php echo $image->getURL();?>"><img src="<?php echo $vars['url'];?>mod/tidypics/thumbnail.php?file_guid=<?php echo $image_guid;?>&size=small" alt="thumbnail"/></a>
			</div>
			<?php
		}
		else{
			// list view displays a thumbnail icon of the image, its title, and the number of comments
			$info = '<p><a href="' .$image->getURL(). '">'.$title.'</a></p>';
			$info .= "<p class=\"owner_timestamp\"><a href=\"{$vars['url']}pg/profile/{$owner->username}\">{$owner->name}</a> {$friendlytime}";
			$numcomments = elgg_count_comments($image);
			if ($numcomments)
				$info .= ", <a href=\"{$image->getURL()}\">" . sprintf(elgg_echo("comments")) . " (" . $numcomments . ")</a>";
			$info .= "</p>";
			$icon = "<a href=\"{$image->getURL()}\">" . '<img src="' . $vars['url'] . 'mod/tidypics/thumbnail.php?file_guid=' . $image_guid . '&size=thumb" alt="' . $title . '" /></a>';
			
			echo elgg_view_listing($icon, $info);
		}

/***************************************************************
 *
 * front page view 
 *
 ****************************************************************/
	} else if (get_context() == "front") {
		// the front page view is a clikcable thumbnail of the image
?>
<a href="<?php echo $image->getURL(); ?>">
<img src="<?php echo $vars['url'];?>mod/tidypics/thumbnail.php?file_guid=<?php echo $image_guid;?>&amp;size=thumb" class="tidypics_album_cover" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" />
</a>
<?php
	} else {

/********************************************************************
 *
 *  listing of photos in an album
 *
 *********************************************************************/
		if (!$vars['full']) {
			
?>
<?php 
	// plugins can override the image link to add lightbox code here
	$image_html = false;
	$image_html = trigger_plugin_hook('tp_thumbnail_link', 'album', array('image' => $image), $image_html);
	
	if ($image_html) {
		echo $image_html;
	} else {
		// default link to image if no one overrides
?>
	<div class="tidypics_album_images">
		<a href="<?php echo $image->getURL();?>"><img src="<?php echo $vars['url'];?>pg/photos/thumbnail/<?php echo $image_guid;?>/small/" alt="<?php echo $image->title; ?>"/></a>
	</div>
<?php 	
	}
?>
<?php
		} else {

/********************************************************************
 *
 *  tidypics individual image display
 *
 *********************************************************************/

			
			$viewer = get_loggedin_user();

			
			// Build back and next links
			$back = '';
			$next = '';

			$album = get_entity($image->container_guid);

			$current = array_search($image_guid, $_SESSION['image_sort']);

			if (!$current) {  // means we are no longer using the correct album array

				//rebuild the array
				$count = get_entities("object","image", $album->guid, '', 999);
				$_SESSION['image_sort'] = array();

				foreach ($count as $img) {
					array_push($_SESSION['image_sort'], $img->guid);
				}

				if ($_SESSION['image_sort'])
					$current = array_search($image_guid, $_SESSION['image_sort']);
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
				if (get_plugin_setting('view_count', 'tidypics') != "disabled") {
					
					$image->addView($viewer->guid);
					$views = $image->getViews($viewer->guid);
					if (is_array($views)) {
						echo sprintf(elgg_echo("tidypics:views"), $views['total']);
						if ($owner->guid == $viewer->guid) {
							echo ' ' . sprintf(elgg_echo("tidypics:viewsbyowner"), $views['unique']);
						}
						else {
							if ($views['mine'])
								echo ' ' . sprintf(elgg_echo("tidypics:viewsbyothers"), $views['mine']);
						}
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
				// this code controls whether the photo is a hyperlink or not and what it links to 
				if (get_plugin_setting('download_link', 'tidypics') != "disabled") {
					// admin allows downloads so default to inline download link
					$image_html = "<a href=\"{$vars['url']}pg/photos/download/{$image_guid}/inline/\" title=\"{$title}\" >";
					$image_html .= "<img id=\"tidypics_image\"  src=\"{$vars['url']}pg/photos/thumbnail/{$image_guid}/large/\" alt=\"{$title}\" />";
					$image_html .= "</a>";
				} else {
					$image_html = "<img id=\"tidypics_image\"  src=\"{$vars['url']}pg/photos/thumbnail/{$image_guid}/large/\" alt=\"{$title}\" />";
				}
				// does any plugin want to override the link
				$image_html = trigger_plugin_hook('tp_thumbnail_link', 'image', array('image' => $image), $image_html);
				echo $image_html;
				?>
			<div class="clearfloat"></div>
		</div>
<?php
			// image menu (start tagging, download, etc.)
			
			echo '<div id="tidypics_controls"><ul>';
			echo elgg_view('tidypics/image_menu', array('image_guid' => $image_guid, 
														'viewer' => $viewer,
														'owner' => $owner,
														'anytags' => $image->isPhotoTagged(),
														'album' => $album, ) );
			echo '</ul></div>'; 
			
			// tagging code - photo tags on images, photo tag listing and hidden divs used in tagging 
			if (get_plugin_setting('tagging', 'tidypics') != "disabled") {
				echo elgg_view('tidypics/tagging', array(	'image' => $image, 
															'viewer' => $viewer,
															'owner' => $owner, ) );
			}
			
			
			if (get_plugin_setting('exif', 'tidypics') == "enabled") {
?>
				<?php echo elgg_view('tidypics/exif', array('guid'=> $image_guid)); ?>
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

			echo elgg_view_comments($image);
			
			echo '<div class="clearfloat"></div>';

			echo '</div>';  // content wrapper

		} // end of individual image display

	}

?>


