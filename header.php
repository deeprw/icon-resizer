<?php
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="css/style.css" />
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="js/ajaxupload.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/drop.js"></script>

	<title>Icon Resizer</title>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#wraper').fadeIn(1000);
			$('#dropZone').fadeIn(1000);
			$('#top').delay(1000).slideDown(1000);
			
			$("#top .content ul li").hover(
				function () {
					$(this).animate({ 
						marginTop: "-3"
						
					}, 300 );
				}, 
				function () {
					$(this).animate({ 
						marginTop: "0"
					}, 300 );		 
			})
		});
	</script>
</head>
<body>
	<div id="wraper">
		<div id="top">
			<div class="content">
				<div id="logo">
					<a href="index.php">Icon Resizer</a>
				</div>
				<ul>
					<li>
						<a class="menu" href="list.php">List</a>
					</li>
					<li>
						<a class="menu" href="about.php">About</a>
					</li>
				</ul>
			</div>
		</div>
