<?php 
/**
 * Initialise Elgg
 */

$lib_files = array(
	//core
	'elgglib.js',

	//libraries
	'security.js',
	'languages.js',
	'ajax.js',
	'session.js',

	//interfaces
	'calendar.js',
	
	//models
	'entities.js',
	'users.js',
	'groups.js',
	'objects.js',
	'sites.js',
	'annotations.js', 

	//ui
//	'ui.js',
//	'ui.widgets.js',
	'ui.plugins.js',
);

$lib_dir = "{$vars['config']->pluginspath}ajaxify/js/";

// Include them
foreach($lib_files as $file) {
	include($lib_dir . $file);
}

/**
 * Finally, set some values that are variable between installations
 * but (relatively) constant to an installation (therefore cacheable)
 */
?>

elgg.version = '<?php echo get_version(); ?>';
elgg.release = '<?php echo get_version(true); ?>';
elgg.config.wwwroot = '<?php echo $vars['config']->wwwroot; ?>';
elgg.security.interval = 5 * 60 * 1000; <?php //TODO make this configurable ?>
