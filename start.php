<?php

function ajaxify_init() {
	elgg_register_js('ajaxify', 'mod/ajaxify/js/ajaxify.js', 'footer');

	elgg_register_action('entity/delete', dirname(__FILE__) . "/actions/entities/delete.php");
}

elgg_register_event_handler('init', 'system', 'ajaxify_init');
