<?php
/**
 * $Id$
 */

function ajaxify_init()
{
	global $CONFIG;
    elgg_extend_view('metatags', 'ajaxify/metatags');
    
	register_action("ajax/annotation/delete", false, $CONFIG->pluginspath.'ajaxify/actions/ajax/annotation/delete.php');
	register_action("ajax/annotation/edit", false, $CONFIG->pluginspath.'ajaxify/actions/ajax/annotation/edit.php');
	
	register_action("ajax/entity/delete", false, $CONFIG->pluginspath.'ajaxify/actions/ajax/entity/delete.php');
	register_action("ajax/entity/edit", false, $CONFIG->pluginspath.'ajaxify/actions/ajax/entity/edit.php');
	
	register_action('ajax/securitytoken', false, $CONFIG->pluginspath."ajaxify/actions/ajax/securitytoken.php" );
	
	return true;
}

register_elgg_event_handler('init', 'system', 'ajaxify_init');
