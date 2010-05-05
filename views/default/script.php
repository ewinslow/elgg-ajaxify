<?php
/**
 * @uses $vars['js']
 */

if(isset($vars['src'])) {
	$src = $vars['src'];
} else {
	$base = $vars['url'];
	$lastcache = $vars['config']->lastcache;
	$view = $vars['js'];
	$viewtype = $vars['view'];
	
	$src = "{$base}_css/$view.$viewtype.$lastcache.js";
}

echo "<script type=\"text/javascript\" src=\"$src\"></script>";