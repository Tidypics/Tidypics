<?php
	/**
	* Elgg images edit/add page
	*  This form is used to:
	*	- create albums
	*	- edit albums
	*	- edit images
	*/
	
	//set stuff if we are editing existing album or image
		if (isset($vars['entity'])) {
			$title = sprintf(elgg_echo("album:edit"),$object->title);
			$action = "tidypics/editalbum";
			$title = $vars['entity']->title;
			$body = $vars['entity']->description;
			$tags = $vars['entity']->tags;
			$access_id = $vars['entity']->access_id;
			$subtype = $vars['subtype'];
						
		// if nothing is sent, create new, but only new albums are sent here
		// new images are sent to upload.php
		} else  {
			$title = elgg_echo("album:add");
			$action = "tidypics/addalbum";
			$tags = "";
			$title = "";
			$description = "";
		}
			
	//  in case we have some cached details
		if (isset($vars['albumtitle'])) {
			$title = $vars['albumtitle'];
			$body = $vars['albumbody'];
			$tags = $vars['albumtags'];
		}
        
		$container_guid = get_input('container_guid');
        if (!$container_guid) $container_guid = page_owner();
	
?>
	<form action="<?php echo $vars['url']; ?>action/<?php echo $action; ?>" method="post">
		<p>
			<label><?php echo elgg_echo('album:title'); ?></label>
			<?php  echo elgg_view("input/text", array("internalname" => "albumtitle", "value" => $title,));  ?>			
		</p>
<?php 		
		if($vars['subtype'] == 'album' || $action == "tidypics/addalbum")
		{
?>
		<p>
			<label><?php echo elgg_echo('album:desc'); ?></label>
			<?php  echo elgg_view("input/text",array("internalname" => "albumbody","value" => $body,)); ?>
		</p>
<?php
		} else {
?>
		<p>
			<label><?php echo elgg_echo('caption'); ?></label>
			<?php  echo elgg_view("input/text",array("internalname" => "albumbody","value" => $body,)); ?>		
		</p>
<?php
		} //End album/image selection
?>
		<p>
			<label><?php echo elgg_echo("tags"); ?></label>
			<?php  echo elgg_view("input/tags", array( "internalname" => "albumtags","value" => $tags,));  ?>
		</p>

	<?php
		
		if($vars['subtype'] == 'image')
		{		
			//if this is an image -- 
				//ALBUM COVER: ask to set image to album cover ::
				//ACCESS:  only existing images come  here  :: so acess should already be initially set by album
	
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
			<p>
				<label><?php echo sprintf(elgg_echo('access'), "$subtype"); ?></label>
				<?php echo elgg_view('input/accessRead', array('internalname' => 'access_id','value' => $access_id)); ?>		
			</p>
			<?php echo elgg_echo('image:access:note');?>
		<?php
		}
		else{
			//this is a new or existing album, both of which access is editable
		?>
			<p>
				<label><?php echo sprintf(elgg_echo('access'), "$subtype"); ?></label>
				<?php echo elgg_view('input/access', array('internalname' => 'access_id','value' => $access_id)); ?>			
			</p>		
		
		<?php
		}
	
		if (isset($vars['entity'])) {  
		?>
			<input type="hidden" name="albumpost" value="<?php echo $vars['entity']->getGUID(); ?>" />
		<?php 
		} 
		?>
		<input type="hidden" name="container_guid" value="<?php echo $container_guid; ?>" /> 		
		<p><input type="submit" name="submit" value="<?php echo elgg_echo('save'); ?>" /></p>
	</form>