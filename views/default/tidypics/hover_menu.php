<?php

	/**
	 * Elgg hoverover extender for tidypics
	 * 
	 * @package ElggFile
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.com/
	 */

?>

	<p class="user_menu_file <?php if(get_context() == 'photos') echo 'profile_select';?>">
		<a href="<?php echo $vars['url']; ?>pg/photos/owned/<?php echo $vars['entity']->username; ?>"><?php echo elgg_echo("albums"); ?></a>	
	</p>