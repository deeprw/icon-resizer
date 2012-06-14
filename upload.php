<?php

	define("MAX_IMAGE_SIZE", 1024 * 1024);
	define("IMAGE_DEFINITION", 512);

	define("UPLOAD_DIRECTORY", "upload");
	define("TEMPORARY_DIRECTORY", "tmp");

	class ValidationException extends RuntimeException { }

	function slugify($text) {
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

	try {
		$image = $_FILES['userfile'];

		if (!validateImageSize($image))
			throw new ValidationException("Invalid image size!");
		if (!validateImageType($image))
			throw new ValidationException("Invalid image type!");
		if (!validateImageDefinition($image))
			throw new ValidationException("Invalid image definition!");

		if (!createDirectory(UPLOAD_DIRECTORY))
			throw new RuntimeException("Couldn't create upload directory!");
		if (!createDirectory(TEMPORARY_DIRECTORY))
			throw new RuntimeException("Couldn't create temporary directory!");

		$uploadpath = UPLOAD_DIRECTORY . DIRECTORY_SEPARATOR . uniqid();
		while (file_exists($uploadpath))
			$uploadpath = UPLOAD_DIRECTORY . DIRECTORY_SEPARATOR . uniqid();

		if (!mkdir($uploadpath))
			throw new RuntimeException("Couldn't create directory for uploaded image!");

		$imagename = slugify(basename($image['name'], ".png"));

		$imagepath = $uploadpath . DIRECTORY_SEPARATOR . $imagename . ".png";
		$archivepath = $uploadpath . DIRECTORY_SEPARATOR . $imagename . ".zip";

		if (!move_uploaded_file($image['tmp_name'], $imagepath))
			throw new RuntimeException("Couldn't move uploaded image!");

		if (exec("./resizer.sh " . $imagepath . " " . $archivepath))
			throw new RuntimeException("Couldn't resize image!");

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
	}
	catch (Exception $e) {
		echo("
			<div id='error'>
				<br>" . $e->getMessage() . "<br>
				<div id='tryagain' onClick=window.location='index.php'>
						<font>try again</font>
				</div>
			</div>"
		);
	}
?>