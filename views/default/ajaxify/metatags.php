<script type="text/javascript" src="<?php echo $vars['url'] ?>mod/ajaxify/js/elgglib.js"></script>
<script type="text/javascript" src="<?php echo $vars['url'] ?>mod/ajaxify/js/calendar.js"></script>
<script type="text/javascript" src="<?php echo $vars['url'] ?>mod/ajaxify/js/entities.js"></script>
<script type="text/javascript" src="<?php echo $vars['url'] ?>mod/ajaxify/js/objects.js"></script>
<script type="text/javascript" src="<?php echo $vars['url'] ?>mod/ajaxify/js/groups.js"></script>
<script type="text/javascript" src="<?php echo $vars['url'] ?>mod/ajaxify/js/objects.js"></script>
<script type="text/javascript" src="<?php echo $vars['url'] ?>mod/ajaxify/js/sites.js"></script>
<script type="text/javascript" src="<?php echo $vars['url'] ?>mod/ajaxify/js/users.js"></script>
<script type="text/javascript" src="<?php echo $vars['url'] ?>mod/ajaxify/js/server.js"></script>
<script type="text/javascript" src="<?php echo $vars['url'] ?>mod/ajaxify/js/languages.js"></script>
<script type="text/javascript" src="<?php echo $vars['url'] ?>mod/ajaxify/js/sessions.js"></script>
<script type="text/javascript">
elgg.config.wwwroot = '<?php echo $vars['config']->wwwroot; ?>';
elgg.config.lastcache = <?php echo $vars['config']->lastcache; ?>;
elgg.config.sitename = '<?php echo $vars['config']->sitename; ?>';

elgg.security.interval = 5 * 60 * 1000; //TODO make this configurable
elgg.security.token.__elgg_ts = <?php echo $ts = time(); ?>;
elgg.security.token.__elgg_token = '<?php echo generate_action_token($ts); ?>';

elgg.page_owner_guid = <?php echo page_owner(); ?>;

</script>