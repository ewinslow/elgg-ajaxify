<?php
$name = $vars['internalname'];
$value = $vars['value'];
$checked = $vars['checked'] ? 'checked' : '';
$id = $vars['internalid'];
$label = $vars['label'];

echo <<<CHECKBOX
<input type="checkbox" id="$id" name="$name" value="$value" $checked />
<label for="$id">$label</label>
CHECKBOX;
