<?php
/**
 * Setup the user's flickr username and store it
 */
require_once dirname(dirname(__FILE__)) . "/lib/phpFlickr/phpFlickr.php";
$f = new phpFlickr("26b2abba37182aca62fe0eb2c7782050");

$flickr_username = get_input( "flickr_username" );
$return_url = get_input( "return_url" );
$user = get_loggedin_user();

if( empty( $flickr_username )) {
	register_error( "You must enter a username" );
	forward( $return_url );
	die; //just in case
} else {
	$flickr_user = $f->people_findByUsername( $flickr_username );
	if( !empty( $flickr_user["id"] )) {
		create_metadata( $user->guid, "flickr_username", $flickr_username, "text", $user->guid, ACCESS_PUBLIC );
		create_metadata( $user->guid, "flickr_id", $flickr_user["id"], "text", $user->guid, ACCESS_PUBLIC );
		
		system_message( "Successfully saved Flickr username of $flickr_username" );
		system_message( "flickr user id: $flickr_user[id]" );
	} else {
		register_error( "Username $flickr_username not found on Flickr" );
	}
}

forward($_SERVER['HTTP_REFERER']);
//echo "<pre>"; var_dump( array($flickr_username, $return_url )); echo "</pre>";

?>