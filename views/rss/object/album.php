<?php
	/**
	 * Tidypics Album RSS View
	 */

// for now catch the albums view and ignore it
if (get_context() == "search" && get_input('search_viewtype') == "gallery") {
?>
	<item>
	  <guid isPermaLink='true'><?php echo $vars['entity']->getURL(); ?></guid>
	  <pubDate><?php echo date("r",$vars['entity']->time_created) ?></pubDate>
	  <link><?php echo $vars['entity']->getURL(); ?></link>
	  <title><![CDATA[<?php echo $$vars['entity']->title; ?>]]></title>
	  <description><![CDATA[<?php echo (autop($vars['entity']->description)); ?>]]></description>
	</item>

<?php
} else {

	$album = $vars['entity'];

	// use fullsize image
	$base_url_fullsize = $vars['url'] . 'pg/photos/download/';

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
		echo elgg_view_entity($image);
	}

}
?>