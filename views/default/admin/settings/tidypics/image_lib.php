<?php
/**
 * Tidypics image library tools
 */

$content = '<p>' . elgg_echo('tidypics:lib_tools:overview') . '</p>';
$content .= '<p>' . elgg_echo('tidypics:lib_tools:testing') . '</p>';
$content .= '<p><label>' . elgg_echo('tidypics:settings:im_path');
$content .= elgg_view('input/text', array(
	'name' => 'im_location'
));
$content .= elgg_view('input/submit', array(
	'value' => elgg_echo('submit'),
	'id' => 'tidypics-im-test'
));	
$content .= '</p>';
$content .= '<p id="tidypics-im-results"></p>';

echo elgg_view_module('inline', elgg_echo('tidypics:lib_tools'), $content);

?>
<script type="text/javascript">
	$(function() {
		$('#tidypics-im-test').click(function() {
			var loc = $('input[name=im_location]').val();
			$("#tidypics-im-results").html("");
			$.ajax({
				type: "GET",
				url: elgg.normalize_url('mod/tidypics/actions/photos/admin/imtest.php'),
				data: {location: loc},
				cache: false,
				success: function(html){
					$("#tidypics-im-results").html(html);
				}
			});
		});
	});
</script>
