<?php
	global $CONFIG;
	
	//this is for image uploads only. Image edits are handled by edit.php form
	
	$container_guid = get_input('container_guid');
	$access_id = get_entity($vars['album'])->access_id;

	$maxfilesize = (int) get_plugin_setting('maxfilesize','tidypics');
	if (!$maxfilesize)
		$maxfilesize = 5;

?>
<script language="javascript">
<!--

var state = 'none';

function showhide(layer_ref) {
	if (state == 'block') {
	state = 'none';
	}
	else {
	state = 'block';
	}
	if (document.all) { //IS IE 4 or 5 (or 6 beta)
	eval( "document.all." + layer_ref + ".style.display = state");
	}
	if (document.layers) { //IS NETSCAPE 4 or below
	document.layers[layer_ref].display = state;
	}
	if (document.getElementById &&!document.all) {
	hza = document.getElementById(layer_ref);
	hza.style.display = state;
	}
	return false;
}
//-->
</script>
<div class="contentWrapper">
<?php
	ob_start();
?>
	<p style="line-height:1.6em;">
		<label><?php echo elgg_echo("images:upload"); ?></label><br />
		<i><?php echo elgg_echo("tidypics:settings:maxfilesize") . ' ' . $maxfilesize; ?></i><br />
		<div align="center" class="tidypics_loader" id="tidypics_loader" name="tidypics_loader" style="display:none;"><center><img alt="..." border="0" src="<?php echo $vars['url'].'mod/tidypics/graphics/loader.gif' ?>" /></center></div>
	  <ol id="tidypics_image_upload_list">
<?php
		for($x = 0; $x < 10; $x++){
			echo '<li>' . elgg_view("input/file",array('internalname' => "upload_$x")) . "</li>\n";
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
			<input type="submit" value="<?php echo elgg_echo("save"); ?>" onclick="showhide('tidypics_loader');" />
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