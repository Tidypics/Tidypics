<?php
/**
* Elgg tidypics plugin german language pack
* Beta Version 0.8.4
*
*/


	$german = array(
		// hack for core bug
			'untitled' => "Unbenannt",

		// Menu items and titles

			'image' => "Bild",
			'images' => "Bilder",
			'caption' => "Beschreibung",
			'photos' => "Fotos",
			'images:upload' => "Fotos hochladen",
			'images:multiupload' => "Flash Multi-Upload Tool",
			'images:multiupload:todo' => "Ein oder mehrere Bilder zum Hochladen wählen!",
			'album' => "Fotoalbum",
			'albums' => "Fotoalben",
			'album:slideshow' => "Diashow ansehen",
			'album:yours' => "Deine Fotoalben",
			'album:yours:friends' => "Fotoalben deiner Freunde",
			'album:user' => "%s's Fotoalben",
			'album:friends' => "Fotoalben von %s's Freunden",
			'album:all' => "Alle Fotoalben",
			'album:group' => "Gruppen-Alben",
			'item:object:image' => "Fotos",
			'item:object:album' => "Alben",
			'tidypics:uploading:images' => "Die Bilder werden hochgeladen",
			'tidypics:enablephotos' => 'Schalte Gruppenalben frei',
			'tidypics:editprops' => 'Bild bearbeiten',
			'tidypics:mostcommented' => 'meist kommentierte',
			'tidypics:mostcommentedthismonth' => 'Meist kommentierte des Monats',
			'tidypics:mostcommentedtoday' => 'Meist kommentierte des Tages',
			'tidypics:mostviewed' => 'Meist gesehene Bilder',
			'tidypics:mostvieweddashboard' => 'Meist gesehene dashboard',
			'tidypics:mostviewedthisyear' => 'Meist gesehene des Jahres',
			'tidypics:mostviewedthismonth' => 'Meist gesehene des Monats',
			'tidypics:mostviewedlastmonth' => 'Meist gesehen im letzten Monat',
			'tidypics:mostviewedtoday' => 'Am häufigsten gezeigte des Tages',
			'tidypics:recentlyviewed' => 'Zuletzt angezeigt',
            'tidypics:recentlycommented' => 'Zuletzt kommentiert',
			'tidypics:mostrecent' => 'Community neue Bilder',
			'tidypics:yourmostviewed' => 'Deine meist gesehene',
			'tidypics:yourmostrecent' => 'Zuletzt hochgeladen',
			'tidypics:friendmostviewed' => "%s's meist gesehene",
			'tidypics:friendmostrecent' => "Zuletzt hochgeladen von %s",
			'tidypics:highestrated' => "Am höchsten bewertet",
			'tidypics:views' => "Zugriffe: %s",
			'tidypics:viewsbyowner' => "Zugriffe: %s von %s Mitglieder (du ausgeschlossen)",
			'tidypics:viewsbyothers' => "Zugriffe: %s (%s deine)",
			'tidypics:administration' => 'Tidypics Administration',
			'tidypics:stats' => 'Statitik',

		//settings
			'tidypics:settings' => 'Einstellungen',
			'tidypics:admin:instructions' => 'Das sind die Tidypics Einstellungen',

			'tidypics:settings:image_lib' => "Image Library: ",
			'tidypics:settings:thumbnail' => "Thumbnail Creation",			
			'tidypics:settings:download_link' => "Zeige Download-Link",
			'tidypics:settings:tagging' => "Erlaube Foto-Links",
			'tidypics:settings:photo_ratings' => "Erlaube Foto Bewertungen (benötigt rate plugin of Miguel Montes oder passendes)",
			'tidypics:settings:exif' => "Zeige EXIF data",
			'tidypics:settings:view_count' => "Zeige Zähler",
			'tidypics:settings:grp_perm_override' => "Erlaube den Gruppen-Mitgliedern unbeschränkten zugagn zur verwaltung von Gruppen-Alben",
			'tidypics:settings:maxfilesize' => "Maximale Bildgröße in Megabytes (MB):",
			'tidypics:settings:quota' => "Benutzer/Gruppen Speicherplatz in (MB) (0 = Kein Speicherplatz)",
			'tidypics:settings:watermark' => "Gib den Text für den Wasserzeichen ein - ImageMagick Cmdline muss ausgewählt sein für die Bildbibliothek",

			'tidypics:settings:im_path' => "Gib den Pfad zu ImageMagick Befehle (mit abschließendem Slasch)",
			'tidypics:settings:img_river_view' => "Wie viele Einträge in der aktivitäten Liste beim Upload von mehreren Bildern",
			'tidypics:settings:album_river_view' => "Zeige Albumcover oder ein Set von Fotos für neuen Album",
			'tidypics:settings:largesize' => "Bild-Größe",
			'tidypics:settings:smallsize' => "Album-Tumbnail Bild-Größe",
			'tidypics:settings:thumbsize' => "Thumbnail Bild-Größe",
            'tidypics:settings:im_id' => "Bild ID",


		//actions

			'album:create' => "Album hinzufügen",
			'album:add' => "Neues Album hinzufügen",
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
			'album:cover' => "Das bild als Albumcover nutzen",
			'tidypics:quota' => "Speicherplatz:",

		//views

			'image:total' => "Bilder im Album:",
			'image:by' => "Bild hinzugefügt von",
			'album:by' => "Album erstellt von:",
			'album:created:on' => "Erstellt",
			'image:none' => "Noch keine Bilder hinzugefügt.",
			'image:back' => "Vorheriges",
			'image:next' => "Nächstes",

		// tagging
			'tidypics:taginstruct' => 'Wähle ein Bereich auf dem Foto den du Verlinken willst',
			'tidypics:deltag_title' => 'Wähle zu löschende Links',
			'tidypics:finish_tagging' => 'Abbrechen',
			'tidypics:tagthisphoto' => 'Link zum Foto hinzufügen',
			'tidypics:deletetag' => 'Lösche Foto-Link',
			'tidypics:actiontag' => 'Link',
			'tidypics:actiondelete' => 'Löschen',
			'tidypics:actioncancel' => 'Abbrechen',
			'tidypics:inthisphoto' => 'Links in dem Foto',
			'tidypics:usertag' => "Foto verlinkt mit Mitglied %s",
			'tidypics:phototagging:success' => 'Foto-Link erfolgreich hinzugefügt',
			'tidypics:phototagging:error' => 'Unerwarteter Fehler beim verlinken',
			'tidypics:deletetag:success' => 'Ausgewählte Links wurden erfolgreich gelöscht',

			'tidypics:tag:subject' => "Du wurdest in einem Foto verlinkt",
			'tidypics:tag:body' => "Du wurdest in diesem Foto verlinkt %s von %s.
			
Das Foto kanns du hier sehen: %s",


		//rss
			'tidypics:posted' => 'Das Bild eingestellt:',

		//widgets

			'tidypics:widget:albums' => "Fotoalben",
			'tidypics:widget:album_descr' => "Zeige neuste Alben",
			'tidypics:widget:num_albums' => "Anzahl der Alben",
			'tidypics:widget:latest' => "Neuste Bilder",
			'tidypics:widget:latest_descr' => "Zeige neuste Bilder",
			'tidypics:widget:num_latest' => "Anzahl der Bilder",
			'album:more' => "Alle Alben ansehen",

		//river

			//images
			'image:river:created' => "%s hat ein Bild %s zum Album %s hinzugefügt",
			'image:river:item' => "ein Bild",
			'image:river:annotate' => "einen Kommentar zum Bild",
			'image:river:tagged' => "war im Foto verlinkt",

			//albums
			'album:river:created' => "%s hat ein neues Album erstellt",
			'album:river:group' => "in der Gruppe",
			'album:river:item' => "ein Album",
			'album:river:annotate' => "einen Kommentar zum Album",

		//notifications
			'tidypics:newalbum' => 'Neues Fotoalbum',



			//  Status messages
			'tidypics:upl_success' => "Die Bilder sind erfolgreich hochgeladen",
			'image:saved' => "Das Bild wurde gespeichert",
			'images:saved' => "Alle Bilder sind gespeichert",
			'image:deleted' => "Das Bild wurde gelöscht",
			'image:delete:confirm' => "Willst du das Bild wirklich löschen?",

			'images:edited' => "Das Bild wurde aktualisiert",
			'album:edited' => "Das Album wurde aktualisiert",
			'album:saved' => "Das Album wurde gespeichert",
			'album:deleted' => "Das Album wurde gelöscht",
			'album:delete:confirm' => "Willst du das Album wirklich löschen?",
			'album:created' => "Dein neues Album ist erstellt",
			'tidypics:settings:save:ok' => 'Tidypics Einstellungen erfolgreich gespeichert',











			'tidypics:upgrade:success' => 'Upgrade von Tidypics erfolgreich',

		//Error messages

			'tidypics:partialuploadfailure' => "Es sind Fehler beim Hochladen einiger Bilder aufgetreten (%s von %s Bildern)",
			'tidypics:completeuploadfailure' => "Bilder-Upload fehlgeschlagen",
			'tidypics:exceedpostlimit' => "Zuviele große Bilder auf einmal - versuche weniger oder kleinere Bilder hochzuladen",

			'tidypics:noimages' => "Keine Bilder zum Upload ausgewählt",
			'tidypics:image_mem' => "Das Bild ist zu groß",
			'tidypics:image_pixels' => "Das Bild hat zuviele Pixel",
			'tidypics:unk_error' => "Unbekannte Fehler beim Upload ",
			'tidypics:save_error' => "Unbekanntes Fehler beim speichern des Bildes auf dem Server",
			'tidypics:not_image' => "Das Bild-Typ wurde nicht erkannt",
			'image:deletefailed' => "Dein Bild konnte nicht gelöscht werden",
			'image:downloadfailed' => "Fehler: Das Bild ist zur Zeit nicht verfügbar",


			'tidypics:nosettings' => "Admin dieser Seite hat keine Einstellungen für Fotoalben vorgenommen",
			'tidypics:exceed_quota' => "Dir zugewiesener Speicherplatz ist ausgeschöpft!",

			'images:notedited' => "Nicht alle Bilder konnten erfolgreich upgedated werden",

			'album:none' => "Bis jetzt keine Alben erstellt",

			'album:uploadfailed' => "Dein Album konnte nicht gespeichert werden",
			'album:deletefailed' => "Dein Album konnte nicht gelöscht werden",
			'album:blank' => "Bitte gib diesem Album einen Titel und eine Beschreibung",

			
			
			'tidypics:upgrade:failed' => "Upgrade von Tidypics gescheitert",
	);

	add_translation("de",$german);
?>
