<?php
if($_FILES['userfile']['size']>0) {
	echo'
		<script type="text/javascript">
		var elm=parent.window.document.getElementById("result");
		elm.innerHTML=elm.innerHTML+"<br />Получен файл '.$_FILES['userfile']['name'].' размером '.$_FILES['userfile']['size'].' байт";
		</script>
	';
}
?>
