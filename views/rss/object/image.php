<?php

$title = $vars['entity']->title;
$descr = $vars['entity']->description;
$download = $vars['url'] . 'pg/photos/download/' . $vars['entity']->guid . '/inline/';
$base_url = $vars['url'] . 'mod/tidypics/thumbnail.php?file_guid=';
?>

	<item>
		<title><?php echo $title; ?></title>
		<link><?php echo $base_url . $vars['entity']->guid . '&amp;size=large'; ?></link>
		<description><?php echo htmlentities($descr, ENT_QUOTES); ?></description>
		<pubDate><?php echo date("r", $vars['entity']->time_created); ?></pubDate>
		<guid isPermaLink="true"><?php echo $vars['entity']->getURL(); ?></guid>
		<media:content url="<?php echo $download; ?>" medium="image" type="<?php echo $vars['entity']->getMimeType(); ?>" />
		<media:title><?php echo $title; ?></media:title>
		<media:description><?php echo htmlentities($descr); ?></media:description>
		<media:thumbnail url="<?php echo $base_url . $vars['entity']->guid . '&amp;size=thumb'; ?>"></media:thumbnail>
	</item>