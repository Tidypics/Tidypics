<?php
	/**
	 * tidypics CSS extender
	 */
?>
	/*  --- independent view for image/album SHARED --- */
	
#tidypics_title{
	font-size:1.2em;
	font-weight:bold;
}
#tidypics_desc{
	padding:0 20px;
	font-style:italic;
}
#tidypics_info{
	padding:20px;
	line-height:1.5em;
}

#tidypics_controls{
	text-align:center;
	margin-bottom:10px;
}

#tidypics_controls a{
	margin:10px;
}

	/* independent album view only */
	
.album_images{
	float:left;
	width:160px; 
	height:160px;
	margin:4px;
	padding:5px;
	border:1px solid #cccccc;	
	text-align:center;
}

	/* independent image view only */

#image_full{
	text-align:center;
	margin:10px;
}
#image_full img{
	padding:5px;
	border:1px solid #cccccc;
	margin:7px 0;
}

/*  --- albums gallery view --- */

.album_cover{
	padding:2px;
	border:1px solid #cccccc;
	margin:8px 0;
}


/* ------ album WIDGET VIEW ------  */

#album_widget_container{
	text-align:center;
}

.album_widget_single_item{

}
.album_widget_title{

}
.album_widget_timestamp {
	color:#666666;
	margin:0;
}
.collapsable_box #album_widget_layout {
	margin:0;
}

/* ---------  image upload/edit forms  ------------   */

#image_upload_list li{
	margin:3px 0;
}
.edit_image_container{
	padding:5px;
	margin:5px 0;
	overflow:auto;
}
.edit_images{
	float:right;
	width:160px; 
	height:160px;
	margin:4px;
	padding:5px;
	border:1px solid #cccccc;	
	text-align:center;
}
.image_info{
	float:left;
	width:60%;
}
.image_info label{
	font-size:1em;
}
.edit_image{
	float:right;
	border:1px solid #cccccc; 
	width:153px; 
	height:153px;
}

/* ---------  tidypics river items ------------   */

.river_image_create {
	background: url(<?php echo $vars['url']; ?>mod/tidypics/graphics/icons/river_icon_image.gif) no-repeat left -1px;
}
.river_album_create {
	background: url(<?php echo $vars['url']; ?>mod/tidypics/graphics/icons/river_icon_album.gif) no-repeat left -1px;
}
.river_object_album_create {
	background: url(<?php echo $vars['url']; ?>mod/tidypics/graphics/icons/river_icon_album.gif) no-repeat left -1px;
}
.river_object_image_comment {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_comment.gif) no-repeat left -1px;
}
.river_object_album_comment {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_comment.gif) no-repeat left -1px;
}

.pagination {
	clear:both !important;
}
	