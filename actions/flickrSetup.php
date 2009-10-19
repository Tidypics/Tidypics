<?php
/**
 * Setup the user's flickr username and store it
 */
require_once dirname(dirname(__FILE__)) . "/lib/phpFlickr/phpFlickr.php";
$f = new phpFlickr("26b2abba37182aca62fe0eb2c7782050");

$flickr_username = get_input( "flickr_username" );
$album_id = get_input( "album_id" );
$return_url = get_input( "return_url" );
$user = get_loggedin_user();

if( empty( $flickr_username )) {
	register_error( elgg_echo( 'flickr:enterusername' ));
	forward( $return_url );
	die; //just in case
} else {
	$flickr_user = $f->people_findByUsername( $flickr_username );
	if( !empty( $flickr_user["id"] )) {
		create_metadata( $user->guid, "flickr_username", $flickr_username, "text", $user->guid, ACCESS_PUBLIC );
		create_metadata( $user->guid, "flickr_id", $flickr_user["id"], "text", $user->guid, ACCESS_PUBLIC );
		if( $album_id ) {
			create_metadata( $user->guid, "flickr_album_id", $album_id, "text", $user->guid, ACCESS_PUBLIC );
			$album = get_entity( $album_id );
		}
		
		system_message( sprintf( elgg_echo( 'flickr:savedusername' ), $flickr_username ));
		system_message( sprintf( elgg_echo( 'flickr:saveduserid' ), $flickr_user["id"] ));
		system_message( sprintf( elgg_echo( 'flickr:savedalbum' ), $album->title ));
	} else {
		register_error( sprintf( elgg_echo( 'flickr:errorusername' ), $flickr_username ));
	}
}

forward($_SERVER['HTTP_REFERER']);
//echo "<pre>"; var_dump( array($flickr_username, $return_url )); echo "</pre>";

?>