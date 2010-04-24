<?php

$language = get_input('language');
global $CONFIG;

header("Content-Type: application/json");
echo json_encode($CONFIG->translations[$language]);
