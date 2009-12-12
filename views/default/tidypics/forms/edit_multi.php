<?php
	/**
	* form for mass editing all uploaded images
	*/	
?>
<div class="contentWrapper">
<form action="<?php echo $vars['url']; ?>action/tidypics/edit_multi" method="post">
<?php

	$file_array = $vars['file_array'];
	
	// make sure one of the images becomes the cover if there isn't one already
	$album_entity = get_entity($vars['album_guid']);
	if (!$album_entity->cover) $no_cover = true;
	
	foreach ($file_array as $key => $file_guid){
		$entity = get_entity($file_guid);
		$guid = $entity->guid;
		$body = $entity->description;
		$title = $entity->title;
		$tags = $entity->tags;
		$container_guid = $entity->container_guid;
		
		// first one is default cover if there isn't one already
		if ($no_cover) {
			$val = $guid;
			$no_cover = false;
		}
		
		echo '<div class="tidypics_edit_image_container">';
		echo '<img src="' . $vars['url'] . 'mod/tidypics/thumbnail.php?file_guid=' . $guid . '&size=small" class="tidypics_edit_images" alt="' . $title . '"/>';
		echo '<div class="tidypics_image_info">';
		echo '<p><label>' . elgg_echo('album:title') . '</label>';
		echo elgg_view("input/text", array("internalname" => "title[$key]", "value" => $title,)) . "\n";
		echo '</p>';
		echo '<p><label>' . elgg_echo('caption') . "</label>";
		echo elgg_view("input/longtext",array("internalname" => "caption[$key]", "value" => $body, "class" => 'tidypics_caption_input',)) . "\n";
		echo "</p>";
		echo '<p><label>' . elgg_echo("tags") . "</label>\n";
		echo elgg_view("input/tags", array( "internalname" => "tags[$key]","value" => $tags)) . "\n";
		echo '</p>';
		echo '<input type="hidden" name="image_guid[' .$key. ']" value="'. $guid .'">' . "\n";
		echo elgg_view('input/securitytoken');
		
		echo elgg_view("input/radio", array("internalname" => "cover",
											"value" => $val,
											'options' => array(	elgg_echo('album:cover') => $guid,
																),
													));
		echo '</div>';
		echo '</div>';
	}
	
?>
<input type="hidden" name="container_guid" value="<?php echo $container_guid; ?>" />
<p><input type="submit" name="submit" value="<?php echo elgg_echo('save'); ?>" /></p>
</form>
</div>