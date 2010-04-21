<?php
/**
 * $Id$
 */

function ajaxify_init()
{
	global $CONFIG;
    elgg_extend_view('metatags', 'ajaxify/metatags');
    
	register_action('ajax/securitytoken', false, $CONFIG->pluginspath."ajaxify/actions/ajax/securitytoken.php" );
	
	return true;
}

register_elgg_event_handler('init', 'system', 'ajaxify_init');
