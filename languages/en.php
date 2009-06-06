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
			'tidypics:enablephotos' => 'Enable Group Photo Albums',
			'tidypics:editprops' => 'Edit Image Properties',
			'tidypics:mostcommented' => 'Most commented images',
			'tidypics:mostcommentedthismonth' => 'Most commented this month',
			'tidypics:mostcommentedtoday' => 'Most commented today',
			'tidypics:mostviewed' => 'Most viewed images',
			'tidypics:mostvieweddashboard' => 'Most viewed dashboard',
			'tidypics:mostviewedthisyear' => 'Most viewed this year',
			'tidypics:mostviewedthismonth' => 'Most viewed this month',
			'tidypics:mostviewedlastmonth' => 'Most viewed last month',
			'tidypics:mostviewedtoday' => 'Most viewed today',
			'tidypics:recentlyviewed' => 'Recently viewed images',
			'tidypics:mostrecent' => 'Most recent images',
			'tidypics:yourmostviewed' => 'Your most viewed images',
			'tidypics:yourmostrecent' => 'Your most recent images',
			'tidypics:friendmostviewed' => "%s's most viewed images",
			'tidypics:friendmostrecent' => "%s's most recent images",
			'tidypics:highestrated' => "Highest Rated Images",
	
		//settings
			'tidypics:adminsettings' => 'Tidypics Settings',
			'tidypics:admin:instructions' => 'These are the core Tidypics settings. Change them for your setup and then click save.',
			'tidypics:settings:image_lib' => "Image Library: ",
			'tidypics:settings:download_link' => "Show download link",
			'tidypics:settings:tagging' => "Enable photo tagging",
			'tidypics:settings:exif' => "Show EXIF data",
			'tidypics:settings:grp_perm_override' => "Allow group members full access to group albums",
			'tidypics:settings:maxfilesize' => "Maximum image size in megabytes (MB):",
			'tidypics:settings:watermark' => "Enter text to appear in the watermark - ImageMagick must be selected for the image library",
			'tidypics:settings:im_path' => "Enter the path to your ImageMagick commands",
			'tidypics:settings:river_view' => "How many entries in river for each batch of uploaded images",
			'tidypics:settings:largesize' => "Primary image size",
			'tidypics:settings:smallsize' => "Album view image size",
			'tidypics:settings:thumbsize' => "Thumbnail image size",

		//actions
		
			'album:create' => "Create new album",
			'album:add' => "Add Photo Album",
			'album:addpix' => "Add photos to album",
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
			
		// tagging
			'tidypics:taginstruct' => 'Select area that you want to tag',
			'tidypics:finish_tagging' => 'Stop tagging',
			'tidypics:tagthisphoto' => 'Tag this photo',
			'tidypics:actiontag' => 'Tag',
			'tidypics:inthisphoto' => 'In this photo',
			'tidypics:phototagging:success' => 'Photo tag was successfully added',
			'tidypics:phototagging:error' => 'Unexpected error occurred during tagging',
		
		//widgets
		
			'album:widget' => "Photo Albums",
			'album:more' => "View all albums",
			'album:widget:description' => "Showcase your latest photo albums",
			'album:display:number' => "Number of albums to display",
			'album:num_albums' => "Number of albums to display",
			
		//  river
		
			//images
			'image:river:created' => "%s added %s to album %s",
			'image:river:item' => "an image",
			'image:river:annotate' => "a comment on the image",	
		
			//albums
			'album:river:created' => "%s created a new photo album: ",
			'album:river:item' => "an album",
			'album:river:annotate' => "a comment on the photo album",
			
		// notifications
			'tidypics:newalbum' => 'New photo album',
			
				
		//  Status messages
			
			'tidypics:upl_success' => "Your images uploaded successfully.",
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
			'tidypics:settings:save:ok' => 'Successfully saved the Tidypics plugin settings',
				
		//Error messages
				 
			'image:none' => "We could not find any images at the moment.",
			'tidypics:partialuploadfailure' => "There were errors uploading some of the images (%s of %s images).",
			'tidypics:completeuploadfailure' => "Upload of images failed.",
			'tidypics:exceedpostlimit' => "Too many large images - try to upload fewer or smaller images.",
			'tidypics:noimages' => "No images were selected.",
			'tidypics:image_mem' => "Image is too large - too many bytes",
			'tidypics:image_pixels' => "Image has too many pixels",
			'tidypics:unk_error' => "Unknown upload error",
			'tidypics:save_error' => "Unknown error saving the image on server",
			'tidypics:not_image' => "This is not a recognized image type",
			'image:deletefailed' => "Your image could not be deleted at this time.",
			'image:downloadfailed' => "Sorry; this image is not available at this time.",
			'tidypics:nosettings' => "Admin of this site has not set photo album settings.",
			
			'images:notedited' => "Not all images were successfully updated",
		 
			'album:none' => "No albums have been created yet.",
			'album:uploadfailed' => "Sorry; we could not save your album.",
			'album:deletefailed' => "Your album could not be deleted at this time.",
			'album:blank' => "Please give this album a title and description."
	);
					
	add_translation("en",$english);
?>