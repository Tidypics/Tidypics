<?php


$catalan = array(
    // hack for core bug
    'untitled' => "sense títol",


    // Menu items and titles
    'image' => "Imatge",
    'images' => "Imatges",
    'caption' => "Caption",
    'photos' => "Fotos",
    'album' => "Àlbum Fotos",
    'albums' => "Àlbum Fotos",
    'tidypics:disabled' => 'Deshabilitat',
    'tidypics:enabled' => 'Habilitat',
                        'admin:settings:photos' => 'Tidypics',


                        'photos:add' => "Crear àlbum",
                        'images:upload' => "Pujar fotos",


                        'album:slideshow' => "Presentació",
                        'album:yours' => "El teus àlbums fotos",
                        'album:yours:friends' => "Àlbums fotos dels Teus amics",
                        'album:user' => "%s's àlbums fotos",
                        'album:friends' => "Àlbums fotos Amics",
                        'album:all' => "Àlbums fotos tota la web",
                        'photos:group' => "Grup fotos",
                        'item:object:image' => "Fotos",
                        'item:object:album' => "Àlbums",
                        'tidypics:uploading:images' => "Si us plau espera. Pujant imatges.",
                        'tidypics:enablephotos' => 'Habilitar grup àlbums fotos',
                        'tidypics:editprops' => 'Editar Propietats Imatge',
                        'tidypics:mostcommented' => 'Imatges més comentades',
                        'tidypics:mostcommentedthismonth' => 'Més comentades aquest mes',
                        'tidypics:mostcommentedtoday' => 'Més comentades avui',
                        'tidypics:mostviewed' => 'Imatges més vistes',
                        'tidypics:mostvieweddashboard' => 'Quadre de comandament més vist',
                        'tidypics:mostviewedthisyear' => 'Més vist aquest any',
                        'tidypics:mostviewedthismonth' => 'Més vist aquest mes',
                        'tidypics:mostviewedlastmonth' => 'Més vist l’últim mes',
                        'tidypics:mostviewedtoday' => 'Més vist avui',
                        'tidypics:recentlyviewed' => 'Imatges vistes més recentment',
                        'tidypics:recentlycommented' => 'Imanges comentades més recentment',
                        'tidypics:mostrecent' => 'Imatges més recents',
                        'tidypics:yourmostviewed' => 'Les teves imatges més vistes',
                        'tidypics:yourmostrecent' => 'Les teves imatges més recents',
                        'tidypics:friendmostviewed' => "%s's imatges més vistes",
                        'tidypics:friendmostrecent' => "%s's imatges més recents",
                        'tidypics:highestrated' => "Imatges més votades",
                        'tidypics:views' => "%s visites",
                        'tidypics:viewsbyowner' => "per %s usuaris (sense incloure’t)",
                        'tidypics:viewsbyothers' => "(%s per tu)",
                        'tidypics:administration' => 'Administració Tidypics',
                        'tidypics:stats' => 'Stadístiques',
                        'tidypics:nophotosingroup' => 'Aquest grups encara no tenen cap foto',
                        'tidypics:upgrade' => 'Actualitzar',
                        'tidypics:sort' => 'Ordenant el %s àlbum',
                        'tidypics:none' => 'Cap àlbum fotos',
                        
                //settings
                        'tidypics:settings' => 'Configuració',
                        'tidypics:settings:main' => 'Configuració Principal',
                        'tidypics:settings:image_lib' => "Llibreria imatges",
                        'tidypics:settings:thumbnail' => "Creació miniatures",
                        'tidypics:settings:help' => "Ajuda",
                        'tidypics:settings:download_link' => "Mostrar link descàrrega",
                        'tidypics:settings:tagging' => "Habilitat etiquetatge de fotos",
                        'tidypics:settings:photo_ratings' => "Habilitar classificació fotos (cal plugin classificació de Miguel Montes o compatible)",
                        'tidypics:settings:exif' => "Mostrar dades EXIF",
                        'tidypics:settings:view_count' => "Mostrar contador viualitzacions",
                        'tidypics:settings:uploader' => "Usar Flash uploader",
                        'tidypics:settings:grp_perm_override' => "Permetre als membres del grup accés complert als àlbums del grup",
                        'tidypics:settings:maxfilesize' => "Màxim tamany imatge en megabytes (MB):",
                        'tidypics:settings:quota' => "Quota Usuari (MB) - 0 equival a il·limitat",
                        'tidypics:settings:watermark' => "Intruduir text a aparèixer en marca d’aigua",
                        'tidypics:settings:im_path' => "Introduir el camí a les teves comandes ImageMagick",
                        'tidypics:settings:img_river_view' => "How many entries in activity river for each batch of uploaded images",
                        'tidypics:settings:album_river_view' => "Mostra la caràtula de l’àlbum o una sèrie de fotos per a l’àlbum nou",
                        'tidypics:settings:largesize' => "Mida imatge principal",
                        'tidypics:settings:smallsize' => "Mida imatge vista àlbum",
                        'tidypics:settings:tinysize' => "Mida miniatura imatge",
                        'tidypics:settings:sizes:instructs' => 'Potser cal canviar el CSS si canvies els tamanys per defecte',
                        'tidypics:settings:im_id' => "ID Imatge",
                        'tidypics:settings:heading:img_lib' => "Configuració Llibreria Imatge",
                        'tidypics:settings:heading:main' => "Configuració principal",
                        'tidypics:settings:heading:river' => "Opcions Integració Activitat",
                        'tidypics:settings:heading:sizes' => "Tamany miniatura",
                        'tidypics:settings:heading:groups' => "Configuració Grup",
                        'tidypics:option:all' => 'Tot',
                        'tidypics:option:none' => 'Cap',
                        'tidypics:option:cover' => 'Portada',
                        'tidypics:option:set' => 'Conjunt',


                // server analysis
                        'tidypics:server_info' => 'Server Information',
                        'tidypics:server_info:gd_desc' => 'Elgg necessita la extensió GD per ser carregada',
                        'tidypics:server_info:exec_desc' => 'Required for ImageMagick command line',
                        'tidypics:server_info:memory_limit_desc' => 'Change memory_limit to increase',
                        'tidypics:server_info:peak_usage_desc' => 'Això és aproximadament el mínim per pàgina',
                        'tidypics:server_info:upload_max_filesize_desc' => 'Max tamany d’una imatge carregada',
                        'tidypics:server_info:post_max_size_desc' => 'Max tamany post = suma d’images + formulari html',
                        'tidypics:server_info:max_input_time_desc' => 'Time script waits for upload to finish',
                        'tidypics:server_info:max_execution_time_desc' => 'Max time a script will run',
                        'tidypics:server_info:use_only_cookies_desc' => 'Cookie only sessions may affect the Flash uploader',


                        'tidypics:server_info:php_version' => 'Versió PHP',
                        'tidypics:server_info:memory_limit' => 'Memoria disponible per PHP',
                        'tidypics:server_info:peak_usage' => 'Memoria Utilitzada per carregar aquesta pàgina',
                        'tidypics:server_info:upload_max_filesize' => 'Max File Upload Size',
                        'tidypics:server_info:post_max_size' => 'Max Post Size',
                        'tidypics:server_info:max_input_time' => 'Max Input Time',
                        'tidypics:server_info:max_execution_time' => 'Max Execution Time',
                        'tidypics:server_info:use_only_cookies' => 'Cookie only sessions',


                        'tidypics:server_config' => 'Configuració Servidor',
                        'tidypics:server_configuration_doc' => 'Documentació Configuració servidor',


                // ImageMagick test
                        'tidypics:lib_tools:testing' =>
        'Tidypics necesita saber la localització dels executables de ImageMagick si l’has seleccionat
        com la llibreria d’imatges. El teu servei d’allotjament hauria de poder-te donar aquesta informació. Pots provar
        si la locació és correcte més avall. Si és correcte, hauria de motrar la versió d’ImageMagick instal·lada
        en el teu servidor.',


        // thumbnail tool
                        'tidypics:thumbnail_tool' => 'Creació Miniatures',
                        'tidypics:thumbnail_tool_blurb' => 
        'Aquesta pàgina et permet crear miniatures per imatges quan la creació de miniatures falla durant la càrrega.
        Pots tenir problemes en la creació de miniatures si la teva llibreria d’imatges no està configurada correctament o
        si no hi ha suficient memòria per la llibreria GD per carregar i redimensionar una imatge. Si els teus usuaris tenen
        problemes amb la creació de miniatures i has corregit la configuració, pots intentar a refer les
        miniatures. Busca l’identificardor únic de la foto (és el número cap al final de la url quan visualitzes
        una foto) i posa-la més avall.',
                        'tidypics:thumbnail_tool:unknown_image' => 'Impossible acabar imatge original',
                        'tidypics:thumbnail_tool:invalid_image_info' => 'Error recuperant informació sobre la imatge',
                        'tidypics:thumbnail_tool:create_failed' => 'Error al crear miniatures',
                        'tidypics:thumbnail_tool:created' => 'Creades miniatures.',


                //actions
                        'album:create' => "Crear nou àlbum",
                        'album:add' => "Afegir Àlbum Fotos",
                        'album:addpix' => "Afegir fotos a àlbum",
                        'album:edit' => "Editar àlbum",
                        'album:delete' => "Esborrar àlbum",
                        'album:sort' => "Ordenar",
                        'image:edit' => "Editar imatge",
                        'image:delete' => "Esborrar imatge",
                        'image:download' => "Descarregar imatge",


                //forms
                        'album:title' => "Títol",
                        'album:desc' => "Descripció",
                        'album:tags' => "Tags",
                        'album:cover' => "Fer aquesta imatge la coberta de l’àlbum?",
                        'album:cover_link' => 'Fer coberta',
                        'tidypics:title:quota' => 'Quota',
                        'tidypics:quota' => "Ús Quota:",
                        'tidypics:uploader:choose' => "Escollir fotos",
                        'tidypics:uploader:upload' => "Pujar fotos",
                        'tidypics:uploader:describe' => "Descriure fotos",
                        'tidypics:uploader:filedesc' => 'Fitxers Imatge (jpeg, png, gif)',
                        'tidypics:uploader:instructs' => 'Hi ha tres senzills passos per afegir fotos al teu àlbum usant aquest carregador: escollir, pujar i desciure-les. Hi ha un màxim de %s MB per foto. Si no tens el Flash, hi ha també un <a href="%s">carregador bàsic</a> disponible.',
                        'tidypics:uploader:basic' => 'Pots pujar fins a 10 fotos de cop (màxim %s MB per foto)',
                        'tidypics:sort:instruct' => 'Ordenar l’àlbum de fotos arrossegant i deixant anar les imatges. Després clica el botó guardar.',
                        'tidypics:sort:no_images' => 'Cap imatge trobada per a ser ordenada. Puja imatges usant el link de dalt.',


                // albums
                        'album:num' => '%s fotos',


                //views
                        'image:total' => "Imatges en àlbum:",
                        'image:by' => "Imatge afegida per",
                        'album:by' => "Àlbum creat per",
                        'album:created:on' => "Creat",
                        'image:none' => "Cap imatge ha estat afegida encara.",
                        'image:back' => "Prèvia",
                        'image:next' => "Següent",
                        'image:index' => "%u de %u",


                // tagging
                        'tidypics:taginstruct' => 'Selecciona l’àrea que vols etiquetar o %s',
                        'tidypics:finish_tagging' => 'Parar etiquetatge',
                        'tidypics:tagthisphoto' => 'Etiqueta aquesta foto',
                        'tidypics:actiontag' => 'Etiqueta',
                        'tidypics:actioncancel' => 'Cancel·lar',
                        'tidypics:inthisphoto' => 'En aquesta foto',
                        'tidypics:usertag' => "Fotos etiquetades amb usuari %s",
                        'tidypics:phototagging:success' => 'Etiqueta foto ha estat afegida correctament',
                        'tidypics:phototagging:error' => 'Ha succeït un error inesperat durant l’etiquetatge',


                        'tidypics:phototagging:delete:success' => 'Etiqueta foto ha estat esborrada.',
                        'tidypics:phototagging:delete:error' => 'Ha succeït un error inesperat durant l’esborrat d’etiqueta foto.',
                        'tidypics:phototagging:delete:confirm' => 'Esborrar aquesta etiqueta?',






                        'tidypics:tag:subject' => "Has estat etiquetat en una foto",
                        'tidypics:tag:body' => "Has estat etiquetat a la foto %s per %s.

    La foto pot ser visualitzada aquí: %s",




                //rss
                        'tidypics:posted' => 'publicar una foto',


                //widgets
                        'tidypics:widget:albums' => "Àlbums Fotos",


                        'tidypics:widget:album_descr' => "Mostrar els teus àlbums de fotos",
                        'tidypics:widget:num_albums' => "Número d’àlbums a mostrar",
                        'tidypics:widget:latest' => "Últimes Fotos",
                        'tidypics:widget:latest_descr' => "Mostrar les teves últimes fotos",
                        'tidypics:widget:num_latest' => "Número d’imatges a mostrar",
                        'album:more' => "Veure tots els àlbums",


                //  river
                        'river:create:object:image' => "%s carregades les fotos %s",
                        'image:river:created' => "%s afegida una foto a l’àlbum %s",
                        'image:river:created:multiple' => "%s afegides %u fotos a l’àlbum %s",
                        'image:river:item' => "una foto",
                        'image:river:annotate' => "un comentari a la foto",
                        'image:river:tagged' => "%s etiquetat %s a la foto %s",
                        'image:river:tagged:unknown' => "%s etiquetat %s en una photo",
                        'river:create:object:album' => "%s creada una nova foto àlbum %s",
                        'album:river:group' => "al grup",
                        'album:river:item' => "un àlbum",
                        'album:river:annotate' => "un comentari al àlbum de fotos",
                        'river:comment:object:image' => '%s comentat a la foto %s',
                        'river:comment:object:album' => '%s comentat a l’àlbum %s',


                // notifications
                        'tidypics:newalbum_subject' => 'Nou àlbum de fotos',
                        'tidypics:newalbum' => '%s creat un nou àlbum de fotos',
                        'tidypics:updatealbum' => "%s noves fotos carregades a l’àlbum %s",


                //  Status messages
                        'tidypics:upl_success' => "Les imatges han estat carregades correctament.",
                        'image:saved' => "La teva imatge ha estat guardada correctament.",
                        'images:saved' => "Totes les imatges han estat guardades correctament.",
                        'image:deleted' => "La imatge ha estat esborrada correctament.",
                        'image:delete:confirm' => "Estàs segur que vols esborrar aquesta imatge?",
                        'images:edited' => "Les teves imatges han estat actualitzades correctament.",
                        'album:edited' => "El teu àlbum ha estat actualitzada correctament.",
                        'album:saved' => "El teu àlbum ha estat guardat correctament.",
                        'album:deleted' => "El teu àlbum ha estat esborrat correctament.",
                        'album:delete:confirm' => "Estàs segur que vols esborrar aquest àlbum?",
                        'album:created' => "El teu nou àlbum ha estat creat.",
                        'album:save_cover_image' => 'Imatge portada guardada.',
                        'tidypics:settings:save:ok' => 'paràmetres plugin Tidypics guardat correctament',
                        'tidypics:album:sorted' => 'L’àlbum %s està ordenat',
                        'tidypics:album:could_not_sort' => 'Podria no ordenar l’àlbum %s. Assegura’t que hi ha imatges a l’àlbum i intenta-ho novament.',
                        'tidypics:upgrade:success' => 'Actualització de Tidypics correcte',


                //Error messages
                        'tidypics:baduploadform' => "Hi ha hagut un error amb el formulari de càrrega",
                        'tidypics:partialuploadfailure' => "Hi ha hagut errors en la càrrega d’alguna de les imatges (%s de %s imatges).",
                        'tidypics:completeuploadfailure' => "Ha fallat la càrrega d’imatges.",
                        'tidypics:exceedpostlimit' => "Masses imatges grans - intenta carregar menys o imatges més petites.",
                        'tidypics:noimages' => "Cap imatge ha estat seleccionada.",
                        'tidypics:image_mem' => "Imatge és massa gran - masses bytes",
                        'tidypics:image_pixels' => "Imatge té masses píxels",
                        'tidypics:unk_error' => "Error de càrrega desconegut",
                        'tidypics:save_error' => "Error desconegut al guardar la imatge al servidor",
                        'tidypics:not_image' => "Aquest no és un tipus d’imatge reconegut",
                        'tidypics:deletefailed' => "Ho sentim. Esborrat fallit.",
                        'tidypics:deleted' => "Esborrat correctament.",
                        'tidypics:nosettings' => "Admin del site no ha definit paràmetres d’àlbum de fotos.",
                        'tidypics:exceed_quota' => "Has excedit la quota definida per l’administrador",
                        'tidypics:cannot_upload_exceeds_quota' => 'Imatge no carregada. Tamany fitxer supera quota disponible.',


                        'album:none' => "Cap àlbum ha estat creat encara.",
                        'album:uploadfailed' => "Ho sentim; no hem pogut guardar el teu àlbum.",
                        'album:deletefailed' => "El teu àlbum podría no haver estat esborrat.",
                        'album:blank' => "Si us plau dona un títol a l’àlbum.",
                        'album:invalid_album' => 'Àlbum Invàlid',
                        'album:cannot_save_cover_image' => 'No es pot guardar la imatge portada',


                        'image:downloadfailed' => "Perdona; aquesta imatge no està disponible.",
                        'images:notedited' => "No totes les imatges han estat actualitzades",
                        'image:blank' => 'Si us plau dona un títol a aquesta imatge.',
                        'image:error' => 'Could not save image.',


                        'tidypics:upgrade:failed' => "L’actualització de Tidypics ha fallat", 
);


add_translation("ca", $catalan);