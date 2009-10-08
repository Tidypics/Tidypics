<?php
require_once dirname(dirname(dirname(__FILE__))) . "/lib/phpFlickr/phpFlickr.php";
$f = new phpFlickr("26b2abba37182aca62fe0eb2c7782050");

// Load Elgg engine
include_once dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php";
	
$username = get_input('username');
if( !empty( $username )) {
	$temp_user = get_user_by_username( $username );
} else {
	$temp_user = get_loggedin_user();
}
$flickr_username = get_metadata_byname( $temp_user->guid, "flickr_username" );
if( empty( $flickr_username )) {
	register_error( "No Flickr username set");
	echo "<pre>No flickr username set: $temp_user->guid"; die;
	forward( "/" );
	die;
}
$flickr_user = $f->people_findByUsername( $flickr_username->value );

// Get the friendly URL of the user's photos
$photos_url = $f->urls_getUserPhotos( $flickr_user["id"] );

if( !empty( $flickr_user )) {
	$recent = $f->people_getPublicPhotos( $flickr_user['id'], NULL, NULL, 5 );
} else {
	echo "user not found"; die;
}
//echo "<pre>"; var_dump( $recent ); echo "</pre>";

//echo "<pre>"; var_dump( $user ); echo "</pre>";
$body = elgg_view_title( "Flickr photos for $flickr_user[username]" );

$count = 0;
foreach ($recent['photos']['photo'] as $photo) {
	
	$photo_info = $f->photos_getInfo( $photo["id"], $photo["secret"] );
	$body .= "<div class='tidypics_album_images'>";
	$body .= "$photo_info[title]<br />Views: $photo_info[views]<br />";
	$body .= "<a href=$photos_url$photo[id]>";
	$body .= "<img border='0' alt='$photo[title]' ".
		"src=" . $f->buildPhotoURL($photo, "Square") . ">";
	$body .= "</a>";

	$tag_count = 0;
	$body .= "<br /><div style='font-size: 8px;'>Tags:<br />";
	foreach( $photo_info["tags"]["tag"] as $tag ) {
		if( $tag_count ) $body .= ", ";
		$body .= "$tag[_content]";
		$tag_count++;
	}
	
	$body .= "</div></div>";
	$count++;
}
page_draw( "Flickr photos for $flickr_user[username]", elgg_view_layout("two_column_left_sidebar", '', $body));

?>