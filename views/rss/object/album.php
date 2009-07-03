<?php
	/**
	 * Tidypics Album RSS View
	 */

	// for now catch the albums view and ignore it
	if (get_context() == "search" && get_input('search_viewtype') == "gallery") {
	} else {

	$album = $vars['entity'];

	$base_url = $vars['url'] . 'mod/tidypics/thumbnail.php?file_guid=';

	// use fullsize image
	$base_url_fullsize = $vars['url'] . 'action/tidypics/download?file_guid=';

	// insert cover image if it exists image
	if ($album->cover) {
		// Set title
		$vars['title'] = $album->title;
		if (empty($vars['title'])) {
			$title = $vars['config']->sitename;
		} else if (empty($vars['config']->sitename)) {
			$title = $vars['title'];
		} else {
			$title = $vars['config']->sitename . ": " . $vars['title'];
		}
		$album_cover_url = $vars['url'] . 'mod/tidypics/thumbnail.php?file_guid=' . $album->cover . '&amp;size=thumb';
?>		<image>
			<url><?php echo $album_cover_url; ?></url>
			<title><![CDATA[<?php echo $title; ?>]]></title>
			<link><?php echo $album->getURL() . '?view=rss'; ?></link>

		</image>
<?php
	}


	$images = get_entities("object", "image", 0, "", 0, 0, false, 0, $album->guid);


	foreach ($images as $image) {
		$descr = '<p>' . get_entity($image->owner_guid)->name;
		$descr .= ' ' . elgg_echo('tidypics:posted') . '</p>';
		$descr .= "<p><img src=\"{$base_url}{$image->guid}&size=small\" /></p>";
		$descr .= "<p>{$image->description}</p>";

?>
	<item>
		<title><?php echo $image->title; ?></title>
		<link><?php echo $base_url . $image->guid . '&amp;size=large'; ?></link>
		<description><?php echo htmlentities($descr, ENT_QUOTES); ?></description>
		<pubDate><?php echo date("r", $image->time_created); ?></pubDate>
		<guid isPermaLink="true"><?php echo $image->getURL(); ?></guid>
		<media:content url="<?php echo $base_url_fullsize . $image->guid . '&amp;view=inline'; ?>" medium="image" type="<?php echo $image->getMimeType(); ?>" />
		<media:title><?php echo $image->title; ?></media:title>
		<media:description><?php echo htmlentities($image->description); ?></media:description>
		<media:thumbnail url="<?php echo $base_url . $image->guid . '&amp;size=thumb'; ?>"></media:thumbnail>
	</item>

<?php
	}

	}
?>