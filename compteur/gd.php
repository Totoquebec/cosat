<html>
<head>
<title>Librairie GD et types d'images support�s</title>
<script language="javascript" type="text/javascript">
window.resizeTo(500,300);
//  
window.moveTo(200 , 200);
</script>
</head>
<body>
<?


if (strtolower(PHP_OS)=="linux") $dll="gd.so"; else $dll="php_gd2.dll";
if (!extension_loaded('gd'))   echo "Probl�me!<br>Librairie gd non disponible.<br>Sous syst�me ".PHP_OS ." rajouter l'extension $dll";
else {
	echo "OK!<br>Librairie gd ($dll) disponible<br>";
	if (imagetypes() & IMG_PNG) echo "Type PNG support�<br>"; else echo "Type PNG non support�<br>";
	if (imagetypes() & IMG_JPG) echo "Type JPEG support�<br>"; else echo "Type JPEG non support�<br>";
	if (imagetypes() & IMG_GIF) echo "Type GIF support�<br>"; else echo "Type GIF non support�<br>";
	
}	
?>
</body>
</html>