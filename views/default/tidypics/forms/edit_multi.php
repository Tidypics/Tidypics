<?php
	/**
	* form for mass editing all uploaded images
	*/	
?>
<div class="contentWrapper">
<form action="<?php echo $vars['url']; ?>action/tidypics/edit_multi" method="post">
<?php

	$file_array = $vars['file_array'];
	$album_entity = get_entity($vars['album_guid']);
	if(!$album_entity->cover) $no_cover = true;
	
	foreach($file_array as $key => $file_guid){
		$entity = get_entity($file_guid);
		$guid = $entity->guid;
		$body = $entity->description;
		$tags = $entity->tags;
		$container_guid = $entity->container_guid;
		if($no_cover && !$cover) $cover = $guid;
						
  echo '<div class="edit_image_container">';		
	echo '<img src="' . $vars['url'] . 'mod/tidypics/thumbnail.php?file_guid=' . $guid . '&size=small" border="0" class="edit_images" alt="' . $title . '"/>';
	echo '<div class="image_info">';
	echo '<p><label>' . elgg_echo('album:title') . '</label>';
	echo elgg_view("input/text", array("internalname" => "title[$key]", "value" => $title,)) . "\n";
	echo '</p>';
	  echo '<p><label>' . elgg_echo('caption') . "</label>";
	  echo elgg_view("input/text",array("internalname" => "caption[$key]", "value" => $body,)) . "\n";
	  echo "</p>";
	  echo '<p><label>' . elgg_echo("tags") . "</label>\n";
	  echo elgg_view("input/tags", array( "internalname" => "tags[$key]","value" => $tags)) . "\n";
	  echo '</p>';
	  echo '<input type="hidden" name="image_guid[' .$key. ']" value="'. $guid .'">' . "\n";
	  echo '<label>' . elgg_echo("album:cover") . '</label>';
	  echo elgg_view("input/multi_radio", array( "internalname" => "cover", "value" => $guid, 'options' => array(elgg_echo('album:cover:yes')), 'set' => $cover));
	echo '</div>';
  echo '</div>';
		
	}
?>
<input type="hidden" name="container_guid" value="<?php echo $container_guid; ?>" /> 		
<p><input type="submit" name="submit" value="<?php echo elgg_echo('save'); ?>" /></p>
</form>
</div>