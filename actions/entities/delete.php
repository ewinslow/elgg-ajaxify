<?php
/**
 * Default entity delete action
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 */

$guid = get_input('guid');
$entity = get_entity($guid);
$type = $entity->getSubType();
if (($entity) && ($entity->canEdit())) {
	if ($entity->delete()) {
		system_message(sprintf(elgg_echo('entity:delete:success'), $type));
	} else {
		register_error(sprintf(elgg_echo('entity:delete:fail'), $type));
	}
} else {
	register_error(sprintf(elgg_echo('entity:delete:fail'), $type));
}

forward($_SERVER['HTTP_REFERER']);
