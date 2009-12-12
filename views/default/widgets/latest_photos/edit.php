<p>
<?php 
	echo elgg_echo("tidypics:widget:num_latest") . ": ";

	if($vars['entity']->num_display == '') $vars['entity']->num_display = 6;
	
?>
	<select name="params[num_display]">
		<option value="6" <?php if($vars['entity']->num_display == 6) echo "SELECTED"; ?>>6</option>
		<option value="9" <?php if($vars['entity']->num_display == 9) echo "SELECTED"; ?>>9</option>
		<option value="12" <?php if($vars['entity']->num_display == 12) echo "SELECTED"; ?>>12</option>
		<option value="15" <?php if($vars['entity']->num_display == 15) echo "SELECTED"; ?>>15</option>
		<option value="18" <?php if($vars['entity']->num_display == 18) echo "SELECTED"; ?>>18</option>
	</select>
</p>