<?php
	/**
	 * tidypics CSS extender
	 */
?>
/* ---- tidypics object views ---- */

#tidypics_wrapper {
}

#tidypics_breadcrumbs {
margin:5px 0 25px 0;
font-size:80%;
}

#tidypics_desc {
padding:0 20px;
font-style:italic;
}

#tidypics_info {
padding:20px;
}

#tidypics_controls {
text-align:center;
margin-bottom:10px;
}

#tidypics_controls a {
margin:10px;
}

#tidypics_controls ul {
list-style:none; 
margin:0px; 
padding:8px;
}

#tidypics_controls ul li {
padding:2px 10px 2px 22px;
margin:2px 0px; 
display:inline;
}
/*
.tidypics_download a {
font:12px/100% Arial, Helvetica, sans-serif;
font-weight:bold;
color:white;
background:#4690d6;
border:none;
-webkit-border-radius: 5px; 
-moz-border-radius: 5px;
width:auto;
height:25px;
padding:3px 6px 3px 6px;
margin:10px 0 10px 0;
cursor:pointer;
}

.tidypics_download a:hover {
background:#0054a7;
color:white;
text-decoration:none;
}
*/
.tidypics_album_images {
float:left;
width:153px; 
height:153px;
margin:3px;
padding:4px;
border:1px solid #dedede;
text-align:center;
}

#tidypics_image_nav {
text-align:center;
}

#tidypics_image_full {
text-align:center;
margin:10px;
}

#tidypics_image_wrapper {
margin:10px 0 10px 0;
text-align:center;
}

/*
#tidypics_image_frame {
padding:5px;
border:1px solid #dedede;
float: left;
margin: 0 auto;
}
*/


#tidypics_image_full img {
padding:5px;
border:1px solid #dedede;
margin:7px 0;
}

#tidypics_image {
background:#EEEEEE none repeat scroll 0 0;
border:2px solid #999999;
padding:5px;
}

.tidypics_album_cover {
padding:2px;
border:1px solid #dedede;
margin:8px 0;
}

.tidypics_album_widget_single_item {
margin-bottom:8px;
}

.tidypics_album_gallery_item {
text-align:center;
}

/* ------ tidypics widget view ------  */

#tidypics_album_widget_container {
text-align:center;
}

.tidypics_album_widget_timestamp {
color:#333333;
}

/* ---------  image upload/edit forms  ------------   */

#tidpics_image_upload_list li {
margin:3px 0;
}

.tidypics_edit_image_container {
padding:5px;
margin:5px 0;
overflow:auto;
}

.tidypics_edit_images {
float:right;
width:160px; 
height:160px;
margin:4px;
padding:5px;
border:1px solid #dedede;
text-align:center;
}

.tidypics_image_info {
float:left;
width:60%;
}

.tidypics_image_info label {
font-size:1em;
}

/* ---- tidypics group css ----- */

#group_albums_widget {
-webkit-border-radius: 8px; 
-moz-border-radius: 8px;
background:white none repeat scroll 0 0;
margin:0 0 20px;
padding:0 0 5px;
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

/* ----------- tagging ---------------- */
#tagging_instructions {
background:#BBDAF7; 
border:1px solid #4690D6;  
padding:10px;
height:25px;
width:360px;
display:none;
overflow:hidden; 
position:absolute; 
z-index:10000;
}

#tag_instruct_text {
padding-top: 3px;
float: left;
}

#tag_instruct_button_div {
float: left;
margin-left: 15px;
}

#tag_instruct_button {
margin:0;
}

#tag_menu {
border:1px solid #3B5999; 
width:200px; 
position:absolute;
z-index:10000; 
display:none; 
background:#ffffff; 
padding:10px; 
font-size:12px; 
text-align:left;
}

.tidypics_tag {
display:none;
background:url(<?php echo $vars['url']; ?>mod/tidypics/graphics/spacer.gif); 
border:2px solid #ffffff; 
overflow:hidden; 
position:absolute; 
z-index:0;
}

.tidypics_tag_text {
display:none;
overflow:hidden; 
position:absolute; 
z-index:0;
text-align:center;
background:#BBDAF7;
border:1px solid #3B5999;
-webkit-border-radius:3px; 
-moz-border-radius:3px;
padding:1px;
}

#tidypics_phototags_list {
padding:20px;
}

#tidypics_phototags_list ul {
list-style:none; 
margin:0px; 
padding:8px;
}

#tidypics_phototags_list ul li {
padding-right:10px;
margin:2px 0px; 
display:inline;
} 
