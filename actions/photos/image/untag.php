<?php
/**
 * Remove photo tag action
 */

$annotation = elgg_get_annotation_from_id(get_input('annotation_id'));

if (!$annotation instanceof ElggAnnotation || $annotation->name != 'phototag') {
	register_error(elgg_echo("tidypics:phototagging:delete:error"));
	forward(REFERER);
}

if (!$annotation->canEdit()) {
	register_error(elgg_echo("tidypics:phototagging:delete:error"));
	forward(REFERER);
}

$entity_guid = $annotation->entity_guid;
$tag = unserialize($annotation->value);

if ($annotation->delete()) {
	if ($tag->type == 'user') {
		remove_entity_relationship($tag->value, 'phototag', $entity_guid);
	}
	system_message(elgg_echo("tidypics:phototagging:delete:success"));
} else {
	system_message(elgg_echo("tidypics:phototagging:delete:error"));
}

forward(REFERER);
