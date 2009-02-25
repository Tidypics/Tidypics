<?php

	/**
	 * Elgg access level input
	 * this is a custom input that disables the given value, but passes the value discreetly
	 * we need this because using "disabled" inputs do not pass values and will store as default 0
	 * 
	 * @package Elgg
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.org/
	 * 
	 * @uses $vars['value'] The current value, if any
	 * @uses $vars['js'] Any Javascript to enter into the input tag
	 * @uses $vars['internalname'] The name of the input field
	 * 
	 */

	$class = $vars['class'];
	if (!$class) $class = "input-access";

		//default no array sent get all normal select values
		if (!is_array($vars['options']))
		{
			$vars['options'] = array();
			$vars['options'] = get_write_access_array();
		}
		
		//if sending custom select values via array
	if (is_array($vars['options']) && sizeof($vars['options']) > 0) 
	{	 
		
	/* my hacks (pay no attention please =D )
		//allow showing of group for write access
			if($vars['group_write']) $vars['options'] = trigger_plugin_hook('access:collections:write','user',array('user_id' => $_SESSION['guid'], 'site_id' => 0),$vars['options']);
	*/
		
		//developer check - to check the value being sent initially
		//echo 'given value: '.$vars['value'].'<br>';
		
		//if no value currently set - specify default
		if (empty($vars['value']) && $vars['value'] != '0') 
			$vars['value'] = 2;
					

		foreach($vars['options'] as $key => $option) {
			if ($key == $vars['value']) {
?>
			<input type="text" value="<?php echo htmlentities($option, null, 'UTF-8'); ?>" class="<?php echo $class ?>" DISABLED> 
			<input type="hidden" name="<?php echo $vars['internalname']; ?>" value="<?php echo $key ;?>" <?php if (isset($vars['js'])) echo $vars['js']; ?> class="<?php echo $class; ?>">

<?php
			}
		}


	}		

?>