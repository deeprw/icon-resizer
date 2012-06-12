$(document).ready(function() {
   
    // Обрабатываем событие после выбора фаила
   // $("#file").live("click", function(){
        var file = event.dataTransfer.files[0];
      	var filen = 0;
      	var filen = file;
        if (file == " ") {
        
        	alert(file);
        }else {
        	    // Создаем запрос
        var xhr = new XMLHttpRequest()
        xhr.upload.addEventListener('progress', uploadProgress, false);
        xhr.onreadystatechange = stateChange;
        xhr.open('POST', 'upload.php', true);
        //xhr.setRequestHeader('X-FILE-NAME', file.name);     
        var fd = new FormData;
		fd.append("userfile", file);
		xhr.send(fd);
		
		    function stateChange(event) {
        if (event.target.readyState == 4) {
            if (event.target.status == 200) {
				dropZone.text('Ready');
				//var fName = parseInt("data", 1);			
				//
	     		var my_image = xhr.responseText;
	     		document.getElementById('dropZone').innerHTML = my_image;
	     		/*
				fName = document.getElementById("image").innerHTML
	     		$('#dropZone').fadeIn(300).css("background-image", "url(" + fName + ")");
				
*/
				
            } else {
                dropZone.text('Error');
                dropZone.addClass('error');
            }
        }
    }
        }
   // });
    });