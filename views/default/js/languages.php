<?php
/**
 * @uses $vars['language']
 */
global $CONFIG;

$language = $vars['language'];
$json = json_encode($CONFIG->translations[$language]);

header("Content-Type: application/x-javascript");
echo "elgg.config.translations.$language = $.parseJSON('$json');";
