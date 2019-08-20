<?php
/* Fichier : bye.php
 * Description : Fin d'une opération
 * Auteur : Denis Léveillé 	 		  Date : 2004-01-01
 */
include('../lib/config.php');
/**
 * Delete cookies - the time must be in the past,
 * so just negate what you added when creating the
 * cookie.
 */

/*if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
   setcookie("cookname", "", time()-60*60*24*100, "/");
   setcookie("cookpass", "", time()-60*60*24*100, "/");
}*/
	/* Kill session variables */
	unset($_SESSION['username']);
	unset($_SESSION['password']);
	$_SESSION = array(); // reset session array
	session_destroy();   // destroy session.
	destroy( session_id());
	
	session_unset();
	session_regenerate_id(true);
	$_SESSION['NomLogin'] = "WEBUSER";
	session_name ( $_SESSION['NomLogin'] );
//	$_SESSION['NoContact'] = 0;
//	$_SESSION['Prio'] = 10;

/*	foreach($_COOKIE as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}*/

?>

<html>
<head>
	<meta http-equiv="Page-Enter" content="revealTrans(Duration=1.5,Transition=12)">
	<meta http-equiv="Content-Type" content="text/html; charset=charset=utf-8"/>
	<title><?php echo $TabMessGen[9] ?></title>
</head>
<script language='JavaScript1.2' src='js/disablekeys.js'></script>
<body bgcolor="#9a8bb4" >
	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="center" valign="top">
				<img src="gifs/logo.gif" width="186" height="160" alt="<?=@$param['nom_client'];?>">
				<p style="margin-top: 5pt">
					<img src="gifs/ordi.gif" alt="<?=@$param['nom_client'];?>" width="153" height="140" >
					<p><h2><B><?php echo $TabMessGen[10] ?></B></h2><br>
					<?php
						// **** Choix de la langue de travail ****
						switch( @$_SESSION['SLangue'] ) {
							case "ENGLISH" : 	echo "<a href='login.php?Lang=EN'>";
										break;
							default : 		 echo "<a href='login.php'>";
						
						} // switch SLangue
					?>
					
					<b><?php echo $TabMessGen[11] ?></b></a><br>
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

</body>
</html>
