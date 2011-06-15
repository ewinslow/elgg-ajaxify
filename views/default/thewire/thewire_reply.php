<?php
/**
 * Wire add form body for replying via xhr
 *
 * @uses $vars['guid']
 * @todo eliminate the need for this file
 */

gatekeeper();
elgg_load_js('elgg.thewire');

$post = get_entity(get_input('guid'));

$content = elgg_view_form('thewire/add', array(), array('post' => $post));
$content .= elgg_view('input/urlshortener');
echo "$content<br /><br />";
