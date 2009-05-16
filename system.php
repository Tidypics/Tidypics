<?php

/********************************************************************
 *
 *   Tidypics System Analysis Script
 *
 *   Helps admins configure their server
 *
 ********************************************************************/   

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	admin_gatekeeper();

	set_context('admin');

	$title = 'TidyPics Server Analysis'; 

/*
$php_ok = (function_exists('version_compare') && version_compare(phpversion(), '4.3.0', '>='));
$xml_ok = extension_loaded('xml');
$pcre_ok = extension_loaded('pcre');
$curl_ok = function_exists('curl_exec');
$zlib_ok = extension_loaded('zlib');
$mbstring_ok = extension_loaded('mbstring');
$iconv_ok = extension_loaded('iconv');
*/
	ob_start();

	echo elgg_view_title($title);
?>
<div class="contentWrapper">

</div>
<?php

	$content = ob_get_clean();

	$body = elgg_view_layout('two_column_left_sidebar', '', $content);

	echo page_draw($title, $body);
?>