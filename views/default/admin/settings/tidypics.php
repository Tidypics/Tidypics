<?php
/**
 * Admin page
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

echo elgg_view('output/longtext', array('value' => elgg_echo('tidypics:admin:instructions')));

echo elgg_view_form('photos/admin/settings');
