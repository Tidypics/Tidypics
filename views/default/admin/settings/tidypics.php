<?php
/**
 * Admin page
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$tab = get_input('tab', 'settings');

echo elgg_view('navigation/tabs', array(
	'tabs' => array(
		array(
			'text' => elgg_echo('settings'),
			'href' => '/admin/settings/tidypics',
			'selected' => ($tab == 'settings'),
		),
		array(
			'text' => elgg_echo('tidypics:server_info'),
			'href' => '/admin/settings/tidypics?tab=server_info',
			'selected' => ($tab == 'server_info'),
		),
		array(
			'text' => elgg_echo('tidypics:settings:image_lib'),
			'href' => '/admin/settings/tidypics?tab=image_lib',
			'selected' => ($tab == 'image_lib'),
		),
		array(
			'text' => elgg_echo('tidypics:settings:thumbnail'),
			'href' => '/admin/settings/tidypics?tab=thumbnail',
			'selected' => ($tab == 'thumbnail'),
		),
		array(
			'text' => elgg_echo('tidypics:settings:help'),
			'href' => '/admin/settings/tidypics?tab=help',
			'selected' => ($tab == 'help'),
		),
	)
));

switch ($tab) {
	case 'server_info':
		echo elgg_view('admin/settings/tidypics/server_info');
		break;

	case 'image_lib':
		echo elgg_view('admin/settings/tidypics/image_lib');
		break;

	case 'thumbnail':
		echo elgg_view('admin/settings/tidypics/thumbnail');
		break;

	case 'help':
		echo elgg_view('admin/settings/tidypics/help');
		break;

	default:
	case 'settings':
		echo elgg_view('admin/settings/tidypics/settings');
		break;
}