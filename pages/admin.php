<?php
/**
 * Tidypics Admin Page
 * @todo deprecated
 */

admin_gatekeeper();
set_context('admin');

$tab = get_input('tab', 'settings');

$body = elgg_view_title(elgg_echo('tidypics:administration'));

$body .= elgg_view("tidypics/admin/tidypics", array('tab' => $tab));

page_draw(elgg_echo('tidypics:administration'), elgg_view_layout("two_column_left_sidebar", '', $body));
