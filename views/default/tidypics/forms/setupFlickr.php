<?php
require_once( dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/lib/flickr.php";

$user = get_loggedin_user();
$flickr_username = get_metadata_byname( $user->guid, "flickr_username" );
$flickr_album_id = get_metadata_byname( $user->guid, "flickr_album_id" );

$action = $vars['url'] . 'action/tidypics/flickrSetup';

$form_body = "<p>";
$form_body .= "Please enter your Flickr username here: <input style='width: 20%;' type='text' name='flickr_username' value='$flickr_username->value' ' class='input-text' /> <br />";
$form_body .= "<input type='hidden' name='return_url' value='$_SERVER[REQUEST_URI]' />";

$albums = get_entities( "object", "album", $user->guid );
$options = array( 0 => "Select album" );
foreach( $albums as $album ) {
	$title = $album->title;
	switch( $album->access_id ) {
		case ACCESS_PRIVATE:
			$title .= " (private)";
			break;
		case ACCESS_PUBLIC:
			$title .= " (public)";
			break;
		default:
			$title .= " (not sure)";
			break;
	}
	$options[$album->guid] = $title;
}

$form_body .= "<br />Album to import photos to: ";
$form_body .= elgg_view('input/pulldown', array('internalname' => 'album_id',
												'options_values' => $options,
												'value' => $flickr_album_id->value ));
$form_body .= "<br />";
$form_body .= elgg_view('input/submit', array('value' => elgg_echo("save")));

flickr_menu();

echo elgg_view('input/form', array('action' => $action, 'body' => $form_body));
?>