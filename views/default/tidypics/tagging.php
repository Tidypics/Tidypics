<?php
	$photo_tags = $vars['photo_tags'];
	$links = $vars['links'];
	$photo_tags_json = $vars['photo_tags_json'];
	$file_guid = $vars['file_guid'];
	$viewer = $vars['viewer'];
	$owner = $vars['owner'];
	
	if ($photo_tags) { 
?>
<div id="tidypics_phototags_list">
	<h3><?php echo elgg_echo('tidypics:inthisphoto') ?></h3>
	<ul>
<?php
		foreach ($links as $tag_link) {
			echo "<li><a class='phototag-links' id='taglink{$tag_link[0]}' href='#'>{$tag_link[1]}</a></li>";
		}
?>
	</ul>
</div>
<?php 
	} 
?>
<div id='tagging_instructions'>
	<div id='tag_instruct_text'><?php echo elgg_echo('tidypics:taginstruct'); ?></div>
	<div id='tag_instruct_button_div'><button class='submit_button' id='tag_instruct_button' onclick='stopTagging()'><?php echo elgg_echo('tidypics:finish_tagging'); ?></button></div>
</div>
<div id="tag_menu">
<?php

	if($viewer) {
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
	}
	$content .= "</ul>";

	$content .= "<fieldset><button class='submit_button' type='submit'>" . elgg_echo('tidypics:actiontag') . "</button></fieldset>";

	echo elgg_view('input/form', array('internalid' => 'quicksearch', 'internalname' => 'form-phototagging', 'class' => 'quicksearch', 'action' => "{$vars['url']}action/tidypics/addtag", 'body' => $content));

?>
</div>
<?php
	echo elgg_view('js/tagging', array('photo_tags_json' => $photo_tags_json,) );
?>