<?php
/**
 * Autofill actions for Elgg bookmark plugin
 *
 */

if (elgg_is_xhr()) {

	$uri = get_input('address');

	if ($uri && !preg_match("#^((ht|f)tps?:)?//#i", $uri)) {
		$uri = "http://$uri";
	}

	if ($uri && filter_var($uri, FILTER_VALIDATE_URL)) {
		// Close connection immediately
		$context = stream_context_create(array('http' => array('header' => 'Connection: close')));
		$page = file_get_contents($uri, false, $context);
		if ($page) {
			if (preg_match("#<title>(.*)</title>.*", $page, $content)) {
				echo json_encode(array("title" => "$content[1]", "description" => (("$content[2]"))));
			}
		} 
	}
}
