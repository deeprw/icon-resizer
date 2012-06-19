<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="css/style.css" />

	<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="js/ajaxupload.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/drop.js"></script>

	<title>Icon resizer</title>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#wraper').fadeIn(1000);
			$('#dropZone').fadeIn(1000);
		});
	</script>
</head>
<body>
	<div id="wraper">
		<div id="d"></div>
		<div id="zone">
			<div id="dropZone">
				<div id="iconz"></div>
					<div id="content">
						Drag and Drop<br>
						Your icon
						<p>(png | 512x512)</p>

						<div id="buttonBox">
							<div id="uploadButton" class="button">
								<font>Or select a file on your computer</font>
							</div>
						</div>
					</div>
			</div>
		</div>
		<div id="download_text">
		</div>
	</div>



	<!-- Yandex.Metrika counter -->
<script type="text/javascript">
var yaParams = {/*Здесь параметры визита*/};
</script>

<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter13920376 = new Ya.Metrika({id:13920376, enableAll: true, trackHash:true, webvisor:true,params:window.yaParams||{ }});
        } catch(e) {}
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/13920376" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>


