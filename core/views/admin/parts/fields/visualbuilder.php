<?php
$attributes['name'] = $field_name;
$attributes['value'] = $field_value;
$attributes['class'] = 'width-100 visualbuilder'.($field['mandatory']?' mandatory':'');
//$attributes['id'] = 'textarea_'.$field_name;
//echo $p_start.$label.form_textarea($attributes).$additionaldesc.$p_end; ?>
<div class="builder-container">
	<div class="builder-help"><?php echo $additionaldesc; ?></div>
  <div class="builder-wrapper"><?php echo form_textarea($attributes); ?></div>
</div>
  <link rel="stylesheet" href="/editor/sir-trevor-icons.css" type="text/css" media="screen" title="no title" charset="utf-8">
  <link rel="stylesheet" href="/editor/sir-trevor.css" type="text/css" media="screen" title="no title" charset="utf-8">
  <script src="/editor/underscore.js" type="text/javascript" charset="utf-8"></script>
  <script src="/editor/eventable.js" type="text/javascript" charset="utf-8"></script>

  <script src="/editor/sir-trevor.js" type="text/javascript" charset="utf-8"></script>
  <script src="/editor/locales/ru.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript" charset="utf-8">
    $(function(){
      SirTrevor.LANGUAGE = "ru";
      window.editor = new SirTrevor.Editor({
        el: $('.visualbuilder'),
        blockTypes: [
          "Embedly",
          "Text",
          "List",
          "Quote",
          "Image",
          "Video",
          "Tweet"
        ]
      });

      $('form').bind('submit', function(){
//        return false;
      });

    });
  </script>
