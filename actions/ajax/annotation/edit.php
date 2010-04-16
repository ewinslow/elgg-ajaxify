<?php
/**
 * CourseWare edit annotation value action
 *
 * @package ElggCoreExtensions
 */

// Make sure we can get the annotation in question
$annotation_id = (int) get_input('annotation_id');
$annotation = get_annotation($annotation_id);
if (!$annotation || !$annotation->canEdit()) {
	header("HTTP/1.1 400 Bad Request");
	exit("You do not have permission to edit this annotation");
}

$property = get_input('property');
$value = get_input('value');

$annotation->$property = $value;
if($annotation->save()) {
	echo "Your changes have been saved";
} else {
	header("HTTP/1.1 400 Bad Request");
	echo "There was a problem saving your changes";
}

exit;