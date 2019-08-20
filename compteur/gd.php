<html>
<head>
<title>Librairie GD et types d'images supportés</title>
<script language="javascript" type="text/javascript">
window.resizeTo(500,300);
//  
window.moveTo(200 , 200);
</script>
</head>
<body>
<?


if (strtolower(PHP_OS)=="linux") $dll="gd.so"; else $dll="php_gd2.dll";
if (!extension_loaded('gd'))   echo "Problème!<br>Librairie gd non disponible.<br>Sous système ".PHP_OS ." rajouter l'extension $dll";
else {
	echo "OK!<br>Librairie gd ($dll) disponible<br>";
	if (imagetypes() & IMG_PNG) echo "Type PNG supporté<br>"; else echo "Type PNG non supporté<br>";
	if (imagetypes() & IMG_JPG) echo "Type JPEG supporté<br>"; else echo "Type JPEG non supporté<br>";
	if (imagetypes() & IMG_GIF) echo "Type GIF supporté<br>"; else echo "Type GIF non supporté<br>";
	
}	
?>
</body>
</html>