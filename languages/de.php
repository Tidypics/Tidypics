<?php
	/**
	 * Elgg tidypics plugin language pack
	 * 
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.com/
     *
     *  FIXED problem for german letters umlaute äöü and ÄÖÜ     Importand! (File is stored in UTF-8 Without BOM)
	 */

	$german = array(
			
		// Menu items and titles
			 
			'image' => "Bild",
			'images' => "Bilder",
			'caption' => "Untertitel",
			'photos' => "Photos",
			'images:upload' => "Bilder hochladen",
			'album' => "Fotoalbum",
			'albums' => "Fotoalben",
			'album:yours' => "Deine Fotoalben",
			'album:yours:friends' => "Fotoalben von Freunden",
			'album:user' => "Fotoalben von %s",
			'album:friends' => "Fotoalben von Freunden von %s",
			'album:all' => "Alle Fotoalben",
			'album:group' => "Alben der Gruppe",
			'item:object:image' => "Photos",
			'item:object:album' => "Alben",
			'tidypics:settings:maxfilesize' => "Maximale Dateigröße in den Kilobytes (KB):",
	
		//actions
		
			'album:create' => "Neues Album",
			'album:add' => "Fotoalbum hinzufügen",
			'album:addpix' => "Fotos hinzufügen",
			'album:edit' => "Album bearbeiten",
			'album:delete' => "Album löschen",

			'image:edit' => "Bild bearbeiten",
			'image:delete' => "Bild löschen",
			'image:download' => "Download Bild",
		
		//forms
		
			'album:title' => "Titel",
			'album:desc' => "Beschreibung",
			'album:tags' => "Stichwörter",
			'album:cover' => "Albumcover erstellen?",
			'album:cover:yes' => "Ja",
			'image:access:note' => "(Zugriffsberechtigung wird vom Album übernommen)",
			
		//views 
		
			'image:total' => "Bilder im Album:",
			'image:by' => "Bild hinzugefügt von",
			'album:by' => "Album erstellt von:",
			'album:created:on' => "Verursacht",
			'image:none' => "Noch keine Bilder hinzugefügt.",
			'image:back' => "Zurück",
			'image:next' => "Weiter",
		
		//widgets
		
			'album:widget' => "Fotoalben",
			'album:more' => "Alle Alben ansehen",
			'album:widget:description' => "Zeige Deine neuesten Fotoalben",
			'album:display:number' => "Anzahl der Alben, die angezeigt werden sollen",
			'album:num_albums' => "Anzahl der anzuzeigenden Alben",
			
		//  river
		
			//images
			'image:river:created' => "%s hat hochgeladen:",
			'image:river:item' => "ein Bild",
			'image:river:annotate' => "%s kommentierte",
		
			//albums
			'album:river:created' => "%s erstellte",
			'album:river:item' => "ein Album",
			'album:river:annotate' => "%s kommentierte",
				
		//  Status messages
			
			'image:saved' => "Dein Bild wurde gespeichert.",
			'images:saved' => "Alle Bilder wurden gespeichert.",
			'image:deleted' => "Dein Bild wurde gelöscht.",
			'image:delete:confirm' => "Willst Du das Bild wirklich löschen?",
			
			'images:edited' => "Dein Bild wurde aktualisiert.",
			'album:edited' => "Dein Album wurde aktualisiert.",
			'album:saved' => "Dein Album wurde gespeichert.",
			'album:deleted' => "Dein Album wurde gelöscht.",
			'album:delete:confirm' => "Willst Du das Album wirklich löschen?",
			'album:created' => "Ihr neues Album ist hergestellt worden.",
			'tidypics:status:processing' => "Warten Sie bitte, während wir verarbeiten Ihre Abbildung....",
				
		//Error messages
				 
			'image:none' => "Kein Bilder gefunden.",
			'image:uploadfailed' => "Dateien konnten nicht hochgeladen werden:",
			'image:deletefailed' => "Bild konnte nicht gelöscht werden.",
			'image:downloadfailed' => "Dieses Bild ist nicht diesmal vorhanden.",
			
			'image:notimage' => 'Wir akzeptieren nur jpeg, gif, und png Dateien der erlaubten Dateigröße an.',
			'images:notedited' => 'Nicht alle Bilder konnten hochgeladen werden',
		 
			'album:none' => "Keine Alben gefunden.",
			'album:uploadfailed' => "Sorry; Dein Album konnte nicht gespeichert werden.",
			'album:deletefailed' => "Dein Album konnte nicht gelöscht werden.",
			'album:blank' => "Geben Sie diesem Album einen Titel und eine Beschreibung bitte."
	);
					
	add_translation("de",$german);
?>
