<?php
	/**
	* Tidypics images edit/add form
	*  This form is used to:
	*	- create albums
	*	- edit albums
	*	- edit images
	*/

	//set stuff if we are editing existing album or image
	if (isset($vars['entity'])) {
		$action = "tidypics/edit";
		$title = $vars['entity']->title;
		$body = $vars['entity']->description;
		$tags = $vars['entity']->tags;
		$access_id = $vars['entity']->access_id;
		$subtype = $vars['subtype'];

	// if nothing is sent, create new, but only new albums are sent here
	// new images are sent to upload.php
	} else  {
		$action = "tidypics/addalbum";
		$tags = "";
		$title = "";
		$body = "";
		if (defined('ACCESS_DEFAULT'))
			$access_id = ACCESS_DEFAULT;
		else
			$access_id = 0;
		$subtype = 'album';
		
		$title = $_SESSION['tidypicstitle'];
		$body = $_SESSION['tidypicsbody'];
		$tags = $_SESSION['tidypicstags'];

		unset($_SESSION['tidypicstitle']); 
		unset($_SESSION['tidypicsbody']); 
		unset($_SESSION['tidypicstags']);
	}

	// group or individual 
	$container_guid = page_owner();

?>
<div class="contentWrapper">
	<form action="<?php echo $vars['url']; ?>action/<?php echo $action; ?>" method="post">
		<p>
			<label><?php echo elgg_echo('album:title'); ?></label>
			<?php  echo elgg_view("input/text", array("internalname" => "tidypicstitle", "value" => $title,));  ?>
		</p>
<?php
		if ($subtype == 'album') {
?>
		<p>
			<label><?php echo elgg_echo('album:desc'); ?></label>
			<?php  echo elgg_view("input/text",array("internalname" => "tidypicsbody","value" => $body,)); ?>
		</p>
<?php
		} else {
?>
		<p>
			<label><?php echo elgg_echo('caption'); ?></label>
			<?php  echo elgg_view("input/text",array("internalname" => "tidypicsbody","value" => $body,)); ?>
		</p>
<?php
		} 
?>
		<p>
			<label><?php echo elgg_echo("tags"); ?></label>
			<?php  echo elgg_view("input/tags", array( "internalname" => "tidypicstags","value" => $tags,));  ?>
		</p>

<?php
		if ($subtype == 'image') {
			// should this album be the cover for the album
			
			// try to determine if it is already the cover - the pass of this variable doesn't work - leave for next version
			$guid = $vars['entity']->guid;
			$container_guid = $vars['entity']->container_guid;
			$cover_guid = get_entity($container_guid)->cover;
			if($cover_guid == $vars['entity']->guid)
				$cover = 'yes';
			
?>
		<p>
			<label><?php echo elgg_echo("album:cover"); ?></label>
			<?php  echo elgg_view("input/cover_checkbox", array( "internalname" => "cover", "value" => $cover, 'options' => array(elgg_echo('album:cover:yes'))));  ?>
		</p>
<?php
		} else {
			// album so display access control
?>
			<p>
				<label><?php echo elgg_echo('access'); ?></label>
				<?php echo elgg_view('input/access', array('internalname' => 'access_id','value' => $access_id)); ?>
			</p>

<?php
		}
	
		if (isset($vars['entity'])) {  
?>
			<input type="hidden" name="guid" value="<?php echo $vars['entity']->getGUID(); ?>" />
<?php 
		} 
?>
		<input type="hidden" name="container_guid" value="<?php echo $container_guid; ?>" />
		<input type="hidden" name="subtype" value="<?php echo $subtype; ?>" />
		<p><input type="submit" name="submit" value="<?php echo elgg_echo('save'); ?>" /></p>
	</form>
</div>