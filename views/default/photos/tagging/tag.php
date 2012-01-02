<?php
/**
 * Photo tag view
 *
 * @uses $vars['tag'] Tag object
 */

$coords = json_decode('{' . $vars['tag']->coords . '}');

$attributes = elgg_format_attributes(array(
	'class' => 'tidypics-tag',
	'data-x1' => $coords->x1,
	'data-y1' => $coords->y1,
	'data-width' => $coords->width,
	'data-height' => $coords->height,
));

//var_dump($vars['tag']);
//$text = "This is a something";

echo <<<HTML
<div $attributes>
</div>
HTML;
