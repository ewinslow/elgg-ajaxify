<?php

$prefix = elgg_normalize_url('/admin');

$href = elgg_normalize_url($vars['href']);

$isAdminUrl = strpos($href, $prefix) === 0;

// Forces angular
if (!$isAdminUrl && elgg_in_context('admin') && !isset($vars['target']) ) {
	$vars['target'] = '_self';
}

