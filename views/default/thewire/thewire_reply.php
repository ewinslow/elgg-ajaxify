<?php
/**
 * Wire add form body for replying via xhr
 *
 * @uses $vars['guid']
 * @todo eliminate the need for this file
 */

gatekeeper();
elgg_load_js('elgg.thewire');

$guid = get_input('guid');

$post = get_entity($guid);

$content = elgg_view_form('thewire/add', array("id" => "thewire-form-reply-$guid"), array('post' => $post));
$content .= elgg_view('input/urlshortener');
echo "$content<br /><br />";
