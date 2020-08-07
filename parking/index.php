<html>
<!--[if lte IE 9]>
    <script type="text/javascript"> 
        window.location = "html/auxiliar/precursorbrowser.html";
    </script>
    <?php
        // Si no hay Javascript
        if (preg_match("/MSIE/",$_SERVER['HTTP_USER_AGENT'])) header("Location: html/auxiliar/precursorbrowser.html");
    ?>
<![endif]-->
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="rgba(0,0,0,1)"> <!-- Para teñir el encabezado y barra de búsqueda en android -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link id="favicon" rel="shortcut icon" href="parking/img/icons/favicon.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="parking/css/unconnoencon.css">
    <link rel="stylesheet" type="text/css" href="parking/css/imprimir.css" media="print">
    <title>Charcutería C&amp;C</title>
    <script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-106300288-1', 'auto');
		ga('send', 'pageview');
	</script>
</head>
<body style="height: 100%; width: 100% ; margin: 0px 0px;" scroll=no>
	<?php
		require_once "parking/uncon.html";
	?>
</body>
</html>

