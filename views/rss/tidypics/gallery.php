<?php
	/**
	 * Tidypics Listing RSS View
	 */

$context = $vars['context'];
$entities = $vars['entities'];
$count = $vars['count'];
$baseurl = $vars['baseurl'];


if (is_array($entities) && sizeof($entities) > 0) {
	foreach($entities as $entity) {
		echo elgg_view_entity($entity);
	}
}

?>