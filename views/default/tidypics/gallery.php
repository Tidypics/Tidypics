<?php
/**
 * view a gallery of photos or albums
 *
 */

if ($vars['context'] == 'widget') {
	$num_wide = 3;
} else {
	// four albums across
	$num_wide = 4;
}

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
	$counter = 0;
	foreach($entities as $entity) {
		if ($counter % $num_wide == 0) {
			$html .= "<div class=\"tidypics_line_break\"></div>";
		}
		$html .= elgg_view_entity($entity, $fullview);
		$counter++;
	}
}

$html .= '<div class="clearfloat"></div>';

if ($count) {
	$html .= $nav;
}

echo $html;