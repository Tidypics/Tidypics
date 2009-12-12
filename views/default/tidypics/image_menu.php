<?php

	/**************************************************************************
	 *
	 *  Tidypics Image Menu
	 *
	 *  This is the menu that appears below an image. Admins can override the
	 *  menu with a different view to provide a look and feel that matches
	 *  their themes. The view can be extended to provide additional controls.
	 *
	 **************************************************************************/

	$image_guid = $vars['image_guid'];
	$viewer = $vars['viewer'];
	$owner = $vars['owner'];
	$anytags = $vars['anytags'];
	$album = $vars['album'];

	if (get_plugin_setting('tagging', 'tidypics') != "disabled") {
		
		$can_tag = false;
		
		$container = get_entity($album->container_guid);
		if ($container instanceof ElggGroup) {
			$can_tag = $viewer && $container->isMember($viewer);
		} else {
			$can_tag = $viewer && $viewer->guid == $owner->guid || user_is_friend($owner->guid, $viewer->guid);
		}
		
		// only owner and friends of owner can tag
		if ($can_tag) {
?>
<li id="start_tagging"><a id="tidypics_tag_control" href="javascript:void(0)" onclick="startTagging()"><?php echo elgg_echo('tidypics:tagthisphoto'); ?></a></li>
<?php
		}
		
		// only owner can delete tags
		if ($anytags && $viewer && $viewer->guid == $owner->guid) {
?>
<li id="delete_tags"><a href="javascript:void(0)" onclick="deleteTags()"><?php elgg_echo('tidypics:deletetag'); ?></a></li>
<?php
		}
	}
	
	if (get_plugin_setting('download_link', 'tidypics') != "disabled") {
		$download_url = $vars['url'] . "pg/photos/download/{$image_guid}/"; 
?>
<li id="download_image"><a href="<?php echo $download_url; ?>"><?php echo elgg_echo("image:download"); ?></a></li>
<?php
	} 
?>