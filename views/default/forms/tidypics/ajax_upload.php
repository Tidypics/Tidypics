<?php
/**
 * Tidypics ajax upload form body
 *
 * @uses $vars['album']
 */

elgg_extend_view('metatags', 'tidypics/js/uploader');

$album = $vars['album'];

$ts = time();
$token = generate_action_token($ts);
$batch = time();
$tidypics_token = md5(session_id() . get_site_secret() . $ts . get_loggedin_user()->salt);

$basic_uploader_url = current_page_url() . '/basic';
$upload_endpoint_url = "{$vars['url']}action/tidypics/ajax_upload/";
$upload_complete_url = "{$vars['url']}action/tidypics/ajax_upload_complete/";

$maxfilesize = (float) get_plugin_setting('maxfilesize','tidypics');
if (!$maxfilesize) {
	$maxfilesize = 5;
}

$quota = get_plugin_setting('quota','tidypics');
if ($quota) {
	$image_repo_size_md = get_metadata_byname($album->container_guid, "image_repo_size");
	$image_repo_size = (int)$image_repo_size_md->value;
	$image_repo_size = $image_repo_size / 1024 / 1024;
	$quote_percentage = round(100 * ($image_repo_size / $quota));
	// for small quotas, so one decimal place
	if ($quota < 10) {
		$image_repo_size = sprintf('%.1f', $image_repo_size);
	} else {
		$image_repo_size = round($image_repo_size);
	}
	if ($image_repo_size > $quota) {
		$image_repo_size = $quota;
	}
}

?>

<div class="contentWrapper">

	<p><?php echo sprintf(elgg_echo('tidypics:uploader:instructs'), $basic_uploader_url); ?></p>

	<ul id="tidypics_uploader_steps">
		<li>
	<div id="tidypics_uploader">
		<a id="tidypics_choose_button" href="<?php echo $basic_uploader_url; ?>">
			1. <?php echo elgg_echo('tidypics:uploader:choose'); ?>
		</a>
		<div id="tidypics_flash_uploader">
			<input type="file" id="uploadify" name="uploadify" />
		</div>
	</div>
		</li>
		<li>
			<a id="tidypics_upload_button" class="tidypics_disable" href="javascript:$('#uploadify').uploadifyUpload();">
				2. <?php echo elgg_echo('tidypics:uploader:upload'); ?>
			</a>
		</li>
		<li>
			<a id="tidypics_describe_button" class="tidypics_disable" href="<?php echo $vars['url']; ?>pg/photos/batch/<?php echo $batch; ?>">
				3. <?php echo elgg_echo('tidypics:uploader:describe'); ?>
			</a>
		</li>
	</ul>
</div>

<script type="text/javascript">

$("#uploadify").uploadify({
	'uploader'     : '<?php echo $vars['url']; ?>mod/tidypics/vendors/uploadify/uploadify.swf',
	'script'       : '<?php echo $upload_endpoint_url; ?>',
	'scriptData'   : {
						'album_guid'     : '<?php echo $album->guid; ?>',
						'user_guid'      : '<?php echo get_loggedin_userid(); ?>',
						'__elgg_token'   : '<?php echo $token; ?>',
						'__elgg_ts'      : '<?php echo $ts; ?>',
						'Elgg'           : '<?php echo session_id(); ?>',
						'tidypics_token' : '<?php echo $tidypics_token; ?>',
						'batch'          : '<?php echo $batch; ?>'
					 },
	'fileDataName' : 'Image',
	'cancelImg'    : '<?php echo $vars['url']; ?>_graphics/icon_customise_remove.gif',
	'multi'        : true,
	'auto'         : false,
	'wmode'        : 'transparent',
	'buttonImg'    : " ",
	'height'       : 20,
	'width'        : 130,
	'onEmbedFlash' : function(event) {
		$("#" + event.id).hover(
			function(){
				$("#tidypics_choose_button").addClass('tidypics_choose_button_hover');
			},
			function(){
				$("#tidypics_choose_button").removeClass('tidypics_choose_button_hover');
			}
		);
	},
	'onSelectOnce'  : function() {
		$("#tidypics_upload_button").removeClass('tidypics_disable');
	},
	'onAllComplete' : function() {
		$("#tidypics_choose_button").addClass('tidypics_disable');
		$("#tidypics_upload_button").addClass('tidypics_disable');
		$("#tidypics_choose_button").attr("href", "javascript:void(0)");
		$("#tidypics_upload_button").attr("href", "javascript:void(0)");

		$("#tidypics_describe_button").removeClass('tidypics_disable');
		$.post(
			'<?php echo $upload_complete_url; ?>',
			{ 
				album_guid   : '<?php echo $album->guid; ?>',
				__elgg_token : '<?php echo $token; ?>',
				__elgg_ts    : '<?php echo $ts; ?>',
				batch        : '<?php echo $batch; ?>'
			}
		);
	},
	'onComplete'    : function(event, queueID, fileObj, response) {
		// check for errors here
		if (response != 'success') {
			$("#uploadify" + queueID + " .percentage").text(" - " + response);
			$("#uploadify" + queueID).addClass('uploadifyError');
		}
		$("#uploadify" + queueID + " > .cancel").remove();
		return false;
	},
	'onCancel'      : function(event, queueID, fileObj, data) {
		if (data.fileCount == 0) {
			$("#tidypics_upload_button").addClass('tidypics_disable');
		}
	}

});
</script>
