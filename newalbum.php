<?php

	/**
	 * Elgg blog add entry page
	 * 
	 * @package ElggBlog
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.com/
	 */

	// Load Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		gatekeeper();
		
	// Get the current page's owner	
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}
				
		$area2 = elgg_view_title(elgg_echo('album:add'));
		$area2 .= elgg_view("tidypics/forms/edit");
		
	// Display page
		page_draw(elgg_echo('album:add'),elgg_view_layout("two_column_left_sidebar", $area1, $area2, $area3 ));

		
?>