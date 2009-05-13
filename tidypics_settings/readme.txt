What is this?
=============================
tidypics_settings is a plugin


What does it do?
=============================
It allows you to override settings in tidypics like the size of images or whether images
can be downloaded or not. By changing those settings in this plugin and NOT in the 
tidypics plugin, you can upgrade to new versions without worrying about losing your
custom settings. 


How do I install it?
=============================
1. Copy the tidypics_settings directory to your Elgg mod directory. You should now have 
a directory path like this: /mod/tidypics_settings

2. Under that directory, you should have 2 files: this readme and a start.php file. Edit
this start.php file to change any settings that you want to change (uncomment the setting
and then change its value).

3. Confirm that this plugin appears below tidypics on the plugin list in Tools Administration.
It does not have to be directly below. Just as long as it is loaded afterwards.

4. Enable the plugin under Tools Administration in your Elgg install. If you get a misconfigured
plugin error message, you've done something dumb. 
