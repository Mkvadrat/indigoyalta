<?php

				echo $p_start.$label;
				$count = $field_value != '' ? count($field_value) : 0;

				//Multi upload on webkit+ff browsers
				$attributes['name'] = $field_name.'[]';
				$attributes['multiple'] = 'multiple';

				if ($count < $field['max']) { ?>
        
    <div class="dropbox dropbox_<?php echo $field_name; ?>">
      <span class="info-message">Перетащите сюда необходимые изображения<br /><i>(превью изображений будет доступно только для просмотра)</i></span>
    </div>
  
    <ul>
    </ul>
        
        
        
  <script src="/gui/corejs/repo/jquery.filedrop.js"></script>
  <script>
  
$(function(){
	
	var dropbox = $('.dropbox_<?php echo $field_name; ?>'),
		message = $('.info-message', dropbox);
	
	dropbox.filedrop({
		paramname:'<?php echo $field_name; ?>[]',
		maxfiles: 5,
   	maxfilesize: 2,
		url: admin_url+'contents/add_record_images/<?php echo $tipo['name'].($record->id?'/'.$record->id:'')?>',
		
		uploadFinished:function(i,file,response){
			$.data(file).addClass('done');
		},
		
    	error: function(err, file) {
			switch(err) {
				case 'BrowserNotSupported':
					showMessage('Your browser does not support HTML5 file uploads!');
					break;
				case 'TooManyFiles':
					alert('Too many files! Please select 5 at most! (configurable)');
					break;
				case 'FileTooLarge':
					alert(file.name+' is too large! Please upload files up to 2mb (configurable).');
					break;
				default:
					break;
			}
		},
		
		// Called before each upload is started
		beforeEach: function(file){
			if(!file.type.match(/^image\//)){
				alert('Only images are allowed!');
				return false;
			}
		},
		
		uploadStarted:function(i, file, len){
			createImage(file);
		},
		
		progressUpdated: function(i, file, progress) {
			$.data(file).find('.progress').width(progress);
		}
    	 
	});
	
	var template = '<div class="preview">'+
						'<span class="imageHolder">'+
							'<img />'+
							'<span class="uploaded"></span>'+
						'</span>'+
						'<div class="progressHolder">'+
							'<div class="progress"></div>'+
						'</div>'+
					'</div>'; 
	
	
	function createImage(file){

		var preview = $(template), 
			image = $('img', preview);
			
		var reader = new FileReader();
		
		image.width = 100;
		image.height = 100;
		
		reader.onload = function(e){
			image.attr('src',e.target.result);
		};
		
		reader.readAsDataURL(file);
		
		message.hide();
		preview.appendTo(dropbox);
		$.data(file,preview);
	}

	function showMessage(msg){
		fastnotify.success(msg);
	}

});  
  
  </script>

        <?php
				//	echo form_upload($attributes).br(1).$this->lang->_trans('Максимальное количество для загрузки - %n', array('n' => $field['max']));
					echo ' - загружено - '.$count;
				} else {
					echo '<span class="limit">Загружено максимальное количество изображений</span>';
			//		echo '<div class="hidden limit">'.br(1).form_upload($attributes).br(1).'('.$this->lang->_trans('You can attach up to %n images', array('n' => $field['max'])).')</div>';
				}
				if ($count && is_array($field_value)) {
					echo '<table cellpadding="0" cellspacing="0" width="100%" class="sortable cursor">'
						.'<thead><tr><th>Миниатюра</th><th>Оригинал</th><th>Ресайз</th><th>Тэг alt</th><th>Порядок сортировки</th><th></th></tr></thead><tbody>';
					;
					$tdnum = 1;
					foreach ($field_value as $image) {
						if (array_key_exists('thumbnail', $field['presets']))
						{
							$src = 'cache/' . $tipo['name'] . '/' . $field_name . '/' . $record->id . '/' . $field['presets']['thumbnail'] . '/' . $image->name;
						} else {
							$src = $image->thumb_path ? $image->thumb_path : $image->path;
						}
						echo '<tr><td><img src="'. attach_url($src) . '" alt="' . $image->alt_text . '" /></td>'
							.'<td><a target="_blank" href="'. attach_url($image->path) . '">просмотр</a><br />'.$image->width.' x '.$image->height.' px<br />'.$image->size.' Kb</td>'
							.'<td>'.($image->resized_path ? '<a target="_blank" href="'. attach_url($image->resized_path) . '">просмотр</a>':'').'</td>'
							.'<td><input name="_alt_text['.$image->id_document.']" type="text" class="text small" value="' . $image->alt_text . '" /></td>'
							.'<td><input class="tbl-priority text small" name="_priority['.$image->id_document.']" type="text" value="' . $image->priority . '" /></td>'
							.'<td class="delete"><img align="absmiddle" src="'.site_url(THEMESPATH.'admin/widgets/icns/delete.png').'" /> <a href="#" onclick="return fastcms.remove.document(this, '.$image->id_document.');">удалить</a></td>'
							."</tr>\n";
					$tdnum++;}
					echo '</tbody></table>';
				}
				echo $p_end;
