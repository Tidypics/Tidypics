<?php
	global $CONFIG;
	
	//this is for image uploads only. Image edits are handled by edit.php form
	
	$container_guid = get_input('container_guid');
	$access_id = get_entity($vars['album'])->access_id;

	$maxfilesize = (int) get_plugin_setting('maxfilesize','tidypics');
	if (!$maxfilesize)
		$maxfilesize = 5;

?>
<div id="tidypics_ref"></div>
<div class="contentWrapper">
<?php
	ob_start();
?>
<p style="line-height:1.6em;">
	<label><?php echo elgg_echo("images:upload"); ?></label><br />
	<i><?php echo elgg_echo("tidypics:settings:maxfilesize") . ' ' . $maxfilesize; ?></i><br />
	<div id="delete_tag_menu">
		Uploading images<br />
		<div style="margin:20px 0px 20px 80px;"><img alt="..." border="0" src="<?php echo $vars['url'].'mod/tidypics/graphics/loader.gif' ?>" /></div>
	</div>
	<ol id="tidypics_image_upload_list">
<?php
		for ($x = 0; $x < 10; $x++) {
			echo '<li>' . elgg_view("input/file",array('internalname' => "upload_$x")) . '</li>';
		} 
?>
	</ol>
</p>
<p>
<?php
		if ($container_guid)
			echo '<input type="hidden" name="container_guid" value="' . $container_guid . '" />';
		if ($access_id)
			echo '<input type="hidden" name="access_id" value="' . $access_id . '" />';
?>
	<input type="submit" value="<?php echo elgg_echo("save"); ?>" onclick="displayProgress();" />
</p>
<?php
	$form_body = ob_get_clean();
	
	echo elgg_view('input/form', array(	'action' => "{$vars['url']}action/tidypics/upload", 
										'body' => $form_body, 
										'internalid' => 'tidypicsUpload',
										'enctype' => 'multipart/form-data',
										'method' => 'post',));
?>
</div>
<script type="text/javascript">

	function displayProgress()
	{
		offsetY = 60;
		offsetX = 120;
		
		divWidth = $('#tidypics_ref').width();
		imgOffset = $('#tidypics_ref').offset();
		imgWidth  = $('#tidypics_ref').width();
		
		_top = imgOffset.top + offsetY;
		_left = imgOffset.left + offsetX;

		$('#delete_tag_menu').show().css({
			"top": _top + "px",
			"left": _left + "px"
		});
		
	}
</script>