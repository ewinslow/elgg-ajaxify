<?php

function ajaxify_init() {
	elgg_register_js('ajaxify', 'mod/ajaxify/js/ajaxify.js', 'footer');
	elgg_register_js('require', '/mod/ajaxify/vendors/requirejs-1.0.7/require.min.js', 'footer');
	elgg_load_js('require');

	elgg_register_action('entity/delete', dirname(__FILE__) . "/actions/entities/delete.php");

	if (elgg_in_context('admin')) {
		elgg_extend_view('page/elements/foot', 'requirejs/config/admin');
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
}

elgg_register_event_handler('init', 'system', 'ajaxify_init');
