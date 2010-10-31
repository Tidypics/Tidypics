<?php
/**
 * Album sorting view
 */

$album = $vars['album'];
$image_guids = $album->getImageList();

// create submission form
$body = elgg_view('input/hidden', array('internalname' => 'guids'));
$body .= elgg_view('input/hidden', array('internalname' => 'album_guid', 'value' => $album->guid));
$body .= elgg_view('input/submit', array('value' => elgg_echo('save')));
?>
<div class="contentWrapper">
	<div>
		<?php echo elgg_echo('tidypics:sort:instruct'); ?>
	</div>
	<?php
	$params = array(
		'internalid' => 'tidypics_sort_form',
		'action'     => "{$vars['url']}action/tidypics/sortalbum",
		'body'       => $body,
	);
	echo elgg_view('input/form', $params);
	?>

	<ul id="tidypics_album_sort">
		<?php
		foreach ($image_guids as $image_guid) {
			$image = get_entity($image_guid);
			$url = "{$vars['url']}pg/photos/thumbnail/$image_guid/small/";
			echo "<li id=\"$image_guid\"><img src=\"$url\" /></li>";
		}
		?>
	</ul>
	<div class="clearfloat"></div>
</div>

<script type="text/javascript">
$("#tidypics_album_sort").sortable(
	{
		opacity: 0.7,
		revert: true,
		scroll: true
	}
);
$('#tidypics_sort_form').submit(function() {
	var tidypics_guids = [];
	$("#tidypics_album_sort li").each(function(index) {
		tidypics_guids.push($(this).attr('id'));
	});
	$('input[name="guids"]').val(tidypics_guids.toString());
});
</script>