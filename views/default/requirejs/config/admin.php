<?php
if (!elgg_in_context('admin')) {
    return true;
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

require.config({
	paths: {
		'text': '/mod/ajaxify/vendors/requirejs-1.0.7/text.min',
		'elgg/ajaxify/admin': '/mod/ajaxify/js/ajaxify/admin'
	},
	urlArgs: 'bust=' + (+new Date())
});

require(['elgg/ajaxify/admin'], function() {});

</script>