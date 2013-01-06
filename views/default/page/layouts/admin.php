<?php
elgg_load_js('require');
elgg_load_js('angular');

/**
 * Elgg Admin Area Canvas
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['content'] Content string
 * @uses $vars['sidebar'] Optional sidebar content
 * @uses $vars['title']   Title string
 */

?>

<div class="elgg-layout elgg-layout-one-sidebar">
	<div class="elgg-sidebar clearfix">
		<?php
			echo elgg_view('admin/sidebar', $vars);
		?>
	</div>
	<div class="elgg-main elgg-body">
		<div class="elgg-head">
		<?php
			echo elgg_view_menu('title', array(
				'sort_by' => 'priority',
				'class' => 'elgg-menu-hz',
			));

		?>
			<h2 data-ng-bind="elggPage.title">
				<?php echo $vars['title']; ?>
			</h2>
		</div>
		<div data-ng-view>
		<?php
			if (isset($vars['content'])) {
				echo $vars['content'];
			}
		?>
		</div>
	</div>
</div>
