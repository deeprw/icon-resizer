<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<? 
if (isset($_POST['name'])) {$name = $_POST['name'];}
if (isset($_POST['email'])) {$email = $_POST['email'];}
if (isset($_POST['text_message'])) {$text_message = $_POST['text_message'];}

$name = stripslashes($name);
$name = htmlspecialchars($name);
$email = stripslashes($email);
$email = htmlspecialchars($email);
$text_message = stripslashes($text_message);
$text_message = htmlspecialchars($text_message);

$address = "deeprw@gmail.com";
$message = ""."\nName: ".$name."\nEmail: ".$email."\nMessage: ".$text_message."";
$subject = "IconResizer";
$from .= 'From: IconResizer' . "\r\n";
$verify = mail($address,$subject,$message,$from,"Content-type:text/plain; Charset=UTF-8\r\n");

if ($verify == 'true'){
	echo "Thank you, it is important to us that you wrote to us!";
}
else {
	echo "Error";
}
?>