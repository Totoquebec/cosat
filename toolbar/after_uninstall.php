<?php

if( @$_GET['lang'] == "en" ){
$title = "Cosat Toolbar";
$desc = "<p align='center'>
	<font face='Times New Roman' size='4'>
	Removal Operation of Cosat Toolbar complete successfully.</font></p>
	<p align='center'>&nbsp;</p><p align='center'>
	<font face='Times New Roman' size='4'>Denis Technicien from Cosat</font>
	</p>";

}
else{
$title = "Barre outils Cosat";
$desc = "<p align='center'>
	<font face='Times New Roman' size='4'>Désinstallation de la Barre d'outils Cosat c'est terminée avec Succès.</font>
	</p>
	<p align='center'></p><p align='center'>
	<font face='Times New Roman' size='4'>Denis Technicien de chez Cosat</font>
	</p>";
}
?>
<html>

<head>
<meta http-equiv="Content-Language" content="fr-ca">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title><?=$title?></title>
</head>

<body>
	<p align="center">
		<img src="../images/logocosat.jpg" border='0' width='300' height='230' name="Logo Cosat" alt="Logo Cosat"/>
	</p>
	<?=$desc?>
</body>

</html>