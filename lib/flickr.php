<?php

function flickr_menu() {
	add_submenu_item( elgg_echo( 'flickr:menusetup' ), "/mod/tidypics/pages/flickr/setup.php");
	add_submenu_item( elgg_echo( 'flickr:menuimport' ), "/mod/tidypics/pages/flickr/importPhotosets.php" );
}
	
?>