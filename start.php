<?php
/**
 * $Id: start.php 40 2010-04-30 04:13:47Z evan.b.winslow $
 */

/**
 * Initialize the ajaxify plugin
 */
function ajaxify_init()
{
	global $CONFIG;
    elgg_extend_view('metatags', 'scripts/ajaxify');
    elgg_extend_view('css', 'ajaxify/admin/plugins/css');
    
	register_action('ajax/securitytoken', false, $CONFIG->pluginspath."ajaxify/actions/ajax/securitytoken.php" );
	
	register_action('entity/delete', false, $CONFIG->pluginspath.'ajaxify/actions/entities/delete.php');
	
	elgg_view_register_simplecache('js/ajaxify');
	elgg_view_register_simplecache('js/languages/en');
		
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
	if(ajaxify_is_xhr()) {
		header("Content-type: application/json");
		
		$params['system_messages'] = system_messages(NULL, "");
		if(isset($params['system_messages']['errors'])) {
			$params['status'] = -1;
		} else {
			$params['status'] = 0;
		}
		
		echo json_encode($params);
		
		return '';
	}
}


register_elgg_event_handler('init', 'system', 'ajaxify_init');