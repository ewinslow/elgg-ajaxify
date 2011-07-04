<?php
/**
 * View for serving entities via AJAX
 *
 */
//Incomplete
if (elgg_is_xhr()) {
	$subtype = get_input('subtype');
	$guid = get_input('guid');
	$limit =  get_input('limit');
	$pagination = (boolean) get_input('pagination', FALSE);
	$offset = get_input('offset');
	$page_type = get_input('page_type');

	switch ($page_type) {
		case 'friends': 
			$entities = list_user_friends_objects(elgg_get_logged_in_user_guid(), $subtype, $limit);
			break;
		case 'owner':
			$owner_guid = elgg_get_logged_in_user_guid();
		default:
			$options = array(
				'type' => 'object',
				'subtype' => $subtype,
				'limit' => $limit,
				'guid' => $guid,
				'owner_guid' => $owner_guid,
				'pagination' => $pagination,
				'offset' => $offset,
			);
			$entities = elgg_list_entities($options);
			break;
	}
	echo $entities;
}
?>
