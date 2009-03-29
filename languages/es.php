<?php
	/**
	 * Elgg tidypics plugin language pack
	 * 
	 */

	$spanish = array(
			
		// Menu items and titles
			 
			'image' => "Imagen",
			'images' => "Im&#225;genes",
			'caption' => "Leyenda",		
			'photos' => "Fotos",
			'images:upload' => "Subir Im&#225;genes",
			'album' => "&#193;llbum de Fotos",
			'albums' => "&#193;lbums de Fotos",
			'album:yours' => "Tus &#225;lbums de fotos",
			'album:yours:friends' => "&#193;lbums de tus amigos",
			'album:user' => "&#193;llbums de %s",
			'album:friends' => "Albums de los amigos de %s",
			'album:all' => "Todos los &#225;lbums",
			'album:group' => "&#193;llbums del grupo",
			'item:object:image' => "Fotos",
			'item:object:album' => "&#193;llbums",
			'tidypics:settings:maxfilesize' => "Tama&#241;o m&#225;ximo en kilo bytes (KB):",

            'tidypics:editprops' => "Editar propiedades de imagen",

		//actions
		
			'album:create' => "Nuevo &#225;lbum",
			'album:add' => "A&#241;adir &#225;lbum de fotos",
			'album:addpix' => "A&#241;adir fotos",		
			'album:edit' => "Modificar &#225;lbum",			
			'album:delete' => "Eliminar &#225;lbum",		

			'image:edit' => "Modificar imagen",
			'image:delete' => "Eliminar imagen",
			'image:download' => "Descargar imagen",
		
		//forms
		
			'album:title' => "T&#237;tulo",
			'album:desc' => "Descripci&#243;n",
			'album:tags' => "Etiquetas",
			'album:cover' => "&#191;Hacer portada del &#225;lbum?",
			'album:cover:yes' => "Si",
			'image:access:note' => "(los permisos de acceso se heredan del &#225;lbum)",
			
		//views 
		
			'image:total' => "Im&#225;genes en el &#225;lbum:",
			'image:by' => "Imagen a&#241;adida por",
			'album:by' => "Album creado por",
			'album:created:on' => "Creado",
			'image:none' => "Todav&#237;a no se han a&#241;adido im&#225;genes.",
			'image:back' => "Anterior",
			'image:next' => "Siguiente",
		
		//widgets
		
			'album:widget' => "Albums de Fotos",
			'album:more' => "Ver todos los albums",
			'album:widget:description' => "Muestra tus &#225;lbums de fotos m&#225;s recientes",
			'album:display:number' => "N&#250;mero de albums a mostrar",
			'album:num_albums' => "N&#250;mero de albums a mostrar",
			
		//  river
		
			//images
			'image:river:created' => "%s subi&#243;",
			'image:river:item' => "una imagen",
			'image:river:annotate' => "%s coment&#243; en",	
		
			//albums
			'album:river:created' => "%s cre&#243;",
			'album:river:item' => "un album",
			'album:river:annotate' => "%s coment&#243; en",
				
		//  Status messages
			
			'image:saved' => "Tu imagen ha sido guardada.",
			'images:saved' => "Todas tus im&#225;genes han sido guardadas.",
			'image:deleted' => "Tu imagen ha sido borrada.",			
			'image:delete:confirm' => "&#191;Deseas borrar esta imagen?",
			
			'images:edited' => "Tus im&#225;genes han sido actualizadas.",
			'album:edited' => "Tu &#225;lbum ha sido actualizado.",
			'album:saved' => "Tu &#225;lbum ha sido guardado.",
			'album:deleted' => "Tu &#225;lbum ha sido borrado con &#233;xito.",	
			'album:delete:confirm' => "&#191;Deseas borrar este &#225;lbum?",
			'album:created' => "Tu nuevo &#225;lbum ha sido creado.",
			'tidypics:status:processing' => "Por favor espera mientras procesamos tu imagen....",
				
		//Error messages
				 
			'image:none' => "No ha sido psible encontrar ninguna imagen en este momento.",
			'image:uploadfailed' => "Algunos ficheros no se pudieron subir:",
			'image:deletefailed' => "Tu imagen no ha podido ser borrada en este momento.",
			'image:downloadfailed' => "Esta imagen no se encuentra disponible en este momento.",
			
			'image:notimage' => "S&#243;lo se aceptan im&#225;genes jpeg, gif, o png del tama&#241;o permitido.",
			'images:notedited' => "No se pudieron actualizar todas las im&#225;genes.",
		 
			'album:none' => "Actualmente no hay ning&#250;n &#225;lbum de fotos.",
			'album:uploadfailed' => "No se ha podido guardar el &#225;lbum.",
			'album:deletefailed' => "En este momento no se ha podido borrar el &#225;lbum.",
			'album:blank' => "Por favor entra un t&#237;tulo y descripci&#243;n para tu nuevo &#225;lbum."
	);
					
	add_translation("es",$spanish);
?>