<?php
/**
 * Tidypics admin stats page.
 */

$stats = array();

// number of images
$img_type = get_subtype_id('object', 'image');
$query = "SELECT count(guid) as total from {$CONFIG->dbprefix}entities where subtype={$img_type}";
$total = get_data_row($query);
$num_images = $total->total;
$stats['images'] = $total->total;

// number of albums
$img_type = get_subtype_id('object', 'album');
$query = "SELECT count(guid) as total from {$CONFIG->dbprefix}entities where subtype={$img_type}";
$total = get_data_row($query);
$num_albums = $total->total;
$stats['albums'] = $total->total;

$options = array(
	'count' => true,
	'type' => 'object',
	'subtype' => 'image',
	'annotation_name' => 'generic_comment'
);

// number of comments on photos
$stats['photo_comments'] = elgg_get_annotations($options);

// number of comments on albums
$options['subtype'] = 'album';
$stats['album_comments'] = elgg_get_annotations($options);

// number of views on images
$options['subtype'] = 'image';
$options['annotation_name'] = 'tp_view';
$stats['views'] = elgg_get_annotations($options);

// number of photo tags on images
if (elgg_get_plugin_setting('tagging', 'tidypics') != 'disabled') {
	$options['annotation_name'] = 'phototag';
	$stats['tags'] = elgg_get_annotations($options);
}

$content = '<table class="elgg-table-alt">';

foreach ($stats as $str => $value) {
	$str = elgg_echo("tidypics:stats:$str");
	$value = (int)$value;
	
	$content .= <<<HTML
	<tr>
		<td>$str:</td>
		<td>$value</td>
	</tr>
HTML;
}

$content .= '</table>';

echo elgg_view_module('inline', elgg_echo('tidypics:stats'), $content);