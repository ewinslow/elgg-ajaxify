<?php

$object = $params['entity'];

if (elgg_is_logged_in() && !elgg_in_context('widgets') && elgg_is_active_plugin('likes')) {
	$menu = new EvanMenu($return);
	
	if ($object->canAnnotate(0, 'likes')) {
		$hasLiked = elgg_annotation_exists($object->guid, 'likes');
		
		// Always register both. That makes it super easy to toggle with javascript
		$menu->registerItem('like', array(
			'href' => elgg_add_action_tokens_to_url("/action/likes/add?guid={$object->guid}"),
			'text' => elgg_view_icon('thumbs-up'),
			'title' => elgg_echo('likes:likethis'),
			'item_class' => $hasLiked ? 'hidden' : '',
		));
		$menu->registerItem('unlike', array(
			'href' => elgg_add_action_tokens_to_url("/action/likes/delete?guid={$object->guid}"),
			'text' => elgg_view_icon('thumbs-up-alt'),
			'title' => elgg_echo('likes:remove'),
			'item_class' => $hasLiked ? '' : 'hidden',
		));
	}

	$count = elgg_view('likes/count', array('entity' => $object));

	if ($count) {
		$menu->registerItem('likes_count', array(
			'href' => false,
			'priority' => 1001,
			'text' => $count,
			'title' => elgg_echo('likes:see'),
		));
	}

	return $menu->getItems();
}

return NULL;