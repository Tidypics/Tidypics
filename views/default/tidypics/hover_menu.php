<?php

	/**
	 * Elgg hoverover extender for tidypics
	 * 
	 */

?>

	<p class="user_menu_file <?php if(get_context() == 'photos') echo 'profile_select';?>">
		<a href="<?php echo $vars['url']; ?>pg/photos/owned/<?php echo $vars['entity']->username; ?>"><?php echo elgg_echo("albums"); ?></a>	
	</p>