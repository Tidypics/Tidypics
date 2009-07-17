<?php

/********************************************************************
 *
 *   Tidypics System Analysis Script
 *
 *   Helps admins configure their server
 *
 ********************************************************************/   

	include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	global $CONFIG;

	admin_gatekeeper();

	set_context('admin');

	$title = 'TidyPics Server Analysis'; 


	function tp_readable_size($bytes) 
	{
		if (strpos($bytes, 'M'))
			return $bytes . 'B';
		
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

	$disablefunc = explode(',', ini_get('disable_functions'));
	$exec_avail = "Disabled";
	if (is_callable('exec') && !in_array('exec',$disablefunc))
		$exec_avail = "Enabled";

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
			<td>ImageMagick PHP</td>
			<td><?php echo (extension_loaded('imagick')) ? 'Enabled' : 'Disabled'; ?></td>
			<td></td>
		</tr>
		<tr>
			<td>exec()</td>
			<td><?php echo $exec_avail; ?></td>
			<td>Required for ImageMagick command line</td>
		</tr>
		<tr>
			<td>Memory Available to PHP</td>
			<td><?php echo tp_readable_size(ini_get('memory_limit')); ?></td>
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
			<td>Max size of an uploaded image</td>
		</tr>
		<tr>
			<td>Max Post Size</td>
			<td><?php echo tp_readable_size(ini_get('post_max_size')); ?></td>
			<td>Max post size = sum of images + html form</td>
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
		<tr>
			<td>GD imagejpeg</td>
			<td><?php echo (is_callable('imagejpeg')) ? 'Enabled' : 'Disabled'; ?></td>
			<td></td>
		</tr>
		<tr>
			<td>GD imagepng</td>
			<td><?php echo (is_callable('imagepng')) ? 'Enabled' : 'Disabled'; ?></td>
			<td></td>
		</tr>
		<tr>
			<td>GD imagegif</td>
			<td><?php echo (is_callable('imagegif')) ? 'Enabled' : 'Disabled'; ?></td>
			<td></td>
		</tr>
		<tr>
			<td>EXIF</td>
			<td><?php echo (is_callable('exif_read_data')) ? 'Enabled' : 'Disabled'; ?></td>
			<td></td>
		</tr>
	</table>
	<div style="margin-top:20px;">
		<a href="<?php echo $CONFIG->url . "mod/tidypics/docs/configure_server.txt"; ?>">Server configuration doc</a>
	</div>
</div>
<?php

	$content = ob_get_clean();

	$body = elgg_view_layout('two_column_left_sidebar', '', $content);

	echo page_draw($title, $body);
?>