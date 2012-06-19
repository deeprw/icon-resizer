$(function() {
	$.ajax_upload($('#uploadButton'), {
		action : 'upload.php',
		name : 'image',
		onSubmit : function(file, ext) {
			$("#uploadButton font").text('Please wait, I resize your icon');
			this.disable();
		},
		onComplete : function(file, responseText) {
			$("#uploadButton font").text('Or select a file on your computer');
			this.enable();

			response = JSON.parse(responseText);

			if (response.status == "success") {
				$('#dropZone').addClass('drop');
				$('#content').fadeOut(500);
				$('#iconz').fadeIn(500).css("background-image", "url(" + response.imageUrl + ")");

				$('<div id="download" onClick="window.location=\'' + response.archiveUrl + '\'"></div>')
					.append($('<font>Ready! Download ZIP</font>'))
					.appendTo("#download_text");

				$('<div id="tryagain" onClick="window.location=\'index.php\'"></div>')
					.append($('<font>Resize other icon</font>'))
					.appendTo("#download_text");
			}
			else {
				$("#content").hide();
				$('<div id="error"></div>')
					.append($('<br/>'))
					.append(response.message)
					.append($('<br/>'))
					.append(
						$('<div id="tryagain" onClick="window.location=\'index.php\'"></div>')
							.append($('<font>Try again</font>'))
					).appendTo("#download_text");
			}
		}
	});
});