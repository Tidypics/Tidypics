<?php

	/**
	 * Elgg custom checkbox input used to define an album cover 
	 * @ forms/edit.php
	 * i made custom check box because the default checkboxes allows for more than one box.
	 * it handles the checkboxes via arrays, but i only need one and i did not want to use time figuring it all out
	 * simple and sweet , one checkbox.
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
	 * @uses $vars['options'] An array of strings representing the options for the checkbox field
	 * 
	 */

	$class = $vars['class'];
	if (!$class) $class = "input-checkboxes";

    foreach($vars['options'] as $label => $option) {

	    if ($option != $vars['value']) {
	        $selected = "";
	    } else {
			$selected = "checked = \"checked\"";
	    }

        $labelint = (int) $label;
        if ("{$label}" == "{$labelint}") {
        	$label = $option;
        }
        
        $disabled = "";
        if ($vars['disabled']) $disabled = ' disabled="yes" '; 
        echo "<label><input type=\"checkbox\" $disabled {$vars['js']} name=\"{$vars['internalname']}\" {$selected} value=\"".htmlentities($option, null, 'UTF-8')."\" {$selected} class=\"$class\" />{$label}</label><br />";
    }

?> 