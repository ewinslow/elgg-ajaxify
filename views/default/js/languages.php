<?php
/**
 * @uses $vars['language']
 */
global $CONFIG;

$language = $vars['language'];
$json = addslashes(json_encode($CONFIG->translations[$language]));

echo "elgg.config.translations.$language = $.parseJSON('$json');";
