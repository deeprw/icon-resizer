<?php
	$size = getimagesize($_FILES['userfile']['tmp_name']);
	if ($size[2] != 3 || $size[0] != 512 || $size[1] != 512) {
		echo("
			<div id='error'>
				<br>Your picture not supported<br><br><p>Please used only *.PNG 512x512px</p>
			
				<div id='tryagain' onClick=window.location='index.php'>
						<font>try again</font>
				</div>
			</div>"
		);
	}
	else {	
		// print_r($size);
		$uploaddir = getcwd().DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR;
	
		$hash_file_name = md5(uniqid(rand(),1));
		$hash_file_name = substr("$hash_file_name", -5);
		$random_file_name = "IconResizer_".$hash_file_name."_";
		
		$uploadfile = $uploaddir.$random_file_name.basename($_FILES['userfile']['name']);
		
		move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
		
		$exec = exec("./resizer.sh ".$uploadfile);
	
		$file = $random_file_name.basename($_FILES['userfile']['name']);
		$name = substr("$file", 0, -4);
		
		$source_zip = "$name.zip";
		$dest_zip = "arch/zip/$source_zip";
		copy($source_zip, $dest_zip);
		unlink($source_zip);
		
		$source_png = "upload/$file";
		$dest_png = "arch/source/$file";
		copy($source_png, $dest_png);
		unlink($source_png);
		
		echo("<div id='image'>$dest_png</div><br><a href='". $dest_zip ."'>Download ZIP</a>");
	}
?>