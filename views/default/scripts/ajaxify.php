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
elgg.config.lastcache = <?php echo (int)($vars['config']->lastcache); ?>;

elgg.security.token.__elgg_ts = <?php echo $ts = time(); ?>;
elgg.security.token.__elgg_token = '<?php echo generate_action_token($ts); ?>';

<?php
$page_owner = page_owner_entity();

if ($page_owner instanceof ElggEntity) {
	$page_owner_json = array();
	foreach ($page_owner->getExportableValues() as $v) {
		$page_owner_json[$v] = $page_owner->$v;
	}
	
	$page_owner_json['subtype'] = $page_owner->getSubtype();
	$page_owner_json['url'] = $page_owner->getURL();
	
	echo 'elgg.page_owner =  '.json_encode($page_owner_json); 
}
?>;
</script>