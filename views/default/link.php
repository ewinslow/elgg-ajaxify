<?php
$rel = $vars['rel'];
$type = $vars['type'];
$href = $vars['href'];

$link = <<<LINK

<link href="$href" rel="$rel" type="$type" />

LINK;
echo $link;