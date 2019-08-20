<?php
/* Fichier : bye.php
 * Description : Fin d'une opération
 * Auteur : Denis Léveillé 	 		  Date : 2004-01-01
 */
// Début de la session
include("sessionsave.inc");

// **** Choix de la langue de travail ****
switch( @$_SESSION['SLangue'] ) {
	case "ENGLISH" : 	include("varmessen.inc");
							break;
	case "SPANISH" : 	include("varmesssp.inc");
							break;
	default : 		  	include("varmessfr.inc");

} // switch SLangue


include("varcie.inc");

?>

<html>
<head>
	<meta http-equiv="Page-Enter" content="revealTrans(Duration=1.5,Transition=12)">
	<title><?php echo $TabMessGen[9] ?></title>
</head>
<SCRIPT language=JavaScript1.2 src='javafich/disablekeys.js'></SCRIPT>
<body bgcolor="#C0C0FF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="center" valign="top">
				<img src="gifs/logoantillas.gif" alt="Courrier">
				<p style="margin-top: 5pt">
					<img src="gifs/groscourrier.gif" alt="Le Courrier" height="139" width="191">
					<p><h2><B><?php echo $TabMessGen[10] ?></B></h2><br>
					<div align="center"><font size="-1">
					<?php echo $TabMessGen[1] ?>
					<a href="mailto:<?php echo hexentities($AdrWebmestre) ?>?subject=Page Web <?php echo $NomCie ?>"><?php echo $TabMessGen[2] ?></a>
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
<SCRIPT LANGUAGE='javascript'>

addKeyEvent();

</SCRIPT>
<SCRIPT language=JavaScript1.2 src='javafich/blokclick.js'></SCRIPT>

</body>
</html>
