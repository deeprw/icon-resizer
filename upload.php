<?php

$uploaddir = getcwd().DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR;
$uploadfile = $uploaddir.basename($_FILES['file']['name']);
move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
$filename = $_FILES['userfile']['name'];
//echo("$filename");


if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . 
	$_FILES['userfile']['name'])) {
	$exec = exec("./resizer.sh upload/".$filename);
	echo(" $exec ");
	$name = substr("$filename", 0, -4);
	echo("<a href='". $name .".zip'>Download</a>");
    print "File is valid, and was successfully uploaded.";    
} else {
    print "There some errors!";
}

?>