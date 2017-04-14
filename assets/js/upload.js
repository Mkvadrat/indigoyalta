$(function(){
	
	var dropbox = $('.dropbox'),
		message = $('.upload-message', dropbox);
	
	dropbox.filedrop({
		paramname:'attachments',
		maxfiles: 25,
   	maxfilesize: 5,
		url: '/request/attachments.php',
		fallback_id: 'upload_button',
		uploadFinished:function(i,file,response){
            var img = $.data(file).find('img');
            if ($(img).length>0)
                $(img).attr('src', $(img).parent().attr('rel'));
			$.data(file).addClass('done');
		},
		
    	error: function(err, file) {
			switch(err) {
				case 'BrowserNotSupported':
					showMessage('Ваш браузер не поддерживает HTML5 загрузку файлов');
					break;
				case 'TooManyFiles':
					alert('Загружено максимальное количество файлов');
					break;
				case 'FileTooLarge':
					alert(file.name+' превышает максимально допустимый размер');
					break;
				default:
					break;
			}
		},
		
		// Called before each upload is started
		beforeEach: function(file){
			if(!file.type.match(/^image\//)){
				alert('Разрешаются только изображения');
				return false;
			}
		},
		
		uploadStarted:function(i, file, len){
			console.log(file);
			//createImage(file);
            createLoad(file);
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
					'<input type="hidden" value="" name="attachments[]"></div>';

    var load_template = '<div class="preview load-preview">'+
        '<span class="imageHolder">'+
        '<div class="load-preview-loader"><img /></div>'+
        '<span class="uploaded"></span>'+
        '</span>'+
        '<div class="progressHolder">'+
        '<div class="progress"></div>'+
        '</div>'+
        '<input type="hidden" value="" name="attachments[]"></div>';

    function createImage(file){
		var preview = $(template), 
			image = $('img', preview), input = $('input', preview);
			
		var reader = new FileReader();
		
		image.width = 100;
		image.height = 100;
		
		reader.onload = function(e){
			image.attr('src',e.target.result);
			input.val(file.name);
		};
		
		reader.readAsDataURL(file);
		
		message.hide();
		preview.appendTo(dropbox);
		$.data(file,preview);
	}

    function createLoad(file){

        var preview = $(load_template),
            loader = $('.load-preview-loader', preview),
            image = $('img', preview), input = $('input', preview);

        var reader = new FileReader();

        image.width = 100;
        image.height = 100;

        reader.onload = function(e){
            loader.attr('rel',e.target.result);
            input.val(file.name);
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