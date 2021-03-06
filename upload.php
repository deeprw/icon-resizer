<?php

	class ValidationException extends RuntimeException { }

	function joinPath($firstPart, $secondPart) {
		return $firstPart . DIRECTORY_SEPARATOR . $secondPart;
	}

	function createDirectory($path) {
		return file_exists($path) || mkdir($path);
	}

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

	define("MAX_IMAGE_SIZE", 1024 * 1024);
	define("IMAGE_DEFINITION", 512);

	define("UPLOAD_DIRECTORY", joinPath(getcwd(), "upload"));
	define("TEMPORARY_DIRECTORY", joinPath(getcwd(), "tmp"));

	define("UPLOAD_URL", "upload");

	try {
		$image = $_FILES['image'];

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

		$directoryName = uniqid();
		while (file_exists(joinPath(UPLOAD_DIRECTORY, $directoryName)))
			$directoryName = uniqid();

		if (!mkdir(joinPath(UPLOAD_DIRECTORY, $directoryName)))
			throw new RuntimeException("Couldn't create directory for uploaded image!");
		if (!mkdir(joinPath(TEMPORARY_DIRECTORY, $directoryName)))
			throw new RuntimeException("Couldn't create temporary directory for image processing!");

		$imageBasename = slugify(basename($image['name'], ".png"));

		$imageRelativePath = joinPath($directoryName, $imageBasename . ".png");
		$archiveRelativePath = joinPath($directoryName, $imageBasename . ".zip");

		if (!move_uploaded_file($image['tmp_name'], joinPath(UPLOAD_DIRECTORY, $imageRelativePath)))
			throw new RuntimeException("Couldn't move uploaded image!");

		if (exec("sh resizer.sh " . joinPath(UPLOAD_DIRECTORY, $imageRelativePath) . " " . joinPath(UPLOAD_DIRECTORY, $archiveRelativePath) . " " . joinPath(TEMPORARY_DIRECTORY, $directoryName)))
			throw new RuntimeException("Couldn't resize image!");

		$response = json_encode(
			array(
				"status" => "success",
				"imageUrl" => joinPath(UPLOAD_URL, $imageRelativePath),
				"archiveUrl" => joinPath(UPLOAD_URL, $archiveRelativePath)
			)
		);
	}
	catch (Exception $e) {
		$response = json_encode(
			array(
				"status" => "failure",
				"message" => $e->getMessage()
			)
		);
	}

	echo($response)

?>
