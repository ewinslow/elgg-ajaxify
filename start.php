<?php

function ajaxify_init() {
	$cached_url = elgg_get_simplecache_url('js', 'ajaxify');
	elgg_register_js('elgg.ajaxify', $cached_url, 'footer');

	elgg_register_action('entity/delete', dirname(__FILE__) . "/actions/entities/delete.php");
	elgg_register_action('bookmarks/autofill', dirname(__FILE__) . "/actions/bookmarks/autofill.php");
	elgg_load_js('elgg.ajaxify');
}

elgg_register_event_handler('init', 'system', 'ajaxify_init');
