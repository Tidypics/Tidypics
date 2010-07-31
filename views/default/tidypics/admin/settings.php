<?php

echo elgg_view('output/longtext', array('value' => elgg_echo("tidypics:admin:instructions")));

?>
<p>
<?php
echo elgg_view('tidypics/admin/upgrade');

global $CONFIG;
$url = $CONFIG->wwwroot . 'mod/tidypics/pages/server_analysis.php';
$text = elgg_echo('tidypics:settings:server:analysis');

echo "<a href=\"$url\">$text</a>";
?>
</p>
<?php

echo elgg_view("tidypics/forms/settings");
