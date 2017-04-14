<?php

$attributes['name'] = $field_name;
$attributes['value'] = $field_value;
$attributes['class'] = 'width-100 code'.($field['mandatory']?' mandatory':'');
$attributes['id'] = 'texteditor_'.$field_name;
echo $p_start.$label.form_textarea($attributes).$additionaldesc.$p_end;

//$js_onload.= "fastcms.tab_textarea('#".$attributes['id']."');";
