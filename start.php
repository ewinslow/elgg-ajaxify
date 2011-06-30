<?php

function ajaxify_init() {
	$cached_url = elgg_get_simplecache_url('js', 'ajaxify');
	elgg_register_js('elgg.ajaxify', $cached_url, 'footer');
	
	$cached_url = elgg_get_simplecache_url('js', 'likes_ajaxify');
	elgg_register_js('elgg.ajaxify.likes', $cached_url, 'footer');

	$cached_url = elgg_get_simplecache_url('js', 'comments_ajaxify');
	elgg_register_js('elgg.ajaxify.comments', $cached_url, 'footer');

	$cached_url = elgg_get_simplecache_url('js', 'search_ajaxify');
	elgg_register_js('elgg.ajaxify.search', $cached_url, 'footer');
	
	$cached_url = elgg_get_simplecache_url('js', 'messages_ajaxify');
	elgg_register_js('elgg.ajaxify.messages', $cached_url, 'footer');
	
	elgg_register_js('jquery.livequery', 'mod/elgg-ajaxify/vendors/livequery/jquery.livequery.js', 'footer');
	
	//Extend the default javascript views
	elgg_extend_view('js/thewire', 'js/thewire_ajaxify');

	//Override the default actions
	elgg_register_action('entity/delete', dirname(__FILE__) . "/actions/entities/delete.php");
	elgg_register_action('thewire/add', dirname(__FILE__) . "/actions/thewire/add.php");
	elgg_register_action('bookmarks/autofill', dirname(__FILE__) . "/actions/bookmarks/autofill.php");

	elgg_load_js('jquery.livequery');
	elgg_load_js('elgg.ajaxify');
	elgg_load_js('elgg.ajaxify.likes');
	elgg_load_js('elgg.ajaxify.comments');
	elgg_load_js('elgg.ajaxify.search');
	elgg_load_js('elgg.ajaxify.messages');
}

elgg_register_event_handler('init', 'system', 'ajaxify_init');
