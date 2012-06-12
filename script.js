$(document).ready(function() {
    
    var dropZone = $('#dropZone'),
        maxFileSize = 1000000; // максимальный размер фалйа - 1 мб.
    
    // Проверка поддержки браузером
   /*
 if (typeof(window.FileReader) == 'undefined') {
        dropZone.text('Не поддерживается браузером!');
        dropZone.addClass('error');
    }
*/
    
    // Добавляем класс hover при наведении
    dropZone[0].ondragover = function() {
        dropZone.addClass('hover');
        return false;
    };
    
    // Убираем класс hover
    dropZone[0].ondragleave = function() {
        dropZone.removeClass('hover');
        return false;
    };
    
    
    // Обрабатываем событие Drop
    dropZone[0].ondrop = function(event) {
        event.preventDefault();
        dropZone.removeClass('hover');
        dropZone.addClass('drop');
        
        var file = event.dataTransfer.files[0];
        
        
        // Проверяем размер файла
        if (file.size > maxFileSize) {
            dropZone.text('Файл слишком большой!');
            dropZone.addClass('error');
            
            return false;
        }
     //alert(file.width+'x'+file.height);
        // Создаем запрос
        var xhr = new XMLHttpRequest()
        xhr.upload.addEventListener('progress', uploadProgress, false);
        xhr.onreadystatechange = stateChange;
        xhr.open('POST', 'upload.php', true);
        xhr.setRequestHeader('X-FILE-NAME', file.name);     
        var fd = new FormData;
		fd.append("userfile", file);
		xhr.send(fd);

 
    // Показываем процент загрузки
    function uploadProgress(event) {
        var percent = parseInt(event.loaded / event.total * 100);
        $('#content').text('Resize: ' + percent + '%');
    }
   ;
    // Пост обрабочик
    function stateChange(event) {
        if (event.target.readyState == 4) {
            if (event.target.status == 200) {
				//dropZone.text(' ');
				//var fName = parseInt("data", 1);			
				//
	     		var my_image = xhr.responseText;
	     		document.getElementById('download_text').innerHTML = my_image;
	     		fName = document.getElementById("image").innerHTML
	     		$('#content').fadeOut(500);
	     		$('#iconz').fadeIn(500).css("background-image", "url(" + fName + ")");
				
				
            } else {
                dropZone.text('Error');
                dropZone.addClass('error');
            }
        }
    }
    
    };
   
});