<?php

	/**
	 * Import a set of photos from Flickr
	 */

	// Load Elgg engine
	include_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php";
	$body = elgg_view_title( elgg_echo( 'flickr:importmanager' ));
	$body .= "<h2>" . elgg_echo( 'flickr:desc' ) . "</h2>";
	
	$viewer = get_loggedin_user();
	
	require_once dirname(dirname(dirname(__FILE__))) . "/lib/phpFlickr/phpFlickr.php";
	require_once( dirname(dirname(dirname(__FILE__)))) . "/lib/flickr.php";
	$f = new phpFlickr("26b2abba37182aca62fe0eb2c7782050");
	
	$viewer = get_loggedin_user();
	$flickr_username = get_metadata_byname( $viewer->guid, "flickr_username" );
	$flickr_id = get_metadata_byname( $viewer->guid, "flickr_id" );
	$album_id = get_metadata_byname( $viewer->guid, "flickr_album_id" );
	
	if( intval( $album_id->value ) <= 0 ) {
		register_error( sprintf( elgg_echo( 'flickr:errornoalbum' ), $album_id->value ));
		forward( "/mod/tidypics/pages/flickr/setup.php" );
	}
	
	$photosets = $f->photosets_getList( $flickr_id->value );
	foreach( $photosets["photoset"] as $photoset ) {
		$body .= "<div class='tidypics_album_images'>";
		$body .= "$photoset[title]<br />";
		
		$count = 0;
		$looper = 0;
		//create links to import photos 10 at a time
		while( $photoset["photos"] > $count ) {
			$looper++;
			$body .= " <a href='/mod/tidypics/actions/flickrImportPhotoset.php?set_id=$photoset[id]&page=$looper&album_id=$album_id->value'>$looper</a>";
			$count = $count + 10;			
		}
		$body .= "<br />$photoset[photos] images";
		$body .= "</div>";
//		echo "<pre>"; var_dump( $photoset ); echo "</pre>"; die;
	}

//	$body .= elgg_view("tidypics/forms/setupFlickr", array(), false, true );
	flickr_menu();
	page_draw( elgg_echo( 'flickr:importmanager' ), elgg_view_layout("two_column_left_sidebar", '', $body));
	
?>