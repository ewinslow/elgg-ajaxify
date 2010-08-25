<?php
/**
 * $Id: start.php 40 2010-04-30 04:13:47Z evan.b.winslow $
 */

/**
 * Initialize the ajaxify plugin
 */
function ajaxify_init()
{
    elgg_extend_view('metatags', 'scripts/ajaxify');
    elgg_extend_view('js/initialise_elgg', 'js/ajaxify');
    
	register_action('ajax/securitytoken', false, dirname(__FILE__)."/actions/ajax/securitytoken.php" );
	register_action('entity/delete', false, dirname(__FILE__)."/actions/entities/delete.php");
	
	elgg_view_register_simplecache('js/ajaxify');
	elgg_view_register_simplecache('js/languages/en');
		
	register_plugin_hook('action', 'all', 'ajaxify_action_hook');
	register_plugin_hook('forward', 'system', 'ajaxify_forward_hook');
}


/**
 * Checks whether the request was requested via ajax
 */
function ajaxify_is_xhr() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
		&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'; 
}


/**
 * Catch calls to forward() in ajax request and force an exit.
 * 
 * Forces response is json of the following form:
 * <pre>
 * {
 *     "current_url": "the.url.we/were/coming/from",
 *     "forward_url": "the.url.we/were/going/to",
 *     "system_messages": {
 *         "messages": ["msg1", "msg2", ...],
 *         "errors": ["err1", "err2", ...]
 *     },
 *     "status": -1 //or 0 for success if there are no error messages present
 * }
 * </pre>
 * where "system_messages" is all message registers at the point of forwarding
 */
function ajaxify_forward_hook($hook, $type, $location, $params)
{
	if (ajaxify_is_xhr()) {
		//grab any data echo'd in the action
		$output = ob_get_clean();
		
		//Avoid double-encoding in case data is json
		$json = json_decode($output);
		if (isset($json)) {
			$params['output'] = $json;
		} else {
			$params['output'] = $output;
		}
		
		//flush and return system messages register
		$params['system_messages'] = system_messages(NULL, "");
		
		if (isset($params['system_messages']['errors'])) {
			$params['status'] = -1;
		} else {
			$params['status'] = 0;
		}
		
		header("Content-type: application/json");
		echo json_encode($params);
		exit;
	}
}

/**
 * Buffer all output echo'd in the action for inclusion in the returned JSON.
 */
function ajaxify_action_hook() {
	if (ajaxify_is_xhr()) {
		ob_start();
	}
}


register_elgg_event_handler('init', 'system', 'ajaxify_init');