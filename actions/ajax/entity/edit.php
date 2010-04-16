<?php
/**
 * Modify one property of an entity via ajax
 * 
 */

$guid = get_input('guid');
$entity = get_entity($guid);

if($entity && $entity->canEdit()) { //proceed
	$property = get_input('property');
	$value = get_input('value');
	$entity->$property = $value;
	if($entity->save()) { //try to save
		//silent success
	} else { //give up
		header('HTTP/1.1 500 Internal Server Error'); 
		echo "We're sorry, we could not complete your request!";
	}
} else { //reject
	header('HTTP/1.1 400 Bad Request');
	if($entity) { //not allowed to edit
		echo "You do not have permission to edit that ".elgg_echo($entity->getSubtype());
	} else { //bad guid
		echo "We could not find the object specified";
	}
}

exit;