<?php
$ts = time();
$token = generate_action_token($ts);

header('Content-type: application/json');
echo Zend_Json::encode(array('__elgg_ts' => $ts, '__elgg_token' => $token));
exit;