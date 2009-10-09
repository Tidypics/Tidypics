<?php

function flickr_menu() {
	add_submenu_item( "Flickr setup", "/mod/tidypics/pages/flickr/setup.php");
	add_submenu_item( "Import Flickr photos", "/mod/tidypics/pages/flickr/importPhotosets.php" );
}
	
?>