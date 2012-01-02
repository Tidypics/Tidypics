<?php
/**
 * Photo tagging JavaScript
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

?>

elgg.provide('elgg.tidypics.tagging');

elgg.tidypics.tagging.init = function() {
	$('[rel=photo-tagging]').click(elgg.tidypics.tagging.start);

	$('#tidypics-tagging-quit').click(elgg.tidypics.tagging.stop);
}

/**
 * Start a tagging session
 */
elgg.tidypics.tagging.start = function(event) {

	$('.tidypics-photo').imgAreaSelect({
		disable      : false,
		hide         : false,
		classPrefix  : 'tidypics-tagging',
		onSelectEnd  : elgg.tidypics.tagging.startSelect,
		onSelectStart: function() {
			$('#tidypics-tagging-select').hide();
		}
	});

	$('.tidypics-photo').css({"cursor" : "crosshair"});

	$('#tidypics-tagging-help').toggle();

	event.preventDefault();
}

/**
 * Stop tagging
 *
 * A tagging session could be completed or the user could have quit.
 */
elgg.tidypics.tagging.stop = function(event) {
	$('#tidypics-tagging-help').toggle();
	$('#tidypics-tagging-select').hide();

	$('.tidypics-photo').imgAreaSelect({hide: true, disable: true});
	$('.tidypics-photo').css({"cursor" : "pointer"});

	event.preventDefault();
}

/**
 * Start the selection stage of tagging
 */
elgg.tidypics.tagging.startSelect = function(img, selection) {

	var coords  = '"x1":"' + selection.x1 + '",';
	coords += '"y1":"' + selection.y1 + '",';
	coords += '"width":"' + selection.width + '",';
	coords += '"height":"' + selection.height + '"';
	$("input[name=coordinates]").val(coords);

	$('#tidypics-tagging-select').show().css({
		'top' : selection.y2 + 10,
		'left' : selection.x2
	});
}

elgg.register_hook_handler('init', 'system', elgg.tidypics.tagging.init);
