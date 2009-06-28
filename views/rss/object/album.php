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
	
	$base_url = $vars['url'] . 'mod/tidypics/thumbnail.php?file_guid=';

	
	$owner_guid = $album->getOwner();
	$images = get_entities("object", "image", 0, "", 10, 0, false, 0, $album->guid);
	
	echo "\n";
	
	foreach ($images as $image) {
		$caption = $image->description;
		if (!$caption)
			$caption = "No caption";
?>
	<item>
		<title><?php echo $image->title; ?></title>
		<link><?php echo $image->getURL(); ?></link>
		<description><?php echo $caption; ?></description>
		<pubDate><?php echo date("r", $image->time_created); ?></pubDate>
		<guid isPermaLink="true"><?php echo $image->getURL(); ?></guid>
		<media:content url="<?php echo $base_url . $image->guid . '&amp;size=large'; ?>" medium="image" type="<?php echo $image->getMimeType(); ?>">
			<media:title><?php echo $image->title; ?></media:title>
			<media:description><?php echo $caption; ?></media:description>
			<media:thumbnail url="<?php echo $base_url . $image->guid . '&amp;size=thumb'; ?>"></media:thumbnail>
		</media:content>
	</item>
	
<?php
	}
?>