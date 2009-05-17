<?php

	/**
	 * Tidypics RSS file object view - need to look into removing download link based on settings
	 */

	$title = $vars['entity']->title;
	if (empty($title)) {
		$title = substr($vars['entity']->description,0,32);
		if (strlen($vars['entity']->description) > 32)
			$title .= " ...";
	}

?>

	<item>
	  <guid isPermaLink='true'><?php echo $vars['entity']->getURL(); ?></guid>
	  <pubDate><?php echo date("r",$vars['entity']->time_created) ?></pubDate>
	  <link><?php echo $vars['entity']->getURL(); ?></link>
	  <title><![CDATA[<?php echo $title; ?>]]></title>
	  <description><![CDATA[<?php echo (autop($vars['entity']->description)); ?>]]></description>
	  <enclosure url="<?php echo $vars['url']; ?>action/file/download?file_guid=<?php echo $vars['entity']->getGUID(); ?>" length="<?php echo $vars['entity']->size(); ?>" type="<?php echo $vars['entity']->getMimeType(); ?>" />
	</item>
