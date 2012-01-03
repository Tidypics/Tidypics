<?php
/**
 * Tidypics ajax upload form body
 *
 * @uses $vars['album']
 */

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
