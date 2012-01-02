<?php
/**
 * Photo tag view
 *
 * @uses $vars['tag'] Tag object
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$coords = json_decode('{' . $vars['tag']->coords . '}');

$attributes = elgg_format_attributes(array(
	'class' => 'tidypics-tag',
	'data-x1' => $coords->x1,
	'data-y1' => $coords->y1,
	'data-width' => $coords->width,
	'data-height' => $coords->height,
));

if ($vars['tag']->type == 'user') {
	$user = get_entity($vars['tag']->value);
	$label = elgg_view('output/url', array(
		'text' => $user->name,
		'href' => $user->getURL(),
	));
} else {
	$label = $vars['tag']->value;
}

echo <<<HTML
<div class="tidypics-tag-wrapper">
	<div $attributes></div>
	<div class="elgg-module-popup tidypics-tag-label">$label</div>
</div>
HTML;
