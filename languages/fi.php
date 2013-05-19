<?php

$finnish = array(
		// hack for core bug
			'untitled' => "nimetön",

		// Menu items and titles
			'image' => "Kuva",
			'images' => "Kuvat",
			'caption' => "Kuvaus",
			'photos' => "Kuvat",
			'album' => "Kuva-albumi",
			'albums' => "Kuva-albumit",
			'tidypics:disabled' => 'Ei käytössä',
			'tidypics:enabled' => 'Käytössä',
			'admin:settings:photos' => 'Tidypics',

			'photos:add' => "Luo uusi albumi",
			'images:upload' => "Lisää kuvia",

			'album:slideshow' => "Diaesitys",
			'album:yours' => "Omat kuva-albumisi",
			'album:yours:friends' => "Ystäviesi kuva-albumit",
			'album:user' => "Käyttäjän %s kuva-albumit",
			'album:friends' => "Ystäviesi kuva-albumit",
			'album:all' => "Kaikki sivuston kuva-albumit",
			'photos:group' => "Ryhmän kuvat",
			'item:object:image' => "Kuvat",
			'item:object:album' => "Albumit",
			'tidypics:uploading:images' => "Odota, kuvia ladataan.",
			'tidypics:enablephotos' => 'Ota käyttöön ryhmän kuva-albumit',
			'tidypics:editprops' => 'Muokkaa kuvan tietoja',
			'tidypics:mostcommented' => 'Kommentoiduimmat kuvat',
			'tidypics:mostcommentedthismonth' => 'Kuukauden kommentoiduimmat kuvat',
			'tidypics:mostcommentedtoday' => 'Tämän päivän kommentoiduimmat kuvat',
			'tidypics:mostviewed' => 'Katsotuimmat kuvat',
			'tidypics:mostvieweddashboard' => 'Katsotuimmat kuvat',
			'tidypics:mostviewedthisyear' => 'Katsotuimmat kuvat tänä vuonna',
			'tidypics:mostviewedthismonth' => 'Katsotuimmat kuvat tässä kuussa',
			'tidypics:mostviewedlastmonth' => 'Katsotuimmat kuvat viime kuussa',
			'tidypics:mostviewedtoday' => 'Katsotuimmat tänään',
			'tidypics:recentlyviewed' => 'Viimeksi katsotut kuvat',
			'tidypics:recentlycommented' => 'Viimeksi kommentoidut kuvat',
			'tidypics:mostrecent' => 'Uusimmat kuvat',
			'tidypics:yourmostviewed' => 'Katsotuimmat kuvasi',
			'tidypics:yourmostrecent' => 'Uusimmat kuvasi',
			'tidypics:friendmostviewed' => "Käyttäjän %s katsotuimmat kuvat",
			'tidypics:friendmostrecent' => "Käyttäjän %s uusimmat kuvat",
			'tidypics:highestrated' => "Parhaiten arvostellut kuvat",
			'tidypics:views' => "%s katselua",
			'tidypics:viewsbyowner' => "%s käyttäjältä (poislukien itsesi)",
			'tidypics:viewsbyothers' => "(%s sinulta)",
			'tidypics:administration' => 'Tidypics Hallinta',
			'tidypics:stats' => 'Tilastot',
			'tidypics:nophotosingroup' => 'Tällä ryhmällä ei ole vielä kuvia',
			'tidypics:upgrade' => 'Päivitä',
			'tidypics:sort' => 'Järjestele albumi %s',
			'tidypics:none' => 'Ei kuva-albumeita',
			
		//settings
			'tidypics:settings' => 'Asetukset',
			'tidypics:settings:main' => 'Pääasetukset',
			'tidypics:settings:image_lib' => "Kuvakirjasto",
			'tidypics:settings:thumbnail' => "Esikatselukuvien luonti",
			'tidypics:settings:help' => "Ohje",
			'tidypics:settings:download_link' => "Näytä latauslinkki",
			'tidypics:settings:tagging' => "Ota käyttöön kuvien merkitseminen",
			'tidypics:settings:photo_ratings' => "Ota käyttöön kuvien arvosteleminen (vaatii yhteensopivan arvointiliitännäisen)",
			'tidypics:settings:exif' => "Näytä EXIF data",
			'tidypics:settings:view_count' => "Näytä katselumäärät",
			'tidypics:settings:uploader' => "Käytä Flash-lataajaa",
			'tidypics:settings:grp_perm_override' => "Salli ryhmien jäsenille täysi oikeus ryhmien albumeihin",
			'tidypics:settings:maxfilesize' => "Suurin sallitty kuvakoko megabitteinä (MB):",
			'tidypics:settings:quota' => "Käyttäjän tilakiintiö (MB) - 0 = ei kiintiötä",
			'tidypics:settings:watermark' => "Lisää vesileimassa käytettävä teksti",
			'tidypics:settings:im_path' => "Syötä polku ImageMagick-komentoihin",
			'tidypics:settings:img_river_view' => "Kuinka monta kuvaa näytetään aktiviteettisyöttessa kutakin lisättyä kuvaerää kohden",
			'tidypics:settings:album_river_view' => "Näytä albumin kansi tai joukko kuvia",
			'tidypics:settings:largesize' => "Kuvan peruskoko",
			'tidypics:settings:smallsize' => "Albuminäkymän kuvakoko",
			'tidypics:settings:tinysize' => "Esikatselukuvien koko",
			'tidypics:settings:sizes:instructs' => 'Saatat joutua muokkaamaan css-määrityksiä, josta muutat oletuskokoja',
			'tidypics:settings:im_id' => "Kuvan ID",
			'tidypics:settings:heading:img_lib' => "Kuvakirjaston asetukset",
			'tidypics:settings:heading:main' => "Pääasetukset",
			'tidypics:settings:heading:river' => "Aktiviteettisyötteen asetukset",
			'tidypics:settings:heading:sizes' => "Esikatselukuvan koko",
			'tidypics:settings:heading:groups' => "Ryhmien asetukset",
			'tidypics:option:all' => 'Kaikki',
			'tidypics:option:none' => 'Ei yhtään',
			'tidypics:option:cover' => 'Kansikuva',
			'tidypics:option:set' => 'Aseta',

		// server analysis
			'tidypics:server_info' => 'Tietoa palvelimesta',
			'tidypics:server_info:gd_desc' => 'Elgg vaatii GD-laajennuksen',
			'tidypics:server_info:exec_desc' => 'Vaaditaan ImageMagic-komentoja varten',
			'tidypics:server_info:memory_limit_desc' => 'Muuta memory_limit-asetusta kasvattaaksesi muistia',
			'tidypics:server_info:peak_usage_desc' => 'Tämä on arvio sivukohtaisesta minimistä',
			'tidypics:server_info:upload_max_filesize_desc' => 'Lisättävien kuvien maksimikoko',
			'tidypics:server_info:post_max_size_desc' => 'Suurin koko = kuvien yhteiskoko + html-lomake',
			'tidypics:server_info:max_input_time_desc' => 'Aika, jonka kuvien lisääminen saa kestää',
			'tidypics:server_info:max_execution_time_desc' => 'Maksimiaika, jonka skriptillä on käytettävissä',
			'tidypics:server_info:use_only_cookies_desc' => 'Istuntokohtaiset evästeet saattavat vaikuttaa Flash-lataajaan',

			'tidypics:server_info:php_version' => 'PHP-versio',
			'tidypics:server_info:memory_limit' => 'PHP:n käytössä oleva muisti',
			'tidypics:server_info:peak_usage' => 'Sivun lataamiseen käytetty muisti',
			'tidypics:server_info:upload_max_filesize' => 'Tiedoston maksimikoko',
			'tidypics:server_info:post_max_size' => 'Post-muuttujan maksimikoko',
			'tidypics:server_info:max_input_time' => 'Suurin sallittu syöteaika',
			'tidypics:server_info:max_execution_time' => 'Suurin sallittu suoritusaika',
			'tidypics:server_info:use_only_cookies' => 'Istuntokohtaiset evästeet',

			'tidypics:server_config' => 'Palvelimen asetukset',
			'tidypics:server_configuration_doc' => 'Palvelimen asetusten dokumentaatio',

		// ImageMagick test
			'tidypics:lib_tools:testing' =>
	'Tidypics tarvitsee ImageMagic-komentojen sijainnin, mikäli valitset sen kuvakirjastoksi.
	Palvelimesi ylläpitäjän pitäisi pystyä toimittamaan tämä tieto. Voit testata sijainnin
	syöttämällä sen allaolevaan kenttään. Jos polku on oikein, lomake näyttää käytössä
	olevan ImageMagic-kirjaston versionumeron.',

	// thumbnail tool
			'tidypics:thumbnail_tool' => 'Esikatselukuvien luonti',
			'tidypics:thumbnail_tool_blurb' => 
	'Tällä sivulla voit luoda esikatselukuvan kuville, joiden kohdalla luonti epäonnistui kuvaa lisättäessä.
	Esikatsekuvien lisäämisessä saattaa ilmetä ongelmia, mikäli käytössä olevan kuvakirjaston asetuksissa on
	puutteita tai muisti ei riitä kuvan lataamiseen ja koon muuttamiseen. Jos käyttäjillä on ollut ongelmia
	esikatselukuvien luonnissa, voit asetusten korjaamisen jälkeen yrittää esikatselukuvien uudelleenluontia.
	Etsi kuvan yksilöllinen id (numero joka näkyy kuvan url-osoitteessa) ja syötä se alla olevaan kenttään.',
			'tidypics:thumbnail_tool:unknown_image' => 'Kuvaa ei löytynt',
			'tidypics:thumbnail_tool:invalid_image_info' => 'Virhe kuvan tietojen hakemisessa',
			'tidypics:thumbnail_tool:create_failed' => 'Esikatselukuvan luonti epäonnistui',
			'tidypics:thumbnail_tool:created' => 'Luotiin esikatselukuva.',

		//actions
			'album:create' => "Lisää uusi albumi",
			'album:add' => "Lisää kuva-albumi",
			'album:addpix' => "Lisää kuvia albumiin",
			'album:edit' => "Muokkaa albumia",
			'album:delete' => "Poista albumi",
			'album:sort' => "Kuvien järjestys",
			'image:edit' => "Muokkaa kuvaa",
			'image:delete' => "Poista kuva",
			'image:download' => "Lataa kuva",

		//forms
			'album:title' => "Otsikko",
			'album:desc' => "Kuvaus",
			'album:tags' => "Tagit",
			'album:cover' => "Tee tästä albumin kansikuva?",
			'album:cover_link' => 'Vaihda kansikuvaksi',
			'tidypics:title:quota' => 'Kiintiö',
			'tidypics:quota' => "Kiintiön käyttö:",
			'tidypics:uploader:choose' => "Valitse kuvat",
			'tidypics:uploader:upload' => "Lataa kuvat",
			'tidypics:uploader:describe' => "Lisää kuvaukset",
			'tidypics:uploader:filedesc' => 'Kuvatiedostot (jpeg, png, gif)',
			'tidypics:uploader:instructs' => 'Voit lisätä kuvia albumiisi tällä kolme vaihetta sisältävällä latausohjelmalla. Jos selaimessasi ei ole Flash-tukea, voit käyttää vaihtoehtoisesti <a href="%s">yksinkertaista lataajaa</a>.',
			'tidypics:uploader:basic' => 'Voit lisätä maksimissaan 10 kuvaa kerralla (kunkin kuvan maksimikoko %s MB)',
			'tidypics:sort:instruct' => 'Järjestele kuvat raahaamalla ne haluamaasi järjestykseen. Paina lopuksi tallenna-painiketta.',
			'tidypics:sort:no_images' => 'Ei kuvia järjesteltäväksi. Lisää kuvia ylläolevasta linkistä.',

		// albums
			'album:num' => '%s kuvaa',

		//views
			'image:total' => "Kuvia albumissa:",
			'image:by' => "Kuvan lisääjä",
			'album:by' => "Albumin luoja",
			'album:created:on' => "Luotu",
			'image:none' => "Kuvia ei ole vielä lisätty.",
			'image:back' => "Edellinen",
			'image:next' => "Seuraava",
			'image:index' => "%u / %u",

		// tagging
			'tidypics:taginstruct' => 'Valitse alue, jonka haluat merkitä tai %s',
			'tidypics:finish_tagging' => 'Lopeta merkitseminen',
			'tidypics:tagthisphoto' => 'Merkitse tämä kuva',
			'tidypics:actiontag' => 'Merkitse kuva',
			'tidypics:actioncancel' => 'Peruuta',
			'tidypics:inthisphoto' => 'Tässä kuvassa',
			'tidypics:usertag' => "Kuvat, joihin %s on merkitty",
			'tidypics:phototagging:success' => 'Lisättiin uusi kuvamerkintä',
			'tidypics:phototagging:error' => 'Merkinnän lisäämisessä tapahtui odottamaton virhe',

			'tidypics:phototagging:delete:success' => 'Merkintä poistettu.',
			'tidypics:phototagging:delete:error' => 'Merkinnän poistamisessa tapahtua odottamaton virhe.',
			'tidypics:phototagging:delete:confirm' => 'Poista tämä merkintä?',



			'tidypics:tag:subject' => "Sinut on merkitty kuvaan",
			'tidypics:tag:body' => "Sinut on merkinnyt kuvaan %s käyttäjä %s.

Voit nähdä kuvan täällä:
%s",

		//rss
			'tidypics:posted' => 'lisäsi kuvan:',

		//widgets
			'tidypics:widget:albums' => "Kuva-albumit",
			'tidypics:widget:album_descr' => "Esittele kuva-albumisi",
			'tidypics:widget:num_albums' => "Näytettävien albumeiden määrä",
			'tidypics:widget:latest' => "Viimeisimmät kuvat",
			'tidypics:widget:latest_descr' => "Näytä viimeisimmät kuvasi",
			'tidypics:widget:num_latest' => "Näytettävien kuvien määrä",
			'album:more' => "Näytä kaikki albumit",

		//  river
			'river:create:object:image' => "%s lisäsi kuvan %s",
			'image:river:created' => "%s lisäsi kuvan %s albumiin %s",
			'image:river:created:multiple' => "%s lisäsi %u kuvaa albumiin %s",
			'image:river:item' => "kuva",
			'image:river:annotate' => "kommentin kuvaan",
			'image:river:tagged' => "%s merkiti käytäjän %s kuvaan %s",
			'image:river:tagged:unknown' => "%s lisäsi merkinnän %s kuvaan",
			'river:create:object:album' => "%s loi uuden kuva-albumin %s",
			'album:river:group' => "ryhmässä",
			'album:river:item' => "albumin",
			'album:river:annotate' => "kommentin kuva-albumiin",
			'river:comment:object:image' => '%s kommentoi kuvaa %s',
			'river:comment:object:album' => '%s kommentoi albumia %s',

		// notifications
			'tidypics:newalbum_subject' => 'Uusi kuva-albumi',
			'tidypics:newalbum' => '%s loi uuden kuva-albumin',
			'tidypics:updatealbum' => "%s lisäsi uusia kuvia albumiin %s",

		//  Status messages
			'tidypics:upl_success' => "Kuvat lisätty.",
			'image:saved' => "Kuva tallennettu.",
			'images:saved' => "Kuvat tallennettu.",
			'image:deleted' => "Poistettiin kuva.",
			'image:delete:confirm' => "Haluatko varmasti poistaa tämän kuvan?",
			'images:edited' => "Kuvat lisätty.",
			'album:edited' => "Albumi päivitetty.",
			'album:saved' => "Albumi tallennettu.",
			'album:deleted' => "Albumi poistettu.",
			'album:delete:confirm' => "Haluatko varmasti poistaa tämän albumin",
			'album:created' => "Luotiin uusi albumi.",
			'album:save_cover_image' => 'Kansikuva vaihdettu.',
			'tidypics:settings:save:ok' => 'Tidypics-pluginin asetukset tallennettu',
			'tidypics:album:sorted' => 'Järjesteltiin albumi %s',
			'tidypics:album:could_not_sort' => 'Ei voitu järjestää albumia %s. Varmista, että albumissa on kuvia, ja yritä uudellen.',
			'tidypics:upgrade:success' => 'Tidypics päivitetty onnistuneesti',

		//Error messages
			'tidypics:baduploadform' => "Kuvien lisäämisessä tapahti virhe",
			'tidypics:partialuploadfailure' => "Joidenkin kuvien lisääminen epäonnistui (%s / %s).",
			'tidypics:completeuploadfailure' => "Kuvien lisääminen epäonnistui.",
			'tidypics:exceedpostlimit' => "Liian monta suurta kuvaa - yritä lisätä pienempiä kuvia tai vähemmän kerralla.",
			'tidypics:noimages' => "Yhtäkään kuvaa ei ole valittuna.",
			'tidypics:image_mem' => "Kuvatiedosto on liian suuri",
			'tidypics:image_pixels' => "Kuvassa on liian monta pikseliä",
			'tidypics:unk_error' => "Tuntematon virhe lisäämisessä",
			'tidypics:save_error' => "Tuntematon virhe kuvan tallentamisessa palvelimelle",
			'tidypics:not_image' => "Tämä ei ole tuettu kuvatyyppi",
			'tidypics:deletefailed' => "Poistaminen epäonnistui.",
			'tidypics:deleted' => "Poistettiin kuva.",
			'tidypics:nosettings' => "Sivuston ylläpitäjä ei ole vielä määrittänyt kuva-albumien asetuksia.",
			'tidypics:exceed_quota' => "Olet ylittänyt sivuston ylläpitäjän määrittämän tilakiintiön",
			'tidypics:cannot_upload_exceeds_quota' => 'Kuvaa ei lisätty. Kuvan koko ylittää käytettävissä olevan tilakiintiön.',

			'album:none' => "Albumeita ei ole vielä luotu.",
			'album:uploadfailed' => "Albumin tallentaminen epäonnistui.",
			'album:deletefailed' => "Albumin poistaminen epäonnistui.",
			'album:blank' => "Anna albumille otsikko.",
			'album:invalid_album' => 'Virheellinen albumi',
			'album:cannot_save_cover_image' => 'Kansikuvan tallentaminen epäonnistui',

			'image:downloadfailed' => "Kuva ei ole saatavilla.",
			'images:notedited' => "Joidenkin kuvien tallentaminen epäonnistui",
			'image:blank' => 'Anna kuvalle otsikko.',
			'image:error' => 'Kuvan tallentaminen epäonnistui.',

			'tidypics:upgrade:failed' => "Tidypics-pluginin päivittäminen epäonnistui", 
);

add_translation("fi", $finnish);
