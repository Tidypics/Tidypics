<?php

	$img_type = get_subtype_id('object', 'image');
	$query = "SELECT count(guid) as total from {$CONFIG->dbprefix}entities where subtype={$img_type}";
	$total = get_data_row($query);
	$num_images = $total->total;
	
	$img_type = get_subtype_id('object', 'album');
	$query = "SELECT count(guid) as total from {$CONFIG->dbprefix}entities where subtype={$img_type}";
	$total = get_data_row($query);
	$num_albums = $total->total;

	$num_comments_photos = count_annotations(0, 'object', 'image', 'generic_comment');
	$num_comments_albums = count_annotations(0, 'object', 'album', 'generic_comment');
	
	$num_views = count_annotations(0, 'object', 'image', 'tp_view');
	
	if (get_plugin_setting('tagging', 'tidypics') != "disabled")
		$num_tags = count_annotations(0, 'object', 'image', 'phototag');
?>
<br />
<h3>Overview</h3>
<p>
An image library is required by Tidypics to perform various manipulations: resizing on upload, watermarking, rotation, and cropping.
There are three image library options with Tidypics: PHP extension <a href="http://www.php.net/manual/en/book.image.php">GD</a>, 
<a href="http://www.imagemagick.org/">ImageMagick</a> called via a system call, and the PHP extension 
<a href="http://pecl.php.net/package/imagick/">imagick</a>. GD is the most common of the three on hosted servers but suffers 
from serious memory usage problems when resizing photos. If you have access to ImageMagick (whether through system calls or the
PHP extension), we recommend that you use that.
</p>
<h3>Testing ImageMagick Commandline</h3>
<p>
To use the ImageMagick executables, PHP must be configured to allow calls to exec(). You can check our 
<a href="<?php echo $CONFIG->wwwroot . 'mod/tidypics/pages/server_analysis.php'; ?>">server analysis page</a> to find out the 
configuration of your server. Next, you need to determine the path to ImageMagick on your server. Your hosting service should 
be able to provide this to you. You can test if the location is correct below. If successful, it should display the version of 
ImageMagick installed on your server.  
</p>
<br />
<p>
<?php echo elgg_echo('tidypics:settings:im_path'); ?><br />
<input name="im_location" type="text" />
<input type="submit" value="Submit" onclick="TestImageMagickLocation();" />
</p>
<div id="im_results"></div>

<script type="text/javascript">
function TestImageMagickLocation()
{
	var loc = $('input[name=im_location]').val();
	$("#im_results").html("");
	$.ajax({
		type: "GET",
		url: "<?php echo $CONFIG->wwwroot . 'mod/tidypics/actions/imtest.php'; ?>",
		data: {location: loc},
		cache: false,
		success: function(html){
			$("#im_results").html(html);
		}
	});
}
</script>