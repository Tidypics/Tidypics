<?php
/**
 * Widget settings for newest albums
 */

// set default value
if (!isset($vars['entity']->num_display)) {
	$vars['entity']->num_display = 5;
}

$params = array(
	'name' => 'params[num_display]',
	'value' => $vars['entity']->num_display,
	'options' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 15, 20),
);
$dropdown = elgg_view('input/dropdown', $params);

?>
<div>
	<?php echo elgg_echo('tidypics:widget:num_albums'); ?>:
	<?php echo $dropdown; ?>
</div>
