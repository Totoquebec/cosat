<?php
/* Fichier : PageRien.php
* Description : Affiche rien
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
*/

?>
<?php
// Début de la session
include("sessionsave.inc");
// l'usager est-il autorisé
if( @$auth != "yes") {
	header( "Location: login.php");
   	exit();
}
?>

<html>
<head>
<title>Page des Clients</title>
</head>
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
   	<td colspan="3" bgcolor="#0DC4C4" align="center">
      	<font color="white" size="+10">
         <b>En Construction</b></fonr>
      </td>
   	<td align="center" valign="top">
      </td>
   </tr>
</table>
</body>
</html>
