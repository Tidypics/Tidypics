<?php

	/*
	 * Overriding core view to work around bug dealing with empty titles
	 */

	$performed_by = get_entity($vars['item']->subject_guid);
	$object = get_entity($vars['item']->object_guid);
	$url = $object->getURL();
	$subtype = get_subtype_from_id($object->subtype);
	$title = $object->title;
	if (!$title)
		$title = elgg_echo('untitled');

	$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$string = sprintf(elgg_echo("river:posted:generic"),$url) . " ";
	$string .= elgg_echo("{$subtype}:river:annotate") . " <a href=\"" . $object->getURL() . "\">" . $title . "</a>";

?>

<?php echo $string; ?>