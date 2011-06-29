<?php
//Incomplete
$annotation_id = (int) get_input('annotation_id');
$limit = (int) get_input('limit');
$annotation_name = get_input('annotation_name');
$guid = (int) get_input('guid');
$order = get_input('order', 'desc');
$offset = (int) get_input('offset', 0);

$options = array(
	'limit' => $limit,
	'guid' => $guid,
	'annotation_name' => $annotation_name,
	'annotation_id' => $annotation_id,
	'order_by' => "n_table.time_created $order",
	'offset' => $offset,
);

echo elgg_list_annotations($options);
?>
