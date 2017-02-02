<?php
/**
 * Display the latest photos uploaded by an individual
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$options = array(
    'type' => 'object',
    'subtype' => 'image',
    'limit' => $vars['entity']->num_display,
    'full_view' => false,
    'list_type' => 'gallery',
    'list_type_toggle' => false,
    'gallery_class' => 'tidypics-gallery-widget',
);

if(!elgg_in_context("index")){
    if(elgg_in_context("profile")){
        $options['owner_guid'] = elgg_get_page_owner_guid();
        
    } else {
        $dbprefix = elgg_get_config("dbprefix");
        if(elgg_get_page_owner_guid()){
            $options['joins'] = array("JOIN " . $dbprefix . "entities album ON e.container_guid = album.guid");
            $options['wheres'] = array("album.container_guid = " . elgg_get_page_owner_guid());
        }
    }
}

echo elgg_list_entities($options);

