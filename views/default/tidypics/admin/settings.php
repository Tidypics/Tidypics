<?php
/**
 * Tidypics admin settings tab
 */

$form_body = elgg_view('forms/tidypics/admin/settings', $vars);

$server_analysis_link = elgg_view('output/url', array(
	'href' => "{$vars['url']}mod/tidypics/pages/server_analysis.php",
	'text' => elgg_echo('tidypics:settings:server:analysis'),
));

echo elgg_view('output/longtext', array('value' => elgg_echo('tidypics:admin:instructions')));

echo '<p>';
echo elgg_view('tidypics/admin/upgrade');
echo $server_analysis_link;
echo '</p>';

echo elgg_view('input/form', array(
	'body' => $form_body,
	'action' => $vars['url'] . 'action/tidypics/admin/settings',
));
