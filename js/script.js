$(document).ready(function() {

      var button = $('#uploadButton'), interval;

      $.ajax_upload(button, {
            action : 'upload.php',
            name : 'userfile',
            onSubmit : function(file, ext) {
              // показываем картинку загрузки файла
             // $("img#load").attr("src", "load.gif");
              $("#uploadButton font").text('Please wait, I resize your icon');

              /*
               * Выключаем кнопку на время загрузки файла
               */
              this.disable();

            },
            onComplete : function(file, dest_zip) {
              // убираем картинку загрузки файла
              //$("img#load").attr("src", "loadstop.gif");
              $("#uploadButton font").text('Or select a file on your computer');

              // снова включаем кнопку
              this.enable();

              // показываем что файл загружен
              
				$(dest_zip).appendTo("#download");
				$('#dropZone').text(' ');
				fName = document.getElementById("image").innerHTML
				$('#dropZone').addClass('drop');
				$('#dropZone').fadeIn(300).css("background-image", "url(" + fName + ")");
				
            }
          });
    });