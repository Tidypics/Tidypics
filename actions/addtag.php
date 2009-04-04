<?php
	/**
	 * Tidypics Add Tag
	 * 
	 */

	// Make sure we're logged in (send us to the front page if not)
	if (!isloggedin()) forward();

	forward($_SERVER['HTTP_REFERER']);

?>