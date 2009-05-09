<?php
	/**
	 *
	 * Tidypics image object views
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


// photo tags
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

	if (get_context() == "search") { //if this is the search view

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

		if (!$vars['full']) {

//simple gallery view
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

		<div id="tidypics_desc">
			<?php echo autop($desc); ?>
		</div>
		<div id="tidypics_image_nav">
			<?php echo $back . $next; ?>
		</div>
		<div id="tidypics_image_wrapper">
			<div id="tidypics_image_frame">
			<?php echo '<img id="tidypics_image"' . ' src="' . $vars['url'] . 'mod/tidypics/thumbnail.php?file_guid=' . $file_guid . '&size=large" alt="' . $title . '"/>'; ?>
			</div>
			<div class="clearfloat"></div>
		</div>
		<div id="tidypics_controls">
			<ul>
				<li><a id="tag_control" href="javascript:void(0)" onclick="startTagging()"><?= elgg_echo('tidypics:tagthisphoto') ?></a></li>
				<?php echo elgg_view('tidypics/download', array('file_guid' => $file_guid,) ); ?>
			</ul>
		</div>
<?php if ($photo_tags) { ?>
		<div id="tidypics_phototags_list">
			<h3><?php echo elgg_echo('tidypics:inthisphoto') ?></h3>
				<ul>
<?php
			foreach ($photo_tag_links as $tag_link) {
				echo "<li><a class='phototag-links' id='taglink{$tag_link[0]}' href='#'>{$tag_link[1]}</a></li>";
			}
?>
				</ul>
		</div>
<?php } ?>

		<div id="tidypics_info">
<?php if (!is_null($tags)) { ?>
			<div class="object_tag_string"><?php echo elgg_view('output/tags',array('value' => $tags));?></div>
<?php } ?>
<?
			echo elgg_echo('image:by');?> <b><a href="<?php echo $vars['url']; ?>pg/profile/<?php echo $owner->username; ?>"><?php echo $owner->name; ?></a></b>  <?php echo $friendlytime;
?>
		</div>
	</div> <!-- tidypics wrapper-->
<?php

			echo elgg_view_comments($file);

			echo '</div>';  // content wrapper
?>
<div id='tagging_instructions'>
	<div id='tag_instruct_text'><?php echo elgg_echo('tidypics:taginstruct'); ?></div>
	<div id='tag_instruct_button_div'><button class='submit_button' id='tag_instruct_button' onclick='stopTagging()'><?php echo elgg_echo('tidypics:finish_tagging'); ?></button></div>
</div>

<div id="tag_menu">
<?php

	$viewer = get_loggedin_user();
	$friends = get_entities_from_relationship('friend', $viewer->getGUID(), false, 'user', '', 0);

	$content = "<input type='hidden' name='image_guid' value='{$file_guid}' />";
	$content .= "<input type='hidden' name='coordinates' id='coordinates' value='' />";
	$content .= "<input type='hidden' name='user_id' id='user_id' value='' />";
	$content .= "<input type='hidden' name='word' id='word' value='' />";

	$content .= "<ul id='phototagging-menu'>";
	$content .= "<li><a href='javascript:void(0)' onClick='selectUser({$viewer->getGUID()},\"{$viewer->name}\")'> {$viewer->name} (" . elgg_echo('me') . ")</a></li>";

	if ($friends) {
		foreach($friends as $friend) {
			$content .= "<li><a href='javascript:void(0)' onClick='selectUser({$friend->getGUID()}, \"{$friend->name}\")'>{$friend->name}</a></li>";
		}
	}

	$content .= "</ul>";

	$content .= "<fieldset><button class='submit_button' type='submit'>" . elgg_echo('tidypics:actiontag') . "</button></fieldset>";

	echo elgg_view('input/form', array('internalid' => 'quicksearch', 'internalname' => 'form-phototagging', 'class' => 'quicksearch', 'action' => "{$vars['url']}action/tidypics/addtag", 'body' => $content));

?>
</div>

<?php

	echo elgg_view('js/tidypics', array('photo_tags_json' => $photo_tags_json,) );

		} // // end of individual image display

	}

?>


