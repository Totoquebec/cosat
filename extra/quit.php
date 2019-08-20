<?php
/* Fichier : quit.php
* Description : Fin d'une opération
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-27
*/
include('connect.inc');

echo "<?xml version='1.0' encoding='ISO-8859-1'?>";
?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Frameset//EN' 'http://www.w3.org/TR/html4/frameset.dtd'> 
<html>
<head>
<title>Fin opération</title>
<META HTTP-EQUIV="Window-target" CONTENT="_top">
</head>
<!-- script language='javascript1.2' src='javafich/disablekeys.js'></script>
<script language='javascript1.2' src='javafich/blokclick.js'></script>
<script language='JavaScript1.2'>addKeyEvent();</script -->
<body bgcolor="#C0C0FF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload='javascript:pageonload()'>
<base target='TOP'>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
   	<td align="center" valign="top">
      	<p style="margin-top: 5pt">
      	<p><h2><B>FIN DE L'OPÉRATION</B></h2><br>
		<div align="center"><font size="-1">
		<?php echo $TabMessGen[1] ?>
		<a href="mailto:<?php echo hexentities($AdrWebmestre) ?>?subject=Page Web <?php echo $NomCie ?>">
		<?php echo $TabMessGen[2] ?></a>
		</font></div>
		<p align="center" valign="bottom"><font size="1">
		<?php echo $TabMessGen[8] ?>		 
		<?php echo $TabMessGen[3] ?>		 
		<?php echo $NomCie ?>
		<?php echo $TabMessGen[4] ?>		  
		</p>
      </td>
   </tr>
</table>
<script language='javascript'>
 function pageonload() {
	close();	 
	 return;
 } // pageonload
</script>
</body>
</html>
