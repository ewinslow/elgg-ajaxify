<?php 

?>
<script type="text/javascript" src="<?php echo "{$vars['url']}_css/js.php?lastcache={$vars['config']->lastcache}&amp;js=ajaxify&amp;viewtype={$vars['view']}"; ?>"></script>
<script type="text/javascript">
/**
 * Don't want to cache these -- they could change for every request
 */
elgg.config.lastcache = <?php echo (int)$vars['config']->lastcache.''; ?>;

elgg.security.token.__elgg_ts = <?php echo $ts = time(); ?>;
elgg.security.token.__elgg_token = '<?php echo generate_action_token($ts); ?>';

elgg.page_owner_guid = <?php echo page_owner(); ?>;
</script>