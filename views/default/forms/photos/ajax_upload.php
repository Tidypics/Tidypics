<?php
/**
 * Tidypics ajax upload form body
 *
 * @uses $vars['entity']
 */

$album = $vars['entity'];

$ts = time();
$batch = time();
$tidypics_token = md5(session_id() . get_site_secret() . $ts . elgg_get_logged_in_user_entity()->salt);
$basic_uploader_url = current_page_url() . '/basic';

$maxfilesize = (float) elgg_get_plugin_setting('maxfilesize', 'tidypics');
if (!$maxfilesize) {
	$maxfilesize = 5;
}

$quota = elgg_get_plugin_setting('quota', 'tidypics');
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

<p><?php echo elgg_echo('tidypics:uploader:instructs', array($basic_uploader_url)); ?></p>

<ul id="tidypics-uploader-steps">
	<li class="mbm">
		<div id="tidypics-uploader">
			<a id="tidypics-choose-button" href="<?php echo $basic_uploader_url; ?>">
				1. <?php echo elgg_echo('tidypics:uploader:choose'); ?>
			</a>
			<div id="tidypics-flash-uploader">
				<input type="file" id="uploadify" name="uploadify" class="hidden" />
				<input type="hidden" name="album_guid" value="<?php echo $album->getGUID(); ?>" />
				<input type="hidden" name="batch" value="<?php echo $batch; ?>" />
				<input type="hidden" name="tidypics_token" value="<?php echo $tidypics_token; ?>" />
				<input type="hidden" name="user_guid" value="<?php echo elgg_get_logged_in_user_guid(); ?>" />
				<input type="hidden" name="Elgg" value="<?php echo session_id(); ?>" />
			</div>
		</div>
	</li>
	<li class="mbm">
		<a id="tidypics-upload-button" class="tidypics-disable" href="#">
			2. <?php echo elgg_echo('tidypics:uploader:upload'); ?>
		</a>
	</li>
	<li class="mbm">
		<a id="tidypics-describe-button" class="tidypics-disable" href="#">
			3. <?php echo elgg_echo('tidypics:uploader:describe'); ?>
		</a>
	</li>
</ul>
