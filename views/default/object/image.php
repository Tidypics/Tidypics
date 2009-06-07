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
$photo_tag_links = array();
$photo_tags_json = "\"\"";
$photo_tags = get_annotations($file_guid,'object','image','phototag');

if ($photo_tags) {
	$photo_tags_json = "[";
	foreach ($photo_tags as $p) {
		$photo_tag = unserialize($p->value);
		

		$phototag_text = $photo_tag->value;
		if ($photo_tag->type === 'user') {
			$user = get_entity($photo_tag->value);
			if ($user)
				$phototag_text = $user->name;
			else
				$phototag_text = "unknown user";
		}

		// hack to handle format of Pedro Prez's tags - ugh
		if (isset($photo_tag->x1)) {
			$photo_tag->coords = "\"x1\":\"{$photo_tag->x1}\",\"y1\":\"{$photo_tag->y1}\",\"width\":\"{$photo_tag->width}\",\"height\":\"{$photo_tag->height}\""; 
			$photo_tags_json .= '{' . $photo_tag->coords . ',"text":"' . $phototag_text . '","id":"' . $p->id . '"},';
		} else
			$photo_tags_json .= '{' . $photo_tag->coords . ',"text":"' . $phototag_text . '","id":"' . $p->id . '"},';
		
		$photo_tag_links[] = array($p->id, $phototag_text); // gave up on associative array for now
	}
	$photo_tags_json = rtrim($photo_tags_json,',');
	$photo_tags_json .= ']';
}


/////////////////////////////////////////////////////
//
// search view of an image
//
/////////////////////////////////////////////////////
	if (get_context() == "search") { 

		if (get_input('search_viewtype') == "gallery") {
			?>
			<div class="tidypics_album_images">
				<a href="<?php echo $file->getURL();?>"><img src="<?php echo $vars['url'];?>mod/tidypics/thumbnail.php?file_guid=<?php echo $file_guid;?>&size=small" border="0" alt="thumbnail"/></a>
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
			$icon = "<a href=\"{$file->getURL()}\">" . elgg_view("tidypics/icon", array("mimetype" => $mime, 'thumbnail' => $file->thumbnail, 'file_guid' => $file_guid, 'size' => 'small')) . "</a>";

			echo elgg_view_listing($icon, $info);
		}
	} else {

////////////////////////////////////////////////
//
//  simple gallery view - when is this called?
//
////////////////////////////////////////////////
		if (!$vars['full']) {
?>
	<div class="tidypics_album_images">
		<a href="<?php echo $file->getURL();?>"><img src="<?php echo $vars['url'];?>mod/tidypics/thumbnail.php?file_guid=<?php echo $file_guid;?>&size=small" border="0" alt="thumbnail"/></a>
	</div>
<?php
		} else {

////////////////////////////////////////////////////////
//
//  tidypics individual image display
//
////////////////////////////////////////////////////////

			// Get view information
			
			$viewer = get_loggedin_user();
		
			//who is viewing?
			if($viewer->guid) {
				$the_viewer = $viewer->guid;
			} else {
				$the_viewer = 0;
			}
			
			create_annotation($file_guid, "tp_view", "1", "integer", $the_viewer, 2);
			$views_a = get_annotations($file_guid, "object", "image", "tp_view", "", 0, 9999);
			$views = count($views_a);
		
			$my_views = 0;
			foreach($views_a as $view) {
				if($view->owner_guid == $the_viewer && $the_viewer != 0) $my_views++;
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

				$current = array_search($file_guid, $_SESSION['image_sort']);
			}

			if ($current != 0)
				$back = '<a href="' .$vars['url'] . 'pg/photos/view/' . $_SESSION['image_sort'][$current-1] . '#content_area_user_title">&#60;&#60;' . elgg_echo('image:back') . '</a>';

			if (sizeof($_SESSION['image_sort']) > $current + 1)
				$next = '<a href="' . $vars['url'] . 'pg/photos/view/' . $_SESSION['image_sort'][$current+1] . '#content_area_user_title">' . elgg_echo('image:next') . '&#62;&#62;</a>';


?>
<div class="contentWrapper">
	<div id="tidypics_wrapper">

		<div id="tidypics_breadcrumbs">
			<?php echo elgg_view('tidypics/breadcrumbs', array('album' => $album,) ); ?> <br />
			Views: <?=$views ?> <?= $my_views ? " ($my_views by me)" : ""; ?>
		</div>

		<div id="tidypics_desc">
			<?php echo autop($desc); ?>
		</div>
		<div id="tidypics_image_nav">
			<?php echo $back . "&nbsp;&nbsp;" . $next; ?>
		</div>
		<div id="tidypics_image_wrapper">
			<?php echo '<img id="tidypics_image"' . ' src="' . $vars['url'] . 'mod/tidypics/thumbnail.php?file_guid=' . $file_guid . '&size=large" alt="' . $title . '"/>'; ?>

			<div class="clearfloat"></div>
		</div>
<?php
			// image menu (start tagging, download, etc.)
			echo '<div id="tidypics_controls"><ul>';
			echo elgg_view('tidypics/image_menu', array('file_guid' => $file_guid, 
														'viewer' => $viewer,
														'owner' => $owner,) );
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
			
			
			if (get_plugin_setting('exif', 'tidypics') != "disabled") {
?>
			<div id="tidypics_breadcrumbs">
				<?php
					$exif = tp_exif_formatted($file_guid);
					if($exif) echo $exif;
				?>
			</div>
<?php		} ?>
		<div id="tidypics_info">
<?php if (!is_null($tags)) { ?>
			<div class="object_tag_string"><?php echo elgg_view('output/tags',array('value' => $tags));?></div>
<?php } 
			if (get_plugin_setting('photo_ratings', 'tidypics') != "disabled") {
?>
			<div id="rate_container">
	<?php echo elgg_view('rate/rate', array('entity'=> $vars['entity'])); ?>
</div>
<?
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


