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
$photo_tags_json = "";
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
				$back = '<a href="' .$vars['url'] . 'pg/photos/view/' . $_SESSION['image_sort'][$current-1] . '">&#60;&#60;' . elgg_echo('image:back') . '</a>';

			if (sizeof($_SESSION['image_sort']) > $current + 1)
				$next = '<a href="' . $vars['url'] . 'pg/photos/view/' . $_SESSION['image_sort'][$current+1] . '">' . elgg_echo('image:next') . '&#62;&#62;</a>';


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
				<li><a href="javascript:void(0)" onclick="startTagging()"><?= elgg_echo('image:tagthisphoto') ?></a></li>
				<li><a href="<?php echo $vars['url']; ?>action/tidypics/download?file_guid=<?php echo $file_guid; ?>"><?php echo elgg_echo("image:download"); ?></a></li>
			</ul>
		</div>
<?php if ($photo_tags) { ?>
		<div id="tidypics_phototags_list">
			<h3><?php echo elgg_echo('image:inthisphoto') ?></h3>
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
		} // // end of individual image display

	}

?>

<div id='tagging_instructions'>
	<table>
		<tbody>
			<tr>
				<td width='375' align='center'><div id='instructions_default_message'><?php echo elgg_echo('image:doclickfortag'); ?></div></td>
				<td valign='middle'><button class='submit_button' onclick='stopTagging()'><?php echo elgg_echo('image:finish_tagging'); ?></button></td>
			</tr>
		</tbody>
	</table>
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

	$content .= "<fieldset><button class='submit_button' type='submit'>" . elgg_echo('image:actiontag') . "</button></fieldset>";

	echo elgg_view('input/form', array('internalid' => 'quicksearch', 'internalname' => 'form-phototagging', 'class' => 'quicksearch', 'action' => "{$vars['url']}action/tidypics/addtag", 'body' => $content));

?>
</div>

<script type="text/javascript" src="<?= $vars['url'] ?>mod/tidypics/vendors/jquery.imgareaselect-0.7.js"></script>
<script type="text/javascript" src="<?= $vars['url'] ?>mod/tidypics/vendors/jquery.quicksearch.js"></script>
 
<script type="text/javascript">

	var coordinates = "";
	var user_id = 0;

	// add to DOM as soon as ready
	$(document).ready(function () {
			$('ul#phototagging-menu li').quicksearch({
				position: 'before',
				attached: 'ul#phototagging-menu',
				loaderText: '',
				inputClass: 'input-filter',
				labelText: "<p>Insert tag</p>",
				delay: 100
			});

			$('#quicksearch').submit( function () { addTag() } );
		}
	);

	// images are loaded so process tags
	$(window).load(function () {
			$('#tidypics_image').setupTags();
		}
	);

	// get tags over image ready for mouseover
	$.fn.setupTags = function() 
	{

		image = this;

		imgOffset = $(image).offset();

		tags = <?php echo $photo_tags_json; ?>; 

		$(tags).each(function(){
			appendTag(imgOffset, this);
		});
		
		$(image).hover(
			function(){
				$('.tidypics_tag').show();
			},
			function(){
				$('.tidypics_tag').hide();
			}
		);

		addTagEvents();
		
		$('.phototag-links').hover(
			function(){
				code = this.id.substr(7); // cut off taglink to get unique id
				$('#tag'+code).show();
			},
			function(){
				code = this.id.substr(7);
				$('#tag'+code).hide();
			}
		);

		// make sure we catch and handle when the browser is resized
		$(window).resize(function () {
			$('.tidypics_tag').remove();

			imgOffset = $(image).offset();

			$(tags).each(function(){
				appendTag(imgOffset, this);
			});

			addTagEvents();
		});
	} 

	function appendTag(offset, tag)
	{
		tag_top   = parseInt(imgOffset.top) + parseInt(tag.y1);
		tag_left  = parseInt(imgOffset.left) + parseInt(tag.x1);

		tag_div = $('<div class="tidypics_tag" id="tag'+tag.id+'"></div>').css({ left: tag_left + 'px', top: tag_top + 'px', width: tag.width + 'px', height: tag.height + 'px' });

		tag_text_div = $('<div class="tidypics_tag_text">'+tag.text+'</div>').css({ left: tag_left + 'px', top: tag_top + 'px', width: tag.width + 'px', height: 20 + 'px' });

		$('body').append(tag_div);
		$('body').append(tag_text_div);
	}

	function addTagEvents() 
	{
		$('.tidypics_tag').hover(
			function(){
				$('.tidypics_tag').show();
				$(this).next('.tidypics_tag_text').show();
				$(this).next('.tidypics_tag_text').css("z-index", 10000);
			},
			function(){
				$('.tidypics_tag').show();
				$(this).next('.tidypics_tag_text').hide();
				$(this).next('.tidypics_tag_text').css("z-index", 0);
			}
		);
	}


	function selectUser(id, name) 
	{
		user_id = id;
		$("input.input-filter").val(name);
	}

	function startTagging() 
	{
		if ( $('#tagging_instructions').is(':hidden') )
		{
			$('#tagging_instructions').show();

			$('#tidypics_image').hover(
				function(){
					$('.tidypics_tag').hide();
				},
				function(){
					$('.tidypics_tag').hide();
				}
		);

			$('img#tidypics_image').imgAreaSelect( { 
				borderWidth: 2,
				borderColor1: 'white',
				borderColor2: 'white',
				disable: false,
				hide: false,
				onSelectEnd: showTagMenu,
				onSelectStart: hideTagMenu 
				}
			);
		}
	}

	function stopTagging() 
	{
		$('#tagging_instructions').hide();
		$('#tag_menu').hide();
		$('img#tidypics_image').imgAreaSelect( {hide: true, disable: true} );

		$('#tidypics_image').hover(
			function(){
				$('.tidypics_tag').show();
			},
			function(){
				$('.tidypics_tag').hide();
			}
		);
	}

	function showTagMenu(oObject, oCoordenates)
	{
		offsetX = -100;

		imgOffset = $('#tidypics_image').offset();

		// show the list of friends
		if (oCoordenates.width != 0 && oCoordenates.height != 0) {
			coordinates = oCoordenates;
			
			top = imgOffset.top + oCoordenates.y2;
			left = imgOffset.left + oCoordenates.x2 + offsetX;

			$('#tag_menu').show().css({
				"top": top + "px",
				"left": left + "px"
			});

			$(".input-filter").focus();
		}
	}


	function hideTagMenu()
	{
		$('#tag_menu').hide();
		coordinates = "";
	}


	function addTag()
	{
		// do I need a catch for no tag?

		$("input#user_id").val(user_id);
		$("input#word").val( $("input.input-filter").val() );

		coord_string  = '"x1":"' + coordinates.x1 + '",';
		coord_string += '"y1":"' + coordinates.y1 + '",';
		coord_string += '"width":"' + coordinates.width + '",';
		coord_string += '"height":"' + coordinates.height + '"';

		$("input#coordinates").val(coord_string);

		//Show loading
		//$("#tag_menu").replaceWith('<div align="center" class="ajax_loader"></div>');
	}
</script>