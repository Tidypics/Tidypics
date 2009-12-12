<?php
	$file_guid = $vars['file_guid'];
	$page_owner = page_owner_entity();

	$first_level_text = '';
	$first_level_link = $CONFIG->wwwroot . "pg/photos/owned/" . $page_owner->username;
	if (get_loggedin_userid() == $page_owner->guid)
		$first_level_text = elgg_echo('album:yours');
	else
		$first_level_text = sprintf(elgg_echo('album:user'), $page_owner->name);
?>
<a href="<?php echo $first_level_link; ?>"><?php echo $first_level_text; ?></a>
<?php
	$second_level_text = '';
	if (isset($vars['album'])) {
		$second_level_text = $vars['album']->title;
		$second_level_link = $vars['album']->getURL();
?>
>>  <a href="<?php echo $second_level_link; ?>"><?php echo $second_level_text; ?></a>
<?php
	}
?>
