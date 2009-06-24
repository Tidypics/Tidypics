<?php
	/**
	 * Tidypics Album RSS View
	 */

	$album = $vars['entity'];
	
	$title = $album->title;
	if (empty($title)) {
		$subtitle = strip_tags($vars['entity']->description);
		$title = substr($subtitle,0,32);
		if (strlen($subtitle) > 32)
			$title .= " ...";
	}

	$owner_guid = $album->getOwner();
	$images = get_entities("object", "image", 0, "", 10, 0, false, 0, $album->container_guid);
	
	//error_log(count($images));
?>

	<item>
		<guid isPermaLink='true'><?php echo htmlspecialchars($album->getURL()); ?></guid>
		<pubDate><?php echo date("r",$album->time_created) ?></pubDate>
		<link><?php echo htmlspecialchars($album->getURL()); ?></link>
		<title><![CDATA[<?php echo $title; ?>]]></title>
		<description><![CDATA[<?php echo (autop($album->description)); ?>]]></description>
<?php
			$owner = $album->getOwnerEntity();
			if ($owner)
			{
?>
		<dc:creator><?php echo $owner->name; ?></dc:creator>
<?php
			}
?>
	<?php echo elgg_view('extensions/item'); ?>
	</item>
