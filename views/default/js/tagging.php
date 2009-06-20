<?php
	$photo_tags_json = $vars['photo_tags_json'];
?>
<script type="text/javascript" src="<?= $vars['url'] ?>mod/tidypics/vendors/jquery.imgareaselect-0.7.js"></script>
<script type="text/javascript" src="<?= $vars['url'] ?>mod/tidypics/vendors/jquery.quicksearch.js"></script>
 
<script type="text/javascript">

	var coordinates = "";
	var user_id = 0;
	var tagging = 0;

	// add to DOM as soon as ready
	$(document).ready(function () {
			$('ul#tidypics_phototag_list li').quicksearch({
				position: 'before',
				attached: 'ul#tidypics_phototag_list',
				loaderText: '',
				inputClass: 'input-filter',
				labelText: "<p><?php echo elgg_echo('tidypics:tagthisphoto'); ?></p>",
				delay: 100
			});

			$('#quicksearch').submit( function () { addTag() } );
		}
	);

	// images are loaded so process tags
	$(window).load(function () {
			$('#tidypics_image').setupTags();
		}
	);

	// get tags over image ready for mouseover
	// based on code by Tarique Sani <tarique@sanisoft.com> - MIT and GPL licenses
	$.fn.setupTags = function() 
	{

		image = this;

		imgOffset = $(image).offset();
		imgOffset.left = parseInt(imgOffset.left) + parseInt($(image).css("border-left-width")) + parseInt($(image).css("padding-left"));
		imgOffset.top = parseInt(imgOffset.top) + parseInt($(image).css("border-top-width")) + parseInt($(image).css("padding-top"));
		
		tags = <?php echo $photo_tags_json; ?>; 

		$(tags).each(function(){
			appendTag(imgOffset, this);
		});
		
		$(image).hover(
			function(){
				$('.tidypics_tag').show();
			},
			function(){
				$('.tidypics_tag').hide();
			}
		);

		addTagEvents();
		
		$('.tidypics_phototag_links').hover(
			function(){
				code = this.id.substr(7); // cut off taglink to get unique id
				$('#tag'+code).show();
			},
			function(){
				code = this.id.substr(7);
				$('#tag'+code).hide();
			}
		);

		// make sure we catch and handle when the browser is resized
		$(window).resize(function () {
			$('.tidypics_tag').remove();

			imgOffset = $(image).offset();

			$(tags).each(function(){
				appendTag(imgOffset, this);
			});

			addTagEvents();
		});
	} 

	function appendTag(offset, tag)
	{
		// catch for IE when no tags available
		if (tag.id == undefined)
			return;
		
		tag_top   = parseInt(imgOffset.top) + parseInt(tag.y1);
		tag_left  = parseInt(imgOffset.left) + parseInt(tag.x1);

		tag_div = $('<div class="tidypics_tag" id="tag'+tag.id+'"></div>').css({ left: tag_left + 'px', top: tag_top + 'px', width: tag.width + 'px', height: tag.height + 'px' });

		text_top = parseInt(tag_top) + parseInt(tag.height) + 5;

		tag_text_div = $('<div class="tidypics_tag_text">'+tag.text+'</div>').css({ left: tag_left + 'px', top: text_top + 'px', width: '120px'});

		$('body').append(tag_div);
		$('body').append(tag_text_div);
	}

	function addTagEvents() 
	{
		$('.tidypics_tag').hover(
			function(){
				$('.tidypics_tag').show();
				$(this).next('.tidypics_tag_text').show();
				$(this).next('.tidypics_tag_text').css("z-index", 10000);
			},
			function(){
				$('.tidypics_tag').show();
				$(this).next('.tidypics_tag_text').hide();
				$(this).next('.tidypics_tag_text').css("z-index", 0);
			}
		);
	}


	function selectUser(id, name) 
	{
		user_id = id;
		$("input.input-filter").val(name);
	}

	function startTagging() 
	{
		if (tagging != 0)
		{
			stopTagging();
			return;
		}
		
		tagging = 1;
		
		$('#tidypics_tag_control').text("Stop Tagging");
		
		showTagInstruct();
		$('#tidypics_delete_tag_menu').hide();

		$('#tidypics_image').hover(
			function(){
				$('.tidypics_tag').hide();
			},
			function(){
				$('.tidypics_tag').hide();
			}
		);

		$('img#tidypics_image').imgAreaSelect( { 
			borderWidth: 2,
			borderColor1: 'white',
			borderColor2: 'white',
			disable: false,
			hide: false,
			onSelectEnd: showTagMenu,
			onSelectStart: hideTagMenu 
			}
		);
	}

	function stopTagging() 
	{
		tagging = 0;
		
		hideTagInstruct();
		hideTagMenu();

		$('#tidypics_tag_control').text("Tag this photo");

		$('img#tidypics_image').imgAreaSelect( {hide: true, disable: true} );

		// restart tag hovering
		$('#tidypics_image').hover(
			function(){
				$('.tidypics_tag').show();
			},
			function(){
				$('.tidypics_tag').hide();
			}
		);
	}

	function showTagMenu(oObject, oCoordenates)
	{
		offsetX = -100;

		imgOffset = $('#tidypics_image').offset();

		// show the list of friends
		if (oCoordenates.width != 0 && oCoordenates.height != 0) {
			coordinates = oCoordenates;
			
			_top = imgOffset.top + oCoordenates.y2;
			_left = imgOffset.left + oCoordenates.x2 + offsetX;

			$('#tidypics_tag_menu').show().css({
				"top": _top + "px",
				"left": _left + "px"
			});

			$(".input-filter").focus();
		}
	}


	function hideTagMenu()
	{
		$('#tidypics_tag_menu').hide();
	}

	function showTagInstruct()
	{
		offsetY = -60;
		
		divWidth = $('#tidypics_tag_instructions').width();
		imgOffset = $('#tidypics_image').offset();
		imgWidth  = $('#tidypics_image').width();
		offsetX   = parseInt((imgWidth - divWidth)/2);
		
		_top = imgOffset.top + offsetY;
		_left = imgOffset.left + offsetX;

		$('#tidypics_tag_instructions').show().css({
			"top": _top + "px",
			"left": _left + "px"
		});
	}

	function hideTagInstruct()
	{
		$('#tidypics_tag_instructions').hide();
	}

	function addTag()
	{
		// do I need a catch for no tag?

		$("input#user_id").val(user_id);
		$("input#word").val( $("input.input-filter").val() );

		coord_string  = '"x1":"' + coordinates.x1 + '",';
		coord_string += '"y1":"' + coordinates.y1 + '",';
		coord_string += '"width":"' + coordinates.width + '",';
		coord_string += '"height":"' + coordinates.height + '"';

		$("input#coordinates").val(coord_string);

		//Show loading
		//$("#tag_menu").replaceWith('<div align="center" class="ajax_loader"></div>');
	}

	function deleteTags()
	{
		offsetY = 60;
		
		stopTagging();
		
		divWidth = $('#delete_tag_menu').width();
		imgOffset = $('#tidypics_image').offset();
		imgWidth  = $('#tidypics_image').width();
		offsetX   = parseInt((imgWidth - divWidth)/2);
		
		_top = imgOffset.top + offsetY;
		_left = imgOffset.left + offsetX;

		$('#tidypics_delete_tag_menu').show().css({
			"top": _top + "px",
			"left": _left + "px"
		});
		
		$('#tidypics_image').hover(
			function(){
				$('.tidypics_tag').hide();
			},
			function(){
				$('.tidypics_tag').hide();
			}
		);
	}
	
	function hideDeleteMenu()
	{
		$('#tidypics_delete_tag_menu').hide();
		
		// restart tag hovering
		$('#tidypics_image').hover(
			function(){
				$('.tidypics_tag').show();
			},
			function(){
				$('.tidypics_tag').hide();
			}
		);
	}
</script>