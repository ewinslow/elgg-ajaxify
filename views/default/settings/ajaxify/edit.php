<p>
<?php 

	// set default value if user hasn't set it
	$param = $vars['entity']->param;
	if (!isset($param)) $param = 5;

	echo elgg_echo('ajaxify:param_label'); 
	
	echo elgg_view('input/pulldown', array(
			'internalname' => 'params[param]',
			'options' => array(1, 3, 5, 10, 15),
			'value' => $param
		));
?>
</p>