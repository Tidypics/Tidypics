<?php

	$image = $vars['image'];
	$viewer = $vars['viewer'];
	$owner = $vars['owner'];

	// get photo tags
	$tag_info = $image->getPhotoTags();

	// defining json text as "" makes sure the tagging javascript code doesn't throw errors if no tags
	$photo_tags_json = "\"\"";
	if ($tag_info) {
		$photo_tags_json = $tag_info['json'];
	}
	
	if ($tag_info) { 
?>
<div id="tidypics_phototags_list">
	<h3><?php echo elgg_echo('tidypics:inthisphoto') ?></h3>
	<ul>
<?php
		foreach ($tag_info['links'] as $id=>$link) {
			echo "<li><a class='tidypics_phototag_links' id='taglink{$id}' href='{$link['url']}'>{$link['text']}</a></li>";
		}
?>
	</ul>
</div>
<?php 
	} 
?>
<div id='tidypics_tag_instructions'>
	<div id='tidypics_tag_instruct_text'><?php echo elgg_echo('tidypics:taginstruct'); ?></div>
	<div id='tidypics_tag_instruct_button_div'><button class='submit_button' id='tidypics_tag_instruct_button' onclick='stopTagging()'><?php echo elgg_echo('tidypics:finish_tagging'); ?></button></div>
</div>
<div id="tidypics_tag_menu" class="tidypics_popup">
	<div class='tidypics_popup_header'><h3><?php echo elgg_echo('tidypics:tagthisphoto'); ?></h3></div>
<?php

	if ($viewer) {
		
		$people_list = tp_get_tag_list($viewer);

		$content = "<div id='tidypics_tagmenu_left'>";
		$content .= "<input type='hidden' name='image_guid' value='{$image->guid}' />";
		$content .= "<input type='hidden' name='coordinates' id='coordinates' value='' />";
		$content .= "<input type='hidden' name='user_id' id='user_id' value='' />";
		$content .= "<input type='hidden' name='word' id='word' value='' />";
	
		$content .= "<ul id='tidypics_phototag_list'>";
		$content .= "<li><a href='javascript:void(0)' onclick='selectUser({$viewer->getGUID()},\"{$viewer->name}\")'> {$viewer->name} (" . elgg_echo('me') . ")</a></li>";
	
		if ($people_list) {
			foreach($people_list as $friend_guid => $friend_name) {
				$content .= "<li><a href='javascript:void(0)' onclick='selectUser({$friend_guid}, \"{$friend_name}\")'>{$friend_name}</a></li>";
			}
		}
		
		$content .= "</ul></div>";
		
		$content .= "<div id='tidypics_tagmenu_right'><input type='submit' value='" . elgg_echo('tidypics:actiontag') . "' class='submit_button' /></div>";
		
		echo elgg_view('input/form', array('internalid' => 'quicksearch', 'internalname' => 'tidypics_phototag_form', 'class' => 'quicksearch', 'action' => "{$vars['url']}action/tidypics/addtag", 'method' => 'post', 'body' => $content));
	}

?>
<div class="clearfloat"></div>
</div>
<div id="tidypics_delete_tag_menu" class="tidypics_popup">
<div class='tidypics_popup_header'><h3><?php echo elgg_echo('tidypics:deltag_title'); ?></h3></div>
<?php
	if ($tag_info) {
		$content = "<input type='hidden' name='image_guid' value='{$image->guid}' />";
		foreach ($tag_info['links'] as $id => $link) {
			$text = htmlentities($link['text'], ENT_QUOTES, 'UTF-8');
			$content .= "<label><input type=\"checkbox\" class=\"input-checkboxes\" name=\"tags[{$id}]\" value=\"{$text}\" />{$text}</label><br />";
		}

		$content .= "<input type='submit' value='" . elgg_echo('tidypics:actiondelete') . "' class='submit_button' />";
		$content .= "<input type='button' value='" . elgg_echo('cancel') . "' class='cancel_button' onclick='hideDeleteMenu();' />"; 

		echo elgg_view('input/form', array('internalname' => 'phototag_deletetag_form', 'action' => "{$vars['url']}action/tidypics/deletetag", 'method' => 'post', 'body' => $content));

	}
	echo '</div>'; // tidypics_delete_tag_menu
	
	echo elgg_view('js/tagging', array('photo_tags_json' => $photo_tags_json,) );
?>