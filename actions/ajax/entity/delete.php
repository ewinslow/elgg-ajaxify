<?php
/**
 * Default ajax entity delete action
 *
 * @package Ajaxify
 * @author Evan Winslow
 */

$guid = get_input('guid');
$entity = get_entity($guid);

if (($entity) && ($entity->canEdit())) {
	if ($entity->delete()) {
		echo sprintf(elgg_echo('entity:delete:success'), $guid);
	} else {
		header("HTTP/1.1 400 Bad Request");
		echo sprintf(elgg_echo('entity:delete:fail'), $guid);
	}
} else {
	header("HTTP/1.1 400 Bad Request");
	echo sprintf(elgg_echo('entity:delete:fail'), $guid);
}

exit;