<?php
/**
 * View for serving entities via AJAX
 *
 */
//Incomplete
if (elgg_is_xhr()) {
	$subtype = get_input('subtype');
	$guid =  (int) get_input('guid');
	$limit =  (int) get_input('limit');
	$entities = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => $subtype,
		'limit' => $limit,
		'guid' => $guid,
		'pagination' => FALSE
	));
	echo $entities;
}
?>
