<?php
	/**

	 * image object views
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.com/
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
	
if (get_context() == "search") { //if this is the search view
		
		
		if (get_input('search_viewtype') == "gallery") {
			?> 
			<div class="album_images">
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
}
else { //tidypics image display
		
	if (!$vars['full']) { //simple gallery view
	
?> 
		<div class="album_images">
			<a href="<?php echo $file->getURL();?>"><img src="<?php echo $vars['url'];?>mod/tidypics/thumbnail.php?file_guid=<?php echo $file_guid;?>&size=small" border="0" alt="thumbnail"/></a>
		</div>
<?php
	}
	else{  // individual full image view 
			
		$album = get_entity($file->container_guid);
	
	//compile back | next links	
		$current = array_search($file_guid, $_SESSION['image_sort']);
	
		if(!$current){  // means we are no longer using the correct album array
			
			//rebuild the array ->
			$count = get_entities("object","image", $album->guid, '', 999);
			$_SESSION['image_sort'] = array();
	
			foreach($count as $image){
				array_push($_SESSION['image_sort'], $image->guid);
			}	
			
			$current = array_search($file_guid, $_SESSION['image_sort']);	
		}
		
		if(!$current == 0)
			$back = '<a href="' .$vars['url'] . 'pg/photos/view/' . $_SESSION['image_sort'][$current-1] . '">&#60;&#60;' . elgg_echo('image:back') . '</a>&nbsp;&nbsp;';
		
		if(array_key_exists(($current+1), $_SESSION['image_sort']))
			$next = '&nbsp;&nbsp;<a href="' . $vars['url'] . 'pg/photos/view/' . $_SESSION['image_sort'][$current+1] . '">' . elgg_echo('image:next') . '&#62;&#62;</a>';

?>	
	<div id="pages_breadcrumbs">
<?php
		if (is_null(page_owner_entity()->username) || empty(page_owner_entity()->username)) { //when no owner available, link to world photos
?>
		<a href="<?php echo $vars['url'] . 'pg/photos/world'; ?>"><?php echo elgg_echo("albums"); ?></a>&nbsp;&#62;&nbsp;
<?php
		} else {
?>
		<a href="<?php echo $vars['url'] . 'pg/photos/owned/' . page_owner_entity()->username; ?>"><?php echo sprintf(elgg_echo("album:user"), page_owner_entity()->name); ?></a>&nbsp;&#62;&nbsp;
<?php
		}
?>
		<a href="<?php echo $album->getURL(); ?>"><?php echo $album->title; ?></a>&nbsp;&#62;&nbsp;
		<?php echo $current+1 . ' / ' . sizeof($_SESSION['image_sort']); ?>
	</div>
<?php			
	echo '<div id="tidypics_title">' . $title . '</div>'; 
	echo '<div id="tidypics_desc">' . autop($desc) . '</div>';		
	echo '<div id="image_full">';
	  echo '<div id="image_nav">' . $back . $next . '</div>';	  
	  if($next) echo '<a href="' . $vars['url'] . 'pg/photos/view/' . $_SESSION['image_sort'][$current+1] . '">';
	  echo '<img src="' . $vars['url'] . 'mod/tidypics/thumbnail.php?file_guid=' . $file_guid . '&size=large" border="0" alt="' . $title . '"/>';
	  if($next) echo '</a>';
	echo '</div>';
?>
			<div id="tidypics_controls">
				<a target="_new" href="<?php echo $vars['url']; ?>action/tidypics/download?file_guid=<?php echo $file->getGUID(); ?>"><?php echo elgg_echo("image:download"); ?></a>&nbsp;
<?php
		if ($file->canEdit()) {	// add edit controls
?>
				<a href="<?php echo $vars['url']; ?>mod/tidypics/edit.php?file_guid=<?php echo $file->getGUID(); ?>"><?php echo elgg_echo('image:edit'); ?></a>&nbsp; 
				<?php echo elgg_view('output/confirmlink',array(
							'href' => $vars['url'] . "action/tidypics/delete?file=" . $file->getGUID(),
							'text' => elgg_echo("image:delete"),
							'confirm' => elgg_echo("image:delete:confirm"),
				));
		}
				?>
			</div>
	
		<div id="tidypics_info">
			<div class="object_tag_string"><?php echo elgg_view('output/tags',array('value' => $tags));?></div>	
			<?php echo elgg_echo('image:by');?> <b><a href="<?php echo $vars['url']; ?>pg/profile/<?php echo $owner->username; ?>"><?php echo $owner->name; ?></a></b>  <?php echo $friendlytime; ?><br>		
		</div>
<?php 
		echo elgg_view_comments($file);	
	}
	
}
?>