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


	function tp_readable_size($bytes) 
	{
		$size = $bytes / 1024;
		if ($size < 1024) {
			$size = number_format($size, 2);
			$size .= ' KB';
		} else {
			$size = $size / 1024;
			if($size < 1024) {
				$size = number_format($size, 2);
				$size .= ' MB';
			} else {
				$size = $size / 1024;
				$size = number_format($size, 2);
				$size .= ' GB';
			} 
		}
	return $size;
	}


	ob_start();

	echo elgg_view_title($title);
?>
<div class="contentWrapper">
	<table width="100%">
		<tr>
			<td>PHP version</td>
			<td><?php echo phpversion(); ?></td>
			<td></td>
		</tr>
		<tr>
			<td>GD</td>
			<td><?php echo (extension_loaded('gd')) ? 'Enabled' : 'Disabled'; ?></td>
			<td>Elgg requires the GD extension to be loaded</td>
		</tr>
		<tr>
			<td>ImageMagick</td>
			<td><?php echo (extension_loaded('imagick')) ? 'Enabled' : 'Disabled'; ?></td>
			<td></td>
		</tr>
		<tr>
			<td>Memory Available to PHP</td>
			<td><?php echo ini_get('memory_limit'); ?>B</td>
			<td>Change memory_limit to increase</td>
		</tr>
		<tr>
			<td>Memory Used to Load This Page</td>
			<td><?php if (function_exists('memory_get_peak_usage')) echo tp_readable_size(memory_get_peak_usage()); ?></td>
			<td>This is approximately the minimum per page</td>
		</tr>
		<tr>
			<td>Max File Upload Size</td>
			<td><?php echo tp_readable_size(ini_get('upload_max_filesize')); ?></td>
			<td>Max size of the sum of images uploaded at once</td>
		</tr>
		<tr>
			<td>Max Post Size</td>
			<td><?php echo tp_readable_size(ini_get('post_max_size')); ?></td>
			<td>Max post size - should be larger than above</td>
		</tr>
		<tr>
			<td>Max Input Time</td>
			<td><?php echo ini_get('max_input_time'); ?> s</td>
			<td>Time script waits for upload to finish</td>
		</tr>
		<tr>
			<td>Max Execution Time</td>
			<td><?php echo ini_get('max_execution_time'); ?> s</td>
			<td>Max time a script will run</td>
		</tr>
	</table>
</div>
<?php

	$content = ob_get_clean();

	$body = elgg_view_layout('two_column_left_sidebar', '', $content);

	echo page_draw($title, $body);
?>