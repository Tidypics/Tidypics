<?php
/**
 * view a gallery of photos or albums
 *
 */

$context = $vars['context'];
$offset = $vars['offset'];
$entities = $vars['entities'];
$limit = $vars['limit'];
$count = $vars['count'];
$baseurl = $vars['baseurl'];
$context = $vars['context'];
$viewtype = $vars['viewtype'];
$pagination = $vars['pagination'];
$fullview = $vars['fullview'];

$html = "";
$nav = "";

if (isset($vars['viewtypetoggle'])) {
	$viewtypetoggle = $vars['viewtypetoggle'];
} else {
	$viewtypetoggle = true;
}

if ($context == "search" && $count > 0 && $viewtypetoggle) {
	$nav .= elgg_view('navigation/viewtype', array(
		'baseurl' => $baseurl,
		'offset' => $offset,
		'count' => $count,
		'viewtype' => $viewtype,
	));
}

if ($pagination) {
	$nav .= elgg_view('navigation/pagination',array(
		'baseurl' => $baseurl,
		'offset' => $offset,
		'count' => $count,
		'limit' => $limit,
	));
}

$html .= $nav;
if (is_array($entities) && sizeof($entities) > 0) {
	foreach($entities as $entity) {
		$html .= elgg_view_entity($entity, $fullview);
	}
}

$html .= '<div class="clearfloat"></div>';

if ($count) {
	$html .= $nav;
}

echo $html;