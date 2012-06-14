<?php
	define("MAX_IMAGE_SIZE", 1024 * 1024);
	define("IMAGE_DEFINITION", 512);
	
	define("UPLOAD_DIRECTORY", "upload");
	define("TEMPORARY_DIRECTORY", "tmp");
	
	function error($message) {
		echo("
			<div id='error'>
				<br>" . $message . "<br>
				<div id='tryagain' onClick=window.location='index.php'>
						<font>try again</font>
				</div>
			</div>"
		);
		exit();
	}
	
	function slugify($text)
	{
		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
		
		$text = trim($text, '-');
		
		if (function_exists('iconv')) 
			$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		
		$text = strtolower($text);
		
		$text = preg_replace('~[^-\w]+~', '', $text);
		
		if (empty($text))
			return 'n-a';
		
		return $text;
	}
	
	function createDirectory($path) {
		return file_exists($path) || mkdir($path);
	}

	function validateImageSize($image) {
		return $image['size'] <= MAX_IMAGE_SIZE;
	}
	
	function validateImageType($image) {
		$info = getimagesize($image['tmp_name']);
		return $info[2] == IMAGETYPE_PNG;
	}
	
	function validateImageDefinition($image) {
		$info = getimagesize($image['tmp_name']);
		return $info[0] == IMAGE_DEFINITION && $info[1] = IMAGE_DEFINITION;
	}
	
	$image = $_FILES['userfile'];
	
	if (!validateImageSize($image))
		error("Invalid image size");
	if (!validateImageType($image))
		error("Invalid image type");
	if (!validateImageDefinition($image))
		error("Invalid image definition");
	
	if (!createDirectory(UPLOAD_DIRECTORY))
		error("Internal error, code = 0x01");
	if (!createDirectory(TEMPORARY_DIRECTORY))
		error("Internal error, code = 0x02");
	
	$uploadpath = UPLOAD_DIRECTORY . DIRECTORY_SEPARATOR . uniqid();
	while (file_exists($uploadpath))
		$uploadpath = UPLOAD_DIRECTORY . DIRECTORY_SEPARATOR . uniqid();
		
	if (!mkdir($uploadpath))
		error("Internal error, code = 0x03");
	
	$imagename = slugify(basename($image['name'], ".png"));
	
	$imagepath = $uploadpath . DIRECTORY_SEPARATOR . $imagename . ".png";
	$archivepath = $uploadpath . DIRECTORY_SEPARATOR . $imagename . ".zip";
	
	if (!move_uploaded_file($image['tmp_name'], $imagepath))
		error("Internal error, code = 0x04");
	
	if (exec("./resizer.sh " . $imagepath . " " . $archivepath))
		error("Internal error, code = 0x05");
	
	echo("
		<div id='image'>
			$imagepath
		</div>
		<div id='download' onClick=window.location='$archivepath'>
					<font>Ready! Download ZIP</font>
		</div>
		<div id='tryagain' onClick=window.location='index.php'>
					<font>Resize other icon</font>
		</div>"
	);
?>