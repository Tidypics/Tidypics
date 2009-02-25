<?php
	/**
	 * Elgg file browser download action.
	 * 
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.com/
	 */
	 
	 global $CONFIG;

	$file_guid = (int) get_input("file_guid");
	$file = get_entity($file_guid);
		
	if ($file)
	{	
		$filename = $file->originalfilename;
		$mime = $file->mimetype;
		
		header("Content-type: $mime");
		if (strpos($mime, "image/")!==false)
			header("Content-Disposition: inline; filename=\"$filename\"");
		else
			header("Content-Disposition: attachment; filename=\"$filename\"");

			
		$readfile = new ElggFile($file_guid);
		$readfile->owner_guid = $file->owner_guid;
		//$readfile->setFilename($filename);
			
		$contents = $readfile->grabFile();
		
		if (empty($contents))
			echo file_get_contents(dirname(dirname(__FILE__)) . "/graphics/icons/general.jpg" );
		else
			echo $contents;
		
		exit;
	}
	else
		register_error(elgg_echo("image:downloadfailed"));

?>