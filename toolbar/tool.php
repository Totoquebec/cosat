<?php

if( @$_GET['lang'] == "en" ){
$title = "Cosat Toolbar";
$desc = '		<p align="center"><font face="Times New Roman" size="4">Toolbar designed </font></p>
		<p align="center"><font face="Times New Roman" size="4">By 
		Jean-Alexandre</font></p>
		<p align="center"><font face="Times New Roman" size="4">Of Cosat</font></p>';
}
else{
$title = "Barre outils Cosat";
$desc = '		<p align="center"><font face="Times New Roman" size="4">Barre outils 
		conçus</font></p>
		<p align="center"><font face="Times New Roman" size="4">par 
		Jean-Alexandre</font></p>
		<p align="center"><font face="Times New Roman" size="4">de Cosat</font></p>';

}
?>
<html>

<head>
<meta http-equiv="Content-Language" content="fr-ca">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title><?=$title?></title>
</head>

<body>

<table border="0" cellpadding="0" cellspacing="0" width="157" height="64">
	<!-- MSTableType="nolayout" -->
	<tr>
		<td valign="top" height="64" width="157">
		<!-- MSCellType="ContentBody" -->
		<p align="center">
			<img src="../images/logocosat.jpg" border='0' width='300' height='230' name="Logo Cosat" alt="Logo Cosat"/>
		</p>
		<?=$desc?>
&nbsp;</td>
	</tr>
</table>

</body>

</html>