<?php
require_once( dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/lib/flickr.php";

$user = get_loggedin_user();
$flickr_username = get_metadata_byname( $user->guid, "flickr_username" );

$action = $vars['url'] . 'action/tidypics/flickrSetup';

$form_body = "<p>";
$form_body .= "Please enter your Flickr username here:<br /><input style='width: 20%;' type='text' name='flickr_username' value='$flickr_username->value' ' class='input-text' /><br />";
$form_body .= "<input type='hidden' name='return_url' value='$_SERVER[REQUEST_URI]' />";
$form_body .= elgg_view('input/submit', array('value' => elgg_echo("save")));

flickr_menu();

echo elgg_view('input/form', array('action' => $action, 'body' => $form_body));
?>