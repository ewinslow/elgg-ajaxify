<?php
if (!elgg_in_context('admin')) {
    return true;
}

global $AJAXIFY;

$config = array(
    'baseUrl' => '/ajax/view/js',
    'paths' => array(),
);

foreach ($AJAXIFY->modules as $module) {
    $config['paths'][$module] = substr(elgg_get_simplecache_url('js', $module), 0, -3);
}

?>

<script>
/**
 * Defines some modules to be reused so they can be refactored transparently later on.
 */

define('jquery', function() { return jQuery; });
define('elgg', function() { return elgg; });
define('elgg/ElggEntity', function() { return elgg.ElggEntity; });
define('elgg/ElggUser', function() { return elgg.ElggUser; });
define('elgg/ElggPriorityList', function() { return elgg.ElggPriorityList; });
define('elgg/i18n', function() { return elgg.echo; });
define('elgg/ui', function() { return elgg.ui; });
define('elgg/ui/widgets', function() { return elgg.ui.widgets; });
define('angular', function() { return angular; });
define('angular/module/ngResource', function() { return angular; });
define('angular/module/ngSanitize', function() { return angular; });

requirejs.config(<?php echo json_encode($config); ?>);

require(['angular', 'angular/module/elggAdmin'], function(angular) {
	angular.bootstrap(document, ['elggAdmin']);
});

</script>
