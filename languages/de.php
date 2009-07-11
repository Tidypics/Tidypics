<?php
/**
* Elgg tidypics plugin german language pack
*
*
*/


	$german = array(

		// Menu items and titles

			'image' => "Bild",
			'images' => "Bilder",
			'caption' => "Beschreibung",
			'photos' => "Fotos",
			'images:upload' => "Fotos hochladen",
			'images:multiupload' => "Flash Multi Upload Tool",
			'images:multiupload:todo' => "Ein oder mehrere Bilder zum Hochladen wählen!",
			'album' => "Fotoalbum",
			'albums' => "Fotoalben",
			'album:slideshow' => "Diashow ansehen",
			'album:yours' => "Deine Fotoalben",
			'album:yours:friends' => "Fotoalben deiner Freunde",
			'album:user' => "%s's Fotoalben",
			'album:friends' => "%s's Fotoalben von Freunden",
			'album:all' => "Alle Fotoalben",
			'album:group' => "Gruppenalben",
			'item:object:image' => "Fotos",
			'item:object:album' => "Alben",
			'tidypics:enablephotos' => 'Schalte Gruppenalben frei',
			'tidypics:editprops' => 'Bearbeite Bildereigenschaften',
			'tidypics:mostcommented' => 'Am häufigsten kommentierte Bilder',
			'tidypics:mostcommentedthismonth' => 'Am häufigsten kommentierte Bilder des Monats',
			'tidypics:mostcommentedtoday' => 'Am häufigsten kommentierte Bilder des Tages',
			'tidypics:mostviewed' => 'Am häufigsten gezeigte Bilder',
			'tidypics:mostvieweddashboard' => 'Am häufigsten gezeigteS dashboard',
			'tidypics:mostviewedthisyear' => 'Am häufigsten gezeigte des Jahres',
			'tidypics:mostviewedthismonth' => 'Am häufigsten gezeigte des Monats',
			'tidypics:mostviewedlastmonth' => 'Am häufigsten gezeigte des letzten Monats',
			'tidypics:mostviewedtoday' => 'Am häufigsten gezeigte des Tages',
			'tidypics:recentlyviewed' => 'Zuletzt angezeigte Bilder',
			'tidypics:mostrecent' => 'Letzte Bilder',
			'tidypics:yourmostviewed' => 'Deine am häufigsten gezeigten Bilder',
			'tidypics:yourmostrecent' => 'Deine letzten Bilder',
			'tidypics:friendmostviewed' => "%s's m häufigsten gezeigten Bilder",
			'tidypics:friendmostrecent' => "%s's letzte Bilder",
			'tidypics:highestrated' => "Am höchsten bewertete Bilder",
			'tidypics:viewsbyowner' => "Aufrufe: %s von %s Mitglieder (du ausgeschlossen)",
			'tidypics:viewsbyothers' => "Aufrufe: %s (%s von dir)",
			'tidypics:administration' => 'Tidypics Administration',
			'tidypics:stats' => 'Statitik',

		//settings
			'tidypics:settings' => 'Einstellungen',
			'tidypics:admin:instructions' => 'These are the core Tidypics settings. Change them for your setup and then click save.',
			'tidypics:settings:image_lib' => "Image Library: ",
			'tidypics:settings:download_link' => "Show download link",
			'tidypics:settings:tagging' => "Enable photo tagging",
			'tidypics:settings:photo_ratings' => "Enable photo ratings (requires rate plugin of Miguel Montes or compatible)",
			'tidypics:settings:exif' => "Show EXIF data",
			'tidypics:settings:view_count' => "View counter",
			'tidypics:settings:grp_perm_override' => "Allow group members full access to group albums",
			'tidypics:settings:maxfilesize' => "Maximum image size in megabytes (MB):",
			'tidypics:settings:quota' => "User/Group Quota (MB) - 0 equals no quota",
			'tidypics:settings:watermark' => "Enter text to appear in the watermark - ImageMagick Cmdline must be selected for the image library",
			'tidypics:settings:im_path' => "Enter the path to your ImageMagick commands (with trailing slash)",
			'tidypics:settings:img_river_view' => "How many entries in river for each batch of uploaded images",
			'tidypics:settings:album_river_view' => "Show the album cover or a set of photos for new album",
			'tidypics:settings:largesize' => "Primary image size",
			'tidypics:settings:smallsize' => "Album view image size",
			'tidypics:settings:thumbsize' => "Thumbnail image size",


		//actions

			'album:create' => "Lege neues Album an",
			'album:add' => "Fotoalbum hinzufügen",
			'album:addpix' => "Fotos hinzufügen",
			'album:edit' => "Album bearbeiten",
			'album:delete' => "Album löschen",

			'image:edit' => "Bild bearbeiten",
			'image:delete' => "Bild löschen",
			'image:download' => "Bild herunterladen",

		//forms

			'album:title' => "Titel",
			'album:desc' => "Beschreibung",
			'album:tags' => "Stichwörter",
			'album:cover' => "Albumcover erstellen?",
			'tidypics:quota' => "Quota usage:",

		//views

			'image:total' => "Bilder im Album:",
			'image:by' => "Bild hinzugefügt von",
			'album:by' => "Album erstellt von:",
			'album:created:on' => "Erstellt",
			'image:none' => "Noch keine Bilder hinzugefügt.",
			'image:back' => "Vorheriges",
			'image:next' => "Nächstes",

		// tagging
			'tidypics:taginstruct' => 'Wähle den Bereich, den du taggen möchstest, aus',
			'tidypics:deltag_title' => 'Wähle zu löschende Tags',
			'tidypics:finish_tagging' => 'Stop tagging',
			'tidypics:tagthisphoto' => 'Tagge dieses Foto',
			'tidypics:deletetag' => 'Lösche Foto tag',
			'tidypics:actiontag' => 'Tag',
			'tidypics:actiondelete' => 'Löschen',
			'tidypics:actioncancel' => 'Abbrechen',
			'tidypics:inthisphoto' => 'in diesem Foto',
			'tidypics:usertag' => "Foto tagged mit Mitglied %s",
			'tidypics:phototagging:success' => 'Photo tag was successfully added',
			'tidypics:phototagging:error' => 'Unerwarteter Fehler aufgetreten beim taggen',
			'tidypics:deletetag:success' => 'Ausgewählte Tags wurden erfolgreich gelöscht',


		//rss
			'tidypics:posted' => 'posted a photo:',

		//widgets

			'album:widget' => "Fotoalben",
			'album:more' => "Alle Alben ansehen",
			'album:widget:description' => "Zeige Deine neuesten Fotoalben",
			'album:display:number' => "Anzahl der Alben, die angezeigt werden sollen",
			'album:num_albums' => "Anzahl der anzuzeigenden Alben",

		//river

			//images
			'image:river:created' => "%s hat ein Bild %s zum Album %s hinzugefügt",
			'image:river:item' => "ein Bild",
			'image:river:annotate' => "einen Kommentar zum Bild",

			//albums
			'album:river:created' => "%s hat ein neues Fotoalbum erstellt",
			'album:river:group' => "in der Gruppe",
			'album:river:item' => "ein Album",
			'album:river:annotate' => "einen Kommentar zum Fotoalbum",

		//notifications
			'tidypics:newalbum' => 'Neues Fotoalbum',


		//  Status messages
			'tidypics:upl_success' => "Deine Bilder wurden erfolgreich hochgeladen.",
			'image:saved' => "Dein Bild wurde gespeichert.",
			'images:saved' => "Alle Bilder wurden gespeichert.",
			'image:deleted' => "Dein Bild wurde gelöscht.",
			'image:delete:confirm' => "Willst du das Bild wirklich löschen?",

			'images:edited' => "Dein Bild wurde aktualisiert.",
			'album:edited' => "Dein Album wurde aktualisiert.",
			'album:saved' => "Dein Album wurde gespeichert.",
			'album:deleted' => "Dein Album wurde gelöscht.",
			'album:delete:confirm' => "Willst du das Album wirklich löschen?",
			'album:created' => "Ihr neues Album ist hergestellt worden.",
			'tidypics:settings:save:ok' => 'Tidypics plugin Einstellungen erfolgreich gespeichert',
			'tidypics:upgrade:success' => 'Upgrade von Tidypics erfolgreich',

		//Error messages

			'tidypics:partialuploadfailure' => "Es sind Fehler beim Hochladen einiger Bilder aufgetreten (%s von %s Bildern).",
			'tidypics:completeuploadfailure' => "Upload of images failed.",
			'tidypics:exceedpostlimit' => "Zuviel große Bilder - versuche weinger oder kleinere Bilder hochzuladen.",
			'tidypics:noimages' => "Keine Bilder ausgewählt.",
			'tidypics:image_mem' => "Bildgröße zu groß - zuviele Bytes",
			'tidypics:image_pixels' => "Bild hat zuviele Pixel",
			'tidypics:unk_error' => "Unbekannte upload Fehler",
			'tidypics:save_error' => "Unknown error saving the image on server",
			'tidypics:not_image' => "Bildtyp wurde nicht erkannt",
			'image:deletefailed' => "Dein Bild konnte nicht gelöscht werden.",
			'image:downloadfailed' => "Sorry; dieses Bild ist zur Zeit nicht vorhanden.",
			'tidypics:nosettings' => "Admin of this site has not set photo album settings.",
			'tidypics:exceed_quota' => "You have exceeded the quota set by the administrator",
			'images:notedited' => "Nicht alle Bilder konnten erfolgreich upgedated werden",

			'album:none' => "Es wurde kein Album .",
			'album:uploadfailed' => "Sorry; dein Album konnte nicht gespeichert werden.",
			'album:deletefailed' => "Dein Album konnte nicht gelöscht werden.",
			'album:blank' => "Bitte geib diesem Album einen Titel und eine Beschreibung.",

			'tidypics:upgrade:failed' => "Upgrade von Tidypics gescheitert",
	);

	add_translation("de",$german);
?>
