<?php
/**
 * Elgg plugin manifest class
 *
 * This file renders a plugin for the admin screen, including active/deactive, manifest details & display plugin
 * settings.
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 */

$plugin = $vars['plugin'];
$details = $vars['details'];

$active = $details['active'];
$manifest = $details['manifest'];

// Check elgg version if available
$version_check_valid = false;
if ($manifest['elgg_version']) {
	$version_check_valid = check_plugin_compatibility($manifest['elgg_version']);
}

$ts = time();
$token = generate_action_token($ts);
?>
<div class="plugin_details <?php if ($active) echo "active"; else echo "not-active" ?>">
	<div class="drag"></div>
	<div class="admin_plugin_enable_disable">
		<?php if ($active) { ?>
			<a href="<?php echo $vars['url']; ?>action/admin/plugins/disable?plugin=<?php echo $plugin; ?>&__elgg_token=<?php echo $token; ?>&__elgg_ts=<?php echo $ts; ?>"><?php echo elgg_echo("disable"); ?></a>
		<?php } else { ?>
			<a href="<?php echo $vars['url']; ?>action/admin/plugins/enable?plugin=<?php echo $plugin; ?>&__elgg_token=<?php echo $token; ?>&__elgg_ts=<?php echo $ts; ?>"><?php echo elgg_echo("enable"); ?></a>
		<?php } ?>
	</div>

	<h3><?php echo $plugin; ?><?php if (elgg_view("settings/{$plugin}/edit")) { ?> <a class="pluginsettings_link">[<?php echo elgg_echo('settings'); ?>]</a><?php } ?></h3>
	<?php
		if ($manifest) {
	?>
		<div class="plugin_description"><?php echo elgg_view('output/longtext',array('value' => $manifest['description'])); ?></div>
	<?php
		}
	?>

	<p><a class="manifest_details"><?php echo elgg_echo("admin:plugins:label:moreinfo"); ?></a></p>
	
	<?php if (elgg_view("settings/{$plugin}/edit")) { ?>
	<div class="pluginsettings">
		<div id="<?php echo $plugin; ?>_settings">
			<?php echo elgg_view("object/plugin", array('plugin' => $plugin, 'entity' => find_plugin_settings($plugin))) ?>
		</div>
	</div>
	<?php } ?>

	<div class="manifest_file">
	<?php if ($manifest) { ?>
		<?php if ((!$version_check_valid) || (!isset($manifest['elgg_version']))) { ?>
		<div id="version_check">
			<?php
				if (!isset($manifest['elgg_version']))
					echo elgg_echo('admin:plugins:warning:elggversionunknown');
				else
					echo elgg_echo('admin:plugins:warning:elggtoolow');
			?>
		</div>
		<?php } ?>
		<div><?php echo elgg_echo('admin:plugins:label:version') . ": ". $manifest['version'] ?></div>
		<div><?php echo elgg_echo('admin:plugins:label:author') . ": ". $manifest['author'] ?></div>
		<div><?php echo elgg_echo('admin:plugins:label:copyright') . ": ". $manifest['copyright'] ?></div>
		<div><?php echo elgg_echo('admin:plugins:label:licence') . ": ". $manifest['licence'] . $manifest['license'] ?></div>
		<div><?php echo elgg_echo('admin:plugins:label:website') . ": "; ?><a href="<?php echo $manifest['website']; ?>"><?php echo $manifest['website']; ?></a></div>
	<?php } ?>
	</div>
</div>