<?php

extend_view('metatags', 'tidypics/js/uploader');

$container_guid = get_input('container_guid');
$album = get_entity($vars['album']);
$access_id = $album->access_id;

$ts = time();
$token = generate_action_token($ts);


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

<p>Instructions here for uploading images using Ajax/Flash</p>
<input id="upload_file" name="upload_file" type="file" />
<a href="javascript:$('#upload_file').uploadifyUpload();">Upload Files</a> |
<a href="javascript:$('#upload_file').uploadifyClearQueue();">Clear Queue</a>

</div>

<script type="text/javascript">
$("#upload_file").uploadify({
	'uploader'     : '<?php echo $vars['url']; ?>mod/tidypics/vendors/uploadify/uploadify.swf',
	'script'       : '<?php echo $vars['url']; ?>action/tidypics/ajax_upload/',
	'scriptData'   : {
						'album_guid'   : '<?php echo $album->guid; ?>',
						'__elgg_token' : '<?php echo $token; ?>',
						'__elgg_ts'    : '<?php echo $ts; ?>',
						'Elgg'   : '<?php echo session_id(); ?>'
					 },
	'fileDataName' : 'Image',
	'cancelImg'  : '/_images/cancel.png',
	'multi'      : true,
	'auto'       : false,
	'fileDesc'   : '<?php echo elgg_echo('tidypics:upload:filedesc'); ?>',
	'fileExt'    : '*.jpg;*.jpeg;*.png;*.gif'
});
</script>

