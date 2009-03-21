<?php

	$english = array(
			
		// Menu items and titles
			 
			'image' => "Image",
			'images' => "Images",
			'caption' => "Caption",		
			'photos' => "Photos",
			'images:upload' => "Upload Images",
			'album' => "Photo Album",
			'albums' => "Photo Albums",
			'album:yours' => "Your photo albums",
			'album:yours:friends' => "Friends' photo albums",
			'album:user' => "%s's photo albums",
			'album:friends' => "%s's friends' photo albums",
			'album:all' => "All site photo albums",
			'album:group' => "Group albums",
			'item:object:image' => "Photos",
			'item:object:album' => "Albums",
			'tidypics:settings:maxfilesize' => "Maximum file size in kilo bytes (KB):",
	
		//actions
		
			'album:create' => "Create new album",
			'album:add' => "Add Photo Album",
			'album:addpix' => "Add photos",
			'album:edit' => "Edit album",		
			'album:delete' => "Delete album",

			'image:edit' => "Edit image",
			'image:delete' => "Delete image",
			'image:download' => "Download image",
		
		//forms
		
			'album:title' => "Title",
			'album:desc' => "Description",
			'album:tags' => "Tags",
			'album:cover' => "Make image album cover?",
			'album:cover:yes' => "Yes",
			'image:access:note' => "(view access is inherited from the album)",
			
		//views 
		
			'image:total' => "Images in album:",
			'image:by' => "Image added by",
			'album:by' => "Album created by",
			'album:created:on' => "Created",
			'image:none' => "No images have been added yet.",
			'image:back' => "Back",
			'image:next' => "Next",
		
		//widgets
		
			'album:widget' => "Photo Albums",
			'album:more' => "View all albums",
			'album:widget:description' => "Showcase your latest photo albums",
			'album:display:number' => "Number of albums to display",
			'album:num_albums' => "Number of albums to display",
			
		//  river
		
			//images
			'image:river:created' => "%s uploaded",
			'image:river:item' => "an image",
			'image:river:annotate' => "%s commented on",	
		
			//albums
			'album:river:created' => "%s created",
			'album:river:item' => "an album",
			'album:river:annotate' => "%s commented on",				
				
		//  Status messages
			
			'image:saved' => "Your image was successfully saved.",
			'images:saved' => "All images were successfully saved.",
			'image:deleted' => "Your image was successfully deleted.",			
			'image:delete:confirm' => "Are you sure you want to delete this image?",
			
			'images:edited' => "Your images were successfully updated.",
			'album:edited' => "Your album was successfully updated.",
			'album:saved' => "Your album was successfully saved.",
			'album:deleted' => "Your album was successfully deleted.",	
			'album:delete:confirm' => "Are you sure you want to delete this album?",
			'album:created' => "Your new album has been created.",
			'tidypics:status:processing' => "Please wait while we process your picture....",
				
		//Error messages
				 
			'image:none' => "We could not find any images at the moment.",
			'image:uploadfailed' => "Files not uploaded:",
			'image:deletefailed' => "Your image could not be deleted at this time.",
			'image:downloadfailed' => "Sorry; this image is not available at this time.",
			
			'image:notimage' => "We only accept jpeg, gif, or png images of the allowed file size.",
			'images:notedited' => "Not all images were successfully updated",
		 
			'album:none' => "No albums have been created yet.",
			'album:uploadfailed' => "Sorry; we could not save your album.",
			'album:deletefailed' => "Your album could not be deleted at this time.",
			'album:blank' => "Please give this album a title and description."
	);
					
	add_translation("en",$english);
?>