<?php
/**
 * CourseWare delete annotation action
 *
 * @package ElggCoreExtensions
 */

// Make sure we can get the annotation in question
$annotation_id = (int) get_input('annotation_id');
$annotation = get_annotation($annotation_id);
if (!$annotation) {
	header("HTTP/1.1 400 Bad Request");
	echo "We could not find the specified annotation";
	exit;
}

if ($annotation->delete()) {
	echo elgg_echo("generic_comment:deleted");
} else {
	header("HTTP/1.1 400 Bad Request");
	echo elgg_echo("generic_comment:notdeleted");
}

exit;