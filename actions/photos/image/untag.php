<?php
/**
 * Remove photo tag action
 */

$annotation = get_annotation(get_input('annotation_id'));

if (!$annotation instanceof ElggAnnotation || $annotation->name != 'phototag') {
	register_error(elgg_echo("tidypics:phototagging:delete:error"));
	forward(REFERER);
}

if (!$annotation->canEdit()) {
	register_error(elgg_echo("tidypics:phototagging:delete:error"));
	forward(REFERER);
}

if ($annotation->delete()) {
	system_message(elgg_echo("tidypics:phototagging:delete:success"));
} else {
	system_message(elgg_echo("tidypics:phototagging:delete:error"));
}

forward(REFERER);
