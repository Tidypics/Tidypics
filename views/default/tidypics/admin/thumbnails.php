<br />
<h3>Overview</h3>
<p>
This page allows you to create thumbnails for images when the thumbnail creation failed during upload. 
You may experience problems with thumbnail creation if your image library in not configured properly or
if there is not enough memory for the GD library to load and resize an image. If your users have 
experienced problems with thumbnail creation and you have modified your setup, you can try to redo the
thumbnails. Find the unique identifier of the photo (it is the number near the end of the url when viewing
a photo) and enter it below. 
</p>
<h3>Thumbnail Creation</h3>
<p>
<b><?php echo elgg_echo('tidypics:settings:im_id'); ?></b>:
<input name="image_id" type="text" />
<input type="submit" value="Submit" onclick="TestThumbnailCreation();" />
</p>
<div id="im_results"></div>
<script type="text/javascript">
function TestThumbnailCreation()
{
	var image_id = $('input[name=image_id]').val();
	$("#im_results").html("");
	$.ajax({
		type: "GET",
		url: "<?php echo $CONFIG->wwwroot . 'mod/tidypics/actions/create_thumbnails.php'; ?>",
		data: {guid: image_id},
		cache: false,
		success: function(html){
			$("#im_results").html(html);
		}
	});
}
</script>