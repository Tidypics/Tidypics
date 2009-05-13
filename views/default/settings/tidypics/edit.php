<?php
	$image_lib = $vars['entity']->image_lib;
	if (!$image_lib) $image_lib = 'GD';
?>
<p>
	<?php echo elgg_echo('tidypics:image_lib'); ?>
	
	<?php
		echo elgg_view('input/pulldown', array(
			'internalname' => 'params[image_lib]',
			'options_values' => array(
				'GD' => 'GD',
				'ImageMagick' => 'ImageMagick',
			),
			'value' => $image_lib
		));
	?>
	<br />
	<?php
		$im_path = $vars['entity']->im_path;
		if(!$im_path) $im_path = "/usr/bin/";
	?>
	<?php echo elgg_echo('tidypics:settings:im_path'); ?>
	<?php echo elgg_view('input/text', array('internalname' => 'params[im_path]', 'value' => $im_path)); ?>
</p>

<?php
	$maxfilesize = $vars['entity']->maxfilesize;
	if (!$maxfilesize) $maxfilesize = (int) 10240; //set the default maximum file size to 10MB (1024KB * 10 = 10240KB = 10MB)
		
?>
<p>
	<?php echo elgg_echo('tidypics:settings:maxfilesize'); ?>
	
	<?php echo elgg_view('input/text', array('internalname' => 'params[maxfilesize]', 'value' => $maxfilesize)); ?>
</p>
<?php
	$watermark_text = $vars['entity']->watermark_text;
	if(!$watermark_text) $watermark_text = "";
?>
<p>
	<?php echo elgg_echo('tidypics:settings:watermark'); ?>
	<?php echo elgg_view('input/text', array('internalname' => 'params[watermark_text]', 'value' => $watermark_text)); ?>
</p>