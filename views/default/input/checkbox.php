<?php
$name = $vars['internalname'];
$value = $vars['value'];
$checked = $vars['checked'] ? 'checked' : '';
$id = $vars['internalid'];

echo <<<CHECKBOX
<input type="checkbox" id="$id" name="$name" value="$value" $checked />
CHECKBOX;
