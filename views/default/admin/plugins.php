<?php
/**
 * Elgg administration plugin main screen
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 */

global $CONFIG;

$ts = time();
$token = generate_action_token($ts);

?>

<form action="/action/ajaxify/plugins/save" method="post">
	<?php echo elgg_view('input/securitytoken'); ?>
	<div class="contentWrapper">
		<span class="contentIntro">
			<?php 
				echo elgg_view('input/button', array('value' => elgg_echo('enableall')));
				echo elgg_view('input/button', array('value' => elgg_echo('disableall')));
				echo elgg_view('input/submit', array('value' => elgg_echo('save')));
				echo elgg_view('output/longtext', array('value' => elgg_echo('admin:plugins:description'))); 
			?>
			<div class="clearfloat"></div>
		</span>
	</div>
	<?php
		// Get the installed plugins
		$installed_plugins = $vars['installed_plugins'];
		$count = count($installed_plugins);
		
		$plugin_list = get_plugin_list();
		$max = 0;
		foreach($plugin_list as $key => $foo) {
			if ($key > $max) $max = $key;
		}
		
		// Display list of plugins
		$n = 0;
		foreach ($installed_plugins as $plugin => $data) {
			//if (($n>=$offset) && ($n < $offset+$limit))
				echo elgg_view("admin/plugins_opt/plugin", array('plugin' => $plugin, 'details' => $data, 'maxorder' => $max, 'order' => array_search($plugin, $plugin_list)));
		
			$n++;
		}
	?>
</form>