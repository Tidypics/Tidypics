<?php
/**
 * Tidypics Help
 *
 * @todo This would be hard to localize cleanly.
 */

$title = 'White screen when uploading images';

$body = <<<HTML
<p>
Tidypics tries to calculate the maximum size of an image that your server will support. If it
guesses incorrectly and someone uploads a photo that is too large, the script may crash when
resizing the image if you are using GD. The easiest way to test this is to set display_errors
to 1 in your .htaccess file and upload large images. If this causes a problem, a php memory error
should display on the screen. You can increased your php memory limit (see the docs directory).
A better option is to use ImageMagick if your server supports it (again see the docs directory).
</p>
<p>
If it is not a memory issue, you should see some other error appear. Once you have fixed the error,
change display_error back to 0.
</p>
HTML;

echo elgg_view_module('inline', $title, $body);

$title = 'Question mark images appear';
$body =<<<HTML
<p>
If you see question mark images when you look at your albums, this means the resizing of the images
failed. This could be due to the memory limits as described above. There are other causes. Tidypics
tries to detect these problems and write the cause to the error log. You should check your server
error log right after an upload that results in a question mark for these error messages. The messages
will begin with "Tidypics warning:". It is possible if you have turned off php warnings that you will
not see these warnings.
</p>
<p>
Another possible cause is using ImageMagick when your server does not support it or specifying
the wrong path to the ImageMagick executables.
</p>
HTML;

echo elgg_view_module('inline', $title, $body);


$title = 'Unable to save settings';
$body =<<<HTML
<p>If you are unable to settings, there are two possible causes. First,
Apache can be configured to block pages that use file paths as Tidypics
does when setting the location of the ImageMagick executable. In this case,
leave that field blank. Second, there is some bad code in the Izaps video
plugin that can prevent the settings from being saved. Try disabling that plugin.
</p>
HTML;

echo elgg_view_module('inline', $title, $body);

