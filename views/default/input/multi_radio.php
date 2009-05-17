<?php

	/**
	 * Multi radio input
	 * This is for selection of cover image
	 * 
	 * 
	 * @uses $vars['value'] The current value, if any
	 * @uses $vars['js'] Any Javascript to enter into the input tag
	 * @uses $vars['internalname'] The name of the input field
	 * @uses $vars['options'] An array of strings representing the options for the radio field
	 * 
	 */

	$class = $vars['class'];
	if (!$class) $class = "input-checkboxes";

    foreach($vars['options'] as $label => $option) {

	    if ($vars['set'] != $vars['value']) {
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
        echo "<label><input type=\"radio\" $disabled {$vars['js']} name=\"{$vars['internalname']}\" {$selected} value=\"".htmlentities($vars['value'], null, 'UTF-8')."\" {$selected} class=\"$class\" />{$label}</label><br />";
    }

?> 