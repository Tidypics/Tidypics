<?php
/**
 *
 */

$site_url = elgg_get_site_url();
$upload_endpoint_url = "{$site_url}action/tidypics/ajax_upload/";
$upload_complete_url = "{$site_url}action/tidypics/ajax_upload_complete/";

?>

elgg.provide('elgg.tidypics.uploading');

elgg.tidypics.uploading.init = function() {
	$("#uploadify").uploadify({
		'uploader'     : '<?php echo $site_url; ?>mod/tidypics/vendors/uploadify/uploadify.swf',
		'script'       : '<?php echo $upload_endpoint_url; ?>',
		'fileDataName' : 'Image',
		'multi'        : true,
		'auto'         : false,
		'wmode'        : 'transparent',
		'buttonImg'    : " ",
		'height'       : 20,
		'width'        : 130
	});
}

elgg.register_hook_handler('init', 'system', elgg.tidypics.uploading.init);