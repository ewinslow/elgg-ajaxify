<?php

elgg_extend_view('page/elements/foot', 'requirejs/config/admin');
elgg_extend_view('css/admin', 'css/admin/ajaxify');

global $AJAXIFY;

$AJAXIFY = new stdClass();

$AJAXIFY->modules = array(
	'elgg/ajaxify',
	'elgg/ajaxify/admin',
	'elgg/ajaxify/likes',
	'angular/module/elggAdmin',
	'text',
);

if (elgg_is_admin_logged_in()) {
        $AJAXIFY->views = array(
                'admin/statistics/server',
                'admin/statistics/overview',
                'admin/settings/basic',
                'admin/settings/advanced',
                'admin/appearance/menu_items',
                'admin/appearance/profile_fields',
                'admin/appearance/default_widgets',
                'admin/appearance/customcss',
                'admin/appearance/customlogo',
                'admin/users/online',
                'admin/users/add',
                'admin/users/newest',
                'admin/develop_tools/unit_tests',
                'admin/develop_tools/preview',
                'admin/develop_tools/inspect',
                'admin/developers/settings',
                'admin/administer_utilities/logbrowser',
                'admin/administer_utilities/reportedcontent',
        );

        foreach ($AJAXIFY->views as $view) {
                // Every view is assumed to have a route definition that is a module
	        $AJAXIFY->modules[] = "angular/view/$view/route";

		// And a template, which we need to be able to fetch via ajax
		elgg_register_ajax_view("js/angular/view/$view/template.html");
        }
}

foreach ($AJAXIFY->modules as $module) {
	elgg_register_simplecache_view("js/$module");
	elgg_register_js($module, elgg_get_simplecache_url('js', $module), 'footer');
}

// Get your JS lib on!
elgg_register_js('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js');
elgg_register_js('jquery.form', '//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.09/jquery.form.js');
elgg_register_js('jquery-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js');
elgg_register_js('require', "//cdnjs.cloudflare.com/ajax/libs/require.js/2.0.6/require.min.js", 'head', 1);
elgg_register_js('pagedown', "//cdnjs.cloudflare.com/ajax/libs/pagedown/1.0/Markdown.Converter.js", 'footer');
elgg_register_js('moment', "//cdnjs.cloudflare.com/ajax/libs/moment.js/1.7.2/moment.min.js", 'footer');
elgg_register_js('angular', "//ajax.googleapis.com/ajax/libs/angularjs/1.0.2/angular.min.js", 'footer');
elgg_register_js('angular/module/ngResource', "//ajax.googleapis.com/ajax/libs/angularjs/1.0.2/angular-resource.min.js", 'footer');
elgg_register_js('angular/module/ngSanitize', "//ajax.googleapis.com/ajax/libs/angularjs/1.0.2/angular-sanitize.min.js", 'footer');

elgg_load_js('require');

elgg_register_action('entity/delete', dirname(__FILE__) . "/actions/entities/delete.php");

elgg_unregister_plugin_hook_handler('register', 'menu:river', 'likes_river_menu_setup');
elgg_unregister_plugin_hook_handler('register', 'menu:entity', 'likes_entity_menu_setup');


if (elgg_is_active_plugin('likes')) {
    elgg_load_js('elgg/ajaxify/likes');
}

if (elgg_is_admin_logged_in()) {
	$views = array(
		'admin/statistics/server',
		'admin/statistics/overview',
		'admin/settings/basic',
		'admin/settings/advanced',
		'admin/appearance/menu_items',
		'admin/appearance/profile_fields',
		'admin/appearance/default_widgets',
		'admin/appearance/customcss',
		'admin/appearance/customlogo',
		'admin/users/online',
		'admin/users/add',
		'admin/users/newest',
		'admin/develop_tools/unit_tests',
		'admin/develop_tools/preview',
		'admin/develop_tools/inspect',
		'admin/developers/settings',
		'admin/administer_utilities/logbrowser',
		'admin/administer_utilities/reportedcontent',
	);
	
	foreach ($views as $view) {
		elgg_register_ajax_view($view);
	}
}
