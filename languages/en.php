<?php

	$english = array(
		// hack for core bug
			'untitled' => "untitled",

		// Menu items and titles

			'image' => "Image",
			'images' => "Images",
			'caption' => "Caption",
			'photos' => "Photos",
			'images:upload' => "Upload Images",
			'images:multiupload' => "Flash Multi Upload Tool",
			'images:multiupload:todo' => "Choose one or more files for upload.",
			'album' => "Photo Album",
			'albums' => "Photo Albums",
			'album:slideshow' => "View slideshow",
			'album:yours' => "Your photo albums",
			'album:yours:friends' => "Your friends' photo albums",
			'album:user' => "%s's photo albums",
			'album:friends' => "%s's friends' photo albums",
			'album:all' => "All site photo albums",
			'album:group' => "Group albums",
			'item:object:image' => "Photos",
			'item:object:album' => "Albums",
			'tidypics:uploading:images' => "Please wait. Uploading images.",
			'tidypics:enablephotos' => 'Enable group photo albums',
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
			'tidypics:recentlycommented' => 'Recently commented images',
			'tidypics:mostrecent' => 'Most recent images',
			'tidypics:yourmostviewed' => 'Your most viewed images',
			'tidypics:yourmostrecent' => 'Your most recent images',
			'tidypics:friendmostviewed' => "%s's most viewed images",
			'tidypics:friendmostrecent' => "%s's most recent images",
			'tidypics:highestrated' => "Highest rated images",
			'tidypics:views' => "Views: %s",
			'tidypics:viewsbyowner' => "by %s users (not including you)",
			'tidypics:viewsbyothers' => "(%s by you)",
			'tidypics:administration' => 'Tidypics Administration',
			'tidypics:stats' => 'Stats',
			'flickr:setup' => 'Flickr Setup',
			'flickr:usernamesetup' => 'Please enter your Flickr username here:',
			'flickr:selectalbum' => 'Select album to import photos into',
			'flickr:albumdesc' => 'Album to import photos to:',
			'flickr:importmanager' => 'Photoset Import Manager',
			'flickr:desc' => 'Click on the set you wish to import into this site.<br />Copies of the photos will be made and stored on this site where they can be viewed and commented on.',
			'flickr:intro' => 'Flickr Integration allows you to import photos from your flickr account into this Elgg site. By entering your username and choosing an album to import into, you can begin the process. <br />When you have saved your username and album selection, click on the Import Flickr Photos link to the left to select which Flickr set you would like to import photos from.',
			'flickr:menusetup' => 'Flickr Setup',
			'flickr:menuimport' => 'Import Flickr Photos',
			
		//settings
			'tidypics:settings' => 'Settings',
			'tidypics:admin:instructions' => 'These are the core Tidypics settings. Change them for your setup and then click save.',
			'tidypics:settings:image_lib' => "Image Library",
			'tidypics:settings:thumbnail' => "Thumbnail Creation",
			'tidypics:settings:help' => "Help",
			'tidypics:settings:download_link' => "Show download link",
			'tidypics:settings:tagging' => "Enable photo tagging",
			'tidypics:settings:photo_ratings' => "Enable photo ratings (requires rate plugin of Miguel Montes or compatible)",
			'tidypics:settings:exif' => "Show EXIF data",
			'tidypics:settings:view_count' => "View counter",
			'tidypics:settings:grp_perm_override' => "Allow group members full access to group albums",
			'tidypics:settings:maxfilesize' => "Maximum image size in megabytes (MB):",
			'tidypics:settings:quota' => "User/Group Quota (MB) - 0 equals no quota",
			'tidypics:settings:watermark' => "Enter text to appear in the watermark - not for production sites yet",
			'tidypics:settings:im_path' => "Enter the path to your ImageMagick commands (with trailing slash)",
			'tidypics:settings:img_river_view' => "How many entries in river for each batch of uploaded images",
			'tidypics:settings:album_river_view' => "Show the album cover or a set of photos for new album",
			'tidypics:settings:largesize' => "Primary image size",
			'tidypics:settings:smallsize' => "Album view image size",
			'tidypics:settings:thumbsize' => "Thumbnail image size",
			'tidypics:settings:im_id' => "Image ID",
	
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
			'tidypics:quota' => "Quota usage:",

		//views

			'image:total' => "Images in album:",
			'image:by' => "Image added by",
			'album:by' => "Album created by",
			'album:created:on' => "Created",
			'image:none' => "No images have been added yet.",
			'image:back' => "Previous",
			'image:next' => "Next",

		// tagging
			'tidypics:taginstruct' => 'Select area that you want to tag',
			'tidypics:deltag_title' => 'Select tags to delete',
			'tidypics:finish_tagging' => 'Stop tagging',
			'tidypics:tagthisphoto' => 'Tag this photo',
			'tidypics:deletetag' => 'Delete a photo tag',
			'tidypics:actiontag' => 'Tag',
			'tidypics:actiondelete' => 'Delete',
			'tidypics:actioncancel' => 'Cancel',
			'tidypics:inthisphoto' => 'In this photo',
			'tidypics:usertag' => "Photos tagged with user %s",
			'tidypics:phototagging:success' => 'Photo tag was successfully added',
			'tidypics:phototagging:error' => 'Unexpected error occurred during tagging',
			'tidypics:deletetag:success' => 'Selected tags were successfully deleted',
			
			'tidypics:tag:subject' => "You have been tagged in a photo",
			'tidypics:tag:body' => "You have been tagged in the photo %s by %s.			
			
The photo can be viewed here: %s",


		//rss
			'tidypics:posted' => 'posted a photo:',

		//widgets

			'tidypics:widget:albums' => "Photo Albums",
			'tidypics:widget:album_descr' => "Showcase your photo albums",
			'tidypics:widget:num_albums' => "Number of albums to display",
			'tidypics:widget:latest' => "Latest Photos",
			'tidypics:widget:latest_descr' => "Display your latest photos",
			'tidypics:widget:num_latest' => "Number of images to display",
			'album:more' => "View all albums",

		//  river

			//images
			'image:river:created' => "%s added the photo %s to album %s",
			'image:river:item' => "an photo",
			'image:river:annotate' => "a comment on the photo",
			'image:river:tagged' => "was tagged in the photo",

			//albums
			'album:river:created' => "%s created a new photo album",
			'album:river:group' => "in the group",
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
			'tidypics:settings:save:ok' => 'Successfully saved the Tidypics plugin settings',

			'tidypics:upgrade:success' => 'Upgrade of Tidypics a success',
			
			'flickr:enterusername' => 'You must enter a username',
			'flickr:savedusername' => 'Successfully saved username of %s',
			'flickr:saveduserid' => 'Successfully saved userid of %s',
			'flickr:savedalbum' => 'Album saved - %s',

		//Error messages

			'tidypics:partialuploadfailure' => "There were errors uploading some of the images (%s of %s images).",
			'tidypics:completeuploadfailure' => "Upload of images failed.",
			'tidypics:exceedpostlimit' => "Too many large images - try to upload fewer or smaller images.",
			'tidypics:noimages' => "No images were selected.",
			'tidypics:image_mem' => "Image is too large - too many bytes",
			'tidypics:image_pixels' => "Image has too many pixels",
			'tidypics:unk_error' => "Unknown upload error",
			'tidypics:save_error' => "Unknown error saving the image on server",
			'tidypics:not_image' => "This is not a recognized image type",
			'tidypics:deletefailed' => "Sorry. Deletion failed.",
			'tidypics:deleted' => "Successful deletion.",
			'image:downloadfailed' => "Sorry; this image is not available at this time.",
			'tidypics:nosettings' => "Admin of this site has not set photo album settings.",
			'tidypics:exceed_quota' => "You have exceeded the quota set by the administrator",
			'images:notedited' => "Not all images were successfully updated",

			'album:none' => "No albums have been created yet.",
			'album:uploadfailed' => "Sorry; we could not save your album.",
			'album:deletefailed' => "Your album could not be deleted at this time.",
			'album:blank' => "Please give this album a title and description.",

			'tidypics:upgrade:failed' => "The upgrade of Tidypics failed",
			
			'flickr:errorusername' => 'Username %s not found on Flickr',
			'flickr:errorusername2' => 'You must enter a username',
			'flickr:errorimageimport' => 'This image has already been imported',
			'flickr:errornoalbum' => "No album selected.  Please choose and save an album: %s" 
	);

	add_translation("en",$english);
?>
