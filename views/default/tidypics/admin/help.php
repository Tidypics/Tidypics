<br />
<h3>White screen when uploading images</h3>
<p>
Tidypics tries to calculate the maximum size of an image that your server will support. If it
guesses incorrectly and someone uploads a photo that is too large, the script may crash when
resizing the image if you are using GD. The easiest way to test this is to set display_errors
to 1 in your .htaccess file and upload large images. If this causes a problem, a php memory error
should display on the screen. You can increased your php memory limit (see the docs directory).
A better option is to use ImageMagick if your server supports it (again see the docs directory).
</p><p>
If it is not a memory issue, you should see some other error appear. Once you have fixed the error,
change display_error back to 0.  
</p>
<h3>Question mark images appear</h3>
<p>
If you see question mark images when you look at your albums, this means the resizing of the images
failed. This could be due to the memory limits as described above. There are other causes. Tidypics
tries to detect these problems and write the cause to the error log. You should check your server
error log right after an upload that results in a question mark for these error messages. The messages
will begin with "Tidypics warning:". It is possible if you have turned off php warnings that you will 
not see these warnings.
</p><p>
Another possible cause is using ImageMagick when your server does not support it or specifying
the wrong path to the ImageMagick executables.
</p>