<?php
/**
 * Admin page
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

if (tidypics_is_upgrade_available()) {
	echo '<div class="elgg-admin-notices">';
	echo '<p>';
	echo elgg_view('output/url', array(
		'text' => elgg_echo('tidypics:upgrade'),
		'href' => 'action/photos/admin/upgrade',
		'is_action' => true,
	));
	echo '</p>';
	echo '</div>';
}

echo elgg_view('output/longtext', array('value' => elgg_echo('tidypics:admin:instructions')));

echo elgg_view_form('photos/admin/settings');
