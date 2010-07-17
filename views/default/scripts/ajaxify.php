<?php 
/**
 * 
 */

?>
<script type="text/javascript" src="<?php echo "{$vars['url']}_css/js.php?js=ajaxify&amp;viewtype=default&amp;lastcache={$vars['config']->lastcache}"; ?>"></script>
<script type="text/javascript">
/**
 * Don't want to cache these -- they could change for every request
 */
elgg.config.lastcache = <?php echo (int)$vars['config']->lastcache.''; ?>;

elgg.security.token.__elgg_ts = <?php echo $ts = time(); ?>;
elgg.security.token.__elgg_token = '<?php echo generate_action_token($ts); ?>';

elgg.page_owner_guid = <?php echo page_owner(); ?>;
</script>