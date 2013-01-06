<?php

echo json_encode(array(
	'title' => $vars['title'],
	'body' => json_decode($vars['body']),
));
